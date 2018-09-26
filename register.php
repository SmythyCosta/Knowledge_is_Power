<?php
// Require the configuration before any PHP code as the configuration controls error reporting:
require('./includes/config.inc.php');

// Require the database connection:
require('./includes/mysql.inc.php');

// Include the header file:
$page_title = 'Register';
include('./includes/header.php');

// For storing registration errors:
$reg_errors = array();

// Check for a form submission:
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	// Check for a first name:
	// -----------
	// References:
	// https://makandracards.com/zeroglosa/8601-acentos-em-expressao-regular
	if (preg_match('/^[A-ZÀ-Ú \'.-]{2,45}$/i', $_POST['first_name'])) {
		$fn = escape_data($_POST['first_name'], $dbc);
	} else {
		$reg_errors['first_name'] = 'Por favor entre com seu primeiro nome!';
	}
	
	// Check for a last name:
	// -----------
	// References:
	// https://makandracards.com/zeroglosa/8601-acentos-em-expressao-regular
	if (preg_match('/^[A-ZÀ-Ú \'.-]{2,45}$/i', $_POST['last_name'])) {
		$ln = escape_data($_POST['last_name'], $dbc);
	} else {
		$reg_errors['last_name'] = 'Por favor insira seu sobrenome!';
	}
	
	// Check for a username:
	if (preg_match('/^[A-Z0-9]{2,45}$/i', $_POST['username'])) {
		$u = escape_data($_POST['username'], $dbc);
	} else {
		$reg_errors['username'] = 'Por favor, digite um nome desejado usando apenas letras e números!';
	}
	
	// Check for an email address:
	if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === $_POST['email']) {
		$e = escape_data($_POST['email'], $dbc);
	} else {
		$reg_errors['email'] = 'Por favor insira um endereço de e-mail válido!';
	}

	// Check for a password and match against the confirmed password:
	if (preg_match('/^(\w*(?=\w*\d)(?=\w*[a-z])(?=\w*[A-Z])\w*){6,}$/', $_POST['pass1']) ) {
		if ($_POST['pass1'] === $_POST['pass2']) {
			$p = $_POST['pass1'];
		} else {
			$reg_errors['pass2'] = 'Sua senha não corresponde à senha confirmada!';
		}
	} else {
		$reg_errors['pass1'] = 'Por favor coloque uma senha válida!';
	}
	
	if (empty($reg_errors)) { // If everything's OK...

		// Make sure the email address and username are available:
		$q = "SELECT email, username FROM users WHERE email='$e' OR username='$u'";
		$r = mysqli_query($dbc, $q);
	
		// Get the number of rows returned:
		$rows = mysqli_num_rows($r);
	
		if ($rows === 0) { // No problems!
			
			// Add the user to the database...
			
			// Include the password_compat library, if necessary:
			// include('./includes/lib/password.php');
			
			// Temporary: set expiration to a month!
			// Change after adding PayPal!
			// ---------------------------
			//$q = "INSERT INTO users (username, email, pass, first_name, last_name, date_expires) VALUES ('$u', '$e', '"  .  password_hash($p, PASSWORD_BCRYPT) .  "', '$fn', '$ln', ADDDATE(NOW(), INTERVAL 1 MONTH) )";
			
			// New query, updated in Chapter 6 for PayPal integration:
			// Sets expiration to yesterday:
			$q = "INSERT INTO users (username, email, pass, first_name, last_name, date_expires) VALUES ('$u', '$e', '"  .  password_hash($p, PASSWORD_BCRYPT) .  "', '$fn', '$ln', SUBDATE(NOW(), INTERVAL 1 DAY) )";

			$r = mysqli_query($dbc, $q);

			if (mysqli_affected_rows($dbc) === 1) { // If it ran OK.
	
				// Get the user ID:
				// Store the new user ID in the session:
				// Added in Chapter 6:
				$uid = mysqli_insert_id($dbc);
				//$_SESSION['reg_user_id']  = $uid;		

				// Display a thanks message...

				// Original message from Chapter 4:
				// echo '<div class="alert alert-success"><h3>Thanks!</h3><p>Thank you for registering! You may now log in and access the site\'s content.</p></div>';

				// Updated message in Chapter 6:
				echo '<div class="alert alert-success">
						<h3>Obrigado!</h3>
						<p>Obrigado por se registrar! Para concluir o processo, clique no botão abaixo para pagar pelo acesso ao seu site via PayPal. O custo é de 10 R$ por ano. <strong>Observação: quando você concluir seu pagamento no PayPal, clique no botão para retornar a este site.</strong>
						</p>
					</div>';

				// PayPal link added in Chapter 6:
				echo '<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
						<input type="hidden" name="cmd" value="_s-xclick">
						<input type="hidden" name="custom" value="' . $uid . '">
						<input type="hidden" name="email" value="' . $e . '">
						<input type="hidden" name="hosted_button_id" value="8YW8FZDELF296">
						<input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal - A maneira mais segura e fácil de pagar online!">
						<img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
					</form>';

				// Send email
                include"./libs/PHPMailer/PHPMailerAutoload.php";
				$body = "Obrigado por se registrar. ".APP_NAME.".\n\n";
                $Subject = "Confirmação de registro ".APP_NAME."";
                $Address = $_POST['email'];
                                
                include ('./includes/send_email.inc.php');
	
				// Finish the page:
				include('./includes/footer.php'); // Include the HTML footer.
				exit(); // Stop the page.
				
			} else { // If it did not run OK.
				trigger_error('Você não pôde ser registrado devido a um erro do sistema. Pedimos desculpas por qualquer inconveniente. Vamos corrigir o erro o mais rápido possível.');
			}
			
		} else { // The email address or username is not available.
			
			if ($rows === 2) { // Both are taken.
	
				$reg_errors['email'] = 'Este endereço de e-mail já foi registrado. Se você esqueceu sua senha, use o link à esquerda para mandar sua senha para você.';			
				$reg_errors['username'] = 'Este nome de usuário já foi registrado. Por favor tente outro.';			

			} else { // One or both may be taken.

				// Get row:
				$row = mysqli_fetch_array($r, MYSQLI_NUM);
						
				if( ($row[0] === $_POST['email']) && ($row[1] === $_POST['username'])) { // Both match.
					$reg_errors['email'] = 'Este endereço de e-mail já foi registrado. Se você esqueceu sua senha, use o link à esquerda para mandar sua senha para você.';	
					$reg_errors['username'] = 'Este nome de usuário já foi registrado com este endereço de e-mail. Se você esqueceu sua senha, use o link à esquerda para mandar sua senha para você.';
				} elseif ($row[0] === $_POST['email']) { // Email match.
					$reg_errors['email'] = 'Este endereço de e-mail já foi registrado. Se você esqueceu sua senha, use o link à esquerda para mandar sua senha para você.';						
				} elseif ($row[1] === $_POST['username']) { // Username match.
					$reg_errors['username'] = 'Este nome de usuário já foi registrado. Por favor tente outro.';			
				}
		
			} // End of $rows === 2 ELSE.
			
		} // End of $rows === 0 IF.
		
	} // End of empty($reg_errors) IF.

} // End of the main form submission conditional.

// Need the form functions script, which defines create_form_input():
// The file may already have been included by the header.
require_once('./includes/form_functions.inc.php');
?>

<h1>Register</h1>
<p>O acesso ao conteúdo do site está disponível para usuários registrados a um custo de R$ 10,00 (REAIS) por ano. Utilize o formulário abaixo para iniciar o processo de registro. <strong> Todos os campos são obrigatórios</strong>. Depois de preencher este formulário, você terá a oportunidade de pagar sua assinatura anual via <a href="http://www.paypal.com">PayPal</a> com segurança.</p>

<form action="register.php" method="post" accept-charset="utf-8">
	<?php 
	create_form_input('first_name', 'text', 'Primeiro nome', $reg_errors); 
	create_form_input('last_name', 'text', 'Sobrenome', $reg_errors); 
	create_form_input('username', 'text', 'Nome de usuário', $reg_errors); 
	echo '<span class="help-block">Apenas letras e números são permitidos.</span>';
	create_form_input('email', 'email', 'Email', $reg_errors); 
	create_form_input('pass1', 'password', 'Senha', $reg_errors);
	echo '<span class="help-block">Deve ter pelo menos 6 caracteres, com pelo menos uma letra minúscula, uma letra maiúscula e um número.</span>';
	create_form_input('pass2', 'password', 'Confirme a Senha', $reg_errors); 
	?>
	<input type="submit" name="submit_button" value="Avançar &rarr;" id="submit_button" class="btn btn-default" />
</form>
<br>

<?php // Include the HTML footer:
include('./includes/footer.php');
?>
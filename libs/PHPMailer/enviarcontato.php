
<?php

//$para = "contato@sl7.com.br";
//$titulo = "Contato do Site";

//$nome = $_REQUEST['nome'];
//$email = $_REQUEST['email'];

//$mensagem = $_REQUEST['mensagem'];

//	$corpo= "<strong>Mensagem de contato</strong><br><br>";
//	$corpo .="<strong>Nome:</strong> $nome";
//	$corpo .="<br><strong>E-mail:</strong> $email";
//	$corpo .="<br><strong>Assunto:</strong> $assunto";
//	$corpo .="<br><strong>Mensagem:</strong> $mensagem";

//	$header="From: $email Reply-to $email";
//	$header .= "Content-type: text/html; charset= utf-8";

//@mail($para,$titulo,$corpo,$header);

//header("location:contato.php?msg=enviado");


header('Content-Type: text/html; charset=UTF-8');
$reg_erros = array();

if (isset($_POST['envemail'])){

	$nome = $_POST["nome"];
	$email = $_POST["email"];
	$mensagem = $_POST["mensagem"];
	$assunto = utf8_decode($_POST['assunto']);

	// Check for name
	if (!preg_match('/^[A-Z \'.-]{2,60}$/i', $nome)){
		$reg_errors['nome'] = 'nome invalido!';
		echo '
		<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			Campo nome inválido
		</div>';
	}

	// Check for name
	if (!preg_match('/^[A-Z \'.-]{2,100}$/i', $assunto)){
		$reg_errors['assunto'] = 'assunto invalido!';
		echo '
		<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			Campo assunto inválido
		</div>';
	}


	// Check for an email address:
	if (!preg_match("/^[a-z0-9_\.\-]+@[a-z0-9_\.\-]+\.[a-z]{2,4}$/i", $email)) {
		$reg_errors['email'] = 'Digite um email válido!';
		echo '
		<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			Campo email inválido
		</div>';
	}

	// Check for an email address:
	if (empty($mensagem)) {
		$reg_errors['mensagem'] = 'Campo mensagem inválido!';
		echo '
		<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			Campo mensagem inválido
		</div>';
	}


	if (empty($reg_errors)){

		require_once("PHPMailerAutoload.php");

		$mail = new PHPMailer();
		$mail->isSMTP();
		$mail->Host = 'smtp.live.com';
		$mail->Port = 587;
		$mail->SMTPSecure = 'tls';
		$mail->SMTPAuth = true;
		$mail->Username = "smythy.costa@hotmail.com";
		$mail->Password = "vasco@123";




		$mail->setFrom("smythy.costa@hotmail.com", $assunto);
		$mail->addAddress("smythy.costa@gmail.com");  //verificar o email.
		$mail->Subject = $assunto;

		$mail->Charset = 'UTF-8';
		$mail->msgHTML(utf8_decode("<html>DE: {$nome}<br/><br/>EMAIL: {$email}<br/><br/>MENSAGEM: {$mensagem}</html>"));

		$mail->AltBody = utf8_decode("DE: {$nome}\n\n	EMAIL:{$email}\n\n MENSAGEM: {$mensagem}");


		if($mail->send()) 
		{
			echo "<script>alert('Ação efetuada com sucesso.');</script>";
			echo "<script>window.location = 'contato.php';</script>";
		} 
		else 
		{
			echo "<script>alert('Erro!.');</script>";
			echo "<script>window.location = 'contato.php';</script>";
		}
		die();
	} //end reg_errs
}//end post







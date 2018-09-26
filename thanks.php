<?php

// The user comes to this page after completing their PayPal transaction (in theory).
// This script is created in Chapter 6.
// Four lines are used in an earlier version but commented out later.

// Require the configuration before any PHP code as the configuration controls error reporting:
require('./includes/config.inc.php');
// The config file also starts the session.

// If the user hasn't just registered, redirect them:
// ---------------------------------------------------
//
//redirect_invalid_user('reg_user_id');
//
// Above line commented out in later version of this script.

// Require the database connection:
require('./includes/mysql.inc.php');


// Include the header file:
$page_title = 'Thanks!';
include('./includes/header.php');

// Update the users table:
// -----------------------
//
//if (isset($_SESSION['reg_user_id']) && filter_var($_SESSION['reg_user_id'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
//    $q = "UPDATE users SET date_expires = ADDDATE(date_expires, INTERVAL 1 YEAR) WHERE id={$_SESSION['reg_user_id']}";
//    $r = mysqli_query($dbc, $q);
//}
//
// Above lines commented out in later version of this script.

// Unset the session var:
// ----------------------
//
//unset($_SESSION['reg_user_id']);
//
// Above line commented out in later version of this script.

// Confirm the order with PayPal...
// Added in Chapter 12.
// --------------------------------
//
//include('./includes/pdt.php');
?>


<h1>Thank You!</h1>
<p>Obrigado por seu pagamento! Agora você pode acessar todo o conteúdo do site para o próximo ano! <strong>Observação: O seu acesso ao site será automaticamente renovado via PayPal todos os anos. Para desativar esse recurso ou para cancelar sua conta, consulte a seção "Minhas compras pré-aprovadas" da sua página de perfil do PayPal.</strong></p>


<?php // Include the HTML footer:
include('./includes/footer.php');
?>

<?php

// The user comes to this page after canceling their PayPal transaction (in theory).
// This script is created in Chapter 6.

// Require the configuration before any PHP code as the configuration controls error reporting:
require('./includes/config.inc.php');
// The config file also starts the session.

// Require the database connection:
require('./includes/mysql.inc.php');

// Include the header file:
$page_title = 'Oops!';
include('./includes/header.php');

?>
<h1>Oops!</h1>
<p>O pagamento através do PayPal não foi concluído. Agora você tem uma associação válida neste site, mas não poderá visualizar nenhum conteúdo até concluir a transação do PayPal. Você pode fazer isso clicando no link Renovar depois de fazer o login.</p>

<?php

// This is the logout page for the site.

// Require the configuration before any PHP code as the configuration controls error reporting:
require('./includes/config.inc.php');
// The config file also starts the session.

// If the user isn't logged in, redirect them:
redirect_invalid_user();

// Destroy the session:
$_SESSION = array(); // Destroy the variables.
session_destroy(); // Destroy the session itself.
setcookie (session_name(), '', time()-300); // Destroy the cookie.

// Header file needs the database connection:
require('./includes/mysql.inc.php');

// Include the header file:
$page_title = 'Logout';
include('./includes/header.php');

// Print a customized message:
echo '<h1>Logged Out</h1><p>Obrigado pela visita. Você está desconectado agora!</p>';

// Include the HTML footer:
include('./includes/footer.php');
?>
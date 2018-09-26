<?php

// The user comes to this page after canceling their PayPal transaction (in theory).
// This script is created in Chapter 6.

// Require the configuration before any PHP code as the configuration controls error reporting:
require('./includes/config.inc.php');
// The config file also starts the session.

// Require the database connection:
require(MYSQL);

// Include the header file:
$page_title = 'Oops!';
include('./includes/header.html');
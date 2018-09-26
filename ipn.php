<?php

// This page handles the Instant Payment Notification communications with PayPal.
// Most of the code comes from PayPal's documentation.
// This script is created in Chapter 6.

// Require the configuration before any PHP code as the configuration controls error reporting:
require('./includes/config.inc.php');
// The config file also starts the session.

// Check for a POST request, with a provided transaction ID:
if (($_SERVER['REQUEST_METHOD'] === 'POST') && isset($_POST['txn_id']) && ($_POST['txn_type'] === 'web_accept') ) {

} else { // This page was not requested via POST, no reason to do anything!
	echo 'Nothing to do.';
}
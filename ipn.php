<?php

// This page handles the Instant Payment Notification communications with PayPal.
// Most of the code comes from PayPal's documentation.
// This script is created in Chapter 6.

// Require the configuration before any PHP code as the configuration controls error reporting:
require('./includes/config.inc.php');
// The config file also starts the session.

// Check for a POST request, with a provided transaction ID:
if (($_SERVER['REQUEST_METHOD'] === 'POST') && isset($_POST['txn_id']) && ($_POST['txn_type'] === 'web_accept') ) {

	// Create the cURL handler:
	$ch = curl_init();

	// Configure the request:
	curl_setopt_array($ch, array (
	    CURLOPT_URL => 'https://www.sandbox.paypal.com/cgi-bin/webscr',
	    CURLOPT_POST => true,
	    CURLOPT_POSTFIELDS => http_build_query(array('cmd' => '_notify-validate') + $_POST),
	    CURLOPT_RETURNTRANSFER => true,
	    CURLOPT_HEADER => false
	));

} else { // This page was not requested via POST, no reason to do anything!	
	echo 'Nothing to do.';
}
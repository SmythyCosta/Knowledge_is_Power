<?php

// This page handles the Instant Payment Notification communications with PayPal.
// Most of the code comes from PayPal's documentation.
// This script is created in Chapter 6.

// Require the configuration before any PHP code as the configuration controls error reporting:
require('./includes/config.inc.php');
// The config file also starts the session.
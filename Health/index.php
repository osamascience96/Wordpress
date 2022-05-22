<?php
error_reporting(E_ALL);
ini_set('display_error', 1);
ini_set("log_errors", true);
ini_set("error_log", "error.log"); //send error log to log file specified here. 

// Version
define('VERSION', '3.0.0.0');

// Check Version
if (version_compare(phpversion(), '5.5.0', '<') == true) {
	exit('PHP5.5+ Required');
}

// Configuration
if (is_file('config/config.php')) {
	require_once('config/config.php');
} else {
	exit('Configuration file does not exist!');
}

if( defined('DB_HOSTNAME') && defined('DB_USERNAME') && defined('DB_PASSWORD') && defined('DB_DATABASE')) {
	if (empty(DB_HOSTNAME) || empty(DB_USERNAME) || empty(DB_PASSWORD) || empty(DB_DATABASE) || empty(DIR)) {
		header('location: install/index.php');
		exit();
	}
} else {
	header('location: install/index.php');
	exit();
}


require_once 'builder/startup.php';
launch();
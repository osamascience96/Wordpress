<?php
error_reporting(E_ALL);
ini_set('display_error', 1);
ini_set("log_errors", true);
ini_set("error_log", "error.log"); //send error log to log file specified here. 

// Version
define('VERSION', '3.0.0.0');

// Check Version
if (version_compare(phpversion(), '5.6.0', '<') == true) {
	exit('PHP5.6+ Required');
}

// Check if SSL
if ((isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) || $_SERVER['SERVER_PORT'] == 443) {
	$protocol = 'https://';
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') {
	$protocol = 'https://';
} else {
	$protocol = 'http://';
}

define('HTTP_SERVER', $protocol . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/.\\') . '/');
define('HTTP_KLINIKAL', $protocol . $_SERVER['HTTP_HOST'] . rtrim(rtrim(dirname($_SERVER['SCRIPT_NAME']), 'install'), '/.\\') . '/');

define('DIR_APPLICATION', str_replace('\\', '/', realpath(dirname(__FILE__))) . '/');
define('APPLICATION', str_replace('\\', '/', realpath(DIR_APPLICATION . '../')) . '/');

//Installation Directory
define('APP', str_replace('\\', '/', realpath(dirname(__FILE__))) . '/app/');
define('BUILDER', str_replace('\\', '/', realpath(dirname(__FILE__))) . '/builder/');

/*Configuration file path*/
$config_primary = APPLICATION.'config/config.php';
$config_seconadary = APPLICATION.'admin/config/config.php';

/*Check configuration file wraitable or not*/
if(is_writable($config_primary) && is_writable($config_seconadary) ) {
	require $config_primary;
} else {
	exit('Error: Config files are not writable!');
}

/*Check database file(.sql file) exists or not*/ 
$sql = BUILDER.'klinikal.sql';
if(!file_exists($sql)) {
	exit('Error: Database klinikal.sql file does not exist!');
}

require_once 'builder/startup.php';
launch();
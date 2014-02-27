<?php
//session_start();
/*=================
	SYSTEM CONFIG
==================*/
define('ga_appname', 'APPNAME');
define('ga_clientid', 'CLIENTID');
define('ga_clientsecret', 'CLIENTSECRET');
define('ga_redirurl', 'http://localhost');
define('ga_devkey', 'DEVKEY');

// Analytics READONLY mode
$conf_readonly = false;
/*=================
	SETTINGS
==================*/
$enabledebug = true;
if ($enabledebug){
	ini_set('display_errors',1);
	ini_set('display_startup_errors',1);
	error_reporting(-1);
}
/*=================
	INCLUDES
==================*/
/*require_once 'func.php';
require_once 'Google/Client.php';
require_once 'Google/Service/Analytics.php';*/
?>
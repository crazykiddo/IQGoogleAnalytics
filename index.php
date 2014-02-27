<?php
/*
CHARTS AND HELP

http://enarion.net/programming/php/google-client-api/google-client-api-analytics-tutorial/
https://github.com/mbostock/d3/wiki/Gallery
http://www.chartjs.org/
http://www.flotcharts.org/


TODO
- SET SITE SESSIONS (SetSiteProfile) using Ajax then refresh app
- show stats for selected site
*/	
session_start();
require_once 'config.php';
require_once 'func.php';
require_once 'Google/Client.php';
require_once 'Google/Service/Analytics.php';
/*=================
	SYSTEM 
==================*/
global $client;
global $service;
global $debuginfo;
global $token;
global $access;
$access = false;

if ($conf_readonly){
	$ANALYTICS = "https://www.googleapis.com/auth/analytics.readonly";
}else{
	$ANALYTICS = "https://www.googleapis.com/auth/analytics";
}
$client = new Google_Client();

// config
//$client->setAccessType('offline');
/*$client->setApplicationName('My Application name');
$client->setClientId(ga_clientid);
$client->setClientSecret(ga_clientsecret);
$client->setRedirectUri(ga_redirurl);
$client->setDeveloperKey(ga_devkey); // API key*/

$client->setScopes(array($ANALYTICS));
$service = new Google_Service_Analytics($client);

// LOGOUT
if (isset($_GET['logout'])) {
	echo "LOGOUT";
	unset($_SESSION['access_token']);
	//$client->revokeToken();
	//session_destroy();
	$access = false;
	$redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
	header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}

// HANDLE RESPONSE AND SET TOKEN SESSION
if (isset($_GET['code'])) {
	if (!isset($_SESSION['access_token'])){
		$client->authenticate($_GET['code']);
	}	
	$_SESSION['access_token'] = $client->getAccessToken();
	$redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
	header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
	return;
}

// IF TOKEN SET (REFRESH)
if (isset($_SESSION['access_token'])) {
	//echo "TOKEN : ".$_SESSION['access_token']."<br />";
	//$_SESSION['access_token'] = $client->getAccessToken();
	$token = json_decode($_SESSION['access_token']);
	//$client->refreshToken($token->refresh_token);
	//$_SESSION['access_token']= $client->getAccessToken();
	
	$access = true;
	$client->setAccessToken($_SESSION['access_token']);
	$debuginfo.= "TOKEN SET<br/>";
}else{
	$debuginfo."TOKEN NOT SET<br/>";
	$access = false;
}

//echo "isAccessTokenExpired : ".$client->isAccessTokenExpired()."<br>";
//echo "verifyIdToken : ".$client->verifyIdToken($token)."<br>";

// IF ACCESS TOKEN IS SET
if ($client->getAccessToken()) {
	$_SESSION['access_token'] = $client->getAccessToken();
	$token = json_decode($_SESSION['access_token']);
	//echo "TOKEN SET";
	//$debuginfo+="";
	$debuginfo.= "Access Token = " . $token->access_token . '<br/>';
	//$debuginfo.= "Refresh Token = " . $token->refresh_token . '<br/>';
	$debuginfo.= "Token type = " . $token->token_type . '<br/>';
	$debuginfo.= "Expires in = " . $token->expires_in . '<br/>';
	//$debuginfo.= "ID Token = " . $token->id_token . '<br/>';
	$debuginfo.= "Created = " . $token->created . '<br/>';
	//$debuginfo+= "<a class='logout' href='?logout'>Logout</a>";
	
	/*$props = $service->management_webproperties->listManagementWebproperties("~all");
	print "<h1>Web Properties</h1><pre>" . print_r($props, true) . "</pre>";
	$accounts = $service->management_accounts->listManagementAccounts();
	print "<h1>Accounts</h1><pre>" . print_r($accounts, true) . "</pre>";
	$segments = $service->management_segments->listManagementSegments();
	print "<h1>Segments</h1><pre>" . print_r($segments, true) . "</pre>";
	$goals = $service->management_goals->listManagementGoals("~all", "~all", "~all");
	print "<h1>Segments</h1><pre>" . print_r($goals, true) . "</pre>";*/
} else {
	/*echo "TOKEN NOT SET<br>";
	$authUrl = $client->createAuthUrl();
	print "<a class='login' href='$authUrl'>Connect Me!</a>";*/
	$authUrl = $client->createAuthUrl();
	header("Location: ".$authUrl);
	die;
}
// OUTPUT DESIGN
include_once "design.php";
?>
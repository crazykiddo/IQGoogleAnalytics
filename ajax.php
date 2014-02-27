<?php
session_start();
require_once 'config.php';
require_once 'func.php';
require_once 'Google/Client.php';
require_once 'Google/Service/Analytics.php';

$todo = "";
if ($_REQUEST["todo"]){
	$todo = $_REQUEST["todo"];
}


if ($todo=="setsitesession"){
	$aid = "";
	if ($_REQUEST["aid"]){
		$aid = $_REQUEST["aid"];
		$_SESSION['aid']=$aid;
	}
	$pid = "";
	if ($_REQUEST["pid"]){
		$pid = $_REQUEST["pid"];
		$_SESSION['pid']=$pid;
	}
	echo "OK";
}
?>
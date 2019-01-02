<?php
session_start();
ob_start();
	require_once 'functions/Constants.php';
	require_once 'functions/ConfigClass.php';
	require_once 'functions/SiteFunctions.php';
	require_once 'functions/AdminFunctions.php';
	require_once 'functions/Session.php';

$query=mysql_query("select count(*) from orders where read_status='no'");
$row = mysql_fetch_row($query);

// Should show you an integer result.
echo $row[0];exit;

?>
<?php
ob_start();
	require_once 'functions/Constants.php';
	require_once 'functions/ConfigClass.php';
	require_once 'functions/SiteFunctions.php';
	require_once 'functions/Session.php';
	
	session_destroy();
	echo "<script> window.location.href = 'login.php'; </script>";
?>
                            
<?php
	ob_start();
	if(empty($_SESSION['ADMINID']) || !isset($_SESSION['ADMINID']))
		echo "<script> window.location.href = '".SITEURL."login.php'; </script>";
	
	$AdminProfileDetail = GetSingleRow(ADMIN, $_SESSION['ADMINID']);
?>
<?php
ob_start();
require_once 'functions/Constants.php';
require_once 'functions/ConfigClass.php';
require_once 'functions/SiteFunctions.php';
require_once 'functions/AdminFunctions.php';
require_once 'functions/Session.php';

$sql="DELETE FROM `employee_numbers` WHERE `id`=".$_GET['id'].";";
echo $sql;
mysql_query($sql);

?>

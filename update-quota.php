<?php
ob_start();
require_once 'functions/Constants.php';
require_once 'functions/ConfigClass.php';
require_once 'functions/SiteFunctions.php';
require_once 'functions/AdminFunctions.php';
require_once 'functions/Session.php';
if(!AdminAccess($_SESSION['ADMINID'], array('A', 'M'))){
die;
}

$re = $_GET['re'];
$qin = $_GET['qin'];
$qus = $_GET['qus'];
if($re != '0') {
$t = '';
for ($i = 1; $i <= (int)$re; $i++) {
$t .= date("Y-m-d", strtotime(date("Y-m-d").' + '.$i.' days')).',';
}
$re = $t.';;;;'.$qin.';;;;'.$qus;
}
$sql="UPDATE `employee_number_quota` SET `quota_in`='".$qin."',`quota_us`='".$qus."', `repetition` = '".$re."' WHERE userid='".$_GET['uid']."';";
echo $sql;
mysql_query($sql);

?>

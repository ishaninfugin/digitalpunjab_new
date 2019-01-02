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

$type = $_POST['type'];

$number_list = preg_split('/\r\n|\r|\n/', file_get_contents($_FILES["fileToUpload"]["tmp_name"]));
$number_list = array_unique($number_list);
$sqlq = "SELECT `number` FROM `employee_numbers` WHERE `assigned` IS NULL AND `type` = '".$type."';";
$s = mysql_query($sqlq);
$availn = array();

while ($row = mysql_fetch_assoc($s)) {
    $availn[] = $row['number'];
}
$narray = array_diff($number_list, $availn);
$number_list = $narray;

//echo $number_list[0];
//var_dump($number_list);
//var_dump($availn);
//var_dump($narray);

$sql_pre = "INSERT IGNORE INTO `employee_numbers` (`number`, `type`) VALUES ";
$sql_suf = '';
$count = 1;
foreach ($number_list as $number) {
	if ($count >= 100) ins($sql_pre . rtrim($sql_suf,',') . ';');
    if ($number!= '' && $number!= ' ') $sql_suf .= "('$number', '$type'),";
	$count = $count + 1;
}

ins($sql_pre . rtrim($sql_suf,',') . ';');
function ins($esql) {
echo $esql;
mysql_query($esql);
$sql_suf = '';
$count = 1;

header("Location: ".SITEURL."upload-numbers-new.php");
}

?>

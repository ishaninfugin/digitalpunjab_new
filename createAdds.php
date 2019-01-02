<?php

ob_start();
require_once 'functions/Constants.php';
require_once 'functions/ConfigClass.php';
require_once 'functions/SiteFunctions.php';
require_once 'functions/AdminFunctions.php';
require_once 'functions/Session.php';

$request_body = file_get_contents('php://input');
//echo $request_body;
$data = json_decode($request_body);
$sql='';
$id=$data->id;
$message=$data->addsimage1;
if(isset($data->insertdata) && trim($id) ==''){
	$sql = "INSERT INTO `add_ads_new` (`image_name1`) values ('" . $message . "' )";
}
else{
	$sql = "UPDATE `add_ads_new` SET `image_name1`='" .$message. "' where id=".$id;
}

if (mysql_query($sql) === TRUE) {
	$Json['status'] = true;
	//update read instruction flag
	$data = "read_instruction = 0";
	$condition = "read_instruction = 1";
	UpdateRowOnCondition(ADMIN, $data, $condition);
} else {
	$Json['status'] = false;
}

echo json_encode($Json);
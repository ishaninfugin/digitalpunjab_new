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


if(isset($data->insertdata)){

    $num=GetNumOfRecords("tbl_instruction");
    if($num > 0){
        $sql = "UPDATE `tbl_instruction` SET `normalUser`='".$data->normaluser."',`resellerUser`='".$data->reselleruser."'";
    }else{
        $sql = "INSERT INTO `tbl_instruction` (`normalUser`,`resellerUser`) VALUES ('".$data->normaluser."','".$data->reselleruser."');";
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
}
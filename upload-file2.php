<?php

session_start();
ob_start();
require_once 'functions/Constants.php';
require_once 'functions/ConfigClass.php';
require_once 'functions/SiteFunctions.php';
require_once 'functions/AdminFunctions.php';
require_once 'functions/Session.php';

//pp($_FILES);
//pp($_POST);
//die();
$newfilename3 = '';
if ($_FILES['msg']["name"] != '') {
    $fileName = $_FILES["msg"]["name"]; // The file name
    $fileTmpLoc = $_FILES["msg"]["tmp_name"]; // File in the PHP tmp folder
    $fileType = $_FILES["msg"]["type"]; // The type of file it is
    $fileSize = $_FILES["msg"]["size"]; // File size in bytes
    $fileErrorMsg = $_FILES["msg"]["error"]; // 0 for false... and 1 for true
    $a = explode("/", $fileType);
    $created = date('Y-m-d H:i:s');
    $created = strtotime($created);
    $rowcountquery = mysql_query("select max(id) as mid from orders");
    $maxidfetch = mysql_fetch_array($rowcountquery);
    $ext = pathinfo($fileName, PATHINFO_EXTENSION);
    $nextid = $maxidfetch['mid'] + 1;
    $newfilename3 = "uploads/wechat/" . "msg" . $created . $nextid . "." . $ext;
    //echo $created;
    //echo $newfilename3;exit;
    move_uploaded_file($fileTmpLoc, "uploads/wechat/" . "msg" . $created . $nextid . "." . $ext);
}

//$FileName=$created.'_'.$newfilename3;
//echo "<pre>";Print_r($_FILES).'  __'.$newfilename3;exit;

mysql_query("update wechat_orders set confirmedlist='" . $newfilename3 . "' where id=" . $_REQUEST['orderid']);

die(json_encode(['status' => 'success', 'msg' => 'Your number file uploaded Successfully']));
?>
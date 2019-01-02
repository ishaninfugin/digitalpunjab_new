<?php
ob_start();
require_once 'functions/Constants.php';
require_once 'functions/ConfigClass.php';
require_once 'functions/SiteFunctions.php';
require_once 'functions/AdminFunctions.php';
require_once 'functions/Session.php';


if(isset($_REQUEST['id'])){
    $userId = intval($_REQUEST['id']);
    $tblName = mysql_real_escape_string($_REQUEST['tblname']);
    $data=GetSingleRowsOnCondition(ADMIN,'id='.$userId);

    date_default_timezone_set('Etc/UTC');
    require 'mail/PHPMailerAutoload.php';
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPDebug = 2;
    $mail->Debugoutput = 'html';
    $mail->Host = 'localhost';
    $mail->Port = 25;
    $mail->SMTPSecure = 'tls';
    
    $mail->Username = "	amitsharma0186";
    $mail->Password = "Neelamsharma1234";
    $mail->setFrom('ashokneelam59@gmail.com', 'wpdataatul');
    $mail->addAddress($data['email'], $data['name']);
    $mail->Subject = 'Update Password';
    $rand_number=mt_rand(100000, 999999);
    $query = mysql_query("UPDATE `tbl_admin` SET `randno` = " .$rand_number. " WHERE id = '$userId' ") or die(mysql_error());

    $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";

    $mail->msgHTML("<h3>Click this link To <a href='".$actual_link."/updatePassword.php?id=".$data['id']."&num=".$rand_number."'>Update Password</a></h3>");
    $mail->AltBody = 'Update Password';
	
    if (!$mail->send()) {
        echo 0;die;
    } else {
        echo 1;die;
    }

}

?>
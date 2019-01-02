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
$date=$data->date;
$customerId=$data->customername;
$msgcnt=$data->msgcnt;

$uid=$_SESSION['ADMINID'] ;
$staffName=$_SESSION['LOGGEDUSER_FULLNAME'] ;

date_default_timezone_set('Asia/Kolkata');
$date = date( 'Y-m-d', strtotime($date) );

$message='';
$flag=false;
if(trim($id) ==''){

	$noOfPendingRcd=GetNumOfRecordsOnCondition('orders'," msgdate='".$date."' and uid=".$customerId." and (confirmedlist is null or confirmedlist ='') and (deduct is not null and deduct<>'' and concat('',deduct * 1) = deduct)");
	
	if($noOfPendingRcd>0){
		$flag=true;
		$message='There are pending uploads present for this client, Please complete it.';
	}else{
		
		$customerData=GetSingleRow('tbl_admin',$customerId);
		$sql = "INSERT INTO `staff_msg_report` (`uid`,`customer_name`,`customer_id`,`messagecnt`,`messagedate`,`staffname`) values (".$uid.",'" . $customerData['name'] . "',".$customerId.",".$msgcnt.",  CAST('".$date."' AS DATE),'" . $staffName . "')";
	}
}
else{
	$sql = "UPDATE `staff_msg_report` SET `messagecnt`=".$msgcnt." where id=".$id;
}


if($flag){
	$Json['status'] = false;
	$_SESSION['ERROR'] = $message;
}else{
	if (mysql_query($sql) === TRUE) {
		$Json['status'] = true;
		if(trim($id) ==''){
			$_SESSION['SUCCESS'] = 'Record Inserted Successfully';
		}else{
			$_SESSION['SUCCESS'] = 'Record Update Successfully';
		}
		 
	} else {
		$Json['status'] = false;
		$_SESSION['ERROR'] = 'Opps Something was wrong with you. Try again';
	}
	
}

echo json_encode($Json);
//echo $sql;
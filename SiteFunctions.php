<?php

ob_start();

###@@@ FILE FUNCTIONS	
function CountFileLines($filename) {
	$file_path = dirname(__FILE__) . "/../".$filename;

	$linecount = 0;
	
	if(file_exists($file_path)){
		$handle = fopen($file_path, "r");
		while(!feof($handle)){
		  $line = fgets($handle);
		  if(trim($line)!=''){
		  	$linecount++;
		  }
		}		
		fclose($handle);
	}
	
	return $linecount;
}

###@@@ FILE FUNCTIONS	
function FileContentInArray($filename) {
	$lineArray = array();
	
	$file_path = dirname(__FILE__) . "/../".$filename;

	$linecount = 0;
	
	if(file_exists($file_path)){
		$handle = fopen($file_path, "r");
		while(!feof($handle)){
		  $lineArray[] = fgets($handle);
		}		
		fclose($handle);
	}
	
	return $lineArray;
}

###@@@ DATE TIME FUNCTIONS	

function DayMonthYear($date) {
    $newdate = date("jS F Y", strtotime($date));
    return $newdate;
}

function DayMonthYearTime($date) {
    $newdate = date("jS F Y H:i:s A", strtotime($date));
    return $newdate;
}

function DayMonthYearTimeCounter($date) {
    $newdate = date("F j, Y H:i:s", strtotime($date));
    return $newdate;
}

###@@@ FETCH RECORDS FUNCTIONS	

function GetMultiRows($tablename) {
    $query = mysql_query("SELECT * FROM " . $tablename . "") or die(mysql_error());
    while ($row = mysql_fetch_assoc($query)) {
        $data[] = $row;
    }
    return $data;
}

function GetMultiRowsWithOrder($tablename) {
    $query = mysql_query("SELECT * FROM " . $tablename . " ORDER BY id DESC") or die(mysql_error());
    while ($row = mysql_fetch_assoc($query)) {
        $data[] = $row;
    }
    return $data;
}
function GetMultiRowsOnConditionWithOrder($tablename, $condition) {

    $query = mysql_query("SELECT * FROM " . $tablename . " WHERE " . $condition. " ORDER BY id DESC") or die(mysql_error());

    while ($row = mysql_fetch_assoc($query)) {
        $data[] = $row;
    }
    return $data;
}
function GetMultiRowsOnConditionWithOrderLimit($tablename, $condition, $limit) {

    $query = mysql_query("SELECT * FROM " . $tablename . " WHERE " . $condition. " ORDER BY id DESC limit $limit") or die(mysql_error());

    while ($row = mysql_fetch_assoc($query)) {
        $data[] = $row;
    }
    return $data;
}

function GetSingleRow($tablename, $id) {

    $query = mysql_query("SELECT * FROM $tablename WHERE id = '$id' ") or die(mysql_error());
    $row = mysql_fetch_assoc($query);
    return $row;
}
function GetRow($tablename)
{
	$query = mysql_query("SELECT * FROM $tablename ") or die(mysql_error());
    $row = mysql_fetch_assoc($query);
    return $row;
}
function GetMultiRowsOnCondition($tablename, $condition) {

    $query = mysql_query("SELECT * FROM " . $tablename . " WHERE " . $condition) or die(mysql_error());
    
	while ($row = mysql_fetch_assoc($query)) {
        $data[] = $row;
    }
    return $data;
}

function GetSingleRowsOnCondition($tablename, $condition) {

    $query = mysql_query("SELECT * FROM $tablename WHERE " . $condition) or die(mysql_error());

    $row = mysql_fetch_assoc($query);
    return $row;
}

###@@@ DELETE RECORD FUNCTIONS	

function DeleteSingleRow($tablename, $id) {
    $query = mysql_query("DELETE FROM " . $tablename . " WHERE id = '$id' ") or die(mysql_error());
    if ($query)
        return 1;
    else
        return 0;
}

###@@@ ACTIVE RECORD FUNCTIONS

function ActiveSingleRow($tablename, $id) {
    $query = mysql_query("UPDATE " . $tablename . " SET active = '1' WHERE id = '$id' ") or die(mysql_error());
    if ($query)
        $_SESSION['SUCCESS'] = 'Record Active Successfully';
    else
        $_SESSION['ERROR'] = 'Opps Something was worng with you. Try again';
}

###@@@ DEACTIVE RECORD FUNCTIONS

function DeactiveSingleRow($tablename, $id) {
    $query = mysql_query("UPDATE " . $tablename . " SET active = '0' WHERE id = '$id' ") or die(mysql_error());
    if ($query)
        $_SESSION['SUCCESS'] = 'Record Deactive Successfully';
    else
        $_SESSION['ERROR'] = 'Opps Something was worng with you. Try again';
}

###@@@ UPDATE RECORD FUNCTIONS	

function UpdateRowOnCondition($tablename, $data, $condition) {

    $query = mysql_query("UPDATE " . $tablename . " SET " . $data . " WHERE " . $condition) or die(mysql_error());
    if ($query)
        $_SESSION['SUCCESS'] = 'Record Update Successfully';
    else
        $_SESSION['ERROR'] = 'Opps Something was worng with you. Try again';
}

###@@@ FETCH NUM OF RECORDS

function GetNumOfRecords($tablename) {
    $query = mysql_query("SELECT * FROM " . $tablename . "") or die(mysql_error());
    $rows = mysql_num_rows($query);
    return $rows;
}

function GetNumOfRecordsOnCondition($tablename, $condition) {
    $query = mysql_query("SELECT * FROM " . $tablename . " WHERE " . $condition) or die(mysql_error());
    $rows = mysql_num_rows($query);
    return $rows;
}

function CheckEmailNewslatter($email) {
    $query = mysql_query("SELECT id FROM " . NEWSLETTER . " WHERE email = '$email' ");
    $nums = mysql_num_rows($query);
    return $nums;
}

function CountryNameFromId($id) {
    $query = mysql_query("SELECT * FROM " . COUNTRIES . " WHERE id = '$id' ") or die(mysql_error());
    $row = mysql_fetch_assoc($query);
    return ucwords($row['country_name']);
}

function pp($data) {
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

function pv($data) {
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

function getDataByQuery($query) {
    $query1 = mysql_query($query) or die(mysql_error());
    while ($row = mysql_fetch_assoc($query1)) {
        $data[] = $row;
    }
    return $data;
}

function getUserBalance($userid) {
    $balance_query = mysql_query("select msgcredit as bb from tbl_admin where id=" . $userid);
    $balance_fetch = mysql_fetch_array($balance_query);
    return $balance_fetch['bb'];
}
function getWechatBalance($userid) {
    $balance_query = mysql_query("select wechat_credit as bb from tbl_admin where id=" . $userid);
    $balance_fetch = mysql_fetch_array($balance_query);	
    return $balance_fetch['bb'];
}
function getUserFilterBalance($userid){
    $balance_query = mysql_query("select filtercredit as bb from tbl_admin where id=" . $userid);
    $balance_fetch = mysql_fetch_array($balance_query);
    return $balance_fetch['bb'];
}
function createUserCheckBalance($SS)
{
	if($_POST['whatsapp'] == 'Y')
	{
		if (($SS['msgcredit'] >= $_REQUEST['msgcredit'] &&  $_REQUEST['msgcredit'] >= 0) && ($SS['filtercredit'] >= $_REQUEST['filtercredit'] &&  $_REQUEST['filtercredit'] >= 0)) 
		{
			return true;
		}
		return false;
	}
	if($_POST['wechat'] == 'Y')
	{
		if (($SS['wechat_credit'] >= $_REQUEST['wechat_credit'] &&  $_REQUEST['wechat_credit'] >= 0)) 
		{
			return true;
		}
		return false;
	}
}
function checkWithParentUserBalance($user_id)
{
	
	$balance_query = mysql_query("select addedby as bb from tbl_admin where id=" . $user_id);
    $balance_fetch = mysql_fetch_array($balance_query);
	//echo $balance_fetch['bb'];exit;
	//fetch the parent row and credits 
	if($balance_fetch['bb'] != 0 && $balance_fetch['bb'] != 1)
	{
		$query = mysql_query("select * from tbl_admin where id=" . $balance_fetch['bb']);
		$SS = mysql_fetch_array($query);
		//echo $SS['msgcredit']; exit;
		
		if($_POST['whatsapp'] == 'Y')
		{
			if (($SS['msgcredit'] >= $_REQUEST['msgcredit'] &&  $_REQUEST['msgcredit'] >= 0) && ($SS['filtercredit'] >= $_REQUEST['filtercredit'] &&  $_REQUEST['filtercredit'] >= 0)) 
			{
				return true;
			}
			return false;
		}
		if($_POST['wechat'] == 'Y')
		{
			if (($SS['wechat_credit'] >= $_REQUEST['wechat_credit'] &&  $_REQUEST['wechat_credit'] >= 0)) 
			{
				return true;
			}
			return false;
		}
	}
	return true;
}
?>

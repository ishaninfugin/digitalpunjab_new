<?php

ob_start();
require_once 'functions/Constants.php';
require_once 'functions/ConfigClass.php';
require_once 'functions/SiteFunctions.php';
require_once 'functions/AdminFunctions.php';
require_once 'functions/Session.php';

if(isset($_REQUEST['change_important_flag'])){
    //update read important flag
    $admin_id=$AdminProfileDetail['id'];
    $data = "read_important = 1";
    $condition = "id = '$admin_id' ";
    UpdateRowOnCondition(ADMIN, $data, $condition);
    unset($_SESSION['SUCCESS']);
    unset($_SESSION['ERROR']);
}

if(isset($_REQUEST['check_admin_password'])){
    $password =base64_encode($_REQUEST['admin_pass']);
    $condition= "id = 1 and password='$password' ";
    $data=GetNumOfRecordsOnCondition(ADMIN,$condition);
    $Json['status'] = $data;
    echo json_encode($Json);
}

if(isset($_REQUEST['insertdata'])){
    $num=GetNumOfRecords("tbl_instruction");
    if($num > 0){
        $sql = "UPDATE `tbl_instruction` SET `normalUser`='".$_REQUEST['normaluser']."',`resellerUser`='".$_REQUEST['reselleruser']."'";
    }else{
        $sql = "INSERT INTO `tbl_instruction` (`normalUser`,`resellerUser`) VALUES ('".$_REQUEST['normaluser']."','".$_REQUEST['reselleruser']."');";
    }
    if (mysql_query($sql) === TRUE) {
        $Json['status'] = true;
    } else {
        $Json['status'] = false;
    }
}
/*COMMENTED ON 14-NOV-2017
function findChildElements($elements = false, &$childs) {
    global  $con;
    if(!$elements) return  $childs;
    if(is_array($elements)) {
        $elements = implode(',', $elements);
    }
    $userSql = "select group_concat(id) as user_ids from tbl_admin where addedby IN (". $elements .")";
    //echo $userSql.'<br/><br/>';
    $userQuery = mysqli_query($con, $userSql);
    if($userQuery->num_rows <= 0 ) { return $childs; }
    $users = mysqli_fetch_assoc($userQuery);
    if(empty($users['user_ids'])) { return $childs; }
    $childs[] = $users['user_ids'];
    return findChildElements($users['user_ids'], $childs);
}*/

//ADDED ON 14-NOV-2017
function findChildElements($elements = false, &$childs) {
    global  $con;
    if(!$elements) return  $childs;
    if(is_array($elements)) {
        $elements = implode(',', $elements);
    }
	
    $userSql = "select id as user_ids from tbl_admin where addedby IN (". $elements .")";
	
	$user_ids = '';
	$userAry = array();
	
    $userQuery = mysqli_query($con, $userSql);
    if($userQuery->num_rows <= 0 ) { return $childs; }
    while($users = mysqli_fetch_array($userQuery)){
		$userAry[] = $users['user_ids'];
	}
	
	$user_ids = implode(',',$userAry);
	
    if(empty($user_ids)) { return $childs; }
	
    $childs[] = $user_ids;
    return findChildElements($user_ids, $childs);
}

if(isset($_REQUEST['change_user_btn'])){
    $Json = array();
    $id=$_REQUEST['id'];
    $val=$_REQUEST['val'];
    if($val == "true"){
        $val= 1;
    }else{
        $val=0;
    }
    $condition_1 = "id=".$id;
    $sql_get_user_data = GetSingleRowsOnCondition(ADMIN, $condition_1);
    $childs = array();
    $childusers = findChildElements($id,$childs);
    $childstrings = implode(',', $childusers);
   // $childstrings =  $childstrings.','.$id;
    if(empty($childstrings)){
        $sql = "UPDATE `tbl_admin` SET `displaybtn`=".$val." where `id` IN (".$id.")";
    }else{
        $childstrings =  $childstrings.','.$id;
        $sql = "UPDATE `tbl_admin` SET `displaybtn`=".$val." where `id` IN (".$childstrings.")";
    }

    if (mysql_query($sql) === TRUE) {
        $Json['status'] = true;
    } else {
        $Json['status'] = false;
    }
    echo json_encode($Json);
    exit;
}
if(isset($_REQUEST['change_all_user_btn'])){
    $Json = array();
    $id=$_REQUEST['id'];
    $val=$_REQUEST['val'];
    if($val == "true"){
        $val= 1;
    }else{
        $val=0;
    }
    $sql = "UPDATE `tbl_admin` SET `displaybtn`=".$val." where `id`=1";
    $sql1 = "UPDATE `tbl_admin` SET `displaybtn`=".$val;
    if (mysql_query($sql) === TRUE && mysql_query($sql1) === TRUE) {
        $Json['status'] = true;
        $Json['val'] = $val;
    } else {
        $Json['status'] = false;
    }
    echo json_encode($Json);
    exit;
}

if(isset($_REQUEST['update_filter_point'])){
    $Json = array();
    $id=$_REQUEST['hidden_filter_id'];
    $val=$_REQUEST['add_point'];
    mysql_query("INSERT INTO `account`(`uid`,`balance`,`detail`,`datee`,`filter`) VALUES ('" . $id . "','" . $val . "','Account Creation Filter Balance','" . date("d-m-Y") . "',1)");
    $sql = "UPDATE `tbl_admin` SET `filtercredit`=".$val." where `id`=$id";
    if (mysql_query($sql) === TRUE) {
        $Json['status'] = true;
        $Json['val'] = $val;
    } else {
        $Json['status'] = false;
    }
    echo json_encode($Json);
    exit;
}

if(isset($_REQUEST['update_resaller_filter_point'])){
    $Json = array();
    $admin_id=$_REQUEST['hidden_admin_id'];
    $id=$_REQUEST['hidden_filter_id'];
    $val=$_REQUEST['add_point'];
    $condition= 'id='.$admin_id;
    $SS = GetSingleRowsOnCondition(ADMIN, $condition);
    if($SS['filtercredit'] >= $val &&  $val >= 0){
        mysql_query("INSERT INTO `account`(`uid`,`balance`,`detail`,`datee`,`filter`) VALUES ('" . $id . "','" . $val . "','Account Creation Filter Balance','" . date("d-m-Y") . "',1)");
        mysql_query("INSERT INTO `account`(`uid`,`balance`,`detail`,`datee`,`filter`) VALUES ('" . $admin_id . "','-" . $val . "','Filter Balance Given to New User ','" . date("d-m-Y") . "',1)");

        $new_filter_balance = ($AdminProfileDetail['filtercredit'] - $val);
        $query1 = mysql_query("UPDATE tbl_admin SET filtercredit = $new_filter_balance WHERE id = '{$admin_id}' ");
        $sql = "UPDATE `tbl_admin` SET `filtercredit`=".$val." where `id`=$id";
        if (mysql_query($sql) === TRUE) {
            $Json['status'] = true;
            $Json['val'] = $val;
        } else {
            $Json['status'] = false;
        }
        echo json_encode($Json);
        exit;
    }
    else{
        $Json['status'] = false;
        echo json_encode($Json);
        exit;
    }
}

if(isset($_REQUEST['delete_picture'])){
    $field=$_REQUEST['field'];
    $img=$_REQUEST['pic_name'];

    $sql = "UPDATE `add_ads` SET `".$field."`='' WHERE `add_ads`.`id` = 1";
    if (mysql_query($sql) === TRUE) {
        @unlink("uploads/".substr($img, 8));
        $Json['status'] = 1;
    } else {
        $Json['status'] = 0;
    }
    echo json_encode($Json);
}




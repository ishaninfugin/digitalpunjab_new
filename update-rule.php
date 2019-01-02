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
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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

$aul = '';
$aula = '';
$usrs = explode(';',$_GET['au']);
foreach ($usrs as $usr) {
$aula .= ';'.$usr.';';
$childs = array();
$a = findChildElements($usr, $childs);
foreach ($a as $child) {
$b = explode(',',((string) $child));
foreach ($b as $c) {
$aul .= ';'.$c.';';
}
}
}
$aul .= $aula;
$sql="UPDATE `btn_rules` SET `day`='".$_GET['day']."',`aua`='".$aula."', `allowed_users`='".$aul."',`hr`=".$_GET['shr'].", `mn`=".$_GET['smn'].", `shr`=".$_GET['sthr'].", `smn`=".$_GET['stmn'].", `pr`='".$_GET['pr']."', `spr`='".$_GET['spr']."' WHERE id=".$_GET['id'].";";
echo $sql;
mysql_query($sql);

?>

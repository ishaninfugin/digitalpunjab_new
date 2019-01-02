<?php
ob_start();
require_once 'functions/Constants.php';
require_once 'functions/ConfigClass.php';
require_once 'functions/SiteFunctions.php';
require_once 'functions/AdminFunctions.php';
require_once 'functions/Session.php';

function array2csv(array &$array)
{
   if (count($array) == 0) {
     return null;
   }
   ob_start();
   $df = fopen("php://output", 'w');
   fputcsv($df, array_keys(reset($array)));
   foreach ($array as $row) {
      fputcsv($df, $row);
   }
   fclose($df);
   return ob_get_clean();
}
function download_send_headers($filename) {
    // disable caching
    $now = gmdate("D, d M Y H:i:s");
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
    header("Last-Modified: {$now} GMT");

    // force download  
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");

    // disposition / encoding on response body
    header("Content-Disposition: attachment;filename={$filename}");
    header("Content-Transfer-Encoding: binary");
}
if(isset($_GET['uid']))
{
	
	if($_GET['uid'] == 'admin')
	{
		//export all users		
		$condition = "addedby=0 or addedby=1";
		$USerList = GetMultiRowsOnCondition(ADMIN, $condition);
		//echo count($UserList); exit;
	}
	else
	{
		//export users by parent user id
		$condition = "addedby =" . $_GET['uid'];
		$USerList = GetMultiRowsOnCondition(ADMIN, $condition);
		
	}
	//export to csv
	download_send_headers("user_export_" . date("Y-m-d") . ".csv");
	echo array2csv($USerList);
	die();
}
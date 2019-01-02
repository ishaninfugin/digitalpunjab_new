<?php
require_once 'functions/Constants.php';
	require_once 'functions/ConfigClass.php';
	require_once 'functions/SiteFunctions.php';
	require_once 'functions/AdminFunctions.php';
	require_once 'functions/Session.php';




// retrive data which you want to export

$contents="id,Town,SR,Order Date,Item Name,Item Quantity,Delivery Date,Delivery Quantity,Pending Quantity,Remark,Order Status\n";
$user_query = mysql_query("SELECT a.*,b.title as tt,c.name as nn FROM tbl_order a,tbl_town b,tbl_admin c where b.id=a.town_id and c.id=a.sr_id");
//Mysql query to get records from datanbase
//You can customize the query to filter from particular date and month etc...Which will depends your database structure.
//$user_query = mysql_query('SELECT id, display_date, url, title, STATUS FROM webinfo_pre_article ORDER BY RAND( ) LIMIT 0 , 15');

//While loop to fetch the records
$a=1;
while($row = mysql_fetch_array($user_query))
{
$contents.=$a.",";
$contents.=$row['tt'].",";
$contents.=$row['nn'].",";
$contents.=$row['order_date'].",";
$contents.=$row['item_name'].",";
$contents.=$row['item_qnty'].",";
$contents.=$row['delivery_date'].",";
$contents.=$row['delivery_qnty'].",";
$contents.=$row['pending_qnty'].",";
$contents.=$row['remark'].",";
$contents.=$row['order_status']."\n";
$a++;
}

// remove html and php tags etc.
$contents = strip_tags($contents); 

//header to make force download the file
header("Content-Disposition: attachment; filename=ExcelExport".date('d-m-Y').".csv");
print $contents;

?>
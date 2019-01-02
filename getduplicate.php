<?php 
ob_start();

require_once 'functions/Constants.php';
require_once 'functions/ConfigClass.php';
require_once 'functions/SiteFunctions.php';

$ids = $_POST['ids'];
$mainArr = array();
$mainFile=0;

foreach($ids as $id){
	
	if($mainFile==0){	
    $res = $con->query("select * from orders where id='".$id."'");
	$row = mysqli_fetch_array($res);	
	if(trim($row['numberfile']) != ''){ 
		
		$tempAry = FileContentInArray(trim($row['numberfile']));
		foreach($tempAry as $item){
			$item=str_replace("\x00","",$item);
			$mainArr[] = trim($item);
		}
		$duppArr=array_count_values($mainArr);

		foreach ($duppArr as $key => $value){
			
			if($value>1){
				$key=str_replace("\x00","",$key);
				$txtFileData .= $key."\n";
			}			
		}
		
	}else{
		
		$mainArr[] = $row['mobilenumber'];
	}
	$mainFile++;
	
	}else{
		
		$res = $con->query("select * from orders where id='".$id."'");
		$row = mysqli_fetch_array($res);
		
		if(trim($row['numberfile']) != ''){ 
		$tempAry = FileContentInArray(trim($row['numberfile']));
		foreach($tempAry as $item){
			$item=str_replace("\x00","",$item);
			if(in_array(trim($item),$mainArr)){
				$item=str_replace("\x00","",$item);
				$txtFileData .= $item;
			}
			$item=str_replace("\x00","",$item);
		}
	  }elseif(trim($row['mobilenumber']) != ''){
		  $mobilenumber=trim($row['mobilenumber']);
		  if(in_array($mobilenumber,$mainArr)){
				$txtFileData .= $mobilenumber;
			}
	   } 
	}
}

//CREATE TEXT FILE
$txtFilePath = 'uploads/commonnumbers/'.microtime(true).'.txt';
$myfile = fopen($txtFilePath, "w") or die("Unable to open file!");
fwrite($myfile, $txtFileData);
fclose($myfile);

echo $txtFilePath;

?>
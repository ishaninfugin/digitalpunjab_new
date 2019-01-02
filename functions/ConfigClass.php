<?php
//ADDED ON 17-NOV-2017
date_default_timezone_set('Asia/Kolkata');

try{
    $astra_path = dirname(__FILE__) . "/../astra/Astra.php";
    if(file_exists($astra_path))
    {
        require_once($astra_path);
        if(class_exists('Astra')){
            $astra = new Astra();
        }
    }
}
catch(Exception $e) {
 // Do nothing
}

	ob_start();
	class CONNECTION {
		const HOST = 'localhost';  
		const USERNAME = 'root'; 
		const PASS = ''; 
		const DATABASE = 'dp';
		
		function __construct() {
			$CONNECT = mysql_connect(self::HOST,self::USERNAME,self::PASS) or die(mysql_error());
			$DB = mysql_select_db(self::DATABASE,$CONNECT) or die(mysql_error());
		}
	}
	
	$OBJ = new CONNECTION;
	$con = new mysqli($OBJ::HOST, $OBJ::USERNAME, $OBJ::PASS, $OBJ::DATABASE);
?>
                            
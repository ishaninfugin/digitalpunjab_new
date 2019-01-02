<?php
session_start();
ob_start();
	require_once 'functions/Constants.php';
	require_once 'functions/ConfigClass.php';
	require_once 'functions/SiteFunctions.php';
	require_once 'functions/AdminFunctions.php';
	require_once 'functions/Session.php';
	$PageTitle = 'Create Order';
	$menuName = 'entry';
	$submenuName = 'entry-create';
        if(isset($_REQUEST['SubmitEntry'])) {
		$newfilename='';
		if($_FILES['msgimage']["name"]!='') 
	{
		$fileName = $_FILES["msgimage"]["name"]; // The file name
		$fileTmpLoc = $_FILES["msgimage"]["tmp_name"]; // File in the PHP tmp folder
		$fileType = $_FILES["msgimage"]["type"]; // The type of file it is
		$fileSize = $_FILES["msgimage"]["size"]; // File size in bytes
		$fileErrorMsg = $_FILES["msgimage"]["error"]; // 0 for false... and 1 for true
		$a=explode("/",$fileType);
		$rowcountquery=mysql_query("select max(id) as mid from orders");
		$maxidfetch=mysql_fetch_array($rowcountquery);
		$ext = pathinfo($fileName, PATHINFO_EXTENSION);
		$nextid=$maxidfetch['mid']+1;
		$newfilename="uploads/"."msgimage".$nextid.".".$ext;
		move_uploaded_file($fileTmpLoc, "uploads/"."msgimage".$nextid.".".$ext);
	}
	$newfilename2='';
	if($_FILES['numberfile']["name"]!='') 
	{
		$fileName = $_FILES["numberfile"]["name"]; // The file name
		$fileTmpLoc = $_FILES["numberfile"]["tmp_name"]; // File in the PHP tmp folder
		$fileType = $_FILES["numberfile"]["type"]; // The type of file it is
		$fileSize = $_FILES["numberfile"]["size"]; // File size in bytes
		$fileErrorMsg = $_FILES["numberfile"]["error"]; // 0 for false... and 1 for true
		$a=explode("/",$fileType);
		$rowcountquery=mysql_query("select max(id) as mid from orders");
		$maxidfetch=mysql_fetch_array($rowcountquery);
		$ext = pathinfo($fileName, PATHINFO_EXTENSION);
		$nextid=$maxidfetch['mid']+1;
		$newfilename2="uploads/"."numberfile".$nextid.".".$ext;
		move_uploaded_file($fileTmpLoc, "uploads/"."numberfile".$nextid.".".$ext);
	}
        $newfilename3='';
	if($_FILES['msg']["name"]!='') 
	{
		$fileName = $_FILES["msg"]["name"]; // The file name
		$fileTmpLoc = $_FILES["msg"]["tmp_name"]; // File in the PHP tmp folder
		$fileType = $_FILES["msg"]["type"]; // The type of file it is
		$fileSize = $_FILES["msg"]["size"]; // File size in bytes
		$fileErrorMsg = $_FILES["msg"]["error"]; // 0 for false... and 1 for true
		$a=explode("/",$fileType);
		$rowcountquery=mysql_query("select max(id) as mid from orders");
		$maxidfetch=mysql_fetch_array($rowcountquery);
		$ext = pathinfo($fileName, PATHINFO_EXTENSION);
		$nextid=$maxidfetch['mid']+1;
		$newfilename3="uploads/"."msg".$nextid.".".$ext;
		move_uploaded_file($fileTmpLoc, "uploads/"."msg".$nextid.".".$ext);
	}
		
        mysql_query("insert into orders (`msgdate`,`msg`,`msgimage`,`mobilenumber`,`numberfile`,`uid`) values('".$_REQUEST['msgdate']."','".$newfilename3."','".$newfilename."','".$_REQUEST['mobilenumber']."','".$newfilename2."','".$_SESSION['ADMINID']."')");	
		$_SESSION['SUCCESS']="Your Order Saved Successfully";
		//header('location:entry-create.php');
                echo '<script>window.location="entry-create.php"</script>';
                exit;
	}
	
?>


<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $PageTitle; ?></title>
    <link href="<?php echo SITEURL; ?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo SITEURL; ?>font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="<?php echo SITEURL; ?>css/plugins/toastr/toastr.min.css" rel="stylesheet">
    <link href="<?php echo SITEURL; ?>js/plugins/gritter/jquery.gritter.css" rel="stylesheet">
    <link href="<?php echo SITEURL; ?>css/animate.css" rel="stylesheet">
    <link href="<?php echo SITEURL; ?>css/style.css" rel="stylesheet">

</head>

<body>
    <div id="wrapper">
        
        <?php
			include_once 'files/Sidebar.php';
		?>
		
        <div id="page-wrapper" class="gray-bg dashbard-1">
        <?php include_once 'files/TopBar.php'; ?>
        
                <div class="row  border-bottom white-bg dashboard-header">


<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Create Order</h5>
            </div>
            <div class="ibox-content">


<?php
	if(isset($_SESSION['ERROR']) && !empty($_SESSION['ERROR'])) {
		?>
		<div class="alert alert-danger alert-dismissable">
			<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
			<b>Error !! </b><?php echo $_SESSION['ERROR']; ?>
		</div>
		<?php
	}
	unset($_SESSION['ERROR']);
	if(isset($_SESSION['SUCCESS']) && !empty($_SESSION['SUCCESS'])) {
		?>
		<div class="alert alert-success alert-dismissable">
			<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
			<b>Success !! </b><?php echo $_SESSION['SUCCESS']; ?>
		</div>
		<?php
	}
	unset($_SESSION['SUCCESS']);
?>

                <form method="post" class="form-horizontal info" enctype="multipart/form-data">
                    <div class="form-group"><label class="col-sm-2 control-label">Msg Date</label>
                        <div class="col-sm-10">
                        <input type="date" name="msgdate" class="form-control validate[required]">
                        </div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label">Message</label>
                        <div class="col-sm-10" id="BeltSection">
                        <input type="file" name="msg" class="form-control" id="msgimage" value="0" >
                        
                        </div>
                    </div>
                     <div class="form-group"><label class="col-sm-2 control-label">Image For Message</label>
                        <div class="col-sm-10">
                        <input type="file" name="msgimage" class="form-control" id="msgimage" value="0" >
                        </div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label">Attach Number File</label>
                        <div class="col-sm-10">
                        <input type="file" name="numberfile" class="form-control" id="numberfile" value="0">
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <button class="btn btn-primary" name="SubmitEntry" type="submit">Submit Entry</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>                   
                    
                    

            	</div>
        <?php include_once 'files/Footer.php'; ?>

        </div>
    </div>

    <script src="<?php echo SITEURL; ?>js/jquery-2.1.1.js"></script>
    <script src="<?php echo SITEURL; ?>js/bootstrap.min.js"></script>
    <script src="<?php echo SITEURL; ?>js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo SITEURL; ?>js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="<?php echo SITEURL; ?>js/plugins/flot/jquery.flot.js"></script>
    <script src="<?php echo SITEURL; ?>js/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="<?php echo SITEURL; ?>js/plugins/flot/jquery.flot.spline.js"></script>
    <script src="<?php echo SITEURL; ?>js/plugins/flot/jquery.flot.resize.js"></script>
    <script src="<?php echo SITEURL; ?>js/plugins/flot/jquery.flot.pie.js"></script>
    <script src="<?php echo SITEURL; ?>js/plugins/peity/jquery.peity.min.js"></script>
    <script src="<?php echo SITEURL; ?>js/demo/peity-demo.js"></script>
    <script src="<?php echo SITEURL; ?>js/inspinia.js"></script>
    <script src="<?php echo SITEURL; ?>js/plugins/pace/pace.min.js"></script>
    <script src="<?php echo SITEURL; ?>js/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="<?php echo SITEURL; ?>js/plugins/gritter/jquery.gritter.min.js"></script>
    <script src="<?php echo SITEURL; ?>js/plugins/sparkline/jquery.sparkline.min.js"></script>
    <script src="<?php echo SITEURL; ?>js/demo/sparkline-demo.js"></script>

    <link rel="stylesheet" href="<?php echo SITEURL; ?>valideation/validationEngine.jquery.css" type="text/css" />
    <script type="text/javascript" src="<?php echo SITEURL; ?>valideation/jquery-1.7.2.min.js"></script>
    <script src="<?php echo SITEURL; ?>valideation/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo SITEURL; ?>valideation/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <script>
        var $j = jQuery.noConflict();
        $j(document).ready(function(){
            $j(".info").validationEngine();
        });
    </script>
    
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<script type="text/javascript">
     $(document).ready(function(){ 
        $("#OpeningStock").change(function() { 
            var OpeningStock = $("#OpeningStock").val();
			var RetailingStock = $("#RetailingStock").val();
			var ClosingStock =  OpeningStock - RetailingStock;
            $("#ClosingStock").val(ClosingStock);
		});
		
		$("#RetailingStock").change(function() { 
            var OpeningStock = $("#OpeningStock").val();
			var RetailingStock = $("#RetailingStock").val();
			var ClosingStock =  OpeningStock - RetailingStock;
            $("#ClosingStock").val(ClosingStock);
		}); 
		
	 });
	 
	 function LoadBelt(townId) {
	 	$("#BeltSection").load("<?php echo SITEURL; ?>load-belt.php?townId="+townId);
	 }
		
    </script>
    
    
</body>
</html>

                            
                            
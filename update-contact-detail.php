<?php
ob_start();
	require_once 'functions/Constants.php';
	require_once 'functions/ConfigClass.php';
	require_once 'functions/SiteFunctions.php';
	require_once 'functions/AdminFunctions.php';
	require_once 'functions/Session.php';
	
	$PageTitle = 'Update Contact Detail';
	$menuName = 'contact-detail';
	$submenuName = '';
	
	if(isset($_REQUEST['SocialLinkUpdate'])) {
		$address = mysql_real_escape_string(trim($_REQUEST['address']));
		$contactnumber = mysql_real_escape_string(trim($_REQUEST['contactnumber']));
		$mailid = mysql_real_escape_string(trim($_REQUEST['mailid']));
		$website = mysql_real_escape_string(trim($_REQUEST['website']));
		$copyright = mysql_real_escape_string(trim($_REQUEST['copyright']));
		
		$facebook = mysql_real_escape_string(trim($_REQUEST['facebook']));
		$twitter = mysql_real_escape_string(trim($_REQUEST['twitter']));
		$google = mysql_real_escape_string(trim($_REQUEST['google']));
		
		$data = "address = '".$address."', contactnumber = '".$contactnumber."', mailid = '".$mailid."', website = '".$website."', copyright = '".$copyright."', facebook = '".$facebook."', twitter = '".$twitter."', google = '".$google."' ";
		$condition = "id = '1'";
		UpdateRowOnCondition(SOCIALLINKS, $data, $condition);
		echo "<script> window.location.href = 'update-contact-detail.php'; </script>";
		exit();
	}
	
	$SocialLinks = GetSingleRow(SOCIALLINKS, 1);
	
?>


<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $PageTitle; ?></title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Toastr style -->
    <link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">

    <!-- Gritter -->
    <link href="js/plugins/gritter/jquery.gritter.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

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
                <h5>Update Contact Detail</h5>
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
<!--htmlgstart -->
                <form method="post" class="form-horizontal">
                    <div class="form-group"><label class="col-sm-2 control-label">Address</label>
                        <div class="col-sm-10">
                        <input type="text" name="address" class="form-control" value="<?php echo $SocialLinks['address']; ?>" >
                        </div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label">Contact Number</label>
                        <div class="col-sm-10">
                        <input type="text" name="contactnumber" class="form-control" value="<?php echo $SocialLinks['contactnumber']; ?>">
                        </div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label">Email Address</label>
                        <div class="col-sm-10">
                        <input type="text" name="mailid" class="form-control" value="<?php echo $SocialLinks['mailid']; ?>">
                        </div>
                    </div>
                    
                    <div class="form-group"><label class="col-sm-2 control-label">Website Url</label>
                        <div class="col-sm-10">
                        <input type="text" name="website" class="form-control" value="<?php echo $SocialLinks['website']; ?>" >
                        </div>
                    </div>
                    <!--<div class="form-group"><label class="col-sm-2 control-label">Copyright Message</label>
                        <div class="col-sm-10">
                        <input type="text" name="copyright" class="form-control" value="<?php //echo $SocialLinks['copyright']; ?>">
                        </div>
                    </div>-->
                    
                    <div class="form-group"><label class="col-sm-2 control-label">Facebook Link</label>
                        <div class="col-sm-10">
                        <input type="text" name="facebook" class="form-control" value="<?php echo $SocialLinks['facebook']; ?>" >
                        </div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label">Twitter Link</label>
                        <div class="col-sm-10">
                        <input type="text" name="twitter" class="form-control" value="<?php echo $SocialLinks['twitter']; ?>">
                        </div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label">Google Link</label>
                        <div class="col-sm-10">
                        <input type="text" name="google" class="form-control" value="<?php echo $SocialLinks['google']; ?>">
                        </div>
                    </div>
                                                
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <button class="btn btn-primary" name="SocialLinkUpdate" type="submit">Update Details</button>
                        </div>
                    </div>
                </form>
<!--htmlgstop -->
            </div>
        </div>
    </div>
</div>                   
                    
                    

            	</div>
        <?php include_once 'files/Footer.php'; ?>

        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Flot -->
    <script src="js/plugins/flot/jquery.flot.js"></script>
    <script src="js/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="js/plugins/flot/jquery.flot.spline.js"></script>
    <script src="js/plugins/flot/jquery.flot.resize.js"></script>
    <script src="js/plugins/flot/jquery.flot.pie.js"></script>

    <!-- Peity -->
    <script src="js/plugins/peity/jquery.peity.min.js"></script>
    <script src="js/demo/peity-demo.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

    <!-- jQuery UI -->
    <script src="js/plugins/jquery-ui/jquery-ui.min.js"></script>

    <!-- GITTER -->
    <script src="js/plugins/gritter/jquery.gritter.min.js"></script>

    <!-- Sparkline -->
    <script src="js/plugins/sparkline/jquery.sparkline.min.js"></script>

    <!-- Sparkline demo data  -->
    <script src="js/demo/sparkline-demo.js"></script>

    <!-- ChartJS-->
    <script src="js/plugins/chartJs/Chart.min.js"></script>

    <!-- Toastr -->
    <script src="js/plugins/toastr/toastr.min.js"></script>

</body>
</html>

                            
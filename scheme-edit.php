<?php
ob_start();
	require_once 'functions/Constants.php';
	require_once 'functions/ConfigClass.php';
	require_once 'functions/SiteFunctions.php';
	require_once 'functions/AdminFunctions.php';
	require_once 'functions/Session.php';
	
	$PageTitle = 'Update Scheme';
	
	$menuName = 'scheme';
	$submenuName = 'scheme-list';
	
	####@@@ CHECK Scheme ID
	if(isset($_REQUEST['id'])) {
		$SchemeId = intval($_REQUEST['id']);
	}
	else {
		echo "<script> window.location.href = 'scheme-list.php'; </script>";
		exit();
	}
	
	#### UPDATE Scheme CODE
	if(isset($_REQUEST['UpdateScheme'])) {
		$details = mysql_real_escape_string(trim($_REQUEST['details']));
		$start_date = $_REQUEST['start_date'];
		$end_date = $_REQUEST['end_date'];
		$belt_covered = mysql_real_escape_string(trim($_REQUEST['belt_covered']));
		
		$data = "details = '$details', start_date= '$start_date', end_date = '$end_date', belt_covered = '$belt_covered' "; 
		$condition = "id = '$SchemeId' ";
		UpdateRowOnCondition(SCHEME, $data, $condition);
	}
	
	$SchemeDetail = GetSingleRow(SCHEME, $SchemeId);
	
	
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
                <h5>Update Scheme</h5>
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

                <form method="post" class="form-horizontal info">
                    <div class="form-group"><label class="col-sm-2 control-label">Scheme Details</label>
                        <div class="col-sm-10">
                        <textarea name="details" class="form-control"><?php echo $SchemeDetail['details']; ?></textarea>
                        </div>
                    </div>
                    
                    <div class="form-group"><label class="col-sm-2 control-label">Start Time</label>
                        <div class="col-sm-10">
                        <input type="date" name="start_date" class="form-control" value="<?php echo $SchemeDetail['start_date']; ?>">
                        </div>
                        
                    </div>
                    
                    <div class="form-group"><label class="col-sm-2 control-label">End Time</label>
                        <div class="col-sm-10">
                        <input type="date" name="end_date" class="form-control" value="<?php echo $SchemeDetail['end_date']; ?>">
                        </div>
                        
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label">Belt Covered</label>
                        <div class="col-sm-10">
                        <textarea type="text" name="belt_covered" class="form-control"><?php echo $SchemeDetail['belt_covered']; ?></textarea>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <button class="btn btn-primary" name="UpdateScheme" type="submit">Update Scheme</button>
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
    
</body>
</html>
	
                            
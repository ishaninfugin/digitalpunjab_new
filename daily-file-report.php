<?php
session_start ();
ob_start ();
require_once 'functions/Constants.php';
require_once 'functions/ConfigClass.php';
require_once 'functions/SiteFunctions.php';
require_once 'functions/AdminFunctions.php';
require_once 'functions/Session.php';

if (! AdminAccess ( $_SESSION ['ADMINID'], array (
		'A' 
) )) {
	?>
<h1 class="404-error"
	style="color: red; text-align: center; font-size: 100px">
	Looks like you've lost your way. Error 404 - Page not found.
	</h3>
	</div>
<?php
	die ();
}

$menuName='daily_file_report';

date_default_timezone_set ( 'Asia/Kolkata' );
$dateTemp = date ( 'd-m-Y' );
$dateTempForQry = date ( 'Y-m-d' );

$totalFiles = GetNumOfRecordsOnCondition ( 'orders', " msgdate='" . $dateTempForQry . "'" );

$rejectedFile = GetNumOfRecordsOnCondition ( 'orders', " msgdate='" . $dateTempForQry . "' and deduct is not null and deduct<>'' and concat('',deduct * 1) <> deduct" );

$confirmedFile = GetNumOfRecordsOnCondition ( 'orders', " msgdate='" . $dateTempForQry . "' and confirmedlist is not null and confirmedlist<>'' and concat('',deduct * 1) = deduct" );

$processingFile = GetNumOfRecordsOnCondition ( 'orders', " msgdate='" . $dateTempForQry . "' and (confirmedlist is null or confirmedlist='') and concat('',deduct * 1) = deduct" );

$pendingFile = GetNumOfRecordsOnCondition ( 'orders', " msgdate='" . $dateTempForQry . "' and (confirmedlist is null or confirmedlist='') and (deduct is null or deduct='')" );


?>

<!DOCTYPE html>
	<html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Daily Files Report</title>
<link href="<?php echo SITEURL; ?>css/bootstrap.min.css"
	rel="stylesheet">
<link href="<?php echo SITEURL; ?>font-awesome/css/font-awesome.css"
	rel="stylesheet">
<link href="<?php echo SITEURL; ?>css/plugins/toastr/toastr.min.css"
	rel="stylesheet">
<link href="<?php echo SITEURL; ?>js/plugins/gritter/jquery.gritter.css"
	rel="stylesheet">
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
								<h5>Daily Files Report</h5>
							</div>
							<div class="ibox-content">
								<div class="row">
									<div class="col-sm-10 col-lg-3">
										<div class="card">
											<div class="card" style="width: 18rem;">
												<div class="card-body">
													<h4 class="card-title">Total Files</h4>
													<h4 class="card-subtitle mb-2 text-muted"><?php echo $totalFiles;?></h4>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-10 col-lg-3">
										<div class="card">
											<div class="card" style="width: 18rem;">
												<div class="card-body">
													<h4 class="card-title">Confirmed Files</h4>
													<h4 class="card-subtitle mb-2 text-muted"><?php echo $confirmedFile;?></h4>
												</div>
											</div>
										</div>
									</div>
									
										<div class="col-sm-10 col-lg-3">
										<div class="card">
											<div class="card" style="width: 18rem;">
												<div class="card-body">
													<h4 class="card-title">Processing Files</h4>
													<h4 class="card-subtitle mb-2 text-muted"><?php echo $processingFile;?></h4>
												</div>
											</div>
										</div>
									</div>
									
									<div class="col-sm-10 col-lg-3">
										<div class="card">
											<div class="card" style="width: 18rem;">
												<div class="card-body">
													<h4 class="card-title">Pending Files</h4>
													<h4 class="card-subtitle mb-2 text-muted"><?php echo $pendingFile;?></h4>
												</div>
											</div>
										</div>
									</div>
									
									<div class="col-sm-10 col-lg-3">
										<div class="card">
											<div class="card" style="width: 18rem;">
												<div class="card-body">
													<h4 class="card-title">Rejected Files</h4>
													<h4 class="card-subtitle mb-2 text-muted"><?php echo $rejectedFile;?></h4>
												</div>
											</div>
										</div>
									</div>
									
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
		<script
			src="<?php echo SITEURL; ?>js/plugins/metisMenu/jquery.metisMenu.js"></script>
		<script
			src="<?php echo SITEURL; ?>js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
		<script src="<?php echo SITEURL; ?>js/plugins/flot/jquery.flot.js"></script>
		<script
			src="<?php echo SITEURL; ?>js/plugins/flot/jquery.flot.tooltip.min.js"></script>
		<script
			src="<?php echo SITEURL; ?>js/plugins/flot/jquery.flot.spline.js"></script>
		<script
			src="<?php echo SITEURL; ?>js/plugins/flot/jquery.flot.resize.js"></script>
		<script src="<?php echo SITEURL; ?>js/plugins/flot/jquery.flot.pie.js"></script>
		<script
			src="<?php echo SITEURL; ?>js/plugins/peity/jquery.peity.min.js"></script>
		<script src="<?php echo SITEURL; ?>js/demo/peity-demo.js"></script>
		<script src="<?php echo SITEURL; ?>js/inspinia.js"></script>
		<script src="<?php echo SITEURL; ?>js/plugins/pace/pace.min.js"></script>
		<script
			src="<?php echo SITEURL; ?>js/plugins/jquery-ui/jquery-ui.min.js"></script>
		<script
			src="<?php echo SITEURL; ?>js/plugins/gritter/jquery.gritter.min.js"></script>
		<script
			src="<?php echo SITEURL; ?>js/plugins/sparkline/jquery.sparkline.min.js"></script>
		<script src="<?php echo SITEURL; ?>js/demo/sparkline-demo.js"></script>
		<script src="<?php echo SITEURL; ?>js/plugins/chartJs/Chart.min.js"></script>
		<script src="<?php echo SITEURL; ?>js/tinymce/tinymce.min.js"></script>
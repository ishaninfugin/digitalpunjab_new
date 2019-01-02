<?php
ob_start ();
require_once 'functions/Constants.php';
require_once 'functions/ConfigClass.php';
require_once 'functions/SiteFunctions.php';
require_once 'functions/AdminFunctions.php';
require_once 'functions/Session.php';
if (! AdminAccess ( $_SESSION ['ADMINID'], array (
		'S' 
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

$PageTitle = "Numbers for Day";
$menuName = 'number-for-day';

date_default_timezone_set ( 'Asia/Kolkata' );
$dateTemp = date ( 'd-m-Y' );
$dateTempForQry = date ( 'Y-m-d' );


if(isset($_REQUEST['Submit'])){
	
	if(strtotime($dateTempForQry) >= strtotime($_REQUEST['date'])){
		$dateTempForQry=$_REQUEST['date'];
		
	}else{
		$_SESSION['ERROR']="Future date query is not allowed.";
	}
	
}

$reportData = GetSingleRowsOnCondition ( 'staff_numbers_upload', " date='" . $dateTempForQry . "' and uid=" . $_SESSION ['ADMINID'] );

?>


<!DOCTYPE html>
	<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?php echo $PageTitle; ?></title>
<link href="<?php echo SITEURL; ?>css/bootstrap.min.css"
	rel="stylesheet">
<link href="<?php echo SITEURL; ?>font-awesome/css/font-awesome.css"
	rel="stylesheet">
<link href="<?php echo SITEURL; ?>css/plugins/toastr/toastr.min.css"
	rel="stylesheet">
<link href="<?php echo SITEURL; ?>js/plugins/gritter/jquery.gritter.css"
	rel="stylesheet">
<link rel="stylesheet" type="text/css"
	href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/css/dataTables.bootstrap.css" />
<link href="<?php echo SITEURL; ?>css/animate.css" rel="stylesheet">
<link href="<?php echo SITEURL; ?>css/style.css" rel="stylesheet">
<link
	href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css"
	rel="stylesheet">
<link
	href="https://cdn.datatables.net/select/1.2.0/css/select.dataTables.min.css"
	rel="stylesheet">
<link
	href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css"
	rel="stylesheet">
<link
	href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css"
	rel="stylesheet">
<style>
.Edit_ded {
	display: none;
}

.Filter_Edit_ded {
	display: none;
}
</style>
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
								<h5>Numbers </h5>
							</div>
							<div class="ibox-content">
							<?php
	if(isset($_SESSION['ERROR']) && !empty($_SESSION['ERROR'])) {
		?>
		<div class="alert alert-danger alert-dismissable">
			<button aria-hidden="true" data-dismiss="alert" class="close" type="button">Ã—</button>
			<b>Error !! </b><?php echo $_SESSION['ERROR']; ?>
		</div>
		<?php
	}
	
	if(isset($_SESSION['SUCCESS']) && !empty($_SESSION['SUCCESS'])) {
		?>
		<div class="alert alert-success alert-dismissable">
			<button aria-hidden="true" data-dismiss="alert" class="close" type="button">Ã—</button>
			<b>Success !! </b><?php echo $_SESSION['SUCCESS']; ?>
		</div>
		<?php
	}
	unset($_SESSION['SUCCESS']);
?>

<div id="errormsg"> </div>
							<form id="submit_form" class="form-horizontal info"
										 method="post" >
									
									<div class="form-group">
										<label class="col-sm-2 control-label">Date </label>
										<div class="col-sm-5">
											<div class="col-sm-9 col-md-9">
												<input type="date"  name="date" class="form-control" id="date" value="<?php echo $_REQUEST['date']?>">
											</div>                                      
                                    	</div>
									</div>
									<div class="hr-line-dashed"></div>
									<div class="form-group">
										<div class="col-sm-4 col-sm-offset-2">
											<!-- <input type="button" class="btn btn-primary check_admin"
												value="Submit"> -->
											<button type="submit" class="btn btn-primary check_admin" name="Submit"
												id="Submit"  value="Submit">Get Numbers</button>
										
										</div>
									</div>
							</form>
							<?php if(!isset($_SESSION['ERROR'])) {?>
							<div class="row">
							
									<?php if($reportData['numbers']!=''){ ?>
									
									<div class="col-sm-10 col-lg-3">
									<pre><?php echo $reportData['numbers']; ?></pre>
									</div>
									<?php }else{?>
									<div class="col-sm-10 col-lg-3">
									No Numbers Present.</div>
									<?php 
										
									}?>
									<?php if($reportData['filename']!=''){
												?><div class="col-sm-10 col-lg-3">
												<a href="<?php echo $reportData['filename'];?>" target="_blank">Download Numbers Image </a></div>
												<?php 
									}else{?>
									<div class="col-sm-10 col-lg-3">
									No Image Present.</div>
									<?php 
										
									}}else{
										unset($_SESSION['ERROR']);
									}?>
									
									
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

        <?php include_once 'files/Footer.php'; ?>
    </div>


		<!-- Mainly scripts -->
		<script src="<?php echo SITEURL; ?>js/jquery-2.1.1.js"></script>
		<script src="<?php echo SITEURL; ?>js/bootstrap.min.js"></script>
		<script
			src="<?php echo SITEURL; ?>js/plugins/metisMenu/jquery.metisMenu.js"></script>
		<script
			src="<?php echo SITEURL; ?>js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

		<script
			src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
		<script
			src="https://cdn.datatables.net/select/1.2.0/js/dataTables.select.min.js"></script>
		<script
			src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>

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
		<script
			src="http://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
		<script
			src="http://cdn.jsdelivr.net/jquery.validation/1.15.1/additional-methods.min.js"></script>

</body>
	</html>
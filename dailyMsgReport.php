<?php
ob_start();
require_once 'functions/Constants.php';
require_once 'functions/ConfigClass.php';
require_once 'functions/SiteFunctions.php';
require_once 'functions/AdminFunctions.php';
require_once 'functions/Session.php';
if(!AdminAccess($_SESSION['ADMINID'], array('S'))){
	?>
	<h1 class="404-error" style="color: red; text-align:center; font-size: 100px">Looks like you've lost your way. Error 404 - Page not found.</h3>
	</div>
	<?php 
	die;
}

$PageTitle="Daily Message Report";
$menuName='daily_report';

if (isset ( $_REQUEST ['update'] )) {
	$update_data=GetSingleRow("staff_msg_report",$_REQUEST ['update']);
}

if (isset ( $_REQUEST ['deleteId'] )) {
	$flag=DeleteSingleRow('staff_msg_report', $_REQUEST ['deleteId']);
}

date_default_timezone_set('Asia/Kolkata');
$dateTemp=date('d-m-Y');
$dateTempForQry=date('Y-m-d');

$reportData = GetMultiRowsOnCondition ( 'staff_msg_report', " messagedate='".$dateTempForQry."' and uid=".$_SESSION['ADMINID']);

$customerData = GetMultiRowsOnCondition ( 'tbl_admin', " actype in ('M','U') order by name ");

?>
<!DOCTYPE html>
<html>
<?php require_once 'header.php'; ?>

<body>
	<!-- Loading Container -->
	<div class="loading-container">
		<div class="loader"></div>
	</div>
	<!--  /Loading Container -->
	<!-- Navbar -->
	<?php require_once 'files/TopBar.php'; ?>
	<!-- /Navbar -->
	<!-- Main Container -->
	<div class="main-container container-fluid">
		<!-- Page Container -->
		<div class="page-container">

			<!-- Page Sidebar -->
			<?php require_once 'files/Sidebar.php'; ?>
			<!-- /Page Sidebar -->

			<!-- Page Content -->
			<div class="page-content">
				<!-- Page Breadcrumb -->
				<div class="page-breadcrumbs">
					<ul class="breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="#">Home</a>
						</li>
						<li class="active">Update Managers Details</li>
					</ul>
				</div>
				<!-- /Page Breadcrumb -->
				<!-- Page Header -->
				<div class="page-header position-relative">
					<div class="header-title">
						<h1>
							Update Managers Details
						</h1>
					</div>
					<!--Header Buttons-->
					<div class="header-buttons">
						<a class="sidebar-toggler" href="#">
							<i class="fa fa-arrows-h"></i>
						</a>
						<a class="refresh" id="refresh-toggler" href="">
							<i class="glyphicon glyphicon-refresh"></i>
						</a>
						<a class="fullscreen" id="fullscreen-toggler" href="#">
							<i class="glyphicon glyphicon-fullscreen"></i>
						</a>
					</div>
					<!--Header Buttons End-->
				</div>
				<!-- /Page Header -->
				<!-- Page Body -->
				<div class="page-body">

					<div class="row">
						<div class="col-lg-12">
							<div class="widget flat radius-bordered">
								<div class="widget-header bg-blue">
									<span class="widget-caption">Add Daily Message Count</span>
									<div class="widget-buttons">
										<a href="#" data-toggle="maximize">
											<i class="fa fa-expand"></i>
										</a>
										<a href="#" data-toggle="collapse">
											<i class="fa fa-minus"></i>
										</a>
										<a href="#" data-toggle="dispose">
											<i class="fa fa-times"></i>
										</a>
									</div>
								</div>

								<div class="widget-body">


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

									<div id="errormsg"> </div>
									<form id="submit_form" class="form-horizontal"
									method="post" >
									<input type="hidden" name="id" id="id" value="<?php echo $update_data['id']?>">
									<div class="form-group">
										<label class="col-sm-2 control-label">Date </label>
										<div class="col-sm-5">
											<div class="col-sm-9 col-md-9">
												<input type="text"  name="date" class="form-control" id="date" readonly="true"  value="<?php echo $dateTemp;?>">
											</div>                                      
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label">Customer Name </label>
										<div class="col-sm-5">
											<div class="col-sm-9 col-md-9">
												<?php if(isset($_REQUEST['update'])){?>
													<input type="text"  name="customername" class="form-control" id="customername" readonly="true"  value="<?php echo $update_data['customer_name'];?>">
												<?php }else{?>
													<select name="customername" class="form-control" id="customername" value="<?php echo $update_data['customer_name']?>">
														<?php foreach($customerData as $custData) {?>
															<option value="<?php echo $custData['id']; ?>"><?php echo $custData['name']; ?></option>
														<?php }}?>
														<!-- <input type="text" name="customername" class="form-control" id="customername" value="<?php echo $update_data['customer_name']?>"> -->
													</select>
												</div>                                      
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label">Message Count </label>
											<div class="col-sm-5">
												<div class="col-sm-9 col-md-9">
													<input type="number" name="msgcnt" class="form-control" id="msgcnt" value="<?php echo $update_data['messagecnt']?>">
												</div>                                      
											</div>
										</div>

										<div class="hr-line-dashed"></div>
										<div class="form-group">
											<div class="col-sm-4 col-sm-offset-2">
											<!-- <input type="button" class="btn btn-primary check_admin"
												value="Submit"> -->
												<button type="submit" class="btn btn-primary check_admin" name="SubmitImage"
												id="SubmitImage"  value="Submit">Submit</button>

											</div>
										</div>
									</form>

									<table class="table table-striped table-bordered table-hover "
									id="editable">
									<thead>
										<tr>
											<th width="60">Sr. No.</th>
											<th width="10">Date</th>
											<th width="350">Customer Name</th>
											<th width="120">Count</th>
											<th width="120">Update/Delete</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$sr=1;
										$msgCnt=0;
										foreach($reportData as $repData) {
											$msgCnt=$msgCnt+$repData['messagecnt'];
											?>	

											<tr class="gradeX" id="list_<?php echo $addData['id']; ?>">
												<td><?php echo $sr++; ?></td>
												<td><?php echo DayMonthYear($repData['messagedate']); ?></td>
												<td><?php echo $repData['customer_name']; ?></td>
												<td><?php echo $repData['messagecnt']; ?></td>
												<td> <a href="dailyMsgReport.php?update=<?php echo $repData['id']; ?>" class="btn btn-info btn-xs"><i class="fa fa-edit"></i> Update</a>
													<a onclick='deleteAdds("dailyMsgReport.php?deleteId=<?php echo $repData["id"]; ?>")' href="#" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Delete</a></td>
												</tr>
											<?php }?>

											<tfoot>
												<tr>
													<th width="50">Sr. No.</th>
													<th width="70">Date</th>
													<th width="350">Customer Name</th>
													<th width="120">Message Total : <?php echo $msgCnt;?></th>
													<th width="120">Update/Delete</th>
												</tr>
											</tfoot>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>


				<?php include_once 'files/Footer.php'; ?>
			</div>

			<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
			<script src="https://cdn.datatables.net/select/1.2.0/js/dataTables.select.min.js"></script>
			<script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>

			<script src="http://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
			<script src="http://cdn.jsdelivr.net/jquery.validation/1.15.1/additional-methods.min.js"></script>

			<script>

				jQuery('#submit_form').validate({

					errorElement: 'span',
					errorClass: 'help-block help-block-error',
					focusInvalid: false,
					ignore: "",
					rules: {
						date: {
							required: true
						},
						customername: {
							required: true
						},
						msgcnt: {
							required: true
						}
					},
					highlight: function (element) {
						jQuery(element)
						.closest('.form-group').addClass('has-error');
					},
					unhighlight: function (element) {
						jQuery(element)
						.closest('.form-group').removeClass('has-error');
					},
					success: function (label) {
						label
						.closest('.form-group').removeClass('has-error');
					}
				});


				$( "#submit_form" ).submit(function( event ) {

					var date = jQuery('#date').val();
					var customername = jQuery('#customername').val();
					var msgcnt = jQuery('#msgcnt').val();
					var id= jQuery('#id').val();

					if(id!=''){

					}

					if(customername!='' && msgcnt!=''){

						
						jQuery.ajax({ 
							url: 'dailyMsgReportController.php',
							type: 'POST',
							contentType: "application/json",
							data: JSON.stringify({
								date:date,
								customername:customername,
								msgcnt:msgcnt,
								id:id
							}),
							dataType: 'json',
                 // data: 'insertdata=true&normaluser='+encodeURIComponent(normaluser) +'&reselleruser='+encodeURIComponent(reselleruser),
                 success: function(data) {
                 	window.location="dailyMsgReport.php"
                 }
             });
					}
				});

				function deleteAdds(str){

					if(confirm("are you sure you want to delete this ?") == false)
					{
						return;
					}else{
						window.location=str;

					}

				}

			</script>

		</body>
		</html>
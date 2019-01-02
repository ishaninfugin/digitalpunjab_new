<?php
ob_start();
require_once 'functions/Constants.php';
require_once 'functions/ConfigClass.php';
require_once 'functions/SiteFunctions.php';
require_once 'functions/AdminFunctions.php';
require_once 'functions/Session.php';
if(!AdminAccess($_SESSION['ADMINID'], array('A'))){
	?>
		<h1 class="404-error" style="color: red; text-align:center; font-size: 100px">Looks like you've lost your way. Error 404 - Page not found.</h3>
	</div>
<?php 
die;
}

$PageTitle="Daily Report";
$menuName='daily_report';

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
                        <li class="active">Daily Reports</li>
                    </ul>
                </div>
                <!-- /Page Breadcrumb -->
                <!-- Page Header -->
                <div class="page-header position-relative">
                    <div class="header-title">
                        <h1>
                            Daily Reports
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
                <div class="col-lg-12">
                            <div class="widget flat radius-bordered">
                                <div class="widget-header bg-blue">
                                    <span class="widget-caption">Daily Reports</span>
                                    
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
									
									<div class="form-group">
										<label class="col-sm-2 control-label">Date </label>
										<div class="col-sm-5">
											<div class="col-sm-9 col-md-9">
												<input type="date" name="date" class="form-control" id="date" value="<?php echo $_REQUEST['date']?>">
											</div>                                      
                                    	</div>
									</div>
									<div class="hr-line-dashed"></div>
									<div class="form-group">
										<div class="col-sm-4 col-sm-offset-2">
											<!-- <input type="button" class="btn btn-primary check_admin"
												value="Submit"> -->
											<button type="submit" class="btn btn-primary check_admin" name="SubmitImage"
												id="SubmitImage"  value="Submit">Get Report</button>
										
										</div>
									</div>
									</form>
									
									<?php 
									if(isset($_REQUEST['date'])){
										
										$query ="Select distinct a.uid as uid,a.staffname as staffname from staff_msg_report a where a.messagedate='".$_REQUEST['date']."'";										
										$reprtDataMain=getDataByQuery($query);										
										foreach($reprtDataMain as $report){
											$reportData = GetMultiRowsOnCondition( 'staff_msg_report', " messagedate='".$_REQUEST['date']."' and uid=".$report['uid']);
										?>

									<table class="table table-striped table-bordered table-hover "
									id="editable"><caption>Report of <?php echo $report['staffname'];?></caption>
									<thead>
										<tr>
											<th width="60">Sr. No.</th>
											<th width="10">Date</th>
											<th width="350">Customer Name</th>
											<th width="120">Count</th>
											
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
											
											</tr>
									<?php }?>
									
									<tfoot>
										<tr>
											<th width="50">Sr. No.</th>
											<th width="70">Date</th>
											<th width="350">Customer Name</th>
											<th width="120">Message Total : <?php echo $msgCnt;?></th>
											
										</tr>
									</tfoot>
									</tbody>
								</table>
											<?php 
										}
									}	

									?>
									
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
        </script>

        </body>
    </html>
									
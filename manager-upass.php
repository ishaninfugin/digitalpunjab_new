<?php
ob_start();
	require_once 'functions/Constants.php';
	require_once 'functions/ConfigClass.php';
	require_once 'functions/SiteFunctions.php';
	require_once 'functions/AdminFunctions.php';
	require_once 'functions/Session.php';
	
	$PageTitle = 'Update Manager Password';
	$menuName = 'user';
	$submenuName = 'manager-list';
	
	if(isset($_REQUEST['id'])) {
		$userId = intval($_REQUEST['id']);
	}
	else {
		echo "<script> window.location.href = 'manager-list.php?id=".$editId."'; </script>";
		exit();
	}
	
	if(isset($_REQUEST['UpdateSubadministrator'])) {
		$password = mysql_real_escape_string(trim($_REQUEST['password']));
		$confirm_password = mysql_real_escape_string(trim($_REQUEST['confirm_password']));
		$expassword = base64_encode($password);
		
		if($password == $confirm_password) {
			$data = "password = '$expassword'"; 
			$condition = "id = '$userId' ";
			UpdateRowOnCondition(ADMIN, $data, $condition);
		}
		else {
			$_SESSION['ERROR'] = 'Password and confirm Password does not match.';
		}
	}
	
	$UserDetail = GetSingleRow(ADMIN, $userId);
	
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
                        <li class="active">Update Managers Password</li>
                    </ul>
                </div>
                <!-- /Page Breadcrumb -->
                <!-- Page Header -->
                <div class="page-header position-relative">
                    <div class="header-title">
                        <h1>
                            Update Managers Password
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
                                        <span class="widget-caption">Update Managers Password</span>
                                        
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

                <form method="post" class="form-horizontal">
                    <div class="form-group"><label class="col-sm-2 control-label">Username</label>
                        <div class="col-sm-10">
                        <input type="text" name="username" class="form-control validate[required]" disabled value="<?php echo $UserDetail['username']; ?>">
                        </div>
                    </div>
                    
                    <div class="form-group"><label class="col-sm-2 control-label">New Password</label>
                        <div class="col-sm-10">
                        <input type="password" name="password" class="form-control validate[required]">
                        </div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label">Confirm Password</label>
                        <div class="col-sm-10">
                        <input type="password" name="confirm_password" class="form-control validate[required]">
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <button class="btn btn-primary" name="UpdateSubadministrator" type="submit">Update Manager Password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>                   

        <?php include_once 'files/Footer.php'; ?>

        </div>
    </div>

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

                            
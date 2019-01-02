<?php
ob_start();
require_once 'functions/Constants.php';
require_once 'functions/ConfigClass.php';
require_once 'functions/SiteFunctions.php';
require_once 'functions/AdminFunctions.php';
require_once 'functions/Session.php';

$PageTitle = 'Credit History Settings';
$menuName = 'setting';
$setting=GetRow('tbl_setting');
if (isset($_REQUEST['addsetting'])) {
    if(empty($setting)){
        mysql_query("INSERT INTO `tbl_setting`(`name`,`value`) VALUES ('credit_month_limit','" . $_REQUEST['credit_month_limit'] . "')");
        $_SESSION['SUCCESS'] = "Your Record Saved Successfully";
        echo "<script> window.location.href = 'setting.php'; </script>";
	exit();
    }
    else{
        $data = "value = '".$_REQUEST['credit_month_limit']."'";
        $condition = "id = '".$setting['id']."'";
        UpdateRowOnCondition('tbl_setting', $data, $condition);
        echo "<script> window.location.href = 'setting.php'; </script>";
	exit();
    }
}
//if master password is not set send them to enter master password
if($_SESSION['ACTYPE'] == 'A')
{
	if(!isset($_SESSION['masterpass']))
	{
		$_SESSION['page'] = 'setting.php';
		echo "<script> window.location.href = 'masterpassword.php'; </script>";
			exit();
	}
}
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
                        <li class="active">Credit History Settings</li>
                    </ul>
                </div>
                <!-- /Page Breadcrumb -->
                <!-- Page Header -->
                <div class="page-header position-relative">
                    <div class="header-title">
                        <h1>
                            Credit History Settings
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
                                    <span class="widget-caption">Credit History Settings</span>
                                    
                                </div>
                                <div class="widget-body">

                            <?php
                            if (isset($_SESSION['ERROR']) && !empty($_SESSION['ERROR'])) {
                                ?>
                                <div class="alert alert-danger alert-dismissable">
                                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                    <b>Error !! </b><?php echo $_SESSION['ERROR']; ?>
                                </div>
                                <?php
                            }
                            unset($_SESSION['ERROR']);
                            if (isset($_SESSION['SUCCESS']) && !empty($_SESSION['SUCCESS'])) {
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
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Credit History Month Limit</label>
                                    <div class="col-sm-4">
                                        <select name="credit_month_limit" id="credit_month_limit" class="form-control validate[required]">
                                            <option value="1">1 Month</option>
                                            <option value="2">2 Month</option>
                                            <option value="3">3 Month</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-primary" name="addsetting" type="submit">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            
        
        <?php include_once 'files/Footer.php'; ?>
    </div>
</div>

<script>
    $(document).ready(function () {
        var credit_val='<?php echo $setting['value']; ?>';
        if(credit_val!=''){
            $('#credit_month_limit').val(credit_val);
        }
    });

</script>
</body>
</html>


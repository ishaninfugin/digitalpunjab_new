<?php
ob_start();
require_once 'functions/Constants.php';
require_once 'functions/ConfigClass.php';
require_once 'functions/SiteFunctions.php';
require_once 'functions/AdminFunctions.php';
require_once 'functions/Session.php';

$PageTitle = 'Update Manager Details';
$menuName = 'user';
$submenuName = 'manager-list';

if (isset($_REQUEST['id'])) {
    $userId = intval($_REQUEST['id']);
} else {
    echo "<script> window.location.href = 'manager-list.php'; </script>";
    exit();
}

if (isset($_REQUEST['UpdateSubadministrator'])) {

	//If the user is not admin and not the root user then check for the max credit limit with parent user 
	//
	if(checkWithParentUserBalance($userId))
	{
		if ($_REQUEST['msgcredit'] >= 0 && $_REQUEST['filtercredit'] >= 0) {

			extract($_REQUEST);
			//print_r($_POST); exit;
			$name = mysql_real_escape_string(trim($_REQUEST['name']));
			$email = mysql_real_escape_string(trim($_REQUEST['email']));
			$contact_number = mysql_real_escape_string(trim($_REQUEST['contact_number']));
			$msgcredit = mysql_real_escape_string(trim($_REQUEST['msgcredit']));
			$filtercredit = mysql_real_escape_string(trim($_REQUEST['filtercredit']));
			$wechat_credit = mysql_real_escape_string(trim($_REQUEST['wechat_credit']));
			$emp_id = mysql_real_escape_string(trim($_REQUEST['emp_id']));
			
			if($_REQUEST['whatsapp'] == 'Y' ) {$whatsapp = 'Y';} else { $whatsapp = 'N';}
			if($_REQUEST['wechat'] == 'Y' ) {$wechat = 'Y';} else { $wechat = 'N';}
			if($_REQUEST['logo'] == 'Y' ) {$logo = 'Y';} else { $logo = 'N';}
			if($_REQUEST['videoCaption'] == 'Y' ) {$video = 'Y';} else { $video = 'N';}
			if($_REQUEST['displayorders'] == 'Y' ) {$displayorders = 'Y';} else { $displayorders = 'N';}
			
			//calculate balance difference from old and new 
			$uid = $_SESSION['ADMINID'];
			$logged_in_user = getDataByQuery("SELECT * FROM tbl_admin WHERE id = '{$uid}' ")[0];
			$user_to_update = getDataByQuery("SELECT * FROM tbl_admin WHERE id = '{$userId}' ")[0];
			//calculate credit difference to update reseller balance
			$diff = ( floatval($user_to_update['msgcredit']) - floatval($msgcredit) );
			$diff_filtercredit = ( floatval($user_to_update['filtercredit']) - floatval($filtercredit) );
			$diff_wechat_credit  = ( floatval($user_to_update['wechat_credit']) - floatval($wechat_credit) );
			/*echo "<pre>";
			echo $wechat_credit;
			print_r($diff);
			print_r($diff_filtercredit);
			print_r($diff_wechat_credit);
			die;*/

			//make entry into credit table
			//if (($diff != 0 ) || ($diff_filtercredit != 0) || ($diff_wechat_credit != 0 )) {
				$date = date('d-m-Y');
				$diff1 = - $diff;
				$diff2 = - $diff_filtercredit;
				$diff3 = - $diff_wechat_credit;
				mysql_query("INSERT INTO account (uid,balance,detail,datee,filter) VALUES ('{$userId}','{$diff1}','direct balance update with account updation','{$date}',0) ");
				mysql_query("INSERT INTO account (uid,balance,detail,datee,filter) VALUES ('{$userId}','{$diff2}','direct Filter balance update with account updation','{$date}',1) ");
				mysql_query("INSERT INTO account (uid,balance,detail,datee,filter, wechat) VALUES ('{$userId}','{$diff3}','direct wechat balance update with account updation','{$date}',0,1) ");

				//echo "<pre>";print_r($_REQUEST);exit;
				
				$data = "name = '$name', msgcredit= '$msgcredit', filtercredit= '$filtercredit', email = '$email', contact_number = '$contact_number' , wechat_credit ='$wechat_credit', whatsapp='$whatsapp', wechat='$wechat', logo='$logo', displayorders='$displayorders', emp_id='$emp_id', video='".$video."'";
				$condition = "id = '$userId' ";
				
				
				UpdateRowOnCondition(ADMIN, $data, $condition);
		
				if ($_SESSION['ACTYPE'] !== 'A') 
				{
					$new_balance = floatval($logged_in_user['msgcredit']) + ($diff);
					$new_filter_balance = floatval($logged_in_user['filtercredit']) + ($diff_filtercredit);
					$new_wechat_credit = floatval($logged_in_user['wechat_credit']) + ($diff_wechat_credit);
					//update reseller balance
					mysql_query("UPDATE tbl_admin SET msgcredit = '{$new_balance}',filtercredit = '{$new_filter_balance}', wechat_credit = '{$new_wechat_credit}' WHERE id = '{$uid}' ");
				}
			/*}
			else {
				$_SESSION['ERROR'] = 'Sorry insufficient credit amount.';
			}*/

		} else {
		   $_SESSION['ERROR'] = "Sorry invalid credit amount provided."; 
		}
	}
	else
	{
		 $_SESSION['ERROR'] = "Sorry! you Dont have Enough Credit Balance or you have provided negative credit amount."; 
	}
//    pp($_POST);
//    pp($_SESSION);
//    die();
} 

$UserDetail = GetSingleRow(ADMIN, $userId);
//pp($UserDetail);
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
                                        <span class="widget-caption">Update Managers Details</span>
                                        
                                    </div>

                                    <div class="widget-body">


                                    <?php
                                    if (isset($_SESSION['ERROR']) && !empty($_SESSION['ERROR'])) {
                                        ?>
                                        <div class="alert alert-danger alert-dismissable">
                                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">Ã—</button>
                                            <b>Error !! </b><?php echo $_SESSION['ERROR']; ?>
                                        </div>
                                        <?php
                                    }
                                    unset($_SESSION['ERROR']);
                                    if (isset($_SESSION['SUCCESS']) && !empty($_SESSION['SUCCESS'])) {
                                        ?>
                                        <div class="alert alert-success alert-dismissable">
                                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">Ã—</button>
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
                                        <?php if($UserDetail['actype'] != 'S'){ ?>
										<div class="form-group"><label class="col-sm-2 control-label"></label>
											<div class="col-sm-10">
												<div class="checkbox checkbox-inline">
													<input type="checkbox" name="whatsapp" id="whatsapp" value="Y" <?php if($UserDetail['whatsapp'] == 'Y') { echo ' checked';} ?>>
													<label for="whatsapp">Whatsapp </label>
												</div>
												<div class="checkbox checkbox-success checkbox-inline">
													<input type="checkbox" name="wechat" id="wechat" value="Y" <?php if($UserDetail['wechat'] == 'Y') { echo ' checked';} ?>>
													<label for="wechat">Wechat </label>
												</div>
                                                <?php if($SS['logo'] =='Y'){ ?>
                                                <div class="checkbox checkbox-success checkbox-inline">
													<input type="checkbox" name="logo" id="logo" value="Y" <?php if($UserDetail['logo'] == 'Y') { echo ' checked';} ?>>
													<label for="logo">Logo </label>
												</div>
                                                <?php } ?>
                                                <?php if($SS['displayorders'] =='Y' && $_SESSION['ACTYPE'] == 'A'){ ?>
                                                <div class="checkbox checkbox-success checkbox-inline">
													<input type="checkbox" name="displayorders" id="displayorders" value="Y" <?php if($UserDetail['displayorders'] == 'Y') { echo ' checked';} ?>>
													<label for="logo">Orders </label>
												</div>
                                                <?php } ?>
                                                
                                                
                                                <div class="checkbox checkbox-success checkbox-inline">
													<input type="checkbox" name="videoCaption" id="videoCaption" value="Y" <?php if($UserDetail['video'] == 'Y') { echo ' checked';} ?>>
													<label for="logo">Video and Caption </label>
												</div>
                                              
											</div>
										</div>
                                        <?php } ?>
                                        
                                        <?php if($UserDetail['actype'] == 'S'){ ?>
                                        <div class="form-group"><label class="col-sm-2 control-label">Employee ID</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="emp_id" class="form-control validate[required]" value="<?php echo $UserDetail['emp_id']; ?>">
                                            </div>
                                        </div>
                                        <?php } ?>
                                        
                                        <div class="form-group"><label class="col-sm-2 control-label">Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="name" class="form-control validate[required]" value="<?php echo $UserDetail['name']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group"><label class="col-sm-2 control-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="email" class="form-control validate[required]" value="<?php echo $UserDetail['email']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group"><label class="col-sm-2 control-label">Contact Number</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="contact_number" class="form-control validate[required]" value="<?php echo $UserDetail['contact_number']; ?>">
                                            </div>
                                        </div>
                                        <?php if($UserDetail['actype'] != 'S'){ ?>
                                        <div class="form-group"><label class="col-sm-2 control-label">Whatsapp Credit</label>
                                            <div class="col-sm-10">
                                                <input type="number" min="0" <?php if($UserDetail['whatsapp'] != 'Y') { echo 'disabled="disabled"';} ?> name="msgcredit" id="msgcredit" class="form-control validate[required]" value="<?php echo $UserDetail['msgcredit']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group"><label class="col-sm-2 control-label">Whatsapp Filter Credit</label>
                                            <div class="col-sm-10">
                                                <input type="number" min="0" <?php if($UserDetail['whatsapp'] != 'Y') { echo 'disabled="disabled"';} ?> name="filtercredit" id="filtercredit" class="form-control validate[required]" value="<?php echo $UserDetail['filtercredit']; ?>">
                                            </div>
                                        </div>
										<div class="form-group"><label class="col-sm-2 control-label">Wechat Credit</label>
                                            <div class="col-sm-10">
                                                <input type="number" min="0" <?php if($UserDetail['wechat'] != 'Y') { echo 'disabled="disabled"';} ?> name="wechat_credit" id="wechat_credit" class="form-control validate[required]" value="<?php echo $UserDetail['wechat_credit']; ?>">
                                            </div>
                                        </div>
                                        <?php } ?>
                                        <div class="hr-line-dashed"></div>
                                        <div class="form-group">
                                            <div class="col-sm-4 col-sm-offset-2">
                                                <button class="btn btn-primary" name="UpdateSubadministrator" type="submit">Update Manager</button>
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
            $j(document).ready(function () {
                $j(".info").validationEngine();
				
				$j('#whatsapp').click( function() {
				
				  if(this.checked)
				  {
					$j('#filtercredit').removeAttr("disabled");
					$j('#msgcredit').removeAttr("disabled");						
				  }
				  else
				  {
					$j('#filtercredit').attr("disabled", "disabled");
					$j('#msgcredit').attr("disabled", "disabled");						
				  }
				});
				
				$j('#wechat').click( function() {
				  if(this.checked)
				  {
					$j('#wechat_credit').removeAttr("disabled");
											
				  }
				  else
				  {
					$j('#wechat_credit').attr("disabled", "disabled");										
				  }
				});
            });
        </script>

    </body>
</html>


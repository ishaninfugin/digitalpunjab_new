<?php
ob_start();
require_once 'functions/Constants.php';
require_once 'functions/ConfigClass.php';
require_once 'functions/SiteFunctions.php';
require_once 'functions/AdminFunctions.php';
require_once 'functions/Session.php';
if(!AdminAccess($_SESSION['ADMINID'], array('A', 'M'))){?>
		<h1 class="404-error" style="color: red; text-align:center; font-size: 100px">Looks like you've lost your way. Error 404 - Page not found.</h3>
	</div>
<?php 
die;
}
$PageTitle = 'Add Manager';
$menuName = 'user';
$submenuName = 'manager-create';
if (isset($_REQUEST['CreateSubadministrator'])) {
    $username = mysql_real_escape_string(trim(strtolower($_REQUEST['username'])));
    $password = base64_encode(trim($_REQUEST['password']));
    $confirm_password = base64_encode(trim($_REQUEST['confirm_password']));
    $name = mysql_real_escape_string(trim($_REQUEST['name']));
    $email = mysql_real_escape_string(trim($_REQUEST['email']));
    $contact_number = mysql_real_escape_string(trim($_REQUEST['contact_number']));
	$emp_id = mysql_real_escape_string(trim($_REQUEST['emp_id']));
	
	if($_REQUEST['whatsapp'] == 'Y') { $whatsapp = 'Y'; } else { $whatsapp='N';}
	if($_REQUEST['wechat'] == 'Y') { $wechat = 'Y';} else {$wechat='N';}
	if($_REQUEST['logo'] == 'Y') { $logo = 'Y';} else {$logo='N';}
	if($_REQUEST['displayorders'] == 'Y' ) {$displayorders = 'Y';} else { $displayorders = 'N';}
   
   if ($password == $confirm_password) {
        mysql_query("INSERT INTO `tbl_admin`(`actype`, `username`, `password`, `name`, `email`, `contact_number`,`addedby`,`msgcredit`,`filtercredit`,wechat_credit,whatsapp,wechat,logo,displayorders,emp_id) VALUES ('" . $_REQUEST['usertype'] . "','" . $username . "','" . $password . "','" . $name . "','" . $email . "','" . $contact_number . "','1','" . $_REQUEST['msgcredit'] . "','" . $_REQUEST['filtercredit'] . "','" . $_REQUEST['wechat_credit'] . "','" . $whatsapp . "','" . $wechat . "','" . $logo . "','".$displayorders."','".$emp_id."')");
        $temp_id=mysql_insert_id();
	
	if ($_REQUEST['usertype'] == 'S') mysql_query("INSERT INTO `employee_number_quota` (`name`, `userid`)  VALUES ('".$username."', '".$temp_id."');");
        mysql_query("INSERT INTO `account`(`uid`,`balance`,`detail`,`datee`,`filter`) VALUES ('" . $temp_id . "','" . $_REQUEST['msgcredit'] . "','Account Creation Balance','" . date("d-m-Y") . "',0)");
        mysql_query("INSERT INTO `account`(`uid`,`balance`,`detail`,`datee`,`filter`) VALUES ('" . $temp_id . "','" . $_REQUEST['filtercredit'] . "','Account Creation Filter Balance','" . date("d-m-Y") . "',1)");
    } else {
        $_SESSION['ERROR'] = 'Password and Confirm Password does not match.';
    }
}
//if master password is not set send them to enter master password
if($_SESSION['ACTYPE'] == 'A')
{
	if(!isset($_SESSION['masterpass']))
	{
		$_SESSION['page'] = 'manager-create.php';
		echo "<script> window.location.href = 'masterpassword.php'; </script>";
			exit();
	}
}
?>

<!DOCTYPE html>
<html>
  <?php require_once 'header.php'; ?>
    <body>
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
                        <li class="active">Add User</li>
                    </ul>
                </div>
                <!-- /Page Breadcrumb -->
                <!-- Page Header -->
                <div class="page-header position-relative">
                    <div class="header-title">
                        <h1>
                            Add User
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
                                        <span class="widget-caption">Create User</span>
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

                                    <form method="post" class="form-horizontal info_req">
                                        <div class="form-group"><label class="col-sm-2 control-label">User Type</label>
                                            <div class="col-sm-10">
                                                <select name="usertype" id="usertype" class="form-control validate[required]">
                                                    <option value="U">Normal User</option>
                                                    <option value="M">Re-seller User</option>
                                                    <?php if($_SESSION['ACTYPE'] == 'A'){ ?>
                                                    <option value="S">Staff User</option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
										<div class="form-group" id="checkboc_options">
                                        	<label class="col-sm-2 control-label"></label>
											<div class="col-sm-10">
												<div class="checkbox checkbox-inline">
													<input type="checkbox" name="whatsapp"  id="whatsapp" value="Y">
													<label class="text" for="whatsapp">Whatsapp </label>
												</div>
												<div class="checkbox checkbox-success checkbox-inline">
													<input type="checkbox" name="wechat" id="wechat" value="Y" >
													<label class="text" for="wechat">Wechat </label>
												</div>

                                                <?php if($SS['logo'] =='Y'){ ?>
                                                <div class="checkbox checkbox-success checkbox-inline">
													<input type="checkbox" name="logo" id="logo"  value="Y" >
													<label class="text" for="logo">Logo </label>
												</div>
                                                <?php } ?>
                                                <?php if($SS['displayorders'] =='Y'){ ?>
                                                <div class="checkbox checkbox-success checkbox-inline">
													<input type="checkbox" name="displayorders" data-prompt-position="topLeft" id="displayorders" value="Y" >
													<label class="text" for="displayorders">Orders </label>
												</div>
                                                <?php } ?>
											</div>
										</div>
                                        
                                        <div class="form-group hide" id="row_emp_id"><label class="col-sm-2 control-label">Employee ID</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="emp_id" data-prompt-position="topLeft" class="form-control validate[required]">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group"><label class="col-sm-2 control-label">Username</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="username" data-prompt-position="topLeft" class="form-control validate[required]">
                                            </div>
                                        </div>

                                        <div class="form-group"><label class="col-sm-2 control-label">Password</label>
                                            <div class="col-sm-10">
                                                <input type="password" name="password" id="Password" data-prompt-position="topLeft" class="form-control validate[required]">
                                            </div>
                                        </div>

                                        <div class="form-group"><label class="col-sm-2 control-label">Confirm Password</label>
                                            <div class="col-sm-10">
                                                <input type="password" name="confirm_password" data-prompt-position="topLeft" class="form-control validate[required,equals[Password]]">
                                            </div>
                                        </div>

                                        <div class="form-group"><label class="col-sm-2 control-label">Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="name" data-prompt-position="topLeft" class="form-control validate[required,custom[onlyLetterSp]]">
                                            </div>
                                        </div>
                                        <div class="form-group"><label class="col-sm-2 control-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="email" data-prompt-position="topLeft" class="form-control validate[required,custom[email]]">
                                            </div>
                                        </div>
                                        <div class="form-group"><label class="col-sm-2 control-label">Contact Number</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="contact_number" data-prompt-position="topLeft" class="form-control validate[required,custom[phone]]">
                                            </div>
                                        </div>
                                        <div class="form-group" id="whatsapp_credit"><label class="col-sm-2 control-label">Whatsapp Credit</label>
                                            <div class="col-sm-10">
                                                <input type="number" disabled="disabled" id="msgcredit" name="msgcredit" data-prompt-position="topLeft" class="form-control validate[required]">
                                            </div>
                                        </div>
                                        <div class="form-group" id="whatsapp_filter_credit"><label class="col-sm-2 control-label">Whatsapp Filter Credit</label>
                                            <div class="col-sm-10">
                                                <input type="number" disabled="disabled" id="filtercredit" name="filtercredit" data-prompt-position="topLeft" class="form-control validate[required]">
                                            </div>
                                        </div>
										<div class="form-group" id="wechat_credit_tab"><label class="col-sm-2 control-label">Wechat Credit</label>
                                            <div class="col-sm-10">
                                                <input type="number" disabled="disabled" id="wechat_credit" name="wechat_credit" data-prompt-position="topLeft" class="form-control validate[required]">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-4 col-sm-offset-2">
                                                <button class="btn btn-primary" name="CreateSubadministrator" type="submit">Create User</button>
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
    </div>
        <link rel="stylesheet" href="<?php echo SITEURL; ?>valideation/validationEngine.jquery.css" type="text/css" />
        <script type="text/javascript" src="<?php echo SITEURL; ?>valideation/jquery-1.7.2.min.js"></script>
        <script src="<?php echo SITEURL; ?>valideation/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo SITEURL; ?>valideation/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
        <script>
            var $j = jQuery.noConflict();
            $j(document).ready(function () {
                $j(".info_req").validationEngine();
				
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
				
				//USER TYPE
				$j('#usertype').change(function(){
					if($j(this).val()=='S'){
						$j('#checkboc_options').hide();
						$j('#whatsapp_credit').hide();
						$j('#whatsapp_filter_credit').hide();
						$j('#wechat_credit').hide();
						$j('#row_emp_id').removeClass('hide');
					}else{
						$j('#checkboc_options').show();
						$j('#whatsapp_credit').show();
						$j('#whatsapp_filter_credit').show();
						$j('#wechat_credit').show();
						$j('#row_emp_id').addClass('hide');
					}
				});
            });
        </script>
    </body>
</html>


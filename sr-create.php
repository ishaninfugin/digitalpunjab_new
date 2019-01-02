<?php
ob_start();
	require_once 'functions/Constants.php';
	require_once 'functions/ConfigClass.php';
	require_once 'functions/SiteFunctions.php';
	require_once 'functions/AdminFunctions.php';
	require_once 'functions/Session.php';
	
	$PageTitle = 'Add SR';
	
	$menuName = 'sr';
	$submenuName = 'sr-create';
	
	if(isset($_REQUEST['CreateSR'])) {
		$username = mysql_real_escape_string(trim(strtolower($_REQUEST['username'])));
		$password = mysql_real_escape_string(trim($_REQUEST['password']));
		$confirm_password = mysql_real_escape_string(trim($_REQUEST['confirm_password']));
		$name = mysql_real_escape_string(trim($_REQUEST['name']));
		$email = mysql_real_escape_string(trim($_REQUEST['email']));
		$contact_number = mysql_real_escape_string(trim($_REQUEST['contact_number']));
		$head_quater = mysql_real_escape_string(trim($_REQUEST['head_quater']));
		$start_date = $_REQUEST['start_date'];
		$termination_date = $_REQUEST['termination_date'];
		$remark = mysql_real_escape_string(trim($_REQUEST['remark']));
		$active = $_REQUEST['active'];
		
		if($password == $confirm_password) {
			CreateSR($username, $password, $name, $email, $contact_number, $head_quater, $start_date, $termination_date, $remark, $active);
		}
		else {
			$_SESSION['ERROR'] = 'Password and Confirm Password does not match.';
		}
		
	}
	
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
                <h5>Create SR</h5>
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
                    <div class="form-group"><label class="col-sm-2 control-label">Username</label>
                        <div class="col-sm-10">
                        <input type="text" name="username" class="form-control validate[required]">
                        </div>
                    </div>
                    
                    <div class="form-group"><label class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-10">
                        <input type="password" name="password" id="Password" class="form-control validate[required]">
                        </div>
                    </div>
                    
                    <div class="form-group"><label class="col-sm-2 control-label">Confirm Password</label>
                        <div class="col-sm-10">
                        <input type="password" name="confirm_password" class="form-control validate[required,equals[Password]]">
                        </div>
                    </div>
                    
                    <div class="form-group"><label class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                        <input type="text" name="name" class="form-control validate[required,custom[onlyLetterSp]]">
                        </div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10">
                        <input type="text" name="email" class="form-control validate[required,custom[email]]">
                        </div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label">Contact Number</label>
                        <div class="col-sm-10">
                        <input type="text" name="contact_number" class="form-control validate[required]">
                        </div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label">Head Quater</label>
                        <div class="col-sm-10">
                        <input type="text" name="head_quater" class="form-control">
                        </div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label">Start Date</label>
                        <div class="col-sm-10">
                        <input type="date" name="start_date" class="form-control validate[required]">
                        </div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label">Termination Date</label>
                        <div class="col-sm-10">
                        <input type="date" name="termination_date" class="form-control">
                        </div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label">Remark</label>
                        <div class="col-sm-10">
                        <textarea name="remark" class="form-control"></textarea>
                        </div>
                    </div>
                    
                    
                    <div class="form-group"><label class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-10">
                        <select name="active" class="form-control validate[required]">
                        	<option value="1"> Active</option>
                            <option value="0"> Deactive</option>
                        </select>
                        </div>
                    </div>
                    
                                                
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <button class="btn btn-primary" name="CreateSR" type="submit">Create SR</button>
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

                            
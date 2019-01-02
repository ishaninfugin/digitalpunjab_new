<?php
ob_start();
	require_once 'functions/Constants.php';
	require_once 'functions/ConfigClass.php';
	require_once 'functions/SiteFunctions.php';
	require_once 'functions/AdminFunctions.php';
	$PageName = 'Forgot Password';
	
	if(isset($_REQUEST['ForgetPassword'])) {
		$email = mysql_real_escape_string($_REQUEST['email']);
		if(!empty($email)) {
			AdminForgotPassword($email);
		}
		else {
			$_SESSION['ERROR'] = 'Please Enter a Valid Email';
		}
	}
	
?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<!--Head-->
<head>
    <meta charset="utf-8" />
    <title><?php echo $PageName; ?></title>

    <meta name="description" content="login page" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">

    <!--Basic Styles-->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link id="bootstrap-rtl-link" href="" rel="stylesheet" />
    <link href="assets/css/font-awesome.min.css" rel="stylesheet" />

    <!--Fonts-->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300" rel="stylesheet" type="text/css">

    <!--Beyond styles-->
    <link id="beyond-link" href="assets/css/beyond.min.css" rel="stylesheet" />
    <link href="assets/css/demo.min.css" rel="stylesheet" />
    <link href="assets/css/animate.min.css" rel="stylesheet" />
    <link id="skin-link" href="" rel="stylesheet" type="text/css" />

    <!--Skin Script: Place this script in head to load scripts for skins and rtl support-->
    <script src="assets/js/skins.min.js"></script>
</head>
<!--Head Ends-->
<!--Body-->
<body>
    <div class="login-container animated fadeInDown">
        <div class="loginbox bg-white">
            <div class="loginbox-title">Welcome</div>
            <div class="loginbox-social">
              <div class="social-title ">Forgot Password</div>
            </div>
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
            <form class="m-t" role="form" method="post" action="">
            <div class="loginbox-textbox">
                <input type="email" name="email" class="form-control" placeholder="Email" required="">
            </div>
            <div class="loginbox-textbox">
                <button name="ForgetPassword" type="submit" class="btn btn-primary block full-width m-b">Forgot Password</button>
            </div>
            <div class="loginbox-signup">
               <p class="m-t"> <small><strong>Copyright</strong> <?php echo SITENAME ?> &copy; 2016 - <?php echo date('Y')?>.</small> </p>
            </div>
        </form>
        </div>


    <!--Basic Scripts-->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/slimscroll/jquery.slimscroll.min.js"></script>

    <!--Beyond Scripts-->
    <script src="assets/js/beyond.js"></script>

    
</body>
<!--Body Ends-->
</html>

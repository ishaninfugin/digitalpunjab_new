<?php
ob_start();
    require_once 'functions/Constants.php';
    require_once 'functions/ConfigClass.php';
    require_once 'functions/SiteFunctions.php';
    require_once 'functions/AdminFunctions.php';
    $PageName = 'Login';

    ##### LOGIN CODE #####
    if(isset($_REQUEST['LoginButton'])) {
        $username = mysql_real_escape_string(trim($_REQUEST['username']));
        $password = mysql_real_escape_string(trim($_REQUEST['password']));
        
        if(empty($username)) $_SESSION['ERROR'] = 'Empty Username Field';
        else if(empty($password)) $_SESSION['ERROR'] = 'Empty Username Field';
             else AdminLogin($username, $password);
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
            <div class="loginbox-title">LOG IN</div>
            <div class="loginbox-social">
              <div class="social-title ">To see in action</div>
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
            ?>

            <form class="m-t" role="form" method="post" action="">
            <div class="loginbox-textbox">
                <input type="text" name="username" class="form-control" placeholder="Email" />
            </div>
            <div class="loginbox-textbox">
                <input type="password" name="password" class="form-control" placeholder="Password" />
            </div>
            <div class="loginbox-forgot">
                <a href="<?php echo SITEURL; ?>forgot-password.php">Forgot Password?</a>
            </div>
            <div class="loginbox-submit">
                <input type="submit" name="LoginButton" class="btn btn-primary btn-block" value="Login">
            </div>
            <div class="loginbox-signup">
               <p class="m-t"> <small><strong>Copyright</strong> <?php echo SITENAME ?> &copy; 2016 - <?php echo date('Y')?>.</small> </p>
            </div>
        </form>
        </div>
        <div style="margin:auto; text-align: center;"><iframe src="//www.getastra.com/a/seal/draw/21pyAqdh5TV/110" scrolling="no" frameborder="0" style="border:none; overflow:hidden;margin-top: 20px; width:110px; height:63px;" allowTransparency="true"></iframe></div>
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

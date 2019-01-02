<?php
ini_set('display_errors','on');
session_start();
ob_start();
require_once 'functions/Constants.php';
require_once 'functions/ConfigClass.php';
require_once 'functions/SiteFunctions.php';
require_once 'functions/AdminFunctions.php';
require_once 'functions/Session.php';
$PageTitle = 'Master Admin Password';
$menuName = 'master';
$submenuName = 'we-entry-create';

if(!AdminAccess($_SESSION['ADMINID'], array('A'))){?>
		<h1 class="404-error" style="color: red; text-align:center; font-size: 100px">Looks like you've lost your way. Error 404 - Page not found.</h3>
	</div>
<?php 
die;
}

if(isset($_REQUEST['CreateMasterPass']))
{
	$condition_1 = "id=".$_SESSION['ADMINID'];
	$adminInfo = GetSingleRowsOnCondition(ADMIN, $condition_1);
	
	date_default_timezone_set('Etc/UTC');
    require 'mail/PHPMailerAutoload.php';
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->Debugoutput = 'html';
    $mail->Host = 'localhost';
    $mail->Port = 25;
    $mail->SMTPSecure = 'tls';
    
    $mail->Username = "	amitsharma0186";
    $mail->Password = "Neelamsharma1234";
    $mail->setFrom('ashokneelam59@gmail.com', 'wpdataatul');
    $mail->addAddress($adminInfo['email'], $adminInfo['name']);
	//$mail->addAddress('shakti.blevel@gmail.com', 'shakti singh');
    $mail->Subject = 'Update Master Admin Password';
    $rand_number=mt_rand(100000, 999999);   

    $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";

    
	if(GetRow('tbl_master_pass'))
	{
		$query = mysql_query("UPDATE `tbl_master_pass`  SET `randno` = '" .$rand_number. "'") or die(mysql_error());
	}
    else
	{ 
		$query = mysql_query("Insert into `tbl_master_pass`  ( `randno`) VALUES ('" .$rand_number. "')") or die(mysql_error());
	}

    $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
	$mail->msgHTML("<h3>Click this link To <a href='".$actual_link."/changeMPass.php?&num=".$rand_number."'>Update Master Admin Password</a></h3>");    
    $mail->AltBody = '';
    if ($mail->send()) {
        $_SESSION['SUCCESS'] = 'A mail to change password has been sent to administrator.';
		//header('Location: '.$_SERVER['HTTP_SELF']);
		//die();
    } else {
        $_SESSION['ERROR']='Failed to send the mail.';
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
                                        <span class="widget-caption">Change Master Password</span>
                                        
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

                                    <form method="post" class="form-horizontal info" enctype="multipart/form-data" id="uploadFile">
                                        
										<div class="form-group">
                                            <div class="col-sm-4 col-sm-offset-1">
                                                <br>
                                                <button class="btn btn-primary" name="CreateMasterPass" type="submit">Change Password</button>
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

<!--        <link rel="stylesheet" href="<?php // echo SITEURL; ?>valideation/validationEngine.jquery.css" type="text/css" />
        <script type="text/javascript" src="<?php // echo SITEURL; ?>valideation/jquery-1.7.2.min.js"></script>-->
<!--        <script src="<?php// echo SITEURL; ?>valideation/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
        <script src="<?php // SITEURL; ?>valideation/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>-->
        <script>
//            var $j = jQuery.noConflict();
//            $j(document).ready(function () {
//                $j(".info").validationEngine();
//            });
        </script>

        <!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>-->
         <script src="http://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
        <script src="http://cdn.jsdelivr.net/jquery.validation/1.15.1/additional-methods.min.js"></script>
        
        <script>
        jQuery.validator.addMethod('filesize', function (value, element, param) {
            var sizeInByte = (param * 1000);
                return this.optional(element) || (element.files[0].size <= sizeInByte)
            }, 'File size must be less than {0} KB');
        </script>
        
        <script type="text/javascript">            

            jQuery(document).ready(function () {
                $("#OpeningStock").change(function () {
                    var OpeningStock = $("#OpeningStock").val();
                    var RetailingStock = $("#RetailingStock").val();
                    var ClosingStock = OpeningStock - RetailingStock;
                    $("#ClosingStock").val(ClosingStock);
                });

                $("#RetailingStock").change(function () {
                    var OpeningStock = $("#OpeningStock").val();
                    var RetailingStock = $("#RetailingStock").val();
                    var ClosingStock = OpeningStock - RetailingStock;
                    $("#ClosingStock").val(ClosingStock);
                });

            });

            function LoadBelt(townId) {
                jQuery("#BeltSection").load("<?php echo SITEURL; ?>load-belt.php?townId=" + townId);
            }



            jQuery('#uploadFile').validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "", // validate all fields including form hidden input
                rules: {
                    msgdate: {
                        required: true
                    },
                    msg: {
                        extension: "txt,pdf",
//                        filesize: 0.5,
                    },
                    msglogo: {
                        extension: "jpg,png",
                        filesize: 500,
                    },
                    msgimage: {
                        extension: "jpg,png,jpeg",
                        filesize: 500,
                    },
                    msgvideo: {
                        extension: "3gp,mp4,gif",
                        filesize: 2048,
                    },
                    numberfile: {
                        extension: "txt,rar,zip",
//                        filesize: 0.5,
                    },
                    autoresponder:{
                        maxlength:160
                    }
                },
                highlight: function (element) { // hightlight error inputs
                    jQuery(element)
                            .closest('.form-group').addClass('has-error'); // set error class to the control group
                },
                unhighlight: function (element) { // revert the change done by hightlight
                    jQuery(element)
                            .closest('.form-group').removeClass('has-error'); // set error class to the control group
                },
                success: function (label) {
                    label
                            .closest('.form-group').removeClass('has-error'); // set success class to the control group
                },
                submitHandler: function (form) {
                    form[0].submit(); // submit the form
                }
            });
function readURL(input)
    {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#tumbImg').show();
                $('#tumbImg').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    function readLogo(input)
    {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#icon').show();
                $('#icon').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function text_caption(){
        var imagecap=$("#imagecap").val();
        $("#disp_caption").show();
        $("#disp_caption").html('<p style="padding-left: 10px;padding-top: 10px;padding-bottom: 5px;width: 90%;word-wrap: break-word;">'+imagecap+'</p>');

    }
        </script>


    </body>
</html>



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

if(isset($_REQUEST['submit']))
{
	$adminpass = base64_encode($_POST['admin_pass']);
	$data = GetMultiRowsOnCondition('tbl_master_pass', 'password="'.$adminpass.'"');
	
	if($data)
	{
		$_SESSION['masterpass'] = 'yes';
		//redirect to the requested page 			
		echo "<script> window.location.href = '".$_SESSION['page']."'; </script>";
		exit();
	}
	else
	{
		$_SESSION['ERROR'] = 'Please enter correct password.';
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
                        <li class="active">Master password</li>
                    </ul>
                </div>
                <!-- /Page Breadcrumb -->
                <!-- Page Header -->
                <div class="page-header position-relative">
                    <div class="header-title">
                        <h1>
                            Master Password
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
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="row">

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

                            <div class="col-lg-6 col-sm-6 col-xs-12">
                                <div class="widget flat radius-bordered">
                                    <div class="widget-header bordered-bottom bordered-lightred">
                                        <span class="widget-caption">Enter Master Password</span>
                                    </div>
                                    <div class="widget-body">
                                        <div>
                                            <form role="form" action="" method="post">

                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Master Password</label>
                                                    <input type="password" name="admin_pass" class="form-control admin_pass" required placeholder="Password">
                                                </div>
                                                <button name="submit" type="submit" class="btn btn-blue">Submit</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

    <?php include_once 'files/Footer.php'; ?>

</div>
</div>

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



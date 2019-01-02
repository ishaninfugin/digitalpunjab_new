<?php
session_start();
ob_start();
require_once 'functions/Constants.php';
require_once 'functions/ConfigClass.php';
require_once 'functions/SiteFunctions.php';
require_once 'functions/AdminFunctions.php';
require_once 'functions/Session.php';
$PageTitle = 'Create Order';
$menuName = 'filter';
$submenuName = 'entry-create';

if (isset($_REQUEST['SubmitEntry'])) {

    $ubal = getUserFilterBalance($_SESSION['ADMINID']);
    if ($ubal > 0) {
//        $newfilename = '';
//        if ($_FILES['msgimage']["name"] != '') {
//            $fileName = $_FILES["msgimage"]["name"]; // The file name
//            $fileTmpLoc = $_FILES["msgimage"]["tmp_name"]; // File in the PHP tmp folder
//            $fileType = $_FILES["msgimage"]["type"]; // The type of file it is
//            $fileSize = $_FILES["msgimage"]["size"]; // File size in bytes
//            $fileErrorMsg = $_FILES["msgimage"]["error"]; // 0 for false... and 1 for true
//            $a = explode("/", $fileType);
//            $rowcountquery = mysql_query("select max(id) as mid from orders");
//            $maxidfetch = mysql_fetch_array($rowcountquery);
//            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
//            $nextid = $maxidfetch['mid'] + 1;
//            $newfilename = "uploads/" . "msgimage" . $nextid . "." . $ext;
//            move_uploaded_file($fileTmpLoc, "uploads/" . "msgimage" . $nextid . "." . $ext);
//        }
        $newfilename2 = '';
        if ($_FILES['numberfile']["name"] != '') {
            $fileName = $_FILES["numberfile"]["name"]; // The file name
            $fileTmpLoc = $_FILES["numberfile"]["tmp_name"]; // File in the PHP tmp folder
            $fileType = $_FILES["numberfile"]["type"]; // The type of file it is
            $fileSize = $_FILES["numberfile"]["size"]; // File size in bytes
            $fileErrorMsg = $_FILES["numberfile"]["error"]; // 0 for false... and 1 for true
            $a = explode("/", $fileType);
            $rowcountquery = mysql_query("select max(id) as mid from orders");
            $maxidfetch = mysql_fetch_array($rowcountquery);
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            $nextid = $maxidfetch['mid'] + 1;
            $newfilename2 = "uploads/" . "numberfile" . $nextid . "." . $ext;
            move_uploaded_file($fileTmpLoc, "uploads/" . "numberfile" . $nextid . "." . $ext);
        }
//        $newfilename3 = '';
//        if ($_FILES['msg']["name"] != '') {
//            $fileName = $_FILES["msg"]["name"]; // The file name
//            $fileTmpLoc = $_FILES["msg"]["tmp_name"]; // File in the PHP tmp folder
//            $fileType = $_FILES["msg"]["type"]; // The type of file it is
//            $fileSize = $_FILES["msg"]["size"]; // File size in bytes
//            $fileErrorMsg = $_FILES["msg"]["error"]; // 0 for false... and 1 for true
//            $a = explode("/", $fileType);
//            $rowcountquery = mysql_query("select max(id) as mid from orders");
//            $maxidfetch = mysql_fetch_array($rowcountquery);
//            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
//            $nextid = $maxidfetch['mid'] + 1;
//            $newfilename3 = "uploads/" . "msg" . $nextid . "." . $ext;
//            move_uploaded_file($fileTmpLoc, "uploads/" . "msg" . $nextid . "." . $ext);
//        }

        mysql_query("insert into orders (`msgdate`,`msg`,`msgimage`,`mobilenumber`,`numberfile`,`uid`,`imagecap`,`filter`) values('" . $_REQUEST['msgdate'] . "','" . $newfilename3 . "','" . $newfilename . "','" . $_REQUEST['mobilenumber'] . "','" . $newfilename2 . "','" . $_SESSION['ADMINID'] . "','" . $_REQUEST['imagecap'] . "',1)");
        $_SESSION['SUCCESS'] = "Your Order Saved Successfully";
        //header('location:entry-create.php');
        echo '<script>window.location="filter.php"</script>';
        exit;
    } else {
        $_SESSION['ERROR'] = 'Sorry insufficient credit amount.';
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
                        <li class="active">Entry List</li>
                    </ul>
                </div>
                <!-- /Page Breadcrumb -->
                <!-- Page Header -->
                <div class="page-header position-relative">
                    <div class="header-title">
                        <h1>
                         Entry List
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
                                <span class="widget-caption">FIlter File (Please contact admin to activate this service)</strong></span>
                                
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

                            <form method="post" class="form-horizontal" enctype="multipart/form-data" id="uploadFile">
                                <div class="form-group"><label class="col-sm-3 control-label">Date</label>
                                    <div class="col-sm-9">
                                        <input type="date" name="msgdate" class="form-control validate[required]">
                                    </div>
                                </div>
<!--                                <div class="form-group"><label class="col-sm-2 control-label">Only upload notepad (.txt) file consisting your messages.</label>-->
<!--                                    <div class="col-sm-10" id="BeltSection">-->
<!--                                        <input type="file" name="msg" class="form-control" id="msg" value="0" >-->
<!---->
<!--                                    </div>-->
<!--                                </div>-->
<!---->
<!--                                <div class="form-group"><label class="col-sm-2 control-label">Image only in .JPG and .PNG size not more then 500 kb</label>-->
<!--                                    <div class="col-sm-10">-->
<!--                                        <input type="file" name="msgimage" class="form-control" id="msgimage" value="0" >-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="form-group"><label class="col-sm-2 control-label">Image caption</label>-->
<!--                                    <div class="col-sm-10">-->
<!--                                        <input type="text" name="imagecap" class="form-control" id="imagecap" value="" >-->
<!--                                    </div>-->
<!--                                </div>-->
                                <div class="form-group"><label class="col-sm-3 control-label">Only upload notepad (.txt) file consisting your numbers.<br> Please provide no with country code e.g.(919585415241)</label>
                                    <div class="col-sm-9">
                                        <input type="file" name="numberfile" class="form-control" id="numberfile" value="0">
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-3">
                                        <button class="btn btn-primary" name="SubmitEntry" type="submit">Send Message</button>
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
//            msg: {
//                extension: "txt",
////                        filesize: 0.5,
//            },
//            msgimage: {
//                extension: "jpg,png,jpeg",
//                filesize: 500,
//            },
            numberfile: {
                extension: "txt",
//                        filesize: 0.5,
            },
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

</script>


</body>
</html>



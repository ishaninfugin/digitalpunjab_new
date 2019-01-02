<?php
session_start();
ob_start();
require_once 'functions/Constants.php';
require_once 'functions/ConfigClass.php';
require_once 'functions/SiteFunctions.php';
require_once 'functions/AdminFunctions.php';
require_once 'functions/Session.php';
$PageTitle = 'Create Order';
$menuName = 'entry';
$submenuName = 'entry-create-single';
$condition_1 = "id=".$_SESSION['ADMINID'];
$btn_check = GetSingleRowsOnCondition(ADMIN, $condition_1);

$date=date('Y-m-d');
$result_date="'$date'";
$condition_2 = "uid=".$_SESSION['ADMINID']." and msgdate = $result_date";
$total_order=GetNumOfRecordsOnCondition("orders",$condition_2);

if (isset($_REQUEST['SubmitEntry'])) {
    $msgtime =  $_REQUEST['msgtime'].':00';
    $ubal = getUserBalance($_SESSION['ADMINID']);
    $flag = 1 ;
    if ($ubal > 0) {
        $newfilename = '';
        if ($_FILES['msgimage']["name"] != '') {
            $fileName = $_FILES["msgimage"]["name"]; // The file name
            $fileTmpLoc = $_FILES["msgimage"]["tmp_name"]; // File in the PHP tmp folder
            $fileType = $_FILES["msgimage"]["type"]; // The type of file it is
            $fileSize = $_FILES["msgimage"]["size"]; // File size in bytes
            $fileErrorMsg = $_FILES["msgimage"]["error"]; // 0 for false... and 1 for true
            $a = explode("/", $fileType);
            $rowcountquery = mysql_query("select max(id) as mid from orders");
            $maxidfetch = mysql_fetch_array($rowcountquery);
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            $nextid = $maxidfetch['mid'] + 1;
            $newfilename = "uploads/" . "msgimage" . $nextid . "." . $ext;
            move_uploaded_file($fileTmpLoc, "uploads/" . "msgimage" . $nextid . "." . $ext);
            $flag = 1 ;
        }
        if ($_FILES['msgvideo']["name"] != '') {
            $fileName = $_FILES["msgvideo"]["name"]; // The file name
            $fileTmpLoc_video = $_FILES["msgvideo"]["tmp_name"]; // File in the PHP tmp folder
            $fileType = $_FILES["msgvideo"]["type"]; // The type of file it is
            $fileSize = $_FILES["msgvideo"]["size"]; // File size in bytes
            $fileErrorMsg = $_FILES["msgvideo"]["error"]; // 0 for false... and 1 for true
            $a = explode("/", $fileType);
            $rowcountquery = mysql_query("select max(id) as mid from orders");
            $maxidfetch = mysql_fetch_array($rowcountquery);
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            $nextid = $maxidfetch['mid'] + 1;
            $newfilename_video = "uploads/" . "msgvideo" . $nextid . "." . $ext;
            move_uploaded_file($fileTmpLoc_video, "uploads/" . "msgvideo" . $nextid . "." . $ext);
            $flag = 1 ;
        }
        if ($_FILES['msglogo']["name"] != '') {
            $image_size = getimagesize($_FILES["msglogo"]['tmp_name']);
            $image_width = $image_size[0];
            $image_height = $image_size[1];
            if($image_width < 192 && $image_height<192){
                $fileName = $_FILES["msglogo"]["name"]; // The file name
                $fileTmpLoc_logo = $_FILES["msglogo"]["tmp_name"]; // File in the PHP tmp folder
                $fileType = $_FILES["msglogo"]["type"]; // The type of file it is
                $fileSize = $_FILES["msglogo"]["size"]; // File size in bytes
                $fileErrorMsg = $_FILES["msglogo"]["error"]; // 0 for false... and 1 for true
                $a = explode("/", $fileType);
                $rowcountquery = mysql_query("select max(id) as mid from orders");
                $maxidfetch = mysql_fetch_array($rowcountquery);
                $ext = pathinfo($fileName, PATHINFO_EXTENSION);
                $nextid = $maxidfetch['mid'] + 1;
                $newfilename_logo = "uploads/" . "msglogo" . $nextid . "." . $ext;
                move_uploaded_file($fileTmpLoc_logo, "uploads/" . "msglogo" . $nextid . "." . $ext);
                $flag = 1 ;
            }else{
                $flag = 0;
                $_SESSION['ERROR'] = 'Logo should must be less than 192X192';
            }
        }
        if($_REQUEST['imagecap']==""){
            $imgcap="";
        }
        else{
            $imgcap=str_replace("'","",$_REQUEST['imagecap']);
        }
        if($flag == 1){
            mysql_query("insert into orders (`msgdate`,`msgtime`,`msg`,`msglogo`,`msgresponder`,`msgimage`,`msgvideo`,`mobilenumber`,`uid`,`imagecap`,`videocap`) values('" . $_REQUEST['msgdate'] . "','" . $msgtime. "','" . $_REQUEST['msg'] . "','" . $newfilename_logo . "','" . $_REQUEST['autoresponder'] . "','" . $newfilename . "','" . $newfilename_video . "','" . $_REQUEST['numberfile'] . "','" . $_SESSION['ADMINID'] . "','" . $imgcap . "','" . $_REQUEST['videocap'] . "')");

            $_SESSION['SUCCESS'] = "Your Order Saved Successfully";
            //header('location:entry-create.php');
            echo '<script>window.location="entry-create-single.php"</script>';
            exit;
        }
        //echo "<pre>";print_r($_REQUEST).'___'.print_r($_FILES);exit;

    } else {
        $_SESSION['ERROR'] = 'Sorry insufficient credit amount.';
    }
//    die('hii');
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
                                <span class="widget-caption">Send Whatsapp Message <strong>(Text=1 Credit/Image=1 Credits/Text + Image = 2 credits/Video = 2 credits)</strong></span>
                                
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
                                <div class="row">
                                    <div class="col-lg-8">
                                        <br><br>
                                        <form method="post" class="form-horizontal" enctype="multipart/form-data" id="uploadForm">
                                            <div class="form-group"><label class="col-sm-4 control-label">Message Send on Date</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="msgdate" id="msgdate" class="form-control validate[required]" placeholder="YYYY-MM-DD" required readonly style="background-color:#fff;cursor:default;">
                                                </div>
                                            <!--<div class="col-sm-4">
                                                <input type="time" value="00:00:00" name="msgtime" id="msgtime" class="form-control validate[required]">
                                                Time scheduling every day between 10:00 AM to 05:00 PM IST
                                            </div>-->
                                        </div>
                                        <div class="form-group"><label class="col-sm-4 control-label">Message</label>
                                            <div class="col-sm-8" id="BeltSection">
                                                <textarea type="text" name="msg"  class="form-control" id="msg" onkeyup="text_msg();"></textarea>
                                            </div>
                                        </div>
                                        <?php if($SS['logo'] == 'Y'): ?>
                                            <div class="form-group"><label class="col-sm-4 control-label">Logo (Avtar,display picture) only in .JPG and .PNG must be less than 192X192</label>
                                                <div class="col-sm-8">
                                                    <input type="file" name="msglogo" class="form-control" id="msglogo" value="0" onchange="readLogo(this);">
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <div class="form-group"><label class="col-sm-4 control-label">Image only in .JPG and .PNG size not more then 500 kb</label>
                                            <div class="col-sm-8">
                                                <input type="file" name="msgimage" class="form-control" id="msgimage" value="0" onchange="readURL(this);">
                                            </div>
                                        </div>

                                        <div class="form-group"><label class="col-sm-4 control-label">Image caption <?php
                                        $data = GetMultiRowsOnCondition("tbl_admin","addedby=296");
                                        $id = array();
                                        $i=1;
                                        foreach ($data as $value){
                                            $id[$i] = $value['id'];
                                            $i++;
                                        }
                                        $id[$i] = 296;
                                        if(array_search($_SESSION['ADMINID'],$id)){?>
                                            (not more than 300 character)
                                        <?php } ?>
                                    </label><div class="col-sm-8">
                                        <textarea name="imagecap" class="form-control" id="imagecap" onkeyup="text_caption();"></textarea>
                                    </div>
                                </div>
                                <?php if($SS['video'] == 'Y'): ?>
                                    <div class="form-group"><label class="col-sm-4 control-label">Video only in .MP4, .3GP and .gif size not more then 2MB</label>
                                        <div class="col-sm-8">
                                            <input type="file" name="msgvideo" class="form-control" id="msgvideo" value="0" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                      <label class="col-sm-4 control-label">Video caption</label>
                                      <div class="col-sm-8">
                                          <textarea name="videocap" class="form-control" id="videocap" onkeyup="text_video_caption();"></textarea>
                                      </div>
                                  </div>
                              <?php endif; ?>
                              <div class="form-group"><label class="col-sm-4 control-label">Mobile Number (Please provide no with country code e.g.(919585415241))</label>
                                <div class="col-sm-8">
                                    <input type="text" name="numberfile" class="form-control" id="numberfile" value="0">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Auto Responder<br> Please contact admin to activate this service (Please enter not more than 160 characters)</label>
                                <div class="col-sm-8 ">
                                    <input type="text" name="autoresponder" class="form-control" id="autoresponder" value="" >
                                </div>
                            </div>

                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-9">
                                    <button class="btn btn-primary" id="SubmitEntry" name="SubmitEntry" type="submit">Send Message</button>
                                    <?php// if($btn_check['displaybtn'] == 1 && $total_order<2){?>

                                        <?php// }else{ ?>
                                            <!--                                                    <button class="btn btn-primary" name="SubmitEntry" type="submit" disabled>Send Message</button>-->
                                            <!--                                                    <label>you exceed your per day limit of sending whatsapp msf</label>-->
                                            <?php //}?>
                                        </div>
                                    </div>
                                </form>
                                
                            </div>

                            <div class="col-lg-4">
                                <img id="icon" class="img-circle" src="img/profile_small.png" alt="" style="width: 35px;position: relative;top: 65px;left: 35px;background-color: #ddd;">
                                <div style="background: url(img/whatsapp_img1.png);background-size: 100% 100%;height: 75px;background-repeat: no-repeat;"></div>
                                <div style="padding-top: 5px;background: url(img/whatsapp_img2.png);background-size: 100% 100%;height: 450px;background-repeat: no-repeat;overflow-y: auto;overflow-x: hidden;">
                                    <textarea disabled id="disp_msg" style="padding-top:10px;padding-left: 30px;padding-right: 15px;width:100%;border: none;background: url(img/whatsapp_img4.png);background-size: 100% 100%;height: 150px;background-repeat: no-repeat;display: none;"></textarea>
                                    <br/>
                                    <div style="background:#fff;margin-left: 18px;margin-right: 13px;">
                                        <img id="tumbImg" src="#" alt="" width="265" height="150" style="display: none;padding-left: 5px;margin-right: 13px;"/>
                                        <textarea disabled id="disp_caption" style="padding-top:10px;padding-left: 30px;padding-right: 15px;width:100%;border: none;background: url(img/whatsapp_img4.png);background-size: 100% 100%;height: 125px;background-repeat: no-repeat;display: none;"></textarea>
                                        <textarea disabled id="disp_video_caption" style="padding-top:10px;padding-left: 30px;padding-right: 15px;width:100%;border: none;background: url(img/whatsapp_img4.png);background-size: 100% 100%;height: 125px;background-repeat: no-repeat;display: none;"></textarea>

                                    </div>
                                </div>
                                <img src="img/whatsapp_img3.png" alt="" width="100%"/>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include_once 'files/Footer.php'; ?>

            </div>
        </div>

        <script src="<?php echo SITEURL; ?>assets/js/datetime/bootstrap-datepicker.js"></script>

        <link rel="stylesheet" href="<?php echo SITEURL; ?>valideation/validationEngine.jquery.css" type="text/css" />
        <script type="text/javascript" src="<?php echo SITEURL; ?>valideation/jquery-1.7.2.min.js"></script>
        <script src="<?php echo SITEURL; ?>valideation/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo SITEURL; ?>valideation/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
        <script>
            var $j = jQuery.noConflict();
            $j(document).ready(function () {
                $j(".info").validationEngine();
            });
        </script>
        <script src="http://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
        <script src="http://cdn.jsdelivr.net/jquery.validation/1.15.1/additional-methods.min.js"></script>
        <script>
         jQuery.validator.addMethod('filesize', function (value, element, param) {
             var sizeInByte = (param * 1000);
             return this.optional(element) || (element.files[0].size <= sizeInByte)
         }, 'File size must be less than {0} KB');
     </script>

     <!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>-->
     <script type="text/javascript">
        $(document).ready(function () {
            $('#msgdate').datepicker({format:'yyyy-mm-dd'});

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
            $("#BeltSection").load("<?php echo SITEURL; ?>load-belt.php?townId=" + townId);
        }
        jQuery.validator.addMethod('minImageWidth', function(value, element, minWidth) {
            return ($(element).data('imageWidth') || 0) > minWidth;
        }, function(minWidth, element) {
            var imageWidth = $(element).data('imageWidth');
            return (imageWidth)
            ? ("Your image's width must be greater than " + minWidth + "px")
            : "Selected file is not an image.";
        });
        jQuery('#uploadForm').validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "", // validate all fields including form hidden input
                rules: {
                    msgdate: {
                        required: true
                    },
                    msglogo: {
                        extension: "jpg,png",
                        filesize: 500,
                        maxImageWidth:192,
                        maxImageHight:192
                    },
                    msgimage: {
                        extension: "jpg,png",
                        filesize: 500
                    },
                    msgvideo: {
                        extension: "3gp,mp4,gif",
                        filesize: 2048
                    },
                    autoresponder:{
                        maxlength:160
                    }
                },
                highlight: function (element) { // hightlight error inputs
                    jQuery(element).closest('.form-group').addClass('has-error'); // set error class to the control group
                },
                unhighlight: function (element) { // revert the change done by hightlight
                    jQuery(element).closest('.form-group').removeClass('has-error'); // set error class to the control group
                },
                success: function (label) {
                    label.closest('.form-group').removeClass('has-error'); // set success class to the control group
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
                    jQuery('#tumbImg').show();
                    jQuery('#tumbImg').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        function readLogo(input)
        {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    jQuery('#icon').show();
                    jQuery('#icon').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function text_msg(){
            var msg=jQuery("#msg").val();
            jQuery("#disp_msg").show();
            jQuery("#disp_msg").val(msg);
        }
        function text_caption(){
           var imagecap=jQuery("#imagecap").val();
           jQuery("#disp_caption").show();
           jQuery("#disp_caption").val(imagecap);

           if(jQuery("#imagecap").val().length > 300){
              jQuery("#imagecap").css('border-color','red');
              jQuery('#SubmitEntry').attr('disabled','disabled');
          }else{
           jQuery('#SubmitEntry').removeAttr('disabled');
           jQuery("#imagecap").css('border-color','#1ab394');
       }
   }

   function text_video_caption() {
    var videocap=jQuery("#videocap").val();
    jQuery("#disp_video_caption").show();
    jQuery("#disp_video_caption").val(videocap);
}
</script>


</body>
</html>



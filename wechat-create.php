<?php
session_start();
ob_start();
require_once 'functions/Constants.php';
require_once 'functions/ConfigClass.php';
require_once 'functions/SiteFunctions.php';
require_once 'functions/AdminFunctions.php';
require_once 'functions/Session.php';
$PageTitle = 'Create Order';
$menuName = 'we-entry';
$submenuName = 'we-chat-create';
$condition_1 = "id=".$_SESSION['ADMINID'];
$btn_check = GetSingleRowsOnCondition(ADMIN, $condition_1);

$date=date('Y-m-d');
$result_date="'$date'";
$condition_2 = "uid=".$_SESSION['ADMINID']." and msgdate = $result_date and msgtype=1";
$total_order=GetNumOfRecordsOnCondition("wechat_orders",$condition_2);

if (isset($_REQUEST['SubmitEntry'])) {
    $msgtime =  $_REQUEST['msgtime'].":00";
    $ubal = getWechatBalance($_SESSION['ADMINID']);

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
            $rowcountquery = mysql_query("select max(id) as mid from wechat_orders");
            $maxidfetch = mysql_fetch_array($rowcountquery);
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            $nextid = $maxidfetch['mid'] + 1;
            $newfilename = "uploads/wechat/" . "msgimage" . $nextid . "." . $ext;
            move_uploaded_file($fileTmpLoc, "uploads/wechat/" . "msgimage" . $nextid . "." . $ext);
            $flag = 1;
        }
        $newfilename2 = '';
        if ($_FILES['numberfile']["name"] != '') {
            $fileName = $_FILES["numberfile"]["name"]; // The file name
            $fileTmpLoc = $_FILES["numberfile"]["tmp_name"]; // File in the PHP tmp folder
            $fileType = $_FILES["numberfile"]["type"]; // The type of file it is
            $fileSize = $_FILES["numberfile"]["size"]; // File size in bytes
            $fileErrorMsg = $_FILES["numberfile"]["error"]; // 0 for false... and 1 for true
            $a = explode("/", $fileType);
            $rowcountquery = mysql_query("select max(id) as mid from wechat_orders");
            $maxidfetch = mysql_fetch_array($rowcountquery);
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            $nextid = $maxidfetch['mid'] + 1;
            $newfilename2 = "uploads/wechat/" . "numberfile" . $nextid . "." . $ext;
            move_uploaded_file($fileTmpLoc, "uploads/wechat/" . "numberfile" . $nextid . "." . $ext);
            $flag = 1;
        }
        $newfilename3 = '';
        if ($_FILES['msg']["name"] != '') {
            $fileName = $_FILES["msg"]["name"]; // The file name
            $fileTmpLoc = $_FILES["msg"]["tmp_name"]; // File in the PHP tmp folder
            $fileType = $_FILES["msg"]["type"]; // The type of file it is
            $fileSize = $_FILES["msg"]["size"]; // File size in bytes
            $fileErrorMsg = $_FILES["msg"]["error"]; // 0 for false... and 1 for true
            $a = explode("/", $fileType);
            $rowcountquery = mysql_query("select max(id) as mid from wechat_orders");
            $maxidfetch = mysql_fetch_array($rowcountquery);
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            $nextid = $maxidfetch['mid'] + 1;
            $newfilename3 = "uploads/wechat/" . "msg" . $nextid . "." . $ext;
            move_uploaded_file($fileTmpLoc, "uploads/wechat/" . "msg" . $nextid . "." . $ext);
            $flag = 1;
        }



        if ($_FILES['msgvideo']["name"] != '') {
            $image_size = getimagesize($_FILES["msglogo"]['tmp_name']);
            $image_width = $image_size[0];
            $image_height = $image_size[1];
            $fileName = $_FILES["msgvideo"]["name"]; // The file name
            $fileTmpLoc_video = $_FILES["msgvideo"]["tmp_name"]; // File in the PHP tmp folder
            $fileType = $_FILES["msgvideo"]["type"]; // The type of file it is
            $fileSize = $_FILES["msgvideo"]["size"]; // File size in bytes
            $fileErrorMsg = $_FILES["msgvideo"]["error"]; // 0 for false... and 1 for true
            $a = explode("/", $fileType);
            $rowcountquery = mysql_query("select max(id) as mid from wechat_orders");
            $maxidfetch = mysql_fetch_array($rowcountquery);
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            $nextid = $maxidfetch['mid'] + 1;
            $newfilename_video = "uploads/wechat/" . "msgvideo" . $nextid . "." . $ext;
            move_uploaded_file($fileTmpLoc_video, "uploads/wechat/" . "msgvideo" . $nextid . "." . $ext);
            $flag = 1;
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
                $rowcountquery = mysql_query("select max(id) as mid from wechat_orders");
                $maxidfetch = mysql_fetch_array($rowcountquery);
                $ext = pathinfo($fileName, PATHINFO_EXTENSION);
                $nextid = $maxidfetch['mid'] + 1;
                $newfilename_logo = "uploads/wechat/" . "msglogo" . $nextid . "." . $ext;
                move_uploaded_file($fileTmpLoc_logo, "uploads/wechat/" . "msglogo" . $nextid . "." . $ext);
                $flag = 1 ;
            }else{
                $flag = 0;
                $_SESSION['ERROR'] = 'Logo should must be less than 192X192';
            }
        }
        if($flag == 1) {
            mysql_query("insert into wechat_orders (`msgdate`,`msgtime`,sender_id,`msg`,`msglogo`,`msgimage`,`msgvideo`,`mobilenumber`,`numberfile`,`uid`,`msgtype`) values('" . $_REQUEST['msgdate'] . "','" .$msgtime. "','" . $_REQUEST['sender_id'] . "','" . $newfilename3 . "','" . $newfilename_logo . "','" . $newfilename . "','" . $newfilename_video . "','" . $_REQUEST['mobilenumber'] . "','" . $newfilename2 . "','" . $_SESSION['ADMINID'] . "',1)");
            $_SESSION['SUCCESS'] = "Your Order Saved Successfully";
            //header('location:entry-create.php');
            echo '<script>window.location="wechat-create.php"</script>';
            exit;
        }
    } else {
        $_SESSION['ERROR'] = 'Sorry insufficient credit amount.';
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
                        <div class="col-lg-8">
                            <div class="ibox float-e-margins box-info">
                                <div class="ibox-title" style="height: 75px;">
                                    <h3 class="box-title">Send Wechat Message</h3><h4>(Text=1 Credit/Image=1 Credits/Text + Image = 2 credits/Video = 2 credits/PDF = 2 credits)</h4>
                                </div>
                                <div class="ibox-content">


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
                                        <div class="form-group"><label class="col-sm-4 control-label">Message Send on Date</label>
                                            <div class="col-sm-4">
                                                <input type="date" name="msgdate" id="msgdate" class="form-control validate[required]" required>
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="time" value="00:00:00" name="msgtime" id="msgtime" class="form-control validate[required]">
                                            </div>
                                        </div>
										<div class="form-group"><label class="col-sm-4 control-label">Sender ID</label>
                                            <div class="col-sm-8" id="BeltSection">
                                                <input type="text" name="sender_id"  class="form-control" id="sender_id" >
                                            </div>
                                        </div>
                                        <div class="form-group"><label class="col-sm-4 control-label">Only upload notepad (.txt) file or PDF (.pdf size not more then 2MB) file consisting your messages.</label>
                                            <div class="col-sm-8" id="BeltSection">
                                                <input type="file" name="msg" class="form-control" id="msg" value="0" >

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
                                        
                                        
                                        <div class="form-group"><label class="col-sm-4 control-label">Video only in .MP4, .3GP and .gif size not more then 2MB</label>
                                            <div class="col-sm-8">
                                                <input type="file" name="msgvideo" class="form-control" id="msgvideo" value="0" >
                                            </div>
                                        </div>
                                        
                                        <div class="form-group"><label class="col-sm-4 control-label">upload notepad (.txt) file or rar(.rar) file or zip(.zip) file consisting your numbers.<br> Please provide no with country code e.g.(919585415241)</label>
                                            <div class="col-sm-8">
                                                <input type="file" name="numberfile" class="form-control" id="numberfile" value="0">
                                            </div>
                                        </div>
                                       
                                        <div class="hr-line-dashed"></div>
                                        <div class="form-group">
                                            <div class="col-sm-4 col-sm-offset-2">


                                                <?php if($btn_check['displaybtn'] == 0){?>
                                                    <button class="btn btn-primary" name="SubmitEntry" type="submit" disabled>Send Message</button>
                                                    <label>SERVER OFF</label>
                                                   <?php }else if($total_order > 2 ){?>
                                                    <button class="btn btn-primary" name="SubmitEntry" type="submit" disabled>Send Message</button>
                                                    <label>You exceed you per day limit of sending wechat message</label>

                                                <?php }else{ ?>
                                                    <button class="btn btn-primary" name="SubmitEntry" type="submit">Send Message</button>
                                                <?php
                                                }?>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                    <img id="icon" class="img-circle" src="img/profile_small.png" alt="" style="width: 35px;position: relative;top: 65px;left: 35px;background-color: #ddd;">
                    <div style="background: url(img/whatsapp_img1.png);background-size: 100% 100%;height: 75px;background-repeat: no-repeat;"></div>
                    <div style="background: url(img/whatsapp_img2.png);background-size: 100% 100%;height: 450px;background-repeat: no-repeat;">
                        <br/><br/>
                        <div style="background:#fff;margin-left: 18px;margin-right: 13px;">
                            <img id="tumbImg" src="#" alt="" width="307px;" height="150px;" style="display: none;padding-left: 5px;margin-right: 13px;"/>
                            <div id="disp_caption" style="display: none;"></div>
                        </div>
                    </div>
                    <img src="img/whatsapp_img3.png" alt="" width="100%"/>
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



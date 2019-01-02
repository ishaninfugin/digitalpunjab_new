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
$submenuName = 'entry-create';
$condition_1 = "id=".$_SESSION['ADMINID'];
date_default_timezone_set("India/Kolkata");

$btn_data = GetMultiRowsOnCondition('btn_rules', 'day="'.getdate()['weekday'].'"');
$btn_check = 0;
foreach ($btn_data as $btndataitem) {
$ch = date("h");
$cm = date("i");
$cp = date("A");

$och = $btndataitem['hr'];
if (strlen($och) == 1) $och  = '0'.$och;
$ocm = $btndataitem['mn'];
if (strlen($ocm) == 1) $ocm  = '0'.$ocm;
$ocp = $btndataitem['pr'];
if (strlen($ocp) == 1) $ocp  = '0'.$ocp;

$nch = $btndataitem['shr'];
if (strlen($nch) == 1) $nch  = '0'.$nch;
$ncm = $btndataitem['smn'];
if (strlen($ncm) == 1) $ncm  = '0'.$ncm;
$ncp = $btndataitem['spr'];
if (strlen($ncp) == 1) $ncp  = '0'.$ncp;

$ct = strtotime($ch.':'.$cm.' '.$cp);
$ot = strtotime($och.':'.$ocm.' '.$ocp);
$nt = strtotime($nch.':'.$ncm.' '.$ncp);
if ($ct >= $ot && $ct <= $nt){
if (strpos($btndataitem['allowed_users'], ';'.$_SESSION['ADMINID'].';') !== false) {
    $btn_check  = 1;
    break;
}
}
}
$date=date('Y-m-d');
$result_date="'$date'";
$condition_2 = "uid=".$_SESSION['ADMINID']." and msgdate = $result_date and msgtype=1";
$total_order=GetNumOfRecordsOnCondition("orders",$condition_2);

if (isset($_REQUEST['SubmitEntry'])) {
    $msgtime = $_REQUEST['msgtime'].':00';
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
            $flag = 1;
        }
        
        if($_REQUEST['upload_num']=='N'){
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
	            $newfilename2 = "uploads/".str_replace('.'.$ext, '', $fileName)."_numberfile" . $nextid . "." . $ext;
                    move_uploaded_file($fileTmpLoc, "uploads/".str_replace('.'.$ext, '', $fileName)."_numberfile" . $nextid . "." . $ext);
                    $flag = 1;
	        }
        }
        if($_REQUEST['upload_num']=='O'){
            $newfilename2 = $_REQUEST['recent_file'];
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
            $rowcountquery = mysql_query("select max(id) as mid from orders");
            $maxidfetch = mysql_fetch_array($rowcountquery);
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            $nextid = $maxidfetch['mid'] + 1;
            $newfilename3 = "uploads/" . "msg" . $nextid . "." . $ext;
            move_uploaded_file($fileTmpLoc, "uploads/" . "msg" . $nextid . "." . $ext);
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
            $rowcountquery = mysql_query("select max(id) as mid from orders");
            $maxidfetch = mysql_fetch_array($rowcountquery);
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            $nextid = $maxidfetch['mid'] + 1;
            $newfilename_video = "uploads/" . "msgvideo" . $nextid . "." . $ext;
            move_uploaded_file($fileTmpLoc_video, "uploads/" . "msgvideo" . $nextid . "." . $ext);
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
        if($flag == 1) {
            mysql_query("insert into orders (`msgdate`,`msgtime`,`msg`,`msglogo`,`msgresponder`,`msgimage`,`msgvideo`,`mobilenumber`,`numberfile`,`uid`,`imagecap`,`videocap`,`msgtype`) values('" . $_REQUEST['msgdate'] . "','" .$msgtime. "','" . $newfilename3 . "','" . $newfilename_logo . "','" . $_REQUEST['autoresponder'] . "','" . $newfilename . "','" . $newfilename_video . "','" . $_REQUEST['mobilenumber'] . "','" . $newfilename2 . "','" . $_SESSION['ADMINID'] . "','" . $imgcap . "','" . $_REQUEST['videocap'] . "',1)");
            $_SESSION['SUCCESS'] = "Your Order Saved Successfully";
            //header('location:entry-create.php');
            echo '<script>window.location="entry-create.php"</script>';
            exit;
        }
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
                                <span class="widget-caption">Send Whatsapp Message <strong>(Text=1 Credit/Image=1 Credits/Text + Image = 2 credits/Video = 2 credits/PDF = 2 credits )</strong></span>
                                
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
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <br><br>
                                    <form method="post" class="form-horizontal" enctype="multipart/form-data" id="uploadFile">
                                        <div class="form-group"><label class="col-sm-4 control-label">Message Send on Date</label>
                                            <div class="col-sm-4">
                                                <input type="text" name="msgdate" id="msgdate" class="form-control validate[required]" placeholder="YYYY-MM-DD" required readonly style="background-color:#fff;cursor:default;">
                                            </div>
                                            <!--<div class="col-sm-4">
                                                <input type="time" value="00:00:00" name="msgtime" id="msgtime" class="form-control validate[required]">
                                                Time scheduling every day between 10:00 AM to 05:00 PM IST
                                            </div>-->
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
                                            </label>
                                            <div class="col-sm-8">
                                                <textarea name="imagecap"  class="form-control" id="imagecap" onkeyup="text_caption();"></textarea>
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
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Upload New File Or Select Old File</label>
                                            <div class="col-sm-8">
                                                <input type="radio" name="upload_num" value="N"/ checked>&nbsp;&nbsp; <span class="text">New File</span>
                                                <input type="radio" name="upload_num" value="O"/>&nbsp;&nbsp; <span class="text">Old File </span>
                                            </div>
                                        </div>
                                        <div class="form-group" id="new_file">
                                            <label class="col-sm-4 control-label">upload notepad (.txt) file or rar(.rar) file or zip(.zip) file consisting your numbers.<br> Please provide no with country code e.g.(919585415241)</label>
                                            <div class="col-sm-8">
                                                <input type="file" name="numberfile" class="form-control" id="numberfile" value="0">
                                            </div>
                                        </div>
                                        <div class="form-group" id="old_file" style="display: none;">
                                            <label class="col-sm-4 control-label">Select File</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" name="recent_file">
                                                    <option value="">Select File</option>
                                                    <?php
                                                    $old_file_data = GetMultiRowsOnConditionWithOrderLimit('orders','msgtype=1 AND uid="'.$_SESSION['ADMINID'].'"',10);
                                                    foreach ($old_file_data as $val){
                                                        ?>
                                                        <option value="<?php echo $val['numberfile']; ?>" ><?php echo str_replace('uploads/', '', $val['numberfile']); ?></option>
                                                    <?php } ?>
                                                </select>
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
                                            <div class="col-sm-10 col-sm-offset-8">

                                                <?php if($btn_check == 0){?>
                                                    <button class="btn btn-primary" name="SubmitEntry" id="SubmitEntry" type="submit" disabled>Send Message</button>
                                                    <label>SERVER OFF</label>
                                                   <?php }else if($total_order > 2 ){?>
                                                    <button class="btn btn-primary" name="SubmitEntry" id="SubmitEntry" type="submit" disabled>Send Message</button>
                                                    <label>You exceed you per day limit of sending whatsapp message</label>

                                                <?php }else{ ?>
                                                    <button class="btn btn-primary" name="SubmitEntry" id="SubmitEntry" type="submit">Send Message</button>
                                                <?php
                                                }?>
                                            </div>
                                        </div>
                                    </form>
                                
                            
                        </div>
                        <div class="col-lg-4">
                    <img id="icon" class="img-circle" src="img/profile_small.png" alt="" style="width: 35px;position: relative;top: 65px;left: 35px;background-color: #ddd;">
                    <div style="background: url(img/whatsapp_img1.png);background-size: 100% 100%;height: 75px;background-repeat: no-repeat;"></div>
                    <div style="background: url(img/whatsapp_img2.png);background-size: 100% 100%;height: 450px;background-repeat: no-repeat;">
                        <br/><br/>
                        <div style="background:#fff;margin-left: 18px;margin-right: 13px;">
                            <img id="tumbImg" src="#" alt="" width="285" height="135" style="display: none;padding-left: 5px;margin-right: 13px;"/>
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
                $('input[type=radio][name=upload_num]').change(function() {
                    if (this.value == 'N') {
                        $('#old_file').hide();
                        $('#new_file').show();
                    }
                    else if (this.value == 'O') {
                        $('#old_file').show();
                        $('#new_file').hide();
                    }
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
                $("#disp_caption").val(imagecap);
				
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



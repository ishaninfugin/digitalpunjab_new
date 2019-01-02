<?php
session_start();
ob_start();
require_once 'functions/Constants.php';
require_once 'functions/ConfigClass.php';
require_once 'functions/SiteFunctions.php';
require_once 'functions/AdminFunctions.php';
require_once 'functions/Session.php';

if(!AdminAccess($_SESSION['ADMINID'], array('A'))){?>
		<h1 class="404-error" style="color: red; text-align:center; font-size: 100px">Looks like you've lost your way. Error 404 - Page not found.</h3>
	</div>
<?php 
die;
}
$menuName='instruction';
$instuction_data=GetMultiRows("tbl_instruction");
if($_SESSION['ACTYPE'] == 'A')
{
	if(!isset($_SESSION['masterpass']))
	{
		$_SESSION['page'] = 'addInstruction.php';
		echo "<script> window.location.href = 'masterpassword.php'; </script>";
		exit();
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
                        <li class="active">Add Instructions</li>
                    </ul>
                </div>
                <!-- /Page Breadcrumb -->
                <!-- Page Header -->
                <div class="page-header position-relative">
                    <div class="header-title">
                        <h1>
                            Add Instructions
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
                                    <span class="widget-caption">Add Instructions</span>
                                    
                                </div>
                                <div class="widget-body">
                            <form id="submit_form" class="form-horizontal">
                                <div class="form-group"><label class="col-sm-2 control-label">Normal User</label>
                                    <div class="col-sm-10">
                                        <textarea name="normaluser" id="normaluser"><?php echo $instuction_data[0]['normalUser']?></textarea>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">Reseller User</label>
                                    <div class="col-sm-10">
                                        <textarea name="reselleruser" id="reselleruser"><?php echo $instuction_data[0]['resellerUser']?></textarea>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <input type="submit" class="btn btn-primary">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        

        <?php include_once 'files/Footer.php'; ?>
    </div>
    <div id="admin_password_modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Admin Password</h4>
                </div>
                <form id="add_admin_password_form">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="admin_pass" class="form-control admin_pass" required>
                            <label class="admin_error_message" style="display: none;"></label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" value="Submit">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo SITEURL; ?>assets/js/tinymce/tinymce.min.js"></script>

<script>
    tinymce.init({
        selector: '#normaluser,#reselleruser',
        height: 100,
        theme: 'modern',
        menubar:false,
        plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc'
        ],
        toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | link image ',
        toolbar2: ' print preview media | forecolor backcolor emoticons | codesample  | bullist numlist outdent indent | code',
        image_advtab: true,
        templates: [
            { title: 'Test template 1', content: 'Test 1' },
            { title: 'Test template 2', content: 'Test 2' }
        ],
        content_css: [
            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
            '//www.tinymce.com/css/codepen.min.css'
        ]
    });
    jQuery(document).on('keyup click','.admin_pass',function () {
        jQuery('.admin_error_message').hide();
    });
    jQuery(document).on('submit','#submit_form',function(event){
        event.preventDefault();
        jQuery('.admin_pass').val("");
        jQuery('#admin_password_modal').modal('show');
        jQuery('.admin_error_message').hide();

    });
    jQuery(document).on('submit','#add_admin_password_form',function(e){
        e.preventDefault();
        jQuery.ajax({
            url: 'process.php',
            type:'POST',

            data:'check_admin_password=true&'+jQuery('#add_admin_password_form').serialize(),
            success: function(data) {
                var obj = jQuery.parseJSON(data);
                if(obj.status == 1){

                   var normaluser = jQuery('#normaluser').val();
                   var reselleruser= jQuery('#reselleruser').val();
                    console.log(normaluser);
                    
                    jQuery.ajax({ 
                        url: 'process_in.php',
                        type: 'POST',
                        contentType: "application/json",
                        data: JSON.stringify({
                          insertdata:"true",
                         normaluser:normaluser,
                          reselleruser:reselleruser
                         }),
                        dataType: 'json',
                       // data: 'insertdata=true&normaluser='+encodeURIComponent(normaluser) +'&reselleruser='+encodeURIComponent(reselleruser),
                        success: function(data) {
                            //called when successful
                            window.location="addInstruction.php"
                        }
                    });
                }else{
                    jQuery('.admin_error_message').show();
                    jQuery('.admin_error_message').css('color','red');
                    jQuery('.admin_error_message').text('Password is not correct');
                }
            }
        })
    })
</script>
</body>
</html>

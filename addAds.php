<?php
session_start ();
ob_start ();
require_once 'functions/Constants.php';
require_once 'functions/ConfigClass.php';
require_once 'functions/SiteFunctions.php';
require_once 'functions/AdminFunctions.php';
require_once 'functions/Session.php';

if (! AdminAccess ( $_SESSION ['ADMINID'], array (
		'A' 
) )) {
	?>
<h1 class="404-error"
	style="color: red; text-align: center; font-size: 100px">
	Looks like you've lost your way. Error 404 - Page not found.
	</h3>
	</div>
<?php
	die ();
}
$menuName = 'ads';

if (isset ( $_REQUEST ['update'] )) {
	$adds_data=GetSingleRow("add_ads_new",$_REQUEST ['update']);
}

if (isset ( $_REQUEST ['deleteId'] )) {
	$flag=DeleteSingleRow('add_ads_new', $_REQUEST ['deleteId']);
}

$addDatas = GetMultiRowsOnCondition ( 'add_ads_new', ' 1=1 order by creationdate desc' );

if ($_SESSION ['ACTYPE'] == 'A') {
	if (! isset ( $_SESSION ['masterpass'] )) {
		$_SESSION ['page'] = 'addAds.php';
		echo "<script> window.location.href = 'masterpassword.php'; </script>";
		exit ();
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
                        <li class="active">Add Important updates</li>
                    </ul>
                </div>
                <!-- /Page Breadcrumb -->
                <!-- Page Header -->
                <div class="page-header position-relative">
                    <div class="header-title">
                        <h1>
                            Add Important updates
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
                                    <span class="widget-caption">Add Important Updates</span>
                                    
                                </div>
                                <div class="widget-body">
								<form id="submit_form" class="form-horizontal"
										 method="post">
									<input type="hidden" name="id" id="id" value="<?php echo $adds_data['id']?>">
									<div class="form-group">
										<label class="col-sm-2 control-label">Important Message</label>
										<div class="col-sm-10">
											<div class="col-sm-9 col-md-9">
												<textarea name="reselleruser" id="reselleruser"><?php echo $adds_data['image_name1']?></textarea>
											</div>                                      
                                    </div>
									</div>
									<div class="hr-line-dashed"></div>
									<div class="form-group">
										<div class="col-sm-4 col-sm-offset-2">
											<input type="button" class="btn btn-primary check_admin"
												value="Submit">
											<button class="btn btn-primary" name="SubmitImage"
												id="SubmitImage" type="submit" style="display: none">Submit</button>
										</div>
									</div>
								</form>

								<table class="table table-striped table-bordered table-hover crtadd"
									id="editable">
									<thead>
										<tr>
											<th width="50">Sr. No.</th>
											<th width="70">Date</th>
											<th width="300">Message</th>
											<th width="120">Update/Delete</th>
										</tr>
									</thead>
									<tbody>
									 <?php
										$sr=1;
										foreach($addDatas as $addData) {?>
										
											<tr class="gradeX" id="list_<?php echo $addData['id']; ?>">
											 <td><?php echo $sr++; ?></td>
											 <td><?php echo DayMonthYearTimeCounter($addData['creationdate']); ?></td>
											 <td><?php echo $addData['image_name1']; ?></td>
											 <td> <a href="addAds.php?update=<?php echo $addData['id']; ?>" class="btn btn-success btn-xs"><i class="fa fa-edit"></i> Update</a>
											 <a onclick='deleteAdds("addAds.php?deleteId=<?php echo $addData["id"]; ?>")' href="#" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Delete</a></td>
											</tr>
									<?php }?>
									
									<tfoot>
										<tr>
											<th width="50">Sr. No.</th>
											<th width="70">Date</th>
											<th width="300">Message</th>
											<th width="120">Update/Delete</th>
										</tr>
									</tfoot>
									</tbody>
								</table>
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
								<label>Password</label> <input type="password" name="admin_pass"
									class="form-control admin_pass" required> <label
									class="admin_error_message" style="display: none;"></label>
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
    jQuery(document).on('click','.check_admin',function(event){
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

                    
                    var addsimage1 = tinyMCE.activeEditor.getContent();
                    var id= jQuery('#id').val();
					var insertdataFlag="true";
                    if(id!=''){
                    	insertdataFlag="false";
                    }
					console.log(insertdataFlag);
					console.log(id);
					console.log(addsimage1);
                    
                    jQuery.ajax({ 
                        url: 'createAdds.php',
                        type: 'POST',
                        contentType: "application/json",
                        data: JSON.stringify({
                          insertdata:insertdataFlag,
                          addsimage1:addsimage1,
                          id:id
                         }),
                        dataType: 'json',
                       // data: 'insertdata=true&normaluser='+encodeURIComponent(normaluser) +'&reselleruser='+encodeURIComponent(reselleruser),
                        success: function(data) {
                            //called when successful
                            window.location="addAds.php"
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
    function deleteAdds(str){
        
        if(confirm("are you sure you want to delete this Picture?") == false)
        {
            return;
        }else{
        	window.location=str;

            }

    }
</script>
</body>
	</html>
<?php
ob_start();
require_once 'functions/Constants.php';
require_once 'functions/ConfigClass.php';
require_once 'functions/SiteFunctions.php';
require_once 'functions/AdminFunctions.php';
require_once 'functions/Session.php';
if(!AdminAccess($_SESSION['ADMINID'], array('A', 'M'))){?>
		<h1 class="404-error" style="color: red; text-align:center; font-size: 100px">Looks like you've lost your way. Error 404 - Page not found.</h3>
	</div>
<?php 
die;
}
$PageTitle = 'Manager List';
$menuName = 'user';
$submenuName = 'manager-list';

#### UPDATE USER DETAIL
if(isset($_REQUEST['editId'])) {
    $editId = intval($_REQUEST['editId']);
    echo "<script> window.location.href = 'manager-edit.php?id=".$editId."'; </script>";
    exit();
}

#### UPDATE USER PASSWORD
if(isset($_REQUEST['upassId'])) {
    $upassId = intval($_REQUEST['upassId']);
    echo "<script> window.location.href = 'manager-upass.php?id=".$upassId."'; </script>";
    exit();
}


$condition = "addedby=0 or addedby=1";
$USerList = GetMultiRowsOnCondition(ADMIN, $condition);

$condition_1 = "id=1";
$admin_check = GetSingleRowsOnCondition(ADMIN, $condition_1);
//if master password is not set send them to enter master password
if($_SESSION['ACTYPE'] == 'A')
{
	if(!isset($_SESSION['masterpass']))
	{
		$_SESSION['page'] = 'manager-list.php';
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
                        <li class="active">User list</li>
                    </ul>
                </div>
                <!-- /Page Breadcrumb -->
                <!-- Page Header -->
                <div class="page-header position-relative">
                    <div class="header-title">
                        <h1>
                            Clients
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
                                    <span class="widget-caption">Manager List</span>
                                    
                                </div>
                                <div class="widget-body">


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
							<div class="dt-buttons">								
								<a class="dt-button" tabindex="0" aria-controls="editable" href="export_user.php?uid=admin"><span>Export to Excel</span></a>
							</div>
                            <br>
                            <div id="errormsg"> </div>
                            <input type="hidden" id="hidden_id">
                            <input type="hidden" id="hidden_delete_id">
                            <input type="hidden" id="hidden_table_name">
                            <input type="hidden" id="hidden_btn_val">
                            <input type="hidden" id="hidden_btn_id">
                            <input type="hidden" id="hidden_btn_all_val">
                            <table class="table table-striped table-bordered table-hover " id="editable" >
                                <thead>
                                <tr>
                                    <th width="90">Sr. No.</th>
                                    <th width="90"><input type="checkbox"   class="all_toggle" <?php if($admin_check['displaybtn'] == 1){ echo checked; } ?> data-toggle="toggle"></th>
                                    <th>Username</th>
                                    <th>Password</th>
                                    <th width="150">Email</th>
                                    <th width="150">Name</th>
                                    <th width="150">Contact Number</th>
                                    <th width="150">Account Type</th>
                                    <th width="100">Whatsapp Balance</th> 
									<th width="100">Filter Balance</th>	
									<th width="100">Wechat Balance</th>	
                                    <th width="150">Created At</th>
									<th> Service Type</th>
                                    <th width="240">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $sr=1;
                                foreach($USerList as $USerDetail) {
                                    ?>
                                    <tr class="gradeX" id="list_<?php echo $USerDetail['id']; ?>">
                                        <td><?php echo $sr++; ?></td>
                                        <?php if($USerDetail['actype']=='A'){ ?>
                                            <td></td>
                                        <?php }else{?>
                                            <td><input type="checkbox" data_id="<?php echo $USerDetail['id']; ?>" class="toggle-event" <?php if($USerDetail['displaybtn'] == 1){ echo 'checked'; }?> data-toggle="toggle"></td>

                                        <?php }?>
                                        <td><?php echo $USerDetail['username']; ?></td>
                                        <?php if($USerDetail['actype']=='A'){ ?>
                                            <td>-</td>
                                            <td>-</td>
                                        <?php }
                                        else{?>
                                            <td><?php echo base64_decode($USerDetail['password']); ?></td>
                                            <td><?php echo $USerDetail['email']; ?></td>
                                        <?php }?>

                                        <td><?php echo $USerDetail['name']; ?></td>
                                        <td><?php echo $USerDetail['contact_number']; ?></td>
                                        <td>
											<?php if($USerDetail['actype']=='M'){ echo "Resaller"; }
                                            if($USerDetail['actype']=='U'){ echo "Normal User"; }
											if($USerDetail['actype']=='S'){ echo "Staff User"; }
                                            ?></td> <td class="center">
                                            <?php
                                            $SS=GetSingleRowsOnCondition(ADMIN,'id='.$USerDetail['id']);

                                            echo $SS['msgcredit'];
                                            ?>
                                        </td>
                                        <td><?php
                                            $SS=GetSingleRowsOnCondition(ADMIN,'id='.$USerDetail['id']);

                                            echo $SS['filtercredit'];
                                            ?></td>
										<td><?php echo $USerDetail['wechat_credit']; ?></td>
                                        <?php if($USerDetail['created_date']=='0000-00-00 00:00:00'){?>
                                            <td></td>
                                        <?php }else{?>
                                            <td><?php echo date('jS F Y', strtotime($USerDetail['created_date'])); ?></td>
                                        <?php }?>
											
											<td>
												<?php
													if($USerDetail['whatsapp'] == 'Y')
													{
														echo 'Whatsapp ';
													}
													if($USerDetail['wechat'] == 'Y')
													{
														echo ' Wechat';
													}
												?>
											</td>
                                        <td class="center">
                                            <a href="javascript:void(0);" class="btn btn-info btn-xs edit_user" data_id="manager-list.php?editId=<?php echo $USerDetail['id']; ?>"><i class="fa fa-edit"></i> Edit</a>
                                            <?php if($USerDetail['actype']=='A'){ ?>
                                                <a onClick="SendMail('<?php echo ADMIN; ?>', <?php echo $USerDetail['id']; ?>)" class="btn btn-success btn-xs"><i class="fa fa-book"></i> Update Password</a>
                                            <?php }
                                            else{?>
                                                <?php if($USerDetail['filtercredit']==0 && $USerDetail['actype']!='S'){ ?>
                                                    <a href="javascript:void(0);" data_id="<?php echo $USerDetail['id']; ?>" class="btn btn-success btn-xs add_filter_credit"><i class="fa fa-rupee"></i> Add Filter Credit</a>
                                                <?php }?>
                                                <a href="javascript:void(0);" data_id="manager-list.php?upassId=<?php echo $USerDetail['id']; ?>" class="btn btn-success btn-xs update_pass"><i class="fa fa-book"></i> Update Password</a>
                                                <a href="javascript:void(0);" data_table = <?php echo ADMIN; ?> data_id="<?php echo $USerDetail['id']; ?>" class="btn btn-danger btn-xs delete_user"><i class="fa fa-trash-o"></i> Delete</a>
                                            <?php }?>

                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                         <!--        <tfoot>
                                <tr>
                                    <th width="90">Sr. No.</th>
                                    <th width="90"></th>
                                    <th>Username</th>
                                    <th>Password</th>
                                    <th width="150">Email</th>
                                    <th width="150">Name</th>
                                    <th width="150">Contact Number</th>
                                    <th width="150">Account Type</th>
                                    <th width="100">Whatsapp Balance</th>
                                    <th width="100">Filter Balance</th>
									<th width="100">Wechat Balance</th>	
                                    <th width="150">Created At</th>
                                    <th width="240">Action</th>
                                </tr>
                                </tfoot> -->
                                 </table>


                        </div>
                    </div>
                </div>
            </div>

        <?php include_once 'files/Footer.php'; ?>
        <script src="assets/js/datatable/jquery.dataTables.min.js"></script>
        <script src="assets/js/datatable/ZeroClipboard.js"></script>
        <script src="assets/js/datatable/dataTables.tableTools.min.js"></script>
        <script src="assets/js/datatable/dataTables.bootstrap.min.js"></script>
        <script src="assets/js/datatable/datatables-init.js"></script>
        <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    </div>
</div>

</div>

<!-- Mainly scripts -->

<script>
    $(document).ready(function() {

        $('.dataTables-example').dataTable({
            responsive: true,
            "dom": 'T<"clear">lfrtip',
            "tableTools": {
                "sSwfPath": "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
            }
        });


        /* Init DataTables */
        var oTable = $('#editable').dataTable({
            "processing": true,
            "scrollX": true
        });

        /* Apply the jEditable handlers to the table */
/*        oTable.$('td').editable( 'http://webapplayers.com/example_ajax.php', {
            "callback": function( sValue, y ) {
                var aPos = oTable.fnGetPosition( this );
                oTable.fnUpdate( sValue, aPos[0], aPos[1] );
            },
            "submitdata": function ( value, settings ) {
                return {
                    "row_id": this.parentNode.getAttribute('id'),
                    "column": oTable.fnGetPosition( this )[2]
                };
            },

            "width": "90%",
            "height": "100%"
        } );*/


    });

    function fnClickAddRow() {
        $('#editable').dataTable().fnAddData( [
            "Custom row",
            "New row",
            "New row",
            "New row",
            "New row" ] );

    }

</script>

<!--- ==== DELETE RECODE ==== --->
<script type="text/javascript">
    function DeleteRecord(tblname, id){
        if (confirm("Are you sure you want to delete this record?")){
            var dataString = 'id='+ id + '&tblname='+ tblname;
            $.ajax({
                type: "POST",
                url: "deleteRecord.php",
                data: dataString,
                cache: false,
                success: function(result){
                    if(result){
                        if(result=='success'){
                            var randNum=Math.floor((Math.random()*100)+1);
                            if(randNum % 2==0){
                                $("#list_"+id).slideUp(1000);
                            }else{
                                $("#list_"+id).hide(500);
                            }
                        }
                        else {
                            var errorMessage=result.substring(position+2);
                            alert(errorMessage);
                        }
                    }
                }
            });
        }
    }
    function SendMail(tblname,id){
        if(confirm("Are you sure you want update password?"))
        {
            var dataSend = 'id='+ id+ '&tblname='+ tblname;
            $.ajax({
                type: "POST",
                url:  "sendMail.php",
                data: dataSend,
                cache: false,
                success: function(result){
                    if(result==0){
                        alert('Somthing Wrong. PLease Try again!');
                    }
                    else{
                        alert('Please Check Your Register email for Update Password!');
                    }
                }
            });
        }
    }
</script>

</body>
<div id="admin_password_changepassword_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Admin Password</h4>
            </div>
            <form id="admin_password_changepassword_form">
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
<div id="admin_password_changepassword_all_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Admin Password</h4>
            </div>
            <form id="admin_password_changepassword_all_form">
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

<div id="admin_password_modal_for_delete" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Admin Password</h4>
            </div>
            <form id="add_admin_password_form_delete">
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
<div id="admin_password_modal_for_filter" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Admin Password</h4>
            </div>
            <form id="add_admin_password_form_filter">
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
<div id="add_filter_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Filter Credit</h4>
            </div>
            <form id="add_filter_form">
                <div class="modal-body">
                    <input type="hidden" id="hidden_filter_id" name="hidden_filter_id">
                    <div class="form-group">
                        <label>Add Filter Credit</label>
                        <input type="number" name="add_point" class="form-control add_point" required min="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Submit">
                </div>
            </form>
        </div>
    </div>
</div>
</html>
<script>

    jQuery(document).on('keyup click','.admin_pass',function () {
        jQuery('.admin_error_message').hide();
    });
    jQuery(document).on('click','.add_filter_credit',function(){
        jQuery('#add_admin_password_form_filter .admin_pass').val('');
        jQuery('#admin_password_modal_for_filter').modal('show');
        jQuery('#hidden_filter_id').val(jQuery(this).attr('data_id'));
    });
    jQuery(document).on('submit','#add_admin_password_form_filter',function(e){
        e.preventDefault();
        jQuery.ajax({
            url: 'process.php',
            type:'POST',
            data:'check_admin_password=true&'+jQuery('#add_admin_password_form_filter').serialize(),
            success: function(data) {
                var obj = jQuery.parseJSON(data);
                if(obj.status == 1){
                    jQuery('#admin_password_modal_for_filter').modal('hide');
                    jQuery('#add_filter_modal').modal('show');

                }else{
                    jQuery('#add_admin_password_form_filter .admin_error_message').show();
                    jQuery('#add_admin_password_form_filter .admin_error_message').css('color','red');
                    jQuery('#add_admin_password_form_filter .admin_error_message').text('Password is not correct');
                }
            }
        });
    });
    jQuery(document).on('submit','#add_filter_form',function(e){
        e.preventDefault();
        jQuery.ajax({
            url: 'process.php',
            type:'POST',
            data:'update_filter_point=true&'+jQuery('#add_filter_form').serialize(),
            success: function(data) {
                var obj = jQuery.parseJSON(data);
                if(obj.status === true){
                    alert("Filter Credit Added!");
                    location.reload();
                }
            }
        });
    });
    jQuery(document).on('click','.edit_user',function () {
        var id = jQuery(this).attr('data_id');
        jQuery('#admin_password_modal').modal('show');
        jQuery('#hidden_id').val(id);
    });
    jQuery(document).on('click','.update_pass',function () {
        var id = jQuery(this).attr('data_id');
        jQuery('#admin_password_modal').modal('show');
        jQuery('#hidden_id').val(id);
    });
    jQuery(document).on('click','.delete_user',function () {
        var id = jQuery(this).attr('data_id');
        var data_table = jQuery(this).attr('data_table');
        jQuery('#admin_password_modal_for_delete').modal('show');
        jQuery('#hidden_table_name').val(data_table);
        jQuery('#hidden_delete_id').val(id);
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
                    window.location.href= jQuery('#hidden_id').val();
                }else{
                    jQuery('.admin_error_message').show();
                    jQuery('.admin_error_message').css('color','red');
                    jQuery('.admin_error_message').text('Password is not correct');
                }
            }
        });
    });
    $('.toggle-event').change(function() {
        jQuery('#admin_password_changepassword_modal').modal('show');
        jQuery('#hidden_btn_val').val($(this).prop('checked'))
        jQuery('#hidden_btn_id').val(jQuery(this).attr('data_id'))

    });
    $('.all_toggle').change(function() {
        jQuery('#admin_password_changepassword_all_modal').modal('show');
        jQuery('#hidden_btn_all_val').val($(this).prop('checked'))

    });

    jQuery(document).on('hidden.bs.modal','#admin_password_changepassword_modal,#admin_password_changepassword_all_modal',function () {
        location.reload();
    });
    jQuery(document).on('submit','#admin_password_changepassword_form',function(e){
        e.preventDefault();
        jQuery.ajax({
            url: 'process.php',
            type:'POST',
            data:'check_admin_password=true&'+jQuery('#admin_password_changepassword_form').serialize(),
            success: function(data) {
                var obj = jQuery.parseJSON(data);
                if(obj.status == 1){
                    $.ajax({
                        type: "POST",
                        url: "process.php",
                        data: 'change_user_btn=true&id='+ jQuery('#hidden_btn_id').val()+'&val='+ jQuery('#hidden_btn_val').val(),
                        cache: false,
                        success: function(result){
                            var obj = jQuery.parseJSON(result);
                            if(obj.status === true){
                                location.reload();
                            }
                        }
                    })
                }else{
                    jQuery('.admin_error_message').show();
                    jQuery('.admin_error_message').css('color','red');
                    jQuery('.admin_error_message').text('Password is not correct');
                }
            }
        });
    });
    jQuery(document).on('submit','#admin_password_changepassword_all_form',function(e){
        e.preventDefault();
        jQuery.ajax({
            url: 'process.php',
            type:'POST',
            data:'check_admin_password=true&'+jQuery('#admin_password_changepassword_all_form').serialize(),
            success: function(data) {
                var obj = jQuery.parseJSON(data);
                if(obj.status == 1){
                    $.ajax({
                        type: "POST",
                        url: "process.php",
                        data: 'change_all_user_btn=true&val='+jQuery('#hidden_btn_all_val').val(),
                        cache: false,
                        success: function(result){
                            var obj = jQuery.parseJSON(result);
                            if(obj.status === true){
                                location.reload();
                            }
                        }
                    })
                }else{
                    jQuery('.admin_error_message').show();
                    jQuery('.admin_error_message').css('color','red');
                    jQuery('.admin_error_message').text('Password is not correct');
                }
            }
        });
    });
    jQuery(document).on('submit','#add_admin_password_form_delete',function(e){
        e.preventDefault();
        jQuery.ajax({
            url: 'process.php',
            type:'POST',
            data:'check_admin_password=true&'+jQuery('#add_admin_password_form_delete').serialize(),
            success: function(data) {
                var obj = jQuery.parseJSON(data);
                if(obj.status == 1){
                    DeleteRecord(jQuery('#hidden_table_name').val(),
                        jQuery('#hidden_delete_id').val());
                    location.reload();
                    // window.location.href= jQuery('#hidden_id').val();
                }else{

                    jQuery('.admin_error_message').show();
                    jQuery('.admin_error_message').css('color','red');
                    jQuery('.admin_error_message').text('Password is not correct');
                }
            }
        })
    })
</script>


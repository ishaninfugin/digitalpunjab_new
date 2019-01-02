<?php
ob_start();
require_once 'functions/Constants.php';
require_once 'functions/ConfigClass.php';
require_once 'functions/SiteFunctions.php';
require_once 'functions/AdminFunctions.php';
require_once 'functions/Session.php';

if(!AdminAccess($_SESSION['ADMINID'], array('A','S'))){?>
		<h1 class="404-error" style="color: red; text-align:center; font-size: 100px">Looks like you've lost your way. Error 404 - Page not found.</h3>
	</div>
<?php 
die;
}
$PageTitle = 'Order List';
$menuName = 'wechat-order';
$submenuName = 'we-order-list';

mysql_query("update wechat_orders set read_status='yes'");

#### UPDATE USER DETAIL
if (isset($_REQUEST['confirmorder'])) {
    //deduct can not more then credit
    $uid = $_REQUEST['uid'];
    $user_data = getDataByQuery("SELECT * FROM tbl_admin WHERE id = '{$uid}'")[0];
	
    $msgCredit=floatval($user_data['wechat_credit']);	
	
    if($_REQUEST['deduct']>$msgCredit){
		
        $_SESSION['ERROR'] = "Deduct is less then Credit!";
        echo '<script>window.location="wechat-order-list.php"</script>';
        exit;
    }
    mysql_query("update wechat_orders set deduct='" . $_REQUEST['deduct'] . "' where id=" . $_REQUEST['updateid']);
    $amount_inserted = mysql_query("insert into account (`balance`,`uid`,`detail`,`datee`, wechat) values('-" . $_REQUEST['deduct'] . "','" . $_REQUEST['uid'] . "','Deduct By Admin For Your Order','" . date("d-m-Y") . "','1' )");

    //debit admin balance by requested deduct amount
    if(is_numeric($_REQUEST['deduct'])){
        $new_balance = ( floatval($user_data['wechat_credit']) - floatval($_REQUEST['deduct']));
        if ($amount_inserted) {
            $query = mysql_query("UPDATE tbl_admin SET wechat_credit = $new_balance WHERE id = '{$uid}' ");
            header('Location:wechat-order-list.php');
        }
    }
}

if (isset($_REQUEST['filterconfirmorder'])) {
    //deduct can not more then credit
    $uid = $_REQUEST['uid'];
    $user_data = getDataByQuery("SELECT * FROM tbl_admin WHERE id = '{$uid}'")[0];
    $msgCredit=floatval($user_data['filtercredit']);
    if($_REQUEST['filterdeduct']>$msgCredit){
        $_SESSION['ERROR'] = "Deduct is less then Credit!";
        echo '<script>window.location="wechat-order-list.php"</script>';
        exit;
    }
    mysql_query("update wechat_orders set filterdeduct='" . $_REQUEST['filterdeduct'] . "' where id=" . $_REQUEST['updateid']);
    $amount_inserted = mysql_query("insert into account (`balance`,`uid`,`detail`,`datee`,`filter`,'wechat') values('-" . $_REQUEST['filterdeduct'] . "','" . $_REQUEST['uid'] . "','Filter Deduct By Admin For Your Order','" . date("d-m-Y") . "',1,'1')");

    //debit admin balance by requested deduct amount
    if(is_numeric($_REQUEST['filterdeduct'])){
        $new_balance = ( floatval($user_data['filtercredit']) - floatval($_REQUEST['filterdeduct']));
        if ($amount_inserted) {
            $query = mysql_query("UPDATE tbl_admin SET filtercredit = $new_balance WHERE id = '{$uid}' ");
            header('Location:order-list.php');
        }
    }
}

if (isset($_GET['deleteId'])) {
    mysql_query("delete from wechat_orders where id=" . $_GET['deleteId']);
}

if (isset($_REQUEST['deleteId'])) {
    mysql_query("delete from wechat_orders where id='" . $_REQUEST['deleteId'] . "'  and deduct=''");
}

$OrderList = GetMultiRowsOnCondition('wechat_orders', '1 order by id DESC');

//print_r($OrderList); exit;
?>


<!DOCTYPE html>
<html>
   <?php require_once 'header.php'; ?>
    <body>
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
                        <li class="active">Wechat</li>
                    </ul>
                </div>
                <!-- /Page Breadcrumb -->
                <!-- Page Header -->
                <div class="page-header position-relative">
                    <div class="header-title">
                        <h1>
                           Wechat Order List
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
                                        <span class="widget-caption">Order List</span>
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

                                    <div id="errormsg"> </div>
                                    <!--<a href="exportreport.php" target="_blank">EXPORT TO EXCEL</a><br/>-->

                                    <table class="table table-striped table-bordered table-hover " id="editable" >
                                        <thead>
                                            <tr>                                                
                                                <th width=""></th>
                                                <!--<th width=""><input type="checkbox" checked data-toggle="toggle"></th>-->
                                                <th width="">Sr. No.</th>
                                                <th >Order ID</th>
                                                <th >Username</th>
                                                <th >Date</th>
                                                <th >Message</th>
                                                <th >Sender ID</th>
                                                <th >logo</th>
                                                <th >Images</th>
                                                <th >Video</th>
                                                <th >Mobile Number File</th>
                                                <th >Upload</th>
                                                <th >Balance</th>
                                                <th >Confirm</th>
                                                <th >Filter Balance</th>
                                                <th >Filter Confirm</th>
                                                <!--<th width="">Action</th>-->
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                        <tfoot>
                                            <tr>                                                
                                                <!--<th ></th>-->
                                                <th ></th>
                                                <th >Sr. No.</th>
                                                <th >Order ID</th>
                                                <th >Username</th>
                                                <th >Date</th>
                                                <th >Message</th>
                                                <th >Sender ID</th>
                                                <th >logo</th>
                                                <th >Images</th>
                                                <th >video</th>
                                                <th >Mobile Number File</th>
                                                <th >Upload</th>
                                                <th >Balance</th>
                                                <th width="">Confirm</th>
                                                <th >Filter Balance</th>
                                                <th >Filter Confirm</th>
                                                <!--<th >Action</th>-->
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>                   



                </div>
                <?php include_once 'files/Footer.php'; ?>
                                    <!-- <script src="assets/js/datatable/jquery.dataTables.min.js"></script> -->
                    <script src="assets/js/datatable/ZeroClipboard.js"></script>
                    <!-- <script src="assets/js/datatable/dataTables.tableTools.min.js"></script>
                    <script src="assets/js/datatable/dataTables.bootstrap.min.js"></script>
                    <script src="assets/js/datatable/datatables-init.js"></script> -->
                      <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/select/1.2.0/js/dataTables.select.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
        <script src="assets/js/datatable/dataTables.bootstrap.min.js"></script>
                    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js">
                    </script>
            </div>
        </div>
        


        <script>
            var oTable = null;
            $('.Edit_ded').hide();
            $('.Filter_Edit_ded').hide();
            $(document).ready(function() {
                $.fn.dataTableExt.oApi.fnStandingRedraw = function(oSettings) {
                    //redraw to account for filtering and sorting
                    // concept here is that (for client side) there is a row got inserted at the end (for an add)
                    // or when a record was modified it could be in the middle of the table
                    // that is probably not supposed to be there - due to filtering / sorting
                    // so we need to re process filtering and sorting
                    // BUT - if it is server side - then this should be handled by the server - so skip this step
                    if (oSettings.oFeatures.bServerSide === false) {
                        var before = oSettings._iDisplayStart;
                        oSettings.oApi._fnReDraw(oSettings);
                        //iDisplayStart has been reset to zero - so lets change it back
                        oSettings._iDisplayStart = before;
                        oSettings.oApi._fnCalculateEnd(oSettings);
                    }

                    //draw the 'current' page
                    oSettings.oApi._fnDraw(oSettings);
                };
                
                oTable = $('#editable').dataTable({
                    "processing": true,
                    "scrollX": true,
                    //"scrollTop": 1,
                    "serverSide": true,
//                    "bSort": false,
//                    bFilter: false,
//                    bInfo: false,
                    stateSave: true,
                    "ajax": {
                        url: "controller.php",
                        type: 'POST',
                        data: {
                            'requestType': 'wechat_order_list'
                        }
                    },
//                    "aoColumnDefs": [{ "bVisible": false, "aTargets": [2] }],
                    dom: 'Blfrtip',
                    buttons: [
                        {
                            text: 'Remove',
                            action: function(e, dt, node, config) {
                                var choice = confirm('Do you really want to delete this orders?');
                                if (choice) {
                                    var ids = $.map(oTable.api().rows('.selected').data(), function(item) {
                                        return item[2]
                                    });
                                    $.ajax({
                                        dataType: 'json',
                                        type: 'post',
                                        data: {requestType: 'remove_wechat_order', ids: ids},
                                        url: 'controller.php',
                                        success: function(r) {
                                            if (r.status == 'success') {
                                                oTable.fnStandingRedraw();
                                                alert('Orders deleted successfully.');
                                            }
                                        }
                                    })
//                                    console.log(ids)
                                }

                            }
                        },
                        {
                            text: 'Export to Excel',
                            action: function(e, dt, node, config) {
                                window.location = 'wechat_exportreport.php';
                            }
                        }
                    ],
                    columnDefs: [{
                            orderable: false,
                            className: 'select-checkbox',
                            targets: 0
                        }],
                    select: {
                        style: 'multi',
                        selector: 'td:first-child',
                    }
                    ,
                    order: [[1, 'asc']],
                });
                
                
                var allPages = oTable.fnGetNodes();

                $('body').on('click', '#checkAll', function() {
                    if ($(this).prop('checked') == true) {
                        $('tr', allPages).addClass('selected');
                    } else {
                        $('tr', allPages).removeClass('selected');

                    }
//                    $(this).toggleClass('allChecked');
                })

                $('#editable').on('click', '.edit-deduct', function(e) {
                    e.preventDefault();
                    var id = $(this).attr('id');
                    console.log('#editDeduct-' + id);
                    $('#editDeduct-' + id).show();
                });

                $('#editable').on('click', '.edit-filterdeduct', function(e) {
                    e.preventDefault();
                    var id = $(this).attr('id');
                    console.log('#editFilterDeduct-' + id);
                    $('#editFilterDeduct-' + id).show();
                });
            });

//            $(".edit-deduct").click(function() {
//                var id = $(this).attr('id');
//                $('#editDeduct-' + id).show()
////                console.log();
//
//            });

            $('#editable').on('submit', '.Edit_ded', function(e) {
                e.preventDefault();
                var credit = $(this).find('input[name=wechat_credit]').val();
                var data = {requestType: 'deduct_wechat_amount', data: $(this).serialize()};
                if (credit) {
                    var conf = confirm('Do you really want to deduct credit?');
                    if (conf) {
                        $.ajax({
                            dataType: 'json',
                            type: 'post',
                            url: 'controller.php',
                            data: data,
                            success: function(r) {
                                if (r.status == 'success') {
                                    oTable.fnStandingRedraw();
                                    alert('Operation conpleted successfully!');
                                }
                                else if(r.status == 'deduct_error'){
                                    oTable.fnStandingRedraw();
                                    alert('Deduct is less then Credit!');
                                }

                            }
                        })

                    }
                }
            })
            $('#editable').on('submit', '.Filter_Edit_ded', function(e) {
                e.preventDefault();
                var filtercredit = $(this).find('input[name=wechat_filtercredit]').val();
                var data = {requestType: 'wechat_filter_deduct_amount', data: $(this).serialize()};
                if (filtercredit) {
                    var conf = confirm('Do you really want to deduct credit?');
                    if (conf) {
                        $.ajax({
                            dataType: 'json',
                            type: 'post',
                            url: 'controller.php',
                            data: data,
                            success: function(r) {
                                if (r.status == 'success') {
                                    oTable.fnStandingRedraw();
                                    alert('Operation conpleted successfully!');
                                }
                                else if(r.status == 'deduct_error'){
                                    oTable.fnStandingRedraw();
                                    alert('Deduct is less then Credit!');
                                }

                            }
                        })

                    }
                }
            })
            $('#editable').on('submit', '.uploadFile', function(e) {
                e.preventDefault();
                var file = $(this).find('input[name=msg]').val();
                var data = {requestType: 'deduct_amount', data: $(this).serialize()};
                if (file) {
                    var fd = new FormData($(this)[0]);
                    $.ajax({
                        dataType: 'json',
                        type: 'post',
                        url: 'upload-file2.php',
                        data: fd,
                        cache: false,
                        processData: false,
                        contentType: false,
                        success: function(r) {
                            if (r.status == 'success') {
                                oTable.fnStandingRedraw();
                                alert('Operation conpleted successfully!');
                            }

                        }
                    })

                }
            })

        </script>

        <!--- ==== DELETE RECODE ==== --->
        <script type="text/javascript">
            function DeleteRecord(tblname, id) {
                if (confirm("Are you sure you want to delete this record?")) {
                    var dataString = 'id=' + id + '&tblname=' + tblname;
                    $.ajax({
                        type: "POST",
                        url: "deleteRecord.php",
                        data: dataString,
                        cache: false,
                        success: function(result) {
                            if (result) {
                                if (result == 'success') {
                                    var randNum = Math.floor((Math.random() * 100) + 1);
                                    if (randNum % 2 == 0) {
                                        $("#list_" + id).slideUp(1000);
                                    } else {
                                        $("#list_" + id).hide(500);
                                    }
                                } else {
                                    var errorMessage = result.substring(position + 2);
                                    alert(errorMessage);
                                }
                            }
                        }
                    });
                }
            }


        </script>

    </body>
</html>
<?php
ob_start();
require_once 'functions/Constants.php';
require_once 'functions/ConfigClass.php';
require_once 'functions/SiteFunctions.php';
require_once 'functions/AdminFunctions.php';
require_once 'functions/Session.php';

if(!AdminAccess($_SESSION['ADMINID'], array('M'))){?>
		<h1 class="404-error" style="color: red; text-align:center; font-size: 100px">Looks like you've lost your way. Error 404 - Page not found.</h3>
	</div>
<?php 
die;
}
$PageTitle = 'Order List';
$menuName = 'myorder';
$submenuName = 'wechat-myorder';

mysql_query("update wechat_orders set read_status='yes'");

#### UPDATE USER DETAIL
/*if (isset($_REQUEST['confirmorder'])) {
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
}*/

/*if (isset($_REQUEST['filterconfirmorder'])) {
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
}*/

//$OrderList = GetMultiRowsOnCondition('wechat_orders', '1 order by id DESC');

//print_r($OrderList); exit;
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
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/css/dataTables.bootstrap.css"/>
        <link href="<?php echo SITEURL; ?>css/animate.css" rel="stylesheet">
        <link href="<?php echo SITEURL; ?>css/style.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/select/1.2.0/css/select.dataTables.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet">
        <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
        <style>
            .Edit_ded{display: none;}
            .Filter_Edit_ded{display: none;}
        </style>
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
                        <div class="col-lg-12">
							<div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Wechat Order List</h5>
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

                                    <div id="errormsg"> </div>
                                    <!--<a href="exportreport.php" target="_blank">EXPORT TO EXCEL</a><br/>-->

                                    <table class="table table-striped table-bordered table-hover " id="editable" >
                                        <thead>
                                            <tr>                                                
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
                                                <th >Balance</th>
                                                <th >Confirm</th>
                                                <th >Filter Balance</th>
                                                <th >Filter Confirm</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                        <tfoot>
                                            <tr>                                                
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
                                                <th >Balance</th>
                                                <th width="">Confirm</th>
                                                <th >Filter Balance</th>
                                                <th >Filter Confirm</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>                   



                </div>
                <?php include_once 'files/Footer.php'; ?>

            </div>
        </div>
        

        <!-- Mainly scripts -->
        <script src="<?php echo SITEURL; ?>js/jquery-2.1.1.js"></script>
        <script src="<?php echo SITEURL; ?>js/bootstrap.min.js"></script>
        <script src="<?php echo SITEURL; ?>js/plugins/metisMenu/jquery.metisMenu.js"></script>
        <script src="<?php echo SITEURL; ?>js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/select/1.2.0/js/dataTables.select.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>

        <script src="<?php echo SITEURL; ?>js/plugins/peity/jquery.peity.min.js"></script>
        <script src="<?php echo SITEURL; ?>js/demo/peity-demo.js"></script>
        <script src="<?php echo SITEURL; ?>js/inspinia.js"></script>
        <script src="<?php echo SITEURL; ?>js/plugins/pace/pace.min.js"></script>
        <script src="<?php echo SITEURL; ?>js/plugins/jquery-ui/jquery-ui.min.js"></script>
        <script src="<?php echo SITEURL; ?>js/plugins/gritter/jquery.gritter.min.js"></script>
        <script src="<?php echo SITEURL; ?>js/plugins/sparkline/jquery.sparkline.min.js"></script>
        <script src="<?php echo SITEURL; ?>js/demo/sparkline-demo.js"></script>
        <script src="<?php echo SITEURL; ?>js/plugins/chartJs/Chart.min.js"></script>


        <script>
            var oTable = null;
           // $('.Edit_ded').hide();
            //$('.Filter_Edit_ded').hide();
			
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
                        url: "controller_r.php",
                        type: 'POST',
                        data: {
                            'requestType': 'wechat_order_list'
                        }
                    },
//                    "aoColumnDefs": [{ "bVisible": false, "aTargets": [2] }],
                    dom: 'Blfrtip',
                    buttons: [
                        {
                            text: 'Export to Excel',
                            action: function(e, dt, node, config) {
                                window.location = 'wechat_exportreport.php';
                            }
                        }
                    ],
                    select: {
                        style: 'multi',
                        selector: 'td:first-child',
                    }
                    ,
                    order: [[1, 'asc']],
                });
            });
        </script>
    </body>
</html>
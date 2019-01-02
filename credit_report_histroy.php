<?php
require_once 'functions/Constants.php';
require_once 'functions/ConfigClass.php';
require_once 'functions/SiteFunctions.php';
require_once 'functions/AdminFunctions.php';
require_once 'functions/Session.php';
require_once 'process.php';

$PageTitle = 'Credit Report History';
$menuName = 'credit-report-histroy';

$setting=GetRow('tbl_setting');

$month=$setting['value'];
$date=date('Y-m-d',strtotime('-'.$month.' month'));

if ($_SESSION['ACTYPE'] == 'U'){
    $condition = "created_date >= '".$date." 00:00:00' AND created_date <= '".date('Y-m-d')." 23:59:59' AND balance!=0 AND uid = '".$_SESSION['ADMINID']."' ";
    $HistoryList = GetMultiRowsOnConditionWithOrder('account', $condition);
}
if($_SESSION['ACTYPE'] == 'M'){
    $childs = array();
    $childusers = findChildElements($_SESSION['ADMINID'],$childs);
    if(!empty($childusers)){
        $childusers_ids = explode(',',implode(',', $childusers));
        array_splice( $childusers_ids, 0, 0, $_SESSION['ADMINID'] );
        $user_ids=implode(',', $childusers_ids);
    }
    else{
        $user_ids=$_SESSION['ADMINID'];
    }

    $condition = "created_date >= '".$date." 00:00:00' AND created_date <= '".date('Y-m-d')." 23:59:59' AND balance!=0 AND uid IN (".$user_ids.") ";
    $HistoryList = GetMultiRowsOnConditionWithOrder('account', $condition);
}
if($_SESSION['ACTYPE'] == 'A'){
    $condition = "created_date >= '".$date." 00:00:00' AND created_date <= '".date('Y-m-d')." 23:59:59' AND balance!=0";
    $HistoryList = GetMultiRowsOnConditionWithOrder('account', $condition);
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
                        <li class="active">Credit History</li>
                    </ul>
                </div>
                <!-- /Page Breadcrumb -->
                <!-- Page Header -->
                <div class="page-header position-relative">
                    <div class="header-title">
                        <h1>
                            Credit History
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
                <div class="col-lg-12">
                            <div class="widget flat radius-bordered">
                                <div class="widget-header bg-blue">
                                    <span class="widget-caption">Credit History</span>
                                    
                                </div>
                                <div class="widget-body">
                            <table class="table table-striped table-bordered table-hover " id="editable" >
                                <thead>
                                <tr>
                                    <th width="70">Sr. No.</th>
                                    <th width="120">Date</th>
                                    <th width="120">Name</th>
                                    <th width="120">Balance</th>
                                    <th width="120">Detail</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $sr=1;
                                foreach($HistoryList as $list) {
                                    ?>
                                    <tr class="gradeX" id="list_<?php echo $list['id']; ?>">
                                        <td><?php echo $sr++; ?></td>
                                        <td><?php echo DayMonthYear($list['datee']); ?></td>
                                        <td><?php
                                            $UserDetail = GetSingleRow(ADMIN, $list['uid']);
                                            echo ucwords($UserDetail['name']); ?>
                                        </td>
                                        <td><?php echo $list['balance']; ?></td>
                                        <td><?php echo $list['detail']; ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th width="70">Sr. No.</th>
                                    <th width="120">Date</th>
                                    <th width="120">Name</th>
                                    <th width="120">Balance</th>
                                    <th width="120">Detail</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once 'files/Footer.php'; ?>
        <script src="assets/js/datatable/jquery.dataTables.min.js"></script>
        <script src="assets/js/datatable/dataTables.tableTools.min.js"></script>
        <script src="assets/js/datatable/dataTables.bootstrap.min.js"></script>
        <script src="assets/js/datatable/datatables-init.js"></script>
    </div>
</div>
<script type="text/javascript">

    $(document).ready(function() {
        $('.dataTables-example').dataTable({
            responsive: true
        });

        /* Init DataTables */
        var oTable = $('#editable').dataTable({
            "scrollX":        "99%"
        });

        /* Apply the jEditable handlers to the table */
        oTable.$('td').editable( 'http://webapplayers.com/example_ajax.php', {
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
        });
    });
</script>

</body>
</html>
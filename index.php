<?php
ob_start();
require_once 'functions/Constants.php';
require_once 'functions/ConfigClass.php';
require_once 'functions/SiteFunctions.php';
require_once 'functions/AdminFunctions.php';
require_once 'functions/Session.php';

date_default_timezone_set ( 'Asia/Kolkata' );

if ($_SESSION['ACTYPE'] == 'U' || $_SESSION['ACTYPE'] == 'M'){
    $PageTitle = 'Important Update';
}
else{
    $PageTitle = 'Dashboard';
}

$menuName = 'dashboard';
$submenuName = '';
$instuction_data=GetMultiRows("tbl_instruction");

    //$adds_data=GetSingleRow("add_ads",1);
$addDatas=GetMultiRowsOnCondition ( 'add_ads_new', ' 1=1 order by creationdate desc limit 5' );
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- Head -->
<?php require_once 'header.php'; ?>
<!-- /Head -->
<!-- Body -->
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
                        <li class="active">Dashboard</li>
                    </ul>
                </div>
                <!-- /Page Breadcrumb -->
                <!-- Page Header -->
                <div class="page-header position-relative">
                    <div class="header-title">
                        <h1>
                            Dashboard
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
                    <?php $SS = GetSingleRowsOnCondition(ADMIN, 'id=' . $AdminProfileDetail['id']);?>
                    <?php if ($AdminProfileDetail['whatsapp'] == 'Y'):  
                        $wp_name = $AdminProfileDetail['name'];
                        $wp_filter_bal = $SS['msgcredit'];
                        $SS = GetSingleRowsOnCondition(ADMIN, 'id=' . $AdminProfileDetail['id']);
                        $filter_credit = $SS['filtercredit'];
                    endif;                                     
                    if ($AdminProfileDetail['wechat'] == 'Y'):
                        $wechat = (int)$SS['wechat_credit'];
                    endif; 
                    if ($_SESSION['ACTYPE'] == 'S') { 
                     $user_fname = $_SESSION['LOGGEDUSER_FULLNAME'];
                 }else{ $user_fname = 'Admin'; } 

                            //Find User type
                 if($AdminProfileDetail['actype'] == 'A'){
                    $utype = 'Admin';
                }else if($AdminProfileDetail['actype'] == 'M'){
                    $utype = "Reseller";
                }else if($AdminProfileDetail['actype'] == 'U'){ $utype = 'User'; }
                ?>          
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="databox bg-white radius-bordered">
                                    <div class="databox-left bg-themesecondary">
                                        <div class="databox-piechart">
                                            <div data-toggle="easypiechart" class="easyPieChart" data-barcolor="#fff" data-linecap="butt" data-percent="50" data-animate="500" data-linewidth="3" data-size="47" data-trackcolor="rgba(255,255,255,0.1)"><span class="white font-90">50%</span></div>
                                        </div>
                                    </div>
                                    <div class="databox-right">
                                        <span class="databox-number themesecondary"><?php echo $wp_filter_bal; ?></span>
                                        <div class="databox-text darkgray">Whatsapp Balance</div>
                                        <div class="databox-stat themesecondary radius-bordered">
                                            <i class="stat-icon icon-lg fa fa-inr"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="databox bg-white radius-bordered">
                                    <div class="databox-left bg-themethirdcolor">
                                        <div class="databox-piechart">
                                            <div data-toggle="easypiechart" class="easyPieChart" data-barcolor="#fff" data-linecap="butt" data-percent="15" data-animate="500" data-linewidth="3" data-size="47" data-trackcolor="rgba(255,255,255,0.2)"><span class="white font-90">15%</span></div>
                                        </div>
                                    </div>
                                    <div class="databox-right">
                                        <span class="databox-number themethirdcolor"><?php echo $filter_credit; ?></span>
                                        <div class="databox-text darkgray">Whatsapp filter balance</div>
                                        <div class="databox-stat themethirdcolor radius-bordered">
                                            <i class="stat-icon  icon-lg fa fa-inr"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="databox bg-white radius-bordered">
                                    <div class="databox-left bg-themeprimary">
                                        <div class="databox-piechart">
                                            <div id="users-pie" data-toggle="easypiechart" class="easyPieChart" data-barcolor="#fff" data-linecap="butt" data-percent="76" data-animate="500" data-linewidth="3" data-size="47" data-trackcolor="rgba(255,255,255,0.1)"><span class="white font-90">76%</span></div>
                                        </div>
                                    </div>
                                    <div class="databox-right">
                                        <span class="databox-number themeprimary"><?php if(empty($wechat)){echo '0'; }else{ echo $wechat; } ?></span>
                                        <div class="databox-text darkgray">Wechat Balance</div>
                                        <div class="databox-state bg-themeprimary">
                                            <i class="fa fa-inr"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="databox bg-white radius-bordered">
                                    <div class="databox-left no-padding">
                                        <img src="img/profile_small.png" style="width:65px; height:65px;">
                                    </div>
                                    <div class="databox-right padding-top-20">
                                        <div class="databox-stat palegreen">
                                            <!-- <i class="stat-icon icon-xlg fa fa-phone"></i> -->
                                            <div class="widget-buttons">
                                                <div class="btn-group">
                                                    <a class="btn btn-darkorange btn-sm " href="javascript:void(0);">Manage</a>
                                                    <a class="btn btn-labeled btn-darkorange btn-sm dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);" aria-expanded="false"><i class="fa fa-angle-down"></i></a>
                                                    <ul class="dropdown-menu dropdown-blue pull-left">
                                                        <li>
                                                            <a href="profile.php">Profile</a>
                                                        </li>
                                                        <li>
                                                            <a href="update-password.php">Update password</a>
                                                        </li>
                                                        
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="databox-text darkgray"><?php echo ucfirst($wp_name); ?></div>
                                        <div class="databox-text darkgray">Type <?php echo $utype; ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="dashboard-box inst">

                                    <?php 

                                    $data = GetMultiRowsOnCondition("tbl_admin","addedby=296");
                                    $id = array();
                                    $i=1;
                                    foreach ($data as $value){
                                        $id[$i] = $value['id'];
                                        $i++;
                                    }
                                    $id[$i] = 296;
                                    
                                    //james1
                                    $data1 = GetMultiRowsOnCondition("tbl_admin","addedby=609");
                                    $id1 = array();
                                    $j=1;
                                    foreach ($data1 as $value){
                                        $id1[$j] = $value['id'];
                                        $j++;
                                    }
                                    $id1[$j] = 609;

                                    if ($_SESSION['ACTYPE'] == 'U'){?>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">Instruction</div>
                                            <div class="panel-body"><?php echo $instuction_data[0]['normalUser']?></div>
                                        </div>
                                    <?php }else if ($_SESSION['ACTYPE'] == 'M') {?>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">Instruction</div>
                                            <div class="panel-body"><?php echo $instuction_data[0]['resellerUser']?></div>
                                        </div>
                                    <?php }else{ ?>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">Instruction</div>
                                            <div class="panel-body">

                                                <div class="tabbable">
                                                    <ul class="nav nav-tabs" id="myTab">
                                                        <li class="active">
                                                            <a data-toggle="tab" href="#home">
                                                                Users
                                                            </a>
                                                        </li>

                                                        <li class="tab-red">
                                                            <a data-toggle="tab" href="#profile">
                                                                Resellers
                                                            </a>
                                                        </li>
                                                    </ul>

                                                    <div class="tab-content">
                                                        <div id="home" class="tab-pane in active">
                                                            <?php echo $instuction_data[0]['normalUser']?>
                                                        </div>

                                                        <div id="profile" class="tab-pane">
                                                            <?php echo $instuction_data[0]['resellerUser']?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <?php }?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="orders-container">
                            <div class="orders-header">
                                <h6>Important Updates</h6>
                            </div>
                            <ul class="orders-list">
                                <?php if(count($addDatas)>0){?> 
                                    <?php foreach ($addDatas as $key => $addData): ?>
                                        <li class="order-item">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 item-left">
                                                    <div class="item-booker"><?php echo $addData['image_name1']; ?></div>
                                                    <div class="item-time">
                                                        <i class="fa fa-calendar"></i>
                                                        <span><?php echo DayMonthYearTimeCounter($addData['creationdate']); ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    <?php endforeach ?>
                                <?php }else{ ?>
                                    <li class="order-item top">
                                        <div class="row">
                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 item-left">
                                                <div class="item-booker">No Updates!</div>
                                            </div>
                                        </div>
                                        <a class="item-more" href="">
                                            <i></i>
                                        </a>
                                    </li>
                                <?php } ?>
<!--                                     <li class="order-item">
                                        <div class="row">
                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 item-left">
                                                <div class="item-booker">Steve Lewis</div>
                                                <div class="item-time">
                                                    <i class="fa fa-calendar"></i>
                                                    <span>5th July</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 item-right">
                                                <div class="item-price">
                                                    <span class="currency">$</span>
                                                    <span class="price">340</span>
                                                </div>
                                            </div>
                                        </div>
                                        <a class="item-more" href="">
                                            <i></i>
                                        </a>
                                    </li> -->
                                </ul>
                                <div class="orders-footer">
                                    <a class="show-all" href=""><i class="fa fa-angle-down"></i> Show All</a>
                                    <div class="help">
                                        <a href=""><i class="fa fa-question"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php 

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

                    ?>
                    <div class="row">
                        <?php if ($_SESSION['ACTYPE'] != 'A'): ?>


                            <div class="col-lg-4 col-sm-12 col-xs-12">
                                <div class="widget flat radius-bordered">
                                    <div class="widget-header bordered-bottom bordered-themeprimary">
                                        <i class="widget-icon fa fa-tasks themeprimary"></i>
                                        <span class="widget-caption themeprimary">Credit History</span>
                                    </div><!--Widget Header-->
                                    <div class="widget-body no-padding">
                                        <div class="task-container">
                                            <ul class="tasks-list">
                                                <?php    foreach($HistoryList as $list) {  ?>
                                                    <li class="task-item" id="list_<?php echo $list['id']; ?>">
                                                        <div class="task-check">
                                                            <label>
                                                                <input type="checkbox">
                                                                <span class="text"></span>
                                                            </label>
                                                        </div>
                                                        <div class="task-state">
                                                            <span class="label label-green">
                                                                <?php
                                                                $UserDetail = GetSingleRow(ADMIN, $list['uid']);
                                                                echo ucwords($UserDetail['name']); 
                                                                ?>
                                                            </span>
                                                        </div>
                                                        <div class="task-time"><?php echo DayMonthYear($list['datee']); ?></div>
                                                        <div class="task-body">
                                                            Details : 
                                                            <?php echo $list['detail']; ?></div>
                                                            <div class="task-creator">Balance : <a href="#"><?php echo $list['balance']; ?></a></div>
                                                            <!-- <div class="task-assignedto">assigned to you</div> -->
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                        </div><!--Widget Body-->
                                    </div>

                                </div>
                            <?php endif ?>
                            <div class=" <?php if($_SESSION['ACTYPE'] == 'A'){ ?> col-lg-12 <?php }else{ ?> col-lg-8 <?php  } ?> col-sm-12 col-xs-12">
                                <div class="row">
                                    <div class="col-lg-12">

                                        <div class="widget flat radius-bordered">
                                            <div class="widget-header bg-magenta">
                                                <span class="widget-caption">Daily Files Report</span>
                                            </div><!--Widget Header-->
                                            <div class="widget-body bordered-left bordered-magenta">

                                                <?php 

                                                $dateTemp = date ( 'd-m-Y' );
                                                $dateTempForQry = date ( 'Y-m-d' );
                                                $totalFiles = GetNumOfRecordsOnCondition ( 'orders', " msgdate='" . $dateTempForQry . "'" );
                                                $rejectedFile = GetNumOfRecordsOnCondition ( 'orders', " msgdate='" . $dateTempForQry . "' and deduct is not null and deduct<>'' and concat('',deduct * 1) <> deduct" );
                                                $confirmedFile = GetNumOfRecordsOnCondition ( 'orders', " msgdate='" . $dateTempForQry . "' and confirmedlist is not null and confirmedlist<>'' and concat('',deduct * 1) = deduct" );
                                                $processingFile = GetNumOfRecordsOnCondition ( 'orders', " msgdate='" . $dateTempForQry . "' and (confirmedlist is null or confirmedlist='') and concat('',deduct * 1) = deduct" );
                                                $pendingFile = GetNumOfRecordsOnCondition ( 'orders', " msgdate='" . $dateTempForQry . "' and (confirmedlist is null or confirmedlist='') and (deduct is null or deduct='')" );

                                                ?>

                                                <div class="row">
                                                    <div class="col-sm-10 col-lg-3">
                                                        <div class="card">
                                                            <div class="card" style="width: 18rem;">
                                                                <div class="card-body">
                                                                    <h4 class="card-title"><strong>Total Files</strong></h4>
                                                                    <h4 class="card-subtitle mb-2 text-muted"><?php echo $totalFiles;?></h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-10 col-lg-3">
                                                        <div class="card">
                                                            <div class="card" style="width: 18rem;">
                                                                <div class="card-body">
                                                                    <h5 class="card-title"><strong>Confirmed Files</strong></h5>
                                                                    <h4 class="card-subtitle mb-2 text-muted"><?php echo $confirmedFile;?></h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-10 col-lg-3">
                                                        <div class="card">
                                                            <div class="card" style="width: 18rem;">
                                                                <div class="card-body">
                                                                    <h5 class="card-title"><strong>Processing files</strong></h5>
                                                                    <h4 class="card-subtitle mb-2 text-muted"><?php echo $processingFile;?></h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-10 col-lg-3">
                                                        <div class="card">
                                                            <div class="card" style="width: 18rem;">
                                                                <div class="card-body">
                                                                    <h5 class="card-title"><strong>Pending Files</strong></h5>
                                                                    <h4 class="card-subtitle mb-2 text-muted"><?php echo $pendingFile;?></h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-10 col-lg-3">
                                                        <div class="card">
                                                            <div class="card" style="width: 18rem;">
                                                                <div class="card-body">
                                                                    <h5 class="card-title"><strong>Rejected Files</strong></h5>
                                                                    <h4 class="card-subtitle mb-2 text-muted"><?php echo $rejectedFile;?></h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div><!--Widget Body-->
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Page Body -->
                </div>
                <!-- /Page Content -->

            </div>
            <!-- /Page Container -->
            <!-- Main Container -->

        </div>

        <!--Basic Scripts-->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/slimscroll/jquery.slimscroll.min.js"></script>

        <!--Beyond Scripts-->
        <script src="assets/js/beyond.js"></script>


        <!--Page Related Scripts-->
        <!--Sparkline Charts Needed Scripts-->
        <script src="assets/js/charts/sparkline/jquery.sparkline.js"></script>
        <script src="assets/js/charts/sparkline/sparkline-init.js"></script>

        <!--Easy Pie Charts Needed Scripts-->
<!--         <script src="assets/js/charts/easypiechart/jquery.easypiechart.js"></script>
        <script src="assets/js/charts/easypiechart/easypiechart-init.js"></script> -->

        <!--Flot Charts Needed Scripts-->
<!--         <script src="assets/js/charts/flot/jquery.flot.js"></script>
        <script src="assets/js/charts/flot/jquery.flot.resize.js"></script>
        <script src="assets/js/charts/flot/jquery.flot.pie.js"></script>
        <script src="assets/js/charts/flot/jquery.flot.tooltip.js"></script>
        <script src="assets/js/charts/flot/jquery.flot.orderBars.js"></script> -->
</body>
<!--  /Body -->
</html>

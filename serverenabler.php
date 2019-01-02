<?php
ob_start();
	require_once 'functions/Constants.php';
	require_once 'functions/ConfigClass.php';
	require_once 'functions/SiteFunctions.php';
	require_once 'functions/Session.php';
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
                        <li class="active">Update Managers Details</li>
                    </ul>
                </div>
                <!-- /Page Breadcrumb -->
                <!-- Page Header -->
                <div class="page-header position-relative">
                    <div class="header-title">
                        <h1>
                            Update Managers Details
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
                                        <span class="widget-caption">Current Rules :</span>
                                        
                                    </div>

                                    <div class="widget-body">

<?php 
$rulelist = GetMultiRows('btn_rules');

foreach($rulelist as $rule) {
echo '<div style="/*width:100%; padding:20px;height:60px;background:#f3f3f3;border-radius:10px;*/" class="server_time">
<a href="'.SITEURL.'edit-rule.php?id='.$rule['id'].'"><h4>'.$rule['day'].' - '.$rule['hr'].':'.$rule['mn'].$rule['pr'].' to '.$rule['shr'].':'.$rule['smn'].$rule['spr'].'</h4></a><div style="/*float:right; color:red;cursor:pointer;*/" class="server_time_rm" onClick="remove('.$rule['id'].')"><span class="btn btn-danger"><i class="fa fa-trash-o"></i> Remove</span></div>
            </div>';}
?>
<h1>Add Rule:</h1>
<div class="form-group" style="clear:both;">
<h2>Day:</h2>
  <select class="form-control" id="day" name="day">
    <option>Sunday</option>
    <option>Monday</option>
    <option>Tuesday</option>
    <option>Wednesday</option>
    <option>Thursday</option>
    <option>Friday</option>
    <option>Saturday</option>
  </select>
<div class="row">
<div class="col-lg-12">
<h2>Start time:</h2>
</div>
<div class="col-xs-4">
  <label for="hr">Hour:</label>
  <input type="number" name="hr" id="hr" class="form-control" max=12 min=0>
</div><div class="col-xs-4">
  <label for="mn">Minute:</label>
  <input  type="number" name="mn" id="mn" class="form-control" max=60 min=0>
</div><div class="col-xs-4">
  <label for="pr">Period</label>
  <select class="form-control" id="pr" name="pr">
    <option>AM</option>
    <option>PM</option>
  </select>
</div>
</div>
</div>

<div class="row">
<div class="col-lg-12"><h2>Stop time:</h2></div>
</div>

<div class="row">
<div class="col-xs-4">
  <label for="shr">Hour:</label>
  <input type="number" name="shr" id="shr" class="form-control" max=12 min=0>
</div>
<div class="col-xs-4">
  <label for="smn">Minute:</label>
  <input type="number" name="smn" id="smn" class="form-control" max=60 min=0>
</div>
<div class="col-xs-4">
  <label for="spr">Period</label>
  <select class="form-control" id="spr" name="spr">
    <option>AM</option>
    <option>PM</option>
  </select>
</div>
</div>
<div class="row">
<div class="col-lg-12">
    <br>
    <div class='btn btn-primary float-right' onClick="save();" style="float: right;">Save</div>
</div>
</div>


        </div>
    </div>

                <div class="row"></div>
          	
        <?php include_once 'files/Footer.php'; ?>

        </div>
    </div>

    <script>
function save() {
var xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        location=location;
    }
};
var day = document.getElementById('day').value;
var hr = document.getElementById('hr').value;
var shr = document.getElementById('shr').value;
var mn = document.getElementById('mn').value;
var smn = document.getElementById('smn').value;
var pr = document.getElementById('pr').value;
var spr = document.getElementById('spr').value;
xhttp.open("GET", "add-rule.php?day="+day+"&shr="+hr+"&smn="+mn+"&sthr="+shr+"&stmn="+smn+"&pr="+pr+"&spr="+spr, true);
xhttp.send();
}
function remove(id) {
var xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        location=location;
    }
};
xhttp.open("GET", "delete-rule.php?id="+id, true);
xhttp.send();
location = location;
}
    </script>
</body>
</html>

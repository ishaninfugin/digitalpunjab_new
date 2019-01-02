<?php
ob_start();
require_once 'functions/Constants.php';
require_once 'functions/ConfigClass.php';
require_once 'functions/SiteFunctions.php';
require_once 'functions/AdminFunctions.php';
require_once 'functions/Session.php';
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
                        <li class="active">Available Numbers</li>
                    </ul>
                </div>
                <!-- /Page Breadcrumb -->
                <!-- Page Header -->
                <div class="page-header position-relative">
                    <div class="header-title">
                        <h1>
                            Available Numbers
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
                                    <span class="widget-caption">Available Numbers</span>
                                    
                                </div>

                                <div class="widget-body">
<div class="row">
<?php
$gd = $_GET['date'];
if ($gd == ''  || $gd == null) $gd = date("Y-m-d");
echo '<div class="col-lg-12"><h1>'.$gd.'</h1></div>';
$ans = GetMultiRowsOnCondition('employee_numbers', '`assigned_ts` = "'.$gd.'" AND `assigned`="'.$_SESSION['ADMINID'].'"');
echo '<div class="col-lg-6 col-xs-12"><h2>India:</h2>';
foreach ($ans as $n){
if ($n['type'] == 1) echo '<div id="d'.$n['id'].'">'.$n['number'].'<div style="display:none;float:right;font-size:13px;cursor:pointer;color:red;" onClick="remove(\''.$n['id'].'\');"><u>Remove</u></div></div><br>';
}
echo '</div><div class="col-lg-6 col-xs-12"><h2>US:</h2>';
foreach ($ans as $n){
if ($n['type'] == 2) echo '<div id="d'.$n['id'].'">'.$n['number'].'<div style="display:none;float:right;font-size:13px;cursor:pointer;color:red;" onClick="remove(\''.$n['id'].'\');"><u>Remove</u></div></div><br>';
}
/*
foreach ($ans as $n){
if ($n['type'] == 0) $un = $n['number'];
else $in = $n['number'];
}
$tr=0;
if (count($in) > count($us)) $tr = count($in);
else $tr = count($in);
while($tr>-1) {
echo '<tr><td>'.$in[$tr].'</td><td>'.$us[$tr].'</td></tr>';
*/

?>
</div></div>
<h1>Get New Numbers:</h1>
<?php 
//dont show limits
//$quota = GetSingleRowsOnCondition('employee_number_quota', 'userid='.$_SESSION['ADMINID']);
//echo '<h2>India: '.$quota['quota_in'].'&nbsp;&nbsp;&nbsp;US:'.$quota['quota_us'].'</h2>';
?>
<div class="btn btn-primary" onClick="getnumbers(1)">Get Indian Numbers</div>
<div class="btn btn-primary" onClick="getnumbers(2)">Get US Numbers</div>
<hr style="border-top: 1px solid #807474;">
<h1>Report Banned Numbers</h1>

<div class="row">

<div class="col-xs-4">
<label>Number: </label> <input type="text"  class="form-control" id='bn'>
</div>
<div class="col-xs-4"> 
<label> Date: </label> <input type="date" class="form-control" id='bdate'>
</div>
<div class="col-xs-2"> 
    <label>&nbsp;</label>
<div class="btn btn-primary form-control text-white" style="color: #fff;" onClick='report()'>Report</div>
</div>
</div>
<hr style="border-top: 1px solid #807474;">
<h1>Check History</h1>

<div class="row">
<div class="col-xs-4"> 
<label for="enddate">Start Date</label>
<input type="date" class="form-control" id='spdate'>
</div>

<div class="col-xs-2"> 
    <label>&nbsp;</label>
<div class="btn btn-primary form-control text-white" style="color: #fff;" onClick='gethistory()'>Get History</div>
</div>

</div>

</div>
    </div>


                <div class="row"></div>
       
        <?php include_once 'files/Footer.php'; ?>

        </div>
    </div>
<script>
function remove(id) {

}
function getnumbers(c) {
var xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.indexOf('s122')>-1) alert('You have exhausted your number limit. Request admin to raise your limit.');
        else if (this.responseText.indexOf('s124')>-1) alert('All numbers used. Request admin to add more numbers.');
        else location=location;
    }
};
xhttp.open("GET", "number-get.php?c="+c, true);
xhttp.send();
}
function report() {
var xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        location=location;
//console.log(this.responseText);
    }
};
xhttp.open("GET", "report-number.php?number="+document.getElementById('bn').value+"&date="+document.getElementById('bdate').value, true);
xhttp.send();
}
function gethistory()  {
location = <?php echo SITEURL; ?>"?date="+document.getElementById('spdate').value;
}
</script>
</body>
</html>

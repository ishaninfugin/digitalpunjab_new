<?php
ob_start();
require_once 'functions/Constants.php';
require_once 'functions/ConfigClass.php';
require_once 'functions/SiteFunctions.php';
require_once 'functions/AdminFunctions.php';
require_once 'functions/Session.php';
if(!AdminAccess($_SESSION['ADMINID'], array('A', 'M'))){
    die;
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
                        <li class="active">Employees Numbers</li>
                    </ul>
                </div>
                <!-- /Page Breadcrumb -->
                <!-- Page Header -->
                <div class="page-header position-relative">
                    <div class="header-title">
                        <h1>
                            Employees Numbers
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
                                        <span class="widget-caption">Edit Employee</span>
                                        
                                    </div>

                                    <div class="widget-body">

                                            <h1 class="header-fullname" id="name" style="text-transform: capitalize;"></h1>
                                            <div class="row">
                                            <div class="form-group">
                                                <div class="col-xs-3">    
                                                    <label for="in">India</label>
                                                    <input type='number' class="form-control" name='in' id='in'></input>
                                                </div>
                                                <div class="col-xs-3">  
                                                    <label for="us">US</label>
                                                    <input type='number' class="form-control" name='us' id='us'></input>
                                                </div>
                                                <div class="col-xs-3">  
                                                    <label for="re">Repeat</label>
                                                    <input type='number' class="form-control" name='re' id='re' min=0></input>
                                                    <div style="display:none" id='uid'></div>
                                                </div>
                                                 <div class="col-xs-3">  
                                                    <label for="re">&nbsp;</label>
                                                   <div class="btn btn-primary form-control" onClick='save()'><span style="color: #fff;">Save</span></div>
                                                   
                                                </div>
                                                <!--div class="col-xs-3"> 
                                                    <label>&nbsp; </label> 
                                                    <div class="btn btn-primary" onClick='save()'>Save</div>
                                                </div-->
                                            </div>


                                            <hr style="border-top: 1px solid #807474;">
                                        </div>

                                            <div class="form-group">
                                                <h1>History</h1>
                                                <div class="row">
                                                <div class="col-xs-3">  
                                                    <label for="enddate">Start Date</label>
                                                    <input type="date" class="form-control" id='startdate'>
                                                </div>
                                                <div class="col-xs-3">  
                                                    <label for="enddate">End Date</label>
                                                    <input type="date" class="form-control" id='enddate'>
                                                </div>
                                                <div class="col-xs-3">
                                                    <label>&nbsp;</label>
                                                    <div class="btn btn-primary form-control" onClick='getcount()'><span style="color: #fff;">Get Count</span></div>
                                                </div>
                                                <br><h2 id="count"></h2>
                                            </div>
                                        </div>

                                    </div>
                                </div>                <div class="row"></div>

                                <?php include_once 'files/Footer.php'; ?>

                            </div>
                        </div>
                        <script>
                            <?php 
//echo $employee['quota_us'];
                            $employee = GetSingleRowsOnCondition('employee_number_quota', 'userid='.$_GET['id']);
                            $qin = $employee['quota_in'];
                            $qus = $employee['quota_us'];
                            if ($qin == '' || $qin == ' ') $qin  = '0';
                            if ($qus == '' || $qus == ' ') $qus  = '0';

                            echo 'document.getElementById("name").innerText = "'.$employee['name'].'";';
                            echo 'document.getElementById("in").value = '.$qin.';';
                            echo 'document.getElementById("us").value = '.$qus.';';
                            echo 'document.getElementById("uid").value = '.$employee['userid'].';';
                            if($employee['repetition'] != '0' ) {
                                $dates = explode(',',rtrim(explode(';;;;', $employee['repetition'])[0], ','));
                                $diff = date_diff(date_create(date("Y-m-d")),date_create($dates[count($dates)-1]));

                                echo 'document.getElementById("re").value = '.$diff->format("%a").';';
                            }
                            ?>

                            function save() {
                                var xhttp = new XMLHttpRequest();
                                xhttp.onreadystatechange = function() {
                                    if (this.readyState == 4 && this.status == 200) {
                                        location=location;
                                    }
                                };
                                var get = "update-quota.php?qin="+document.getElementById("in").value+"&qus="+document.getElementById("us").value+"&uid="+document.getElementById("uid").value+"&re="+document.getElementById("re").value;
                                console.log(get);
                                xhttp.open("GET", get, true);
                                xhttp.send();
                            }
                            function getcount() {
                                var xhttp = new XMLHttpRequest();
                                xhttp.onreadystatechange = function() {
                                    if (this.readyState == 4 && this.status == 200) {
                                        document.getElementById("count").innerText=this.responseText;
                                    }
                                };
                                var get = "get-count.php?sd="+document.getElementById('startdate').value+"&ed="+document.getElementById('enddate').value+"&uid="+document.getElementById("uid").value;
                                xhttp.open("GET", get, true);
                                xhttp.send();
                            }
                        </script>
                    </body>
                    </html>

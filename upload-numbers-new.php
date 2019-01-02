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
                        <li class="active">Upload Numbers</li>
                    </ul>
                </div>
                <!-- /Page Breadcrumb -->
                <!-- Page Header -->
                <div class="page-header position-relative">
                    <div class="header-title">
                        <h1>
                            Upload Numbers
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
                                        <span class="widget-caption">Upload Numbers</span>
                                        
                                    </div>
                                    <div class="widget-body">

                                        <form action="number-upload.php" method="post" enctype="multipart/form-data">
                                            <div class="form-group">
                                           <span class="file-input btn btn-azure btn-file"> Select file to upload
                                            <input type="file" name="fileToUpload" id="fileToUpload" style="display: inline-block;">
                                            </span>
                                            </div>
                                            <div class="form-group">
                                            <select class="form-control" id="type" name="type" style="width:50%;">
                                                <option value='1'>India</option>
                                                <option value='2'>US</option>
                                            </select>
                                            </div>
                                            <div class="form-group">
                                            <input type="submit" value="Upload Numbers" name="submit" class="btn btn-primary">
                                        </div>
                                        </form>
                                        
                                        <h1>Reserve Numbers</h1>
                                        <div style="width:100%;">
                                            <div style="width:50%;display: inline-block;">
                                                <h1 style="display:inline-block;">India</h1><div style="float:right;font-size:13px;cursor:pointer;color:red;display:inline-block;line-height:70px;padding-right:15px;" onClick="removeall(1);"><span class="btn btn-danger"><i class="fa fa-trash-o"></i> Remove All</span></div>
                                                <div style="clear:both;"></div>
                                                <?php
                                                $avindnumbers = GetMultiRowsOnCondition('employee_numbers', '`assigned` IS NULL AND `type`=1');
                                                $count = 1;
                                                foreach($avindnumbers as $number) {
                                                    echo '<div style="color:black;width:100%;padding:20px;font-size:15px;" id="d'.$number['id'].'">'.$count.'. '.$number['number'].'<div style="float:right;font-size:13px;cursor:pointer;color:red;" onClick="remove(\''.$number['id'].'\');"><span class="btn btn-danger"><i class="fa fa-trash-o"></i> Remove </span></div></div>';
                                                    $count = $count+1;
                                                }
                                                ?>
                                            </div>
                                            <div style="width:50%;display: inline-block;float: right;">
                                                <h1 style="display:inline-block;">US</h1><div style="float:right;font-size:13px;cursor:pointer;color:red;display:inline-block;line-height:70px;padding-right:15px;" onClick="removeall(2);"><span class="btn btn-danger"><i class="fa fa-trash-o"></i> Remove All</span></div>
                                                <?php
                                                $avindnumbers = GetMultiRowsOnCondition('employee_numbers', '`assigned` IS NULL AND `type`=2');
                                                $count2=1;
                                                foreach($avindnumbers as $number) {
                                                    echo '<div style="color:black;width:100%;padding:20px;font-size:15px;" id="d'.$number['id'].'">'.$count2.'. '.$number['number'].'<div style="float:right;font-size:13px;cursor:pointer;color:red;" onClick="remove(\''.$number['id'].'\');"><span class="btn btn-danger"><i class="fa fa-trash-o"></i> Remove</span></div></div>';
                                                    $count2 = $count2+1;
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <hr style="border-top: 1px solid #807474;">
                                        <h1>Banned Numbers</h1>
                                        <?php
                                        $bannednumbers = GetMultiRows('reported_numbers');
                                        $count3=1;
                                        foreach($bannednumbers as $number) {
                                            echo '<div style="color:black;width:100%;padding:20px;font-size:15px;" id="r'.$number['id'].'">'.$count3.'. '.$number['number'].'  <font color="gray">'.$number['username'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font><div style="display:inline-block;font-size:13px;cursor:pointer;color:red;" onClick="removern(\''.$number['id'].'\');"><span class="btn btn-danger"><i class="fa fa-trash-o"></i> Remove</span></div></div>';
                                            $count3++;
                                        }
                                        ?>

                                    </div>
                                </div>
                                <div class="row"></div>

                            <?php include_once 'files/Footer.php'; ?>

                        </div>
                    </div>

                    <script type="text/javascript">
                        function remove(id) {
                            document.getElementById('d'+id).style.opacity=0.3;
                            var xhttp = new XMLHttpRequest();
                            xhttp.onreadystatechange = function() {
                                if (this.readyState == 4 && this.status == 200) {
                                    document.getElementById('d'+id).remove();
                                }
                            };
                            xhttp.open("GET", "delete-number.php?id="+id, true);
                            xhttp.send();
                        }
                        function removern(id) {
                            document.getElementById('r'+id).style.opacity=0.3;
                            var xhttp = new XMLHttpRequest();
                            xhttp.onreadystatechange = function() {
                                if (this.readyState == 4 && this.status == 200) {
                                    document.getElementById('r'+id).remove();
                                }
                            };
                            xhttp.open("GET", "delete-report.php?id="+id, true);
                            xhttp.send();
                        }
                        function removeall(id) {
                            var xhttp = new XMLHttpRequest();
                            xhttp.onreadystatechange = function() {
                                if (this.readyState == 4 && this.status == 200) {
                                    location=location;
                                }
                            };
                            xhttp.open("GET", "delete-all-numbers.php?id="+id, true);
                            xhttp.send();
                        }
                    </script>
                </body>
                </html>

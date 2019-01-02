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
                                        <span class="widget-caption">Add Rule :</span>
                                        
                                    </div>

                                    <div class="widget-body">
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
</div>
<div class="row">
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
  <div class="col-lg-12">
<h2>Stop time:</h2>
</div>
</div>

<div class="row">
<div class="col-xs-4">
  <label for="shr">Hour:</label>
  <input type="number" name="shr" id="shr" class="form-control" max=12 min=0>
</div><div class="col-xs-4">
  <label for="smn">Minute:</label>
  <input type="number" name="smn" id="smn" class="form-control" max=60 min=0>
</div><div class="col-xs-4">
  <label for="spr">Period</label>
  <select class="form-control" id="spr" name="spr">
    <option>AM</option>
    <option>PM</option>
  </select>
</div>
</div>


<h1>Users:</h1>
<div class="row">
<div id="users"></div>
<div class="col-xs-4">
<div class="form-group">
  <br><br>
<input type="text" class="form-control" id="myInput" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name">
<ul id="myUL" class="dd-list" style="display:none;">
  <li id="a2" class="dd-item bordered-inverse"><a onClick="addname('a2')">Adele</a></li>
</ul>
</div>
</div>
<div class="col-xs-4">
<div class="form-group">
<br><br>
<div class='btn btn-primary' style="float:left;color:white;background:#1ab394" onClick="save();">Save</div>
</div>
</div>
</div>
        </div>
    </div>
</div>
                <div class="row"></div>
          	</div>
        <?php include_once 'files/Footer.php'; ?>

        </div>
    </div>

    <!-- Mainly scripts -->
    <script>

<?php
$USerList = GetMultiRows('tbl_admin');
$idr = $_GET['id'];
echo 'var ruleid='.$idr.';';
$asd = GetSingleRow('btn_rules',$idr); 

$au = $asd['aua'];
foreach($USerList as $USerDetail) {
if (strpos($au, ';'.$USerDetail['id'].';') !== false) {
echo 'freshlist("'.$USerDetail['id'].'", "'.$USerDetail['username'].'");';
} else {
echo 'freshul("'.$USerDetail['id'].'", "'.$USerDetail['username'].'");';
}
}

echo "document.getElementById('day').value='".$asd['day'] ;
echo "';document.getElementById('hr').value=".$asd['hr'] ;
echo ";document.getElementById('shr').value=". $asd['shr'] ;
echo ";document.getElementById('mn').value=" .$asd['mn'] ;
echo ";document.getElementById('smn').value=". $asd['smn'] ;
echo ";document.getElementById('pr').value='" .$asd['pr'] ;
echo "';document.getElementById('spr').value='" .$asd['spr'] ;
echo "';\n";
?>
var allwdusrs='';
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
allowed_users();
var get = "update-rule.php?day="+day+"&shr="+hr+"&smn="+mn+"&sthr="+shr+"&stmn="+smn+"&pr="+pr+"&spr="+spr+"&au="+allwdusrs+"&id="+ruleid;
//console.log(get);
xhttp.open("GET", get, true);
xhttp.send();
}
function allowed_users() {
allwdusrs='';
var asd = document.querySelectorAll('#users div');
for (var i=0; i<asd.length;i++) {
allwdusrs += asd[i].id+';';
//console.log(allwdusrs)
}
}
function myFunction() {
    var input, filter, ul, li, a, i, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    if (filter == '') {
    	document.getElementById("myUL").style.display = "none";
    } else {
      document.getElementById("myUL").style.display = "";
      ul = document.getElementById("myUL");
      li = ul.getElementsByTagName("li");
      for (i = 0; i < li.length; i++) {
          a = li[i].getElementsByTagName("a")[0];
          txtValue = a.textContent || a.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
              li[i].style.display = "";
          } else {
              li[i].style.display = "none";
          }
      }
    }
}
function addname(id) {
var elem = "<div id='"+id.toString().replace('a', '')+"' style='/*width:100%; padding:20px;height:60px;background:#f3f3f3;border-radius:10px;*/' class='server_time'><h4>"+document.getElementById(id).innerText+"</h4><div style='float:right;' class='server_time_rm' onClick='addul("+id.toString().replace('a', '')+")'><span class='btn btn-danger'> <i class='fa fa-trash-o'></i> Remove</span></div></div>";
$("#users").append(elem);
remove(id);
}
function remove(id) {
document.getElementById(id).remove();
}
function addul(id) {
var a = '<li id="a'+id+'" class="dd-item bordered-inverse"><a class="dd-handle" onClick="addname(\'a'+id+'\')">'+document.getElementById(id).innerText.replace('Remove', '')+'</a></li>';
$("#myUL").append(a);
remove(id);
}
function freshul(id, name) {
var a = '<li id="a'+id+'" class="dd-item bordered-inverse"><a class="dd-handle" onClick="addname(\'a'+id+'\')">'+name+'</a></li>';
$("#myUL").append(a);
}
function freshlist(id, name) {
var a = "<div id='"+id+"' style='/*width:100%; padding:20px;height:60px;background:#f3f3f3;border-radius:10px;*/' class='server_time'><a href='javascript:void(0)'><h4>"+name+"</h4></a><div style='float:right;' class='server_time_rm' onClick='addul("+id+")'><span class='btn btn-danger'> <i class='fa fa-trash-o'></i> Remove</span></div></div>";
$("#users").append(a);
}
    </script>
</body>
</html>

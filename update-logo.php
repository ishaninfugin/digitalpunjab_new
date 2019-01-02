<?php
ob_start();
	require_once 'functions/Constants.php';
	require_once 'functions/ConfigClass.php';
	require_once 'functions/SiteFunctions.php';
	require_once 'functions/AdminFunctions.php';
	require_once 'functions/Session.php';
	
	$PageTitle = 'Update Logo';
	$menuName = 'update-logo';
	if(isset($_REQUEST['LogoUpdate'])) {
		
		$File_Name          = strtolower($_FILES['logo']['name']);
		$File_Size          = strtolower($_FILES['logo']['size']);
		$File_Ext           = substr($File_Name, strrpos($File_Name, '.')); //get file extention
		$Random_Number      = rand(0, 9999999999); //Random number to be added to name.
		$NewFileName 		= $Random_Number.$File_Ext; //new file name
		
		$UploadDirectory	= 'uploads/';
		$file_link = $UploadDirectory.$NewFileName;
		
		$slogan = mysql_real_escape_string($_REQUEST['slogan']);
		$data = "slogan = '".$slogan."'";
		$condition = 'id = 1';
		UpdateRowOnCondition(SITELOGO, $data, $condition);
		
		if(!empty($File_Name)) {
			if(move_uploaded_file($_FILES['logo']['tmp_name'], $UploadDirectory.$NewFileName )) {
				$data = "logopath = '".$file_link."', logosize = '".$File_Size."' ";
				$condition = 'id = 1';
				UpdateRowOnCondition(SITELOGO, $data, $condition);
			}
			else {
				$_SESSION['ERROR'] = 'Opps Somthing was wrong. Try again..';
			}
		}
	}
	
	$LogoDetail = GetSingleRow(SITELOGO, 1);
?>


<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $PageTitle; ?></title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Toastr style -->
    <link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">

    <!-- Gritter -->
    <link href="js/plugins/gritter/jquery.gritter.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

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
                <h5>Update Logo</h5>
            </div>
            <div class="ibox-content">


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

                <form method="post" class="form-horizontal" enctype="multipart/form-data">
                    <div class="form-group"><label class="col-sm-2 control-label">Select Logo</label>
                        <div class="col-sm-10">
                        <input type="file" name="logo" class="form-control"> <br />
                        <img src="<?php if(!empty($LogoDetail['logopath'])) echo SITEURL.$LogoDetail['logopath']; else echo '../img/logo.png'; ?>" style="width:190px;" />
                        </div>
                    </div>
                    
                    <div class="form-group"><label class="col-sm-2 control-label">Slogan</label>
                        <div class="col-sm-10">
                        <input type="text" name="slogan" class="form-control" value="<?php echo $LogoDetail['slogan']; ?>"> 
                        
                        </div>
                    </div>
                                                
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <button class="btn btn-primary" name="LogoUpdate" type="submit">Update Logo</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>                   
                    
                    

            	</div>
        <?php include_once 'files/Footer.php'; ?>

        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Flot -->
    <script src="js/plugins/flot/jquery.flot.js"></script>
    <script src="js/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="js/plugins/flot/jquery.flot.spline.js"></script>
    <script src="js/plugins/flot/jquery.flot.resize.js"></script>
    <script src="js/plugins/flot/jquery.flot.pie.js"></script>

    <!-- Peity -->
    <script src="js/plugins/peity/jquery.peity.min.js"></script>
    <script src="js/demo/peity-demo.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

    <!-- jQuery UI -->
    <script src="js/plugins/jquery-ui/jquery-ui.min.js"></script>

    <!-- GITTER -->
    <script src="js/plugins/gritter/jquery.gritter.min.js"></script>

    <!-- Sparkline -->
    <script src="js/plugins/sparkline/jquery.sparkline.min.js"></script>

    <!-- Sparkline demo data  -->
    <script src="js/demo/sparkline-demo.js"></script>

    <!-- ChartJS-->
    <script src="js/plugins/chartJs/Chart.min.js"></script>

    <!-- Toastr -->
    <script src="js/plugins/toastr/toastr.min.js"></script>


    
</body>
</html>

                            
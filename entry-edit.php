<?php
ob_start();
	require_once 'functions/Constants.php';
	require_once 'functions/ConfigClass.php';
	require_once 'functions/SiteFunctions.php';
	require_once 'functions/AdminFunctions.php';
	require_once 'functions/Session.php';
	
	$PageTitle = 'Update Entry';
	
	$menuName = 'entry';
	$submenuName = 'entry-list';
	
	####@@@ CHECK BELT ID
	if(isset($_REQUEST['id'])) {
		$EntryId = intval($_REQUEST['id']);
	}
	else {
		echo "<script> window.location.href = '".SITEURL."'; </script>";
		exit();
	}
	
	if(isset($_REQUEST['SubmitEntry'])) {
		$entry_date = $_REQUEST['entry_date'];
		$sr_id = $_REQUEST['sr_id'];
		$town_id = $_REQUEST['town_id'];
		$belt_id = intval($_REQUEST['belt_id']);
		$num_visit = mysql_real_escape_string(trim(strtolower($_REQUEST['num_visit'])));
		$num_active = mysql_real_escape_string(trim(strtolower($_REQUEST['num_active'])));
		$opening_stock = mysql_real_escape_string(trim(strtolower($_REQUEST['opening_stock'])));
		$retailing_stock = mysql_real_escape_string(trim(strtolower($_REQUEST['retailing_stock'])));
		$closing_stock = mysql_real_escape_string(trim(strtolower($_REQUEST['closing_stock'])));
		
		$data = "entry_date = '$entry_date', sr_id = '$sr_id', town_id = '$town_id', belt_id = '$belt_id', num_visit = '$num_visit', num_active = '$num_active', opening_stock = '$opening_stock', retailing_stock = '$retailing_stock', closing_stock = '$closing_stock'  ";	
		$condition = "id = '$EntryId' ";
		UpdateRowOnCondition(ENTRY, $data, $condition);
	}
	
	$EntryDetail = GetSingleRow(ENTRY, $EntryId);
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
    <link href="<?php echo SITEURL; ?>css/animate.css" rel="stylesheet">
    <link href="<?php echo SITEURL; ?>css/style.css" rel="stylesheet">

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
                <h5>Create Belt</h5>
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

                <form method="post" class="form-horizontal info">
                    <div class="form-group"><label class="col-sm-2 control-label">Entry Date</label>
                        <div class="col-sm-10">
                        <input type="date" name="entry_date" class="form-control validate[required]" 
                        value="<?php echo $EntryDetail['entry_date']; ?>">
                        </div>
                    </div>
                    
                    <div class="form-group"><label class="col-sm-2 control-label">Select SR</label>
                        <div class="col-sm-10">
                        <select name="sr_id" class="form-control validate[required]" <?php if($_SESSION['ACTYPE'] == 'U') { echo 'disabled'; } ?> >
							<?php
								$condition = "actype = 'U'";
								$USerList = GetMultiRowsOnCondition(ADMIN, $condition);
								foreach($USerList as $USerDetail) {
									if($USerDetail['id'] == $EntryDetail['sr_id']) {
										echo '<option value="'.$USerDetail['id'].'" selected> '.ucwords($USerDetail['name']).' </option>';
									}
									else {
										echo '<option value="'.$USerDetail['id'].'"> '.ucwords($USerDetail['name']).' </option>';
									}
								}
							?>
                        </select>
                        </div>
                    </div>
                    
                    <div class="form-group"><label class="col-sm-2 control-label">Select Town</label>
                        <div class="col-sm-10">
                        <select name="town_id" class="form-control validate[required]" onChange="LoadBelt(this.value)">
                        	<option value> Select Town </option>
							<?php
								$TownList = GetMultiRows(TOWN);
								foreach($TownList as $TownDetail) {
									if($TownDetail['id'] == $EntryDetail['town_id']) {
										echo '<option value="'.$TownDetail['id'].'" selected> '.ucwords($TownDetail['title']).' </option>';
									}
									else {
										echo '<option value="'.$TownDetail['id'].'"> '.ucwords($TownDetail['title']).' </option>';
									}
								}
							?>
                        </select>
                        </div>
                    </div>
                    
                    <div class="form-group"><label class="col-sm-2 control-label">Belt</label>
                        <div class="col-sm-10" id="BeltSection">
                        <?php
							$BeltDetail = GetSingleRow(BELT, $EntryDetail['belt_id']);
						?>
                        <input type="text" disabled name="capacity" class="form-control" value="<?PHP echo $BeltDetail['title']; ?>">
                        <input type="hidden" name="belt_id" value="<?php echo $EntryDetail['belt_id']; ?>" />
                        </div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label">No. Of Visit</label>
                        <div class="col-sm-10">
                        <input type="text" name="num_visit" class="form-control" value="<?php echo $EntryDetail['num_visit']; ?>">
                        </div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label">No. Of Active</label>
                        <div class="col-sm-10">
                        <input type="text" name="num_active" class="form-control" value="<?php echo $EntryDetail['num_active']; ?>">
                        </div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label">Opening Stock</label>
                        <div class="col-sm-10">
                        <input type="text" name="opening_stock" class="form-control" id="OpeningStock" value="<?php echo $EntryDetail['opening_stock']; ?>" >
                        </div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label">Retailing Stock </label>
                        <div class="col-sm-10">
                        <input type="text" name="retailing_stock" class="form-control" id="RetailingStock" value="<?php echo $EntryDetail['retailing_stock']; ?>">
                        </div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label">Closing Stock </label>
                        <div class="col-sm-10">
                        <input type="text" name="closing_stock" class="form-control" id="ClosingStock" value="<?php echo $EntryDetail['closing_stock']; ?>">
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <button class="btn btn-primary" name="SubmitEntry" type="submit">Submit Entry</button>
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

    <script src="<?php echo SITEURL; ?>js/jquery-2.1.1.js"></script>
    <script src="<?php echo SITEURL; ?>js/bootstrap.min.js"></script>
    <script src="<?php echo SITEURL; ?>js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo SITEURL; ?>js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="<?php echo SITEURL; ?>js/plugins/flot/jquery.flot.js"></script>
    <script src="<?php echo SITEURL; ?>js/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="<?php echo SITEURL; ?>js/plugins/flot/jquery.flot.spline.js"></script>
    <script src="<?php echo SITEURL; ?>js/plugins/flot/jquery.flot.resize.js"></script>
    <script src="<?php echo SITEURL; ?>js/plugins/flot/jquery.flot.pie.js"></script>
    <script src="<?php echo SITEURL; ?>js/plugins/peity/jquery.peity.min.js"></script>
    <script src="<?php echo SITEURL; ?>js/demo/peity-demo.js"></script>
    <script src="<?php echo SITEURL; ?>js/inspinia.js"></script>
    <script src="<?php echo SITEURL; ?>js/plugins/pace/pace.min.js"></script>
    <script src="<?php echo SITEURL; ?>js/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="<?php echo SITEURL; ?>js/plugins/gritter/jquery.gritter.min.js"></script>
    <script src="<?php echo SITEURL; ?>js/plugins/sparkline/jquery.sparkline.min.js"></script>
    <script src="<?php echo SITEURL; ?>js/demo/sparkline-demo.js"></script>

    <link rel="stylesheet" href="<?php echo SITEURL; ?>valideation/validationEngine.jquery.css" type="text/css" />
    <script type="text/javascript" src="<?php echo SITEURL; ?>valideation/jquery-1.7.2.min.js"></script>
    <script src="<?php echo SITEURL; ?>valideation/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo SITEURL; ?>valideation/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <script>
        var $j = jQuery.noConflict();
        $j(document).ready(function(){
            $j(".info").validationEngine();
        });
    </script>
    
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<script type="text/javascript">
     $(document).ready(function(){ 
        $("#OpeningStock").change(function() { 
            var OpeningStock = $("#OpeningStock").val();
			var RetailingStock = $("#RetailingStock").val();
			var ClosingStock =  OpeningStock - RetailingStock;
            $("#ClosingStock").val(ClosingStock);
		});
		
		$("#RetailingStock").change(function() { 
            var OpeningStock = $("#OpeningStock").val();
			var RetailingStock = $("#RetailingStock").val();
			var ClosingStock =  OpeningStock - RetailingStock;
            $("#ClosingStock").val(ClosingStock);
		}); 
		
	 });
	 
	 function LoadBelt(townId) {
	 	$("#BeltSection").load("<?php echo SITEURL; ?>load-belt.php?townId="+townId);
	 }
		
    </script>
    
    
</body>
</html>
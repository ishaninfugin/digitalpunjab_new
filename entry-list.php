<?php
	require_once 'functions/Constants.php';
	require_once 'functions/ConfigClass.php';
	require_once 'functions/SiteFunctions.php';
	require_once 'functions/AdminFunctions.php';
	require_once 'functions/Session.php';
	
	$PageTitle = 'Entry List';
	$menuName = 'entry';
	$submenuName = 'entry-list';
	
	#### UPDATE USER DETAIL 
	if(isset($_REQUEST['editId'])) {
		$editId = intval($_REQUEST['editId']);
		echo "<script> window.location.href = 'entry-edit.php?id=".$editId."'; </script>";
		exit();
	}
	
	$EntryList = GetMultiRows(ENTRY);
	
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
                <h5>Entry List</h5>
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

<div id="errormsg"> </div>

<table class="table table-striped table-bordered table-hover " id="editable" >
            <thead>
            <tr>
                <th width="70">Sr. No.</th>
                <th width="120">Date</th>
                <th width="120">SR Name</th>
                <th width="120">Town</th>
                <th width="120">Belt</th>
                <th width="120">Visit</th>
                <th width="120">Active</th>
                <th width="150">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
				$sr=1;
				foreach($EntryList as $EntryDetail) {
					?>
                    <tr class="gradeX" id="list_<?php echo $EntryDetail['id']; ?>">
                        <td><?php echo $sr++; ?></td>
                        <td><?php echo DayMonthYear($EntryDetail['entry_date']); ?></td>
                        <td><?php 
								$SRDetail = GetSingleRow(ADMIN, $EntryDetail['sr_id']);
								echo ucwords($SRDetail['name']); ?></td>
                        <td><?php 
								$TownDetail = GetSingleRow(TOWN, $EntryDetail['town_id']);
								echo ucwords($TownDetail['title']); ?></td>
                        <td><?php 
								$BeltDetail = GetSingleRow(BELT, $EntryDetail['belt_id']);
								echo ucwords($BeltDetail['title']); ?></td>
                        <td><?php echo $EntryDetail['num_visit']; ?></td>
                        <td><?php echo $EntryDetail['num_active']; ?></td>
                        <td class="center">
                        <a href="entry-list.php?editId=<?php echo $EntryDetail['id']; ?>" class="btn btn-success btn-xs">Edit</a>
                        <a onClick="DeleteRecord('<?php echo ENTRY; ?>', <?php echo $EntryDetail['id']; ?>)" class="btn btn-danger btn-xs">Delete</a>
                        </td>
                    </tr>
                    <?php
				}
			?>

            </tbody>
            <tfoot>
            <tr>
                <th width="70">Sr. No.</th>
                <th width="120">Date</th>
                <th width="120">SR Name</th>
                <th width="120">Town</th>
                <th width="120">Belt</th>
                <th width="120">Visit</th>
                <th width="120">Active</th>
                <th width="150">Action</th>
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
    <script src="<?php echo SITEURL; ?>js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="<?php echo SITEURL; ?>js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script src="<?php echo SITEURL; ?>js/plugins/dataTables/dataTables.responsive.js"></script>
    <script src="<?php echo SITEURL; ?>js/plugins/dataTables/dataTables.tableTools.min.js"></script>
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
        $(document).ready(function() {
            $('.dataTables-example').dataTable({
                responsive: true,
                "dom": 'T<"clear">lfrtip',
                "tableTools": {
                    "sSwfPath": "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
                }
            });

            /* Init DataTables */
            var oTable = $('#editable').dataTable();

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
            } );


        });

        function fnClickAddRow() {
            $('#editable').dataTable().fnAddData( [
                "Custom row",
                "New row",
                "New row",
                "New row",
                "New row" ] );

        }
    </script>
    
    <!--- ==== DELETE RECODE ==== --->
    <script type="text/javascript">
	function DeleteRecord(tblname, id){
	  if (confirm("Are you sure you want to delete this record?")){
		var dataString = 'id='+ id + '&tblname='+ tblname;
		$.ajax({
		   type: "POST",
		   url: "deleteRecord.php",
		   data: dataString,
		   cache: false,
		   success: function(result){
			  if(result){
				 if(result=='success'){
					var randNum=Math.floor((Math.random()*100)+1);
					if(randNum % 2==0){
					   $("#list_"+id).slideUp(1000);
					}else{
					   $("#list_"+id).hide(500);
					}
				 }
				 else {
					 var errorMessage=result.substring(position+2);
					 alert(errorMessage);
				 }
			  }
			}
		});
	  }
	}
	</script>

</body>
</html>

<?php
	require_once 'functions/Constants.php';
	require_once 'functions/ConfigClass.php';
	require_once 'functions/SiteFunctions.php';
	require_once 'functions/AdminFunctions.php';
	require_once 'functions/Session.php';
	
	$PageTitle = 'Wechat Report';
	$menuName = 'reports';
	$submenuName = 'wechat-report';
	
	
	
	#### UPDATE USER DETAIL 
	if(isset($_REQUEST['deleteId'])) {
		mysql_query("delete from wechat_orders where id='".$_REQUEST['deleteId']."' and uid='".$_SESSION['ADMINID']."' and deduct=''");
	}
	$condition = "uid = '".$_SESSION['ADMINID']."' ";
	$EntryList = GetMultiRowsOnCondition('wechat_orders', $condition);

	
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
        <?php include_once 'files/Sidebar.php'; ?>
        <div id="page-wrapper" class="gray-bg dashbard-1">
        <?php include_once 'files/TopBar.php'; ?>
        
                <div class="row  border-bottom white-bg dashboard-header">


<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Wechat Entry List</h5>
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
                <th width="120">Message File</th>
                <th width="120">Images</th>
                <th width="120">Mobile No. File</th>
                <th width="150">Action</th>
				<th width="150">Confirmed Numbers</th>
				<th width="150">Status</th>
            </tr>
            </thead>
            <tbody>
            <?php
				$sr=1;
				foreach($EntryList as $EntryDetail) {
					?>
                    <tr class="gradeX" id="list_<?php echo $EntryDetail['id']; ?>">
                        <td><?php echo $sr++; ?></td>
                        <td><?php echo DayMonthYear($EntryDetail['msgdate']); ?></td>
                        <?php	if($EntryDetail['msg']){ ?>
					    <td><a href="<?php echo $EntryDetail['msg']; ?>" target="_blank">DOWNLOAD</a></td>
                        <?php }else{ echo "<td>N/A</td>"; } ?>
						<?php	if($EntryDetail['msgimage']){ ?>
						<td><a href="<?php echo $EntryDetail['msgimage']; ?>" target="_blank">DOWNLOAD</a>
						<br/>
							<?php if($EntryDetail['imagecap']){
								echo $EntryDetail['imagecap'];
								
							} ?>
						</td>

                        <?php }else{ echo "<td>N/A</td>";} ?>
						<?php	if($EntryDetail['numberfile']){ ?>
                        <td><a href="<?php echo $EntryDetail['numberfile']; ?>" target="_blank">DOWNLOAD</a></td>

                        <?php }else{ echo "<td>N/A</td>"; } ?>

                        <?php if($EntryDetail['filter']==0){?>
                            <td class="center">
                                <?php
                                if($EntryDetail['deduct']=='')
                                {
                                    ?>
                                    <a href="sr-entry-list.php?deleteId=<?php echo $EntryDetail['id']; ?>" class="btn btn-success btn-xs">Delete</a>
                                <?php }
                                else
                                {
									if(is_numeric($EntryDetail['deduct']))
									{
										echo $EntryDetail['deduct']." Msg Deducted";
									}
									else
									{
										echo $EntryDetail['deduct'];
									}
                                }
                                ?>
                            </td>
                        <?php }else{?>
                            <td class="center">
                                <?php
                                if($EntryDetail['filterdeduct']=='')
                                {
                                    ?>
                                    <a href="sr-entry-list.php?deleteId=<?php echo $EntryDetail['id']; ?>" class="btn btn-success btn-xs">Delete</a>
                                <?php }
                                else
                                {
                                    echo $EntryDetail['filterdeduct']." Filter Msg Deducted";
                                }
                                ?>
                            </td>
                        <?php }?>

					    <?php if($EntryDetail['confirmedlist']){ ?>
						
						<td><a href="<?php echo $EntryDetail['confirmedlist']; ?>" target="_blank">DOWNLOAD</a></td>
					    <?php }else{ echo "<td>N/A</td>";} ?>

                        <?php if($EntryDetail['filter']==0){?>
                            <td class="center">
                                <?php

                                if($EntryDetail['deduct']=='')
                                {
                                    ?>
                                    <span class="btn btn-danger btn-xs">Pending</span>
                                <?php }
                                else if(!is_numeric($EntryDetail['deduct'])){?>
                                    <span class="btn btn-danger btn-xs">Rejected</span>
                                <?php }
                                else if($EntryDetail['confirmedlist']){ ?>
                                    <span class="btn btn-success btn-xs">Confirmed</span>
                                <?php }else{ ?>
                                    <span class="btn btn-warning btn-xs">Processing</span>
                                <?php } ?>
                            </td>
                        <?php }else{?>
                            <td class="center">
                                <?php
                                if($EntryDetail['filterdeduct']=='')
                                {
                                    ?>
                                    <span class="btn btn-danger btn-xs">Pending</span>
                                <?php }
                                else if(!is_numeric($EntryDetail['filterdeduct'])){?>
                                    <span class="btn btn-danger btn-xs">Rejected</span>
                                <?php }
                                else if($EntryDetail['confirmedlist']){ ?>
                                    <span class="btn btn-success btn-xs">Confirmed</span>
                                <?php }else{ ?>
                                    <span class="btn btn-warning btn-xs">Processing</span>
                                <?php } ?>
                            </td>
                        <?php }?>

                    </tr>
                    <?php
				}
			?>

            </tbody>
            <tfoot>
            <tr>
                <th width="70">Sr. No.</th>
                <th width="120">Date</th>
                <th width="120">Message</th>
                <th width="120">Images</th>
                <th width="120">Mobile Number</th>
                <th width="120">Action</th>
				<th width="150">Confirmed Numbers</th>
                <th width="150">Status</th>
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
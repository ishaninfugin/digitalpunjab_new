    <div class="navbar">
        <div class="navbar-inner">
            <div class="navbar-container">
                <!-- Navbar Barnd -->
                <!-- <div class="navbar-header pull-left">
                    <a href="#" class="navbar-brand">
                        <small>
                            <img src="assets/img/logo.png" alt="" />
                        </small>
                    </a>
                </div> -->
                <!-- /Navbar Barnd -->
                <!-- Sidebar Collapse -->
                <div class="sidebar-collapse" id="sidebar-collapse">
                    <i class="collapse-icon fa fa-bars"></i>
                </div>
                <!-- /Sidebar Collapse -->
                <!-- Account Area and Settings --->
                <div class="navbar-header pull-right">
                    <div class="navbar-account">
                        <ul class="account-area">
                        	<li>
							<span class="welcome-text">Welcome 
								<?php if($_SESSION['ACTYPE'] == 'A') { ?>
									Super Admin
							<?php 
							}else{
								echo $AdminProfileDetail['name'];
							}
							?></span>
                        	</li>
                            <li>
                                <span>
                                <a href="logout.php">
                                    <i class="fa fa-sign-out"></i> Log out
                                </a>
                                </span>
                            </li>
                            <!-- /Account Area -->
                            <!--Note: notice that setting div must start right after account area list.
                            no space must be between these elements-->
                            <!-- Settings -->
                        </ul>
                        <!-- Settings -->
                    </div>
                </div>
                <!-- /Account Area and Settings -->
            </div>
        </div>
    </div>

<?php
	if($_SESSION['ACTYPE'] != 'U') {	?>
<style>
/*.navbar-header span {
  background: red none repeat scroll 0 0;
  color: #fff;
  border: 1px solid;
  border-radius: 25px;
}*/
}

</style>

<script>
setInterval(function(){
var pagetitle='<?php echo $PageTitle; ?>';	
$.ajax({
	url:'ajax-orders.php',
	type:'post',	
	success: function(data) {
       // alert(data);
		$('#notifications').html(data);
		$('#notification-tab').html( pagetitle +'('+data+')' );

    },
	
})
	//alert("Hello")
	
	
},100000);
</script>
<?php } ?>
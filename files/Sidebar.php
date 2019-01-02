<?php //echo $submenuName?>

<div class="page-sidebar" id="sidebar">
                <!-- Page Sidebar Header-->
            <!--     <div class="sidebar-header-wrapper">
                    <input type="text" class="searchinput" />
                    <i class="searchicon fa fa-search"></i>
                    <div class="searchhelper">Search Reports, Charts, Emails or Notifications</div>
                </div> -->
                <!-- /Page Sidebar Header -->
                <!-- Sidebar Menu -->
                <ul class="nav sidebar-menu">
            <?php $SS = GetSingleRowsOnCondition(ADMIN, 'id=' . $AdminProfileDetail['id']);?>
            <?php
            
            if ($_SESSION['ACTYPE'] == 'A') {
                ?>
                <li <?php if ($menuName == 'dashboard') echo 'class="active"'; ?>>
                    <a href="index.php"><i class="menu-icon glyphicon glyphicon-home"></i> <span class="menu-text">Dashboard</span></a>
                </li>
                <li <?php if ($menuName == 'user') echo 'class="active"'; ?> >
                    <a href="manager-list.php"  href="masterpassword.php" class="go_user menu-dropdown" ><i class="menu-icon glyphicon glyphicon-user"></i> <span class="menu-text">Users</span><i class="menu-expand"></i></a>
                    
                    <ul class="submenu">
                        <li <?php if ($submenuName == 'manager-staff-list') echo 'class="active"'; ?>><a href="manager-staff-list.php" >User List (Staff)</a></li>
                        <li <?php if ($submenuName == 'manager-list') echo 'class="active"'; ?>><a href="manager-list.php" >User List (Clients)</a></li>
                        <li <?php if ($submenuName == 'manager-create') echo 'class="active"'; ?>><a href="manager-create.php" >Add User</a></li>
                    </ul>
                </li>

                <li <?php if ($menuName == 'order') echo 'class="active"'; ?> >
                    <a href="order-list.php" class="menu-dropdown"><i class="menu-icon fa fa-twitch"></i> <span class="menu-text">Whatsapp Order</span>
                    <i class="menu-expand"></i></a>
                    <ul class="submenu">
                        <li <?php if ($submenuName == 'order-list') echo 'class="active"'; ?>><a href="order-list.php">Order List</a></li>
                    </ul>
                </li>
                <li <?php if ($menuName == 'wechat-order') echo 'class="active"'; ?> >
                    <a href="wechat-order-list.php" class="menu-dropdown"><i class="menu-icon fa fa-twitch"></i> <span class="menu-text">Wechat Order</span>
                    <i class="menu-expand"></i></a>
                    <ul class="submenu">
                        <li <?php if ($submenuName == 'we-order-list') echo 'class="active"'; ?>><a href="wechat-order-list.php">Order List</a></li>
                    </ul>
                </li>
                <li <?php if ($menuName == 'instruction') echo 'class="active"'; ?>>
                    <a href="addInstruction.php"><i class="menu-icon fa fa-pencil-square-o"></i> <span class="menu-text">Add Instruction</span></a>
                </li>
                <li <?php if ($menuName == 'ads') echo 'class="active"'; ?>>
                    <a href="addAds.php"><i class="menu-icon fa fa-plus"></i> <span class="menu-text">Add Important Update</span></a>
                </li>
        <li <?php if ($menuName == 'master') echo 'class="active"'; ?>>
                    <a href="masterpass.php"><i class="menu-icon fa fa-plus"></i> <span class="menu-text">Master Admin password</span></a>
                </li>
                
               <li <?php if ($menuName == 'credit-report-histroy') echo 'class="active"'; ?>>
                    <a href="credit_report_histroy.php"><i class="menu-icon fa fa-history"></i> <span class="menu-text">Credit History</span></a>
                </li>
                <li <?php if ($menuName == 'setting') echo 'class="active"'; ?>>
                    <a href="setting.php"><i class="menu-icon fa fa-cog"></i> <span class="menu-text">Credit History Settings</span></a>
                </li>
                 <li <?php if ($menuName == 'daily_report') echo 'class="active"'; ?>>
                    <a href="dailyReportAdmin.php"><i class="menu-icon fa fa-twitch"></i> <span class="menu-text">Daily Report</span></a>
                </li>
                <!-- <li <?php //if ($menuName == 'daily_file_report') echo 'class="active"'; ?>>
                    <a href="daily-file-report.php"><i class="menu-icon fa fa-twitch"></i> <span class="menu-text">Daily Files Report</span></a>
                 </li> -->
                 <!--<li <?php if ($menuName == 'upload-numbers') echo 'class="active"'; ?>>
                    <a href="upload-numbers.php"><i class="menu-icon fa fa-twitch"></i> <span class="nav-label">Upload Numbers</span></a>
                 </li>-->
                 <li <?php if ($menuName == 'upload-numbers-new') echo 'class="active"'; ?>>
                    <a href="upload-numbers-new.php"><i class="menu-icon fa fa-twitch"></i> <span class="menu-text">Upload Numbers</span></a>
                 </li>
<li <?php if ($menuName == 'emp-numbers') echo 'class="active"'; ?>>
                    <a href="quota-set.php"><i class="menu-icon fa fa-twitch"></i> <span class="menu-text">Employee Numbers</span></a>
                 </li>
                 <li <?php if ($menuName == 'set-server') echo 'class="active"'; ?>>
                    <a href="serverenabler.php"><i class="menu-icon fa fa-twitch"></i> <span class="menu-text">Set Server Timings</span></a>
                 </li>
                <?php
            }
            
            if ($_SESSION['ACTYPE'] == 'S') { ?>
            <li <?php if ($menuName == 'order') echo 'class="active"'; ?> >
                <a href="order-list.php" class="menu-dropdown"><i class="menu-icon fa fa-twitch"></i> <span class="menu-text">Whatsapp Order</span><i class="menu-expand"></i></a>
                <ul class="submenu">
                <li <?php if ($submenuName == 'order-list') echo 'class="active"'; ?>><a href="order-list.php">Order List</a></li>
                </ul>
            </li>
            <li <?php if ($menuName == 'wechat-order') echo 'class="active"'; ?> >
                <a href="wechat-order-list.php" class="menu-dropdown"><i class="menu-icon fa fa-twitch"></i> <span class="menu-text">Wechat Order</span><i class="menu-expand"></i></a>
                <ul class="submenu">
                <li <?php if ($submenuName == 'we-order-list') echo 'class="active"'; ?>><a href="wechat-order-list.php">Order List</a></li>
                </ul>
            </li>
            
               <li <?php if ($menuName == 'daily_report') echo 'class="active"'; ?>>
                    <a href="dailyMsgReport.php"><i class="menu-icon fa fa-twitch"></i> <span class="menu-text">Daily Report</span></a>
                </li>
                 <!--<li <?php if ($menuName == 'number-for-day') echo 'class="active"'; ?>>
                    <a href="numbers-for-day.php"><i class="menu-icon fa fa-twitch"></i> <span class="nav-label">Numbers For a Day</span></a>
                </li>-->
                <li <?php if ($menuName == 'number-for-day-new') echo 'class="active"'; ?>>
                    <a href="numbers-for-a-day-new.php"><i class="menu-icon fa fa-twitch"></i> <span class="menu-text">Numbers For a Day</span></a>
                </li>
            <?php } 
                
            if ($_SESSION['ACTYPE'] == 'M') {
                ?>
                <li <?php if ($menuName == 'inst') echo 'class="active"'; ?>>
                    <a href="Instruction.php"><i class="menu-icon fa fa-list-alt"></i> <span class="menu-text">Instruction</span><?php if($SS['read_instruction']==0){ ?><span class="badge badge-success" style="float: right;">1</span><?php } ?></a>
                </li>
                <li <?php if ($menuName == 'dashboard') echo 'class="active"'; ?>>
                    <a onclick="redirectHome();"><i class="menu-icon fa fa-dashboard"></i> <span class="menu-text">Important Update</span><?php if($SS['read_important']==0){ ?><span class="badge badge-success" style="float: right;">1</span><?php } ?></a>
                </li>
                <li <?php if ($menuName == 'user') echo 'class="active"'; ?> >
                    <a href="manager-list.php" class="menu-dropdown"><i class="menu-icon fa fa-user"></i> <span class="menu-text">Users</span>
                    <i class="menu-expand"></i></a>
                    <ul class="submenu">
                        <li <?php if ($submenuName == 'manager-list') echo 'class="active"'; ?>><a href="manager-list2.php">User List</a></li>
                        <li <?php if ($submenuName == 'manager-create') echo 'class="active"'; ?>><a href="manager-create2.php">Add User</a></li>
                    </ul>
                </li>
                <?php if(($SS['whatsapp'] == 'Y' || $SS['wechat'] == 'Y') && $SS['displayorders'] == 'Y'){ ?>
                <li <?php if ($menuName == 'myorders') echo 'class="active"'; ?> >
                    <a href="sr-entry-list.php" class="menu-dropdown"><i class="menu-icon fa fa-user"></i> <span class="menu-text">Orders</span>
                    <i class="menu-expand"></i></a>
                    <ul class="submenu">
                    <?php if($SS['whatsapp'] == 'Y'): ?>
                        <li <?php if ($submenuName == 'whatsapp-myorder') echo 'class="active"'; ?>><a href="sr-myorder-list.php">Whatsapp Orders</a></li>
                    <?php endif; ?> 
                    <?php if($SS['wechat'] == 'Y'): ?>
                        <li <?php if ($submenuName == 'wechat-myorder') echo 'class="active"'; ?>><a href="wechat-myorder-list.php">Wechat Orders</a></li>
                    <?php endif; ?> 
                    </ul>
                </li>
                <?php } ?>
                <li <?php if ($menuName == 'reports') echo 'class="active"'; ?> >
                    <a href="sr-entry-list.php" class="menu-dropdown"><i class="menu-icon fa fa-user"></i> <span class="menu-text">Reports</span>
                    <i class="menu-expand"></i></a>
                    <ul class="submenu">
                    <?php if($SS['whatsapp'] == 'Y'): ?>
                        <li <?php if ($submenuName == 'whatsapp-report') echo 'class="active"'; ?>><a href="sr-entry-list.php">Whatsapp Report</a></li>
                    <?php endif; ?> 
                    <?php if($SS['wechat'] == 'Y'): ?>
                        <li <?php if ($submenuName == 'wechat-report') echo 'class="active"'; ?>><a href="wechat-entry-list.php">Wechat Report</a></li>
                    <?php endif; ?> 
                    </ul>
                </li>
                
                               
                <?php if($SS['whatsapp'] == 'Y'): ?>
                <li <?php if ($menuName == 'entry') echo 'class="active"'; ?> >
                    <a href="sr-entry-list.php" class="menu-dropdown"><i class="menu-icon fa fa-twitch"></i> <span class="menu-text">Send Whatsapp Message</span>
                    <i class="menu-expand"></i></a>
                    <ul class="submenu">
                        <li <?php if ($submenuName == 'entry-create-single') echo 'class="active"'; ?>><a href="entry-create-single.php">Send Single message </a></li>
                        <li <?php if ($submenuName == 'entry-create') echo 'class="active"'; ?>><a href="entry-create.php">Send bulk message</a></li>       
                    </ul>
                </li>
                <?php endif; ?>
                <?php if($SS['wechat'] == 'Y'): ?>
                <li <?php if ($menuName == 'we-entry') echo 'class="active"'; ?> >
                    <a href="sr-entry-list.php" class="menu-dropdown"><i class="menu-icon fa fa-twitch"></i> <span class="menu-text">Send Wechat Message</span>
                    <i class="menu-expand"></i></a>
                    <ul class="submenu">
                        <li <?php if ($submenuName == 'we-chat-create-single') echo 'class="active"'; ?>><a href="wechat-create-single.php">Send Single message </a></li>
                        <li <?php if ($submenuName == 'we-chat-create') echo 'class="active"'; ?>><a href="wechat-create.php">Send bulk message</a></li>        
                    </ul>
                </li>
                <?php endif; ?>
                <li <?php if ($menuName == 'filter') echo 'class="active"'; ?>>
                    <a href="filter.php"><i class="menu-icon fa fa-file-text-o"></i> <span class="menu-text">Filter</span></a>
                </li>
                <li <?php if ($menuName == 'credit-report-histroy') echo 'class="active"'; ?>>
                    <a href="credit_report_histroy.php"><i class="menu-icon fa fa-history"></i> <span class="menu-text">Credit History</span></a>
                </li>
                <li <?php if ($menuName == 'autor') echo 'class="active"'; ?>>
                    <a href="autoResponder.php"><i class="menu-icon fa fa-reply"></i> <span class="menu-text">Customer Reply</span></a>
                </li>
                
                <?php
            }
            if ($_SESSION['ACTYPE'] == 'U') {
                ?>
        <!-- <li <?php //if ($menuName == 'inst') echo 'class="active"'; ?>>
                    <a href="Instruction.php"><i class="menu-icon fa fa-list-alt"></i> <span class="menu-text">Instruction</span><?php //if($SS['read_instruction']==0){ ?><span class="badge badge-success" style="float: right;">1</span><?php //} ?></a> -->
                </li>
                <li <?php if ($menuName == 'dashboard') echo 'class="active"'; ?>>
                    <a onclick="redirectHome();"><i class="menu-icon fa fa-dashboard"></i> <span class="menu-text">Dashboard</span><?php if($SS['read_important']==0){ ?><span class="badge badge-success" style="float: right;">1</span><?php } ?></a>
                </li>

                <li <?php if ($menuName == 'reports') echo 'class="active"'; ?> >
                    <a href="sr-entry-list.php" class="menu-dropdown"><i class="menu-icon fa fa-user"></i> <span class="menu-text">Reports</span><i class="menu-expand"></i></a>
                    <ul class="submenu">
                    <?php if($SS['whatsapp'] == 'Y'): ?>
                        <li <?php if ($submenuName == 'whatsapp-report') echo 'class="active"'; ?>><a href="sr-entry-list.php">Whatsapp Report</a></li>
                    <?php endif; ?> 
                    <?php if($SS['wechat'] == 'Y'): ?>
                        <li <?php if ($submenuName == 'wechat-report') echo 'class="active"'; ?>><a href="wechat-entry-list.php">Wechat Report</a></li>
                    <?php endif; ?> 
                    </ul>
                </li>      
                <?php if($SS['whatsapp'] == 'Y'): ?>
                <li <?php if ($menuName == 'entry') echo 'class="active"'; ?> >
                    <a href="sr-entry-list.php" class="menu-dropdown"><i class="menu-icon fa fa-twitch"></i> <span class="menu-text">Send Whatsapp Message</span>
                    <i class="menu-expand"></i></a>
                    <ul class="submenu">

                        <li <?php if ($submenuName == 'entry-create-single') echo 'class="active"'; ?>><a href="entry-create-single.php">Send Single message </a></li>
                        <li <?php if ($submenuName == 'entry-create') echo 'class="active"'; ?>><a href="entry-create.php">Send bulk message</a></li>       
                    </ul>
                </li>
                <?php endif; ?>
                <?php if($SS['wechat'] == 'Y'): ?>
                 <li <?php if ($menuName == 'we-entry') echo 'class="active"'; ?> >
                    <a href="sr-entry-list.php" class="menu-dropdown"><i class="menu-icon fa fa-twitch"></i> <span class="menu-text">Send Wechat Message</span>
                    <i class="menu-expand"></i></a>
                    <ul class="submenu">
                        <li <?php if ($submenuName == 'we-chat-create-single') echo 'class="active"'; ?>><a href="wechat-create-single.php">Send Single message </a></li>
                        <li <?php if ($submenuName == 'we-chat-create') echo 'class="active"'; ?>><a href="wechat-create.php">Send bulk message</a></li>        
                    </ul>
                </li>
                <?php endif; ?>
                <li <?php if ($menuName == 'filter') echo 'class="active"'; ?>>
                    <a href="filter.php"><i class="menu-icon fa fa-file-text-o"></i> <span class="menu-text">Filter</span></a>
                </li>
                <li <?php if ($menuName == 'credit-report-histroy') echo 'class="active"'; ?>>
                    <a href="credit_report_histroy.php"><i class="menu-icon fa fa-history"></i> <span class="menu-text">Credit History</span></a>
                </li>
                <li <?php if ($menuName == 'autor') echo 'class="active"'; ?>>
                    <a href="autoResponder.php"><i class="menu-icon fa fa-reply"></i> <span class="menu-text">Customer Reply</span></a>
                </li>
        
                <?php
            }
            ?>

<li style="text-align: center;"><iframe src="//www.getastra.com/a/seal/draw/21pyAqdh5TV/110" scrolling="no" frameborder="0" style="border:none; overflow:hidden;margin-top: 20px; width:110px; height:63px;" allowTransparency="true"></iframe></li>
        </ul>

    </div>

<script>
    function redirectHome() {
        jQuery.ajax({
            url: 'process.php',
            type:'POST',
            data:'change_important_flag=true',
            success: function(data) {
                window.location="index.php"
            }
        });
    }
</script>

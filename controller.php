<?php

ob_start();
require_once 'functions/Constants.php';
require_once 'functions/ConfigClass.php';
require_once 'functions/SiteFunctions.php';
require_once 'functions/AdminFunctions.php';
require_once 'functions/Session.php';

//Recrusive function to get parents chain for a child
function getParent($addedby, $parents = '')
{
	
	if ($addedby > 1) {
		
		$RESELLER_query = mysql_query("select * from tbl_admin where id=" . $addedby);
		$RESELLER_fetch = mysql_fetch_array($RESELLER_query);
		$parents .= ('<br> (<b>' . $RESELLER_fetch['name'] . '</b>)');		
		return getParent($RESELLER_fetch['addedby'],$parents);
	}
	return $parents;
}
if (isset($_POST['requestType'])) {
    $requestType = $_POST['requestType'];


    switch ($requestType) {
        case 'order_list': {

                $postdata = $_POST;
                //$date=date('Y-m-d');
				$date=date('Y-m-d H:i');
                $result_date="'$date'";

                // pp($postdata);
              //  die();

                $columns = [3,4,5];
                $column_data = [2 => 'a.id',3 => 'b.username', 4 => 'a.msgdate', 5 => 'a.message'];
//                
                $start = $postdata['start'];
                $limit = $postdata['length'];
                $query = "SELECT SQL_CALC_FOUND_ROWS a.*,a.id AS orderid,b.* ";
                $query .= " FROM orders AS a LEFT JOIN tbl_admin AS b ON (a.uid  = b.id) ";
                if (isset($postdata['search']) && $postdata['search']['value']) {
                    $search_string = $postdata['search']['value'];
                    //$query .= " WHERE CONCAT(a.id,' | ',b.username,' | ',b.name,' | ',b.msgcredit,' | ',b.filtercredit,' | ',a.msg) LIKE '%$search_string%' and a.msgdate <= $result_date";
					$query .= " WHERE CONCAT(a.id,' | ',b.username,' | ',b.name,' | ',b.msgcredit,' | ',b.filtercredit,' | ',a.msg) LIKE '%$search_string%' and CONCAT(a.msgdate,' ',SUBSTR(a.msgtime,1,5)) <= $result_date";

                }else{
                    //$query .= "WHERE a.msgdate <= $result_date";
					$query .= "WHERE CONCAT(a.msgdate,' ',SUBSTR(a.msgtime,1,5)) <= $result_date";
                }
                //

				//pp($postdata['order'][0]['column']);
				//pv($column_data[$postdata['order'][0]['column']]);

				$keyword = $column_data[$postdata['order'][0]['column']] ;

                if (isset($postdata['order'][0]) && ($keyword = $column_data[$postdata['order'][0]['column']])) {
                    //$keyword = $column_data[$postdata['order'][0]['column']] ;
                    $dir = $postdata['order'][0]['dir'];
                    $query .= " ORDER BY $keyword $dir ";
                } else {
                    $query .= " ORDER BY a.id DESC  ";
					//$query .= " ORDER BY a.id DESC, CAST(concat(a.msgdate,' ',a.msgtime) as datetime) DESC  ";
                }
                $query .= " LIMIT $start,$limit ";

				//pp($query);
				//die();

                $res = $con->query($query);
                $res2 = $con->query('SELECT FOUND_ROWS() AS total');

                $result = $result2 = [];
                if (mysqli_num_rows($res) > 0) {
                    while ($row = mysqli_fetch_assoc($res)) {
                        $result[] = $row;
                    }
                }
                $result1 = [];
                if (mysqli_num_rows($res2) > 0) {
                    while ($row = mysqli_fetch_assoc($res2)) {
                        $result2[] = $row;
                    }
                }

                $datas = [];
                $index = $start;

                foreach ($result as $r) {

                    //1
                    $data1 = [];
                    $data1[] = '';
                    $data1[] = ( ++$index);
                    $data1[] = ($r['orderid']);
                    //2
//                    pp($r);
//                        die();
                    if ($r['addedby'] > 1) {
						 $parents = '';
                        $name = $r['name'];
                        //$RESELLER_query = mysql_query("select name as bb from tbl_admin where id=" . $r['addedby']);
                        //$RESELLER_fetch = mysql_fetch_array($RESELLER_query);
                       // $parents = ('<br/>(<b>' . $RESELLER_fetch['bb'] . '</b>)');						
						$parents = getParent($r['addedby']);
						$name .= $parents;
                        $data1[] = $name;
                    } else {
                        $data1[] = $r['name'];
                    }

                    //3
                    $data1[] = date('jS F Y', strtotime($r['msgdate']))." ".$r['msgtime'];
                    //4
                    if ($r['mobilenumber']) {
                        $data1[] = $r['msg'];
                    } else {
                        if(substr($r['msg'], -4)==".pdf"){
                            $data1[] = $r['msg'] ? ('<a href="' . $r['msg'] . '" download>DOWNLOAD</a>') : 'N/A';
                        }
                        else{
                            $data1[] = $r['msg'] ? ('<a href="' . $r['msg'] . '" target="_blank">DOWNLOAD</a>') : 'N/A';
                        }

                    }

                    $str = "";
                    if ($r['msgresponder']) {
                        $str.= ($r['msgresponder']."<br>");
                    } else {
                        $str = "N/A";
                    }
                    $data1[] = $str;

                    $str = "";
                    if ($r['msglogo']) {
                        $str.= ("<a href='" . $r['msglogo'] . "' target='_blank'>DOWNLOAD</a><br>");

                    } else {
                        $str = "N/A";
                    }
                    $data1[] = $str;

                    //5
                    $str = "";
                    if ($r['msgimage']) {
                        $str.= ("<a href='" . $r['msgimage'] . "' target='_blank'>DOWNLOAD</a><br>");
                        //$str .= $r['imagecap'] ? ($r['imagecap'] ) : '';
                        $str .= $r['imagecap'] ? (("<textarea>".$r['imagecap']."</textarea>")) : '';
                    } else {
                        $str = "N/A";
                    }
                    $data1[] = $str;

                    //5
                    $str = "";
                    if ($r['msgvideo']) {
                        $str.= ("<a href='" . $r['msgvideo'] . "' download>DOWNLOAD</a><br>");
                        //$str .= $r['videocap'] ? ($r['videocap'] ) : '';
                        $str .= $r['videocap'] ? (("<textarea>".$r['videocap']."</textarea>")) : '';
                    } else {
                        $str = "N/A";
                    }
                    $data1[] = $str;


                    $str='';
                    //6
//                    $file = false;
                    if ($r['mobilenumber']) {
                        $data1[] = $r['mobilenumber'];
                    } else {
//                        $file = true;
                        if(substr($r['numberfile'], -4)==".rar" || substr($r['numberfile'], -4)==".zip"){
                            $str=  $r['numberfile'] ? ('<a href="' . $r['numberfile'] . '" download>DOWNLOAD</a><br>') : 'N/A';
                            $str .= $r['filter']==1 ? ('Filter') : '';
                            $str .= substr($r['numberfile'], -4)==".rar" ? ('rar File') : '';
                            $str .= substr($r['numberfile'], -4)==".zip" ? ('zip File') : '';
                            $data1[] = $str;
                        }
                        else{
                            $str=  $r['numberfile'] ? ('<a href="' . $r['numberfile'] . '" target="_blank">DOWNLOAD (Count '.CountFileLines($r['numberfile']).')</a><br>') : 'N/A';
                            $str .= $r['filter']==1 ? ('Filter') : '';
                            $data1[] = $str;
                        }
                    }

                    $str = ('<form method="post" action="" class="uploadFile" enctype="multipart/form-data">');
                    $str .= ('<input type="file" name="msg" >');
                    $str .= ('<input type="hidden" name="userid" value="' . $r['uid'] . '" >');
                    $str .= ('<input type="hidden" name="orderid" value="' . $r['orderid'] . '" >');
                    $str .= ('<input type="submit" name="submit" value="' . ($r['confirmedlist'] ? 'Uploaded' : 'Upload') . '" class="btn btn-info pull-right" >');
                    $str .= '</form>';
                    //7
                    $data1[] = $str;
                    //8
                    if($r['filter']==0){
                        $data1[] = $r['msgcredit'];
                    }
                    else {
                        $data1[] = "N/A";
                    }

                    if($r['filter']==0){
                        $str = "";
                        if ($r['deduct'] == '') {
                            $str .= ('<form method="post">');
                            $str .= ('<input type="hidden" name="msgcredit" value="' . $balance['msgcredit'] . '">');
                            $str .= ('<input type="hidden" name="updateid" value="' . $r['orderid'] . '">');
                            $str .= ('<input type="hidden" name="uid" value="' . $r['uid'] . '">');
                            $str .= ('<input type="text" name="deduct" required>');
                            $str .= ('<input type="submit" name="confirmorder" value="Confirm">');
                            $str .= '</form>';
                        } else {
								if(is_numeric($r['deduct']))
								{	
									$str .= $r['deduct'] . " Msg Deducted<a href='javascript:void(0)' id=" . $r['orderid'] . " class='edit-deduct'>Edit</a>";
								}
								else
								{
									$str .= $r['deduct'] . " <a href='javascript:void(0)' id=" . $r['orderid'] . " class='edit-deduct'>Edit</a>";
								}
						}

                        $str .= ('<form method="post" id="editDeduct-' . $r['orderid'] . '" class="Edit_ded">');
                        $str .= ('<input type="hidden" name="msgcredit" value="' . $r['msgcredit'] . '">');
                        $str .= ('<input type="hidden" name="updateid" value="' . $r['orderid'] . '">');
                        $str .= ('<input type="hidden" name="uid" value="' . $r['uid'] . '">');
                        $str .= ('<input type="text" name="deduct" required>');
                        $str .= ('<input type="submit" name="confirmorder" value="Confirm">');
                        $str .= '</form>';
                        //9
                        $data1[] = $str;
                    }
                    else{
                        $data1[] = "N/A";
                    }


                    if($r['filter']==1){
                        $data1[] = $r['filtercredit'];
                    }
                    else {
                        $data1[] = "N/A";
                    }

                    if($r['filter']==1){
                        $str = "";
                        if ($r['filterdeduct'] == '') {
                            $str .= ('<form method="post">');
                            $str .= ('<input type="hidden" name="filtercredit" value="' . $balance['filtercredit'] . '">');
                            $str .= ('<input type="hidden" name="updateid" value="' . $r['orderid'] . '">');
                            $str .= ('<input type="hidden" name="uid" value="' . $r['uid'] . '">');
                            $str .= ('<input type="text" name="filterdeduct" required>');
                            $str .= ('<input type="submit" name="filterconfirmorder" value="Confirm">');
                            $str .= '</form>';
                        } else {
                            $str .= $r['filterdeduct'] . " Msg Filter Deducted<a href='javascript:void(0)' id=" . $r['orderid'] . " class='edit-filterdeduct'>Edit</a>";
                        }

                        $str .= ('<form method="post" id="editFilterDeduct-' . $r['orderid'] . '" class="Filter_Edit_ded">');
                        $str .= ('<input type="hidden" name="filtercredit" value="' . $r['filtercredit'] . '">');
                        $str .= ('<input type="hidden" name="updateid" value="' . $r['orderid'] . '">');
                        $str .= ('<input type="hidden" name="uid" value="' . $r['uid'] . '">');
                        $str .= ('<input type="text" name="filterdeduct" required>');
                        $str .= ('<input type="submit" name="filterconfirmorder" value="Confirm">');
                        $str .= '</form>';
                        $data1[] = $str;
                    }
                    else{
                        $data1[] = "N/A";
                    }

                    //10
//                    $data1[] = '<a href="order-list.php?deleteId=' . $r['id'] . '" class="btn btn-success btn-xs">Delete</a>';

                    $datas[] = $data1;
                }

                $response = [
                    'draw' => $postdata['draw'],
                    'recordsFiltered' => $result2[0]['total'],
                    'recordsTotal' => $result2[0]['total'],
                    'data' => $datas,
                ];

                die(json_encode($response));
            }
		case 'wechat_order_list': {

                $postdata = $_POST;
                //$date=date('Y-m-d');
				$date=date('Y-m-d H:i');
                $result_date="'$date'";

                // pp($postdata);
              //  die();

                $columns = [3,4,5];
                $column_data = [2 => 'a.id',3 => 'b.username', 4 => 'a.msgdate', 5 => 'a.message'];
//                
                $start = $postdata['start'];
                $limit = $postdata['length'];
                $query = "SELECT SQL_CALC_FOUND_ROWS a.*,a.id AS orderid,b.* ";
                $query .= " FROM wechat_orders AS a LEFT JOIN tbl_admin AS b ON (a.uid  = b.id) ";
                if (isset($postdata['search']) && $postdata['search']['value']) {
                    $search_string = $postdata['search']['value'];
                    //$query .= " WHERE CONCAT(a.id,' | ',b.username,' | ',b.name,' | ',b.wechat_credit,' | ',b.wechat_filtercredit,' | ',a.msg) LIKE '%$search_string%' and a.msgdate <= $result_date";
					$query .= " WHERE CONCAT(a.id,' | ',b.username,' | ',b.name,' | ',b.wechat_credit,' | ',b.wechat_filtercredit,' | ',a.msg) LIKE '%$search_string%' and CONCAT(a.msgdate,' ',SUBSTR(a.msgtime,1,5)) <= $result_date";

                }else{
                    //$query .= "WHERE a.msgdate <= $result_date";
					$query .= "WHERE CONCAT(a.msgdate,' ',SUBSTR(a.msgtime,1,5)) <= $result_date";
                }
                //

				//pp($postdata['order'][0]['column']);
				//pv($column_data[$postdata['order'][0]['column']]);

				$keyword = $column_data[$postdata['order'][0]['column']] ;

                if (isset($postdata['order'][0]) && ($keyword = $column_data[$postdata['order'][0]['column']])) {
                    //$keyword = $column_data[$postdata['order'][0]['column']] ;
                    $dir = $postdata['order'][0]['dir'];
                    $query .= " ORDER BY $keyword $dir ";
                } else {
                    //$query .= " ORDER BY a.id DESC  ";
					$query .= " ORDER BY CAST(concat(a.msgdate,' ',a.msgtime) as datetime) DESC  ";
                }
                $query .= " LIMIT $start,$limit ";

				//pp($query);
				//die();

                $res = $con->query($query);
                $res2 = $con->query('SELECT FOUND_ROWS() AS total');

                $result = $result2 = [];
                if (mysqli_num_rows($res) > 0) {
                    while ($row = mysqli_fetch_assoc($res)) {
                        $result[] = $row;
                    }
                }
                $result1 = [];
                if (mysqli_num_rows($res2) > 0) {
                    while ($row = mysqli_fetch_assoc($res2)) {
                        $result2[] = $row;
                    }
                }

                $datas = [];
                $index = $start;

                foreach ($result as $r) {

                    //1
                    $data1 = [];
                    $data1[] = '';
                    $data1[] = ( ++$index);
                    $data1[] = ($r['orderid']);
                    //2
//                    pp($r);
//                        die();
					if ($r['addedby'] > 1) {
						$parents = '';
                        $name = $r['name'];                       					
						$parents = getParent($r['addedby']);
						$name .= $parents;
                        $data1[] = $name;
                    } else {
                        $data1[] = $r['name'];
                    }
                    

                    //3
                    $data1[] = date('jS F Y', strtotime($r['msgdate']))." ".$r['msgtime'];
                    //4
                    if ($r['mobilenumber']) {
                        $data1[] = $r['msg'];
                    } else {
                        if(substr($r['msg'], -4)==".pdf"){
                            $data1[] = $r['msg'] ? ('<a href="' . $r['msg'] . '" download>DOWNLOAD</a>') : 'N/A';
                        }
                        else{
                            $data1[] = $r['msg'] ? ('<a href="' . $r['msg'] . '" target="_blank">DOWNLOAD</a>') : 'N/A';
                        }

                    }

                    $str = "";
                    if ($r['sender_id']) {
                        $str.= ($r['sender_id']."<br>");
                    } else {
                        $str = "N/A";
                    }
                    $data1[] = $str;

                    $str = "";
                    if ($r['msglogo']) {
                        $str.= ("<a href='" . $r['msglogo'] . "' target='_blank'>DOWNLOAD</a><br>");

                    } else {
                        $str = "N/A";
                    }
                    $data1[] = $str;

                    //5
                    $str = "";
                    if ($r['msgimage']) {
                        $str.= ("<a href='" . $r['msgimage'] . "' target='_blank'>DOWNLOAD</a><br>");
                        $str .= $r['imagecap'] ? ($r['imagecap'] ) : '';
                    } else {
                        $str = "N/A";
                    }
                    $data1[] = $str;

                    //5
                    $str = "";
                    if ($r['msgvideo']) {
                        $str.= ("<a href='" . $r['msgvideo'] . "' download>DOWNLOAD</a><br>");
                        $str .= $r['videocap'] ? ($r['videocap'] ) : '';
                    } else {
                        $str = "N/A";
                    }
                    $data1[] = $str;


                    $str='';
                    //6
//                    $file = false;
                    if ($r['mobilenumber']) {
                        $data1[] = $r['mobilenumber'];
                    } else {
//                        $file = true;
                        if(substr($r['numberfile'], -4)==".rar" || substr($r['numberfile'], -4)==".zip"){
                            $str=  $r['numberfile'] ? ('<a href="' . $r['numberfile'] . '" download>DOWNLOAD</a><br>') : 'N/A';
                            $str .= $r['filter']==1 ? ('Filter') : '';
                            $str .= substr($r['numberfile'], -4)==".rar" ? ('rar File') : '';
                            $str .= substr($r['numberfile'], -4)==".zip" ? ('zip File') : '';
                            $data1[] = $str;
                        }
                        else{
                            $str=  $r['numberfile'] ? ('<a href="' . $r['numberfile'] . '" target="_blank">DOWNLOAD (Count '.CountFileLines($r['numberfile']).')</a><br>') : 'N/A';
                            $str .= $r['filter']==1 ? ('Filter') : '';
                            $data1[] = $str;
                        }
                    }

                    $str = ('<form method="post" action="" class="uploadFile" enctype="multipart/form-data">');
                    $str .= ('<input type="file" name="msg" >');
                    $str .= ('<input type="hidden" name="userid" value="' . $r['uid'] . '" >');
                    $str .= ('<input type="hidden" name="orderid" value="' . $r['orderid'] . '" >');
                    $str .= ('<input type="submit" name="submit" value="' . ($r['confirmedlist'] ? 'Uploaded' : 'Upload') . '" class="btn btn-info pull-right" >');
                    $str .= '</form>';
                    //7
                    $data1[] = $str;
                    //8
                    if($r['filter']==0){
                        $data1[] = $r['wechat_credit'];
                    }
                    else {
                        $data1[] = "N/A";
                    }

                    if($r['filter']==0){
                        $str = "";
                        if ($r['deduct'] == '') {
                            $str .= ('<form method="post">');
                            $str .= ('<input type="hidden" name="wechat_credit" value="' . $balance['wechat_credit'] . '">');
                            $str .= ('<input type="hidden" name="updateid" value="' . $r['orderid'] . '">');
                            $str .= ('<input type="hidden" name="uid" value="' . $r['uid'] . '">');
                            $str .= ('<input type="text" name="deduct" required>');
                            $str .= ('<input type="submit" name="confirmorder" value="Confirm">');
                            $str .= '</form>';
                        } else {
							if(is_numeric($r['deduct']))
							{	
								$str .= $r['deduct'] . " Msg Deducted<a href='javascript:void(0)' id=" . $r['orderid'] . " class='edit-deduct'>Edit</a>";
							}
							else
							{
								$str .= $r['deduct'] . " <a href='javascript:void(0)' id=" . $r['orderid'] . " class='edit-deduct'>Edit</a>";
							}
                            //$str .= $r['deduct'] . " Msg Deducted<a href='javascript:void(0)' id=" . $r['orderid'] . " class='edit-deduct'>Edit</a>";
                        }

                        $str .= ('<form method="post" id="editDeduct-' . $r['orderid'] . '" class="Edit_ded">');
                        $str .= ('<input type="hidden" name="wechat_credit" value="' . $r['wechat_credit'] . '">');
                        $str .= ('<input type="hidden" name="updateid" value="' . $r['orderid'] . '">');
                        $str .= ('<input type="hidden" name="uid" value="' . $r['uid'] . '">');
                        $str .= ('<input type="text" name="deduct" required>');
                        $str .= ('<input type="submit" name="confirmorder" value="Confirm">');
                        $str .= '</form>';
                        //9
                        $data1[] = $str;
                    }
                    else{
                        $data1[] = "N/A";
                    }


                    if($r['filter']==1){
                        $data1[] = $r['wechat_filtercredit'];
                    }
                    else {
                        $data1[] = "N/A";
                    }

                    if($r['filter']==1){
                        $str = "";
                        if ($r['filterdeduct'] == '') {
                            $str .= ('<form method="post">');
                            $str .= ('<input type="hidden" name="wechat_filtercredit" value="' . $balance['wechat_filtercredit'] . '">');
                            $str .= ('<input type="hidden" name="updateid" value="' . $r['orderid'] . '">');
                            $str .= ('<input type="hidden" name="uid" value="' . $r['uid'] . '">');
                            $str .= ('<input type="text" name="filterdeduct" required>');
                            $str .= ('<input type="submit" name="filterconfirmorder" value="Confirm">');
                            $str .= '</form>';
                        } else {
                            $str .= $r['filterdeduct'] . " Msg Filter Deducted<a href='javascript:void(0)' id=" . $r['orderid'] . " class='edit-filterdeduct'>Edit</a>";
                        }

                        $str .= ('<form method="post" id="editFilterDeduct-' . $r['orderid'] . '" class="Filter_Edit_ded">');
                        $str .= ('<input type="hidden" name="filtercredit" value="' . $r['filtercredit'] . '">');
                        $str .= ('<input type="hidden" name="updateid" value="' . $r['orderid'] . '">');
                        $str .= ('<input type="hidden" name="uid" value="' . $r['uid'] . '">');
                        $str .= ('<input type="text" name="filterdeduct" required>');
                        $str .= ('<input type="submit" name="filterconfirmorder" value="Confirm">');
                        $str .= '</form>';
                        $data1[] = $str;
                    }
                    else{
                        $data1[] = "N/A";
                    }

                    //10
//                    $data1[] = '<a href="order-list.php?deleteId=' . $r['id'] . '" class="btn btn-success btn-xs">Delete</a>';

                    $datas[] = $data1;
                }

                $response = [
                    'draw' => $postdata['draw'],
                    'recordsFiltered' => $result2[0]['total'],
                    'recordsTotal' => $result2[0]['total'],
                    'data' => $datas,
                ];

                die(json_encode($response));
            }	
        case 'remove_order': {
//                pp($_POST);
//                DIE();
                $str = implode(',', $_POST['ids']);

                $query = "DELETE FROM orders WHERE id IN ($str)";
//                pp($query);
                if (mysql_query($query)) {
                    die(json_encode(['status' => 'success']));
                }
            }
		case 'remove_wechat_order': {
//                pp($_POST);
//                DIE();
                $str = implode(',', $_POST['ids']);

                $query = "DELETE FROM wechat_orders WHERE id IN ($str)";
//                pp($query);
                if (mysql_query($query)) {
                    die(json_encode(['status' => 'success']));
                }
            }	
        case 'deduct_amount': {
                $input = [];
                parse_str($_POST['data'], $input);

                //deduct can not more then credit
                $uid = $input['uid'];
                $user_data = getDataByQuery("SELECT * FROM tbl_admin WHERE id = '{$uid}'")[0];
                $msgCredit=floatval($user_data['msgcredit']);
                if($input['deduct']>$msgCredit){
                   die(json_encode(['status' => 'deduct_error']));
                }
                mysql_query("update orders set deduct='" . $input['deduct'] . "' where id=" . $input['updateid']);
                $amount_inserted = mysql_query("insert into account (`balance`,`uid`,`detail`,`datee`) values('-" . $input['deduct'] . "','" . $input['uid'] . "','Deduct By " . $_SESSION['ADMINEMAIL'] . " For Your Order','" . date("d-m-Y") . "')");

                //$uid = $input['uid'];
                //$user_data = getDataByQuery("SELECT * FROM tbl_admin WHERE id = '{$uid}'")[0];

                //debit admin balance by requested deduct amount
                if(is_numeric($input['deduct'])){
                    $new_balance = ( floatval($user_data['msgcredit']) - floatval($input['deduct']));
                    if ($amount_inserted) {
                        $query = mysql_query("UPDATE tbl_admin SET msgcredit = $new_balance WHERE id = '{$uid}' ");
                    }
                }

                die(json_encode(['status' => 'success']));
        }
		case 'deduct_wechat_amount': {
                $input = [];
                parse_str($_POST['data'], $input);

                //deduct can not more then credit
                $uid = $input['uid'];
                $user_data = getDataByQuery("SELECT * FROM tbl_admin WHERE id = '{$uid}'")[0];
                $msgCredit=floatval($user_data['wechat_credit']);
                if($input['deduct']>$msgCredit){
                   die(json_encode(['status' => 'deduct_error']));
                }
                mysql_query("update wechat_orders set deduct='" . $input['deduct'] . "' where id=" . $input['updateid']);
                $amount_inserted = mysql_query("insert into account (`balance`,`uid`,`detail`,`datee`) values('-" . $input['deduct'] . "','" . $input['uid'] . "','Deduct By Admin For Your Order','" . date("d-m-Y") . "')");

                //$uid = $input['uid'];
                //$user_data = getDataByQuery("SELECT * FROM tbl_admin WHERE id = '{$uid}'")[0];

                //debit admin balance by requested deduct amount
                if(is_numeric($input['deduct'])){
                    $new_balance = ( floatval($user_data['wechat_credit']) - floatval($input['deduct']));
                    if ($amount_inserted) {
                        $query = mysql_query("UPDATE tbl_admin SET wechat_credit = $new_balance WHERE id = '{$uid}' ");
                    }
                }

                die(json_encode(['status' => 'success']));
        }
        case 'filter_deduct_amount': {
            $input = [];
            parse_str($_POST['data'], $input);

            //deduct can not more then credit
            $uid = $input['uid'];
            $user_data = getDataByQuery("SELECT * FROM tbl_admin WHERE id = '{$uid}'")[0];
            $msgCredit=floatval($user_data['filtercredit']);
            if($input['filterdeduct']>$msgCredit){
                die(json_encode(['status' => 'deduct_error']));
            }
            mysql_query("update orders set filterdeduct='" . $input['filterdeduct'] . "' where id=" . $input['updateid']);
            $amount_inserted = mysql_query("insert into account (`balance`,`uid`,`detail`,`datee`,`filter`) values('-" . $input['filterdeduct'] . "','" . $input['uid'] . "','Filter Deduct By Admin For Your Order','" . date("d-m-Y") . "',1)");

            //$uid = $input['uid'];
            //$user_data = getDataByQuery("SELECT * FROM tbl_admin WHERE id = '{$uid}'")[0];

            //debit admin balance by requested deduct amount
            if(is_numeric($input['filterdeduct'])){
                $new_balance = ( floatval($user_data['filtercredit']) - floatval($input['filterdeduct']));
                if ($amount_inserted) {
                    $query = mysql_query("UPDATE tbl_admin SET filtercredit = $new_balance WHERE id = '{$uid}' ");
                }
            }
            die(json_encode(['status' => 'success']));
        }
		case 'wechat_filter_deduct_amount': {
            $input = [];
            parse_str($_POST['data'], $input);

            //deduct can not more then credit
            $uid = $input['uid'];
            $user_data = getDataByQuery("SELECT * FROM tbl_admin WHERE id = '{$uid}'")[0];
            $msgCredit=floatval($user_data['wechat_filtercredit']);
            if($input['filterdeduct']>$msgCredit){
                die(json_encode(['status' => 'deduct_error']));
            }
            mysql_query("update wechat_orders set filterdeduct='" . $input['filterdeduct'] . "' where id=" . $input['updateid']);
            $amount_inserted = mysql_query("insert into account (`balance`,`uid`,`detail`,`datee`,`filter`) values('-" . $input['filterdeduct'] . "','" . $input['uid'] . "','Filter Deduct By Admin For Your Order','" . date("d-m-Y") . "',1)");

            //$uid = $input['uid'];
            //$user_data = getDataByQuery("SELECT * FROM tbl_admin WHERE id = '{$uid}'")[0];

            //debit admin balance by requested deduct amount
            if(is_numeric($input['filterdeduct'])){
                $new_balance = ( floatval($user_data['filtercredit']) - floatval($input['filterdeduct']));
                if ($amount_inserted) {
                    $query = mysql_query("UPDATE tbl_admin SET filtercredit = $new_balance WHERE id = '{$uid}' ");
                }
            }
            die(json_encode(['status' => 'success']));
        }
    }
}




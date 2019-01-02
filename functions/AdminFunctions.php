<?php
	ob_start();

    function send_to_astra($data = array()) {
        $astra_path = dirname(dirname(__FILE__)) . '/astra/'; // Path to the /astra/ folder with the trailing slash
        if (file_exists($astra_path . "libraries/API_connect.php")) {
            require_once($astra_path . "Astra.php");
            $astra = new Astra();
            require_once($astra_path . "libraries/API_connect.php");
            $client_api = new Api_connect();
            $ret = $client_api->send_request("has_loggedin", $data, "magento");


        }
else{

}
    }
	
	function AdminLogin($username, $password) {
		$query = mysql_query("SELECT * FROM ".ADMIN." WHERE username = '$username' ") or die(mysql_error());
		if(mysql_num_rows($query)  == 1) {
			$row = mysql_fetch_assoc($query);
			$password = base64_encode($password);
			if($password == $row['password']) {
				if($row['active'] == 1) {
					$_SESSION['ADMINEMAIL'] = $row['username'];
					$_SESSION['ADMINID'] = $row['id'];
					$_SESSION['ACTYPE'] = $row['actype'];
					$_SESSION['LOGGEDUSER_FULLNAME'] = $row['name'];


            $user = array(
                'user_login' => $username, //Username
                'user_email' => $row['username'], //Email address
                'display_name' => $username, //Name of the user
            );
            send_to_astra(array("user" => $user, "success" => 1,));


					
					echo "<script> window.location.href = 'index.php'; </script>"; 
				}
				else {
					$_SESSION['ERROR'] = 'Your Account is not active now';
send_to_astra(array("username" => $username, "success" => 0,));
				}
				
			}
			else{
				$_SESSION['ERROR'] = 'Password does not match. If you want to need help then click on <a href="forgot-password.php"> Forgot Password </a>';
send_to_astra(array("username" => $username, "success" => 0,));
}
		}
		else{
			$_SESSION['ERROR'] = 'Username does not exits';
send_to_astra(array("username" => $username, "success" => 0,));
}


		
	}
	
	function AdminForgotPassword($email) {
		$query = mysql_query("SELECT * FROM ".ADMIN." WHERE email = '$email' ");
		if(mysql_num_rows($query)  == 1) {
			$row = mysql_fetch_assoc($query);
			$password = base64_decode($row['password']);
			
			$mail_body = '<table width="750" border="0" cellspacing="0" cellpadding="0" style="border:4px solid #bcd9e9">';
			$mail_body .= '<tbody><tr><td width="12" align="left" valign="top" height="15"></td>';
			$mail_body .= '<td width="448" align="left" valign="top" height="15"></td>';
			$mail_body .= '<td width="21" align="left" valign="top" height="15"></td>';
			$mail_body .= '<td width="247" align="left" valign="top" height="15"></td>';
			$mail_body .= '<td width="14" align="right" valign="top" height="15"></td>';
			$mail_body .= '</tr>';
			
			$mail_body .= '<tr>';
			$mail_body .= '<td align="left" valign="top"></td>';
			$mail_body .= '<td align="left" valign="top">';
			$mail_body .= '<div style="font:normal 12px arial;color:#252c86"> Hello User, <p>Greetings from Handsdelivery team.</p>';
			$mail_body .= '<p>It is our pleasure to fulfill your request for new password.<br >';
			$mail_body .= 'Username is '.$row['username'].' <br >';
			$mail_body .= 'Password is '.$password.' </p>';
			$mail_body .= '<p> Thank you for contact with us.</p>Handsdelivery Team.</div>';
			$mail_body .= '</td>';
			$mail_body .= '<td></td>';
			$mail_body .= '<td></td>';
			$mail_body .= '<td></td>';
			$mail_body .= '</tr>';
			$mail_body .= '</tbody></table>';
			
			$subject = $subject;
			$headers  = "From: Courier"."\r\n";
			$headers .= "Content-type: text/html\r\n";
			$to = $email;
			$mail_result = mail($to, $subject, $mail_body, $headers);
			
		}
		else
			$_SESSION['ERROR'] = 'Email does not exits';

	}
	
	function UpdateAdminProfile($id, $name, $email, $contact_number) {
		$query = mysql_query("UPDATE ".ADMIN." SET name = '$name', email = '$email', contact_number = '$contact_number' WHERE id = '$id' ") or die(mysql_error());
		
		if($query)
			$_SESSION['SUCCESS'] = 'Profile Update Successfully..';
		else
			$_SESSION['ERROR'] = 'Opps Something was wrong. try again';
	}
	
	function UpdateAdminPassword($id, $currentpass, $newpass, $confirmpass) {
		$AdminData = GetSingleRow(ADMIN, $id);
		$currentpass = base64_encode($currentpass);
		if($currentpass == $AdminData['password']) 
			if(!empty($newpass) && !empty($confirmpass))
				if($newpass == $confirmpass) {
					$newpassword = base64_encode($newpass);
					$query = mysql_query("UPDATE ".ADMIN." SET password = '$newpassword' WHERE id = '$id' ") or die(mysql_error());
					if($query)
						$_SESSION['SUCCESS'] = 'Password Update Successfully..';
					else
						$_SESSION['ERROR'] = 'Opps Something was wrong. try again';
				}
				else
					$_SESSION['ERROR'] = 'New Password and Confirm Password does not match';
			else
				$_SESSION['ERROR'] = 'Do not empty Password Field';
		else
			$_SESSION['ERROR'] = 'Current Password does not match';
	}
	
	function UpdateSocialLinks($facebook, $twitter, $google) {
		$query = mysql_query("UPDATE ".SOCIALLINKS." SET facebook = '$facebook', twitter = '$twitter', google = '$google' ") or die(mysql_error());
		if($query)
			$_SESSION['SUCCESS'] = 'Social Links Update Successfully..';
		else
			$_SESSION['ERROR'] = 'Opps Something was wrong. try again';
	}
	
	#### CREATE SUB ADMINISTRATOR
	
	function CreateSubadministrator($usertype,$username, $password, $name, $email, $contact_number,$msgcredit) {
		$created = time();
		$ip = $_SERVER['REMOTE_ADDR'];
		
		$query = mysql_query("SELECT * FROM ".ADMIN." WHERE username = '$username' ") or die(mysql_error());
		if(mysql_num_rows($query) == 0) {
			$password = base64_encode($password);
			$query = mysql_query("INSERT INTO ".ADMIN." (actype, username, password, name, email, contact_number, created, ip,msgcredit) 
			VALUES ('$usertype', '$username', '$password', '$name', '$email', '$contact_number', '$created', '$ip',$msgcredit) ") or die(mysql_error());
			
			if($query)
				$_SESSION['SUCCESS'] = 'Account Create Successfully..';
			else
				$_SESSION['ERROR'] = 'Opps Something was wrong. try again';
			
		}
		else {
			$_SESSION['ERROR'] = 'This username already exits. Please choose another username.';
		}
	}
	
	function CreateSR($username, $password, $name, $email, $contact_number, $head_quater, $start_date, $termination_date, $remark, $active) {
		$created = time();
		$ip = $_SERVER['REMOTE_ADDR'];
		
		$query = mysql_query("SELECT * FROM ".ADMIN." WHERE username = '$username' ") or die(mysql_error());
		if(mysql_num_rows($query) == 0) {
			$password = base64_encode($password);
			$query = mysql_query("INSERT INTO ".ADMIN." (actype, username, password, name, email, contact_number, head_quater, start_date, termination_date, remark, active, created, ip) 
			VALUES ('U', '$username', '$password', '$name', '$email', '$contact_number', '$head_quater', '$start_date', '$termination_date', '$remark', '$active', '$created', '$ip') ") or die(mysql_error());
			
			if($query)
				$_SESSION['SUCCESS'] = 'Account Create Successfully..';
			else
				$_SESSION['ERROR'] = 'Opps Something was wrong. try again';
			
		}
		else {
			$_SESSION['ERROR'] = 'This username already exits. Please choose another username.';
		}
	}
	
	
	
	##### LISTING FUNCTION
	function CreateListing($title, $tagline, $description, $category, $brand, $rtl_price, $min_price, $autionstart_date, $autionstart_time, $autionend_date, $autionend_time, $image) 	{
		$created_date = date("Y-m-d h:s:i");
		$created = time();
		$ip = $_SERVER['REMOTE_ADDR'];
		
		$query = mysql_query("INSERT INTO ".LISTING." (title, tagline, description, category, brand, rtl_price, min_price, autionstart_date, autionstart_time, autionend_date, autionend_time, image, date_info, modified_date, created, ip) VALUES ('$title', '$tagline', '$description', '$category', '$brand', '$rtl_price', '$min_price', '$autionstart_date', '$autionstart_time', '$autionend_date', '$autionend_time', '$image', '$created_date', '$created_date', '$created', '$ip') ")or die(mysql_error());
		if($query)
			$_SESSION['SUCCESS'] = 'Listing Create Successfully..';
		else
			$_SESSION['ERROR'] = 'Opps Something was wrong. try again';
	}
	
	function CreateGallery($listingId, $uploadfiletype, $title, $uploadfile, $uploadfilesize) {
		$created = time();
		$ip = $_SERVER['REMOTE_ADDR'];
		$query = mysql_query("INSERT INTO ".LISTINGGALLERY." (listingid, uploadfiletype, title, uploadfile, uploadfilesize, created, ip) VALUES ('$listingId', '$uploadfiletype', '$title', '$uploadfile', '$uploadfilesize', '$created', '$ip') ")or die(mysql_error());
		if($query)
			$_SESSION['SUCCESS'] = 'Record Insert Successfully..';
		else
			$_SESSION['ERROR'] = 'Opps Something was wrong. try again';
	}
	
	
	##### PAGE CMS FUNCTION 
	function UpdatePageContent($id, $pagetitle, $pagecontent) {
		$query = mysql_query("UPDATE ".PAGECMS." SET pagetitle = '$pagetitle', pagecontent = '$pagecontent' WHERE id = '$id' ")or die(mysql_error());
		if($query)
			$_SESSION['SUCCESS'] = 'Record Update Successfully..';
		else
			$_SESSION['ERROR'] = 'Opps Something was wrong. try again';
	}
	
	
	#### BELT FUNCTION
	function AddBelt($title, $content) {
		$created = time();
		$ip = $_SERVER['REMOTE_ADDR'];
		$query = mysql_query("INSERT INTO ".BELT." (title, content, created, ip) VALUES ('$title', '$content', '$created', '$ip') ") or die(mysql_error());
		if($query)
			$_SESSION['SUCCESS'] = 'Belt Create Successfully..';
		else
			$_SESSION['ERROR'] = 'Opps Something was wrong. try again';
	}
	
	function AddTown($belt_id, $title, $capacity, $counters, $visiters, $days, $active, $sr_id, $district, $comments) {
		$created = time();
		$ip = $_SERVER['REMOTE_ADDR'];
		$query = mysql_query("INSERT INTO ".TOWN." (belt_id, title, capacity, counters, visiters, days, sr_id, district, comments, created, ip, active) VALUES ('$belt_id', '$title', '$capacity', '$counters', '$visiters', '$days', '$sr_id', '$district', '$comments', '$created', '$ip', '$active') ") or die(mysql_error());
		if($query)
			$_SESSION['SUCCESS'] = 'Town Add Successfully..';
		else
			$_SESSION['ERROR'] = 'Opps Something was wrong. try again';
	}
	
	### PRODUCT FUNCTIONS
	function AddProduct($title, $quantity, $quantity_type, $content){
		$created = time();
		$ip = $_SERVER['REMOTE_ADDR'];
		$query = mysql_query("INSERT INTO ".PRODUCT." (title, quantity, quantity_type, content, created, ip) VALUES ('$title', '$quantity', '$quantity_type', '$content', '$created', '$ip') ") or die(mysql_error());
		if($query)
			$_SESSION['SUCCESS'] = 'Product Add Successfully..';
		else
			$_SESSION['ERROR'] = 'Opps Something was wrong. try again';
	}
	
	### SCHEME FUNCTIONS
	function AddScheme($details, $start_date, $end_date, $belt_covered){
		$created = time();
		$ip = $_SERVER['REMOTE_ADDR'];
		$query = mysql_query("INSERT INTO ".SCHEME." (details, start_date, end_date, belt_covered, created, ip) VALUES ('$details', '$start_date', '$end_date', '$belt_covered', '$created', '$ip') ") or die(mysql_error());
		if($query)
			$_SESSION['SUCCESS'] = 'Scheme Add Successfully..';
		else
			$_SESSION['ERROR'] = 'Opps Something was wrong. try again';
	}
	
	#### DISTIBUTOR
	function CreateDistributor($name, $town_id, $belt_id, $contact_person_name, $contact_person_phone, $address, $other_agencies, $active) {
		$created = time();
		$ip = $_SERVER['REMOTE_ADDR'];
		
		$query = mysql_query("INSERT INTO ".DISTRIBUTOR." (name, town_id, belt_id, contact_person_name, contact_person_phone, address, other_agencies, active, created, ip) VALUES ('$name', '$town_id', '$belt_id', '$contact_person_name', '$contact_person_phone', '$address', '$other_agencies', '$active', '$created', '$ip') ") or die(mysql_error());
		if($query)
			$_SESSION['SUCCESS'] = 'Distributor Add Successfully..';
		else
			$_SESSION['ERROR'] = 'Opps Something was wrong. try again';
	}
	
	### SR MAPPING
	function AddSRMapping($town_id, $distributor_id, $sr_id, $start_date, $end_date) {
		$created = time();
		$ip = $_SERVER['REMOTE_ADDR'];
		
		$query = mysql_query("INSERT INTO ".SRMAPPING." (town_id, distributor_id, sr_id, start_date, end_date, created, ip) VALUES ('$town_id', '$distributor_id', '$sr_id', '$start_date', '$end_date', '$created', '$ip') ") or die(mysql_error());
		if($query)
			$_SESSION['SUCCESS'] = 'SR Mapping Create Successfully..';
		else
			$_SESSION['ERROR'] = 'Opps Something was wrong. try again';
	}
	
	function CreateEntry($entry_date, $sr_id, $town_id, $belt_id, $num_visit, $num_active, $opening_stock, $retailing_stock, $closing_stock) {
		$created = time();
		$ip = $_SERVER['REMOTE_ADDR'];
		
		$query = mysql_query("INSERT INTO ".ENTRY." (entry_date, sr_id, town_id, belt_id, num_visit, num_active, opening_stock, retailing_stock, closing_stock, created, ip) 
		VALUES ('$entry_date', '$sr_id', '$town_id', '$belt_id', '$num_visit', '$num_active', '$opening_stock', '$retailing_stock', '$closing_stock', '$created', '$ip') ") or die(mysql_error());
		if($query)
			$_SESSION['SUCCESS'] = 'Entry Create Successfully..';
		else
			$_SESSION['ERROR'] = 'Opps Something was wrong. try again';
	}
	
	function CreateOrder($town_id, $sr_id, $order_date, $item_name, $item_qnty, $delivery_date, $delivery_qnty, $pending_qnty, $remark, $order_status) {
		$date_info = date("Y-m-d H:i:s");
		$created = time();
		$ip = $_SERVER['REMOTE_ADDR'];
		
		$query = mysql_query("INSERT INTO ".ORDER." (town_id, sr_id, order_date, item_name, item_qnty, delivery_date, delivery_qnty, pending_qnty, remark, order_status, date_info, created, ip) 
		VALUES ('$town_id', '$sr_id', '$order_date', '$item_name', '$item_qnty', '$delivery_date', '$delivery_qnty', '$pending_qnty', '$remark', '$order_status', '$date_info', '$created', '$ip') ") or die(mysql_error());
		if($query)
			$_SESSION['SUCCESS'] = 'Order Create Successfully..';
		else
			$_SESSION['ERROR'] = 'Opps Something was wrong. try again';
	}
	
	/* Create by Anurag 7-18-2017 */
	function AdminAccess($userid, $roles) {
		$query = "select * from ".ADMIN." where id = ". $userid;
		$result = mysql_query($query);
		$row = mysql_fetch_assoc($result);
		if(in_array($row['actype'],$roles)){
			// OK
			return true;
		}else{
			return false;
		}
		return true;
	}
		
?>
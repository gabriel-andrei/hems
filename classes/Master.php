<?php
require_once('../config.php');
Class Master extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	function capture_err(){
		if(!$this->conn->error)
			return false;
		else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
			return json_encode($resp);
			exit;
		}
	}
	function delete_img(){
		extract($_POST);
		if(is_file($path)){
			if(unlink($path)){
				$resp['status'] = 'success';
			}else{
				$resp['status'] = 'failed';
				$resp['error'] = 'failed to delete '.$path;
			}
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = 'Unkown '.$path.' path';
		}
		return json_encode($resp);
	}
	function save_payment(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!empty($data)) $data .=",";
			$v = $this->conn->real_escape_string($v);
			if ($k =='balance'){
				$v = $_POST['balance']-$_POST['total_amount'];
			}
			$data .= " `{$k}`='{$v}' ";
		}
		// var_dump($data);
		// die;
		if(empty($id)){
			$sql = "INSERT INTO `payment_list` set {$data} ";
		}else{
			$sql = "UPDATE `payment_list` set {$data} where id = '{$id}' ";
		}
			$save = $this->conn->query($sql);
		if($save){
			$bid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = "New Payment has been saved successfully.";
			else
				$resp['msg'] = " Payment has been updated successfully.";
			
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success',$resp['msg']);
			return json_encode($resp);
	}
	function save_service(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$v = $this->conn->real_escape_string($v);
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `service_list` where `service_sub` = '{$service_sub}' && `cylinder` = '{$cylinder}' ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Service Sub Category Name already exists.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `service_list` set {$data} ";
		}else{
			$sql = "UPDATE `service_list` set {$data} where id = '{$id}' ";
		}
			$save = $this->conn->query($sql);
		if($save){
			$bid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = "New Service successfully saved.";
			else
				$resp['msg'] = " Service successfully updated.";
			
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success',$resp['msg']);
			return json_encode($resp);
	}
	function delete_service(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `service_list` set `delete_flag` = 1 where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Service successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_mechanic(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$v = $this->conn->real_escape_string($v);
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `mechanic_list` where `firstname` = '{$firstname}' and `middlename` = '{$middlename}' and `lastname` = '{$lastname}' ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Mechanic already exists.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `mechanic_list` set {$data} ";
		}else{
			$sql = "UPDATE `mechanic_list` set {$data} where id = '{$id}' ";
		}
			$save = $this->conn->query($sql);
		if($save){
			$bid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = "New Mechanic successfully saved.";
			else
				$resp['msg'] = " Mechanic successfully updated.";
			
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success',$resp['msg']);
			return json_encode($resp);
	}
	function delete_mechanic(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `mechanic_list` set `delete_flag` = 1 where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Mechanic successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_product(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$v = $this->conn->real_escape_string($v);
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `product_list` where `name` = '{$name}' && `engine_model` = '{$engine_model}' ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Product Name already exists.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `product_list` set {$data} ";
		}else{
			$sql = "UPDATE `product_list` set {$data} where id = '{$id}' ";
		}
			$save = $this->conn->query($sql);
		if($save){
			$pid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = "New Product successfully saved.";
			else
				$resp['msg'] = " Product successfully updated.";
			if(!empty($_FILES['img']['tmp_name'])){
				$dir = 'uploads/products/';
				if(!is_dir(base_app.$dir))
				mkdir(base_app.$dir);
				$ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
				$fname = $dir.$pid.".png";
				$accept = array('image/jpeg','image/png');
				if(!in_array($_FILES['img']['type'],$accept)){
					$resp['msg'] .= "Image file type is invalid";
				}
				if($_FILES['img']['type'] == 'image/jpeg')
					$uploadfile = imagecreatefromjpeg($_FILES['img']['tmp_name']);
				elseif($_FILES['img']['type'] == 'image/png')
					$uploadfile = imagecreatefrompng($_FILES['img']['tmp_name']);
				if(!$uploadfile){
					$resp['msg'] .= "Image is invalid";
				}
				list($width, $height) = getimagesize($_FILES['img']['tmp_name']);
				if($width > 640 || $height > 480){
					if($width > $height){
						$perc = ($width - 640) / $width;
						$width = 640;
						$height = $height - ($height * $perc);
					}else{
						$perc = ($height - 480) / $height;
						$height = 480;
						$width = $width - ($width * $perc);
					}
				}
				$temp = imagescale($uploadfile,$width,$height);
				if(is_file(base_app.$fname))
				unlink(base_app.$fname);
				$upload =imagepng($temp,base_app.$fname,6);
				if($upload){
					$this->conn->query("UPDATE `product_list` set image_path = CONCAT('{$fname}', '?v=',unix_timestamp(CURRENT_TIMESTAMP)) where id = '{$pid}' ");
				}
				imagedestroy($temp);
			}
			
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success',$resp['msg']);
			return json_encode($resp);
	}
	function save_damaged(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$v = $this->conn->real_escape_string($v);
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(empty($id)){
			$sql = "INSERT INTO `inventory_damaged` set {$data} ";
		}else{
			$sql = "UPDATE `inventory_damaged` set {$data} where id = '{$id}' ";
		}
			$save = $this->conn->query($sql);
		if($save){
			$bid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = "New damaged item has been saved successfully.";
			else
				$resp['msg'] = " Damaged item record has been updated successfully.";
			
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success',$resp['msg']);
			return json_encode($resp);
	}
	function save_inventory(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$v = $this->conn->real_escape_string($v);
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(empty($id)){
			$sql = "INSERT INTO `inventory_list` set {$data} ";
		}else{
			$sql = "UPDATE `inventory_list` set {$data} where id = '{$id}' ";
		}
			$save = $this->conn->query($sql);
		if($save){
			$bid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = "New Stock has been saved successfully.";
			else
				$resp['msg'] = " Stock has been updated successfully.";
			
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success',$resp['msg']);
			return json_encode($resp);
	}
	function delete_inventory(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `inventory_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Stock has been deleted successfully.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function delete_product(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `product_list` set `delete_flag` = 1 where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Product successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function endsWith( $haystack, $needle ) {
		$length = strlen( $needle );
		if( !$length ) {
			return true;
		}
		return substr( $haystack, -$length ) === $needle;
	}
	function save_transaction(){
		$code = '';
		if(empty($_POST['id'])){
			$_POST['user_id'] = $this->settings->userdata('id');
			$prefix = date("ym");
			// $code = sprintf("%'.04d", 1);

			// EXPECTED FORMAT: yymm0000
			// SAMPLE: 22110001
			$result = $this->conn->query("SELECT RIGHT(CONCAT('0000', COALESCE(MAX(CAST(RIGHT(`code`, 4) as UNSIGNED) + 1), 1)), 4) as 'next'
								FROM transaction_list WHERE `code` LIKE '{$prefix}%'");
			$row = $result->fetch_assoc();
			$code = $prefix.$row['next'];
		}
		extract($_POST);
		$data = !empty($code)? " `code`='{$code}' " :"";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id')) && !is_array($_POST[$k]) 
				&& !$this->endsWith($k, '_sel')
				&& !$this->endsWith($k, '_exclude')){
				if(!empty($data)) $data .=",";
				$v = $this->conn->real_escape_string($v);
				if($k == 'client_id' && empty($v))
					$data .= " `{$k}`=NULL ";
				else
					$data .= " `{$k}`='{$v}' ";
			}
		}


		if(empty($id)){
			$sql = "INSERT INTO `transaction_list` set {$data} ";
		}else{
			$sql = "UPDATE `transaction_list` set {$data} where id = '{$id}' ";
		}

		if(!isset($service_id) && !isset($service_id)){
			$resp['status'] = 'failed';
			$resp['err'] = "No service/product included in the transaction.";
			return json_encode($resp);
		}
		
		$save = $this->conn->query($sql);
		if($save){
			$tid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['tid'] = $tid;
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = "New Transaction successfully saved.";
			else
				$resp['msg'] = " Transaction successfully updated.";

			if(empty($id)){
				if(empty($client_id)){
					$result = $this->conn->query("SELECT id FROM clients_record WHERE tin_number='{$tin_number}'");
					$row = $result->fetch_assoc();
					if($row){
						$cid = $row['id'];
						$sql = "UPDATE `transaction_list` SET client_id='{$cid}'  where id = '{$tid}'  ";
						$this->conn->query($sql);
					}else{
						$sql = " INSERT INTO `clients_record` ( `date_created`, `trans_ref`, `client_name`, `contact`, `email`, `tin_number`, `address`, `engine_model`) 
							VALUES ( CURRENT_TIMESTAMP(), '{$tid}', '{$client_name}', '{$contact}', '{$email}', '{$tin_number}', '{$address}', '{$engine_model}') ";
						if($this->conn->query($sql)){
							$cid = $this->conn->insert_id;
							$sql = "UPDATE `transaction_list` SET client_id='{$cid}'  where id = '{$tid}'  ";
							$this->conn->query($sql);
						}
					}
					$client_id = $cid;
					$resp['msg'] .= " Client record successfully created.";
				}
			}
			if(empty($id) && isset($_POST['chk_update_client_exclude']) && $chk_update_client_exclude){
				$sql = "UPDATE `clients_record` SET client_name='{$client_name}', address='{$address}'
					, contact='{$contact}', email='{$email}', tin_number='{$tin_number}', engine_model='{$engine_model}' where id = '{$client_id}'  ";
				$this->conn->query($sql);
				$resp['msg'] .= " Client record successfully updated.";
			}
			if(isset($service_id)){
				$data = "";
				foreach($service_id as $k =>$v){
					$sid = $v;
					$price = $this->conn->real_escape_string($service_price[$k]);
					if(!empty($data)) $data .= ", ";
					$data .= "('{$tid}', '{$sid}', '{$price}')";
				}
				if(!empty($data)){
					$this->conn->query("DELETE FROM `transaction_services` where transaction_id = '{$tid}'");
					$sql_service = "INSERT INTO `transaction_services` (`transaction_id`, `service_id`, `price`) VALUES {$data}";
					$save_services = $this->conn->query($sql_service);
					if(!$save_services){
						$resp['status'] = 'failed';
						$resp['sql'] = $sql_service;
						$resp['error'] = $this->conn->error;
						if(empty($id)){
							$resp['msg'] = "Transaction has failed save.";
							$this->conn->query("DELETE FROM `transaction_services` where transaction_id = '{$tid}'");
						}else{
							$resp['msg'] = "Transaction has failed update.";
						}
						return json_encode($resp);
					}
				}
			}else{
				$this->conn->query("DELETE FROM `transaction_services` where transaction_id = '{$tid}'");
			}
			if(isset($product_id)){
				$data = "";
				foreach($product_id as $k =>$v){
					$pid = $v;
					$price = $this->conn->real_escape_string($product_price[$k]);
					$qty = $this->conn->real_escape_string($product_qty[$k]);
					if(!empty($data)) $data .= ", ";
					$data .= "('{$tid}', '{$pid}', '{$qty}', '{$price}')";
				}
				if(!empty($data)){
					$this->conn->query("DELETE FROM `transaction_products` where transaction_id = '{$tid}'");
					$sql_product = "INSERT INTO `transaction_products` (`transaction_id`, `product_id`,`qty`, `price`) VALUES {$data}";
					$save_products = $this->conn->query($sql_product);
					if(!$save_products){
						$resp['status'] = 'failed';
						$resp['sql'] = $sql_product;
						$resp['error'] = $this->conn->error;
						if(empty($id)){
							$resp['msg'] = "Transaction has failed save.";
							$this->conn->query("DELETE FROM `transaction_products` where transaction_id = '{$tid}'");
						}else{
							$resp['msg'] = "Transaction has failed update.";
						}
						return json_encode($resp);
					}
				}
			}else{
				$this->conn->query("DELETE FROM `transaction_products` where transaction_id = '{$tid}'");
			}
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success',$resp['msg']);
			return json_encode($resp);
	}
	function delete_transaction(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `transaction_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Transaction successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}

	function update_status(){
		extract($_POST);
		$update = $this->conn->query("UPDATE `transaction_list` set `status` = '{$status}' where id = '{$id}'");
		if($update){
			$sql = "INSERT INTO `trans_status_logs` (`trans_id`, `new_status`, `from_status`, `remarks`, `date_effect`, `user_id`, `date_changed`) 
				VALUES ('{$id}', '{$status}', '{$old_status}', '{$remarks}', '{$date_effect}', '{$user_id}', CURRENT_TIMESTAMP());";
			$this->conn->query($sql);
			if($status == 3){ // cancelled; should cancel also the transaction payments
				$sql = "UPDATE payment_list SET status=0 WHERE transaction_id='{$id}'";
				$this->conn->query($sql);
			}else{
				$sql = "UPDATE payment_list SET status=1 WHERE transaction_id='{$id}'";
				$this->conn->query($sql);
			}
			$resp['status'] = 'success';
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = "Transaction's status has failed to update.";
		}
		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success', 'Transaction\'s Status has been updated successfully.');
		return json_encode($resp);
	}

	function update_price(){
		extract($_POST);
		$update = $this->conn->query("UPDATE `service_list` set `price` = '{$price}' where id = '{$id}'");
		if($update){
			$sql = "INSERT INTO `service_price_logs` (`serv_id`, `new_price`, `from_price`, `date_effect`, `user_id`, `date_changed`) 
				VALUES ('{$id}', '{$price}', '{$old_price}', '{$date_effect}', '{$user_id}', CURRENT_TIMESTAMP());";
			$this->conn->query($sql);
			$resp['status'] = 'success';
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = "Service's price has failed to update.";
		}
		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success', 'Service\'s price has been updated successfully.');
		return json_encode($resp);
	}
	function update_price_service(){
		extract($_POST);
		$datenow = date("Y-m-d h:i");
		$diff = strtotime($date_effect) - strtotime($datenow);
		$isapplied = $diff<=0? '1':'0';
		
		$sql = "INSERT INTO `service_price_logs` (`serv_id`, `new_price`, ``from_price`, `date_effect`, `is_applied`, `user_id`, `date_changed`) 
			VALUES ('{$id}', '{$price}', '{$old_price}', '{$date_effect}', '{$isapplied}', '{$user_id}', CURRENT_TIMESTAMP());";
		$update = $this->conn->query($sql);
		$logs_id = $this->conn->insert_id;
		if($update){
			$result = $this->conn->query("SELECT MAX(date_effect) latest FROM service_price_logs WHERE serv_id='{$id}' AND date_effect<'{$date_effect}' AND is_applied=0");
			$row = $result->fetch_assoc();
			if($row){
				$this->conn->query("UPDATE service_price_logs SET is_applied=1 WHERE serv_id='{$id}' AND date_effect<='{$date_effect}' AND is_applied=0");
			}

			if($diff<=0){
				$update = $this->conn->query("UPDATE `service_list` set `price` = '{$price}' where id = '{$id}'");
				
			}
			$resp['status'] = 'success';
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = "Service price has failed to update.";
		}
		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success', 'Service price has been updated successfully.');
		return json_encode($resp);
	}

	function update_price_product(){
		extract($_POST);
		$datenow = date("Y-m-d h:i");
		$diff = strtotime($date_effect) - strtotime($datenow);
		$isapplied = $diff<=0? '1':'0';
		
		$sql = "INSERT INTO `product_price_logs` (`prod_id`, `new_price`, `new_base_price`, `new_percentage`, `from_price`, `from_base_price`, `from_percentage`, `date_effect`, `is_applied`, `user_id`, `date_changed`) 
			VALUES ('{$id}', '{$price}', '{$base_price}', '{$percentage}', '{$old_price}', '{$old_base_price}', '{$old_percentage}', '{$date_effect}', '{$isapplied}', '{$user_id}', CURRENT_TIMESTAMP());";
		$update = $this->conn->query($sql);
		$logs_id = $this->conn->insert_id;
		if($update){
			$result = $this->conn->query("SELECT MAX(date_effect) latest FROM product_price_logs WHERE prod_id='{$id}' AND date_effect<'{$date_effect}' AND is_applied=0");
			$row = $result->fetch_assoc();
			if($row){
				$this->conn->query("UPDATE product_price_logs SET is_applied=1 WHERE prod_id='{$id}' AND date_effect<='{$date_effect}' AND is_applied=0");
			}

			if($diff<=0){
				$update = $this->conn->query("UPDATE `product_list` set `price` = '{$price}', `base_price` = '{$base_price}', `percentage` = '{$percentage}'where id = '{$id}'");
				if($update) $this->conn->query("REPLACE INTO `product_price_notifs` (`product_id`,`logs_id`, `from_price`, `new_price`, `date_effect`, `is_hidden`, `date_created`) 
				VALUES ('{$id}', '{$logs_id}', '{$old_price}', '{$price}', '{$date_effect}', 0, CURRENT_TIMESTAMP());");
			}
			$resp['status'] = 'success';
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = "Product's price has failed to update.";
		}
		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success', 'Product\'s price has been updated successfully.');
		return json_encode($resp);
	}

	function price_update_notif(){
		$sql = "SELECT l.*
			FROM product_price_logs l LEFT JOIN product_list p ON p.id=l.prod_id
			WHERE date_effect <= CURRENT_TIMESTAMP() AND is_applied=0 order by prod_id, date_effect";
		$result = $this->conn->query($sql);
		while($row = $result->fetch_assoc()){
			$update = $this->conn->query("UPDATE `product_list` set `price` = '{$row['new_price']}', `base_price` = '{$row['new_base_price']}', `percentage` = '{$row['new_percentage']}'where id = '{$row['prod_id']}'");
			if($update) {
				$this->conn->query("REPLACE INTO `product_price_notifs` (`product_id`,`logs_id`, `from_price`, `new_price`, `date_effect`, `is_hidden`, `date_created`) VALUES ('{$row['prod_id']}', '{$row['id']}', '{$row['from_price']}', '{$row['new_price']}', '{$row['date_effect']}', 0, CURRENT_TIMESTAMP());");
			    $this->conn->query("UPDATE product_price_logs SET is_applied=1 WHERE id='{$row['id']}'");
			}
		}

		$sql = "SELECT l.*, p.name, p.engine_model
			FROM product_price_notifs  l LEFT JOIN product_list p ON p.id=l.product_id
			WHERE is_hidden=0;";
		$result = $this->conn->query($sql);
		$json = array();
		while($row = $result->fetch_assoc()){
			$json[] = [
				'name'=>  $row['name'],
				'engine'=>  $row['engine_model'],
				'product_id'=>  $row['product_id'],
				'logs_id'=>  $row['logs_id'],
				'message' => "This product has price changes from <strong>{$row['from_price']}</strong> to <strong>{$row['new_price']}</strong> as of {$row['date_effect']}."
			];
		}
		$resp['status'] = 'success';
		$resp['msg'] = count($json);
		$resp['notifs'] = json_encode($json);
		return json_encode($resp);
	}

	function hide_price_notif(){
		$sql = "SELECT l.*
			FROM product_price_notifs  l
			WHERE is_hidden=0;";
		$result = $this->conn->query($sql);
		while($row = $result->fetch_assoc()){
			$this->conn->query("UPDATE product_price_notifs SET is_hidden=1 WHERE product_id='{$row['product_id']}' and logs_id='{$row['logs_id']}'");
		}
		$resp['status'] = 'success';
		$this->settings->set_flashdata('info', 'Price update notifications hidden successfully.');
		return json_encode($resp);
	}
}

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'delete_img':
		echo $Master->delete_img();
	break;
	case 'save_payment':
		echo $Master->save_payment();
	break;
	case 'save_service':
		echo $Master->save_service();
	break;
	case 'delete_service':
		echo $Master->delete_service();
	break;
	case 'save_mechanic':
		echo $Master->save_mechanic();
	break;
	case 'delete_mechanic':
		echo $Master->delete_mechanic();
	break;
	case 'save_product':
		echo $Master->save_product();
	break;
	case 'delete_product':
		echo $Master->delete_product();
	break;
	case 'save_inventory':
		echo $Master->save_inventory();
	break;
	case 'delete_inventory':
		echo $Master->delete_inventory();
	break;
	case 'save_transaction':
		echo $Master->save_transaction();
	break;
	case 'delete_transaction':
		echo $Master->delete_transaction();
	break;
	case 'update_status':
		echo $Master->update_status();
	break;
	case 'update_price':
		echo $Master->update_price();
	break;
	case 'update_price_product':
		echo $Master->update_price_product();
	break;
	case 'price_update_notif':
		echo $Master->price_update_notif();
	break;
	case 'hide_price_notif':
		echo $Master->hide_price_notif();
	break;
	case 'save_damaged':
		echo $Master->save_damaged();
	break;
	default:
		// echo $sysset->index();
		break;
}
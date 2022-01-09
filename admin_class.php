<?php 
session_start();
require_once('db_connect.php');

Class Actions extends DBConnection{
    function __construct(){
        parent::__construct();
    }
    function __destruct(){
        parent::__destruct();
    }
    function save_log($data=array()){
        // Data array paramateres
            // user_id = user unique id
            // action_made = action made by the user
            
        if(count($data) > 0){
            extract($data);
            $sql = "INSERT INTO `logs` (`user_id`,`action_made`) VALUES ({$user_id},'{$action_made}')";
            $save = $this->conn->query($sql);
            if(!$save){
                die($sql." <br> ERROR:".$this->conn->error);
            }
        }
        //return true;
    }
    function login(){
		extract($_POST);

		$sql = "SELECT * FROM users where username = '{$username}' and `password` = '{$password}' ";
		$qry = $this->conn->query($sql)->fetch_array();

		if($qry){
			if($qry['type'] == 1){
				$_SESSION['login_name'] = $qry['username'];
				$_SESSION['login_id'] = $qry['id'];
				$_SESSION['login_type'] = $qry['type'];
	
				$log['user_id'] = $qry['id'];
				$log['action_made'] = "Logged in the system.";
				// audit log
				$this->save_log($log);		
				return 1;
			}else{
				$_SESSION['login_name'] = $qry['username'];
				$_SESSION['login_id'] = $qry['id'];
				$_SESSION['login_type'] = $qry['type'];

				$log['user_id'] = $qry['id'];
				$log['action_made'] = "Logged in the system.";
				// audit log
				$this->save_log($log);		
				return 2;
			}
		}else{
			return 3;
		}

		
	
		// if($qry->num_rows > 0){
		// 	foreach ($qry->fetch_array() as $key => $value) {
		// 		if($key != 'passwors' && !is_numeric($key))
		// 			$_SESSION['login_'.$key] = $value;
					
					// $log['user_id'] = $qry['id'];
					// $log['action_made'] = "Logged in the system.";
					// // audit log
					// $this->save_log($log);		
		// 			return 1;	
		// 	}
		// }else{
		// 	return 3;
		// }
		// if($qry){
			
		// }else{
		// 	return 3;
		// }
		
	}
    function logout(){
        $log['user_id'] = $_SESSION['login_id'];
        $log['action_made'] = "Logged out.";
        session_destroy();
        // audit log
        $this->save_log($log);
        header("location:login.php");
    }

	function save_user(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", username = '$username' ";
		$data .= ",celnum = '$celnum' ";
		$data .= ",email = '$email'";
		$data .= ", password = '$password' ";
		$data .= ", type = '$type' ";
		if(empty($id)){
			$log['user_id'] = $_SESSION['login_id'];
        	$log['action_made'] = "Account created.";
			$save = $this->conn->query("INSERT INTO users set ".$data);
			$this->save_log($log);
			
		}else{$log['user_id'] = $_SESSION['login_id'];
        $log['action_made'] = "Account updated";
			$save = $this->conn->query("UPDATE users set ".$data." where id = ".$id);
			$this->save_log($log);
			
		}
		if($save){
			return 1;
		}
		return 1;
	}
	

	function save_settings(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", email = '$email' ";
		$data .= ", contact = '$contact' ";
		$data .= ", about_content = '".htmlentities(str_replace("'","&#x2019;",$about))."' ";
		if($_FILES['img']['tmp_name'] != ''){
						$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
						$move = move_uploaded_file($_FILES['img']['tmp_name'],'../assets/img/'. $fname);
					$data .= ", cover_img = '$fname' ";

		}
		
		// echo "INSERT INTO system_settings set ".$data;
		$chk = $this->conn->query("SELECT * FROM system_settings");
		if($chk->num_rows > 0){
			$save = $this->conn->query("UPDATE system_settings set ".$data." where id =".$chk->fetch_array()['id']);
		}else{
			$save = $this->conn->query("INSERT INTO system_settings set ".$data);
		}
		if($save){
		$query = $this->conn->query("SELECT * FROM system_settings limit 1")->fetch_array();
		foreach ($query as $key => $value) {
			if(!is_numeric($key))
				$_SESSION['setting_'.$key] = $value;
				$log['user_id'] = $_SESSION['login_id'];
        		$log['action_made'] = "Customer updated.";

			$this->save_log($log);
		}

			return 1;
				}
	}

	
	function save_category(){
		extract($_POST);
		$data = " name = '$name' ";
		if(empty($id)){
			$log['user_id'] = $_SESSION['login_id'];
        	$log['action_made'] = "Category created.";

			$this->save_log($log);
			$save = $this->conn->query("INSERT INTO category_list set ".$data);
			
		}else{
			$log['user_id'] = $_SESSION['login_id'];
        	$log['action_made'] = "Category updated";

			$this->save_log($log);
			$save = $this->conn->query("UPDATE category_list set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	function delete_category(){
		extract($_POST);
		$delete = $this->conn->query("DELETE FROM category_list where id = ".$id);
		if($delete)
			$log['user_id'] = $_SESSION['login_id'];
        	$log['action_made'] = "Category deleted";

			$this->save_log($log);
			return 1;
	}
	function save_supplier(){
		extract($_POST);
		$data = " supplier_name = '$name' ";
		$data .= ", contact = '$contact' ";
		$data .= ", address = '$address' ";
		if(empty($id)){
			$save = $this->conn->query("INSERT INTO supplier_list set ".$data);
			$log['user_id'] = $_SESSION['login_id'];
        	$log['action_made'] = "Supplier added";

			$this->save_log($log);
		}else{
			$save = $this->conn->query("UPDATE supplier_list set ".$data." where id=".$id);
			$log['user_id'] = $_SESSION['login_id'];
        	$log['action_made'] = "Supplier updated";

			$this->save_log($log);
		}
		if($save)
			return 1;
	}
	function delete_supplier(){
		extract($_POST);
		$delete = $this->conn->query("DELETE FROM supplier_list where id = ".$id);
		if($delete)
		$log['user_id'] = $_SESSION['login_id'];
        	$log['action_made'] = "Supplier delleted";

			$this->save_log($log);
			return 1;
	}
	function save_product(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", sku = '$sku' ";
		$data .= ", category_id = '$category_id' ";
		$data .= ", supplier_id = '$supplier_id' ";
		$data .= ", description = '$description' ";
		$data .= ", price = '$price' ";
		$data .= ", status = '$status' ";
		$data .= ", critlvl = '$critlvl' ";

		if(empty($id)){
			$log['user_id'] = $_SESSION['login_id'];
        	$log['action_made'] = "Product added";

			$this->save_log($log);
			$save = $this->conn->query("INSERT INTO product_list set ".$data);
		}else{
			$log['user_id'] = $_SESSION['login_id'];
        	$log['action_made'] = "Product updated";

			$this->save_log($log);
			$save = $this->conn->query("UPDATE product_list set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}

	function delete_product(){
		extract($_POST);
		$delete = $this->conn->query("DELETE FROM product_list where id = ".$id);
		if($delete)
		$log['user_id'] = $_SESSION['login_id'];
        	$log['action_made'] = "Product deleted";

			$this->save_log($log);
			return 1;
	}
	function delete_user(){
		extract($_POST);
		$delete = $this->conn->query("DELETE FROM users where id = ".$id);
		if($delete)
		$log['user_id'] = $_SESSION['login_id'];
        	$log['action_made'] = "User deleted";

			$this->save_log($log);
			return 1;
	}

	function save_receiving(){
		extract($_POST);
		$data = " supplier_id = '$supplier_id' ";
		$data .= ", total_amount = '$tamount' ";
		
		if(empty($id)){
			$ref_no = sprintf("%'.08d\n", $ref_no);
			$i = 1;

			while($i == 1){
				$chk = $this->conn->query("SELECT * FROM receiving_list where ref_no ='$ref_no'")->num_rows;
				if($chk > 0){
					$ref_no = mt_rand(1,99999999);
					$ref_no = sprintf("%'.08d\n", $ref_no);
				}else{
					$i=0;
				}
			}
			$data .= ", ref_no = '$ref_no' ";
			$save = $this->conn->query("INSERT INTO receiving_list set ".$data);
			$id =$this->conn->insert_id;
			foreach($product_id as $k => $v){
				$data = " form_id = '$id' ";
				$data .= ", product_id = '$product_id[$k]' ";
				$data .= ", qty = '$qty[$k]' ";
				$data .= ", type = '1' ";
				$data .= ", stock_from = 'receiving' ";
				$details = json_encode(array('price'=>$price[$k],'qty'=>$qty[$k]));
				$data .= ", other_details = '$details' ";
				$data .= ", remarks = 'Stock from Receiving-".$ref_no."' ";

				$save2[]= $this->conn->query("INSERT INTO inventory set ".$data);
			}
			if(isset($save2)){
				return 1;
			}
		}else{
			$save = $this->conn->query("UPDATE receiving_list set ".$data." where id =".$id);
			$ids = implode(",",$inv_id);
			$this->conn->query("DELETE FROM inventory where type = 1 and form_id ='$id' and id NOT IN (".$ids.") ");
			foreach($product_id as $k => $v){
				$data = " form_id = '$id' ";
				$data .= ", product_id = '$product_id[$k]' ";
				$data .= ", qty = '$qty[$k]' ";
				$data .= ", type = '1' ";
				$data .= ", stock_from = 'receiving' ";
				$details = json_encode(array('price'=>$price[$k],'qty'=>$qty[$k]));
				$data .= ", other_details = '$details' ";
				$data .= ", remarks = 'Stock from Receiving-".$ref_no."' ";
				if(!empty($inv_id[$k])){
									$save2[]= $this->conn->query("UPDATE inventory set ".$data." where id=".$inv_id[$k]);
				}else{
					$save2[]= $this->conn->query("INSERT INTO inventory set ".$data);
				}
			}
			if(isset($save2)){
				
				return 1;
			}

		}
	}

	function delete_receiving(){
		extract($_POST);
		$del1 = $this->conn->query("DELETE FROM receiving_list where id = $id ");
		$del2 = $this->conn->query("DELETE FROM inventory where type = 1 and form_id = $id ");
		if($del1 && $del2)
			return 1;
	}
	function save_customer(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", contact = '$contact' ";
		$data .= ",email = '$email' ";
		$data .= ", purchase = '$purchase' ";
		$data .= ", address = '$address' ";	

		echo '<script type ="text/JavaScript">';  
		echo 'alert("JavaScript Alert Box by PHP")';  
		echo '</script>';  

		if(empty($id)){
			$log['user_id'] = $_SESSION['login_id'];
        	$log['action_made'] = "Customer added.";

			$this->save_log($log);
			$save = $this->conn->query("INSERT INTO customer_list set ".$data);
		}else{
			
			$log['user_id'] = $_SESSION['login_id'];
        	$log['action_made'] = "Customer updated.";

			$this->save_log($log);
			$save = $this->conn->query("UPDATE customer_list set ".$data." where id=".$id);
		}
		if($save){
			return 1;
		}
	}
	function delete_customer(){
		extract($_POST);
		$delete = $this->conn->query("DELETE FROM customer_list where id = ".$id);
		if($delete)
				
			$log['user_id'] = $_SESSION['login_id'];
        	$log['action_made'] = "Customer deleted.";

			$this->save_log($log);
			return 1;
	}

	function chk_prod_availability(){
		extract($_POST);
		$price = $this->conn->query("SELECT * FROM product_list where id = ".$id)->fetch_assoc()['price'];
		$inn = $this->conn->query("SELECT sum(qty) as inn FROM inventory where type = 1 and product_id = ".$id);
		$inn = $inn && $inn->num_rows > 0 ? $inn->fetch_array()['inn'] : 0;
		$out = $this->conn->query("SELECT sum(qty) as `out` FROM inventory where type = 2 and product_id = ".$id);
		$out = $out && $out->num_rows > 0 ? $out->fetch_array()['out'] : 0;
		$available = $inn - $out;
		return json_encode(array('available'=>$available,'price'=>$price));

	}
	function save_sales(){
		extract($_POST);
		$data = " customer_id = '$customer_id' ";
		$data .= ", total_amount = '$tamount' ";
		$data .= ", amount_tendered = '$amount_tendered' ";
		$data .= ", amount_change = '$change' ";
		
		if(empty($id)){
			$ref_no = sprintf("%'.08d\n", $ref_no);
			$i = 1;

			while($i == 1){
				$chk = $this->conn->query("SELECT * FROM sales_list where ref_no ='$ref_no'")->num_rows;
				if($chk > 0){
					$ref_no = mt_rand(1,99999999);
					$ref_no = sprintf("%'.08d\n", $ref_no);
				}else{
					$i=0;
				}
			}
			$data .= ", ref_no = '$ref_no' ";
			$save = $this->conn->query("INSERT INTO sales_list set ".$data);
			$id =$this->conn->insert_id;
			foreach($product_id as $k => $v){
				$data = " form_id = '$id' ";
				$data .= ", product_id = '$product_id[$k]' ";
				$data .= ", qty = '$qty[$k]' ";
				$data .= ", type = '2' ";
				$data .= ", stock_from = 'Sales' ";
				$details = json_encode(array('price'=>$price[$k],'qty'=>$qty[$k]));
				$data .= ", other_details = '$details' ";
				$data .= ", remarks = 'Stock out from Sales-".$ref_no."' ";

				$save2[]= $this->conn->query("INSERT INTO inventory set ".$data);
				$log['user_id'] = $_SESSION['login_id'];
        		$log['action_made'] = "Sales added";

			$this->save_log($log);
			}
			if(isset($save2)){
				return $id;
			}
		}else{
			$save = $this->conn->query("UPDATE sales_list set ".$data." where id=".$id);
			$ids = implode(",",$inv_id);
			$this->conn->query("DELETE FROM inventory where type = 1 and form_id ='$id' and id NOT IN (".$ids.") ");
			foreach($product_id as $k => $v){
				$data = " form_id = '$id' ";
				$data .= ", product_id = '$product_id[$k]' ";
				$data .= ", qty = '$qty[$k]' ";
				$data .= ", type = '2' ";
				$data .= ", stock_from = 'Sales' ";
				$details = json_encode(array('price'=>$price[$k],'qty'=>$qty[$k]));
				$data .= ", other_details = '$details' ";
				$data .= ", remarks = 'Stock out from Sales-".$ref_no."' ";

				if(!empty($inv_id[$k])){
					$save2[]= $this->conn->query("UPDATE inventory set ".$data." where id=".$inv_id[$k]);
				}else{
					$save2[]= $this->conn->query("INSERT INTO inventory set ".$data);
				}if(isset($save2)){
				return $id;
			}
			}
			
		}
	}
	function delete_sales(){
		extract($_POST);
		$del1 = $this->conn->query("DELETE FROM sales_list where id = $id ");
		$del2 = $this->db->query("DELETE FROM inventory where type = 2 and form_id = $id ");
		if($del1 && $del2)
			return 1;
	}

	/*function loadproducts(){
	extract($_POST);
	$product = $this->conn->query("SELECT * FROM product_list  order by name asc");
		
		$query 	= mysqli_query($conn,$product);
		foreach ($query as $key => $value) {
				echo "<tr class='js-add' sku=".$value['sku']." name=".$value['name']." price=".$value['price']." description=".$value['description']."><td>".$value['id']."</td><td>".$value['name']."</td>";
				echo "<td>₱".$value['price']."</td>";
				echo "<td>".$value['description']."</td>";
				echo "<td>".$value['quantity']."</td>";
				echo "<td>".$value['sku']."</td>";
				return 1;
			
		}
	
	
	}*/

	function save_transaction_sales(){
		extract($_POST);
		//$customer = $_POST['customer'];
		$itemsData = $_POST['itemsOut'];
		$customer = $_POST['customer'];
		$getcustomerId = $this->conn->query("SELECT cL.id FROM customer_list cL WHERE cL.name ='$customer'");
		$getRow = $getcustomerId->fetch_assoc();
		$customerId = $getRow["id"];
		//--------------------
		// return json_encode(array('customer'=>$customer));
		//$customerId = $customer($_GET['id']);
		//------------------
		$userId = $_SESSION['login_id'];
		date_default_timezone_set('Asia/Manila');
		$timeNow = date('Y-m-d H:i:s');
		$this->conn->query("INSERT INTO sales_transaction (customer_id, date_transact) VALUES($customerId, '$timeNow')");
		(int)$transactid =$this->conn->insert_id;
		foreach ($itemsData as $id => $row)  { 
			//$customer = $row['customer'];
			//$customerId = $customer($_GET['id']);
			$itemName = $row['itemName'];
			$quantity = (int)$row['quantity'];
			$price = (double)$row['price'];
			$getItemId = $this->conn->query("SELECT pL.id FROM product_list pL WHERE pL.name='$itemName'");

			$getRow = $getItemId->fetch_assoc();
			$itemId = $getRow["id"];

			$this->conn->query("INSERT INTO sales_list (transact_id, item_id, quantity, price) VALUES($transactid, $itemId, $quantity, $price)");
				
		}	
		
		return (int)$transactid;
			
	}

	function get_items_by_supplier_id(){
		if(isset($_POST['selectedSupplierId'])){
			$supplierId = (int)$_POST['selectedSupplierId'];
			
			$itemList = $this->conn->query("SELECT * FROM product_list pL where pL.supplier_id=".$supplierId);

			while($row=$itemList->fetch_assoc()):
				echo "<option value=".$row['id']." data-name='".$row['name']."' data-description='".$row['description']."'>".$row['name'] . " | " . $row['sku']."</option>";
			endwhile;
		}else{
			return 0;
		}
	}

	function add_purchase_order(){
		if(isset($_POST['purchaseItems'])){
			$purchaseItems = $_POST['purchaseItems'];
			$supplierId = $_POST['supplierId'];

			//Getting time now with default timezone to manila
			date_default_timezone_set('Asia/Manila');
			$timeNow = date('Y-m-d H:i:s');

			$this->conn->query("INSERT INTO purchase_order_transaction (supplier_id, order_date) VALUES($supplierId, '$timeNow')");
			(int)$purchase_order_id =$this->conn->insert_id;

			foreach ($purchaseItems as $id => $row)  { 
				$itemId = (int)$row['itemId'];
				$itemRequestQuantity = (int)$row['itemRequestQuantity'];
				$itemPrice = (double)$row['itemPrice'];

				$this->conn->query("INSERT INTO purchase_order_list (purchase_order_id, item_id, quantity, price) VALUES($purchase_order_id, $itemId, $itemRequestQuantity, $itemPrice)");
			}	
			return $purchase_order_id;

		}
		
	}

	function receive_purchase_order(){
		if(isset($_POST['purchaseItems'])){
			$purchaseItems = $_POST['purchaseItems'];
			$poID = $_POST['poID'];

			//Getting time now with default timezone to manila
			date_default_timezone_set('Asia/Manila');
			$timeNow = date('Y-m-d H:i:s');

			$this->conn->query("INSERT INTO receive_transaction (purchase_order_id, receive_date) VALUES($poID, '$timeNow')");
			(int)$receive_id =$this->conn->insert_id;

			foreach ($purchaseItems as $id => $row)  { 
				$itemId = (int)$row['itemId'];
				$itemReceivedQuantity = (int)$row['received_qty'];

				$this->conn->query("INSERT INTO receive_list (receive_id, item_id, quantity) VALUES($receive_id, $itemId, $itemReceivedQuantity)");
			}	

			$getStatusOrder = $this->conn->query("SELECT pOT.purchase_order_id, pOL.total_requested,(SELECT SUM(quantity) FROM receive_list WHERE receive_id IN (SELECT receive_id FROM receive_transaction WHERE purchase_order_id=pOT.purchase_order_id)) as total_received FROM purchase_order_transaction pOT LEFT JOIN (SELECT SUM(quantity) as total_requested, purchase_order_id FROM purchase_order_list GROUP BY purchase_order_id) pOL ON pOL.purchase_order_id = pOT.purchase_order_id WHERE pOT.purchase_order_id = $poID");
			$getStatusRow = $getStatusOrder->fetch_assoc();

			if($getStatusRow["total_requested"] == $getStatusRow["total_received"]) {
				#0 = In-Progress
				#1 = Cancelled
				#2 = Incomplete
				#3 = Complete
				$this->conn->query("UPDATE purchase_order_transaction SET status=3 WHERE purchase_order_id=$poID");
			}

			return $receive_id;

		}
	}

}



$a = isset($_GET['a']) ?$_GET['a'] : '';
$action = new Actions();
switch($a){
    case 'login':
        echo $action->login();
    break;
    case 'logout':
        echo $action->logout();
    break;
	case 'save_category':
        echo $action->save_category();
    break;
	case 'delete_category':
        echo $action->delete_category();
    break;
	case 'save_product':
        echo $action->save_product();
    break;
	case 'delete_product':
        echo $action->delete_product();
    break;
	case 'save_user':
        echo $action->save_user();
    break;
	case 'save_customer':
        echo $action->save_customer();
    break;
	case 'delete_customer':
        echo $action->delete_customer();
    break;
	case 'chk_prod_availability':
        echo $action->chk_prod_availability();
    break;
	case 'save_sales':
        echo $action->save_sales();
    break;
	case 'save_supplier':
        echo $action->save_supplier();
    break;
	case 'delete_supplier':
        echo $action->delete_supplier();
    break;
	case 'save_transaction_sales':
        echo $action->save_transaction_sales();
    break;
	case 'save_receiving':
        echo $action->save_receiving();
    break;
	case 'get_items_by_supplier_id':
        echo $action->get_items_by_supplier_id();
    break;
	case 'add_purchase_order':
        echo $action->add_purchase_order();
    break;
	case 'receive_purchase_order':
        echo $action->receive_purchase_order();
    break;
	/*case 'loadproducts':
        echo $action->loadproducts();
    break;*/
	
    case 'save_log':
        $log['user_id'] = $_SESSION['id'];
        $log['action_made'] = $_POST['action_made'];
        echo $action->save_log($log);
    break;

	
    default:
    // default action here
    echo "No Action given";
    break;
}
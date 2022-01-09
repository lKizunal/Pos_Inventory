<?php
	include('db_connect.php');
	if (!empty($_POST['product_list'])){
		$name = mysqli_real_escape_string($conn,$_POST['product_list']);
		$product = $conn->query("SELECT pL.id, pL.category_id, pL.sku, pL.price, pL.name, pL.description, pL.supplier_id, pL.status, CASE WHEN (CASE WHEN (SELECT SUM(quantity) FROM receive_list rL WHERE rL.item_id = pL.id) > 0 THEN (SELECT SUM(quantity) FROM receive_list rL WHERE rL.item_id = pL.id) ELSE 0 END)- (CASE WHEN (SELECT SUM(quantity) FROM sales_list sL WHERE sL.item_id = pL.id) > 0 THEN (SELECT SUM(quantity) FROM sales_list sL WHERE sL.item_id = pL.id) ELSE 0 END) THEN (CASE WHEN (SELECT SUM(quantity) FROM receive_list rL WHERE rL.item_id = pL.id) > 0 THEN (SELECT SUM(quantity) FROM receive_list rL WHERE rL.item_id = pL.id) ELSE 0 END)- (CASE WHEN (SELECT SUM(quantity) FROM sales_list sL WHERE sL.item_id = pL.id) > 0 THEN (SELECT SUM(quantity) FROM sales_list sL WHERE sL.item_id = pL.id) ELSE 0 END) ELSE 0 END AS stock_available FROM product_list pL WHERE pL.name LIKE '$name%' OR pL.sku LIKE '$name%' GROUP BY pL.id;");
		if(mysqli_num_rows($product)>0){
			while($row = mysqli_fetch_array($product)){
				$description = !empty($row['description']) ? $row['description'] : " ";
				echo "<tr class='js-add' sku=".$row['sku']." name='".$row['name']."' price=".$row['price']." description='".$description."' stock_available=".$row['stock_available'].">
				<td>".$row['sku']."</td><td>".$row['name']."</td>";
				echo "<td>₱".$row['price']."</td>";
				echo "<td>".$description."</td>";
				echo "<td>".$row['stock_available']."</td>";
			}
		}
		else{
			echo "<td></td><td>No Products found!</td><td></td>";
		}
	}?>
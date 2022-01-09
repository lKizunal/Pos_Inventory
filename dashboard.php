<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<title>POS</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.js"></script>
	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>

	<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
		integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous">
	</script>
	<script type="text/javascript"
		src="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js">
	</script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
		integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

	<link rel="stylesheet"
		href="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" />
	<script type="text/javascript">
		$('#dt1').datetimepicker({
			locale: 'en-GB'
		});
	</script>
	<style>
		.alert {
			flex: 1 1 0px;
			border: 1px solid black;
		}
	</style>
</head>

<?php include('db_connect.php');
	#mysql queries
		#sales
		$getSales = $conn->query("SELECT SUM(sL.quantity*sL.price) as total_sales FROM sales_transaction sT LEFT JOIN(SELECT quantity, price, transact_id FROM sales_list)sL ON sL.transact_id = sT.transact_id WHERE CAST(date_transact AS DATE) = CAST(LOCALTIME() AS DATE) GROUP BY CAST(date_transact AS DATE)");
		$getSalesRow = $getSales->fetch_assoc();
		
		#total items available
		$getItemsAvailable = $conn->query("SELECT SUM(quantity) as total_quantity FROM receive_list");
		$getItemsAvailableRow = $getItemsAvailable->fetch_assoc();

		#number of customers
		$getNumberOfCustomers = $conn->query("SELECT COUNT(*) as number_of_customers FROM customer_list");
		$getNumberOfCustomersRow = $getNumberOfCustomers->fetch_assoc();

		#best seller
		$getBestSeller = $conn->query("SELECT item_id, SUM(price*quantity) as sales,(SELECT name FROM product_list WHERE id = item_id) as item_name FROM sales_list WHERE transact_id IN ( SELECT transact_id FROM sales_transaction WHERE CAST(date_transact AS DATE) = CAST(LOCALTIME() AS DATE)) GROUP BY item_id ORDER BY sales DESC LIMIT 1");
		$getBestSellerRow = $getBestSeller->fetch_assoc();

		#recent Purchase Orders
		$getRecentPurchaseOrders = $conn->query("SELECT purchase_order_id,(SELECT supplier_name FROM supplier_list WHERE id = supplier_id) as supplier_name, order_date FROM purchase_order_transaction WHERE status=0 ORDER BY purchase_order_id DESC LIMIT 5");

	$sales = $getSalesRow["total_sales"];
	$itemsAvailable = $getItemsAvailableRow["total_quantity"];
	$noCustomers = $getNumberOfCustomersRow["number_of_customers"];
	$bestSellerItemName = $getBestSellerRow["item_name"];
?>
<body>
	<div class="container-fluid ">
		<div class="card" style="padding:20px;">
			<div class="card-header">
				<?php echo "Welcome back ".$_SESSION['login_name']."!"  ?>

			</div>
			<hr>
			<div>
				<div class="form-group">
					<div class='input-group date' id='dt1'>
						<input type='text' class="form-control" />
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</span>
					</div>
				</div>
				<br>
				<div class="row">

					<div class="card"
						style="background-color:#5bccf6;padding:15px; box-shadow:3px 3px grey; margin-left:15px;">
						<div class="card-header" style="background-color:#7cd6f8">
							<p style="font-size:18px;color:#fcfdfe"><b><large>Total Sales</large></b></p>
						</div>
						<hr>
						<div class="row"
							style="width: 300px; margin-top:15px;justify-content:space-between; padding-left:10px;padding-right:20px ">
							<div>
								<img src="./assets/img/sales.png" alt="sales">
							</div>
							<div style="margin-top:35px;">
								<p style="font-size:25px; color:#fefefe"><?php echo $sales?></p>
							</div>
						</div>
					</div>



					<div class="card"
						style="background-color:#f39c11; padding:15px; box-shadow:3px 3px grey;margin-left:15px;">
						<div class="card-header" style="background-color:#f8c470">
							<p style="font-size:18px;color:#fcfdfe"><b>
									<large>Total Items Available</large>
								</b></p>
						</div>
						<hr>
						<div class="row"
							style="width:300px; margin-top:15px;justify-content:space-between; padding-left:10px;padding-right:20px">
							<div>
								<img src="./assets/img/items.png" alt="sales">
							</div>
							<div style="margin-top:35px;">
								<p style="font-size:25px; color:#fefefe"><?php echo $itemsAvailable?></p>
							</div>

						</div>
					</div>
					<div class="card"
						style="background-color:#ff5757; padding:15px; box-shadow:3px 3px grey;margin-left:15px;">
						<div class="card-header" style="background-color:#ff7979">
							<p style="font-size:18px;color:#fcfdfe"><b>
									<large>No. of Customers</large>
								</b></p>

						</div>
						<hr>
						<div class="row"
							style="width:300px; margin-top:15px;justify-content:space-between; padding-left:10px;padding-right:20px ">
							<div>
								<img src="./assets/img/customer.png" alt="sales">
							</div>
							<div style="margin-top:35px;">
								<p style="font-size:25px; color:#fefefe"><?php echo $noCustomers?></p>
							</div>

						</div>
					</div>
					<div class="card"
						style="background-color:#9cd159; padding:15px; box-shadow:3px 3px grey;margin-left:15px;">
						<div class="card-header" style="background-color:#b0da7a">
							<p style="font-size:18px;color:#fcfdfe"><b>
									<large>Today's best seller</large>
								</b></p>
						</div>
						<hr>
						<div class="row"
							style="width:300px; margin-top:15px;justify-content:space-between; padding-left:10px;padding-right:20px">
							<div>
								<img src="./assets/img/seller.png" alt="sales">
							</div>
							<div style="margin-top:35px;">
								<p style="font-size:20px; color:#fefefe"><?php echo $bestSellerItemName?></p>
							</div>

						</div>
					</div>

				</div>
				<div class="card" style="float:right;margin-top:20px">
					<div class="card-body">
						<table class="table">
							<thead>
								<th class="text-center">Purchase Order#</th>
								<th class="text-center">Supplier Name</th>
								<th class="text-center">Purchase date</th>
								<th class="text-center">Action</th>
							</thead>
							<tbody>

							<?php 
								while($row=$getRecentPurchaseOrders->fetch_assoc()):
							?>
								<tr>
									<td><?php echo str_pad($row["purchase_order_id"], 6, 0, STR_PAD_LEFT)?></td>
									<td><?php echo $row["supplier_name"]?></td>
									<td><?php echo $row["order_date"]?></td>
									<td class="text-center">
										<a href='index.php?page=purchaseorder_details&poID=<?php echo $row['purchase_order_id'] ?>'>View</a>
									</td>
								</tr>
							<?php endwhile;?>
							</tbody>

						</table>
					</div>
				</div>
			</div>
			<!-- 
					<div class="card" style="background-color:#5bccf6; width:300px;height:250px;padding:15px; box-shadow:3px 3px grey; margin-left:15px;" >
						<div class="card-header" style="background-color:#7cd6f8">
							<p style="font-size:18px;color:#fcfdfe"><b><large>Total Items Available</large></b></p>
						</div>
						<hr>
							<div class="row" style="width: 300px; margin-top:15px;justify-content:space-around; ">
								<div>
									<img src="./assets/img/sales.png" alt="sales" style="opacity:0.8">
								</div>
								<div style="text-align:center; padding:10px; margin-top:35px;">
									<p style="font-size:25px; color:#fefefe"><b><large>100,000
										 <?php 
											include 'db_connect.php';
											$sales = $conn->query("SELECT SUM(total_amount) as amount FROM sales_list where date(date_updated)= '".date('Y-m-d')."'");
											echo $sales->num_rows > 0 ? number_format($sales->fetch_array()['amount'],2) : "0.00";

											?>
											</large></b>
									</p>
								</div>
							</div>
					</div> -->







			<!-- <div class="alert alert-cus col-md-2 ml-2" style="background-color:#dad4ed;">
					<p><b><large>No. of Customers</large></b></p>
				<hr>
					<p class="text-right"><b><large>200</large></b></p>
				</div>
				<div class="alert alert-bestsel col-md-2 ml-2" style="background-color:#eddad4;">
					<p><b><large>Best seller Today</large></b></p>
				<hr>
					<p class="text-right"><b><large>iPhone 12 pro max </large></b></p>
				</div>

				<div class="alert alert-avail col-md-2 ml-2" style="background-color:#f5f5f5;">
					<p><b><large>Purchase Orders</large></b></p>
				<hr>
				<a href="index.php?page=receiveorder">
					<p class="text-right"><b><large>Purchase #123456</large></b></p>
				</a>
				</div>
				</div> -->


		</div>

	</div>
</body>

</html>
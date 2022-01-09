<?php 
	include 'db_connect.php';
	
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<title>POS</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" type="text/css" href="bootstrap4/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="bootstrap4/css/style.css">
	<link rel="stylesheet" href="bootstrap4/css/all.min.css" />
	<link rel="stylesheet" href="bootstrap4/css/typeahead.css" />
	<script src="bootstrap4/jquery/sweetalert.min.js"></script>
	<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
	<link href="https://fonts.googleapis.com/css2?family=Lobster&family=Quattrocento&display=swap" rel="stylesheet">


	<style>
		/* tr:hover{
		background-color: brown;
		color:red;
		
	} */
	</style>

</head>

<body>

	<div class="container-fluid">
		<div class="col">

			<div class="card" style="width:1400px; height:650px; padding-bottom:20px;">
				<div class="card-header">
					<div class="row">
						<div style="padding-left:15px">
							<div style="font-size:15px; padding-bottom:5px; padding-left:5px">
								<a href="javascript:history.go(-1)"><i class='bx bx-arrow-back'></i> Back</a>
							</div>

							<div id="#">
								<!--<img src="./assets/img/logos.png"/>-->
								<h3 style="font-family: 'Lobster', cursive;font-size:50px">Hi-tech Store</h3>
								<h3 style="font-family: 'Quattrocento', serif;font-size:20px">Sales and Inventory System
								</h3>
							</div>
						</div>
						<div style="padding-left:80px; padding-right:100px; ">
							<table class="table-responsive">
								<tbody>
									<tr style="background-color:#f7f7f7;">
										<td><small>User Logged on:</small></td>
										<td><small>
												<p class="pt-3 ml-5"><i class="fas fa-user-shield"></i>
													<?php echo $_SESSION['login_name']?></p>
											</small></td>
									</tr>
									<tr style="background-color:#f7f7f7;">
										<td><small class="pb-1">Date:</small></td>
										<td><small>
												<p class="p-1 ml-5" style="color:black"><i
														class="fas fa-calendar-alt"></i><span
														id='currentDateTime'></span></p>
											</small></td>
									</tr>
									<tr style="background-color:#f7f7f7;">
										<td><small class="mt-5 mr-1">Customer Name: </small></td>



										<td><small>
												<div><input type="text" class="form-control-sm customer_search"
														data-provide="typeahead" id="customer_search"
														placeholder="Customer Search" name="customer"
														autocomplete="off" /></div>
											</small>
										</td>

										<!--<td valign="baseline" style=font-size:10px;height:50px;width:65px;><button>Add Customer +</button></td>-->
										<td><button class="btn-sm btn-info border ml-2" data-toggle="modal"
												data-target=".bd-example-modal-md"
												style="padding-top: 1px; padding-bottom: 2px;"><span
													class="badge badge-info"><i class="fas fa-user-plus"></i>
													New</span></button></td>
									</tr>
								</tbody>

							</table>
						</div>
						<div class="header_price border p-0">
							<h5 style="padding:15px">Grand Total</h5>
							<p class="pb-0 mr-2" style="float: right; font-size: 40px;padding-right:10px"
								id="totalValue">₱ 0.00</p>
						</div>
					</div>


				</div>
				<div class="row">
					<div id="content" style="width:900px;padding-left:20px;padding-top:5px">
						<div id="price_column"
							class="m-2 table-responsive-sm table-wrapper-scroll-y my-custom-scrollbar-a">
							<form method="POST" action="">
								<table class="table-striped w-100 font-weight-bold" style="cursor: pointer;" id="table2"
									name="table2">
									<thead>
										<tr class='text-center'>
											<th>SKU</th>
											<th>Description</th>
											<th>Price</th>
											<th>Qty</th>
											<th>Sub Total</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody id="tableData">

									</tbody>
								</table>
							</form>
						</div>
						<div id="table_buttons" style="padding-top:10px">
							<button id="buttons" type="button" name='enter' class="Enter btn btn-secondary border ml-2"
								style="background-color:#57e46a"><i class="fas fa-handshake"></i> Finish</button>
							<div class="">
								<small>
									<ul class="text-black justify-content-center">
										<li class="d-flex mb-0">Total (₱): <p id="totalValue1" class="mb-0 ml-5 pl-3">
												0.00</p>
										</li>
										<li class="mb-0 mt-0">Discount (₱): <input style="width: 100px"
												class="text-right form-control-sm" type="number" name="discount"
												value="0" min="0" placeholder="Enter Discount" id="discount"></li>
									</ul>
								</small>
							</div>
						</div>
					</div>
					<div id="sidebar" style="width:510px;padding-right:10px;padding-top:5px">
						<div class="m-2 ">
							<div class="input-group">
								<div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i
											class="fas fa-search"></i></span></div>

								<input class="form-control" type="text" placeholder="Product Search" aria-label="Search"
									id="search" name="search" onkeyup="loadproducts();" />
							</div>
						</div>
						<div id="product_area"
							class="table-responsive-sm mt-2 table-wrapper-scroll-y my-custom-scrollbar">
							<table class="w-100 table-striped font-weight-bold" style="cursor:pointer;" id="table1"
								name="table1">
								<thead>
									<tr class='text-center'><b>
											<td>SKU</td>
											<td>Product Name</td>
											<td>Price</td>
											<td>Desc</td>
											<td>Stocks</td>

									</tr></b>
								</thead>
								<tbody id="product_list" name="product_list">
								</tbody>

							</table>
						</div>
						<div class="w-100 mt-2" id="enter_area" style="padding-top:16px;">
							<button id="buttons" type="button" class="cancel btn btn-secondary border"
								style="background-color:#E45757"><i class="fas fa-ban"></i> Cancel</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- <div id="header">
			
			<div id="header_image">
				<img class="w-50 " src="./assets/img/storelogo.png" style="size:200px;"/>
			</div>

			<div >
				<table class="table-responsive-sm">
					<tbody>
						<tr>
							<td valign="baseline"><small>User Logged on:</small></td>
							<td valign="baseline"><small><p class="pt-3 ml-5"><i class="fas fa-user-shield"></i> <?php echo $_SESSION['login_name']?></p></small></td>
						</tr>
						<tr>
							<td valign="baseline"><small class="pb-1">Date:</small></td>
							<td valign="baseline"><small><p class="p-1 ml-5" style="color:black"><i class="fas fa-calendar-alt"></i><span id='currentDateTime'></span></p></small></td>
						</tr>
						<tr>
							<td valign="baseline"><small class="mt-5 mr-1">Customer Name:   </small></td>				

						
							</td>
							<td valign="baseline"><small><div class="content p-0 ml-5"><input type="text" class="form-control form-control-sm customer_search" data-provide="typeahead" id="customer_search" placeholder="Customer Search" name="customer" autocomplete="off"/></div></small>
</td><!--need to do position-->
		<!--<td valign="baseline" style=font-size:10px;height:50px;width:65px;><button>Add Customer +</button></td>-->
		<!-- <td valign="baseline"><button class="btn-sm btn-info border ml-2" data-toggle="modal" data-target=".bd-example-modal-md" style="padding-top: 1px; padding-bottom: 2px;"><span class="badge badge-info"><i class="fas fa-user-plus"></i> New</span></button></td> 
						</tr>
					</tbody>
				
				</table>
			
			</div>
			<div class="header_price border p-0">
				<h5>Grand Total</h5>
				<p class="pb-0 mr-2" style="float: right; font-size: 40px;" id="totalValue">₱ 0.00</p>
			</div>
		</div>
		<div id="content" class="mr-2">
			<div id="price_column" class="m-2 table-responsive-sm table-wrapper-scroll-y my-custom-scrollbar-a">
				<form method="POST" action="">
				<table class="table-striped w-100 font-weight-bold" style="cursor: pointer;" id="table2" name="table2">
					<thead>
						<tr class='text-center'>
							<th>SKU</th>
							<th>Description</th>
							<th>Price</th>
							<th>Qty</th>
							<th>Sub Total</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody id="tableData">
					   		
					</tbody>
				</table>
				</form>
			</div>
			<div id="table_buttons">
				<button id="buttons" type="button" name='enter' class="Enter btn btn-secondary border ml-2"><i class="fas fa-handshake"></i> Finish</button>
				<div class="">
				<small>
					<ul class="text-white justify-content-center">
						<li class="d-flex mb-0">Total (₱): <p id="totalValue1" class="mb-0 ml-5 pl-3">0.00</p></li>
						<li class="mb-0 mt-0">Discount (₱): <input style="width: 100px" class="text-right form-control-sm" type="number" name="discount" value="0" min="0" placeholder="Enter Discount" id="discount" ></li>
					</ul>
				</small>
				</div>
			</div>
		</div>
		<div id="sidebar">
		<div class="mt-1 ">
			<div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span></div>
			
			<input 
				class="form-control" 
				type="text" 
				placeholder="Product Search" 
				aria-label="Search" id="search" name="search" onkeyup="loadproducts();"/>
								</div></div>
			<div id="product_area" class="table-responsive-sm mt-2 table-wrapper-scroll-y my-custom-scrollbar" >
				<table class="w-100 table-striped font-weight-bold" style="cursor:pointer;" id="table1" name="table1">
					<thead>
						<tr class='text-center'><b>
							<td>SKU</td>
							<td>Product Name</td>
							<td>Price</td>
							<td>Unit</td>
							<td>Stocks</td>
							
						</tr></b>
					</thead>
						<tbody id="product_list" name="product_list">
						</tbody>
					
				</table>
			</div>
			<div class="w-100 mt-2" id="enter_area">
				<button id="buttons" type="button" class="cancel btn btn-secondary border"><i class="fas fa-ban"></i> Cancel</button>
			</div>
		</div> 
		<!--<div id="footer" class="w-100">
			<button id="buttons" onclick="window.location.href='user/user.php'" class="btn btn-secondary border mr-2 ml-2"><i class="fas fa-users"></i> User</button>
			<button id="buttons" onclick="window.location.href='products/products.php'" class="btn btn-secondary border mr-2"><i class="fas fa-box-open"></i> Product</button>
			<button id="buttons" onclick="window.location.href='supplier/supplier.php'" class="btn btn-secondary border mr-2"><i class="fas fa-user-tie"></i> Supplier</button>
			<button id="buttons" onclick="window.location.href='customer/customer.php'" class="btn btn-secondary border mr-2"><i class="fas fa-user-friends"></i> Customer</button>
			<button id="buttons" onclick="window.location.href='logs/logs.php'" class="btn btn-secondary border mr-2"><i class="fas fa-globe"></i> Logs</button>
			<button id="buttons" onclick="window.location.href='cashflow/cashflow.php'" class="btn btn-secondary border mr-2"><i class="fas fa-money-bill-wave"></i> Cash-Flow</button>
			<button id="buttons" onclick="window.location.href='sales/sales.php'" class="btn btn-secondary border mr-2"><i class="fas fa-shopping-cart"></i> Sales</button>
			<button id="buttons" onclick="window.location.href='delivery/delivery.php'" class="btn btn-secondary border mr-2"><i class="fas fa-truck"></i> Deliveries</button>
	
		</div>-->
	</div>


	<?php include('add.php');?>
	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="bootstrap4/js/time.js"></script>
	<script src="bootstrap4/js/typeahead.js"></script>
	<script type="text/javascript" src="script.js"></script>

	<script>
		var today = new Date();
		var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
		var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
		var dateTime = date + ' ' + time;
		document.getElementById('currentDateTime').innerHTML = dateTime;
	</script>
</body>

</html>
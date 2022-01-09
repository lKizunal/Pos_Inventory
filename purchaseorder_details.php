<?php include 'db_connect.php' ?>

<?php
	if(isset($_GET["poID"])){
		$poID = $_GET["poID"];
	}else{
		$poID = 0;
	}

	$purchaseOrderDetail = $conn->query("SELECT pOT.purchase_order_id,(SELECT supplier_name FROM supplier_list WHERE id=pOT.supplier_id) AS supplier_name, pOT.order_date, pOT.status FROM purchase_order_transaction pOT WHERE pOT.purchase_order_id = $poID");
	while($row=$purchaseOrderDetail->fetch_assoc()):
		$orderSupplierName = $row['supplier_name'];
		$orderOrderDate = $row['order_date'];
		$orderStatus = $row['status'];
	break;
	endwhile;
	
	
?>
<div class="container-fluid">
	<div class="col-lg-15">
		<div class="row">
			<div class="col-md-7">
				<div class="card">
					<div class="card-header">
					<div style="font-size:20px; padding-bottom:5px">
                         <a href="javascript:history.go(-1)"><i class='bx bx-arrow-back'></i> Back</a>
                     </div>
						<div class="col">
							<div>
								<h4><b>Purchase order #<?php echo str_pad($poID, 6, 0, STR_PAD_LEFT)?> </b></h4>
								<div class="row">
									<h6>Status: <?php echo $orderStatus?></h6>

									<b style="margin-left:10px; margin-right:10px"> | </b>

									<h6>Supplier Name: <?php echo $orderSupplierName?></h6>

									<b style="margin-left:10px; margin-right:10px"> | </b>

									<h6>Order Date: <?php echo $orderOrderDate?></h6>
								</div>
							</div>
						</div>
						<div>
							<button class="btn btn-primary float-left btn-sm" style="padding-top: 1px; padding-bottom: 2px; color:blue">
							<i class="fa fa-plus"></i> <a href='index.php?page=receiving_order_details&poID=<?php echo $poID ?>'> Receive Order </a> </button>
						</div>
						<div class="row float-right btn-sm-4" style="padding-right: 20px;">
							<a id="print-os" href="./print/print_purchaseorder.php">
								<p id="print-btn">Print </p>
							</a>
							<b style="margin-left:10px; margin-right:10px"> | </b>
							<a href="#">
								<p id="print-btn">Cancel</p>
							</a>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">

							<div class="card-body">
								<table class="table table-bordered">
									<thead>

										<th class="text-center">Item Name</th>
										<th class="text-center">Requested</th>
										<th class="text-center">Received</th>
										<th class="text-center">Status</th>
										<th class="text-center">Amount</th>

									</thead>
									<tbody>
										<?php 
											$purchaseItems = $conn->query("SELECT(SELECT name FROM product_list WHERE id = pOL.item_id) as item_name, quantity as requested_qty, CASE WHEN (SELECT SUM(quantity) FROM receive_list WHERE receive_id IN (SELECT receive_id FROM receive_transaction rT WHERE rT.purchase_order_id = pOL.purchase_order_id) AND item_id = pOL.item_id) >= 0 THEN (SELECT SUM(quantity) FROM receive_list WHERE receive_id IN (SELECT receive_id FROM receive_transaction rT WHERE rT.purchase_order_id = pOL.purchase_order_id) AND item_id = pOL.item_id) ELSE 0 END as received_qty, pOL.price*pOL.quantity as total_amount FROM purchase_order_list pOL WHERE purchase_order_id = $poID");
											while($row=$purchaseItems->fetch_assoc()):
										?>
										<tr>
											<td class=""> <?php echo $row['item_name'] ?> </td>
											<td class=""> <?php echo $row['requested_qty'] ?> </td>
											<td class=""> <?php echo $row['received_qty'] ?> </td>
											<td class=""> <?php if($row['requested_qty'] > $row['received_qty']){ echo 'Incomplete'; } else{ echo 'Complete';}?> </td>
											<td class=""> <?php echo $row['total_amount'] ?> </td>
										</tr>
									<?php endwhile; ?>

									</tbody>
								</table>

							</div>

						</div>
					</div>
				</div>
			</div>
			<div class="col-md-5">
				<h5><b>Receive order History</b></h5>

				<div class="card">
					<div class="card-body">
						<table class="table">
							<thead>
								<th class="text-center">Received No.</th>
								<th class="text-center">Received date</th>
								<th class="text-center">Action</th>
							</thead>
							<tbody>
							<?php 
								$orderHistory = $conn->query("SELECT receive_id, receive_date FROM receive_transaction WHERE purchase_order_id = $poID");
								while($row=$orderHistory->fetch_assoc()):
							?>
								<tr>
									<td> <?php echo str_pad($row['receive_id'], 6, 0, STR_PAD_LEFT)?> </td>
									<td> <?php echo $row['receive_date'] ?> </td>
									<td><a href='index.php?page=receive_history_details&roID=<?php echo $row['receive_id'] ?>'>view</a></td>
								</tr>
							<?php endwhile; ?>	

							</tbody>
					
						</table>
					</div>
				</div>
			</div>

		</div>
	</div>



	<?php include('add.php');?>
	<script>
		//$('table').dataTable()
		// $('#new_receiving').click(function () {
		// 	location.href = "index.php?page=receiveorder"
		// })
		// $('.delete_receiving').click(function () {
		// 	_conf("Are you sure to delete this data?", "delete_receiving", [$(this).attr('data-id')])
		// })
		/*function delete_receiving($id){
			start_load()
			$.ajax({
				url:'ajax.php?action=delete_receiving',
				method:'POST',
				data:{id:$id},
				success:function(resp){
					if(resp==1){
						alert_toast("Data successfully deleted",'success')
						setTimeout(function(){
							location.reload()
						},1500)

					}
				}
			})
		}*/
		/*$('#print-os').click(function(){
		uni_modal("Print",'print_purchaseorder.php')
		})*/
	</script>

</div>
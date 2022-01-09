<?php include 'db_connect.php' ?>
<?php
	if(isset($_GET["poID"])){
		$poID = $_GET["poID"];
	}else{
		$poID = 0;
	}
?>
<script src="bootstrap4/jquery/sweetalert.min.js"></script>

<div class="container-fluid" style="width:1250px">
	<div class="col-lg-15" style="align-self:center; justify-content:center;">
		<div class="row">

			<div class="card" style="width: 1250px; ">

				<div class="card-header" style="padding:20px">
					<div style="font-size:20px; padding-bottom:5px">
						<a href="javascript:history.go(-1)"><i class='bx bx-arrow-back'></i> Back</a>
					</div>
					<div>
						<h4><b>Purchase order #<?php echo str_pad($poID, 6, 0, STR_PAD_LEFT)?> </b></h4>
					</div>
					<div>
						<button class="btn btn-primary float-left btn-sm" onclick="receiveAll()">
							<i class="fa fa-plus"></i> Receive All</button>
					</div>


					<div class="row float-right btn-sm-4" style="padding-right: 20px;">
						<button class="btn btn-primary float-left btn-sm" onclick="confirmReceive()">Confirm
							Receive</button>
					</div>

				</div>
				<div class="row">
					<div class="col-md-12">

						<div class="card-body">
							<table class="table table-bordered" id="tableReceiveList">
								<thead>
									<th class="text-center">Item Name</th>
									<th class="text-center">Requested Quantity</th>
									<th class="text-center">Received Quantity</th>
								</thead>
								<tbody>

									<?php 
									$purchaseItems = $conn->query("SELECT pOL.item_id,(SELECT name FROM product_list WHERE id = pOL.item_id) AS item_name, pOL.quantity - CASE WHEN (SELECT COUNT(*) FROM receive_list WHERE item_id = pOL.item_id AND receive_id IN (SELECT receive_id FROM receive_transaction WHERE purchase_order_id=pOL.purchase_order_id)) > 0 THEN (SELECT SUM(quantity) FROM receive_list WHERE item_id = pOL.item_id AND receive_id IN (SELECT receive_id FROM receive_transaction WHERE purchase_order_id=pOL.purchase_order_id)) ELSE 0 END AS requested_qty FROM purchase_order_list pOL WHERE pOL.purchase_order_id = $poID AND pOL.quantity - (CASE WHEN (SELECT COUNT(*) FROM receive_list WHERE item_id = pOL.item_id AND receive_id IN (SELECT receive_id FROM receive_transaction WHERE purchase_order_id=pOL.purchase_order_id)) > 0 THEN (SELECT SUM(quantity) FROM receive_list WHERE item_id = pOL.item_id AND receive_id IN (SELECT receive_id FROM receive_transaction WHERE purchase_order_id=pOL.purchase_order_id)) ELSE 0 END) > 0");
									while($row=$purchaseItems->fetch_assoc()):
								?>
									<tr data-id=<?php echo $row['item_id'] ?>>
										<td class=""> <?php echo $row['item_name'] ?> </td>
										<td class=""> <?php echo $row['requested_qty'] ?> </td>
										<td class="">
											<div contenteditable>0</div>
										</td>

									</tr>
									<?php endwhile; ?>

								</tbody>
							</table>

						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
	<!--<button type="button" class="btn btn-primary float-right btn-sm" data-dismiss="modal" style="padding:8px; margin:8px;">Close</button>-->

</div>
<script>
	function receiveAll() {
		$('#tableReceiveList tbody tr').each(function () {
			var itemId = $(this).data('id');

			var cellNo = 0;
			var requested_qty = 0;
			$(this).find('td').each(function () {
				if (cellNo == 1) {
					requested_qty = $(this).text();
				}
				if (cellNo == 2) {
					$(this).find('div').html(requested_qty);
				}
				cellNo++;
			});
		});
	}

	function confirmReceive() {
		var purchaseItems = [];
		$('#tableReceiveList tbody tr').each(function () {
			var itemId = $(this).data('id');

			var cellNo = 0;
			var requested_qty = $(this).find(".requested_qty");
			var received_qty = 0;
			$(this).find('td').each(function () {
				if (cellNo == 1) {
					requested_qty = $(this).text();
				}
				if (cellNo == 2) {
					received_qty = $(this).find('div').text().trim();
					if (parseInt(received_qty) > parseInt(requested_qty)) {
						swal("Error",
							"Receive quantinty is higher than the requested quantity! Please enter valid quantity!",
							"error");
					}

				}
				cellNo++;
			});
			purchaseItems.push({
				'itemId': itemId,
				'received_qty': parseInt(received_qty),

			});
		});

		var hasReceive = false;
		for (let i = 0; i < purchaseItems.length; i++) {
			if (purchaseItems[i].received_qty > 0) {
				hasReceive = true;
				break;
			}
		}

		if (hasReceive) {
			$.ajax({
				url: './admin_class.php?a=receive_purchase_order',
				type: "POST",
				data: {
					"purchaseItems": purchaseItems,
					"poID": <?php echo $poID ?>
				},
				success: function (resp) {
					swal({title: "Success", text:"Received order successfully!", type:"success"}).then(function(){
						location.href = 'index.php?page=purchaseorder_list';
					});
				}
			});
		}else{
			alert("Have atleast one receive item");
		}
	}
</script>
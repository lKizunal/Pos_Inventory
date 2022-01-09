<?php include 'db_connect.php' ?>
<?php
	if(isset($_GET["roID"])){
		$roID = $_GET["roID"];
	}else{
		$roID = 0;
	}
?>
<div class="container-fluid" style="width:1250px">
	<div class="col-lg-15" style="align-self:center; justify-content:center;">
		<div class="row">

			<div class="card" style="width: 1250px; ">

				<div class="card-header" style="padding:20px">
					<div style="font-size:20px; padding-bottom:5px">
						<a href="javascript:history.go(-1)"><i class='bx bx-arrow-back'></i> Back</a>
					</div>
					<div>
						<h4><b>Receive order #<?php echo str_pad($roID, 6, 0, STR_PAD_LEFT)?> </b></h4>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="card-body">
								<table class="table table-bordered" id="tableReceiveList">
									<thead>
										<th class="text-center">Item Name</th>
										<th class="text-center">Received Quantity</th>
									</thead>
									<tbody>
									<?php 
										$orderHistory = $conn->query("SELECT item_id,(SELECT name FROM product_list WHERE id = item_id) as item_name, quantity as received_qty FROM receive_list WHERE receive_id = $roID");
										while($row=$orderHistory->fetch_assoc()):
									?>
										<tr data-id=<?php echo $row['item_id'] ?> >
											<td class=""><?php echo $row['item_name'] ?> </td>
											<td class=""><?php echo $row['received_qty'] ?> </td>
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
</div>
<?php include 'db_connect.php' ?>
<div class="container-fluid">

	<div class="col-lg-15">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
					<div style="font-size:20px; padding-bottom:5px;">
							<a href="javascript:history.go(-1)"><i class='bx bx-arrow-back'></i> Back</a>
						</div>
						<h4><b>Inventory Report</b></h4>
						<div class="row float-right btn-sm-4" style="padding-right: 20px;">
						
						<a href="./print/print_inventory.php">
							<p id="print-btn">Print</p>
						</a>
						</div>
					</div>
					
					<div class="card-body">
						<table class="table table-bordered">
							<thead>
								<th class="text-center">#</th>
								<th class="text-center">Product Name</th>
								<th class="text-center">Stock In</th>
								<th class="text-center">Stock Out</th>
								<th class="text-center">Stock Available</th>
								<th class="text-center">Status</th>
							</thead>
							<tbody>
							<?php 
								$getInventoryReport = $conn->query("SELECT pL.id as item_id, pL.name as item_name, CASE WHEN(SELECT SUM(quantity) FROM receive_list WHERE item_id = id) > 0 THEN (SELECT SUM(quantity) FROM receive_list WHERE item_id = id) ELSE 0 END AS stock_in, CASE WHEN (SELECT SUM(quantity) FROM sales_list WHERE item_id = id) > 0 THEN (SELECT SUM(quantity) FROM sales_list WHERE item_id = id) ELSE 0 END AS stock_out, CASE WHEN (CASE WHEN (SELECT SUM(quantity) FROM receive_list WHERE item_id = id) > 0 THEN (SELECT SUM(quantity) FROM receive_list WHERE item_id = id) ELSE 0 END) - (CASE WHEN (SELECT SUM(quantity) FROM sales_list WHERE item_id = id) > 0 THEN (SELECT SUM(quantity) FROM sales_list WHERE item_id = id) ELSE 0 END) > 0 THEN (CASE WHEN (SELECT SUM(quantity) FROM receive_list WHERE item_id = id) > 0 THEN (SELECT SUM(quantity) FROM receive_list WHERE item_id = id) ELSE 0 END) - (CASE WHEN (SELECT SUM(quantity) FROM sales_list WHERE item_id = id) > 0 THEN (SELECT SUM(quantity) FROM sales_list WHERE item_id = id) ELSE 0 END) ELSE 0 END AS stock_available FROM product_list pL GROUP BY pL.id");
								while($row=$getInventoryReport->fetch_assoc()):
									$status = $row['stock_in'] - $row['stock_out'];
									if($status > 0){
										$statusName = "Available";
									}else{
										$statusName = "Unavailable";
									}
							?>
								<tr>
									<td class="text-center"><?php echo $row['item_id'] ?></td>
									<td class=""><?php echo $row['item_name'] ?></td>
									<td class="text-right"><?php echo $row['stock_in'] ?></td>
									<td class="text-right"><?php echo $row['stock_out'] ?></td>
									<td class="text-right"><?php echo $row['stock_available'] ?></td>
									<td class="text-right"><?php echo $statusName ?></td></td>
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


<script>
		

	$('table').dataTable()
	$('#new_receiving').click(function(){
		location.href = "index.php?page=ordering_items"
	})
	$('.delete_receiving').click(function(){
		_conf("Are you sure to delete this data?","delete_receiving",[$(this).attr('data-id')])
	})
	function delete_receiving($id){
		start_load()
		$.ajax({
			url:'./admin_class.php?a=delete_receiving',
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
	}
</script>
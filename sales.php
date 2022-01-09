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
						<h4><b>Sales Report</b></h4>
					
						<div class="row float-right btn-sm-4" style="padding-right: 20px;">
							<a href="./print/print_sale.php">
								<p id="print-btn">Print</p>
							</a>
						</div>
					</div>
					<div class="card-body">
						<table class="table table-bordered">
							<thead>
								<th class="text-center" style="display:none;">#</th>
								<th class="text-center">Reference #</th>
								<th class="text-center">Date</th>
								<th class="text-center">Customer</th>
								<th class="text-center">Action</th>
								
							</thead>
							<tbody>
							<?php 
								

								$customer = $conn->query("SELECT * FROM customer_list order by name asc");
								while($row=$customer->fetch_assoc()):
									$cus_arr[$row['id']] = $row['name'];
								endwhile;
									$cus_arr[0] = "GUEST";

								$i = 1;
								$sales = $conn->query("SELECT * FROM sales_list "); // order by date(date_updated) desc (walang date_updated sa sales_list)
								while($rows=$sales->fetch_assoc()):

								$transact = $conn->query("SELECT * FROM sales_transaction ORDER BY date_transact DESC"); 
								while($row=$transact->fetch_assoc()):

								
							?>
								<tr>
									<td class="text-center" style="display:none;"><?php echo $i++ ?></td>
									<td class=""><?php echo $row['transact_id'] ?></td>
									<td class=""><?php echo date("M d, Y",strtotime($row['date_transact'])) ?></td>
									
									<td class=""><?php echo isset($cus_arr[$row['customer_id']])? $cus_arr[$row['customer_id']] :'N/A' ?></td>
									<td class="text-center">
									<a class="btn btn-sm btn-danger view_order" href="javascript:void(0)" data-id="<?php echo $rows['sales_id'] ?>">View</a>
									<!--<button type="button" class="view_order" data-toggle="modal" data-target=".view_order_details" data-id="<?php //echo $row['id'] ?>" style="padding-top: 1px; padding-bottom: 2px; color:blue">View</button>
										<a class="btn btn-sm btn-danger delete_sales" href="javascript:void(0)" data-id="<?php //echo $row['id'] ?>">Delete</a>-->
									</td>
								</tr>
								<?php endwhile; ?>
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
	$('#new_sales').click(function(){
		location.href = "index.php?page=pos"
	})
	/*$('.delete_sales').click(function(){
		_conf("Are you sure to delete this data?","delete_sales",[$(this).attr('data-id')])
	})
	function delete_sales($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_sales',
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
	$('.view_order').click(function(){
		alert($(this).attr('data-id'));
	//uni_modal('Order Details','view_order_details.php?id='+$(this).attr('data-id'))
})
</script>
<?php include('add.php');?>
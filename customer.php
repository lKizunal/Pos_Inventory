<div class="container-fluid">
<div class="col-lg-15">	
	<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
					<div style="font-size:20px; padding-bottom:5px;">
							<a href="javascript:history.go(-1)"><i class='bx bx-arrow-back'></i> Back</a>
						</div>
						<div class="col">
							<div>
								<h4><b>Customers</b></h4>
							<br>
							</div>				
						<div>
						<button class="btn btn-primary float-left btn-sm" id="new_customer"><i class="fa fa-plus"></i> New Customer</button>		
						</div>
						</div>

						<!-- <div class="row float-right btn-sm-4" style="padding-right: 20px;">
							<a href="./print/print_customer.php">
								<p id="print-btn">Print</p>
							</a>
						</div> -->
					</div>
						<div class="row">
						<div class="col-md-12">
							<div class="card-body">
								<table class="table table-bordered">
									<thead>
			
										<th class="text-center">#</th>
										<th class="text-center">Customer</th>
										<th class="text-center">Contact</th>
										<th class="text-center">Email</th>
										
										<th class="text-center">Address</th>
										<th class="text-center">Action</th>
									</thead>
									<tbody>
										<?php
											include 'db_connect.php';
											
											$customer = $conn->query("SELECT * FROM customer_list");
											$i = 1;
											while($row= $customer->fetch_assoc()):
										?>
										<tr>
											<td>
												<?php echo $i++ ?>
											</td>
											<td>
												<?php echo $row['name'] ?>
											</td>
											<td>
												<?php echo $row['contact'] ?>
											</td>
											<td>
												<?php echo $row['email'] ?>
											</td>
										
											<td>
												<?php echo $row['address'] ?>
											</td>
											<td>
												<center>
														<div class="btn-group">
														<a class="edit_customer" href="javascript:void(0)" data-id = '<?php echo $row['id'] ?>'>Edit</a>
														<!--<button type="button" class="btn btn-primary">Action</button>
														<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															<span class="sr-only">Toggle Dropdown</span>
														</button>

														
														<div class="dropdown-menu">
															
															<div class="dropdown-divider"></div>
															<a class="dropdown-item delete_customer" href="javascript:void(0)" data-id = '<?php echo $row['id'] ?>'>Delete</a>
														</div>-->
														</div>
														</center>
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
</div>
</div>
<script>
$('table').dataTable()
$('#new_customer').click(function(){
	uni_modal('New Customer','manage_customer.php')
})
$('.edit_customer').click(function(){
	uni_modal('Edit Customer','manage_customer.php?id='+$(this).attr('data-id'))
})
$('.delete_customer').click(function(){
		_conf("Are you sure to delete this customer?","delete_customer",[$(this).attr('data-id')])
	})
	function delete_customer($id){
		start_load()
		$.ajax({
			url:'./admin_class.php?a=delete_customer',
			method:'POST',
			data:{id:$id},
			success:function(resp){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)
				
			}
		})
	}
</script>
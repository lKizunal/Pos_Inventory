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
								<h4><b>Users</b></h4>
								<br>
							</div>				
							<div class="row">
								<button class="btn btn-primary float-left btn-sm" id="new_user"><i class="fa fa-plus"></i> New user</button>

								<button class="btn btn-primary btn-sm" id="archive" style="margin-left:20px;"><i class="fa fa-user-times"></i> Archived</button>		
				
							</div>
						</div>

						<div class="row float-right btn-sm-4" style="padding-right: 20px;padding-left:20px">
							<a href="./print/print_users.php">
								<p id="print-btn">Print </p>
							</a>
							<b style="margin-left:10px; margin-right:10px"> | </b>
							<a href="archived_users.php">
								<p id="archive print-btn ">Archive </p>
							</a>

					</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="card-body">
								<table class="table table-bordered">
								
								<thead>
									<th class="text-center">ID</th>
									<th class="text-center">Name</th>
									<th class="text-center">Cel/Tel No.</th>
									<th class="text-center">Email</th>
									<th class="text-center">Username</th>
									<th class="text-center">Action</th>
								</thead>

								<tbody>
									<?php
										include 'db_connect.php';
										
										$users = $conn->query("SELECT * FROM users ");
										$i = 1;
										while($row= $users->fetch_assoc()):
									?>
									<tr>
										<td>
											<?php echo $i++ ?>
										</td>
										<td>
											<?php echo $row['name'] ?>
										</td>
										<td>
											<?php echo $row['celnum'] ?>
										</td>
										<td>
											<?php echo $row['email'] ?>
										</td>
										<td>
											<?php echo $row['username'] ?>
										</td>
										<td>
											<center>
													<div class="btn-group">
													<a class="edit_user" href="javascript:void(0)" data-id = '<?php echo $row['id'] ?>'>Edit</a>
													<!--<button type="button" class="btn btn-primary">Action</button>
													<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														<span class="sr-only">Toggle Dropdown</span>
													</button>
													<div class="dropdown-menu">
														
														<div class="dropdown-divider"></div>
														<a class="dropdown-item delete_user" href="javascript:void(0)" data-id = '<?php echo $row['id'] ?>'>Delete</a>
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

$('#new_user').click(function(){
	uni_modal('New User','manage_user.php')
})
$('.edit_user').click(function(){
	uni_modal('Edit User','manage_user.php?id='+$(this).attr('data-id'))
})
$('#archive').click(function(){
		location.href = "index.php?page=archived_users"
	})
/*$('.delete_user').click(function(){
		_conf("Are you sure to delete this user?","delete_user",[$(this).attr('data-id')])
	})
	function delete_user($id){
		start_load()
		$.ajax({
			url:'/admin_class.php?a=delete_user',
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
</script>
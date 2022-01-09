<style>
	input[name="image"] {
		width: 100px;
	}

	input[id="validationCustom02"] {
		margin-bottom: -20px
	}

	table {
		border-collapse: collapse;
	}

	.wborder {
		border: 1px solid gray;
	}

	.bbottom {
		border-bottom: 1px solid black
	}

	td p,
	th p {
		margin: unset
	}

	.text-center {
		text-align: center
	}

	.text-right {
		text-align: right
	}

	.clear {
		padding: 10px
	}

	#uni_modal .modal-footer {
		display: none;
	}
</style>

<!-- Modal for Adding data -->
<div class="modal fade bd-example-modal-md" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
	aria-hidden="true" data-backdrop="false" data-keyboard="false">
	<div class="modal-dialog modal-fluid" role="document">
		<div class="modal-content" style="width:70%; margin-left: 20%;">
			<div class="modal-header bg-secondary">
				<h4 class="modal-title text-light" id="exampleModalCenterTitle"><strong>Add New Customer</strong></h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<div class="container-fluid">
					<form method="post" id="modal-form" action="" enctype="multipart/form-data" class="needs-validation"
						autocomplete="off">
						<div>
							<div align="center">
								<input type="hidden" name="size" class="form-control-sm" value="1000000">
								<input type="hidden" name="user" class="form-control-sm"
									value="<?php echo $_GET['username'];?>">

							</div>
							<small>
								<div class="input-group mb-2">
									<div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i
												class="fas fa-pen-alt"></i></span></div>
									<input class="form-control form-control-sm" type="text" id="txtFullName" name="name"
										placeholder="Enter Full name" required>
								</div>
								<div class="input-group mb-2">
									<div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i
												class="fas fa-pen-alt"></i></span></div>
									<input class="form-control form-control-sm" type="text" id="txtContact"
										name="contact" placeholder="Enter Contact Number" required>
								</div>
								<div class="input-group mb-2">
									<div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i
												class="fas fa-phone"></i></span></div>
									<input class="form-control form-control-sm" type="text" id="txtEmail" name="email"
										placeholder="Enter Email Address">
								</div>
								<div class="input-group">
									<div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i
												class="fas fa-map-marker-alt"></i></span></div>
									<textarea type="text" class="form-control form-control-sm" id="txtAddress"
										name="address" placeholder="Enter Address" required></textarea>
								</div>

							</small>

						</div>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-danger" data-dismiss="modal"><i class="fas fa-ban"></i>
					Cancel</button>
				<button type="submit" name="submit" class="btn btn-secondary" form="modal-form">Submit</button>
			</div>
		</div>
	</div>
</div>


<div class="modal fade receiveorder" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"
	data-backdrop="false" data-keyboard="false">
	<div class="modal-dialog " role="dialog">
		<div class="modal-content">
			<div class="container-fluid">
				<div class="col-lg-15">
					<div class="row">

						<div class="card">
							<div class="card-header">
								<div class="col">
									<div>
										<h4><b>Receiving order #123456 </b></h4>

									</div>
									<div>
										<button class="btn btn-primary float-left btn-sm" id="new_receiving"><i
												class="fa fa-plus"></i> Receive All</button>
									</div>
								</div>

								<div class="row float-right btn-sm-4" style="padding-right: 20px;">
									<button class="btn btn-primary float-left btn-sm" id="confirm">Confirm
										Receive</button>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">

									<div class="card-body">
										<table class="table table-bordered">
											<thead>
												<th class="text-center">Item Name</th>
												<th class="text-center">Brand</th>
												<th class="text-center">Requested Quantity</th>
												<th class="text-center">Received Quantity</th>


											</thead>
											<tbody>

												<tr>
													<td class="">Oppo R17 Pro</td>
													<td class="">Oppo</td>
													<td class="">5x</td>
													<td class="">
														<div contenteditable>0x</div>
													</td>

												</tr>
												<tr>
													<td class="">iPhone 12 Pro Max</td>
													<td class="">Apple</td>
													<td class="">3x</td>
													<td class="">
														<div contenteditable>0x</div>
													</td>

												</tr>

											</tbody>
										</table>

									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
				<button type="button" class="btn btn-primary float-right btn-sm" data-dismiss="modal"
					style="padding:8px; margin:8px;">Close</button>

			</div>
		</div>
	</div>
</div>
<script>
	$('table').dataTable()
	$('#confirm').click(function () {
		location.href = "index.php?page=purchaseorder_list"
	})


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
</script>
<script>
	$('#modal-form').submit(function (e) {
		e.preventDefault();
		start_load()

		var nameVal = document.getElementById("txtFullName").value;
		var contactVal = document.getElementById("txtContact").value;
		var emailVal = document.getElementById("txtEmail").value;
		var addressVal = document.getElementById("txtAddress").value;

		$.ajax({
			url: './admin_class.php?a=save_customer',
			method: 'POST',
			dataType: 'json',
			data: {
				'name': nameVal,
				'contact': contactVal,
				'email': emailVal,
				'address': addressVal
			},
			success: function (output) {
				end_load()
				// location.reload()
			},
			error: function () {
				end_load()
				// location.reload()
			}
			// success:function(resp){
			// 	if(resp==0){
			// 		alert('Save!');
			// 		alert_toast("Data successfully saved",'success')
			// 		setTimeout(function(){
			// 			location.reload()
			// 		},1500)
			// 	}
			// 	if(resp==1){
			// 		alert('UNKNOWN');
			// 		alert_toast("Data successfully saved",'success')
			// 		setTimeout(function(){
			// 			location.reload()
			// 		},1500)
			// 	}
			// }
		})

		// success:function(resp){
		// 		if(resp==1){
		// 			alert_toast("Data successfully added",'success')
		// 			setTimeout(function(){
		// 				location.reload()
		// 			},1500)

		// 		}
		// 		else if(resp==2){
		// 			alert_toast("Data successfully updated",'success')
		// 			setTimeout(function(){
		// 				location.reload()
		// 			},1500)

		// 		}
		// 	}

	})
</script>
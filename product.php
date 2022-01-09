<?php include('db_connect.php');
	$sku = mt_rand(1,99999999);
	$sku = sprintf("%'.08d\n", $sku);
	$i = 1;
	while($i == 1){
		$chk = $conn->query("SELECT * FROM product_list where sku ='$sku'")->num_rows;
		if($chk > 0){
			$sku = mt_rand(1,99999999);
			$sku = sprintf("%'.08d\n", $sku);
		}else{
			$i=0;
		}
	}
?>

<div class="container-fluid">
	<div class="row" style="justify-content:space-between">
	<div style="font-size:20px; padding-bottom:5px; padding-left:5px">
		<a href="javascript:history.go(-1)"><i class='bx bx-arrow-back'></i> Back</a>
	</div>
		<div class="float-right" style="padding-right:20px;font-size:20px">
			<a href="./print/print_inventory.php">
				<p id="print-btn">Print</p>
			</a>
		</div>
	</div>
	</div>
	<div class="col-lg-12">
		<div class="row">

			<!-- FORM Panel -->
			<div class="col-md-4">
				<form action="" id="manage-product" autocomplete="off">
					<div class="card">
						<div class="card-header">
							Product Form
						</div>
						<div class="card-body">
							<input type="hidden" name="id">
							<div class="form-group">
								<label class="control-label">SKU</label>
								<input type="text" class="form-control" name="sku" value="<?php echo $sku ?>">
							</div>

							<div class="form-group">
								<label class="control-label">Category</label>
								<select name="category_id" id="" class="custom-select browser-default">
									<?php 

								$cat = $conn->query("SELECT * FROM category_list order by name asc");
								while($row=$cat->fetch_assoc()):
									$cat_arr[$row['id']] = $row['name'];
								?>
									<option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
									<?php endwhile; ?>
								</select>
							</div>
							<div class="form-group">
								<label class="control-label">Supplier</label>
								<select name="supplier_id" onChange="selectedSupplierChange()" id="supplier"
									class="custom-select browser-default select2">
									<?php 
								$supplier = $conn->query("SELECT * FROM supplier_list order by supplier_name");
								while($row=$supplier->fetch_assoc()):
								?>
									<option value="<?php echo $row['id'] ?>"><?php echo $row['supplier_name'] ?>
									</option>


									<?php endwhile; ?>
								</select>
							</div>
							<div class="form-group">
								<label class="control-label">Product Name</label>
								<input type="text" class="form-control" name="name">
							</div>
							<div class="form-group">
								<label class="control-label">Description</label>
								<textarea class="form-control" cols="30" rows="3" name="description"></textarea>
							</div>
							<div class="form-group">
								<label class="control-label">Product Price</label>
								<input type="number" step="any" class="form-control text-right" name="price">
							</div>
							<div class="form-group">
								<label class="control-label">Critical Level</label>
								<input type="number" step="any" class="form-control text-right" name="critlvl">
							</div>
							<div class="form-group">
								<label class="control-label">Status</label>
								<select name="status" id="status" class="custom-select">
									<option value="Available">Available</option>
									<option value="Unavailable">Unavailable</option>
								</select>
							</div>
						</div>
						<div class="card-footer">
							<div class="row">
								<div class="col-md-12">
									<button class="btn btn-sm btn-primary col-sm-3 offset-md-3"> Save</button>
									<button class="btn btn-sm btn-default col-sm-3" type="button"
										onclick="$('#manage-product').get(0).reset()"> Cancel</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-8">
				<div class="card">
					<div class="card-body">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Product Info</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$prod = $conn->query("SELECT pL.id, pL.category_id, pL.sku, pL.price, pL.name, pL.description, pL.supplier_id, pL.status, pL.critlvl, CASE WHEN (CASE WHEN (SELECT SUM(quantity) FROM receive_list rL WHERE rL.item_id = pL.id) > 0 THEN (SELECT SUM(quantity) FROM receive_list rL WHERE rL.item_id = pL.id) ELSE 0 END)- (CASE WHEN (SELECT SUM(quantity) FROM sales_list sL WHERE sL.item_id = pL.id) > 0 THEN (SELECT SUM(quantity) FROM sales_list sL WHERE sL.item_id = pL.id) ELSE 0 END) THEN (CASE WHEN (SELECT SUM(quantity) FROM receive_list rL WHERE rL.item_id = pL.id) > 0 THEN (SELECT SUM(quantity) FROM receive_list rL WHERE rL.item_id = pL.id) ELSE 0 END)- (CASE WHEN (SELECT SUM(quantity) FROM sales_list sL WHERE sL.item_id = pL.id) > 0 THEN (SELECT SUM(quantity) FROM sales_list sL WHERE sL.item_id = pL.id) ELSE 0 END) ELSE 0 END AS stock_available FROM product_list pL GROUP BY pL.id;");
								while($row=$prod->fetch_assoc()):
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td class="">
										<p>SKU : <b><?php echo $row['sku'] ?></b></p>
										<p><small>Category : <b><?php echo $cat_arr[$row['category_id']] ?></b></small>
										</p>
										<p><small>Name : <b><?php echo $row['name'] ?></b></small></p>
										<p><small>Description : <b><?php echo $row['description'] ?></b></small></p>
										<p><small>Price : <b><?php echo number_format($row['price'],2) ?></b></small>
										</p>
										<p><small>Status : <b><?php echo $row['status'] ?></b></small></p>
										<p><small>Critical Lvl: <b><?php echo $row['critlvl'] ?></b></small></p>
										<p><small>Stock Available : <b><?php echo $row['stock_available'] ?></b></small>
										</p>
									</td>
									<td class="text-center">
										<a class="edit_product" href="javascript:void(0)"
											data-id="<?php echo $row['id'] ?>" data-name="<?php echo $row['name'] ?>"
											data-sku="<?php echo $row['sku'] ?>"
											data-category_id="<?php echo $row['category_id'] ?>"
											data-supplier_id="<?php echo $row['supplier_id'] ?>"
											data-description="<?php echo $row['description'] ?>"
											data-price="<?php echo $row['price'] ?>"
											data-status_id="<?php echo $row['status_id'] ?>"
											data-crit_lvl="<?php echo $row['critlvl'] ?>">Edit</a>
										<!--<button class="btn btn-sm btn-danger delete_product" type="button" data-id="<?php /*echo $row['id'] */?>">Delete</button>-->
									</td>
								</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- Table Panel -->
		</div>
	</div>

</div>
<style>
	td {
		vertical-align: middle !important;
	}

	td p {
		margin: unset;
	}
</style>
<script>
	$('table').dataTable()
	$('#manage-product').submit(function (e) {
		e.preventDefault()
		start_load()
		$.ajax({
			url: './admin_class.php?a=save_product',
			data: new FormData($(this)[0]),
			cache: false,
			contentType: false,
			processData: false,
			method: 'POST',
			type: 'POST',
			success: function (resp) {

				location.reload()

			}
		})
	})
	$('.edit_product').click(function () {
		start_load()
		var cat = $('#manage-product')
		cat.get(0).reset()
		cat.find("[name='id']").val($(this).attr('data-id'))
		cat.find("[name='name']").val($(this).attr('data-name'))
		cat.find("[name='sku']").val($(this).attr('data-sku'))
		cat.find("[name='category_id']").val($(this).attr('data-category_id'))
		cat.find("[name='supplier_id']").val($(this).attr('data-supplier_id'))
		cat.find("[name='description']").val($(this).attr('data-description'))
		cat.find("[name='price']").val($(this).attr('data-price'))
		cat.find("[name='critlvl']").val($(this).attr('data-crit_lvl'))
		cat.find("[name='status_id']").val($(this).attr('data-status_id'))
		end_load()
	})
	/*$('.delete_product').click(function(){
		_conf("Are you sure to delete this product?","delete_product",[$(this).attr('data-id')])
	})
	function delete_product($id){
		start_load()
		$.ajax({
			url:'./admin_class.php?a=delete_product',
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
<?php include 'db_connect.php';

if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM receiving_list where id=".$_GET['id'])->fetch_array();
	foreach($qry as $k => $val){
		$$k = $val;
	}
	$inv = $conn->query("SELECT * FROM inventory where type=1 and form_id=".$_GET['id']);

}

?>
<div class="container-fluid">
	<div class="col-lg-12">
		
		<div class="card">
			<div class="card-header">
			<div style="font-size:20px; padding-bottom:5px">
                         <a href="javascript:history.go(-1)"><i class='bx bx-arrow-back'></i> Back</a>
                     </div>
				<h4>Ordering Items</h4>
			</div>
			<div class="card-body">
				<form action="" id="manage-receiving">
					<input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
					<input type="hidden" name="ref_no" value="<?php echo isset($ref_no) ? $ref_no : '' ?>">
					<div class="col-md-12">
						<div class="row">
							<div class="form-group col-md-5">
								<label class="control-label">Supplier</label>
								<select name="supplier_id" onChange="selectedSupplierChange()" id="supplier" class="custom-select browser-default select2">
								<?php 
								$supplier = $conn->query("SELECT * FROM supplier_list order by supplier_name");
								while($row=$supplier->fetch_assoc()):
								?>
									<option value="<?php echo $row['id'] ?>"><?php echo $row['supplier_name'] ?></option>
										
								
									<?php endwhile; ?>
								</select>
							</div>
						</div>
						<hr>
						<div class="row mb-3">
								<div class="col-md-4">
									<label class="control-label">Product</label>
									<select name="" id="product" class="custom-select browser-default select2">
										
										<!-- Untitled Notepad -->
								
									</select>
								</div>
								<div class="col-md-2">
									<label class="control-label">Qty</label>
									<input type="number" class="form-control text-right" step="any" id="qty" >
								</div>
								<div class="col-md-3">
									<label class="control-label">Price</label>
									<input type="number" class="form-control text-right" step="any" id="price" >
								</div>
								<div class="col-md-3">
									<label class="control-label">&nbsp</label>
									<button class="btn btn-block btn-sm btn-primary" type="button" id="add_list"><i class="fa fa-plus"></i> Add to List</button>
								</div>


						</div>
						<div class="row">
							<table class="table table-bordered" id="list">
								<colgroup>
									<col width="30%">
									<col width="10%">
									<col width="25%">
									<col width="25%">
									<col width="10%">
								</colgroup>
								<thead>
									<tr>
										<th class="text-center">Product</th>
										<th class="text-center">Qty</th>
										<th class="text-center">Price</th>
										<th class="text-center">Amount</th>
										<th class="text-center"></th>
									</tr>
								</thead>
								<tbody>
									<?php 
									if(isset($id)):
									while($row = $inv->fetch_assoc()): 
										foreach(json_decode($row['other_details']) as $k=>$v){
											$row[$k] = $v;
										}
									?>
										<tr class="item-row">
											<td>
												<input type="hidden" name="inv_id[]" value="<?php echo $row['id'] ?>">
												<input type="hidden" name="product_id[]" value="<?php echo $row['product_id'] ?>">
												<p class="pname">Name: <b><?php echo $prod[$row['product_id']]['name'] ?></b></p>
												<p class="pdesc"><small><i>Description: <b><?php echo $prod[$row['product_id']]['description'] ?></b></i></small></p>
											</td>
											<td>
												<input type="number" min="1" step="any" name="qty[]" value="<?php echo $row['qty'] ?>" class="text-right">
											</td>
											<td>
												<input type="number" min="1" step="any" name="price[]" value="<?php echo $row['price'] ?>" class="text-right">
											</td>
											<td>
												<p class="amount text-right"></p>
											</td>
											<td class="text-center">
												<buttob class="btn btn-sm btn-danger" onclick = "rem_list($(this))"><i class="fa fa-trash"></i></buttob>
											</td>
										</tr>
									<?php endwhile; ?>
									<?php endif; ?>
								</tbody>
								<tfoot>
									<tr>
										<th class="text-right" colspan="3">Total</th>
										<th class="text-right tamount"></th>
										<th><input type="hidden" name="tamount" value=""></th>
									</tr>
								</tfoot>
							</table>
						</div>
						<div class="row">
							<button class="btn btn-primary btn-sm btn-block float-right .col-md-3">Save</button>
						</div>
					</div>
				</form>
			</div>
			
		</div>
	</div>
</div>
<div id="tr_clone">
	<table>
	<tr class="item-row">
		<td>
			<input type="hidden" name="inv_id[]" value="">
			<input type="hidden" name="product_id[]" value="">
			<p class="pname">Name: <b>product</b></p>
			<p class="pdesc"><small><i>Description: <b>Description</b></i></small></p>
		</td>
		<td>
			<input type="number" min="1" step="any" name="qty[]" value="" class="text-right">
		</td>
		<td>
			<input type="number" min="1" step="any" name="price[]" value="" class="text-right">
		</td>
		<td>
			<p class="amount text-right"></p>
		</td>
		<td class="text-center">
			<buttob class="btn btn-sm btn-danger" onclick = "rem_list($(this))"><i class="fa fa-trash"></i></button>
		</td>
	</tr>
	</table>
</div>
<style type="text/css">
	#tr_clone{
		display: none;
	}
	td{
		vertical-align: middle;
	}
	td p {
		margin: unset;
	}
	td input[type='number']{
		height: calc(100%);
		width: calc(100%);

	}
	input[type=number]::-webkit-inner-spin-button, 
	input[type=number]::-webkit-outer-spin-button { 
	  -webkit-appearance: none; 
	  margin: 0; 
	}
</style>
<script>
	$('.select2').select2({
	 	placeholder:"Please select heres",
	 	width:"100%"
	})

	var selectedSupplierId = 0;

	function selectedSupplierChange(){
		
		selectedSupplierId = document.getElementById("supplier").value;

		$.ajax({
				url: './admin_class.php?a=get_items_by_supplier_id',
				type: "POST",
				data: {
					'selectedSupplierId': selectedSupplierId,
				},
				success:function(resp){
					$('#product').empty();
					$('#product').append(resp);
				}
			});
	}

	$(document).ready(function(){
		if('<?php echo isset($id) ?>' == 1){
			$('[name="supplier_id"]').val('<?php echo isset($supplier_id) ? $supplier_id :'' ?>').select2({
				placeholder:"Please select here",
	 			width:"100%"
			})
			calculate_total()
		}
	})
	function rem_list(_this){
		_this.closest('tr').remove();
		calculate_total();
	}
	$('#add_list').click(function(){
		
		// return false;

		var tr = $('#tr_clone tr.item-row').clone();
		var product = $('#product').val(),
			qty = $('#qty').val(),
			price = $('#price').val();
			if($('#list').find('tr[data-id="'+product+'"]').length > 0){
				//alert("Product already on the list",'danger')
				swal("Error","Product already on the list!","error");
				return false;
			}
			if(product == '' || qty == '' || price ==''){
				//alert("Please complete the fields first",'danger')
				swal("Error","Please complete the fields first!","error");
				return false;
			} 
			
		tr.attr('data-id',product)
		tr.find('.pname  b').html($("#product option[value='"+product+"']").attr('data-name'))
		tr.find('.pdesc b').html($("#product option[value='"+product+"']").attr('data-description'))
		tr.find('[name="product_id[]"]').val(product)
		tr.find('[name="qty[]"]').val(qty)
		tr.find('[name="price[]"]').val(price)
		var amount = parseFloat(price) * parseFloat(qty);
		tr.find('.amount').html(parseFloat(amount).toLocaleString('en-US',{style:'decimal',maximumFractionDigits:2,minimumFractionDigits:2}))
		$('#list tbody').append(tr)
		calculate_total()
		$('[name="qty[]"],[name="price[]"]').keyup(function(){
			calculate_total()
		})
		 $('#product').val('').select2({
		 	placeholder:"Please select here",
	 		width:"100%"
		 })
			$('#qty').val('')
			$('#price').val('')
			alert("hi");
	})
	function calculate_total(){
		var total = 0;
		$('#list tbody').find('.item-row').each(function(){
			var _this = $(this).closest('tr')
		var amount = parseFloat(_this.find('[name="qty[]"]').val()) * parseFloat(_this.find('[name="price[]"]').val());
		amount = amount > 0 ? amount :0;
		_this.find('p.amount').html(parseFloat(amount).toLocaleString('en-US',{style:'decimal',maximumFractionDigits:2,minimumFractionDigits:2}))
		total+=parseFloat(amount);
		})
		$('#list [name="tamount"]').val(total)
		$('#list .tamount').html(parseFloat(total).toLocaleString('en-US',{style:'decimal',maximumFractionDigits:2,minimumFractionDigits:2}))
	}
	$('#manage-receiving').submit(function(e){
		e.preventDefault()
		//start_load()
		if($("#list .item-row").length <= 0){
			
			//alert_toast("Please insert atleast 1 item first.",'danger');
			swal("Error","Please insert atleast 1 item first!","error");
			end_load();
			return false;
		}

		var purchaseItems = [];
		$('#list tbody tr').each(function(){
			var itemId = $(this).data('id');
			var itemRequestQuantity = 0;
			var itemPrice = 0;
			var cellNo = 0;
			//column cell
				//1 = requestQuantity
				//2 = price
				
			$(this).find('td').each(function(){
				if(cellNo==1){
					itemRequestQuantity=$(this).find('input').val();
				}
				if(cellNo==2){
					itemPrice=$(this).find('input').val();
				}
				cellNo++;
			});

			purchaseItems.push(
				{
					'itemId':itemId, 
					'itemRequestQuantity':itemRequestQuantity, 
					'itemPrice':itemPrice
			});

		});

		swal({
			title: "Are you sure?",
			text: "Proceed creating this purchase order",
			icon: "warning",
			buttons: [
			'No, cancel it!',
			'Yes, I am sure!'
			],
			dangerMode: true,
		}).then(function(isConfirm) {
			if (isConfirm) {
			swal({
				title: 'Success',
				text: 'Purchase order has been made!',
				icon: 'success'
			}).then(function() {
				$.ajax({
					url: './admin_class.php?a=add_purchase_order',
					type: "POST",
					data: {
						"purchaseItems" : purchaseItems, 
						"supplierId" : selectedSupplierId
					},
					success:function(resp){
						location.href = "index.php?page=purchaseorder_list"
					}
				});
			});
			} else {
			swal("Cancelled", "Your imaginary file is safe :)", "error");
			}
		});
			
			
	})
</script>
<script src="bootstrap4/jquery/sweetalert.min.js"></script>



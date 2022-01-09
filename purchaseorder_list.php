<?php include 'db_connect.php';
$n2 = str_pad( 1, 6, 0, STR_PAD_LEFT);


?>
<div class="container-fluid">
	<div class="col-lg-15">
		<div class="row">
		<div class="col-md-12">
		<div class="card">
		<div class="card-header">
		<div style="font-size:20px; padding-bottom:5px">
                         <a href="javascript:history.go(-1)"><i class='bx bx-arrow-back'></i> Back</a>
                     </div>
			<div class="col">
				<div>
					<h4><b>Purchase Order List</b></h4>
					<br>
				</div>				
				<div>
			<button class="btn btn-primary float-left btn-sm" id="new_receiving"><i class="fa fa-plus"></i> Add New Purchase Order</button>		
				</div>
			</div>

			<div class="row float-right btn-sm-4" style="padding-right: 20px;">
				<a href="./print/print_inventory.php">
					<p id="print-btn">Print</p>
				</a>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				
					<div class="card-body">
						<table class="table table-bordered">
							<thead>
								<th class="text-center">PO #</th>
								<th class="text-center">Supplier</th>
								<th class="text-center">Order Date</th>
								<th class="text-center">Delivery Date</th>
								<th class="text-center">Total Amount</th>
								<th class="text-center">Status</th>
								<th class="text-center">Action</th>

								
							</thead>
							<tbody>

							<?php 
								$purchaseOrderList = $conn->query("SELECT pOT.purchase_order_id,(SELECT supplier_name FROM supplier_list WHERE id=pOT.supplier_id) AS supplier_name, pOT.order_date, CASE WHEN (SELECT COUNT(*) FROM receive_transaction WHERE purchase_order_id = pOT.purchase_order_id) > 0 THEN (SELECT receive_date FROM receive_transaction WHERE purchase_order_id = pOT.purchase_order_id ORDER BY receive_id DESC LIMIT 1) ELSE 0 END AS delivery_date, pOT.status, pOL2.TotalItems AS number_items_ordered, CASE WHEN rT.TotalItems > 0 THEN rT.TotalItems ELSE 0 END AS number_items_received, pOL.total_amount FROM purchase_order_transaction pOT LEFT JOIN (SELECT SUM(price*quantity) as total_amount, purchase_order_id FROM purchase_order_list GROUP BY purchase_order_id) pOL ON pOL.purchase_order_id = pOT.purchase_order_id LEFT JOIN (SELECT purchase_order_id, COUNT(item_id) as TotalItems FROM purchase_order_list GROUP BY purchase_order_id) pOL2 ON pOL2.purchase_order_id = pOT.purchase_order_id LEFT JOIN ( SELECT rT2.receive_id, purchase_order_id, rL2.TotalItems FROM receive_transaction rT2 LEFT JOIN( SELECT COUNT(*) as TotalItems, rL.receive_id FROM receive_list rL WHERE rL.quantity IN ( SELECT pL3.quantity FROM purchase_order_list pL3 WHERE pL3.item_id = rL.item_id))rL2 ON rL2.receive_id = rT2.receive_id )rT ON rT.purchase_order_id = pOT.purchase_order_id GROUP BY pOT.purchase_order_id");
								while($row=$purchaseOrderList->fetch_assoc()):
							?>
								<tr data-id=<?php echo $row['purchase_order_id'] ?> >
									<td class=""> <?php echo str_pad($row['purchase_order_id'], 6, 0, STR_PAD_LEFT) ?> </td>
									<td class=""> <?php echo $row['supplier_name'] ?> </td>
									<td class=""> <?php echo $row['order_date'] ?> </td>
									<td class=""> <?php echo $row['delivery_date'] ?> </td>
									<td class=""> <?php echo $row['total_amount'] ?> </td>
									<td class=""> <?php echo $row['status'] ?> </td>
									<td class="text-center">
										<a href='index.php?page=purchaseorder_details&poID=<?php echo $row['purchase_order_id'] ?>'>View</a>
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
	$(document).ready(function(){
    $('#myModal').click( function () {
        var rowid = $(e.relatedTarget).data('id');
        $.ajax({
            type : 'post',
            url : 'fetch_record.php', //Here you will fetch records 
            data :  'rowid='+ rowid, //Pass $id
            success : function(data){
            $('.fetched-data').html(data);//Show fetched data from database
            }
        });
     });
});
	$('table').dataTable()
	$('#new_receiving').click(function(){
		location.href = "index.php?page=ordering_items"
	})
	$('.delete_receiving').click(function(){
		_conf("Are you sure to delete this data?","delete_receiving",[$(this).attr('data-id')])
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
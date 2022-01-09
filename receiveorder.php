<?php include 'db_connect.php' ?>
<div class="container-fluid">
	<div class="col-lg-15">
		<div class="row">
		<div class="col-md-12">
		<div class="card">
		<div class="card-header">
			<div class="col">
				<div>
					<h4><b>Receiving order #123456 </b></h4>
					
				</div>				
			<div>
			    <button class="btn btn-primary float-left btn-sm" id="new_receiving"><i class="fa fa-plus"></i> Receive All</button>		
			</div>
			</div>

			<div class="row float-right btn-sm-4" style="padding-right: 20px;">
            <button class="btn btn-primary float-left btn-sm" id="confirm">Confirm Receive</button>   
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
								<th class="text-center">Status</th>
								
							</thead>
							<tbody>
							
								<tr>
									<td class="">Oppo R17 Pro</td>
									<td class="">Oppo</td>
									<td class="">5x</td>
									<td class=""><div contenteditable>0x</div></td>
									<td class="">Incomplete</td>
									
								</tr>
								<tr>
									<td class="">iPhone 12 Pro Max</td>
									<td class="">Apple</td>
									<td class="">3x</td>
									<td class=""><div contenteditable>0x</div></td>
									<td class="">Incomplete</td>
									
								</tr>
		
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
	$('#confirm').click(function(){
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
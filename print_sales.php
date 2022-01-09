<?php 
include 'db_connect.php';
//include './admin_class.php?a=save_transaction_sales';


if( isset($_GET['id']) ){
	$transactId = (int)$_GET['id'];
	$customer= isset($_GET['customer']) ? $_GET['customer'] : 'Guest';	
	$change = isset($_GET['change']) ? (float)$_GET['change'] : 0;
	$amountTendered =  isset($_GET['amountTendered']) ? (float)$_GET['amountTendered'] : 0;
	$grandTotal = isset($_GET['grandTotal']) ? (float)$_GET['grandTotal'] : 0;

	date_default_timezone_set('Asia/Manila');
	$timeNow = date('Y-m-d H:i:s');
	
	//$customer= "secret";
	$salesQry = $conn->query(
			"SELECT 
				pL.name, 
				pL.description, 
				sL.quantity, 
				sL.price, 
				sL.price * sL.quantity AS total_amount 
			FROM sales_list sL 
			LEFT JOIN (
				SELECT 
					pL2.id, 
					pL2.name, 
					pL2.price, 
					pL2.description 
				FROM product_list pL2
			)pL ON pL.id = sL.item_id 
			WHERE sL.transact_id = ".$transactId);
}
?>
<div class="container-fluid" id="print-sales">
	<style>
		table{
			border-collapse: collapse;
		}
		.wborder{
			border:1px solid gray;
		}
		.bbottom{
			border-bottom: 1px solid black
		}
		td p , th p{
			margin: unset
		}
			.text-center{
				text-align: center
			}
			.text-right{
				text-align: right
			}
			.clear{
				padding: 10px
			}
			#uni_modal .modal-footer{
				display: none;
			}
	</style>
	<table width="100%">
			
				<tr>
					<th class="text-center">
						<p>
							<b>Receipt</b>
						</p>
					</th>
				</tr>
				<tr>
					<td class="clear">&nbsp;</td>
				</tr>
				<tr>
					<td>
						<table width="100%">
							<tr>
								<td width="20%" class="text-right">Customer :</td>
								<td width="20%" class="bbottom"><?php echo $customer; ?></td>
								<!--<td width="40%" class="bbottom">Guest</td>-->
								<td width="20%" class="text-right">Date :</td>
								<td width="20%" class=""><?php echo $timeNow ?></td>
							</tr>
							<tr>
								<td width="20%" class="text-right">Reference Number :</td>
								<td width="80%" class="bbottom" colspan="3"><?php echo $transactId ?></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td class="clear">&nbsp;</td>
				</tr>
				<tr>
					<table width="100%">
						<tr>
							<th width="20%" class="wborder">Qty</th>
							<th width="30%" class="wborder">Product</th>
							<th width="25%" class="wborder">Unit Price</th>
							<th width="25%" class="wborder">Amount</th>
						</tr>
						

						<?php 
							while($row=$salesQry->fetch_assoc()):
						?>
						<tr>
							<td class="wborder text-center">
								<?php echo $row['quantity'] ?>
							</td>
							<td class="wborder">
								<p class="pname">Name: <b><?php echo $row['name'] ?></b></p>
								<p class="pdesc"><small><i>Description: <b><?php echo $row['description'] ?></b></i></small></p>
							</td>
							<td class="wborder text-right"><?php echo number_format($row['price'],2) ?></td>
							<td class="wborder text-right"><?php echo number_format($row['total_amount'],2) ?></td>

						</tr>
						<?php endwhile;?>
						<!-- <tr>
							<td class="wborder text-center">
								1
							</td>
							<td class="wborder">
								<p class="pname">Name: <b>Samsung note</b></p>
								<p class="pdesc"><small><i>Description: <b>4GB</b></i></small></p>
							</td>
							<td class="wborder text-right">30,000</td>
							<td class="wborder text-right">30,000</td>

						</tr> -->
					
						<tr>
							<th class="text-right wborder" colspan="3">Total</th>
							<th class="text-right wborder" ><?php echo number_format($grandTotal) ?></th>
						</tr>
						<tr>
							<th class="text-right wborder" colspan="3">Amount Tendered</th>
							<th class="text-right wborder" ><?php echo number_format($amountTendered) ?></th>
						</tr>
						<tr>
							<th class="text-right wborder" colspan="3">Change</th>
							<th class="text-right wborder" ><?php echo number_format($change) ?></th>
						</tr>
					</table>
				</tr>
				<tr>
					<td class="clear">&nbsp;</td>
				</tr>
				<tr>
					<th>
						<p class="text-center"><i>This is not an official receipt.</i></p>
					</th>
				</tr>
	</table>


</div>
<hr>
<div class="text-right">
	<div class="col-md-12">
		<div class="row">
			<button type="button" class="btn btn-sm btn-primary" id="print"><i class="fa fa-print"></i> Print</button>
        	<button type="button" class="btn btn-sm btn-secondary"  onclick="location.reload()"><i class="fa fa-plus"></i> New Sales</button>

		</div>
	</div>
</div>
<script type="text/javascript" src="script.js"></script>
<script>
	$('#print').click(function(){
		var _html = $('#print-sales').clone();
		var newWindow = window.open("","_blank","menubar=no,scrollbars=yes,resizable=yes,width=700,height=600");
		newWindow.document.write(_html.html())
		newWindow.document.close()
		newWindow.focus()
		newWindow.print()
		setTimeout(function(){;newWindow.close();}, 1500);
	})

</script>


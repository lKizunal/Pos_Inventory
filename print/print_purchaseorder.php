<div class="container-fluid" id="print-po">
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
							<b>Purchase Order</b>
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
								<td width="20%" class="text-right">Supplier :</td>
								<td width="20%" class="bbottom">GadgetsHub</td>
							
								<td width="20%" class="text-right">Order Date :</td>
								<td width="20%" class="">12/20/2012 10:30 am</td>
							</tr>
							<tr>
								<td width="20%" class="text-right">Purchase Order# :</td>
								<td width="80%" class="bbottom" colspan="3">123456</td>
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
						

						<tr>
							<td class="wborder text-center">
							3
							</td>
							<td class="wborder">
								<p class="pname">Product: <b>iPHONE 12 Pro Max</b></p>
								<p class="pdesc"><small><i></b>none</i></small></p>
							</td>
							<td class="wborder text-right">50,000</td>
							<td class="wborder text-right">3</td>

						</tr>
					
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
							<th class="text-right wborder" >30000</th>
						</tr>
					
					</table>
				
				<tr>
					<td class="clear">&nbsp;</td>
				</tr>
		
	</table>


</div>
<hr>
<div class="text-right">
	<div class="col-md-12">
		<div class="row">
			<button type="button" class="btn btn-sm btn-primary" id="print-po"><i class="fa fa-print"></i> Print</button>
        	<button type="button" class="btn btn-sm btn-secondary"  onclick="location.reload()"><i class="fa fa-plus"></i> New Sales</button>

		</div>
	</div>
</div>
<script>
	$('#print-po').click(function(){
		var _html = $('#print-po').clone();
		var newWindow = window.open("","_blank","menubar=no,scrollbars=yes,resizable=yes,width=700,height=600");
		newWindow.document.write(_html.html())
		newWindow.document.close()
		newWindow.focus()
		newWindow.print()
		setTimeout(function(){;newWindow.close();}, 1500);
	})

</script>
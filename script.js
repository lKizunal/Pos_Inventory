var CustomerDetails = {};
var GrandTotalValue = 0;
var customer='';
function loadproducts(){
	var name = $("#search").val();
	$.ajax({
		type: 'post',
		data: {
			product_list:name,
		},
		url: 'loadproducts.php',
		success: function (Response){
			$('#product_list').html(Response);
		}
	});
};

$(document).ready(function(){
	$('#customer_search').typeahead({
	  	source: function(query, result){
			// console.log(query);
			$.ajax({
			url: 'loadcustomer.php',
			method: "POST",
			data:{
				query:query
			},
			display: 'name',
			success:function(data){
				let dataObject = JSON.parse(data);
				// let dataNames = [];
				// let stringHTML = "";

				// dataObject.forEach((element, index, array) => {
				// 	// dataNames.push(element.name);
				// 	console.log(element.name);
				// 	//result[alert("Name: "+element.name+ "Address: "+element.address)].join();
					
				// 	stringHTML += "<b>"+element.name+"</b><br/> <p>"+element.address+"</p><br/>"

					
				// });

				result($.map(dataObject,function(element){
					return ['<b>'+element.name+'</b><br>'+element.address];
					// return {
					// 	name: element.name,
					// 	address: element.address
					// }
				  }));


			}
			});
	  	},updater: function (item) {
			  let itemraw = item.slice(3);
			  let itemFinal = itemraw;
			  for(let i=0; i<itemraw.length;i++){
				  if(itemraw[i] === "<"){
					itemFinal = itemraw.slice(0, i);  
					break;
				  }
			  }
			  
			$('#customer_search').val(itemFinal);
			return itemFinal;
		}
	});
}); 


function GrandTotal(){
	var TotalValue = 0;
	var TotalPriceArr = $('#tableData tr .totalPrice').get()
	var discount = $('#discount').val();
  
	$(TotalPriceArr).each(function(){
	  TotalValue += parseFloat($(this).text());//gumana pero need parin i parsefloat
	});

	GrandTotalValue = TotalValue;
  
	if(discount != null){
	  var f_discount = 0;
  
	  f_discount = TotalValue - discount;
  
	  $("#totalValue").text((f_discount));
	  $("#totalValue1").text((TotalValue));
	
	}else{
	  $("#totalValue").text((TotalValue));
	  $("#totalValue1").text((TotalValue));
	}
  };
  
  $(document).on('change', '#discount', function(){
	GrandTotal();
  });

$('body').on('click','.js-add',function(){
		var totalPrice = 0;
   		var target = $(this);
    	var product = target.attr('name');
    	var price = target.attr('price');
    	var barcode = target.attr('sku');
    	var unit = target.attr('description'); 
		var stock_available = parseInt(target.attr('stock_available')); 

		if(stock_available > 0 ){
			swal({
				title: "Enter number of items:",
				content: "input",
				})
					.then((value) => {
						console.log(value);
						if (value == "") {
							swal("Error","Entered none!","error");
						}else{
							var qtynum = value;
							if (isNaN(qtynum)){
								swal("Error","Please enter a valid number!","error");
							}else if(qtynum == null){
								swal("Error","Please enter a number!","error");
							}else{
								if(value <= stock_available){
									var subtotal = (value) * (price);
									$('#table2  tbody:last-child').append("<tr class='prd'><td class='barcode text-center'>"+barcode+"</td><td class='product text-center'>"+product+"</td><td class='price text-center'>"+price+"</td><td class='qty text-center'>"+value+"</td><td class='totalPrice text-center'>"+subtotal+"</td><td class='text-center p-1'><button class='btn btn-danger btn-sm' type='button' id='delete-row'><i class='fas fa-times-circle'></i></button></td></tr>");
									GrandTotal();								
									document.getElementById('search').value = '';
									loadproducts();

								}else{
									swal("Warning","Product insufficient stock","warning");
								}								
							}
						}
				  });
		}else{
			swal("Warning","Product Unavailable!","warning"); 
		}	
});

$("body").on('click','#delete-row', function(){
	var target = $(this);
	swal({
	   title: "Remove this item?",
	   icon: "warning",
	   buttons: true,
	   dangerMode: true,
	 })
	 .then((willDelete) => {
	   if (willDelete) {
		   $(this).parents("tr").remove();
		 swal("Removed Successfully!", {
		   icon: "success",
		   
		 });
			 GrandTotal();
	   }
 });
});

$(document).on('click','.cancel',function(e){
	var TotalPriceArr = $('#tableData tr .totalPrice').get();
	if (TotalPriceArr == 0){
	  return 0;
	}else{
	  swal({
		title: "Cancel orders?",
		text: "By doing this,orders will remove!",
		icon: "warning",
		buttons: ["No","Yes"],
		dangerMode: true,
	  })
	  .then((reload) => {
		if (reload) {
		  location.reload();
		}
	  });
	}
  });

  
  $(document).on('click','.Enter',function(){

	var TotalPriceArr = $('#tableData tr .totalPrice').get();
  
	if($.trim($('#customer_search').val()).length == 0){
		swal("Warning","Please Enter Customer Name!","warning");
		return false;
	  }
  
	if (TotalPriceArr == 0){
	  swal("Warning","No products ordered!","warning");
	  return false; 
	}else{
		
	  var product = [];
	  var quantity = [];
	  var price = [];
	  //var user = $('#uname').val();
	  var customer = $('#customer_search').val();
	  //var customer_id = $('#customer_search').attr('id');
	  var discount = $('#discount').val();
	  //alert(customer_id);
	  $('.barcode').each(function(){
		product.push($(this).text());
	  });
	  $('.qty').each(function(){
		quantity.push($(this).text());
	  });
	  $('.price').each(function(){
		price.push($(this).text());
	  });
	
	  swal({
		title: "Enter Cash",
		content: "input",
	  })
	  .then((value) => {  
		if(value == "") {
		  swal("Error","Entered None!","error");
		}else{
		  var qtynum = value;
		  if(isNaN(qtynum)){
			swal("Error","Please enter a valid number!","error");
		  }else if(qtynum == 0){
			swal("Error","Entered None!","error");
		  }else if(qtynum <= GrandTotalValue){
				swal("Error","Invalid amount! Sufficient","error");
		  }else{
			  
			// swal({
			// 	title: "Your change is" + change,
			// 	icon: "success",
			// 	buttons: "Okay",
			// 	})
			// 	.then((okay)=>{
			// 	if(okay){
			// 	  window.location.href='index.php?page=pos';
			// 	}
			// });

			//Kunin mo itong date ngayon
			
			//var today = new Date();
			//alert(quantity);
			var itemsOut = [];
			$('#tableData tr').each(function(){
				//column cell
					//1 = name
					//2 = price
					//3 = qty
					
				var itemname = "";
				var quantity = 0;
				var price = 0;
				var cellNo = 0;
				$(this).find('td').each(function(){
					console.log($(this).text());
					if(cellNo==1){
						itemname=$(this).text();
					}
					if(cellNo==2){
						price=$(this).text();
					}
					if(cellNo==3){
						quantity=$(this).text();
					}
					cellNo++;
				});

				itemsOut.push(
					{
						'itemName':itemname, 
						'quantity':quantity, 
						'price':price,
						'customer':customer,
				});

			});
			
			
			var customer_id = $(customer).attr("id ");
			var change = value - GrandTotalValue;
		
			$.ajax({
				url: './admin_class.php?a=save_transaction_sales',
				type: "POST",
				//dataType:'json',
				method: 'POST',
				data: {
					itemsOut: itemsOut, customer:customer, change:change,
				},
				success:function(resp){
					end_load()
					//var customer = $('#customer_search').val(itemFinal);
					uni_modal(
						'Print',
						"print_sales.php?"+
						"id="+resp+
						" &change="+parseFloat(change) +
						" &amountTendered="+parseFloat(value) +
						" &grandTotal="+parseFloat(GrandTotalValue) +
						" &customer="+customer);
					$('#uni_modal').modal({backdrop:'static',keyboard:false})
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(thrownError);
				  }
			 });
			//return false;

			 /*var TotalPriceArr = $('#tableData tr .totalPrice').get()
			 $(TotalPriceArr).each(function(){
			TotalValue +=($(this).text());
			   
			});*/
			
		 //d kase naka parse int kaya less than qtynum ung totalValue
			
		//change = value - TotalValue;
			//($('#totalValue').text(TotalValue));
	
	

			}
		}
		
	  });
	}
  });
  
 
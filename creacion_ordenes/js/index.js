var index = 0;
$(function() {
	$('.select2').select2();
    getCustomers();
});
function getCustomers() {
	var option="<option value=''></option>";
	$('#customer').select2('destroy');
	$.ajax({
		url:'../api-rest-laravel/public/api/customer',
		method: "GET",
	}).done(function(resp) {
		for (var i = 0; i < resp.customers.length; i++) {
			option+="<option value = '"+resp.customers[i].customer_id+"'>"+resp.customers[i].name+"</option>";
		}
		$("#customer").html(option);
		$("#customer").select2();
	}).fail(function(err) {
		console.log('error',err)
	})
}
function getProducts() {
	$('#product').select2('destroy');
	var customer_id = $("#customer").val();
	var option="<option value=''></option>";
	$.ajax({
		url:'../api-rest-laravel/public/api/customer/'+customer_id,
		method: "GET",
	}).done(function(resp) {
		for (var i = 0; i < resp.products.length; i++) {
			option+="<option value = '"+resp.products[i].product_id+"' price ="+resp.products[i].price+">"+resp.products[i].name+"</option>";
		}
		$("#product").html(option);
		$("#product").select2();
	}).fail(function(err) {
		console.log('error',err)
	})
}
function add_product() {
	var product_id = $("#product").val();
	var description = $("#product option:selected").html();
	var price = $('#product option:selected').attr('price');
	var quantity = $("#quantity").val();
	var numProducts = quantityProducts(quantity);
	if (numProducts<=5 && quantity <=5) {
		index++;
		row = "<tr><td style='display:none;' class='products_id'>"+product_id+"|"+quantity+"</td><td>"+index+"</td><td>"+description+"</td><td class='pPrice'>"+price+"</td><td class='pQuantity'>"+quantity+"</td></tr>";
		$("#summaryTable").find('tbody').append(row);
		var total = totalOrder();
		$("#total").html(total);
	}
}
function quantityProducts(quantity) {
	var numProducts = parseInt(quantity);
	$( ".pQuantity" ).each(function( index ) {
		numProducts+= parseInt($(this).html());
	});
	return numProducts;
}
function totalOrder() {
	var total = 0;
	$( ".pPrice" ).each(function( index ) {
		total+= parseInt($(this).html());
	});
	return total;
}
function create_order() {
	$("#respuesta").html('<center><h2>Please wait<br><i class="fas fa-spinner fa-spin"></i></h2></center>')
	var customer_id = $("#customer").val();
	var address = $("#address").val();
	var total = $("#total").html();
	var order_detail = [];
	$( ".products_id" ).each(function( index ) {
		var array_product = $(this).html().split("|");
		order_detail.push(JSON.parse('{"product_id":"'+array_product[0]+'","quantity":"'+array_product[1]+'"}'))
	});
	var json = {
		"customer_id":customer_id,
		"delivery_address":address,
		"total":total,
		"order_detail":order_detail
	}
	$.post('../api-rest-laravel/public/api/order',json).done(function(resp) {
		console.log(resp);
		if (resp.code==200) {
			$("#respuesta").html('<br><center><h2><div class="alert alert-success" role="alert">Order created</div></h2></center>')
		}
	}).fail(function(err) {
		respError = err.responseJSON;
		console.log(respError);
		var htmlError = '<br><div class="alert alert-danger" role="alert">Data Invalid</div>';
		$("#respuesta").html(htmlError);
	})
	
}
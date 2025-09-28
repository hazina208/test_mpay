$(document).ready(function(){  
	// code to get all records from table via select box
	$("#acc_dropdown").change(function() {    
		var item_id = $(this).find(":selected").val();
		var dataString = 'priceid='+ item_id;    
		$.ajax({
			url: 'getPrice.php',
			dataType: "json",
			data: dataString,  
			cache: false,
			success: function(priceData) {
			   if(priceData) {
					$("#heading").show();		  
					$("#no_records").hide();					
					$("#acc_amount").text(priceData.price);
					$("#tax").text(priceData.tax);
					$("#records").show();		 
				} else {
					$("#heading").hide();
					$("#records").hide();
					$("#no_records").show();
				}   	
			} 
		});
 	}) 
});
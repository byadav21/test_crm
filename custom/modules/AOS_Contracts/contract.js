$(document).ready(function(){
	$('#contract_type').change(function (){
                 returtn false;
		var contract_type = $("#contract_type").val();	
		var vender_id = $("#te_vendor_aos_contracts_1te_vendor_ida").val();
		$.ajax({
			url: "index.php?entryPoint=duplicatecontract",
			data: {vender_id_c:vender_id,contract_type:contract_type},
			type: 'POST',
			dataType: 'json',
			success: function(result){
				//alert(result.message);
				//.log(result.message);
				 if(result.message == 'yes') {
					 alert("One contract for this vendor & contract type already exist");
					 $("#contract_type").val('');
				 }
			},
		});
	
	});
	
});

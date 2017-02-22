function changeTransferStatus(request_id,value){
	var span_id="batch_transfer_request_"+request_id;	
	$("#"+span_id).html('<img id="previewimage" src="custom/themes/default/images/spin.gif" width="32" height="32"/>');	
	jQuery.ajax({
		type: "POST",
		url: 'index.php?entryPoint=transferbatch',
		data: {request_id: request_id,request_status: value},
		success: function (result)
		{
			var result = JSON.parse(result);			
			if(result.status=='Transferred'){
				 //$("#"+span_id).html('');
				 window.location.reload();
			}
		}
	}); 
	
}

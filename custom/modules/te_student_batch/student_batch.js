$(document).ready(function(){	
	$(window).load(function() {
		  $('.id-ff').html('');
		  $('.utils').html('');
		  if($("#status").val() != "Dropout" ){
			document.getElementById("detailpanel_2").style.display ='none';
		  }else{
			  document.getElementById("detailpanel_2").style.display ='inline';
		  }
	});
	$("#status").change(function() {
		if(this.value === "Dropout" ){
			document.getElementById("detailpanel_2").style.display ='inline';
		}else{
			document.getElementById("detailpanel_2").style.display ='none';
		}
	})
});

function changeDropoutStatus(request_id,value){
	var span_id="dropout_request_"+request_id;	
	$("#"+span_id).html('<img id="previewimage" src="custom/themes/default/images/spin.gif" width="32" height="32"/>');	
	jQuery.ajax({
		type: "POST",
		url: 'index.php?entryPoint=dropoutapprove',
		data: {request_id: request_id,request_status: value},
		success: function (result)
		{
			var result = JSON.parse(result);			
			if(result.status=='Approved'){
				 window.location.reload();
			}
		}
	}); 	
}
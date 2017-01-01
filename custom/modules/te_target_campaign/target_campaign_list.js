function sendEmail(campaignId){
	var span_id="send_email"+campaignId;
	
	 $("#"+span_id).html('<img id="previewimage" src="custom/themes/default/images/spin.gif" width="32" height="32"/>');	
	 jQuery.ajax({
		type: "POST",
		url: 'index.php?entryPoint=sendtargetcampaign',
		data: {campaignId: campaignId},
		success: function (result)
		{
			var result = JSON.parse(result);			
			if(result.status=='Sent'){
				 $("#"+span_id).html(result.status);
			}
		}
	}); 
}

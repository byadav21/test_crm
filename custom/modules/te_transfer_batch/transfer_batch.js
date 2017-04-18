function changeTransferStatus(request_id,value){
	if(value!='Pending' && value!='') {
		var span_id="batch_transfer_request_"+request_id;
		$("#"+span_id).html('<img id="previewimage" src="custom/themes/default/images/spin.gif" width="32" height="32"/>');
		 var conf = confirm("Are you sure you want change the status to "+value+" ?");
		 if(conf==true) {
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
			else {
	 	  jQuery('select[name=status] option[value='+value+']').removeAttr('selected');
	 	  jQuery('select[name=status] option[value=Pending]').prop('selected','selected');
  	 }
	 }

}
function updateTransfer(){

    $.ajax({
        async: false,
        type: "GET",
        data: {
          action2:'updateTransfer'
         },
        dataType: "json",
        url: 'index.php?action=seen&type=new_transfer&module=te_student_batch&is_new_approved_basic=1&to_pdf=1',
        error: function(responseData){
        },
        success:function(responseData)
        {
             if(responseData.status==1){

             }


        }
    });

}
$(document).ready(function(){
	$(".actionmenulinks").eq(0).hide();

        var is_new_approved = $( "input[name='is_new_approved_basic']" ).val();

        if(is_new_approved==1){
         updateTransfer();
        }
});

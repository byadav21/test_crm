(function($) {
	var setting ={
		headerColor: '#F08080',
	};
	var popObj = '';
	$.fn.popupModal = function(p,o){
		//~ alert(1);
		popObj = $('#'+p);
		$(this).popupSetting(o);
		popObj.show();
	};
	$.fn.popupSetting = function(o){
		console.log(setting.headerColor);
		if(popObj != 'undefined')
			popObj.find('div:eq(1)').find('div:eq(0)').css('background-color', setting.headerColor);
	};
})(jQuery);

function hideAtomBox(){
		
		$("#atomBox").hide();
	}
	



$(document).ready(function () {
         
             $("#status_d").change(function() {

				var el = $(this) ;
//~ alert(el.val())
				if(el.val() === "Alive" ) {
					$("#status_detail_d option").remove() ; 
					 $("#status_detail_d").append('<option></option>');
					$("#status_detail_d").append('<option>Call Back</option>');
					$("#status_detail_d").append('<option>Follow Up</option>');
					$("#status_detail_d").append('<option>New Lead</option>');
				}
				else if(el.val() === "Dead" ) {
					$("#status_detail_d option").remove() ; 
					 $("#status_detail_d").append('<option></option>');
					 $("#status_detail_d").append('<option>Dead Number</option>');
					$("#status_detail_d").append('<option>Wrong Number</option>');
					$("#status_detail_d").append('<option>Ringing Multiple Times</option>');
					$("#status_detail_d").append('<option>Not Enquired</option>');
					$("#status_detail_d").append('<option>Not Eligible</option>');
					$("#status_detail_d").append('<option>Rejected</option>');
					$("#status_detail_d").append('<option>Fallout</option>');
					$("#status_detail_d").append('<option>Retired</option>');
				}
				else if(el.val() === "Converted" ) {
					$("#status_detail_d option").remove() ; 
					 $("#status_detail_d").append('<option></option>');
					 $("#status_detail_d").append('<option>Converted</option>');
				}
				else if(el.val() === "Duplicate" ) {
					$("#status_detail_d option").remove() ; 
					 $("#status_detail_d").append('<option></option>');
					 $("#status_detail_d").append('<option>Duplicate</option>');
				}
				else if(el.val() === "Warm" ) {
					$("#status_detail_d option").remove() ; 
					 $("#status_detail_d").append('<option></option>');
					 $("#status_detail_d").append('<option>Re-Enquired</option>');
					$("#status_detail_d").append('<option>Prospect</option>');
				}
			  });


			document.getElementById("date_of_callback_date_d").style.display ='none';
			document.getElementById("date_of_callback_trigger_d").style.display ='none';
			document.getElementById("date_of_callback_hours_d").style.display ='none';
			document.getElementById("date_of_callback_minutes_d").style.display ='none';
			document.getElementById("call_back_label").innerHTML = '';
			
			document.getElementById("date_of_followup_date_d").style.display ='none';
			document.getElementById("date_of_followup_trigger_d").style.display ='none';
			document.getElementById("date_of_followup_hours_d").style.display ='none';
			document.getElementById("date_of_followup_minutes_d").style.display ='none';
			document.getElementById("followup_label").innerHTML = '';		
			
			document.getElementById("date_of_prospect_date_d").style.display ='none';
			document.getElementById("date_of_prospect_trigger_d").style.display ='none';
			document.getElementById("date_of_prospect_hours_d").style.display ='none';
			document.getElementById("date_of_prospect_minutes_d").style.display ='none';
			document.getElementById("prospect_label").innerHTML = '';	

         $("#status_detail_d").change(function() {
					if(document.getElementById('status_detail_d').value=='Call Back'){
							document.getElementById("date_of_callback_date_d").style.display ='inline';
							document.getElementById("date_of_callback_trigger_d").style.display ='inline';
							document.getElementById("date_of_callback_hours_d").style.display ='inline';
							document.getElementById("date_of_callback_minutes_d").style.display ='inline';
							document.getElementById("call_back_label").innerHTML = 'Call back Date:';	
							
					}
					else{
							document.getElementById("date_of_callback_date_d").style.display ='none';
							document.getElementById("date_of_callback_trigger_d").style.display ='none';
							document.getElementById("date_of_callback_hours_d").style.display ='none';
							document.getElementById("date_of_callback_minutes_d").style.display ='none';
							document.getElementById("call_back_label").innerHTML = '';								
					}
					
					
					if(document.getElementById('status_detail_d').value=='Follow Up'){
							document.getElementById("date_of_followup_date_d").style.display ='inline';
							document.getElementById("date_of_followup_trigger_d").style.display ='inline';
							document.getElementById("date_of_followup_hours_d").style.display ='inline';
							document.getElementById("date_of_followup_minutes_d").style.display ='inline';
							document.getElementById("followup_label").innerHTML = 'Followup Date:';	
					}
					else{
							
							document.getElementById("date_of_followup_date_d").style.display ='none';
							document.getElementById("date_of_followup_trigger_d").style.display ='none';
							document.getElementById("date_of_followup_hours_d").style.display ='none';
							document.getElementById("date_of_followup_minutes_d").style.display ='none';
							document.getElementById("followup_label").innerHTML = '';				 
					}
					
					if(document.getElementById('status_detail_d').value=='Prospect'){
							document.getElementById("date_of_prospect_date_d").style.display ='inline';
							document.getElementById("date_of_prospect_trigger_d").style.display ='inline';
							document.getElementById("date_of_prospect_hours_d").style.display ='inline';
							document.getElementById("date_of_prospect_minutes_d").style.display ='inline';
							document.getElementById("prospect_label").innerHTML = 'Prospect Date:';	
					}
					else{

						document.getElementById("date_of_prospect_date_d").style.display ='none';
						document.getElementById("date_of_prospect_trigger_d").style.display ='none';
						document.getElementById("date_of_prospect_hours_d").style.display ='none';
						document.getElementById("date_of_prospect_minutes_d").style.display ='none';
						document.getElementById("prospect_label").innerHTML = '';	
					 
					}

				});       
             
             
		 });
    

(function($) {
	var setting ={
		headerColor: '#F08080',
	};
	var popObj = '';
	$.fn.popupModal = function(p,o){
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
	
	function saveDisposition(lid){
			
			var status = document.getElementById('status_d').value;
			var status_detail = document.getElementById('status_detail_d').value;
			var description = document.getElementById('description_d').value;
			
			var callback_date = document.getElementById('date_of_callback_date_d').value;
			var callback_hr = document.getElementById('date_of_callback_hours_d').value;
			var callback_min = document.getElementById('date_of_callback_minutes_d').value;
			var call_id = document.getElementById('call_id').value;
			var disposition_id = document.getElementById('disposition_id').value;
			
			var callback = callback_date+" "+callback_hr+":"+callback_min+":00";
			//~ 
			//~ 
			
			var followup_date = document.getElementById('date_of_followup_date_d').value;
			var followup_hr = document.getElementById('date_of_followup_hours_d').value;
			var followup_min = document.getElementById('date_of_followup_minutes_d').value;
			
			var followup = followup_date+" "+followup_hr+":"+followup_min+":00";
			
			var prospect_date = document.getElementById('date_of_prospect_date_d').value;
			var prospect_hr = document.getElementById('date_of_prospect_hours_d').value;
			var prospect_min = document.getElementById('date_of_prospect_minutes_d').value;
			
			var prospect = prospect_date+" "+prospect_hr+":"+prospect_min+":00";
			//~ var followup = '';
			//~ var prospect = '';
			var redirect = 'DetailView&record='+lid;
			if(document.getElementById('lead_id').value!=''){
				lid = document.getElementById('lead_id').value;
				var redirect = 'index';
			}
			
			var params = '&lead_id='+lid+'&status='+status+'&status_detail='+status_detail+'&description='+description+'&callback='+callback+'&followup='+followup+'&prospect='+prospect+'&call_id='+call_id+'&disposition_id='+disposition_id
			//~ alert(params)
			//~ return false;
			//~ SUGAR.ajaxUI.showLoadingPanel();
			var callback = {
				success:function(b){
					//~ SUGAR.ajaxUI.hideLoadingPanel();
					//~ alert(b.responseText)
					if(b.responseText.trim()=="1"){	
						window.opener = self;
      window.close();
						//~ window.location.href='index.php?module=Leads&action='+redirect;
					}
					else if(b.responseText.trim()=="2"){
						alert('Please disconnect the call first and save the record')
					}
					else{
						alert('Error!! Record not saved')
					}
				}
						
			}
			
			var connectionObject = YAHOO.util.Connect.asyncRequest('GET', 'index.php?entryPoint=saveDisposition'+params, callback);
		 }
		
	
	function callHangup(){
			
		
			lid = document.getElementById('lead_id').value;
			number = document.getElementById('mobile').value;
			//~ alert(number);
			SUGAR.ajaxUI.showLoadingPanel();
			var callback = {
				success:function(b){
					SUGAR.ajaxUI.hideLoadingPanel();
					//~ alert(b.responseText);
					if(b.responseText.trim()=="200"){	
						document.getElementById("call_status").innerHTML = ' Call Disconnected';
						document.getElementById("hangup").disabled = true;
						document.getElementById("hold").disabled = true;
						document.getElementById("unhold").disabled = true;

					}
					else{
						alert('Error!! Not Disconnected')
					}
				}
						
			}
			
			var connectionObject = YAHOO.util.Connect.asyncRequest('GET', 'index.php?entryPoint=callHangup&number='+number+'&lid='+lid, callback);
		 }



	function callHold(method){
			
			lid = document.getElementById('lead_id').value;
			number = document.getElementById('mobile').value;
			//~ alert(number);
			SUGAR.ajaxUI.showLoadingPanel();
			var callback = {
				success:function(b){
					SUGAR.ajaxUI.hideLoadingPanel();
					//~ alert(b.responseText);
					if(b.responseText.trim()=="200"){	
						document.getElementById("call_status").innerHTML = '';
						if(method=='hold'){
							document.getElementById("call_status").innerHTML = ' Call on Hold';
							document.getElementById("hold").style.display ='none';
							document.getElementById("unhold").style.display ='inline';
						}
						else{
							document.getElementById("call_status").innerHTML = '';
							document.getElementById("hold").style.display ='inline';
							document.getElementById("unhold").style.display ='none';
						}
					}
					else{
						if(method=='hold'){
						alert('Error!! Not putting on hold')
						}
						else{
							alert('Error!! Not putting on un hold')
						}
					}
				}
						
			}
			
			var connectionObject = YAHOO.util.Connect.asyncRequest('GET', 'index.php?entryPoint=callHold&number='+number+'&method='+method, callback);
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


			/*document.getElementById("date_of_callback_date_d").style.display ='none';
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
			document.getElementById("prospect_label").innerHTML = '';*/

		(!document.getElementById("date_of_callback_date_d")) ? false : document.getElementById("date_of_callback_date_d").style.display ='none';
		(!document.getElementById("date_of_callback_trigger_d")) ? false : document.getElementById("date_of_callback_trigger_d").style.display ='none';
		(!document.getElementById("date_of_callback_hours_d")) ? false : document.getElementById("date_of_callback_hours_d").style.display ='none';
		(!document.getElementById("date_of_callback_minutes_d")) ? false : document.getElementById("date_of_callback_minutes_d").style.display ='none';
		(!document.getElementById("call_back_label")) ? false : document.getElementById("call_back_label").innerHTML = '';

		(!document.getElementById("date_of_followup_date_d")) ? false : document.getElementById("date_of_followup_date_d").style.display ='none';
		(!document.getElementById("date_of_followup_trigger_d")) ? false : document.getElementById("date_of_followup_trigger_d").style.display ='none';
		(!document.getElementById("date_of_followup_hours_d")) ? false : document.getElementById("date_of_followup_hours_d").style.display ='none';
		(!document.getElementById("date_of_followup_minutes_d")) ? false : document.getElementById("date_of_followup_minutes_d").style.display ='none';
		(!document.getElementById("followup_label")) ? false : document.getElementById("call_back_label").innerHTML = '';

		(!document.getElementById("date_of_prospect_date_d")) ? false : document.getElementById("date_of_prospect_date_d").style.display ='none';
		(!document.getElementById("date_of_prospect_trigger_d")) ? false : document.getElementById("date_of_prospect_trigger_d").style.display ='none';
		(!document.getElementById("date_of_prospect_hours_d")) ? false : document.getElementById("date_of_prospect_hours_d").style.display ='none';
		(!document.getElementById("date_of_prospect_minutes_d")) ? false : document.getElementById("date_of_prospect_minutes_d").style.display ='none';
		(!document.getElementById("prospect_label")) ? false : document.getElementById("prospect_label").innerHTML = '';		

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

<?php
require_once('include/MVC/View/views/view.edit.php');
class te_utmViewEdit extends ViewEdit {
      function display(){
?>
 <script>
 //batch_status
YAHOO.util.Event.addListener(window,"load", function() {
document.getElementById('btn_te_vendor_te_utm_1_name').onclick=function(){
	var popup_request_data = {
		'call_back_function' : 'set_vendor_rfq_return',
		'form_name' : 'EditView',
		'field_to_name_array' : {
		   'id' : 'te_vendor_te_utm_1te_vendor_ida',
		   'name': 'te_vendor_te_utm_1_name',
		 },
	};
open_popup('te_vendor', 600, 400, '&vendor_status_advanced[]=Active', true, false, popup_request_data);
}
});
function set_vendor_rfq_return(popup_reply_data){				
	 var name_to_value_array = popup_reply_data.name_to_value_array;
	 var id = name_to_value_array['te_vendor_te_utm_1te_vendor_ida'];
	 var name = name_to_value_array['te_vendor_te_utm_1_name'];
	 document.getElementById('te_vendor_te_utm_1_name').value= name;
	 document.getElementById('te_vendor_te_utm_1te_vendor_ida').value = id;
}

YAHOO.util.Event.addListener(window,"load", function() {
document.getElementById('btn_batch').onclick=function(){
	var popup_request_data = {
		'call_back_function' : 'set_rfq_return',
		'form_name' : 'EditView',
		'field_to_name_array' : {
		   'id' : 'te_ba_batch_id_c',
		   'batch_code': 'batch',
		 },
	};
open_popup('te_ba_Batch', 600, 400, '&batch_status_advanced[]=planned&batch_status_advanced[]=classes_in_progress', true, false, popup_request_data);
}
});
function set_rfq_return(popup_reply_data){				
	 var name_to_value_array = popup_reply_data.name_to_value_array;
	 var id = name_to_value_array['te_ba_batch_id_c'];
	 var name = name_to_value_array['batch'];
	 document.getElementById('batch').value= name;
	 document.getElementById('te_ba_batch_id_c').value = id;
}
//medium
YAHOO.util.Event.addListener(window,"load", function() {
document.getElementById('btn_contract').onclick=function(){
	var vendor=$("#te_vendor_te_utm_1_name").val();
	var popup_request_data = {
		'call_back_function' : 'set_contract_rfq_return',
		'form_name' : 'EditView',
		'field_to_name_array' : {
		   'id' : 'aos_contracts_id_c',
		   'name': 'contract',
		 },
	};
open_popup('AOS_Contracts', 600, 400, '&te_vendor_aos_contracts_1_name_advanced='+vendor, true, false, popup_request_data);
}
});
function set_contract_rfq_return(popup_reply_data){				
	 var name_to_value_array = popup_reply_data.name_to_value_array;
	 var id = name_to_value_array['aos_contracts_id_c'];
	 var name = name_to_value_array['contract'];
	 document.getElementById('contract').value= name;
	 document.getElementById('aos_contracts_id_c').value = id;
}
</script> 	
      	
      	
<?php      	
//te_vendor_te_utm_1te_vendor_ida
//te_vendor_id_c

		if($this->bean->aos_contracts_id_c){
			
		  $obj= new AOS_Contracts();
		   $cont=$obj->retrieve($this->bean->aos_contracts_id_c);
		   $this->bean->contract=$cont->name;	
		}


      	parent::display();
    }
}
?>

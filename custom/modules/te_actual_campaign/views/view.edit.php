<?php
require_once('include/MVC/View/views/view.edit.php');
class te_actual_campaignViewEdit extends ViewEdit {
      function display(){
?>
 <script>
YAHOO.util.Event.addListener(window,"load", function() {
document.getElementById('btn_te_utm_te_actual_campaign_1_name').onclick=function(){
	var popup_request_data = {
		'call_back_function' : 'set_utm_rfq_return',
		'form_name' : 'EditView',
		'field_to_name_array' : {
		   'id' : 'te_utm_te_actual_campaign_1te_utm_ida',
		   'name': 'te_utm_te_actual_campaign_1_name',
		 },
	};
open_popup('te_utm', 600, 400, '&utm_status_advanced[]=Testing&utm_status_advanced[]=Live', true, false, popup_request_data);
}
});
function set_utm_rfq_return(popup_reply_data){				
	 var name_to_value_array = popup_reply_data.name_to_value_array;
	 var id = name_to_value_array['te_utm_te_actual_campaign_1te_utm_ida'];
	 var name = name_to_value_array['te_utm_te_actual_campaign_1_name'];
	 document.getElementById('te_utm_te_actual_campaign_1_name').value= name;
	 document.getElementById('te_utm_te_actual_campaign_1te_utm_ida').value = id;
}
</script>    	
<?php      	
   	parent::display();
    }
}
?>

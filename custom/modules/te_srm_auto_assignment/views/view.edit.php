<?php
require_once('include/MVC/View/views/view.edit.php');
class te_srm_auto_assignmentViewEdit extends ViewEdit {
      function display(){
		global $current_user;
		$username=$current_user->last_name;
?>
 <script>
 //batch_status
YAHOO.util.Event.addListener(window,"load", function() {
document.getElementById('btn_assigned_user_name').onclick=function(){
	var popup_request_data = {
		'call_back_function' : 'set_user_rfq_return',
		'form_name' : 'EditView',
		'field_to_name_array' : {
		   'id' : 'assigned_user_id',
		   'name': 'assigned_user_name',
		 },
	};
open_popup('Users', 600, 400, '&reports_to_name_advanced=<?php echo $username;?>', true, false, popup_request_data);
}
});
function set_user_rfq_return(popup_reply_data){				
	 var name_to_value_array = popup_reply_data.name_to_value_array;
	 var id = name_to_value_array['assigned_user_id'];
	 var name = name_to_value_array['assigned_user_name'];
	 document.getElementById('assigned_user_name').value= name;
	 document.getElementById('assigned_user_id').value = id;
}

</script> 	
      	
      	
<?php      	
      	parent::display();
    }
}
?>

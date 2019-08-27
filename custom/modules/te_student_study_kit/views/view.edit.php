<?php
require_once('include/MVC/View/views/view.edit.php');
class te_student_study_kitViewEdit extends ViewEdit {
      function display(){
?>
 <script>
 //batch_status
YAHOO.util.Event.addListener(window,"load", function() {
document.getElementById('btn_batch_id').onclick=function(){	
	var student=$("#te_student_te_student_study_kit_1_name").val();
	var popup_request_data = {
		'call_back_function' : 'set_batch_rfq_return',
		'form_name' : 'EditView',
		'field_to_name_array' : {
		   'id' : 'te_student_batch_id_c',
		   'name': 'batch_id',
		 },
	};
open_popup('te_student_batch', 600, 400, '&te_student_te_student_batch_1_name_advanced='+student, true, false, popup_request_data);
}
});
function set_batch_rfq_return(popup_reply_data){				
	 var name_to_value_array = popup_reply_data.name_to_value_array;
	 var id = name_to_value_array['te_student_batch_id_c'];
	 var name = name_to_value_array['batch_id'];
	 document.getElementById('batch_id').value= name;
	 document.getElementById('te_student_batch_id_c').value = id;
}
</script> 	    	
      	
<?php      	
		parent::display();
    }
}
?>

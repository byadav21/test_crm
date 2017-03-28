<?php
require_once('include/MVC/View/views/view.edit.php');
class te_student_paymentViewEdit extends ViewEdit {
      function display(){
?>
 <script>
 //batch_status
YAHOO.util.Event.addListener(window,"load", function() {
document.getElementById('btn_batch_id').onclick=function(){	
	var student=$("#te_student_te_student_payment_1_name").val();
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
// Drop-down payments Mamnish
$(function(){
	$("#payment_type").change(function() {

		var py = $(this) ;
		if(py.val()=='Online'){
			$("#payment_source option").remove() ; 
			 $("#payment_source").append('<option></option>');
			 $("#payment_source").append('<option>PayU</option>');
			 $("#payment_source").append('<option>ATOM</option>');
			 $("#payment_source").append('<option>Paytm</option>');
			 //~ document.getElementById("transaction_id_label").style.display ='inline';
			 //~ document.getElementById("transaction_id").style.display ='inline';
			 //~ document.getElementById("reference_number_label").style.display ='none';
			 //~ document.getElementById("reference_number").style.display ='none';
		}
		else if(py.val()=='Offline'){
			$("#payment_source option").remove() ; 
			 $("#payment_source").append('<option></option>');
			 $("#payment_source").append('<option>NEFT</option>');
			 $("#payment_source").append('<option>Cheque</option>');
			  $("#payment_source").append('<option>Institute</option>');
			 //~ document.getElementById("transaction_id_label").style.display ='none';
			 //~ document.getElementById("transaction_id").style.display ='none';
			 //~ document.getElementById("reference_number_label").style.display ='inline';
			 //~ document.getElementById("reference_number").style.display ='inline';
		}
		else{
			$("#payment_source option").remove() ; 
		}
	})	
})
</script> 	    	
      	
<?php  
	if(isset($_REQUEST['te_student_te_student_payment_1_name'])){
		global $db;
		
			$comp = new te_student();
			$comp->retrieve($_REQUEST['parent_id']);
				$batchSql="SELECT sb.id,b.name FROM te_student_te_student_batch_1_c AS sbr INNER JOIN te_student_batch AS sb on sbr.te_student_te_student_batch_1te_student_batch_idb=sb.id AND sbr.te_student_te_student_batch_1te_student_ida='".$comp->id."' INNER JOIN te_ba_batch AS b ON b.id=sb.te_ba_batch_id_c ORDER BY sb.date_entered DESC LIMIT 0,1";
				$batchObj =$db->query($batchSql);
				$row =$db->fetchByAssoc($batchObj);
				$this->bean->batch_id =$row['name'];
				$this->bean->te_student_batch_id_c=$row['id'];
				 
  }
		parent::display();
    }
}
?>

<?php
require_once('include/MVC/View/views/view.edit.php');
class te_student_batchViewEdit extends ViewEdit {
	function display(){		
		global $current_user;	
		parent::display();
		echo "<script>
		    if($('#status').val()!='Dropout'){
				document.getElementById('detailpanel_2').style.display ='none';
		    }
			
				$('#status').on('change',function(){
						if($(this).val()=='Dropout'){
							document.getElementById('detailpanel_2').style.display ='block';
						}else{
							document.getElementById('detailpanel_2').style.display ='none';
						}
				});
			</script>";	
		if($current_user->designation!="BUH"){
			echo '<script>
			document.getElementById("dropout_status_label").style.display ="none"
			document.getElementById("dropout_status").style.display ="none"
			$("#refund_date_label").hide()
			$("#refund_date").hide()
			$("#refund_date_trigger").hide()
			</script>';	
		}
    }
}
?>

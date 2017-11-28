<?php
require_once('include/MVC/View/views/view.edit.php');
class te_student_batchViewEdit extends ViewEdit {
	function display(){		
		global $current_user,$db;		
		parent::display();
		
		$checkRoleSql="SELECT * FROM `acl_roles_users` WHERE user_id='".$current_user->id."' AND `role_id`='30957fe0-3494-e372-656d-58a9a6296516'";
	    $checkRoleObj =$db->query($checkRoleSql);
		$row =$db->fetchByAssoc($checkRoleObj);
		if($row){
			echo "<script>
			$('#assigned_user_name').prop('readonly',true);
			$('#btn_assigned_user_name').hide();
			$('#btn_clr_assigned_user_name').hide();
			</script>";	
		}
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
	?>
	<script>	
	$(function(){
	$("#status option[value='Inactive_transfer']").remove();
	 $("#status_discription_label").text('Dispostion Status:');
	$("#status").trigger('click');
	$("#status").change(function(){
		if($(this).val()=='Active'){
		  $("#status_discription").show();
		  $("#status_discription_label").text('Dispostion Status:');
		}
		else{
			$("#status_discription").hide();
			$("#status_discription_label").text('');
		}
	});
	});	
	</script>
	<?php
    }
}
?>

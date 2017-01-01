<?php
ini_set ( 'display_errors', 'off' );
require_once ('include/MVC/View/views/view.edit.php');
class te_dispositionViewEdit extends ViewEdit {
	public function __construct()
  {
	   parent::ViewEdit();
	   $this->useForSubpanel = true;     //use this file for sub-panel as well as for editview
	   $this->useModuleQuickCreateTemplate = true;
  }
  function display(){
		global $current_user;
		$this->ev->process();
		if($this->ev->isDuplicate) {
		 foreach($this->ev->fieldDefs as $name=>$defs) {
			 if(!empty($defs['auto_increment'])) {
				$this->ev->fieldDefs[$name]['value'] = '';
			 }
		   }
		}
		//~ echo "sdfasdf";
		$this->ev->defs['templateMeta']['form']['buttons'] = array('SUBPANELSAVE', 'SUBPANELCANCEL'); // code to remove full form button from quick create view
		unset($this->ev->defs['templateMeta']['form']['buttons']);
		echo $this->ev->display($this->showTitle);
			//~ parent::display ();
		?>
		<script>
		
		$(document).ready(function () {
		document.getElementById("date_of_callback_date").style.display ='none';
		document.getElementById("date_of_callback_hours").style.display ='none';
		document.getElementById("date_of_callback_minutes").style.display ='none';
		document.getElementById("date_of_callback_trigger").style.display ='none';
		document.getElementById("date_of_callback_label").innerHTML = '';			
 
 		document.getElementById("date_of_followup_date").style.display ='none';
		document.getElementById("date_of_followup_hours").style.display ='none';
		document.getElementById("date_of_followup_minutes").style.display ='none';
		document.getElementById("date_of_followup_trigger").style.display ='none';
		document.getElementById("date_of_followup_label").innerHTML = '';			
 
 
 
 		document.getElementById("date_of_prospect_date").style.display ='none';
		document.getElementById("date_of_prospect_hours").style.display ='none';
		document.getElementById("date_of_prospect_minutes").style.display ='none';
		document.getElementById("date_of_prospect_trigger").style.display ='none';
		document.getElementById("date_of_prospect_label").innerHTML = '';			
 
 
             $("#status_detail").change(function() {
					if(document.getElementById('status_detail').value=='Call Back'){
							document.getElementById("date_of_callback_date").style.display ='inline';
							document.getElementById("date_of_callback_hours").style.display ='inline';
							document.getElementById("date_of_callback_minutes").style.display ='inline';
							document.getElementById("date_of_callback_trigger").style.display ='inline';
							document.getElementById("date_of_callback_label").innerHTML = 'Call back Date:';			
					}
					else{
							document.getElementById("date_of_callback_date").style.display ='none';
							document.getElementById("date_of_callback_minutes").style.display ='none';
							document.getElementById("date_of_callback_hours").style.display ='none';
							document.getElementById("date_of_callback_trigger").style.display ='none';
							document.getElementById("date_of_callback_label").innerHTML = '';			
					 
					}
					
					
					if(document.getElementById('status_detail').value=='Follow Up'){
							document.getElementById("date_of_followup_date").style.display ='inline';
							document.getElementById("date_of_followup_hours").style.display ='inline';
							document.getElementById("date_of_followup_minutes").style.display ='inline';
							document.getElementById("date_of_followup_trigger").style.display ='inline';
							document.getElementById("date_of_followup_label").innerHTML = 'Followup Date:';			
					}
					else{
							
							document.getElementById("date_of_followup_date").style.display ='none';
							document.getElementById("date_of_followup_hours").style.display ='none';
							document.getElementById("date_of_followup_minutes").style.display ='none';
							document.getElementById("date_of_followup_trigger").style.display ='none';
							document.getElementById("date_of_followup_label").innerHTML = '';			
					 
					 
										 
					}
					
					if(document.getElementById('status_detail').value=='Prospect'){
							document.getElementById("date_of_prospect_date").style.display ='inline';
							document.getElementById("date_of_prospect_hours").style.display ='inline';
							document.getElementById("date_of_prospect_minutes").style.display ='inline';
							document.getElementById("date_of_prospect_trigger").style.display ='inline';
							document.getElementById("date_of_prospect_label").innerHTML = 'Prospect Date:';			
					}
					else{

						document.getElementById("date_of_prospect_date").style.display ='none';
						document.getElementById("date_of_prospect_hours").style.display ='none';
						document.getElementById("date_of_prospect_minutes").style.display ='none';
						document.getElementById("date_of_prospect_trigger").style.display ='none';
						document.getElementById("date_of_prospect_label").innerHTML = '';			
				 
					 
					}

				})
			
})
		</script>
		
		<?php	
	}
}
?>

<?php
ini_set ( 'display_errors', 'off' );
require_once ('include/MVC/View/views/view.edit.php');
class te_payment_detailsViewEdit extends ViewEdit {
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
		//~ $this->ev->defs['templateMeta']['form']['buttons'] = array('SUBPANELSAVE', 'SUBPANELCANCEL'); // code to remove full form button from quick create view
		//~ unset($this->ev->defs['templateMeta']['form']['buttons']);
		echo $this->ev->display($this->showTitle);
			//~ parent::display ();
		?>
		<script>
		
		$(document).ready(function () {
		$("#payment_source option").remove() ; 
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
	}
}
?>

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
		$payment_source = '';
		if(isset($this->ev->focus->fetched_row['payment_source']) && !empty($this->ev->focus->fetched_row['payment_source'])){
			$payment_source = $this->ev->focus->fetched_row['payment_source'];
		}
		
		//~ $this->ev->defs['templateMeta']['form']['buttons'] = array('SUBPANELSAVE', 'SUBPANELCANCEL'); // code to remove full form button from quick create view
		//~ unset($this->ev->defs['templateMeta']['form']['buttons']);
		echo $this->ev->display($this->showTitle);
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
								 $("#payment_source").append('<option>Institute</option>');
								 $("#payment_source").append('<option>IMPS</option>');
								 $("#payment_source").append('<option>TPT</option>');
								 $("#payment_source").append('<option>FT</option>');
								 $("#payment_source").append('<option>Cash</option>');
								 $("#payment_source").append('<option>DD</option>');
								 $("#payment_source").append('<option>Inst.DD</option>');
								 $("#payment_source").append('<option>C.Disc</option>');
								 $("#payment_source").append('<option>E.Disc</option>');
								 $("#payment_source").append('<option>TDS</option>');
								 $("#payment_source").append('<option>Others</option>');
								 //~ document.getElementById("transaction_id_label").style.display ='none';
								 //~ document.getElementById("transaction_id").style.display ='none';
								 //~ document.getElementById("reference_number_label").style.display ='inline';
								 //~ document.getElementById("reference_number").style.display ='inline';
							}
							else{
								$("#payment_source option").remove() ; 
							}
						});
			$("#payment_type").trigger('change');
			
			<?php 
			if($payment_source && ($payment_source=='PayU' || $payment_source=='payu_in')){?>
			var inputText='PayU';
			$("#payment_source option:contains(" + inputText + ")").prop('selected', 'selected');
			<?php } ?>
			<?php 
			if($payment_source && strtolower($payment_source=='atom')){?>
			var inputText='Atom';
			$("#payment_source option:contains(" + inputText + ")").prop('selected', 'selected');
			<?php } ?>
			<?php 
			if($payment_source && strtolower($payment_source=='paytm')){?>
			var inputText='Paytm';
			$("#payment_source option:contains(" + inputText + ")").prop('selected', 'selected');
			<?php } ?>
			<?php 
			if($payment_source && strtolower($payment_source=='neft')){?>
			var inputText='NEFT';
			$("#payment_source option:contains(" + inputText + ")").prop('selected', 'selected');
			<?php } ?>
			<?php 
			if($payment_source && strtolower($payment_source=='cheque')){?>
			var inputText='Cheque';
			$("#payment_source option:contains(" + inputText + ")").prop('selected', 'selected');
			<?php } ?>
			<?php 
			if($payment_source && strtolower($payment_source=='institute')){?>
			var inputText='Institute';
			$("#payment_source option:contains(" + inputText + ")").prop('selected', 'selected');
			<?php } ?>
			<?php 
			if($payment_source && strtolower($payment_source=='imps')){?>
			var inputText='IMPS';
			$("#payment_source option:contains(" + inputText + ")").prop('selected', 'selected');
			<?php } ?>
			<?php 
			if($payment_source && strtolower($payment_source=='tpt')){?>
			var inputText='TPT';
			$("#payment_source option:contains(" + inputText + ")").prop('selected', 'selected');
			<?php } ?>
			<?php 
			if($payment_source && strtolower($payment_source=='ft')){?>
			var inputText='FT';
			$("#payment_source option:contains(" + inputText + ")").prop('selected', 'selected');
			<?php } ?>
			<?php 
			if($payment_source && strtolower($payment_source=='cash')){?>
			var inputText='Cash';
			$("#payment_source option:contains(" + inputText + ")").prop('selected', 'selected');
			<?php } ?>
			<?php 
			if($payment_source && strtolower($payment_source=='dd')){?>
			var inputText='DD';
			$("#payment_source option:contains(" + inputText + ")").prop('selected', 'selected');
			<?php } ?>
			<?php 
			if($payment_source && strtolower($payment_source=='inst.dd')){?>
			var inputText='Inst.DD';
			$("#payment_source option:contains(" + inputText + ")").prop('selected', 'selected');
			<?php } ?>
			<?php 
			if($payment_source && strtolower($payment_source=='c.disc')){?>
			var inputText='C.Disc';
			$("#payment_source option:contains(" + inputText + ")").prop('selected', 'selected');
			<?php } ?>
			<?php 
			if($payment_source && strtolower($payment_source=='e.disc')){?>
			var inputText='E.Disc';
			$("#payment_source option:contains(" + inputText + ")").prop('selected', 'selected');
			<?php } ?>
			<?php 
			if($payment_source && strtolower($payment_source=='tds')){?>
			var inputText='TDS';
			$("#payment_source option:contains(" + inputText + ")").prop('selected', 'selected');
			<?php } ?>
			<?php 
			if($payment_source && strtolower($payment_source=='others')){?>
			var inputText='Others';
			$("#payment_source option:contains(" + inputText + ")").prop('selected', 'selected');
			<?php } ?>
			
})
		</script>
		
		<?php	
	}
}
?>

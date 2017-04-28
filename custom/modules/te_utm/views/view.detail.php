<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once 'include/MVC/View/views/view.detail.php';
require_once 'modules/AOS_Contracts/AOS_Contracts.php';

class Customte_UTMViewDetail extends ViewDetail
{
    public function preDisplay()
    {
        parent::preDisplay();
    }
	public function display()
    { 
		
		if($this->bean->aos_contracts_id_c){
			
		  $obj= new AOS_Contracts();
		   $cont=$obj->retrieve($this->bean->aos_contracts_id_c);
		   $this->bean->contract=$cont->name;	
		}
		
		if($this->bean->utm_status=="Live" || $this->bean->utm_status=="Expired"){
			unset($this->dv->defs['templateMeta']['form']['buttons'][0]);
			unset($this->dv->defs['templateMeta']['form']['buttons'][2]);
		}
		$this->bean->utm_url="http://www.talentedge.in/?utm_source=".strtolower($this->bean->te_vendor_te_utm_1_name)."&utm_medium=".strtolower($this->bean->contract_type)."&utm_term=".strtolower($this->bean->batch)."&utm_campaign=".strtolower($this->bean->utm_campaign);
		parent::display();
	}
}

?>
<script language="javascript">
function makeExpire(thisform){
	var url='index.php?module=te_utm&return_module=te_utm&return_action=DetailView&action=makeexpire&record='+thisform.record.value;	
	$.ajax({
		url: "index.php?entryPoint=makeitexpire",
		data: {record_id:thisform.record.value},
		type: 'POST',
		dataType: 'json',
		success: function(result){
			window.location.reload();
		},
	});
	return false;
}
</script>

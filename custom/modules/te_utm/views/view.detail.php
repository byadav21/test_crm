<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once 'include/MVC/View/views/view.detail.php';

class Customte_UTMViewDetail extends ViewDetail
{
    public function preDisplay()
    {
        parent::preDisplay();
    }
	public function display()
    { 
		if($this->bean->utm_status=="Live" || $this->bean->utm_status=="Expired"){
			unset($this->dv->defs['templateMeta']['form']['buttons'][0]);
			unset($this->dv->defs['templateMeta']['form']['buttons'][2]);
		}
		$this->bean->utm_url="http://www.talentedge.in/?utm_source=".$this->bean->te_vendor_te_utm_1_name."&utm_medium=".$this->bean->contract."&utm_campaign=".$this->bean->utm_campaign."&utm_term=".$this->bean->batch;
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
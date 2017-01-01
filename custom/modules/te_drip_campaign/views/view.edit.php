<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
class te_drip_campaignViewEdit extends ViewEdit
{
	public function display(){		
		$campainListSql="SELECT cl.name,cl.mailer_day FROM te_drip_campaign_list cl INNER JOIN te_drip_campaign_te_drip_campaign_list_c clr  ON cl.id=clr.te_drip_campaign_te_drip_campaign_listte_drip_campaign_list_idb AND clr.te_drip_campaign_te_drip_campaign_listte_drip_campaign_ida='".$this->bean->id."' AND clr.deleted=0 WHERE cl.deleted=0";
		$campainListObj=$GLOBALS['db']->query($campainListSql);	
		$drip_campain_list=array();
		while($row = $GLOBALS['db']->fetchByAssoc($campainListObj)){
			$drip_campain_list[]=$row;
		}
		$templateList=array();
		$templateObj=$GLOBALS['db']->query("SELECT id,name FROM email_templates WHERE type='email'");
		while($row = $GLOBALS['db']->fetchByAssoc($templateObj)){
			$templateList[]=$row;
		}		
		$this->ss->assign('total_mailers', $this->bean->total_mailers); 
		$this->ss->assign('drip_campain_list', $drip_campain_list);  
		$this->ss->assign('templateList', $templateList); 
		?>
		<script>
		YAHOO.util.Event.addListener(window,"load", function() {
		document.getElementById('btn_program').onclick=function(){
			alert("sdfasdfa")'
			var institue=$("#institue").val();
			var popup_request_data = {
				'call_back_function' : 'set_program_rfq_return',
				'form_name' : 'EditView',
				'field_to_name_array' : {
				   'id' : 'te_pr_programs_id_c',
				   'contract_type': 'program',
				 },
			};
		open_popup('te_pr_Programs', 600, 400, '&institue_advanced='+institue, true, false, popup_request_data);
		}
		});
		function set_program_rfq_return(popup_reply_data){				
			 var name_to_value_array = popup_reply_data.name_to_value_array;
			 var id = name_to_value_array['te_pr_programs_id_c'];
			 var name = name_to_value_array['program'];
			 document.getElementById('program').value= name;
			 document.getElementById('te_pr_programs_id_c').value = id;
		}
		</script> 	
	<?php
		parent::display();
		
	}  
	 
}

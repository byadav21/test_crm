<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php'); 
class StudentHook{
	
	function updateFields($bean, $event, $argument){				
		$leadSql = "SELECT leads.id as lead_id FROM leads INNER JOIN leads_cstm ON leads.id = leads_cstm.id_c INNER JOIN email_addr_bean_rel ON email_addr_bean_rel.bean_id = leads.id AND email_addr_bean_rel.bean_module ='Leads' INNER JOIN email_addresses ON email_addresses.id =  email_addr_bean_rel.email_address_id WHERE leads.deleted = 0 AND email_addresses.email_address='".$bean->email."'";

		$leadObj= $GLOBALS['db']->query($leadSql);
		while($row = $GLOBALS['db']->fetchByAssoc($leadObj)){
			$GLOBALS['db']->query("UPDATE leads SET phone_other='".$bean->phone_other."' WHERE id='".$row['lead_id']."'");
			$GLOBALS['db']->query("UPDATE leads_cstm SET work_experience_c='".$bean->work_experience."', functional_area_c='".$bean->functional_area."', education_c='".$bean->education."' WHERE id_c='".$row['lead_id']."'");
		}			
	}		
}

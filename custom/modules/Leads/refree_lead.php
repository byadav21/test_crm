<?php

class Alogic{
	function Bmethod(&$bean, $event, $arguments){
		global $db;

		 if (isset($_REQUEST['parent_id']) && $_REQUEST['parent_id'] != '' && isset($_REQUEST['parent_type']) &&  $_REQUEST['parent_type'] == 'Leads'){			
				 $bean->lead_source="Referrals";
				   $sqllead="SELECT * FROM `leads_leads_1_c` where leads_leads_1leads_ida='".$bean->id."' AND leads_leads_1leads_idb='".$_REQUEST['parent_id']."'";
				   $leadObj = $db->query($sqllead);
				   $leadresult = $db->fetchByAssoc($leadObj);
				   if(!$leadresult){
					$insertSql="INSERT INTO leads_leads_1_c SET id='".create_guid()."', date_modified='".date('Y-m-d H:i:s')."', leads_leads_1leads_ida='".$bean->id."', leads_leads_1leads_idb='".$_REQUEST['parent_id']."'";
					$insertresult = $db->query($insertSql);
				}
			}
			
		}
			
	}
	 
?>
 

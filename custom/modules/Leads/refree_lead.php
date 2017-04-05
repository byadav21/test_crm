<?php

class Alogic{
	function Bmethod(&$bean, $event, $arguments){
		global $db;

		 if (isset($_REQUEST['parent_id']) && $_REQUEST['parent_id'] != '' && isset($_REQUEST['parent_type']) &&  $_REQUEST['parent_type'] == 'Leads'){
			
	
			$bean->lead_source="Referrals";
			
			
			}
			
		}
			
	}
	 
?>
 

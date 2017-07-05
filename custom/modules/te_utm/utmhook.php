
<?php
if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');

class MakeUtmLive {
    function updateLiveOn(&$bean, $event, $arguments){
	   $bean->live_on= date("Y-m-d");
	}
	
	function validate($bean, $event, $arguments){
		 
		global $db;
		if($bean->contract_type && $bean->te_ba_batch_id_c && $bean->te_vendor_te_utm_1_name){
			
			$vendor=$db->query("select id from te_vendor where name='" . $bean->te_vendor_te_utm_1_name . "' and deleted=0");
			if($db->getRowCount($vendor)>0){
				$vendorid = $db->fetchByAssoc($vendor);
				if($vendorid['id']){
				   $sql="select te_utm.id from te_utm inner join te_vendor_te_utm_1_c v on v.te_vendor_te_utm_1te_utm_idb=te_utm.id and te_vendor_te_utm_1te_vendor_ida='". $vendorid['id'] ."' where contract_type='{$bean->contract_type}' and te_ba_batch_id_c='". $bean->te_ba_batch_id_c."' and te_utm.deleted=0 and v.deleted=0";	
				  $dupl=$db->query($sql);
					  if($db->getRowCount($dupl)>0){
						  $utmid = $db->fetchByAssoc($dupl);
                                                  if(!empty($bean->fetched_row['id']) && $bean->id==$utmid[id]){
						 
                                                  } else
                                                  {
                                                       echo '<script> alert("You can\'t add duplicate utm");callPage(); function callPage(){  window.location.href="index.php?module=te_utm&action=DetailView&record='. $utmid['id'] .'" } </script>';	 exit();
                                                      
                                                  }
					  }
				}
			} 
			
		}
		
	}
	
}

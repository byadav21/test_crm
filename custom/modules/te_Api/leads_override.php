<?php

require_once('modules/Leads/Lead.php');
class leads_override extends Lead {
	
	
	public function __construct() {
		parent::__construct();
	}
	
	
	public function fetchUtm($source,$medium,$term){
		 global $db;
		 
		$sql="select u.te_ba_batch_id_c,u.name from te_utm u 
					inner join te_vendor_te_utm_1_c v on v.te_vendor_te_utm_1te_utm_idb=u.id 
					inner join te_vendor tv on tv.id=v.te_vendor_te_utm_1te_vendor_ida and tv.name='$source' 
					inner join te_ba_batch b on b.id=u.te_ba_batch_id_c and b.batch_code='$term'
					inner join aos_contracts c on c.id=u.aos_contracts_id_c and c.contract_type='$medium' where utm_status!='Expired' and u.deleted=0 and v.deleted=0 and tv.deleted=0 and b.deleted=0 and c.deleted=0 "; 
						
		 $results=$db->query($sql);
		 if($db->getRowCount($results)>0){
			 $utm=$db->fetchByAssoc($results);
			 return $utm;
		 }else{
			return false;	 
		 }
	}
	
	
}


<?php
if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');

class UserHook {
    function changeUserName(&$bean, $event, $arguments){
	   $bean->email1 = $bean->user_name;
	}
	function checkUserVendors(){
		global $current_user; 
		$looged_in_user_id = $current_user->id;
		$userArr = $this->__fetchVendorWithUsers($looged_in_user_id);
		$_SESSION['user_cp_vendor'] = $userArr; 	
	}
	function __fetchVendorWithUsers($user_id){
		 global $db;
		 
		$sql="select v.name AS vendor from te_vendor AS v
					inner join te_vendor_users_1_c AS uvr on uvr.te_vendor_users_1te_vendor_ida=v.id and uvr.te_vendor_users_1users_idb='$user_id' 
					where v.deleted=0 and uvr.deleted=0 "; 
						
		 $results=$db->query($sql);
		 if($db->getRowCount($results)>0){
			 $vendor=$db->fetchByAssoc($results);
			 return $vendor;
		 }else{
			return false;	 
		 }
	}
}

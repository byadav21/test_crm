<?php

class Approver extends SugarBean{
	
	public static function getApprover($roleID){
		
		$db = DBManagerFactory::getInstance();
          $query = "SELECT a.parent_role,a.issubmit,a.isapprove,b.name as parname FROM acl_roles as a left join acl_roles as b on a.parent_role=b.id 
                    WHERE a.deleted=0 and a.id='$roleID' ORDER BY a.name";

        $result = $db->query($query);
        return $db->fetchByAssoc($result);
		
	}
	
}

//call into tplfile

function approver($role){
		$parent= Approver::getApprover($role);
		return ($parent && count($parent)>0)? $parent['parname']:'';
}

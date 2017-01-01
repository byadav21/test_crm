<?php

global $current_user,$admin_group_header;
if ($current_user->user_access_type =='group'){
	foreach($admin_group_header as $key => $value){
		if($key > 0){
		unset($admin_group_header[$key]);	
		}
	}
	unset($admin_group_header['sagility']);	
	unset($admin_group_header[0][3]['Users']['roles_management']);
	unset($admin_group_header[0][3]['Administration']['password_management']);
	unset($admin_group_header[0][3]['Administration']['securitygroup_config']);
	
}


?>

<?php 
 //WARNING: The contents of this file are auto-generated


/***Ravi Tiwari 17 Jan 2017****/
/** Create a link for Currency Setting in admin Panel***********/

global $current_user,$admin_group_header;
$admin_option_defs=array();
$admin_option_defs['Administration']['task']= array('Tax_Settings','LBL_TAX_SETTING','LBL_TAX_PREFIX','./index.php?module=Configurator&action=taxSettings');
$admin_group_header[]=array('LBL_TAX_SETTING','',false,$admin_option_defs, 'LBL_TAX_PREFIX');




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
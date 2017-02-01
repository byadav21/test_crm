<?php
/***Ravi Tiwari 17 Jan 2017****/
/** Create a link for Currency Setting in admin Panel***********/

global $current_user,$admin_group_header;
$admin_option_defs=array();
$admin_option_defs['Administration']['task']= array('Tax_Settings','LBL_TAX_SETTING','LBL_TAX_PREFIX','./index.php?module=Configurator&action=taxSettings');
$admin_group_header[]=array('LBL_TAX_SETTING','',false,$admin_option_defs, 'LBL_TAX_PREFIX');
?>

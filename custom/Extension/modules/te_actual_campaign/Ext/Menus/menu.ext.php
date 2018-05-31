<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point'); 
global $mod_strings, $app_strings, $sugar_config;
// This will add the new option @Pawan

//print_r($module_menu);
unset($module_menu[0]);
unset($module_menu[1]);
//print_r($module_menu);
$module_menu[]=Array("index.php?module=te_actual_campaign&action=actual_campaign_summary", "Actual Campaign Plan", "");
if(ACLController::checkAccess('te_actual_campaign', 'import', true))$module_menu[]=Array("index.php?module=Import&action=Step1&import_module=te_actual_campaign&return_module=te_actual_campaign&return_action=index", "Actual Campaign Import");


?>

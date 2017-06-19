<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point'); 
global $mod_strings, $app_strings, $sugar_config;
// This will add the new option @Manish Kumar
unset($module_menu[0]);
unset($module_menu[1]);
if(ACLController::checkAccess('te_budgeted_campaign', 'import', true))$module_menu[]=Array("index.php?module=te_budgeted_campaign&action=budget_summary", "Budgeted Campaign Plan", "");


?>

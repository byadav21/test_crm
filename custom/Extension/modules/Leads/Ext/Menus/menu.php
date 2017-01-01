<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point'); 
global $mod_strings, $app_strings, $sugar_config;

// This will add the new option
if(ACLController::checkAccess('Leads', 'import', true))$module_menu[]=Array("index.php?module=Leads&action=lead_transfer", "Bulk Leads Transfer", "");
$module_menu[]=Array("index.php?module=Leads&action=search_leads", "CRM Leads Search", "");
?>

<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point'); 
global $mod_strings, $app_strings, $sugar_config;

// This will add the new option
if(ACLController::checkAccess('Leads', 'import', true))$module_menu[]=Array("index.php?module=Leads&action=lead_transfer", "Bulk Leads Transfer", "");
$module_menu[]=Array("index.php?module=Leads&action=search_leads", "CRM Leads Search", "");
$module_menu[]=Array("index.php?module=Leads&action=utmleadassignmentrule", "Campaign Allocation", "");
$module_menu[] = array('index.php?module=AOR_Reports&action=agentdashboardreport', "Agent dashboard Report", 'AOR_Reports');
$module_menu[] = array('index.php?module=AOR_Reports&action=prospectdashboard', "Prospect dashboard", 'AOR_Reports');
$module_menu[] = array('index.php?module=AOR_Reports&action=prospectdashboard2', "Prospect dashboard 2", 'AOR_Reports');
?>

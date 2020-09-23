<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point'); 
global $mod_strings, $current_user;

require_once('modules/ACLRoles/ACLRole.php');
$acl_obj = new ACLRole();

//Channel Partner as displayCHP hide 
$misData    = $acl_obj->getUserSlug($current_user->id);

// This will add the new option
if(ACLController::checkAccess('Leads', 'import', true))
    $module_menu[]=array("index.php?module=Leads&action=search_leads", "CRM Leads Search", "");
    
    //Channel Partner(CP) , Channel Partner Manager(CPMGR) & Channel Partner TL(CPTL) for not show Lead menu
    if ($misData['slug'] != "CP" || $misData['slug'] != "CPMGR" || $misData['slug'] != "CPTL"){
        $module_menu[]=array("index.php?module=Leads&action=lead_transfer", "Bulk Leads Transfer", "");
        $module_menu[]=array("index.php?module=Leads&action=utmleadassignmentrule", "Campaign Allocation", "");
        $module_menu[] = array('index.php?module=AOR_Reports&action=agentdashboardreport', "Agent dashboard Report", 'AOR_Reports');
        $module_menu[] = array('index.php?module=AOR_Reports&action=prospectdashboard', "Prospect dashboard", 'AOR_Reports');
        $module_menu[] = array('index.php?module=AOR_Reports&action=prospectdashboard2', "Prospect dashboard 2", 'AOR_Reports');
    }
?>

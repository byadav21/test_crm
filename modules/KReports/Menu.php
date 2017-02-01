<?php
/* * *******************************************************************************
 * This file is part of KReporter. KReporter is an enhancement developed
 * by Christian Knoll. All rights are (c) 2012 by Christian Knoll
 *
 * This Version of the KReporter is licensed software and may only be used in
 * alignment with the License Agreement received with this Software.
 * This Software is copyrighted and may not be further distributed without
 * witten consent of Christian Knoll
 *
 * You can contact us at info@kreporter.org
 * ****************************************************************************** */
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

global $mod_strings,$app_strings;
if(ACLController::checkAccess('KReports', 'edit', true))$module_menu[]=Array("index.php?module=KReports&action=EditView&return_module=KReports&return_action=DetailView", $mod_strings['LNK_NEW_REPORT'],"CreateReport");
if(ACLController::checkAccess('KReports', 'list', true))$module_menu[]=Array("index.php?module=KReports&action=index&return_module=KReports&return_action=DetailView", $mod_strings['LNK_REPORT_LIST'],"Reports");
$acl_obj = new ACLController();
$module_menu[] = array ('index.php?module=AOR_Reports&action=weeklyreport', "Weekly Report", 'AOR_Reports');
$module_menu[] = array ('index.php?module=AOR_Reports&action=dailyreport', "Daily Report", 'AOR_Reports');
$module_menu[] = array ('index.php?module=te_report_recipients&action=index', "Report Recipients", 'te_report_recipients');
$module_menu[] = array ('index.php?module=AOR_Reports&action=pipelinereport', "Pipeline Report", 'AOR_Reports');
$module_menu[] = array ('index.php?module=AOR_Reports&action=salescyclereport', "Sales Cycle Report", 'AOR_Reports');
$module_menu[] = array ('index.php?module=AOR_Reports&action=statusreport', "Status Report", 'AOR_Reports');
$module_menu[] = array ('index.php?module=AOR_Reports&action=conversionreport', "Conversion Report", 'AOR_Reports');
?>

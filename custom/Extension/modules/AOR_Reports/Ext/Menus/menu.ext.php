<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point'); 
/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Master Subscription
 * Agreement ("License") which can be viewed at
 * http://www.sugarcrm.com/crm/master-subscription-agreement
 * By installing or using this file, You have unconditionally agreed to the
 * terms and conditions of the License, and You may not use this file except in
 * compliance with the License.  Under the terms of the license, You shall not,
 * among other things: 1) sublicense, resell, rent, lease, redistribute, assign
 * or otherwise transfer Your rights to the Software, and 2) use the Software
 * for timesharing or service bureau purposes such as hosting the Software for
 * commercial gain and/or for the benefit of a third party.  Use of the Software
 * may be subject to applicable fees and any use of the Software without first
 * paying applicable fees is strictly prohibited.  You do not have the right to
 * remove SugarCRM copyrights from the source code or user interface.
 *
 * All copies of the Covered Code must include on each user interface screen:
 *  (i) the "Powered by SugarCRM" logo and
 *  (ii) the SugarCRM copyright notice
 * in the same form as they appear in the distribution.  See full license for
 * requirements.
 *
 * Your Warranty, Limitations of liability and Indemnity are expressly stated
 * in the License.  Please refer to the License for the specific language
 * governing these rights and limitations under the License.  Portions created
 * by SugarCRM are Copyright (C) 2004-2011 SugarCRM, Inc.; All Rights Reserved.
 ********************************************************************************/

/*********************************************************************************

 * Description:  TODO To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
 
global $current_user;
global $mod_strings, $app_strings;
require_once('modules/ACL/ACLController.php');
$acl_obj = new ACLController();
$module_menu[] = array ('index.php?module=AOR_Reports&action=weeklyreport', "Weekly Report", 'AOR_Reports');
$module_menu[] = array ('index.php?module=AOR_Reports&action=dailyreport', "Daily Report", 'AOR_Reports');
$module_menu[] = array ('index.php?module=te_report_recipients&action=index', "Report Recipients", 'te_report_recipients');
$module_menu[] = array ('index.php?module=AOR_Reports&action=pipelinereport', "Pipeline Report", 'AOR_Reports');
$module_menu[] = array ('index.php?module=AOR_Reports&action=salescyclereport', "Sales Cycle Report", 'AOR_Reports');
$module_menu[] = array ('index.php?module=AOR_Reports&action=statusreport', "Status Report", 'AOR_Reports');
$module_menu[] = array ('index.php?module=AOR_Reports&action=conversionreport', "Conversion Report", 'AOR_Reports');
$module_menu[] = array ('index.php?module=AOR_Reports&action=conversionreport', "Conversion Report Vendor", 'AOR_Reports');
$module_menu[] = array ('index.php?module=AOR_Reports&action=gsvreport', "GSV Report", 'AOR_Reports');
$module_menu[] = array ('index.php?module=AOR_Reports&action=feedbackreport', "Feedback Report", 'AOR_Reports');
$module_menu[] = array ('index.php?module=AOR_Reports&action=resultreport', "Result Report", 'AOR_Reports');
$module_menu[] = array ('index.php?module=AOR_Reports&action=dropoutreport', "Dropout Report", 'AOR_Reports');

?>

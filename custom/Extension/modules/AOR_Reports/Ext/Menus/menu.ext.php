<?php
 //WARNING: The contents of this file are auto-generated


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

global $current_user,$db;
global $mod_strings, $app_strings;
require_once('modules/ACL/ACLController.php');
/*
$ccrow =$db->query("SELECT user_id FROM `acl_roles_users` WHERE `role_id` IN('7e225ca3-69fa-a75d-f3f2-581d88cafd9a','270ce9dd-7f7d-a7bf-f758-582aeb4f2a45','cc7133be-0db9-d50a-2684-582c0078e74e') AND deleted=0");
$crrArr=[];
while($ccres =$db->fetchByAssoc($ccrow)){
  $crrArr[]=$ccres['user_id'];
}

$dmrow =$db->query("SELECT user_id FROM `acl_roles_users` WHERE `role_id` IN('d7097ec5-28a7-8e06-46aa-581b127ee4af') AND deleted=0");
$dmArr=[];
while($dmres =$db->fetchByAssoc($dmrow)){
  $dmArr[]=$dmres['user_id'];
}

$srmrow =$db->query("SELECT user_id FROM `acl_roles_users` WHERE `role_id` IN('86800aa5-c8c2-5868-a690-58a88d188265','30957fe0-3494-e372-656d-58a9a6296516') AND deleted=0");
$srmArr=[];
while($srmres =$db->fetchByAssoc($srmrow)){
  $srmArr[]=$srmres['user_id'];
}*/

$acl_obj = new ACLController();
# CC #
if($current_user->is_admin==1){
$module_menu[] = array ('index.php?module=te_report_recipients&action=index', "Report Recipients", 'te_report_recipients');  
}

//CC ROLE
$sql="select slug from acl_roles inner join acl_roles_users on acl_roles_users.role_id=acl_roles.id and user_id='" . $current_user->id . "' and acl_roles.deleted=0 and acl_roles_users.deleted=0";
$mis=$db->query($sql);
$misData=$db->fetchByAssoc($mis);
$displayCC=false;
$displayMis=false;
$displaySRM=false;
$displayDM=false;
if($misData['slug']=='CCTL') $displayCC=true;
else if($misData['slug']=='mis') $displayMis=true;
else if($misData['slug']=='SRM') $displaySRM=true;
else if($misData['slug']=='DMM') $displayDM=true;
//MIS ROLE
$sql="select slug from acl_roles inner join acl_roles_users on acl_roles_users.role_id=acl_roles.id and user_id='" . $current_user->id . "' and acl_roles.deleted=0 and acl_roles_users.deleted=0";
$mis=$db->query($sql);
$misData=$db->fetchByAssoc($mis);
$displayMis=false;


if($current_user->is_admin==1 || $displayMis||$displayCC){
  $module_menu[] = array ('index.php?module=AOR_Reports&action=pipelinereport', "Pipeline Report", 'AOR_Reports');
  $module_menu[] = array ('index.php?module=AOR_Reports&action=salescyclereport', "Sales Cycle Report", 'AOR_Reports');
  $module_menu[] = array ('index.php?module=AOR_Reports&action=statusreport', "Status Report", 'AOR_Reports');
  $module_menu[] = array ('index.php?module=AOR_Reports&action=conversionreport', "Conversion Report", 'AOR_Reports');
  $module_menu[] = array ('index.php?module=AOR_Reports&action=gsvreport', "GSV Report", 'AOR_Reports');
  $module_menu[] = array ('index.php?module=AOR_Reports&action=referalleads', "Referal Lead", 'AOR_Reports');
}

# DIgital Marketing #
if( $current_user->is_admin==1 || $displayMis || $displayDM){
$module_menu[] = array ('index.php?module=AOR_Reports&action=weeklyreport', "Weekly Report", 'AOR_Reports');
$module_menu[] = array ('index.php?module=AOR_Reports&action=dailyreport', "Daily Report", 'AOR_Reports');
$module_menu[] = array ('index.php?module=AOR_Reports&action=dmstatusreport', "DM Status Report", 'AOR_Reports');
$module_menu[] = array ('index.php?module=AOR_Reports&action=budgeted_actual', "Budgeted Vs Actual Report", 'AOR_Reports');
$module_menu[] = array ('index.php?module=AOR_Reports&action=Conversion_data', "Conversion Data Report", 'AOR_Reports');
$module_menu[] = array ('index.php?module=AOR_Reports&action=utmstatusreport', "UTM Status Report", 'AOR_Reports');

$module_menu[] = array ('index.php?module=AOR_Reports&action=dateleadperformance', "Till Date Lead Performance", 'AOR_Reports');
$module_menu[] = array ('index.php?module=AOR_Reports&action=leadsfeedbackreport', "Leads Feedback Report", 'AOR_Reports');
$module_menu[] = array ('index.php?module=AOR_Reports&action=leadperformancereport', "Leads Performance Report", 'AOR_Reports');
$module_menu[] = array ('index.php?module=AOR_Reports&action=dailyuploadreport', "Upload Report", 'AOR_Reports');
}
# SRM REPORTS #
if( $current_user->is_admin==1 || $displayMis || $displaySRM){
$module_menu[] = array ('index.php?module=AOR_Reports&action=feedbackreport', "Feedback Report", 'AOR_Reports');
$module_menu[] = array ('index.php?module=AOR_Reports&action=resultreport', "Result Report", 'AOR_Reports');
$module_menu[] = array ('index.php?module=AOR_Reports&action=dropoutreport', "Dropout Report", 'AOR_Reports');
$module_menu[] = array ('index.php?module=AOR_Reports&action=leadprofilingreport', "Lead Profiling Report", 'AOR_Reports');
$module_menu[] = array ('index.php?module=AOR_Reports&action=certificate', "Certificate Report", 'AOR_Reports');
$module_menu[] = array ('index.php?module=AOR_Reports&action=studentstudykit', "Student Study Kit Report", 'AOR_Reports');
$module_menu[] = array ('index.php?module=AOR_Reports&action=referalstudent', "Referal Student Report",'AOR_Reports');
$module_menu[] = array ('index.php?module=AOR_Reports&action=feereport', "Fee Report", 'AOR_Reports');
}


?>

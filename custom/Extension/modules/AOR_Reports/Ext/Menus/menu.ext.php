<?php

//WARNING: The contents of this file are auto-generated


if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
/* * *******************************************************************************
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
 * ****************************************************************************** */

/* * *******************************************************************************

 * Description:  TODO To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 * ****************************************************************************** */

global $current_user, $db;
global $mod_strings, $app_strings;
//require_once('modules/ACL/ACLController.php');
//$acl_obj = new ACLController();

require_once('modules/ACLRoles/ACLRole.php');
$acl_obj = new ACLRole();
# CC #
//echo '<pre>';
//print_r($current_user);
$vendorID   = $current_user->te_vendor_users_1te_vendor_ida;
$vendorName = $current_user->te_vendor_users_1_name;
$is_Vendor  = 0;
if ($vendorID != '' && $vendorName != '')
{
    $is_Vendor = 1;
}

$userSql = "SELECT u.id
                FROM users AS u
            INNER JOIN acl_roles_users AS aru ON aru.user_id=u.id
            INNER JOIN acl_roles ON aru.role_id=acl_roles.id
            INNER JOIN users AS ru ON ru.id=u.reports_to_id
            WHERE aru.`role_id` IN ('7e225ca3-69fa-a75d-f3f2-581d88cafd9a')
              AND u.deleted=0
              AND u.id='" . $current_user->id . "'
              AND aru.deleted=0
              AND acl_roles.deleted=0 ";

$userObj   = $db->query($userSql);
$is_manger = $db->getRowCount($userObj);

$misData    = $acl_obj->getUserSlug($current_user->id);
$displayCC  = false;
$displayMis = false;
$displaySRM = false;
$displayDM  = false;
$displayCCM = false;
$displayCP  = false; // Channel Partner
$displayCPMGR = false;// Channel Partner Manger
$displayCPTL = false;// Channel Partner TL

if ($misData['slug'] == 'CCM' || $misData['slug'] == 'CCC' || $misData['slug'] == 'CCTL' || $misData['slug'] == 'CCH')
    $displayCC  = true;
if ($misData['slug'] == 'mis')
    $displayMis = true;
if ($misData['slug'] == 'SRM' || $misData['slug'] == 'SRE')
    $displaySRM = true;
if ($misData['slug'] == 'DMM' || $misData['slug'] == 'BA')
    $displayDM  = true;
if ($misData['slug'] == 'CCM')
    $displayCCM = true;
if ($misData['slug'] == 'CP')
    $displayCP = true;
if ($misData['slug'] == 'CPMGR')    
    $displayCPMGR = true;
if ($misData['slug'] == 'CPTL')    
    $displayCPTL = true;

        $UsersVendrArr = array(
            'e7c007d2-5ca7-57e5-64ba-5b23a435c4b7',// => 'ileap',
            'b28d0f4a-b486-731e-2781-5b23a41da9cf',// => 'TBS',
            'b80c8a52-5174-3d92-feae-5b23a453bbcf',// => 'iimjobs',
            'ca7ed5d5-daaf-7bf9-110e-5b23a58965dd',// => 'CiteHR',
            '3d29ebfb-23a7-ea3e-b4d8-5b23a590f80f',// => 'Career360',
            '36990877-a094-db61-6610-5b20f95a6e6e',// => 'Infoedge'
            'e7dafa0f-2d5e-9885-90d4-5c383bda6353',// =>'intellactads'
            'bbbea66c-1aee-a0bc-2654-5cb02b0123f0',// =>'OneyearMBA'
            '80c3283f-97f4-06b3-c231-5d66510a463d',// =>'Proformics'
	        '98beaef1-89c8-b51e-68f0-5df21e3b40d9',// =>'pointific'
            '67fe4fa4-3b45-9a7c-35c4-5efeed862529',//=> Connective9
            '9ecbddae-7078-89f6-4cbb-5f1a854587fe', //=> Collegedunia
            '2abde316-781b-2dce-4ba4-6051cd2c902c', //=> Shiksha
            '5d31a08d-d23e-a7e5-e661-6034cbfba0f3', //=> wheebox
            'af9384f4-266e-4de2-b036-6074239ec46d' // => 'Freshersworld'
            );
         
        
        /*
        $UsersVendrArr = array(
            '29a6c441-8c9c-a49a-a28e-5b234fa1ecf9', // => 'ileap', 
            '1cbd38c1-2a63-3ab8-a85c-5b234febc8a4', // => 'TBS',
            '93e39ed4-487b-e35c-62bc-5b234f7cd078', // => 'iimjobs',
            'e86be88c-3f72-3211-a058-5b2350c211cd', // => 'CiteHR',
            'b27c5fd1-f781-bcab-a7e5-5b2350b22896', // => 'Career360',
            '87d1f4da-c6c9-81fe-944a-5b1fb537fc1c', // => 'Infoedge'
            );
        */
//   print_r($misData['slug']);      
if ($current_user->is_admin == 1 || $displayMis || $displayCC)
{

    //$module_menu[] = array('index.php?module=AOR_Reports&action=vendorwisecounconreport', "Vendor wise agent conversion Report", 'AOR_Reports');
    //$module_menu[] = array('index.php?module=AOR_Reports&action=conversionreport', "Conversion Report", 'AOR_Reports');
}

// if Counsellors managers logged in;
if ($is_manger == 1)
{
    $module_menu[] = array('index.php?module=AOR_Reports&action=leadutilization', "Lead Utilization", 'AOR_Reports');
    $module_menu[] = array('index.php?module=AOR_Reports&action=agentproductivityreport', "Agent Productivity Report", 'AOR_Reports');
    $module_menu[] = array('index.php?module=AOR_Reports&action=leadperformancereports', "Leads Performance Report", 'AOR_Reports');
    $module_menu[] = array('index.php?module=AOR_Reports&action=batchwisestatusdetailreport', "Lead connectivity report", 'AOR_Reports');
}


if(in_array($current_user->id, $UsersVendrArr))
{       
 $module_menu[] = array('index.php?module=AOR_Reports&action=vendorwisestatusdetailreport', "Vendor Wise Status Detail Report", 'AOR_Reports');
 $module_menu[] = array('index.php?module=AOR_Reports&action=utmstatusreport', "UTM Status Report", 'AOR_Reports');
 $module_menu[] = array('index.php?module=AOR_Reports&action=vendordataexport', "Vendor Data Export Report", 'AOR_Reports');
}

    $salesClusterHeadArray  = array("SCH","SCHMGR","SCHTL","SCHAGENT");
    $qualityArray           = array("QA","QAMGR","QATL","QAAGENT");
    $trainingArray          = array("TR","TRMGR","TRTL","TRAGENT");
    $channelArray           = array("CH","CHMGR","CHTL","CHAGENT");

# DIgital Marketing Training Quality #
if( in_array($misData['slug'], $salesClusterHeadArray) ||  in_array($misData['slug'], $qualityArray) ||  in_array($misData['slug'], $trainingArray) || in_array($misData['slug'], $channelArray) || in_array($misData['slug'], $businessHeadArray) ){
    $module_menu[] = array('index.php?module=AOR_Reports&action=counsellorwisestatusdetailreport', "Counsellor Wise Status Detail Report_Create Date", 'AOR_Reports');
    $module_menu[] = array('index.php?module=AOR_Reports&action=counsellorwisestatusupdatedreport', "Counsellor Wise Status Detail Report_Modified Date", 'AOR_Reports');

}

# DIgital Marketing #
if ($current_user->is_admin == 1 || $displayMis || $displayDM )
{

    //$module_menu[] = array('index.php?module=AOR_Reports&action=studentgsv', "Student GSV", 'AOR_Reports');
    //$module_menu[] = array('index.php?module=AOR_Reports&action=studentcollection', "Student Collection", 'AOR_Reports');
    $module_menu[] = array('index.php?module=AOR_Reports&action=leadutilization', "Lead Utilization", 'AOR_Reports');
    $module_menu[] = array('index.php?module=AOR_Reports&action=dailyreport', "Daily Report", 'AOR_Reports');
    //$module_menu[] = array('index.php?module=AOR_Reports&action=dmstatusreport', "DM Status Report", 'AOR_Reports');
    //$module_menu[] = array('index.php?module=AOR_Reports&action=budgeted_actual', "Budgeted Vs Actual Report", 'AOR_Reports');
    //$module_menu[] = array('index.php?module=AOR_Reports&action=conversiondatareport', "Conversion Data Report", 'AOR_Reports');
    //$module_menu[] = array('index.php?module=AOR_Reports&action=counselorconversionreport', "Counselor Conversion Report", 'AOR_Reports');
    $module_menu[] = array('index.php?module=AOR_Reports&action=vendorwiseleadsreport', "Vendor Wise Leads Report", 'AOR_Reports');
    $module_menu[] = array('index.php?module=AOR_Reports&action=vendorwiseconversionreport', "Vendor Wise Conversion Report", 'AOR_Reports');
    //$module_menu[] = array('index.php?module=AOR_Reports&action=batchwisestatusreport', "Batch Wise Status Report", 'AOR_Reports');
    //$module_menu[] = array('index.php?module=AOR_Reports&action=vendorwisestatusreport', "Vendor Wise Status Report", 'AOR_Reports');
    $module_menu[] = array('index.php?module=AOR_Reports&action=vendorwisestatusdetailreport', "Vendor Wise Status Detail Report", 'AOR_Reports');
    $module_menu[] = array ('index.php?module=AOR_Reports&action=vendorstatusdatewisereport', "Vendor Status Date Wise Report", 'AOR_Reports');
    $module_menu[] = array ('index.php?module=AOR_Reports&action=vendorwisecalldisposition', "Vendor wise Call Disposition Report", 'AOR_Reports');

    $module_menu[] = array('index.php?module=AOR_Reports&action=batchwisestatusdetailreport', "Lead connectivity report", 'AOR_Reports');
    $module_menu[] = array('index.php?module=AOR_Reports&action=utmstatusreport', "UTM Status Report", 'AOR_Reports');

    //$module_menu[] = array('index.php?module=AOR_Reports&action=dateleadperformance', "Till Date Lead Performance", 'AOR_Reports');
    //$module_menu[] = array('index.php?module=AOR_Reports&action=leadsfeedbackreport', "Leads Feedback Report", 'AOR_Reports');
    $module_menu[] = array('index.php?module=AOR_Reports&action=leadperformancereports', "Leads Performance Report", 'AOR_Reports');
    $module_menu[] = array('index.php?module=AOR_Reports&action=dailyuploadreport', "Upload Report", 'AOR_Reports');

    $module_menu[] = array('index.php?module=AOR_Reports&action=productivityform', "Create Target Report", 'AOR_Reports');
    $module_menu[] = array('index.php?module=AOR_Reports&action=agentproductivityreport', "Agent Productivity Report", 'AOR_Reports');

    //$module_menu[] = array('index.php?module=AOR_Reports&action=eloquacontacts', "Eloqua Contacts", 'AOR_Reports');
    //$module_menu[] = array('index.php?module=AOR_Reports&action=eloquaobjects', "Eloqua Objects", 'AOR_Reports');
    $module_menu[] = array('index.php?module=AOR_Reports&action=eloquareport', "Eloqua Report", 'AOR_Reports');

    if ($current_user->id == '5240d085-ec81-a57b-8619-590da1bba899' || $current_user->id == 'ede84399-71df-5962-1e68-590dd0a64b0e' || $current_user->id == 1 || $current_user->id == 'd81fc9e1-91ae-eba3-19d9-5af02415c81c' || $current_user->id == 'a790cb6d-961d-85ac-27d1-590d9dc00adc')
    {
        $module_menu[] = array('index.php?module=AOR_Reports&action=exportheaderwisereport', "Export Report By Headers", 'AOR_Reports');
    }
    
     $module_menu[] = array('index.php?module=AOR_Reports&action=counsellorwisecpacpl', "Counsellor wise CPA Report", 'AOR_Reports');
     $module_menu[] = array('index.php?module=AOR_Reports&action=addreportaccess', "Add Access report to users", 'AOR_Reports');
}
# SRM REPORTS #
if ($current_user->is_admin == 1 || $displayMis || $displaySRM || $displayDM)
{

    $module_menu[] = array('index.php?module=AOR_Reports&action=dropoutreport', "Dropout Report", 'AOR_Reports');
    //$module_menu[] = array('index.php?module=AOR_Reports&action=leadprofilingreport', "Lead Profiling Report", 'AOR_Reports');

    if ($current_user->is_admin == 1)
    {
        $module_menu[] = array('index.php?module=AOR_Reports&action=importlead', "Import Leads Data", 'AOR_Reports');
        $module_menu[] = array('index.php?module=AOR_Reports&action=targetupload', "Target Upload", 'AOR_Reports');
        $module_menu[] = array('index.php?module=AOR_Reports&action=actualupload', "Actual Upload", 'AOR_Reports');
        $module_menu[] = array('index.php?module=AOR_Reports&action=numbercorrectionspushtodialer', "Number Corrections Push to Dialer", 'AOR_Reports');
        $module_menu[] = array('index.php?module=AOR_Reports&action=uploadmarkwrongnumber', "Mark Wrong Number", 'AOR_Reports');
        $module_menu[] = array('index.php?module=AOR_Reports&action=mobilenumbercorrectionsdonotpush', "Number Corrections | DO NOT Push", 'AOR_Reports');
    }
    $module_menu[] = array('index.php?module=AOR_Reports&action=srmpaymentreceivedreport', "Payment Received Report", 'AOR_Reports');
    $module_menu[] = array('index.php?module=AOR_Reports&action=debtorreport', "Debtor Report", 'AOR_Reports');
    $module_menu[] = array('index.php?module=AOR_Reports&action=openingbalancereport', "GSV/Opening Balance Report", 'AOR_Reports');
    $module_menu[] = array('index.php?module=Leads&action=junkleadlog ', "Leads Snag List", 'AOR_Reports');
    $module_menu[] = array('index.php?module=AOR_Reports&action=summarised', "Summarised GSV", 'AOR_Reports');
    $module_menu[] = array('index.php?module=AOR_Reports&action=counsellorwisestatusdetailreport', "Counsellor Wise Status Detail Report_Create Date", 'AOR_Reports');
    $module_menu[] = array('index.php?module=AOR_Reports&action=counsellorwisestatusupdatedreport', "Counsellor Wise Status Detail Report_Modified Date", 'AOR_Reports');
    $module_menu[] = array('index.php?module=AOR_Reports&action=vendorwiseleadsource', "Vendor Wise Lead Source Report", 'AOR_Reports');
    $module_menu[] = array('index.php?module=AOR_Reports&action=srmstudentlist', "Student List Report", 'AOR_Reports');
    
}

if ($displayCCM)
{
    $module_menu[] = array('index.php?module=AOR_Reports&action=counsellorwisestatusdetailreport', "Counsellor Wise Status Detail Report_Create Date", 'AOR_Reports');
    $module_menu[] = array('index.php?module=AOR_Reports&action=counsellorwisestatusupdatedreport', "Counsellor Wise Status Detail Report_Modified Date", 'AOR_Reports');
}


?>

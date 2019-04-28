<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
/* * *******************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 * ****************************************************************************** */


require_once('include/EditView/EditView2.php');

/**
 * MassUpdate class for updating multiple records at once
 * @api
 */
class MassUpdate
{
    /*
     * internal sugarbean reference
     */

    var $sugarbean = null;

    /**
     * where clauses used to filter rows that have to be updated
     */
    var $where_clauses = '';
    public $report_to_id  = array();

    /**
     * set the sugar bean to its internal member
     * @param sugar bean reference
     */
    function setSugarBean($sugar)
    {
        $this->sugarbean = $sugar;
    }

    /**
     * get the massupdate form
     * @param bool boolean need to execute the massupdate form or not
     * @param multi_select_popup booleanif it is a multi-select value
     */
    function getDisplayMassUpdateForm($bool, $multi_select_popup = false)
    {

        require_once('include/formbase.php');

        if (!$multi_select_popup)
            $form = '<form action="index.php" method="post" name="displayMassUpdate" id="displayMassUpdate">' . "\n";
        else
            $form = '<form action="index.php" method="post" name="MassUpdate" id="MassUpdate">' . "\n";

        if ($bool)
        {
            $form .= '<input type="hidden" name="mu" value="false" />' . "\n";
        }
        else
        {
            $form .= '<input type="hidden" name="mu" value="true" />' . "\n";
        }

        $form .= getAnyToForm('mu', true);
        if (!$multi_select_popup)
            $form .= "</form>\n";

        return $form;
    }

    /**
     * returns the mass update's html form header
     * @param multi_select_popup boolean if it is a mult-select or not
     */
    function getMassUpdateFormHeader($multi_select_popup = false)
    {
        global $sugar_version;
        global $sugar_config;
        global $current_user;

        unset($_REQUEST['current_query_by_page']);
        unset($_REQUEST[session_name()]);
        unset($_REQUEST['PHPSESSID']);
        $query = json_encode($_REQUEST);

        $bean                  = loadBean($_REQUEST['module']);
        $order_by_name         = $bean->module_dir . '2_' . strtoupper($bean->object_name) . '_ORDER_BY';
        $lvso                  = isset($_REQUEST['lvso']) ? $_REQUEST['lvso'] : "";
        $request_order_by_name = isset($_REQUEST[$order_by_name]) ? $_REQUEST[$order_by_name] : "";
        $action                = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
        $module                = isset($_REQUEST['module']) ? $_REQUEST['module'] : "";
        if ($multi_select_popup)
            $tempString            = '';
        else
            $tempString            = "<form action='index.php' method='post' name='MassUpdate'  id='MassUpdate' onsubmit=\"return check_form('MassUpdate');\">\n"
                    . "<input type='hidden' name='return_action' value='{$action}' />\n"
                    . "<input type='hidden' name='return_module' value='{$module}' />\n"
                    . "<input type='hidden' name='massupdate' value='true' />\n"
                    . "<input type='hidden' name='delete' value='false' />\n"
                    . "<input type='hidden' name='merge' value='false' />\n"
                    . "<input type='hidden' name='current_query_by_page' value='{$query}' />\n"
                    . "<input type='hidden' name='module' value='{$module}' />\n"
                    . "<input type='hidden' name='action' value='MassUpdate' />\n"
                    . "<input type='hidden' name='lvso' value='{$lvso}' />\n"
                    . "<input type='hidden' name='{$order_by_name}' value='{$request_order_by_name}' />\n";

        // cn: bug 9103 - MU navigation in emails is broken
        if ($_REQUEST['module'] == 'Emails')
        {
            $type = "";
            // determine "type" - inbound, archive, etc.
            if (isset($_REQUEST['type']))
            {
                $type = $_REQUEST['type'];
            }
            // determine owner
            $tempString .= <<<eoq
				<input type='hidden' name='type' value="{$type}" />
				<input type='hidden' name='ie_assigned_user_id' value="{$current_user->id}" />
eoq;
        }

        return $tempString;
    }

    /**
     * Executes the massupdate form
     * @param displayname Name to display in the popup window
     * @param varname name of the variable
     */
    function handleMassUpdate()
    {

        require_once('include/formbase.php');
        global $current_user, $db, $disable_date_format, $timedate;
        $current_user_id = $current_user->id;
        foreach ($_POST as $post => $value)
        {
            if (is_array($value))
            {
                if (empty($value))
                {
                    unset($_POST[$post]);
                }
            }
            elseif (strlen($value) == 0)
            {
                if (isset($this->sugarbean->field_defs[$post]) && $this->sugarbean->field_defs[$post]['type'] == 'radioenum' && isset($_POST[$post]))
                {
                    $_POST[$post] = '';
                }
                else
                {
                    unset($_POST[$post]);
                }
            }

            if (is_string($value) && isset($this->sugarbean->field_defs[$post]))
            {
                if (($this->sugarbean->field_defs[$post]['type'] == 'bool' || (!empty($this->sugarbean->field_defs[$post]['custom_type']) && $this->sugarbean->field_defs[$post]['custom_type'] == 'bool'
                        )))
                {
                    if (strcmp($value, '2') == 0)
                        $_POST[$post] = 0;
                    if (!empty($this->sugarbean->field_defs[$post]['dbType']) && strcmp($this->sugarbean->field_defs[$post]['dbType'], 'varchar') == 0)
                    {
                        if (strcmp($value, '1') == 0)
                            $_POST[$post] = 'on';
                        if (strcmp($value, '2') == 0)
                            $_POST[$post] = 'off';
                    }
                }

                if (($this->sugarbean->field_defs[$post]['type'] == 'radioenum' && isset($_POST[$post]) && strlen($value) == 0) || ($this->sugarbean->field_defs[$post]['type'] == 'enum' && $value == '__SugarMassUpdateClearField__') // Set to '' if it's an explicit clear
                )
                {
                    $_POST[$post] = '';
                }
                if ($this->sugarbean->field_defs[$post]['type'] == 'bool')
                {
                    $this->checkClearField($post, $value);
                }
                if ($this->sugarbean->field_defs[$post]['type'] == 'date' && !empty($_POST[$post]))
                {
                    $_POST[$post] = $timedate->to_db_date($_POST[$post], false);
                }
                if ($this->sugarbean->field_defs[$post]['type'] == 'datetime' && !empty($_POST[$post]))
                {
                    $_POST[$post] = $timedate->to_db($this->date_to_dateTime($post, $value));
                }
                if ($this->sugarbean->field_defs[$post]['type'] == 'datetimecombo' && !empty($_POST[$post]))
                {
                    $_POST[$post] = $timedate->to_db($_POST[$post]);
                }
            }
        }

        //We need to disable_date_format so that date values for the beans remain in database format
        //notice we make this call after the above section since the calls to TimeDate class there could wind up
        //making it's way to the UserPreferences objects in which case we want to enable the global date formatting
        //to correctly retrieve the user's date format preferences
        $old_value           = $disable_date_format;
        $disable_date_format = true;

        //echo '<pre>ssss'; print_r($_REQUEST); die;
        if (!empty($_REQUEST['uid']))
            $_POST['mass'] = explode(',', $_REQUEST['uid']); // coming from listview


        elseif (isset($_REQUEST['entire']) && empty($_POST['mass']))
        {

            if (isset($_REQUEST['current_query_by_page']) && strtolower($_REQUEST['module']) == 'leads')
            {


                $jsonText              = $_REQUEST['current_query_by_page'];
                $decodedText           = html_entity_decode($jsonText);
                $myArray               = json_decode($decodedText, true);
                $Counsellors_advanced  = $myArray['Counsellors_advanced']; // done
                $batch_advanced        = $myArray['batch_advanced'];       // done
                $email_advanced        = $myArray['email_advanced'];
                $phone_mobile_advanced = $myArray['phone_mobile_advanced'];

                $date_entered_advanced_range_choice = $myArray['date_entered_advanced_range_choice']; // need not to add
                $range_date_entered_advanced        = $myArray['range_date_entered_advanced'];

                $start_range_date_entered_advanced = $myArray['start_range_date_entered_advanced'];
                $end_range_date_entered_advanced   = $myArray['end_range_date_entered_advanced'];


                $status_advanced             = $myArray['status_advanced'];
                $status_description_advanced = $myArray['status_description_advanced'];
                $lead_source_advanced        = $myArray['lead_source_advanced'];
                $vendor_list_advanced        = $myArray['vendor_list_advanced'];



                $Counsellorstring = array();
                $Batchstring      = array();
                $wherecl          = '';
                //$Counsellorstring    = implode("','", $Counsellors_advanced);
                //$Batchstring         = implode("','", $batch_advanced);
                if (!empty($status_advanced))
                {
                    $wherecl .= " AND  l.status IN ('" . implode("','", $status_advanced) . "')";
                }
                if (!empty($status_description_advanced))
                {
                    $wherecl .= " AND  l.status_description IN ('" . implode("','", $status_description_advanced) . "')";
                }

                if (!empty($start_range_date_entered_advanced))
                {
                    $date1   = str_replace('/', '-', $start_range_date_entered_advanced);
                    $wherecl .= " AND  l.date_entered  >= '" . date('Y-m-d', strtotime($date1)) . "'";
                }
                if (!empty($end_range_date_entered_advanced))
                {
                    $date2   = str_replace('/', '-', $end_range_date_entered_advanced);
                    $wherecl .= " AND  l.date_entered  <= '" . date('Y-m-d', strtotime($date2)) . "'";
                }

                if (!empty($range_date_entered_advanced))
                {
                    $date3   = str_replace('/', '-', $range_date_entered_advanced);
                    $wherecl .= " AND  l.date_entered  = '" . date('Y-m-d', strtotime($date3)) . "'";
                }




                if (!empty($Counsellors_advanced))
                {

                    $wherecl .= " AND  l.assigned_user_id IN ('" . implode("','", $Counsellors_advanced) . "')";
                }


                if (!empty($batch_advanced))
                {

                    $wherecl .= " AND  lc.te_ba_batch_id_c IN ('" . implode("','", $batch_advanced) . "')";
                }

                if (!empty($lead_source_advanced))
                {

                    $wherecl .= " AND  l.lead_source IN ('" . implode("','", $lead_source_advanced) . "')";
                }
                if (!empty($vendor_list_advanced))
                {

                    $wherecl .= " AND  l.vendor IN ('" . implode("','", $vendor_list_advanced) . "')";
                }


                $leadSql = "SELECT 
                    l.id
                FROM leads l
                INNER JOIN leads_cstm AS lc ON l.id=lc.id_c
                 WHERE l.deleted=0
                   $wherecl
               order by  l.date_entered ";


                //echo '<pre>';
                //print_r($leadSql);
                //die;
            }
            else
            {
                $this->report_to_id[] = $current_user->id;
                $module_name          = strtolower($_REQUEST['module']);
                $users_arr            = $this->reportingUser($current_user->id);
                $users                = implode("','", $this->report_to_id);

                if ($users)
                {
                    $where_clauses = explode(' ) AND ( ', $this->where_clauses);
                    if ($current_user->is_admin == 1)
                    {
                        array_push($where_clauses, "($module_name.assigned_user_id in ('" . $users . "')) OR ($module_name.assigned_user_id IS NULL) OR (TRIM($module_name.assigned_user_id)='') OR (TRIM($module_name.assigned_user_id)='NULL') ");
                    }
                    else
                    {
                        array_push($where_clauses, "$module_name.assigned_user_id in ('" . $users . "')");
                    }

                    $where_clauses = array_filter($where_clauses);
                    if ($where_clauses)
                    {
                        $this->where_clauses = '(' . implode(' ) AND ( ', $where_clauses) . ')';
                    }
                }
                $query = $this->sugarbean->create_new_list_query($order_by, $this->where_clauses, array(), array(), 0, '', false, $this, true, true);
            }

            //            if (isset($_REQUEST['module']) && strtolower($_REQUEST['module']) == 'leads')
            //            {
            //                $this->where_clauses = str_replace('leads.batch in', 'leads_cstm.te_ba_batch_id_c in', $this->where_clauses);
            //                $this->where_clauses = str_replace('Counsellors', 'leads.assigned_user_id', $this->where_clauses);
            //            }

            $result  = $db->query($leadSql, true);
            $new_arr = array();
            while ($val     = $db->fetchByAssoc($result, false))
            {

                array_push($new_arr, $val['id']);
            }
            $_POST['mass'] = $new_arr;


            //echo '<pre>';
            //print_r($_POST['mass']);
            //die;
        }

        if (isset($_POST['mass']) && is_array($_POST['mass']) && $_REQUEST['massupdate'] == 'true')
        {

            if (isset($_POST['Delete']))
            {
                $this->sugarbean->retrieve($id);
                if ($this->sugarbean->ACLAccess('Delete'))
                {
                    $this->sugarbean->mark_deleted($id);
                }
            }
            else
            {

                $count = 0;
               
                 
                $assigned_user_id   = $_REQUEST['assigned_user_id'];
                $statusX            = $_REQUEST['status'];
                $statusDescriptionX = $_REQUEST['status_description'];
                $leadList           = $_POST['mass'];
                $error_fields       = [];

                if (!isset($assigned_user_id) || empty($assigned_user_id))
                {
                    $error_fields['assigned_user_id'] = ['assigned_user_id field is required.'];
                }
                if (!isset($leadList) || empty($leadList))
                {
                    $error_fields['leadList'] = ['Lead list is required.'];
                }

                if ($error_fields)
                {
                    $response_result = array('status' => '400', 'result' => $error_fields);
                    $statusx         = json_encode($response_result);
                    echo "<script type=\"text/javascript\">
                                                         alert('$statusx');
                                                         window.location = \"index.php?module=Leads&action=index\"
                                                 </script>";
                }

                if (!empty($assigned_user_id) && !empty($leadList))
                {

                    //echo '<pre>';print_r($_REQUEST);print_r(partition($leadList, count($assigned_user_id))); die;

                    $finalarray = array();
                    $finalx     = $this->partition($leadList, count($assigned_user_id));


                    //echo '<pre>'; print_r($finalx);die;
                    foreach ($assigned_user_id as $key => $val)
                    {
                        $finalarray[$val] = $finalx[$key];
                    }

                    //echo '<pre>'; print_r($finalarray);die;
                    if (!empty($finalarray))
                    {   
                        $records        = $db->fetchByAssoc($res);
                        $assignSQL   = '';
                        $dispoSQL    = "INSERT INTO `te_disposition` (`id`, `status`,`status_detail`,`date_modified`,`date_entered`,`modified_user_id`,`created_by`,`assigned_user_id`) VALUES ";
                        $dispoRelSQL = "INSERT INTO `te_disposition_leads_c` (`id`, `te_disposition_leadste_disposition_idb`,`te_disposition_leadsleads_ida`,`date_modified`) VALUES ";
                        foreach ($finalarray as $assignedUser => $lead_list)
                        {
                            if (!empty($assignedUser) || !empty($lead_list))
                            {

                                $string    = implode("','", $lead_list);
                                $assignSQL = "update leads set assigned_user_id='$assignedUser',status='$statusX',status_description='$statusDescriptionX',modified_user_id='$current_user_id',date_modified='" . date('Y-m-d H:i:s') . "' where id in ('$string');";

                                //echo '<pre>'; print_r($lead_list);
                                if (!empty($statusDescriptionX) or !empty($statusX)){
                                $query = $db->query($assignSQL);
                                }
                                $i     = 1;
                                foreach ($lead_list as $key => $leadID)
                                {
                                    //echo $leadID . '<br>';
                                    $guidid      = create_guid();
                                    $guidid2     = create_guid();
                                    $dispoSQL    .= "('$guidid','$statusX','$statusDescriptionX','" . date('Y-m-d H:i:s') . "','" . date('Y-m-d H:i:s') . "','$current_user_id','$current_user_id','$assignedUser'),";
                                    $dispoRelSQL .= "('$guidid2','$guidid','$leadID','" . date('Y-m-d H:i:s') . "'),";
                                    
                                    if (empty($statusDescriptionX) or empty($statusX))
                                    {
                                        $sql               = "select status,status_description from leads where id='$leadID'";
                                        $LeadRecordrecords = $db->fetchByAssoc($db->query($sql));
                                        $assignStatusSQL = "update leads set assigned_user_id='$assignedUser',status='".$LeadRecordrecords['status']."',status_description='".$LeadRecordrecords['status_description']."',modified_user_id='$current_user_id',date_modified='" . date('Y-m-d H:i:s') . "' where id='$leadID'";
                                        $query = $db->query($assignStatusSQL);
                                    }

                                    $i++;
                                }
                            }
                        }
                        $exeSql    = rtrim($dispoSQL, ',');
                        $disExeSql = rtrim($dispoRelSQL, ',');

                        if ($i > 1)
                        {
                            //echo $exeSql.'xx='.$disExeSql;print_r($finalarray);die;

                            $db->query($exeSql);
                            $db->query($disExeSql);
                        }
                    }

                    //echo $assignSQL; die;
                    //$db->query($assignSQL);
                    //echo '<pre>';
                    //print_r($finalarray);
                    //die;
                }
            }
        }
        $disable_date_format = $old_value;
    }

    /**
     * split the array in chunks
     */
    function partition(Array $list, $p)
    {
        $listlen   = count($list);
        $partlen   = floor($listlen / $p);
        $partrem   = $listlen % $p;
        $partition = array();
        $mark      = 0;
        for ($px = 0; $px < $p; $px ++)
        {
            $incr           = ($px < $partrem) ? $partlen + 1 : $partlen;
            $partition[$px] = array_slice($list, $mark, $incr);
            $mark           += $incr;
        }
        return $partition;
    }

    /**
     * Displays the massupdate form
     */
    function getMassUpdateForm(
    $hideDeleteIfNoFieldsAvailable = false
    )
    {
        global $app_strings;
        global $current_user;
        
        $getRoleSlug = getUsersRole();
        $usersRole   = ''; //Contact Center Counselor 
        $usersRole   = !empty($getRoleSlug[$current_user->id]['role_name']) ? $getRoleSlug[$current_user->id]['role_name'] : 'NA';
        
        if ($this->sugarbean->bean_implements('ACL') && (!ACLController::checkAccess($this->sugarbean->module_dir, 'edit', true) || !ACLController::checkAccess($this->sugarbean->module_dir, 'massupdate', true) ))
        {
            return '';
        }

        $lang_delete              = translate('LBL_DELETE');
        $lang_update              = translate('LBL_UPDATE');
        $lang_confirm             = translate('NTC_DELETE_CONFIRMATION_MULTIPLE');
        $lang_sync                = translate('LBL_SYNC_CONTACT');
        $lang_oc_status           = translate('LBL_OC_STATUS');
        $lang_unsync              = translate('LBL_UNSYNC');
        $lang_archive             = translate('LBL_ARCHIVE');
        $lang_optout_primaryemail = $app_strings['LBL_OPT_OUT_FLAG_PRIMARY'];

        $field_count = 0;

        $html = "<div id='massupdate_form' style='display:none;'><table width='100%' cellpadding='0' cellspacing='0' border='0' class='formHeader h3Row'><tr><td nowrap><h3><span>" . $app_strings['LBL_MASS_UPDATE'] . "</h3></td></tr></table>";
        $html .= "<div id='mass_update_div'><table cellpadding='0' cellspacing='1' border='0' width='100%' class='edit view' id='mass_update_table'>";

        $even = true;

        if ($this->sugarbean->object_name == 'Contact')
        {
            $html .= "<tr><td width='15%' scope='row'>$lang_sync</td><td width='35%' class='dataField'><select name='Sync'><option value=''>{$GLOBALS['app_strings']['LBL_NONE']}</option><option value='false'>{$GLOBALS['app_list_strings']['checkbox_dom']['2']}</option><option value='true'>{$GLOBALS['app_list_strings']['checkbox_dom']['1']}</option></select></td>";
            $even = false;
        }
        else if ($this->sugarbean->object_name == 'Employee')
        {
            $this->sugarbean->field_defs['employee_status']['type']       = 'enum';
            $this->sugarbean->field_defs['employee_status']['massupdate'] = true;
            $this->sugarbean->field_defs['employee_status']['options']    = 'employee_status_dom';
        }
        else if ($this->sugarbean->object_name == 'InboundEmail')
        {
            $this->sugarbean->field_defs['status']['type']    = 'enum';
            $this->sugarbean->field_defs['status']['options'] = 'user_status_dom';
        }

        //These fields should never appear on mass update form
        static $banned = array('date_modified' => 1, 'date_entered' => 1, 'created_by' => 1, 'modified_user_id' => 1, 'deleted' => 1, 'modified_by_name' => 1,);

        foreach ($this->sugarbean->field_defs as $field)
        {
            if (!isset($banned[$field['name']]) && (!isset($field['massupdate']) || !empty($field['massupdate'])))
            {
                $newhtml = '';

                if ($even)
                {
                    $newhtml .= "<tr>";
                }

                if (isset($field['vname']))
                {
                    $displayname = translate($field['vname']);
                }
                else
                {
                    $displayname = '';
                }

                if (isset($field['type']) && $field['type'] == 'relate' && isset($field['id_name']) && $field['id_name'] == 'assigned_user_id')
                {
                    $field['type'] = 'assigned_user_name';
                }

                if (isset($field['custom_type']))
                {
                    $field['type'] = $field['custom_type'];
                }

                if (isset($field['type']))
                {
                    switch ($field["type"])
                    {
                        case "relate":
                            // bug 14691: avoid laying out an empty cell in the <table>
                            $handleRelationship = $this->handleRelationship($displayname, $field);
                            if ($handleRelationship != '')
                            {
                                $even    = !$even;
                                $newhtml .= $handleRelationship;
                            }
                            break;
                        case "parent":$even    = !$even;
                            $newhtml .= $this->addParent($displayname, $field);
                            break;
                        case "int":
                            if (!empty($field['massupdate']) && empty($field['auto_increment']))
                            {
                                $even    = !$even;
                                $newhtml .= $this->addInputType($displayname, $field);
                            }
                            break;
                        case "contact_id":$even    = !$even;
                            $newhtml .= $this->addContactID($displayname, $field["name"]);
                            break;
                        case "assigned_user_name":$even    = !$even;
                            $newhtml .= $this->addAssignedUserID($displayname, $field["name"]);
                            break;
                        case "account_id":$even    = !$even;
                            $newhtml .= $this->addAccountID($displayname, $field["name"]);
                            break;
                        case "account_name":$even    = !$even;
                            $newhtml .= $this->addAccountID($displayname, $field["id_name"]);
                            break;
                        case "bool": $even    = !$even;
                            $newhtml .= $this->addBool($displayname, $field["name"]);
                            break;
                        case "enum":
                        case "multienum":
                            if (!empty($field['isMultiSelect']))
                            {
                                $even    = !$even;
                                $newhtml .= $this->addStatusMulti($displayname, $field["name"], translate($field["options"]));
                                break;
                            }
                            else if (!empty($field['options']))
                            {
                                $even    = !$even;
                                $newhtml .= $this->addStatus($displayname, $field["name"], translate($field["options"]));
                                break;
                            }
                            else if (!empty($field['function']))
                            {
                                $functionValue = $this->getFunctionValue($this->sugarbean, $field);
                                $even          = !$even;
                                $newhtml       .= $this->addStatus($displayname, $field["name"], $functionValue);
                                break;
                            }
                            break;
                        case "radioenum":
                            $even    = !$even;
                            $newhtml .= $this->addRadioenum($displayname, $field["name"], translate($field["options"]));
                            break;
                        case "datetimecombo":
                            $even    = !$even;
                            $newhtml .= $this->addDatetime($displayname, $field["name"]);
                            break;
                        case "datetime":
                        case "date":$even    = !$even;
                            $newhtml .= $this->addDate($displayname, $field["name"]);
                            break;
                        default:
                            $newhtml .= $this->addDefault($displayname, $field, $even);
                            break;
                            break;
                    }
                }

                if ($even)
                {
                    $newhtml .= "</tr>";
                }

                $field_count++;

                if (!in_array($newhtml, array('<tr>', '</tr>', '<tr></tr>', '<tr><td></td></tr>')))
                {
                    $html .= $newhtml;
                }
            }
        }


        if ($this->sugarbean->object_name == 'Contact' ||
                $this->sugarbean->object_name == 'Account' ||
                $this->sugarbean->object_name == 'Prospect')
        {

            $html .= "<tr><td width='15%'  scope='row' class='dataLabel'>$lang_optout_primaryemail</td><td width='35%' class='dataField'><select name='optout_primary'><option value=''>{$GLOBALS['app_strings']['LBL_NONE']}</option><option value='false'>{$GLOBALS['app_list_strings']['checkbox_dom']['2']}</option><option value='true'>{$GLOBALS['app_list_strings']['checkbox_dom']['1']}</option></select></td></tr>";
        }
        $html .= "</table>";

        if ($this->sugarbean->object_name == 'Lead')
        {
            $html .= '<style>#converted_datejscal_field{display:none}</style>';
            $html .= '<script>var role_name = "'.$usersRole.'"</script>';
            $html .= <<<EOJS
<script>
              

                   
  
 
   $(document).ready(function () {


   $("#mass_assigned_user_id").closest('tr').children('td:first').html("<span id='massUpdate_level'>Counsellors</span>");
   $("#mass_vendor_list").closest('tr').children('td:nth-child(3)').html("<span id='massVendor_level'>Vendors</span>");
  $("#mass_lead_source_types").parents("tr").children("td:nth-child(3)").html("<span id='massUpdate_level'>Lead Source Type</span>");
                    
    });
           

                    
var option = document.getElementById("mass_status").options;
var status_detail = document.getElementById('mass_status_description').value;
$("#mass_status option[value='Converted']").hide();
$("#mass_status option[value='Dropout']").hide();
$("#mass_status_description option").remove() ;

$('#mass_batch').parent().css('display','none');
$('#mass_Counsellors').parent().css('display','none')
$('#converted_datejscal_field').parent().css('display','none');
$('#mass_country_log').parent().parent().css('display','none');                 
$('#mass_assigned_mass_user_id').parent().css('display','none');  
$('#mass_disposition_reason').parent().css('display','none');   
$('#mass_vendor_list').parent().css('display','none'); 
$("#mass_disposition_reason").closest('tr').children('td:nth-child(3)').html("");  
$("#mass_vendor_list").closest('tr').children('td:nth-child(3)').html("");
     
$("#mass_assigned_user_name").closest('tr').children('td:nth-child(2)').html("<select id='mass_assigned_user_name'>"+$('#mass_assigned_mass_user_id').html()+"</select>");
    
$('#mass_assigned_user_name').addClass('multiselbox');
$('#mass_assigned_user_name').attr('multiple','multiple');
$('#mass_assigned_user_name').attr('name', 'assigned_user_id[]');

//alert(role_name);
if(role_name=="Contact Center Counselor"){
$('#mass_assigned_user_name').parent().css('display','none'); 
$('#mass_status').parent().css('display','none'); 
$('#mass_status_description').parent().css('display','none'); 
    }
 $("body").on('change','#mass_status',function() {

	var el = $(this) ;

	if(el.val() === "Alive" ) {
		$("#mass_status_description option").remove() ;

		$("#mass_status_description").append('<option value="Call Back">Call Back</option><option value="Follow Up">Follow Up</option><option value="New Lead">New Lead</option>');
	}
	else if(el.val() === "Dead" ) {
		$("#mass_status_description option").remove() ;

		$("#mass_status_description").append('<option value="Dead Number">Dead Number</option>');
		$("#mass_status_description").append('<option value="Wrong Number">Wrong Number</option>');
		$("#mass_status_description").append('<option value="Ringing Multiple Times">Ringing Multiple Times</option>');
		$("#mass_status_description").append('<option value="Not Enquired">Not Enquired</option>');
		$("#mass_status_description").append('<option value="Not Eligible">Not Eligible</option>');
		$("#mass_status_description").append('<option value="Rejected">Rejected</option>');
		$("#mass_status_description").append('<option value="Fallout">Fallout</option>');
		$("#mass_status_description").append('<option value="Retired">Retired</option>');
	}
	else if(el.val() === "Converted" ) {
		$("#mass_status_description option").remove() ;

		 $("#mass_status_description").append('<option>Converted</option>');
	}
	else if(el.val() === "Duplicate" ) {
		$("#mass_status_description option").remove() ;

		 $("#mass_status_description").append('<option value="Duplicate">Duplicate</option>');
	}
	else if(el.val() === "Warm" ) {
		$("#mass_status_description option").remove() ;

		 $("#mass_status_description").append('<option value="Re-Enquired">Re-Enquired</option><option value="Prospect">Prospect</option>');

	}
	else if(el.val() === "Dropout" ) {
		$("#mass_status_description option").remove() ;

		 $("#mass_status_description").append('<option>Dropout</option>');
	}
        else if(el.val() === "Recycle" ) {
		$("#mass_status_description option").remove() ;

		 $("#mass_status_description").append('<option>Recycle</option>');
	}
  });
</script>
EOJS;
        }

        $html .= "<table cellpadding='0' cellspacing='0' border='0' width='100%'><tr><td class='buttons'><input onclick='return sListView.send_mass_update(\"selected\", \"{$app_strings['LBL_LISTVIEW_NO_SELECTED']}\")' type='submit' id='update_button' name='Update' value='{$lang_update}' class='button'>&nbsp;<input onclick='javascript:toggleMassUpdateForm();' type='button' id='cancel_button' name='Cancel' value='{$GLOBALS['app_strings']['LBL_CANCEL_BUTTON_LABEL']}' class='button'>";
        // TODO: allow ACL access for Delete to be set false always for users
//		if($this->sugarbean->ACLAccess('Delete', true) && $this->sugarbean->object_name != 'User') {
//			global $app_list_strings;
//			$html .=" <input id='delete_button' type='submit' name='Delete' value='{$lang_delete}' onclick='return confirm(\"{$lang_confirm}\") && sListView.send_mass_update(\"selected\", \"{$app_strings['LBL_LISTVIEW_NO_SELECTED']}\", 1)' class='button'>";
//		}
        // only for My Inbox views - to allow CSRs to have an "Archive" emails feature to get the email "out" of their inbox.
        if ($this->sugarbean->object_name == 'Email' && (isset($_REQUEST['assigned_user_id']) && !empty($_REQUEST['assigned_user_id'])) && (isset($_REQUEST['type']) && !empty($_REQUEST['type']) && $_REQUEST['type'] == 'inbound'))
        {
            $html .= <<<eoq
			<input type='button' name='archive' value="{$lang_archive}" class='button' onClick='setArchived();'>
			<input type='hidden' name='ie_assigned_user_id' value="{$current_user->id}">
			<input type='hidden' name='ie_type' value="inbound">
eoq;
        }

        $html .= "</td></tr></table></div></div>";

        $html .= <<<EOJS
<script>
function toggleMassUpdateForm(){
    document.getElementById('massupdate_form').style.display = 'none';
}
</script>
EOJS;

        if ($field_count > 0)
        {
            return $html;
        }
        else
        {
            //If no fields are found, render either a form that still permits Mass Update deletes or just display a message that no fields are available
            $html = "<div id='massupdate_form' style='display:none;'><table width='100%' cellpadding='0' cellspacing='0' border='0' class='formHeader h3Row'><tr><td nowrap><h3><span>" . $app_strings['LBL_MASS_UPDATE'] . "</h3></td></tr></table>";
            if ($this->sugarbean->ACLAccess('Delete', true) && !$hideDeleteIfNoFieldsAvailable)
            {
                $html .= "<table cellpadding='0' cellspacing='0' border='0' width='100%'><tr><td><input type='submit' name='Delete' value='$lang_delete' onclick=\"return confirm('{$lang_confirm}')\" class='button'></td></tr></table></div>";
            }
            else
            {
                $html .= $app_strings['LBL_NO_MASS_UPDATE_FIELDS_AVAILABLE'] . "</div>";
            }
            return $html;
        }
    }

    function getFunctionValue($focus, $vardef)
    {
        $function = $vardef['function'];
        if (is_array($function) && isset($function['name']))
        {
            $function = $vardef['function']['name'];
        }
        else
        {
            $function = $vardef['function'];
        }
        if (!empty($vardef['function']['returns']) && $vardef['function']['returns'] == 'html')
        {
            if (!empty($vardef['function']['include']))
            {
                require_once($vardef['function']['include']);
            }
            return call_user_func($function, $focus, $vardef['name'], '', 'MassUpdate');
        }
        else
        {
            return call_user_func($function, $focus, $vardef['name'], '', 'MassUpdate');
        }
    }

    /**
     * Returns end of the massupdate form
     */
    function endMassUpdateForm()
    {
        return '</form>';
    }

    /**
     * Decides which popup HTML code is needed for mass updating
     * @param displayname Name to display in the popup window
     * @param field name of the field to update
     */
    function handleRelationship($displayname, $field)
    {
        $ret_val = '';
        if (isset($field['module']))
        {
            if ($field['name'] == 'reports_to_name' && ($field['module'] == 'Users' || $field['module'] == 'Employee'))
                return $this->addUserName($displayname, $field['name'], $field['id_name'], $field['module']);

            switch ($field['module'])
            {
                case 'Accounts':
                    $ret_val = $this->addAccountID($displayname, $field['name'], $field['id_name']);
                    break;
                case 'Contacts':
                    $ret_val = $this->addGenericModuleID($displayname, $field['name'], $field['id_name'], "Contacts");
                    break;
                case 'Users':
                    $ret_val = $this->addGenericModuleID($displayname, $field['name'], $field['id_name'], "Users");
                    break;
                case 'Employee':
                    $ret_val = $this->addGenericModuleID($displayname, $field['name'], $field['id_name'], "Employee");
                    break;
                case 'Releases':
                    $ret_val = $this->addGenericModuleID($displayname, $field['name'], $field['id_name'], "Releases");
                    break;
                default:
                    if (!empty($field['massupdate']))
                    {
                        $ret_val = $this->addGenericModuleID($displayname, $field['name'], $field['id_name'], $field['module']);
                    }
                    break;
            }
        }

        return $ret_val;
    }

    /**
     * Add a parent selection popup window
     * @param displayname Name to display in the popup window
     * @param field_name name of the field
     */
    function addParent($displayname, $field)
    {
        global $app_strings, $app_list_strings;

        ///////////////////////////////////////
        ///
        /// SETUP POPUP

        $popup_request_data = array(
            'call_back_function'  => 'set_return',
            'form_name'           => 'MassUpdate',
            'field_to_name_array' => array(
                'id'   => "parent_id",
                'name' => "parent_name",
            ),
        );

        $json                       = getJSONobj();
        $encoded_popup_request_data = $json->encode($popup_request_data);

        $qsName = array(
            'form'          => 'MassUpdate',
            'method'        => 'query',
            'modules'       => array("Accounts"),
            'group'         => 'or',
            'field_list'    => array('name', 'id'),
            'populate_list' => array("mass_parent_name", "mass_parent_id"),
            'conditions'    => array(array('name' => 'name', 'op' => 'like_custom', 'end' => '%', 'value' => '')),
            'limit'         => '30', 'no_match_text' => $app_strings['ERR_SQS_NO_MATCH']);
        $qsName = $json->encode($qsName);

        //
        ///////////////////////////////////////

        $change_parent_button  = "<span class='id-ff'><button title='" . $app_strings['LBL_SELECT_BUTTON_TITLE'] . "'  type='button' class='button' value='" . $app_strings['LBL_SELECT_BUTTON_LABEL']
                . "' name='button_parent_name' onclick='open_popup(document.MassUpdate.{$field['type_name']}.value, 600, 400, \"\", true, false, {$encoded_popup_request_data});'>
			" . SugarThemeRegistry::current()->getImage("id-ff-select", '', null, null, ".png", $app_strings['LBL_ID_FF_SELECT']) . "
			</button></span>";
        $parent_type           = $field['parent_type'];
        $parent_types          = $app_list_strings[$parent_type];
        $disabled_parent_types = ACLController::disabledModuleList($parent_types, false, 'list');
        foreach ($disabled_parent_types as $disabled_parent_type)
        {
            unset($parent_types[$disabled_parent_type]);
        }
        $types   = get_select_options_with_id($parent_types, '');
        //BS Fix Bug 17110
        $pattern = "/\n<OPTION.*" . $app_strings['LBL_NONE'] . "<\/OPTION>/";
        $types   = preg_replace($pattern, "", $types);
        // End Fix

        $json                  = getJSONobj();
        $disabled_parent_types = $json->encode($disabled_parent_types);

        return <<<EOHTML
<td width="15%" scope="row">{$displayname} </td>
<td>
    <table width='100%' border='0' cellspacing='0' cellpadding='0'>
    <tr>
        <td valign='top'>
            <select name='{$field['type_name']}' id='mass_{$field['type_name']}'>
                $types
            </select>
        </td>
        <td valign='top'>
			<input name='{$field['id_name']}' id='mass_{$field['id_name']}' type='hidden' value=''>
			<input name='parent_name' id='mass_parent_name' class='sqsEnabled' autocomplete='off'
                type='text' value=''>
            $change_parent_button
        </td>
    </tr>
    </table>
</td>
<script type="text/javascript">
<!--
var disabledModules='{$disabled_parent_types}';
if(typeof sqs_objects == 'undefined'){
    var sqs_objects = new Array;
}
sqs_objects['MassUpdate_parent_name'] = $qsName;
registerSingleSmartInputListener(document.getElementById('mass_parent_name'));
addToValidateBinaryDependency('MassUpdate', 'parent_name', 'alpha', false, '{$app_strings['ERR_SQS_NO_MATCH_FIELD']} {$app_strings['LBL_ASSIGNED_TO']}','parent_id');

document.getElementById('mass_{$field['type_name']}').onchange = function()
{
    document.MassUpdate.parent_name.value="";
    document.MassUpdate.parent_id.value="";

	new_module = document.forms["MassUpdate"].elements["parent_type"].value;

	if(typeof(disabledModules[new_module]) != 'undefined') {
		sqs_objects["MassUpdate_parent_name"]["disable"] = true;
		document.forms["MassUpdate"].elements["parent_name"].readOnly = true;
	} else {
		sqs_objects["MassUpdate_parent_name"]["disable"] = false;
		document.forms["MassUpdate"].elements["parent_name"].readOnly = false;
	}
	sqs_objects["MassUpdate_parent_name"]["modules"] = new Array(new_module);
    enableQS(false);

    checkParentType(document.MassUpdate.parent_type.value, document.MassUpdate.button_parent_name);
}
-->
</script>
EOHTML;
    }

    /**
     * Add a generic input type='text' field
     * @param displayname Name to display in the popup window
     * @param field_name name of the field
     */
    function addInputType($displayname, $varname)
    {
        //letrium ltd
        $displayname = addslashes($displayname);
        $html        = <<<EOQ
	<td scope="row" width="20%">$displayname</td>
	<td class='dataField' width="30%"><input type="text" name='$varname' size="12" id='{$varname}' maxlength='10' value=""></td>
	<script> addToValidate('MassUpdate','$varname','int',false,'$displayname');</script>
EOQ;
        return $html;
    }

    /**
     * Add a generic widget to lookup Users.
     * @param displayname Name to display in the popup window
     * @param varname name of the variable
     * @param id_name name of the id in vardef
     * @param mod_type name of the module, either "Contact" or "Releases" currently
     */
    function addUserName($displayname, $varname, $id_name = '', $mod_type)
    {
        global $app_strings;

        if (empty($id_name))
            $id_name = strtolower($mod_type) . "_id";

        ///////////////////////////////////////
        ///
        /// SETUP POPUP
        $reportsDisplayName = showFullName() ? 'name' : 'user_name';
        $popup_request_data = array(
            'call_back_function'  => 'set_return',
            'form_name'           => 'MassUpdate',
            'field_to_name_array' => array(
                'id'                  => "{$id_name}",
                "$reportsDisplayName" => "{$varname}",
            ),
        );

        $json                       = getJSONobj();
        $encoded_popup_request_data = $json->encode($popup_request_data);

        $qsName = array(
            'form'          => 'MassUpdate',
            'method'        => 'get_user_array',
            'modules'       => array("{$mod_type}"),
            'group'         => 'or',
            'field_list'    => array('user_name', 'id'),
            'populate_list' => array("mass_{$varname}", "mass_{$id_name}"),
            'conditions'    => array(array('name' => 'name', 'op' => 'like_custom', 'end' => '%', 'value' => '')),
            'limit'         => '30', 'no_match_text' => $app_strings['ERR_SQS_NO_MATCH']);
        $qsName = $json->encode($qsName);
        //
        ///////////////////////////////////////

        return <<<EOHTML
<td width='15%'  scope='row' class='dataLabel'>$displayname</td>
<td width='35%' class='dataField'>
    <input name='{$varname}' id='mass_{$varname}' class='sqsEnabled' autocomplete='off' type='text' value=''>
    <input name='{$id_name}' id='mass_{$id_name}' type='hidden' value=''>&nbsp;
    <input title='{$app_strings['LBL_SELECT_BUTTON_TITLE']}'
        type='button' class='button' value='{$app_strings['LBL_SELECT_BUTTON_LABEL']}' name='button'
        onclick='open_popup("$mod_type", 600, 400, "", true, false, {$encoded_popup_request_data});'
        />
</td>
<script type="text/javascript">
<!--
if(typeof sqs_objects == 'undefined'){
    var sqs_objects = new Array;
}
sqs_objects['MassUpdate_{$varname}'] = $qsName;
registerSingleSmartInputListener(document.getElementById('mass_{$varname}'));
addToValidateBinaryDependency('MassUpdate', '{$varname}', 'alpha', false, '{$app_strings['ERR_SQS_NO_MATCH_FIELD']} {$app_strings['LBL_ASSIGNED_TO']}','{$id_name}');
-->
</script>
EOHTML;
    }

    /**
     * Add a generic module popup selection popup window HTML code.
     * Currently supports Contact and Releases
     * @param displayname Name to display in the popup window
     * @param varname name of the variable
     * @param id_name name of the id in vardef
     * @param mod_type name of the module, either "Contact" or "Releases" currently
     */
    function addGenericModuleID($displayname, $varname, $id_name = '', $mod_type)
    {
        global $app_strings;

        if (empty($id_name))
            $id_name = strtolower($mod_type) . "_id";

        ///////////////////////////////////////
        ///
        /// SETUP POPUP

        $popup_request_data = array(
            'call_back_function'  => 'set_return',
            'form_name'           => 'MassUpdate',
            'field_to_name_array' => array(
                'id'   => "{$id_name}",
                'name' => "{$varname}",
            ),
        );

        $json                       = getJSONobj();
        $encoded_popup_request_data = $json->encode($popup_request_data);

        $qsName = array(
            'form'          => 'MassUpdate',
            'method'        => 'query',
            'modules'       => array("{$mod_type}"),
            'group'         => 'or',
            'field_list'    => array('name', 'id'),
            'populate_list' => array("mass_{$varname}", "mass_{$id_name}"),
            'conditions'    => array(array('name' => 'name', 'op' => 'like_custom', 'end' => '%', 'value' => '')),
            'limit'         => '30', 'no_match_text' => $app_strings['ERR_SQS_NO_MATCH']);
        $qsName = $json->encode($qsName);
        $img    = SugarThemeRegistry::current()->getImageURL("id-ff-select.png");
        //
        ///////////////////////////////////////

        return <<<EOHTML
<td width='15%'  scope='row' class='dataLabel'>$displayname</td>
<td width='35%' class='dataField'>
    <input name='{$varname}' id='mass_{$varname}' class='sqsEnabled' autocomplete='off' type='text' value=''>
    <input name='{$id_name}' id='mass_{$id_name}' type='hidden' value=''>
	<span class="id-ff multiple">
    <button title='{$app_strings['LBL_SELECT_BUTTON_TITLE']}'
        type='button' class='button' value='{$app_strings['LBL_SELECT_BUTTON_LABEL']}' name='button'
        onclick='open_popup("$mod_type", 600, 400, "", true, false, {$encoded_popup_request_data});'
        /><img alt="$img" src="$img"></button></span>
</td>
<script type="text/javascript">
<!--
if(typeof sqs_objects == 'undefined'){
    var sqs_objects = new Array;
}
sqs_objects['MassUpdate_{$varname}'] = $qsName;
registerSingleSmartInputListener(document.getElementById('mass_{$varname}'));
addToValidateBinaryDependency('MassUpdate', '{$varname}', 'alpha', false, '{$app_strings['ERR_SQS_NO_MATCH_FIELD']} {$app_strings['LBL_ASSIGNED_TO']}','{$id_name}');
-->
</script>
EOHTML;
    }

    /**
     * Add Account selection popup window HTML code
     * @param displayname Name to display in the popup window
     * @param varname name of the variable
     * @param id_name name of the id in vardef
     */
    function addAccountID($displayname, $varname, $id_name = '')
    {
        global $app_strings;

        $json = getJSONobj();

        if (empty($id_name))
            $id_name = "account_id";

        ///////////////////////////////////////
        ///
        /// SETUP POPUP

        $popup_request_data = array(
            'call_back_function'  => 'set_return',
            'form_name'           => 'MassUpdate',
            'field_to_name_array' => array(
                'id'   => "{$id_name}",
                'name' => "{$varname}",
            ),
        );

        $encoded_popup_request_data = $json->encode($popup_request_data);

        //
        ///////////////////////////////////////

        $qsParent                  = array(
            'form'          => 'MassUpdate',
            'method'        => 'query',
            'modules'       => array('Accounts'),
            'group'         => 'or',
            'field_list'    => array('name', 'id'),
            'populate_list' => array('parent_name', 'parent_id'),
            'conditions'    => array(array('name' => 'name', 'op' => 'like_custom', 'end' => '%', 'value' => '')),
            'order'         => 'name',
            'limit'         => '30',
            'no_match_text' => $app_strings['ERR_SQS_NO_MATCH']
        );
        $qsParent['populate_list'] = array('mass_' . $varname, 'mass_' . $id_name);
        $img                       = SugarThemeRegistry::current()->getImageURL("id-ff-select.png");
        $html                      = '<td scope="row">' . $displayname . " </td>\n"
                . '<td><input class="sqsEnabled" type="text" autocomplete="off" id="mass_' . $varname . '" name="' . $varname . '" value="" /><input id="mass_' . $id_name . '" type="hidden" name="'
                . $id_name . '" value="" />&nbsp;<span class="id-ff multiple"><button type="button" name="btn1" class="button" title="'
                . $app_strings['LBL_SELECT_BUTTON_LABEL'] . '"  value="' . $app_strings['LBL_SELECT_BUTTON_LABEL'] . '" onclick='
                . "'open_popup(\"Accounts\",600,400,\"\",true,false,{$encoded_popup_request_data});' /><img alt=\"$img\" src=\"$img\"></button></span></td>\n";
        $html                      .= '<script type="text/javascript" language="javascript">if(typeof sqs_objects == \'undefined\'){var sqs_objects = new Array;}sqs_objects[\'MassUpdate_' . $varname . '\'] = ' .
                $json->encode($qsParent) . '; registerSingleSmartInputListener(document.getElementById(\'mass_' . $varname . '\'));
					addToValidateBinaryDependency(\'MassUpdate\', \'' . $varname . '\', \'alpha\', false, \'' . $app_strings['ERR_SQS_NO_MATCH_FIELD'] . $app_strings['LBL_ACCOUNT'] . '\',\'' . $id_name . '\');
					</script>';

        return $html;
    }

    /**
     * Add AssignedUser popup window HTML code
     * @param displayname Name to display in the popup window
     * @param varname name of the variable
     */
    function addAssignedUserID($displayname, $varname)
    {
        global $app_strings;

        $json = getJSONobj();

        $popup_request_data         = array(
            'call_back_function'  => 'set_return',
            'form_name'           => 'MassUpdate',
            'field_to_name_array' => array(
                'id'        => 'assigned_user_id',
                'user_name' => 'assigned_user_name',
            ),
        );
        $encoded_popup_request_data = $json->encode($popup_request_data);
        $qsUser                     = array(
            'form'          => 'MassUpdate',
            'method'        => 'get_user_array', // special method
            'field_list'    => array('user_name', 'id'),
            'populate_list' => array('assigned_user_name', 'assigned_user_id'),
            'conditions'    => array(array('name' => 'user_name', 'op' => 'like_custom', 'end' => '%', 'value' => '')),
            'limit'         => '30', 'no_match_text' => $app_strings['ERR_SQS_NO_MATCH']);

        $qsUser['populate_list'] = array('mass_assigned_user_name', 'mass_assigned_user_id');
        $img                     = SugarThemeRegistry::current()->getImageURL("id-ff-select.png");
        $html                    = <<<EOQ
		<td width="15%" scope="row">$displayname</td>
		<td ><input class="sqsEnabled" autocomplete="off" id="mass_assigned_user_name" name='assigned_user_name' type="text" value=""><input id='mass_assigned_user_id' name='assigned_user_id' type="hidden" value="" />
		<span class="id-ff multiple"><button id="mass_assigned_user_name_btn" title="{$app_strings['LBL_SELECT_BUTTON_TITLE']}" type="button" class="button" value='{$app_strings['LBL_SELECT_BUTTON_LABEL']}' name=btn1
				onclick='open_popup("Users", 600, 400, "", true, false, $encoded_popup_request_data);' /><img src="$img"></button></span>
		</td>
EOQ;
        $html                    .= '<script type="text/javascript" language="javascript">if(typeof sqs_objects == \'undefined\'){var sqs_objects = new Array;}sqs_objects[\'MassUpdate_assigned_user_name\'] = ' .
                $json->encode($qsUser) . '; registerSingleSmartInputListener(document.getElementById(\'mass_assigned_user_name\'));
				addToValidateBinaryDependency(\'MassUpdate\', \'assigned_user_name\', \'alpha\', false, \'' . $app_strings['ERR_SQS_NO_MATCH_FIELD'] . $app_strings['LBL_ASSIGNED_TO'] . '\',\'assigned_user_id\');
				</script>';

        return $html;
    }

    /**
     * Add Status selection popup window HTML code
     * @param displayname Name to display in the popup window
     * @param varname name of the variable
     * @param options array of options for status
     */
    function addStatus($displayname, $varname, $options)
    {
        global $app_strings, $app_list_strings;

        // cn: added "mass_" to the id tag to differentiate from the status id in StoreQuery
        $html = '<td scope="row" width="15%">' . $displayname . '</td><td>';
        if (is_array($options))
        {
            if (!isset($options['']) && !isset($options['0']))
            {
                $new_options     = array();
                $new_options[''] = '';
                foreach ($options as $key => $value)
                {
                    $new_options[$key] = $value;
                }
                $options = $new_options;
            }
            $options = get_select_options_with_id_separate_key(
                    $options, $options, '__SugarMassUpdateClearField__', FALSE
            );
            $html    .= '<select id="mass_' . $varname . '" name="' . $varname . '">' . $options . '</select>';
        }
        else
        {
            $html .= $options;
        }
        $html .= '</td>';
        return $html;
    }

    /**
     * Add Status selection popup window HTML code
     * @param displayname Name to display in the popup window
     * @param varname name of the variable
     * @param options array of options for status
     */
    function addBool($displayname, $varname)
    {
        global $app_strings, $app_list_strings;
        return $this->addStatus($displayname, $varname, $app_list_strings['checkbox_dom']);
    }

    function addStatusMulti($displayname, $varname, $options)
    {
        global $app_strings, $app_list_strings;

        if (!isset($options['']) && !isset($options['0']))
        {
            $new_options     = array();
            $new_options[''] = '';
            foreach ($options as $key => $value)
            {
                $new_options[$key] = $value;
            }
            $options = $new_options;
        }
        $options = get_select_options_with_id_separate_key($options, $options, '', true);
        ;

        // cn: added "mass_" to the id tag to differentiate from the status id in StoreQuery
        $html = '<td scope="row" width="15%">' . $displayname . '</td>
			 <td><select id="mass_' . $varname . '" name="' . $varname . '[]" size="5" MULTIPLE>' . $options . '</select></td>';
        return $html;
    }

    /**
     * Add Date selection popup window HTML code
     * @param displayname Name to display in the popup window
     * @param varname name of the variable
     */
    function addDate($displayname, $varname)
    {
        global $timedate;
        //letrium ltd
        $displayname    = addslashes($displayname);
        $userformat     = '(' . $timedate->get_user_date_format() . ')';
        $cal_dateformat = $timedate->get_cal_date_format();
        global $app_strings, $app_list_strings, $theme;

        $javascriptend   = <<<EOQ
		 <script type="text/javascript">
		Calendar.setup ({
			inputField : "${varname}jscal_field", daFormat : "$cal_dateformat", ifFormat : "$cal_dateformat", showsTime : false, button : "${varname}jscal_trigger", singleClick : true, step : 1, weekNumbers:false
		});
		</script>
EOQ;
        $jscalendarImage = SugarThemeRegistry::current()->getImageURL('jscalendar.gif');
        $html            = <<<EOQ
	<td scope="row" width="20%">$displayname</td>
	<td class='dataField' width="30%"><input onblur="parseDate(this, '$cal_dateformat')" type="text" name='$varname' size="12" id='{$varname}jscal_field' maxlength='10' value="">
    <img src="$jscalendarImage" id="{$varname}jscal_trigger" align="absmiddle" title="{$app_strings['LBL_MASSUPDATE_DATE']}" alt='{$app_strings['LBL_MASSUPDATE_DATE']}'>&nbsp;<span class="dateFormat">$userformat</span>
	$javascriptend</td>
	<script> addToValidate('MassUpdate','$varname','date',false,'$displayname');</script>
EOQ;
        return $html;
    }

    function addRadioenumItem($name, $value, $output)
    {
        $_output = '';
        $_output .= '<label>';
        $_output .= '<input type="radio" name="'
                . $name . '" value="'
                . $value . '"';

        $_output .= ' />' . ($output == '' ? $GLOBALS['app_strings']['LBL_LINK_NONE'] : $output);
        $_output .= '</label><br />';
        return $_output;
    }

    function addRadioenum($displayname, $varname, $options)
    {
        foreach ($options as $_key => $_val)
        {
            $_html_result[] = $this->addRadioenumItem($varname, $_key, $_val);
        }

        $html = '<td scope="row" width="15%">' . $displayname . '</td>
			 <td>' . implode("\n", $_html_result) . '</td>';
        return $html;
    }

    /**
     * Add Datetime selection popup window HTML code
     * @param displayname Name to display in the popup window
     * @param varname name of the variable
     */
    function addDatetime($displayname, $varname)
    {
        global $timedate;
        $userformat      = $timedate->get_user_time_format();
        $cal_dateformat  = $timedate->get_cal_date_format();
        global $app_strings, $app_list_strings, $theme;
        $jscalendarImage = SugarThemeRegistry::current()->getImageURL('jscalendar.gif');

        $javascriptend = <<<EOQ
		 <script type="text/javascript">
		Calendar.setup ({
			inputField : "{$varname}_date",
			daFormat : "$cal_dateformat",
			ifFormat : "$cal_dateformat",
			showsTime : false,
			button : "{$varname}_trigger",
			singleClick : true,
			step : 1,
			weekNumbers:false
		});
		</script>
EOQ;
        $dtscript      = getVersionedScript('include/SugarFields/Fields/Datetimecombo/Datetimecombo.js');
        $html          = <<<EOQ
		<td scope="row" width="20%">$displayname</td>
		<td class='dataField' width="30%"><input onblur="parseDate(this, '$cal_dateformat')" type="text" name='$varname' size="12" id='{$varname}_date' maxlength='10' value="">
		<img border="0" src="$jscalendarImage" alt='{$app_strings['LBL_MASSUPDATE_DATE']}' id="{$varname}_trigger" title="{$app_strings['LBL_MASSUPDATE_DATE']}"  align="absmiddle">&nbsp;$javascriptend

		<span id="{$varname}_time_section"></span>
		</td>
		<input type="hidden" id="{$varname}" name="{$varname}">
		$dtscript
		<script type="text/javascript">
		var combo_{$varname} = new Datetimecombo(" ", "$varname", "$userformat", '','','',1);
		//Render the remaining widget fields
		text = combo_{$varname}.html('');
		document.getElementById('{$varname}_time_section').innerHTML = text;

		//Call eval on the update function to handle updates to calendar picker object
		eval(combo_{$varname}.jsscript(''));

		function update_{$varname}_available() {
		      YAHOO.util.Event.onAvailable("{$varname}_date", this.handleOnAvailable, this);
		}

		update_{$varname}_available.prototype.handleOnAvailable = function(me) {
			Calendar.setup ({
			onClose : update_{$varname},
			inputField : "{$varname}_date",
			daFormat : "$cal_dateformat",
			ifFormat : "$cal_dateformat",
			button : "{$varname}_trigger",
			singleClick : true,
			step : 1,
			weekNumbers:false
			});

			//Call update for first time to round hours and minute values
			combo_{$varname}.update(false);
		}

		var obj_{$varname} = new update_{$varname}_available();
		</script>

		<script> addToValidate('MassUpdate','{$varname}_date','date',false,'$displayname');
		addToValidateBinaryDependency('MassUpdate', '{$varname}_hours', 'alpha', false, "{$app_strings['ERR_MISSING_REQUIRED_FIELDS']}", '{$varname}_date');
		addToValidateBinaryDependency('MassUpdate', '{$varname}_minutes', 'alpha', false, "{$app_strings['ERR_MISSING_REQUIRED_FIELDS']}", '{$varname}_date');
		addToValidateBinaryDependency('MassUpdate', '{$varname}_meridiem', 'alpha', false, "{$app_strings['ERR_MISSING_REQUIRED_FIELDS']}", '{$varname}_date');
		</script>

EOQ;
        return $html;
    }

    function date_to_dateTime($field, $value)
    {
        global $timedate;
        //Check if none was set
        if (isset($this->sugarbean->field_defs[$field]['group']))
        {
            $group = $this->sugarbean->field_defs[$field]['group'];
            if (isset($this->sugarbean->field_defs[$group . "_flag"]) && isset($_POST[$group . "_flag"]) && $_POST[$group . "_flag"] == 1)
            {
                return "";
            }
        }

        $oldDateTime = $this->sugarbean->$field;
        $oldTime     = explode(" ", $oldDateTime);
        if (isset($oldTime[1]))
        {
            $oldTime = $oldTime[1];
        }
        else
        {
            $oldTime = $timedate->now();
        }
        $oldTime = explode(" ", $oldTime);
        if (isset($oldTime[1]))
        {
            $oldTime = $oldTime[1];
        }
        else
        {
            $oldTime = $oldTime[0];
        }
        $value = explode(" ", $value);
        $value = $value[0];
        return $value . " " . $oldTime;
    }

    function checkClearField($field, $value)
    {
        if ($value == 1 && strpos($field, '_flag'))
        {
            $fName = substr($field, -5);
            if (isset($this->sugarbean->field_defs[$field]['group']))
            {
                $group = $this->sugarbean->field_defs[$field]['group'];
                if (isset($this->sugarbean->field_defs[$group]))
                {
                    $_POST[$group] = "";
                }
            }
        }
    }

    function generateSearchWhere($module, $query)
    {//this function is similar with function prepareSearchForm() in view.list.php
        $seed                 = loadBean($module);
        $this->use_old_search = true;
        if (file_exists('modules/' . $module . '/SearchForm.html'))
        {
            if (file_exists('modules/' . $module . '/metadata/SearchFields.php'))
            {
                require_once('include/SearchForm/SearchForm.php');
                $searchForm = new SearchForm($module, $seed);
            }
            elseif (!empty($_SESSION['export_where']))
            { //bug 26026, sometimes some module doesn't have a metadata/SearchFields.php, the searchfrom is generated in the ListView.php.
                //So currently massupdate will not gernerate the where sql. It will use the sql stored in the SESSION. But this will cause bug 24722, and it cannot be avoided now.
                $where    = $_SESSION['export_where'];
                $whereArr = explode(" ", trim($where));
                if ($whereArr[0] == trim('where'))
                {
                    $whereClean = array_shift($whereArr);
                }
                $this->where_clauses = implode(" ", $whereArr);
                return;
            }
            else
            {
                $this->where_clauses = '';
                return;
            }
        }
        else
        {
            $this->use_old_search = false;
            require_once('include/SearchForm/SearchForm2.php');

            if (file_exists('custom/modules/' . $module . '/metadata/metafiles.php'))
            {
                require('custom/modules/' . $module . '/metadata/metafiles.php');
            }
            elseif (file_exists('modules/' . $module . '/metadata/metafiles.php'))
            {
                require('modules/' . $module . '/metadata/metafiles.php');
            }

            $searchFields = $this->getSearchFields($module);
            $searchdefs   = $this->getSearchDefs($module);

            if (empty($searchdefs) || empty($searchFields))
            {
                $this->where_clauses = ''; //for some modules, such as iframe, it has massupdate, but it doesn't have search function, the where sql should be empty.
                return;
            }

            $searchForm = new SearchForm($seed, $module);
            $searchForm->setup($searchdefs, $searchFields, 'SearchFormGeneric.tpl');
        }
        /* bug 31271: using false to not add all bean fields since some beans - like SavedReports
          can have fields named 'module' etc. which may break the query */
        $query              = json_decode(html_entity_decode($query), true);
        $searchForm->populateFromArray($query, null, true);
        $this->searchFields = $searchForm->searchFields;
        $where_clauses      = $searchForm->generateSearchWhere(true, $module);
        if (count($where_clauses) > 0)
        {
            $this->where_clauses = '(' . implode(' ) AND ( ', $where_clauses) . ')';
            $GLOBALS['log']->info("MassUpdate Where Clause: {$this->where_clauses}");
        }
        else
        {
            $this->where_clauses = '';
        }
    }

    protected function getSearchDefs($module, $metafiles = array())
    {
        if (file_exists('custom/modules/' . $module . '/metadata/searchdefs.php'))
        {
            require('custom/modules/' . $module . '/metadata/searchdefs.php');
        }
        elseif (!empty($metafiles[$module]['searchdefs']))
        {
            require($metafiles[$module]['searchdefs']);
        }
        elseif (file_exists('modules/' . $module . '/metadata/searchdefs.php'))
        {
            require('modules/' . $module . '/metadata/searchdefs.php');
        }

        return isset($searchdefs) ? $searchdefs : array();
    }

    protected function getSearchFields($module, $metafiles = array())
    {
        if (file_exists('custom/modules/' . $module . '/metadata/SearchFields.php'))
        {
            require('custom/modules/' . $module . '/metadata/SearchFields.php');
        }
        elseif (!empty($metafiles[$module]['searchfields']))
        {
            require($metafiles[$module]['searchfields']);
        }
        elseif (file_exists('modules/' . $module . '/metadata/SearchFields.php'))
        {
            require('modules/' . $module . '/metadata/SearchFields.php');
        }

        return isset($searchFields) ? $searchFields : array();
    }

    /**
     * This is kinda a hack how it is implimented, but will tell us whether or not a focus has
     * fields for Mass Update
     *
     * @return bool
     */
    public function doMassUpdateFieldsExistForFocus()
    {
        static $banned = array('date_modified' => 1, 'date_entered' => 1, 'created_by' => 1, 'modified_user_id' => 1, 'deleted' => 1, 'modified_by_name' => 1,);
        foreach ($this->sugarbean->field_defs as $field)
        {
            if (!isset($banned[$field['name']]) && (!isset($field['massupdate']) || !empty($field['massupdate'])))
            {
                if (isset($field['type']) && $field['type'] == 'relate' && isset($field['id_name']) && $field['id_name'] == 'assigned_user_id')
                    $field['type'] = 'assigned_user_name';
                if (isset($field['custom_type']))
                    $field['type'] = $field['custom_type'];
                if (isset($field['type']))
                {
                    switch ($field["type"])
                    {
                        case "relate":
                        case "parent":
                        case "int":
                        case "contact_id":
                        case "assigned_user_name":
                        case "account_id":
                        case "account_name":
                        case "bool":
                        case "enum":
                        case "multienum":
                        case "radioenum":
                        case "datetimecombo":
                        case "datetime":
                        case "date":
                            return true;
                            break;
                    }
                }
            }
        }

        return false;
    }

    /**
     * Have to be overridden in children
     * @param string $displayname field label
     * @param string $field field name
     * @param bool $even even or odd
     * @return string html field data
     */
    protected function addDefault($displayname, $field, & $even)
    {
        return '';
    }

    function reportingUser($currentUserId)
    {
        $userObj                             = new User();
        $userObj->disable_row_level_security = true;
        $userList                            = $userObj->get_full_list("", "users.reports_to_id='" . $currentUserId . "'");
        if (!empty($userList))
        {
            foreach ($userList as $record)
            {
                if (!empty($record->reports_to_id) && !empty($record->id))
                {
                    $this->report_to_id[] = $record->id;
                    $this->reportingUser($record->id);
                }
            }
        }
    }

}

?>

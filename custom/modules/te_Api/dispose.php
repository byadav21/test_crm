<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
require_once('custom/modules/te_Api/te_Api.php');
require_once('modules/te_disposition/te_disposition.php');
require_once('modules/te_neox_call_details/te_neox_call_details.php');
global $db, $current_user;



$crmDispo = array('New Lead'               => 'Alive',
    'Follow Up'              => 'Alive',
    'Converted'              => 'Converted',
    'Instalment Follow up'   => 'Converted',
    'Referral Follow up'     => 'Converted',
    'Dead Number'            => 'Dead',
    'Wrong Number'           => 'Dead',
    'Ringing Multiple Times' => 'Dead',
    'Not Enquired'           => 'Dead',
    'Not Eligible'           => 'Dead',
    'Fallout'                => 'Dead',
    'Cross Sell'             => 'Dead', //New
    'Not Interested'         => 'Dead', //New
    'Next Batch'             => 'Dead', //New
    'Retired'                => 'Dead', //New
    'Duplicate'              => 'Duplicate',
    'Dropout'                => 'Dropout',
    'Prospect'               => 'Warm',
    'Recycle'                => 'Recycle',
    'wrap.timeout'           => 'Wrap Out'
);

function createLog($action, $filename, $field = '', $dataArray = array())
{
    $file = fopen(str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']) . "upload/apilog/$filename", "a");
    fwrite($file, date('Y-m-d H:i:s') . "\n");
    fwrite($file, $action . "\n");
    fwrite($file, $field . "\n");
    fwrite($file, print_r($dataArray, TRUE) . "\n");
    fclose($file);
}

function getAttemptCount()
{
    global $db, $current_user;
    $records = array();
    if (isset($_REQUEST['lead_reference']) && $_REQUEST['lead_reference'] != 'null')
    {
        $sql     = " SELECT id_c lead_id,
                                            count(te_disposition_leads_c.te_disposition_leadsleads_ida) total_dispo,
                                            leads.status_description,
                                            leads.status,
                                            lc.attempts_c,
                                            te_disposition_leads_c.te_disposition_leadste_disposition_idb AS dispo_id
                                     FROM leads_cstm lc
                                     INNER JOIN leads ON lc.id_c=leads.id
                                     AND leads.status_description='New Lead'
                                     INNER JOIN te_disposition_leads_c ON te_disposition_leads_c.te_disposition_leadsleads_ida=leads.id
                                     WHERE leads.deleted=0
                                       AND (lc.attempts_c > 0  OR lc.attempts_c='')
                             AND leads.id='" . $_REQUEST['lead_reference'] . "'";
        $res     = $db->query($sql);
        $records = $db->fetchByAssoc($res);
    }
    return $records;
}

unset($_SESSION['temp_for_newUser']);

if (isset($_REQUEST['checkCallStatus']) && isset($_REQUEST['records']) && $_REQUEST['checkCallStatus'] == 1 && $_REQUEST['records'])
{
    //echo "select id from  session_call where lead_id='". $_REQUEST['records'] ."' session_id='" . session_id() ."'";
    $res = $db->query("select id from  session_call where lead_id='" . $_REQUEST['records'] . "' and session_id='" . $_REQUEST['customerCRTId'] . "'");
    if ($db->getRowCount($res) > 0)
    {
        echo '1';
    }
    exit();
}


$sql    = "delete from  session_call where  session_id='" . $_REQUEST['customerCRTId'] . "'";
$db->query($sql);
$objapi = new te_Api_override();


if (isset($_REQUEST['customerCRTId']) && $_REQUEST['customerCRTId'])
{

    $objapi->createLog(print_r($_REQUEST, true), 'disposeamyo', $_REQUEST);


    $dispositionCode = '';
    $status          = '';
    $dispositionCode = $_REQUEST['dispositionCode'];
    $status          = isset($crmDispo[$dispositionCode]) ? $crmDispo[$dispositionCode] : '';

    $debugArr = array('lead_id'           => $records['id'],
        'status'            => $status,
        'subStatus'         => $dispositionCode,
        'entryPoint'        => $_REQUEST['entryPoint'],
        'phone'             => $_REQUEST['phone'],
        'dispositionName'   => $_REQUEST['dispositionName'],
        'systemDisposition' => $_REQUEST['systemDisposition'],
        'callType'          => $_REQUEST['callType'],
        'campaignId'        => $_REQUEST['campaignId']
    );



    if (isset($_REQUEST['lead_reference']) && $_REQUEST['lead_reference'] != 'null' && $_REQUEST['callType'] != 'auto.dial.customer')
    {

        $sql = "select attempts_c,id_c from leads inner join  leads_cstm on id_c=id where id='" . $_REQUEST['lead_reference'] . "'";
        $res = $db->query($sql);
        if ($db->getRowCount($res) > 0)
        {

            $records  = $db->fetchByAssoc($res);
            $id       = $records['id_c'];
            $attempid = intval($records['attempts_c']);
            $attempid++;
            $sql      = "update leads_cstm set attempts_c='" . $attempid . "' where id_c='" . $id . "'";
            $res      = $db->query($sql);

            $dispCountArr = getAttemptCount();
            if (!empty($dispCountArr))
            {
                if ($dispCountArr['total_dispo'] == 1)
                {
                    $sql = "UPDATE te_disposition
                                SET attempt_count='" . $attempid . "',
                                    dispositionName='" . $_REQUEST['dispositionName'] . "',
                                    callType='" . $_REQUEST['callType'] . "'
                                WHERE id='" . $dispCountArr['dispo_id'] . "'";
                    $res = $db->query($sql);
                    createLog('{Ameyo dispostion is null}', 'null_dispose_log.txt', $sql, $_REQUEST);
                }
            }
        }
    }
    else if ($_REQUEST['callType'] == 'auto.dial.customer' && $_REQUEST['dispositionName'] != 'CONNECTED' && $_REQUEST['lead_reference'] && $_REQUEST['lead_reference'] != 'null')
    {

        $sql = "select attempts_c,id_c,assigned_user_id from leads inner join  leads_cstm on id_c=id where id='" . $_REQUEST['lead_reference'] . "'";
        $res = $db->query($sql);
        if ($db->getRowCount($res) > 0)
        {

            $records        = $db->fetchByAssoc($res);
            $id             = $records['id_c'];
            $attempid       = intval($records['attempts_c']);
            $assignedUserId = $records['assigned_user_id'];
            $attempid++;
            $sql            = "update leads_cstm set attempts_c='" . $attempid . "' where id_c='" . $id . "'";
            $res            = $db->query($sql);

            $dispCountArr = getAttemptCount();
            if (!empty($dispCountArr))
            {
                if ($dispCountArr['total_dispo'] == 1)
                {
                    $sql = "UPDATE te_disposition
                                SET attempt_count='" . $attempid . "',
                                    dispositionName='" . $_REQUEST['dispositionName'] . "',
                                    callType='" . $_REQUEST['callType'] . "'
                                WHERE id='" . $dispCountArr['dispo_id'] . "'";
                    $res = $db->query($sql);
                    createLog('{Ameyo dispostion is null}', 'null_dispose_log.txt', $sql, $_REQUEST);
                }
            }

            if ($attempid >= 6 && $assignedUserId == '')
            {
                //$sql = "update leads set status='Dead', status_description='Auto Retired' where id='" . $id . "'";
                //$res = $db->query($sql);
                $bean                     = BeanFactory::getBean('Leads', $id);
                $bean->status             = 'Dead';
                $bean->status_description = 'Auto Retired';
                $bean->save();

                $xxar = array('ref_id' => $id, 'status' => 'Dead', 'status_description' => 'Auto Retired');
                createLog('{Auto Retired}', 'auto_retired_log.txt', $id, $xxar);
            }
        }
    }


    $phone = $_REQUEST['phone'];
    if (isset($_REQUEST['lead_reference']) && $_REQUEST['lead_reference'] && $_REQUEST['lead_reference'] != 'null')
    {
        $lead = "select id,assigned_user_id,first_name,last_name,status,status_description,dristi_campagain_id from  leads where  id='" . $_REQUEST['lead_reference'] . "' and deleted=0 and status!='Duplicate' ";
    }
    else
    {

        $lead = "select id,assigned_user_id,first_name,last_name,status,status_description,dristi_campagain_id from  leads where phone_mobile='$phone' and status!='Duplicate' and deleted=0 ";

        //$lead = "select id,assigned_user_id,first_name,last_name,status,status_description,dristi_campagain_id from  leads where ( phone_mobile like '%$phone%' or    phone_other like '%$phone%' ) and status!='Duplicate' and deleted=0 ";
    }
    $res = $db->query($lead);
    if ($db->getRowCount($res) > 0)
    {
        $records = $db->fetchByAssoc($res);
        $db->query("update leads set dristi_request=null where id='" . $records['id'] . "'");
    }




    if ($dispositionCode != 'null')
    {
        $status   = isset($crmDispo[$dispositionCode]) ? $crmDispo[$dispositionCode] : '';
        $debugArr = array(
            'lead_id'           => $_REQUEST['lead_reference'],
            'status'            => $status,
            'SubStatus'         => $dispositionCode,
            'entryPoint'        => $_REQUEST['entryPoint'],
            'phone'             => $_REQUEST['phone'],
            'dispositionName'   => $_REQUEST['dispositionName'],
            'systemDisposition' => $_REQUEST['systemDisposition'],
            'callType'          => $_REQUEST['callType'],
            'campaignId'        => $_REQUEST['campaignId']);




        $bean                     = BeanFactory::getBean('Leads', $_REQUEST['lead_reference']);
        $bean->status             = $status;
        $bean->status_description = $dispositionCode;
        $bean->dispositionName    = $_REQUEST['dispositionName'];
        $bean->callType           = $_REQUEST['callType'];
        $bean->save();

        if (isset($_REQUEST['lead_reference']))
        {
            $userAssociations = $_REQUEST['lead_reference'];
            $userSJson        = str_replace('&quot;', '"', $userAssociations);
            $userDispoArr     = json_decode($userSJson, TRUE);
            $disPosedUser     = $userDispoArr[0]['userId'];
            createLog('{Ameyo userAssociations}', 'userassociations_dispose_log.txt', $disPosedUser, $userDispoArr);
        }


        createLog('{Ameyo dispostion response}', 'new_dispose_log.txt', $_REQUEST['lead_reference'], $debugArr);
    }






    if ($_REQUEST['callType'] == 'manual.dial.customer')
    {


        //$res=$db->query($lead);
        if ($db->getRowCount($res) > 0)
        {
            $campID                            = 18;
            $apiID                             = 42;
            $records                           = $db->fetchByAssoc($res);
            $api                               = new te_Api_override();
            $data                              = [];
            $session                           = $api->doLogin();
            $data['sessionId']                 = $session;
            $data['properties']                = array('update.customer' => true, 'migrate.customer' => true);
            $data['customerRecords']           = [];
            $customerRecords['name']           = $records['first_name'] . " " . $records['last_name'];
            $customerRecords['first_name']     = $records['first_name'];
            $customerRecords['last_name']      = ($records['last_name']) ? $records['last_name'] : '';
            $customerRecords['phone1']         = $phone;
            $customerRecords['lead_reference'] = $records['id'];
            $data['customerRecords'][]         = $customerRecords;

            if ($records['dristi_campagain_id'] == 18)
            {

                $campID = 18;
                $apiID  = 46;
            }
            else if ($records['dristi_campagain_id'] == 16)
            {

                $campID = 16;
                $apiID  = 47;
            }
            else if ($records['dristi_campagain_id'] == 17)
            {

                $campID = 17;
                $apiID  = 48;
            }

            $responses = $api->uploadContacts($data, $campID, $apiID);


            $file = fopen(str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']) . "upload/apilog/manual_dial_customer_if_18_16_17.txt", "a");
            fwrite($file, date('Y-m-d H:i:s') . "\n");
            fwrite($file, '$data  if {18,16,17}' . "\n");
            fwrite($file, print_r($data, TRUE) . "\n");
            fwrite($file, '$responses  if {18,16,17}' . "\n");
            fwrite($file, $responses . "\n");
            fclose($file);
        }
    }
    exit();
}
die;

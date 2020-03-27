<?php

ini_set('display_errors', 1);
error_reporting(1);
require_once('custom/modules/te_Api/leads_override.php');
global $db;
$name         = $_REQUEST['name'];
$phone        = ltrim($_REQUEST['phone'], '0');
$email        = $_REQUEST['email'];
$source       = $_REQUEST['utm_source'];
$medium       = $_REQUEST['utm_medium'];
$term         = $_REQUEST['utm_term']; //batchcode
$campaign     = $_REQUEST['utm_campaign'];
$clvrtp_whatsapp     = $_REQUEST['whatsapp'];

$leadObj      = new leads_override();
$batchid      = '';
$status       = 'Alive';
$statusDetail = 'New Lead';

$uname              = '';
$campagain_d        = '';
$lead_d             = '';
$vendor_id          = '';
$vendor_user_id     = '';
$vendor_source_type = '';

$lead_source_types = '';
$lead_source       = '';
$lead_source       = $_REQUEST['lead_source'];
$ABNDArr           = array('CC_ABND', 'CC_FAILD', 'CC_DIRECT');

function createLog($action, $filename, $field = '', $dataArray = array())
{
    $file = fopen(str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']) . "upload/apilog/$filename", "a");
    fwrite($file, date('Y-m-d H:i:s') . "\n");
    fwrite($file, $action . "\n");
    fwrite($file, $field . "\n");
    fwrite($file, print_r($dataArray, TRUE) . "\n");
    fclose($file);
}

createLog('{on initial action}', 'leadGenration_source_status' . date('Y-m-d') . '_log.txt', $lead_source, $_REQUEST);

if ($phone || $email)
{
    if ($source)
    {
        $vendorUsers = $leadObj->fetchVendorWithUsers($source);

        if ($vendorUsers)
        {
            $vendor_id          = $vendorUsers['vendor_id'];
            $vendor_user_id     = $vendorUsers['u_id'];
            $vendor_source_type = $vendorUsers['source_type'];
        }
    }#echo "<pre>";print_r($vendorUsers);exit();
    $utm = $leadObj->fetchUtm($source, $medium, $term);
    if ($utm)
    {

        $batchid     = $utm['te_ba_batch_id_c'];
        $uname       = $utm['name'];
        $campagain_d = $utm['d_campaign_id'];
        $lead_d      = $utm['d_lead_id'];
    }
    else
    {
        $batchQ   = "SELECT b.id,b.name,b.d_campaign_id,b.d_lead_id,b.lastCampagain FROM  `te_ba_batch`  b WHERE b.deleted=0 and b.`batch_code`='" . $term . "'";
        $rex      = $GLOBALS['db']->query($batchQ);
        $BatchRow = $GLOBALS['db']->fetchByAssoc($rex);
        $batchid  = $BatchRow['id'];
        $camID    = $BatchRow['d_campaign_id'];
        $leadID   = $BatchRow['d_lead_id'];
        //                            if(!$batchid)
        //                                   {
        //                                       echo json_encode(array('status'=>'error','msg'=>'Utm term is required field')); exit();
        //                                   }
        if ($camID && $leadID)
        {
            $camID  = explode(',', $BatchRow['d_campaign_id']);
            $leadID = explode(',', $BatchRow['d_lead_id']);
            if (count($camID) > 1 && count($camID) == count($leadID))
            {
                $assigned = false;
                for ($i = 0; $i < count($camID); $i++)
                {
                    if ($BatchRow['lastCampagain'] == $camID[$i] . $leadID[$i] || $assigned)
                        continue;
                    $campagain_d = $camID[$i];
                    $lead_d      = $leadID[$i];
                    $assigned    = true;
                }
            }
            else
            {
                if ($camID[0] && $leadID[0])
                {
                    $campagain_d = $camID[0];
                    $lead_d      = $leadID[0];
                }
            }
        }
    }
}
else
{
    //echo json_encode(array('status'=>'error','msg'=>'Email, Utm source, utm medium and utm term is required field')); exit();	
    echo json_encode(array('status' => 'error', 'msg' => 'Mobile or Email is required field'));
    exit();
}

            /*
            $sql = "SELECT  leads.id AS id,
                                leads.assigned_user_id,
                                status,
                                status_description
                         FROM leads
                         INNER JOIN leads_cstm ON leads.id = leads_cstm.id_c";
            if ($email != "")
            {
                $sql .= " INNER JOIN email_addr_bean_rel ON email_addr_bean_rel.bean_id = leads.id
                            AND email_addr_bean_rel.bean_module ='Leads'";

                $sql .= " INNER JOIN email_addresses ON email_addresses.id =  email_addr_bean_rel.email_address_id ";
            }

            $sql .= " WHERE leads.deleted = 0 AND leads_cstm.te_ba_batch_id_c = '" . $batchid . "'";

            if ($phone != "" && $email != "")
            {
                $sql .= " AND leads.phone_mobile = '$phone' AND email_addresses.email_address='" . $email . "'";
            }
            */

            $sql = "SELECT  leads.id AS id,
                            leads.assigned_user_id,
                            leads.status,
                            leads.status_description
                     FROM leads
                     INNER JOIN leads_cstm ON leads.id = leads_cstm.id_c ";
           
            $sql .= " WHERE leads.deleted = 0
                          AND leads_cstm.te_ba_batch_id_c = '" . $batchid . "'
                          AND status_description!='Duplicate'
                          AND status_description!='Re-Enquired'
                          AND leads.deleted=0 "; 
                        // AND DATE(date_entered) = '".date('Y-m-d')."'";
            if ($phone && $email)
            {

                $sql .= " AND ( leads.phone_mobile = '{$phone}' or email_add_c = '{$email}')";
            }
            elseif (!$phone && $email)
            {

                $sql .= " AND email_add_c=  '{$email}'";
            }
            elseif ($phone && !$email)
            {
                $sql .= " AND leads.phone_mobile = '{$phone}'";
            }
            
           /*if (in_array($lead_source, $ABNDArr))
            {
                $sql .= " AND leads.status IN ('Alive','Warm') AND leads.status_description IN ('New Lead','Follow Up','Prospect')";
            }*/

//echo '<pre>'; echo $sql; echo 'xxxx=='.$lead_source; print_r($ABNDArr); die;

$autoassign       = 'Yes';
$assigned_user_id = NULL;
$duplicate_check  = 0;

$re = $GLOBALS['db']->query($sql);
if ($GLOBALS['db']->getRowCount($re) > 0)
{

    //When Re-Enquired or New 
    $status          = 'Warm';
    $statusDetail    = 'Re-Enquired';
    $campagain_d     = '';
    $lead_d          = '';
    $autoassign      = 'No';
    $duplicate_check = 1;
}


if ($vendor_id && $vendor_user_id)
{
    $statusDetail      = 'Follow Up';
    $lead_source_types = ($vendor_source_type) ? $vendor_source_type : "OO";
    $lead_source       = $lead_source_types . '_' . strtoupper($source);
    $autoassign        = 'No';
    $assigned_user_id  = $vendor_user_id;
}
$leadObj->first_name      = $name;
$leadObj->duplicate_check = $duplicate_check;
$leadObj->email1          = $email;
$leadObj->email_add_c     = $email;
$leadObj->phone_mobile    = $phone;

if (isset($_REQUEST['country_code']) && isset($_REQUEST['country_name']) && $_REQUEST['country_name'] != 'India' && $_REQUEST['country_code'] != '')
{
    $leadObj->phone_mobile = '+' . $_REQUEST['country_code'] . ' ' . $phone;
}

$leadObj->status               = $status;
$leadObj->status_description   = $statusDetail;
$leadObj->lead_source          = $lead_source;
$leadObj->lead_source_types    = $lead_source_types;
//if($_REQUEST['work_experience'])  $leadObj->work_experience_c=$_REQUEST['work_experience'];
//if($_REQUEST['education']) $leadObj->education_c= $_REQUEST['education'];
if ($_REQUEST['city'])
    $leadObj->primary_address_city = $_REQUEST['city'];
if ($_REQUEST['functional_area'])
    $leadObj->functional_area_c    = $_REQUEST['functional_area'];

if ($_REQUEST['experience'])
    $leadObj->work_experience_c     = $_REQUEST['experience'];
if ($_REQUEST['qualification'])
    $leadObj->education_c           = $_REQUEST['qualification'];
if ($_REQUEST['unknownone'])
    $leadObj->dummy_one             = $_REQUEST['unknownone'];
if ($_REQUEST['unknowntwo'])
    $leadObj->dummy_two             = $_REQUEST['unknowntwo'];
if ($_REQUEST['landing_url'])
    $leadObj->landing_url           = $_REQUEST['landing_url'];
if ($_REQUEST['state'])
    $leadObj->primary_address_state = $_REQUEST['state'];

if ($_REQUEST['country_code'])
    $leadObj->country_code            = $_REQUEST['country_code'];
if ($_REQUEST['country_name'])
    $leadObj->primary_address_country = $_REQUEST['country_name'];
if ($_REQUEST['country_name'])
    $leadObj->country_log             = $_REQUEST['country_name'];
if ($_REQUEST['site_lead_id'])
    $leadObj->site_lead_id            = $_REQUEST['site_lead_id'];

if ($term)
    $leadObj->utm_term_c          = $term;
if ($source)
    $leadObj->utm_source_c        = $source;
if ($medium)
    $leadObj->utm_contract_c      = $medium;
if ($campaign)
    $leadObj->utm_campaign        = $campaign;
if ($source)
    $leadObj->vendor              = $source;
if ($uname)
    $leadObj->utm                 = $uname;
//if(!$uname) $leadObj->utm='NA';
if ($batchid)
    $leadObj->te_ba_batch_id_c    = $batchid;
if (!$source)
    $leadObj->vendor              = 'NA_VENDOR';
if ($campagain_d)
    $leadObj->dristi_campagain_id = $campagain_d;
if ($lead_d)
    $leadObj->dristi_API_id       = $lead_d;
if ($clvrtp_whatsapp)
    $leadObj->msg_whatsapp_clvrtp       = strtolower($clvrtp_whatsapp);

$leadObj->assigned_user_id    = $assigned_user_id;
$leadObj->autoassign          = $autoassign;

if ($statusDetail == 'Re-Enquired' && in_array($lead_source, $ABNDArr))
{       
        $data = $GLOBALS['db']->fetchByAssoc($re);
        $lead_xID       = $data['id'];
        createLog('{on ABND_CASE action}', 'leadGenration_source_status' . date('Y-m-d') . '_log.txt', $lead_source, $_REQUEST);
        
        $updateSql    = "update leads_cstm
                            SET
                      abnd_reenquired_status   = '1' 
                      where id_c='$lead_xID'"; 
        createLog('{If Re-Enquired & with ABND from leadGenration API}', 're_enquired_check_log_' . date('Y-m-d') . '_log.txt', $updateSql, $_REQUEST);
        $db->query($updateSql);
        echo json_encode(array('status' => 'ABND_CASE', 'msg' => 'Re-Enquired found no action taken'));
        exit();
}
else
{
    $leadObj->save();
    if (!$leadObj->id)
    {
        echo json_encode(array('status' => 'error', 'msg' => 'Some thing gone wrong!'));
        exit();
    }
    else
    {
        echo json_encode(array('status' => 'success', 'msg' => 'Lead saved successfully!'));
    }
    if ($campagain_d && $lead_d)
    {
        $sql = "update te_ba_batch set lastCampagain='" . $campagain_d . $lead_d . "' where id='" . $batchid . "'";
        $db->query($sql);
    }
    exit();
}
//echo json_encode(array('status'=>'success','msg'=>'Lead saved successfully!')); exit();

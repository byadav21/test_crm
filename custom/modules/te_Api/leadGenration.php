<?php

ini_set('display_errors', 1);
error_reporting(0);
require_once('custom/modules/te_Api/leads_override.php');

global $db, $sugar_config;

function createLogX($action, $filename, $field = '', $dataArray = array())
{
    $file = fopen(str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']) . "upload/apilog/$filename", "a");
    fwrite($file, date('Y-m-d H:i:s') . "\n");
    fwrite($file, $action . "\n");
    fwrite($file, $field . "\n");
    fwrite($file, print_r($dataArray, TRUE) . "\n");
    fclose($file);
}


$number = $_REQUEST['phone'];
 // Remove the spaces & special char. show only numbers
 $number = preg_replace('/[^0-9\-]/', '', $number );
 $number = ltrim($number, '0');//12345
// Remove the 91 sign.
// if(strlen($number) > 10){
//     $number = str_replace('91', '', $number);
// }

$name         = $_REQUEST['name'];
$phone        = $number;//ltrim($_REQUEST['phone'], '0');
$email        = $_REQUEST['email'];
$source       = $_REQUEST['utm_source'];
$medium       = $_REQUEST['utm_medium'];
$term         = $_REQUEST['utm_term']; //batchcode
$campaign     = $_REQUEST['utm_campaign'];
$clvrtp_whatsapp     = $_REQUEST['whatsapp'];
$gupshup_whatsapp    = $_REQUEST['whatsapp'];

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



        $batchObj = $db->query("SELECT batch_code FROM te_ba_batch WHERE batch_code = '" . $term . "' AND deleted=0");
        $batchdata= $db->fetchByAssoc($batchObj);

        //Start Using for OPT_IN Gupshup APi
        
        if(!empty($batchdata['batch_code'])){

            $batchCode = isset($batchdata['batch_code']) ?  $batchdata['batch_code'] : $term;
            //echo 'xxx'.$batchCode; die;
            // echo "cust_name:- ". $name ." phone:- ". $phone." email:- ".$email." batchCode:- ".$term.'<br/>';
            // $phone = "+919911198392";
    
            $getQuery = "select * from gupshup_api_details where batch_code='".$batchCode."' AND deleted = 0 ";
            $itemDetal=$db->query($getQuery);
            $resultData = $db->fetchByAssoc($itemDetal);

            $checkPhoneNum = "select phone_mobile from gupshup_leads_details where phone_mobile='".$phone."' ";
            $getPhoneDetal = $db->query($checkPhoneNum);
            $getPhoneNum   = $db->fetchByAssoc($getPhoneDetal);
            
            //Start Using for WhatsApp Gupshup APi
            $url_gupshup  = 'https://media.smsgupshup.com/GatewayAPI/rest?';
            
            if($db->getRowCount($getPhoneDetal) <= 0 && $resultData['batch_code'] == $batchCode ){
              $url_opt_in_gupshup = $url_gupshup.'method=OPT_IN&format=json&userid='.$sugar_config['whatsapp_gupshup_userid'].'&password='.$sugar_config['whatsapp_gupshup_pass'].'&phone_number='.$phone.'&v=1.1&auth_scheme=plain&channel=WHATSAPP';
              $ch     = curl_init();
              curl_setopt($ch, CURLOPT_URL, $url_opt_in_gupshup);
              # Return response instead of printing.
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
              curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
              curl_setopt($ch, CURLOPT_TIMEOUT, 30);
              # Send request.
              $result = curl_exec($ch);
                curl_close($ch);
              $jsonresultData = json_decode($result);
                // echo "<pre>";
                //   print_r($resultData);
                //   print_r($jsonresultData->response->status);
                //   die('imhere');
                  
                if($jsonresultData->response->status == 'success'){
                    $insertPhoneNum = "INSERT INTO gupshup_leads_details (`date_entered`,`date_modified`,`phone_mobile`,`batch_code`,`utm_source`, `send_whatsapp`,`opt_in`) VALUES ('".date('Y-m-d h:i:s')."','".date('Y-m-d h:i:s')."','".$phone."', '".$resultData['batch_code']."', '".$source."', '".$result."','1')";
                    $insertPhoneNumData = $db->query($insertPhoneNum);
                } else {
                    createLog('{In Add Case}', 'zsend_gupshup_not_optin_log_'.date('Y-m-d').'.txt', $_REQUEST, $result);
                }
//createLog('{In check gupshup test}', 'zzsend_gupshup_'.date('Y-m-d').'_log.txt', $_REQUEST, $result);
            }
            //End Using for OPT_IN Gupshup APi
            $phoneNum = "select phone_mobile from gupshup_leads_details where phone_mobile='".$phone."' ";
            $getPhoneDetail = $db->query($phoneNum);
            $getPhoneNum1 = $db->fetchByAssoc($getPhoneDetail);
            // echo "<pre>"; print_r($getPhoneNum);print_r($resultData);print_r($batchCode);print_r($getPhoneNum1);print_r($phone);

            // die; 
            if($getPhoneNum1['phone_mobile'] == $phone && $resultData['batch_code'] == $batchCode ){
            //*<a href='tel:+91".$resultData['number']."'>+91". $resultData['number']."</a>*
$caption_Core_Data = "Your registration for *".$resultData['institute_name']." ".$resultData['course_name']."* is successfully completed.

For the course details, download the attached brochure.

You can call us on ".$resultData['number']." or reply Hi to this message to chat with our counsellor on WhatsApp.";

                // $captionData = urlencode($caption_Core_Data);
                $captionData = rawurlencode($caption_Core_Data);
                
               $url_media_gupshup = $url_gupshup.'send_to='.$phone.'&msg_type=DOCUMENT&userid='.$sugar_config["whatsapp_gupshup_userid"].'&auth_scheme=plain&password='.$sugar_config["whatsapp_gupshup_pass"].'&method=SendmediaMessage&v=1.1&media_url='.$resultData["brochure_url"].'&caption='.$captionData.'&isHSM=True&footer=TALENTEDGE&filename='.rawurlencode($resultData['course_name']).'&format=json';
                //print_r($url_media_gupshup);die;
                //https://media.smsgupshup.com/GatewayAPI/rest?send_to=9930079420&msg_type=DOCUMENT&userid=2000199169&auth_scheme=plain&password=xHeVYaDP&method=SendmediaMessage&v=1.1&media_url=http://www.africau.edu/images/default/sample.pdf&caption=Your%20registration%20for%20test%20test%20is%20successfully%20completed.%0A%0AFor%20the%20course%20details%2C%20download%20the%20attached%20brochure.%0A%0AYou%20can%20call%20us%20on%20test%20or%20reply%20Hi%20to%20this%20message%20to%20chat%20with%20our%20counsellor%20on%20WhatsApp.&isHSM=True&footer=TALENTEDGE&filename=TEST123&format=json

                $ch     = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url_media_gupshup);
                # Return response instead of printing.
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
                curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                # Send request.
                $result = curl_exec($ch);
                
                $jsonresultData = json_decode($result);
                curl_close($ch);
                // echo "<pre>";
                //   print_r($resultData);
                //   print_r($jsonresultData->response->status);
                //   die('imhere');
                  
                if($jsonresultData->response->status == 'success'){
                    $updateData = "UPDATE gupshup_leads_details SET send_whatsapp = '".$caption_Core_Data."', date_modified = '".date('Y-m-d h:i:s')."' where phone_mobile='".$phone."' ";
                    $itemDetal=$db->query($updateData);
                    createLog('{In Add Case}', 'zsend_gupshup_sendmedia_success_log_'.date('Y-m-d').'.txt', $_REQUEST, $result);
                } else {
                    createLog('{In Add Case}', 'zsend_gupshup_sendmedia_error_log_'.date('Y-m-d').'.txt', $_REQUEST, $result);
                }

createLog('{Check Default Case}', 'zsend_gupshup_sendmedia_default_log_'.date('Y-m-d').'.txt', $_REQUEST, $result);
                
            } else {
                createLog('{In Add Case}', 'zsend_gupshup_log_'.date('Y-m-d').'.txt', $_REQUEST, $result);
            }
        }

    
    //End Using for WhatsApp Gupshup APi


}
else
{
    //echo json_encode(array('status'=>'error','msg'=>'Email, Utm source, utm medium and utm term is required field')); exit();	
    echo json_encode(array('status' => 'error', 'msg' => 'Mobile or Email is required field'));
    exit();
}

//$updateData = "Insert into test_check_data (datacheck,batch_code, date_entered) VALUES('".$phone."','term',now()) ";
  //          $itemDetal=$db->query($updateData);

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

$updateData = "Insert into test_check_data (datacheck,batch_code, date_entered) VALUES('".$sql."','".$term."',now()) ";
            $itemDetal=$db->query($updateData);


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
    $leadObj->msg_whatsapp_clvrtp  = $clvrtp_whatsapp;
if ($gupshup_whatsapp)
    $leadObj->msg_whatsapp_gupshup = $gupshup_whatsapp;
    
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


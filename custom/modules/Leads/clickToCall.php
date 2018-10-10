<?php

require_once('custom/modules/te_Api/te_Api.php');
//Client to test Neox Dial Call API with JSON format 

$mobile_number = filter_var($_GET['number'], FILTER_SANITIZE_NUMBER_INT);
$lead_id   = filter_var($_GET['lead'], FILTER_SANITIZE_STRING);

if (!empty($lead_id) && !empty($mobile_number ))
{

    global $current_user, $db;

    function writeLog($file_name, $action_name, $data = '', $array = array())
    {
        $file = fopen(str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']) . "upload/apilog/$file_name", "a");
        fwrite($file, date('Y-m-d H:i:s') . "\n");
        fwrite($file, $action_name . "\n");
        fwrite($file, $data . "\n");
        fwrite($file, print_r($array, TRUE) . "\n");
        fclose($file);
    }

    writeLog('new_dispose_log.txt', '1. Click To Call func ', $lead_id, $_GET);


    $leadQuery = "select id,first_name,last_name,phone_mobile,phone_home,phone_work,phone_other,assigned_user_id from leads where id='" . $lead_id . "'";
    $res  = $db->query($leadQuery);


    $SBlead = "select leads_id,assigned_user_id from te_student_batch where leads_id='" . $lead_id . "'";
    $SBres  = $db->query($SBlead);


    if ($db->getRowCount($SBres) > 0)
    {
        $SBdata = $db->fetchByAssoc($SBres);

        writeLog('srm_dispose_log.txt', '1. SRM Click To Call func ', $SBdata['assigned_user_id'], $SBdata);
    }

    if ($db->getRowCount($res))
    {
        $resdata = $db->fetchByAssoc($res);

        if (($current_user->id == $resdata['assigned_user_id']) || $current_user->id == $SBdata['assigned_user_id'])
        {
            $drobj = new te_Api_override();

            $session = $_SESSION['amyoSID'];
            if ($session)
            {
                $arrReq                            = [];
                $arrReq['campaignId']              = $_SESSION['amyoCID'];
                $arrReq['sessionId']               = $session;
                $arrReq['searchable']              = $resdata['id'];
                $arrReq['phone']                   = $mobile_number;
                $customerRecords                   = [];
                if ($resdata['first_name'] || $resdata['last_name'])
                    $customerRecords['name']           = $resdata['first_name'] . " " . $resdata['last_name'];
                if ($resdata['first_name'])
                    $customerRecords['first_name']     = $resdata['first_name'];
                if ($resdata['last_name'])
                    $customerRecords['last_name']      = $resdata['last_name'];
                //if($resdata['email_address'] )  $customerRecords['email'] = $resdata['email_address'];
                if ($resdata['phone_mobile'])
                    $customerRecords['phone1']         = $resdata['phone_mobile'];
                if ($resdata['phone_home'])
                    $customerRecords['phone2']         = $resdata['phone_home'];
                if ($resdata['phone_work'])
                    $customerRecords['phone3']         = $resdata['phone_work'];
                if ($resdata['phone_other'])
                    $customerRecords['phone4']         = $resdata['phone_other'];
                if ($resdata['id'])
                    $customerRecords['lead_reference'] = $resdata['id'];

                $arrReq['customerRecord'] = $customerRecords;

                if (!$drobj->call($session, $arrReq))
                {
                    echo "Something gone wrong. Please try again!";
                }
            }
            else
            {
                echo "Something gone wrong. Please try again!";
            }
        }
    }
    else
    {
        echo "1st: Call Can't be connected";
    }
}
else
{
    echo "2nd: Call Can't be connected";
}

exit();
?>

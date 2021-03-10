<?php

ini_set('max_execution_time', 3600);
set_time_limit(3600);
require_once('custom/modules/te_Api/te_Api.php');
$api = new te_Api_override();
global $db;


function createLog($action, $filename, $field = '', $dataArray = array())
{
    $file = fopen(str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']) . "upload/apilog/$filename", "a");
    fwrite($file, date('Y-m-d H:i:s') . "\n");
    fwrite($file, $action . "\n");
    fwrite($file, $field . "\n");
    fwrite($file, print_r($dataArray, TRUE) . "\n");
    fclose($file);
}


// $sql    = "select lead_id from cron_job where session_id='cron_job'";
// $result = $db->query($sql);
// if ($db->getRowCount($result) > 0)
// {
//     $res = $db->fetchByAssoc($result);
//     if ($res['lead_id'] == 1)
//         exit();
// }

// Delete API {"campaignId":"1","sessionId":"abc-133123-xyz","customerIds":[123456,123456,123456]}

$campaignId                        = 18;
$customerIds                       = 42;
$api                               = new te_Api_override();
$data                              = [];
$session                           = $api->doLogin();
$data['sessionId']                 = $session;
echo "Brijesh imhere";
echo $session;
echo "====================imhere========="; die('the end');
// removeContactsFromCampaign($campaignId='',$sessionId,$customerIds='')
$responses = $api->removeContactsFromCampaign($campaignId, $data['sessionId'], $customerIds);


echo $responses;
// $db->query("update cron_job set lead_id='0' where session_id='cron_job'");
// echo json_encode(array('status'=>'success','current_queue'=>$db->getRowCount($result))); 
exit();

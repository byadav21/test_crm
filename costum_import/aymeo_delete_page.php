<?php
error_reporting(E_ALL);
// ini_set('max_execution_time', 3600);
// set_time_limit(3600);
require_once('custom/modules/te_Api/te_Api.php');
$api = new te_Api_override();
global $db;

class aymeo_deleteAPI {


    // Delete API {"campaignId":"1","sessionId":"abc-133123-xyz","customerIds":[123456,123456,123456]}
    function main(){
        
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


        echo "<pre>";print_r($responses);
        // $db->query("update cron_job set lead_id='0' where session_id='cron_job'");
        // echo json_encode(array('status'=>'success','current_queue'=>$db->getRowCount($result))); 
        exit();
    }
}

$mainObj = new aymeo_deleteAPI();
$mainObj->main();
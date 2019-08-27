<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
ini_set('memory_limit', '1024M');
require_once('include/entryPoint.php');
require_once('custom/modules/Leads/eloqua/lib/eloquaRequest.php');

//error_reporting(-1);
//ini_set('display_errors', 'On');

global $db;
error_reporting(-1);
ini_set('display_errors', 'On');

class eloquaScore
{

    function createLog($req, $action)
    {
        $file = fopen(str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']) . "upload/apilog/eloquaScore_log.txt", "a");
        fwrite($file, date('Y-m-d H:i:s') . "\n");
        fwrite($file, $action . "\n");
        fwrite($file, print_r($req, TRUE) . "\n");
        fclose($file);
    }

    public function main()
    {
        global $sugar_config, $app_list_strings, $current_user, $db;

        $client    = new EloquaRequest('https://secure.p07.eloqua.com/api/bulk/2.0');
        $exportUri = '';

        $json      = '{
                    "name": "Contact Lead Score Export",
                    "fields": {
                        "Rating": "{{Contact.LeadScore.Model[1].Rating}}",
                        "Profile": "{{Contact.LeadScore.Model[1].ProfileScore}}",
                        "Engagement": "{{Contact.LeadScore.Model[1].EngagementScore}}",
                        "EmailAddress": "{{Contact.Field(C_EmailAddress)}}"
                    }
                }';
        $exportReq = json_decode($json, true);


        //1. this will be called to export

        $expResponse = $client->post("contacts/exports", $exportReq);
        $this->createLog($expResponse, '1. Export API');
        $exportUri   = $expResponse->uri;

        if ($exportUri != '')
        {
            sleep(50);
            //2. this will be called to export   

            $json         = '{
                        "syncedInstanceUri" : "' . $exportUri . '"
                   }';
            $syncReq      = json_decode($json, true);
            $syncResponse = $client->post("syncs", $syncReq);
            $this->createLog($syncResponse, '2. Syncs API');
            $syncStatus   = $syncResponse->status;
            $syncURI      = $syncResponse->uri;


            if ($syncStatus == 'pending' && $syncURI != '')
            {
                sleep(50);
                $checkStatus = $client->get($syncURI);
                $this->createLog($checkStatus, '3. Check export Status API');
                $finalStatus = $checkStatus->status;
                sleep(100);
                if ($finalStatus == 'success' || $finalStatus == 'active')
                {

                    $ExportSyncurl = $checkStatus->uri;
                    //echo 'xxxx' . $finalStatus.'$ExportSyncurl='.$ExportSyncurl;
                    ###################
                    //echo '<pre>';
                    //print_r($checkStatus);
                    //die;
                    
                    $db->query("insert into eloqua_sync_score_api set 
                    syncedInstanceUri='" . $checkStatus->syncedInstanceUri . "', 
                    syncStartedAt='" . date( 'Y-m-d h:i:s', strtotime($checkStatus->syncStartedAt)) . "', 
                    syncEndedAt='" . date( 'Y-m-d h:i:s', strtotime($checkStatus->syncEndedAt)) . "',
                    status='" . $checkStatus->status     . "',
                    createdAt='" . date( 'Y-m-d h:i:s', strtotime($checkStatus->createdAt)) . "',
                    createdBy='" . $checkStatus->createdBy. "',
                    uri='" . $checkStatus->uri . "'");

                    $itemcount = 711180;
                    $limit     = 1000;
                    $interval  = $itemcount / $limit;

                    /////////////// start it on offset with 0
                    echo "$ExportSyncurl/data?offset=0&limit=$limit<br>";
                    $response = $client->get("$ExportSyncurl/data?offset=0&limit=$limit");
                    $array    = json_decode(json_encode($response), true);


                    if (!empty($array['items']))
                    {
                        foreach ($array['items'] as $key => $val)
                        {

                            $Rating       = isset($val['Rating']) ? $val['Rating'] : '';
                            $EmailAddress = isset($val['EmailAddress']) ? $val['EmailAddress'] : '';

                            if ($Rating != '' && $EmailAddress != '')
                            {

                                $sql = "update leads_cstm set eloqua_lead_score='$Rating' where email_add_c='$EmailAddress'";
                                $re  = $GLOBALS['db']->query($sql);
                            }
                        }
                    } // End of empty array
                    ///////////////
                    echo '<pre>'; print_r($array);
                        

                    for ($i = 1; $i <= $interval; $i++)
                    {
                        $offset = $i * $limit;

                        echo "$ExportSyncurl/data?offset=$offset&limit=$limit<br>";
                        $response = $client->get("$ExportSyncurl/data?offset=$offset&limit=$limit");
                        $array    = json_decode(json_encode($response), true);


                        if (!empty($array['items']))
                        {
                            foreach ($array['items'] as $key => $val)
                            {

                                $Rating       = isset($val['Rating']) ? $val['Rating'] : '';
                                $EmailAddress = isset($val['EmailAddress']) ? $val['EmailAddress'] : '';

                                if ($Rating != '' && $EmailAddress != '')
                                {

                                    $sql = "update leads_cstm set eloqua_lead_score='$Rating' where email_add_c='$EmailAddress'";
                                    $re  = $GLOBALS['db']->query($sql);
                                }
                            }
                        } // End of empty array

                        echo '<pre>';
                        print_r($array);
                    } // End of For loop 
                    ###################
                }
            }
        }
    }

// End of main function
}

$mainObj = new eloquaScore();
$mainObj->main();



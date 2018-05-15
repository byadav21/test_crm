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

                $checkStatus = $client->get($syncURI);
                $this->createLog($checkStatus, '3. Check export Status API');
                $finalStatus = $checkStatus->status;

                if ($finalStatus == 'success' || $finalStatus == 'active')
                {
                    
                    $ExportSyncurl = $checkStatus->uri;
                    //echo 'xxxx' . $finalStatus.'$ExportSyncurl='.$ExportSyncurl;

                    ###################

                    //echo '<pre>';
                    //print_r($checkStatus);
                    //die;

                    $itemcount = 704;
                    $limit     = 100;
                    $interval  = $itemcount / $limit;

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



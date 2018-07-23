<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
ini_set('memory_limit', '1024M');
require_once('include/entryPoint.php');


global $db;
error_reporting(-1);
ini_set('display_errors', 'On');

class updatecampaignByBatch
{

    function createLog($req, $action)
    {
        $file = fopen(str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']) . "upload/apilog/ameyo_campaignID_apiID_update.txt", "a");
        fwrite($file, date('Y-m-d H:i:s') . "\n");
        fwrite($file, $action . "\n");
        fwrite($file, $req . "\n");
        fclose($file);
    }

    function getLeads()
    {

        global $db;
        $leadsCstmData = array();

        $query   = "select
                                    leads.id,
                                    leads.utm_term_c,
                                    lc.te_ba_batch_id_c,
                                    leads.dristi_api_id,
                                    leads.dristi_campagain_id,
                                    bb.d_campaign_id,
                                    bb.d_lead_id
                            from leads 
                            inner join leads_cstm lc on leads.id=lc.id_c 
                            inner join te_ba_batch bb on lc.te_ba_batch_id_c=bb.id
                            where
                            date(leads.date_entered)='".date('Y-m-d')."'  
                            AND ((leads.dristi_api_id is null OR leads.dristi_api_id='') 
                             OR (leads.dristi_campagain_id is null OR leads.dristi_campagain_id=''))
                            AND leads.neoxstatus='0'
                            AND leads.deleted =0
                            AND leads.autoassign='yes'
                            AND (leads.assigned_user_id= 'NULL'
                                       OR leads.assigned_user_id =''
                                       OR leads.assigned_user_id IS NULL)";
        $leadObj = $db->query($query);
        if ($leadObj)
        {

            while ($row = $db->fetchByAssoc($leadObj))
            {
                $leadsCstmData[] = $row;
            }
        }

        return $leadsCstmData;
    }

    function main()
    {
        global $db;
        $leadsCstmData = array();

        $DataArr = $this->getLeads();

        //echo "<pre>";
        //print_r($DataArr);
        //die;


        foreach ($DataArr as $key => $data)
        {
            $d_campaign_id = $data['d_campaign_id'];
            $d_lead_id     = $data['d_lead_id'];

            if ($data['d_campaign_id'] != '' && $data['d_lead_id'] != '')
            {

                $sql = "UPDATE leads
                                    SET dristi_api_id=$d_lead_id,
                                        dristi_campagain_id=$d_campaign_id,
                                        date_modified=NOW()
                                    WHERE id='" . $data['id'] . "'";
                $db->query($sql);
                $this->createLog($sql, ':new line:');
            }else{
                
                 $this->createLog('LeadID: '.$data['id'], 'd_campaign_id not found!');
            }
        }
    }

// END of Main
}

$mainObj = new updatecampaignByBatch();
$mainObj->main();


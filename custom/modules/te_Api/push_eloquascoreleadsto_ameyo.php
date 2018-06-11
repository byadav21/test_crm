<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

ini_set('memory_limit', '1024M');
require_once('include/entryPoint.php');
global $db;
error_reporting(-1);
ini_set('display_errors', 'On');
$query  = "SELECT  lead.id,
                    batch.d_campaign_id,
                    batch.d_lead_id,
                    leadcstm.email_add_c as email_id,
                    leadcstm.te_ba_batch_id_c as batch_id,
                    lead.phone_mobile as mobile_no,
                    lead.autoassign,
                    lead.neoxstatus,
                    lead.assigned_user_id,
                    lead.update_flag,
                    lead.dristi_campagain_id,
                    lead.dristi_API_id,
                    lead.status,
                    lead.status_description
             FROM `leads_cstm` AS `leadcstm`
             INNER JOIN `te_ba_batch` AS `batch` ON leadcstm.te_ba_batch_id_c = batch.id
             INNER JOIN `leads` AS `lead` ON leadcstm.id_c = lead.id
             WHERE leadcstm.eloqua_lead_score IN ('A1',
                                                  'A2',
                                                  'A3',
                                                  'B1',
                                                  'B2')
               AND lead.status_description IN ('Fallout',
                                               'Not interested',
                                               'Retired',
                                               'Cross Sell',
                                               'Not Enquired',
                                               'Next Batch')
               AND batch.batch_status = 'enrollment_in_progress'
               AND lead.deleted = '0'
               AND lead.update_flag = '0'
             GROUP BY leadcstm.te_ba_batch_id_c,
                      lead.phone_mobile,
                      leadcstm.email_add_c
             ORDER BY lead.date_entered ASC
             LIMIT 100";
$result = $db->query($query);

if ($db->getRowCount($result) > 0)
{

    $lead_detail = array();
    while ($row         = $db->fetchByAssoc($result))
    {

        $lead_id               = $row['id'];
        $lead_detail[$lead_id] = $row;
    }
}


//echo '<pre>'; print_r($lead_detail); die;

$final_array = array();
foreach ($lead_detail as $key => $val)
{

    $lead_id   = $key;
    $batch_id  = $val['batch_id'];
    $mobile_no = $val['mobile_no'];
    $email_id  = $val['email_id'];


    $query_new = "SELECT    leadcstm.id_c,
                            lead.status,
                            lead.status_description
                     FROM `leads_cstm` AS `leadcstm`
                     RIGHT JOIN `leads` AS `lead` ON leadcstm.id_c = lead.id
                     WHERE leadcstm.te_ba_batch_id_c='$batch_id' && lead.phone_mobile='$mobile_no' && leadcstm.email_add_c='$email_id' ";

    $resultm = $db->query($query_new);
    // print_r($resultm);

    while ($rowm = $db->fetchByAssoc($resultm))
    {

        $new_val                     = $rowm['id_c'];
        $final_array[$key][$new_val] = $rowm['status'];
        if ($rowm['status'] == 'Converted')
        {
            unset($final_array[$key]);
        }
    }
}


//echo '<pre>'; print_r($final_array); die;
$to_be_update_leads = array();
foreach ($final_array as $key => $val)
{

    $autoassign          = $lead_detail[$key]['autoassign'];
    $status              = $lead_detail[$key]['status'];
    $status_description  = $lead_detail[$key]['status_description'];
    $neoxstatus          = $lead_detail[$key]['neoxstatus'];
    $assigned_user_id    = $lead_detail[$key]['assigned_user_id'];
    $update_flag         = $lead_detail[$key]['update_flag'];
    $dristi_campagain_id = $lead_detail[$key]['dristi_campagain_id'];
    $dristi_API_id       = $lead_detail[$key]['dristi_API_id'];
    $d_campaign_id       = $lead_detail[$key]['d_campaign_id'];
    $d_lead_id           = $lead_detail[$key]['d_lead_id'];

    foreach ($val as $index => $valm)
    {
        echo 'LeadID='.$index.'<br>';

        $c_lead_id      = $index;
        //insert query in lead table 'lead_logdata'
        echo $insert_logdata = "INSERT INTO `leads_logdata` ( `lead_id`, `autoassign`, `status`, `status_description`, `neoxstatus`, `assigned_user_id`, `update_flag`, `dristi_campagain_id`, `dristi_API_id`)
    VALUES ( '$c_lead_id', '$autoassign', '$status', '$status_description', '$neoxstatus', '$assigned_user_id', '$update_flag', '$dristi_campagain_id', '$dristi_API_id');";
        $db->query($insert_logdata);
        echo '<br>';
        
        
        //update query in lead table
        echo $update_lead    = "UPDATE `leads` SET `autoassign` = 'Yes', `status` = 'Alive', `status_description` = 'New Lead', `neoxstatus` = '0',`assigned_user_id` = '', `update_flag` = '1', `dristi_campagain_id` = '$d_campaign_id',   `dristi_API_id` = '$d_lead_id',`update_timestamp`= now() WHERE `id` = '$c_lead_id'";
        $db->query($update_lead);
          echo '<br>';
    }
}


<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
require_once('custom/modules/Leads/eloqua/lib/eloquaRequest.php');

//error_reporting(-1);
//ini_set('display_errors', 'On');

class eloqua_contact
{

    function createLog($action, $filename, $field = '', $dataArray = array())
    {
        $file = fopen(str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']) . "upload/apilog/$filename", "a");
        fwrite($file, date('Y-m-d H:i:s') . "\n");
        fwrite($file, $action . "\n");
        fwrite($file, $field . "\n");
        fwrite($file, print_r($dataArray, TRUE) . "\n");
        fclose($file);
    }

    function delete_leads_eloqua()
    {
        global $db;

        //echo "<pre>"; print_r($bean);

        $leadObj = $db->query("SELECT 
                                    lc.eloqua_contact_id,
                                    lc.eloqua_customobject_id,
                                    lc.eloqua_contact_status,
                                    lc.eloqua_customobject_status
                             FROM leads_cstm lc
                             INNER JOIN leads l ON lc.id_c=l.id
                             WHERE l.deleted=0
                               AND (lc.eloqua_contact_id!=''
                                    OR lc.eloqua_customobject_id!='')
                               and lc.email_add_c like 'test%'
                             LIMIT 10");

        $result = $db->query($query);

        $contact_client = new EloquaRequest('https://secure.p07.eloqua.com/API/REST/1.0');
        $custome_client = new EloquaRequest('https://secure.p07.eloqua.com/API/REST/2.0');

        if ($db->getRowCount($result) > 0)
        {
            $lead_detail = array();
            while ($row         = $db->fetchByAssoc($result))
            {

                $contact_id      = $row['eloqua_contact_id'];
                $customobject_id = $row['eloqua_customobject_id'];
                $lead_id         = $row['eloqua_contact_id'];

                if ($contact_id != '')
                {
                    $response = $contact_client->delete('/data/contact/' . $contact_id, '');

                    if ($response)
                    {
                        createLog('{In $contact_id}', 'delete_eloqua_log_' . date('Y-m-d') . '.txt', $contact_id, $response);
                    }
                }

                if ($customobject_id != '')
                {
                    $response = $custome_client->delete('/data/customObject/7/instance/' . $customobject_id, '');
                    if ($response)
                    {
                        createLog('{In $customobject_id}', 'delete_eloqua_log_' . date('Y-m-d') . '.txt', $customobject_id, $response);
                    }
                }
            }
        }
    }

}
$mainObj = new eloqua_contact();
$mainObj->delete_leads_eloqua();

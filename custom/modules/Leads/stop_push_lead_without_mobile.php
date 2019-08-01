<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

//error_reporting(-1);
//ini_set('display_errors', 'On');

class checkLeadsMobile
{

    function check_leads_mobile(&$bean, $event, $argument)
    {
        global $db;
        $beanId             = $bean->id;
        $phone              = $bean->phone_mobile;
        $email              = $bean->email_add_c;
        $batchid            = $bean->te_ba_batch_id_c;
        $modified_user_id   = $bean->modified_user_id;
        $created_by         = $bean->created_by;
        $vendor             = $bean->vendor;
        $status             = $bean->status;
        $status_description = $bean->status_description;
        $term               = $bean->utm_term_c;
        $source             = $bean->utm_source_c;
        $medium             = $bean->utm_contract_c;


        if (($phone == '' || strlen($phone) <= 7) && $status_description == 'New Lead')
        {
            $this->createLog('{while snag phone found:}', 'stop_push_lead_without_mobile_' . date('Y-m-d') . '_log.txt', '', array('LeadID'   => $beanId,
                'vendor'   => $vendor,
                'email'    => $email,
                'phone'    => $phone,
                'batch_id' => $batchid,
                'utm_term' => $term,
                'source'   => $source,
                'medium'   => $medium));

            $bean->autoassign          = 'No';
            $bean->neoxstatus          = '2';
            $bean->assigned_user_id    = '';
            $bean->dristi_campagain_id = '03';
            $bean->dristi_API_id       = '03';


        
        }
    }

    function createLog($action, $filename, $field = '', $dataArray = array())
    {
        $file = fopen(str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']) . "upload/apilog/$filename", "a");
        fwrite($file, date('Y-m-d H:i:s') . "\n");
        fwrite($file, $action . "\n");
        fwrite($file, $field . "\n");
        fwrite($file, print_r($dataArray, TRUE) . "\n");
        fclose($file);
    }

}

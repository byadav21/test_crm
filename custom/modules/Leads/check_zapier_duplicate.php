<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

error_reporting(-1);
ini_set('display_errors', 'On');

class checkZapierLeads
{

    function check_duplicate_leads(&$bean, $event, $argument)
    {
        global $db;
        $beanId     = $bean->id;
        $created_by = $bean->created_by;
        $phone      = $bean->phone_mobile;
        $email      = $bean->email_add_c;
        $batchid    = $bean->te_ba_batch_id_c;
        $batchId    = $bean->created_by;

        $sourcesArr = array('Linkedin', 'TE_Focus');

        $vendor = $bean->vendor;
        echo '$vendor==='.$vendor.'$created_by=='.$created_by; die;
        //!in_array($vendor, $sourcesArr) ||(
        if ($created_by != '695fff76-e5ed-19b1-a61f-5c20f44b3efe')
        {   
              echo 'www==='.$vendor.'weee=='.$created_by; die;
              
            $this->createLog('{while false return:}', 'check_zapier_duplicate_' . date('Y-m-d') . '_log.txt', $vendor, array('$beanId'=>$beanId,'vendor'=>$vendor,'created_by'=>$created_by));
            return;
        }



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

        $this->createLog('{Lead get updated:}', 'check_zapier_duplicate_' . date('Y-m-d') . '_log.txt', $sql, array('$beanId'=>$beanId));

        $autoassign       = 'Yes';
        $assigned_user_id = NULL;
        $duplicate_check  = 0;

        $re = $GLOBALS['db']->query($sql);
        if ($GLOBALS['db']->getRowCount($re) > 0)
        {

            $updateSql    = "update leads 
                                                SET
                                            autoassign          = 'No',
                                            neoxstatus          = '',
                                            assigned_user_id    = '',
                                            status_description   = 'Re-Enquired',
                                            status              = 'Warm',
                                            dristi_campagain_id = '',
                                            dristi_API_id       = '',
                                            date_modified       = NOW()  where id='$beanId'";
            $updateSqlres = $db->Query($updateSql);

            if ($updateSqlres)
            {
                $this->createLog('{Lead get updated:}', 'check_zapier_duplicate_' . date('Y-m-d') . '_log.txt', $updateSqlres, array());

                $guidid            = create_guid();
                $insertSql         = "INSERT INTO te_disposition
                                                SET id          =   '$guidid',
                                            status              =   'Warm',
                                            status_detail       =   'Re-Enquired',
                                            date_modified       =   NOW(),
                                            date_entered        =   NOW()";
                $te_disposition_id = $db->Query($insertSql);


                $guidid2        = create_guid();
                $insertDis_cSql = "INSERT INTO te_disposition_leads_c
                                                SET id          =   '$guidid2',
                          te_disposition_leadste_disposition_idb=   '$guidid',
                          te_disposition_leadsleads_ida         =   '$beanId',
                                            date_modified=NOW()";
                $db->Query($insertDis_cSql);
            }
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

<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
ini_set('memory_limit', '1024M');
require_once('include/entryPoint.php');

global $db;
error_reporting(-1);
ini_set('display_errors', 'On');

class updateUTM
{

    public $fromDate;
    public $toDate;

    public function __construct()
    {
        $this->fromDate = date('Y-m-d');
        $this->toDate   = date('Y-m-d');
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

    public function main()
    {
        global $sugar_config, $app_list_strings, $current_user, $db;



        //$fetchUtm = $this->fetchUtm();
        $getLeads = $this->getLeads();
        echo '<pre>';
        //print_r($getLeads);
        $uname    = '';

        foreach ($getLeads as $key => $val)
        {
            $source  = $val['utm_source_c'];
            $medium  = $val['utm_contract_c'];
            $term    = $val['utm_term_c'];
            $leadid  = $val['id'];
            
            $arrayLog = array($leadid,$source,$medium,$term);
            $utmData = $this->fetchUtm($source, $medium, $term);
            //$utmData = $this->fetchUtm('ileap', 'cpl', 'Batch-001');
          
            if ($utmData)
            {
                $uname = $utmData['name'];
                if ($uname)
                {
                    $updateUtmQ = "UPDATE leads set utm='$uname' where id='$leadid'";
                    $db->query($updateUtmQ);
                    
                     $this->createLog('{UTM updated}', 'utm_update_' . date('Y-m-d') . '_log.txt', $updateUtmQ, $utmData);
                }
                else
                {
                    $this->createLog('{NULL UTM name in contract}', 'utm_update_' . date('Y-m-d') . '_log.txt', $leadid, $arrayLog);
                }
            }
            else
            {
                 $this->createLog('{UTM is not Created}', 'utm_update_' . date('Y-m-d') . '_log.txt', $leadid, $arrayLog);
            }
        }
    }

    public function fetchUtm($source, $medium, $term)
    {
        global $db;

        $sql = "SELECT u.te_ba_batch_id_c,
                            u.name,
                            b.d_campaign_id,
                            b.d_lead_id,
                            tv.id AS vendor_id
                     FROM te_utm u
                     INNER JOIN te_vendor_te_utm_1_c v ON v.te_vendor_te_utm_1te_utm_idb=u.id
                     INNER JOIN te_vendor tv ON tv.id=v.te_vendor_te_utm_1te_vendor_ida
                     AND tv.name='$source'
                     INNER JOIN te_ba_batch b ON b.id=u.te_ba_batch_id_c
                     AND b.batch_code='$term'
                     INNER JOIN aos_contracts c ON c.id=u.aos_contracts_id_c
                     AND c.contract_type='$medium'
                     WHERE utm_status!='Expired'
                       AND u.deleted=0
                       AND v.deleted=0
                       AND tv.deleted=0
                       AND b.deleted=0
                       AND c.deleted=0 ";

        $results = $db->query($sql);
        if ($db->getRowCount($results) > 0)
        {
            $utm = $db->fetchByAssoc($results);
            return $utm;
        }
        else
        {
            return false;
        }
    }

    public function getLeads()
    {
        global $sugar_config, $app_list_strings, $current_user, $db;
        $ignore_vendors = "'facebook','google','te_focus','taboola','chat','eloqua','Linkedin','NA_VENDOR','Website','Social','Chat'";
       echo $leadSql        = "SELECT   id,
                            utm,
                            utm_source_c,
                            utm_term_c,
                            utm_contract_c
                     FROM leads
                     WHERE deleted=0
                       AND date(leads.date_entered) >= '$this->fromDate'
                       AND date(leads.date_entered) <= '$this->toDate'
                       AND vendor NOT IN ($ignore_vendors)
                       AND (utm='' or utm is null or utm='NA') 
                       AND utm_source_c!='' 
                       AND utm_term_c!=''
                       AND utm_contract_c!='' limit 1000";
        //echo $leadSql;exit();


        $leadObj = $db->query($leadSql);
        $data    = array();
        while ($row     = $db->fetchByAssoc($leadObj))
        {
            $data[] = $row;
        }
        return $data;
    }

}

$mainObj = new updateUTM();
if (strtotime($mainObj->fromDate) == strtotime($mainObj->toDate))
{
    $fromDate = date('Y-m-d', (strtotime('-1 day', strtotime($mainObj->fromDate))));
    //$fromDate = '2019-09-28';
}

$mainObj->toDate   = $fromDate;
$mainObj->fromDate = $fromDate;

$mainObj->main();


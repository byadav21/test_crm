<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
ini_set('memory_limit', '1024M');
require_once('include/entryPoint.php');
require_once('custom/include/Email/sendmail_cron.php');
global $db;
error_reporting(-1);
ini_set('display_errors', 'On');

class sendVisitReport
{

    public $fromDate;
    public $toDate;

    public function __construct()
    {
        $this->fromDate = date('Y-m-d');
        $this->toDate   = date('Y-m-d');
    }

    public function main()
    {
        global $sugar_config, $app_list_strings, $current_user, $db;
        $mail = new FalconideEmail();

        $file     = "VendorWiseStatusReport_report";
        $where    = '';
        $filename = $file . "_" . $this->toDate;

        $leadSql = "SELECT COUNT(l.id) AS lead_count,
                    l.date_entered,
                    te_ba_batch.id AS batch_id,
                    te_ba_batch.name AS batch_name,
                    te_ba_batch.batch_code,
                    l.status,
                    l.vendor,
                    te_vendor.id vendor_id
                   
                FROM leads l
                INNER JOIN leads_cstm AS lc ON l.id=lc.id_c
                LEFT JOIN te_ba_batch ON lc.te_ba_batch_id_c = te_ba_batch.id
                LEFT JOIN te_vendor on lower(l.vendor)=lower(te_vendor.name)
                 WHERE l.deleted=0 and l.date_entered >= '$this->toDate 00:00:00' AND l.date_entered <= '$this->toDate 23:59:59'
               GROUP BY l.status,te_vendor.id order by  te_ba_batch.batch_code";
        //echo $leadSql;exit();


        $leadObj = $db->query($leadSql);

        $vendor = 'NULL';

        while ($row = $db->fetchByAssoc($leadObj))
        {
            if ($row['vendor'] == '')
            {
                $row['vendor'] = $vendor;
            }



            $programList[$row['vendor']][$row['batch_id']]['batch_id']   = $row['batch_id'];
            $programList[$row['vendor']][$row['batch_id']]['batch_name'] = $row['batch_name'];
            $programList[$row['vendor']][$row['batch_id']]['batch_code'] = $row['batch_code'];
            $programList[$row['vendor']][$row['batch_id']]['vendor']     = $row['vendor'];
            $programList[$row['vendor']][$row['batch_id']]['lead_count'] = $row['lead_count'];
            $programList[$row['vendor']][$row['batch_id']]['status']     = $row['status'];

            $programList[$row['vendor']][$row['batch_id']][$row['status']] = $row['lead_count'];
            $StatusList[$row['status']]                                    = $row['status'];
            //$programList[$row['batch_id']][$row['status']] = $row['lead_count'];
        }



        # Create heading
        $data = "Programme Name";
        $data .= ",Batch Code";
        $data .= ",Vendor";
        foreach ($StatusList as $key => $statusVal)
        {
            $data .= "," . $key;
        }
        $data .= ",Total";
        $data .= "\n";





        foreach ($programList as $key => $valArr)
        {
            foreach ($valArr as $key => $councelor)
            {
                $data .= "\"" . $councelor['batch_name'];
                $data .= "\",\"" . $councelor['batch_code'];
                $data .= "\",\"" . $councelor['vendor'];
                $toal = 0;
                foreach ($StatusList as $key1 => $value)
                {
                    $countedLead = isset($councelor[$key1]) ? $councelor[$key1] : 0;
                    $data        .= "\",\"" . $countedLead;
                    $toal        += $countedLead;
                }
                $data .= "\",\"" . $toal;
                $data .= "\"\n";
            }
        }
        //echo $data; die;

        $fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/reports/" . $filename . ".csv", "wb");
        fwrite($fp, $data);
        fclose($fp);
        chmod($_SERVER['DOCUMENT_ROOT'] . "/reports/" . $filename . ".csv", 0777);

        ///var/www/htmlVendorWiseReport_report_2018-01-22.csv
        $emailData = $mail->TestemailData('Vendor Wise Status Report', $filename, $this->toDate);
        $mail->sendCertificateEmail($emailData);
    }

}

$mainObj           = new sendVisitReport();
//$mainObj->toDate   = '2017-11-04';
//$mainObj->fromDate = '2017-11-04';
if (strtotime($mainObj->fromDate) == strtotime($mainObj->toDate))
{
    $fromDate = date('Y-m-d', (strtotime('-1 day', strtotime($mainObj->fromDate))));
}

$mainObj->toDate   = $fromDate;
$mainObj->fromDate = $fromDate;

$mainObj->main();


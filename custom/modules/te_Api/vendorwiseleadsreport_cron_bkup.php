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

        $file     = "VendorWiseAllocation_report";
        $where    = '';
        $filename = $file . "_" . $this->toDate;

        $leadSql = "SELECT COUNT(leads.id) AS lead_count,
                    leads.date_entered,
                    te_ba_batch.id AS batch_id,
                    te_ba_batch.name AS batch_name,
                    te_ba_batch.batch_code,
                    leads.vendor,
                    te_vendor.id vendor_id
             FROM leads
          
             LEFT JOIN leads_cstm ON leads.id = leads_cstm.id_c
             LEFT JOIN te_ba_batch ON leads_cstm.te_ba_batch_id_c = te_ba_batch.id
             LEFT JOIN te_vendor on lower(leads.vendor)=lower(te_vendor.name)
             WHERE leads.date_entered >= '$this->toDate 00:00:00' AND leads.date_entered <= '$this->toDate 23:59:59'
  
             GROUP BY leads.vendor,batch_code";
        //echo $leadSql;exit();


        $leadObj = $db->query($leadSql);


        while ($row = $db->fetchByAssoc($leadObj))
        {


            $programList[$row['batch_id']]['id']         = $row['batch_id'];
            $programList[$row['batch_id']]['name']       = $row['batch_name'];
            $programList[$row['batch_id']]['batch_code'] = $row['batch_code'];


            $VendorList[$row['vendor_id']]['name']                          = $row['vendor'];
            $programList[$row['batch_id']][$row['vendor_id']]['lead_count'] = $row['lead_count'];
        }



        # Create heading
        $data = "Programme Name";
        $data .= ",Batch Code";
        foreach ($VendorList as $key => $vendorVal)
        {
            $data .= "," . $vendorVal['name'];
        }
        $data .= ",Total";
        $data .= "\n";




        foreach ($programList as $key => $councelor)
        {
            $toal = 0;
            $data .= "\"" . $councelor['name'];
            $data .= "\",\"" . $councelor['batch_code'];
            foreach ($VendorList as $key1 => $value)
            {
                $converted = isset($programList[$key][$key1]) ? $programList[$key][$key1]['lead_count'] : 0;
                $data      .= "\",\"" . $converted;
                $toal      += $converted;
            }
            $data .= "\",\"" . $toal;
            $data .= "\"\n";
        }
        //echo $data; die;

        $fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/reports/" . $filename . ".csv", "wb");
        fwrite($fp, $data);
        fclose($fp);
        chmod($_SERVER['DOCUMENT_ROOT'] . "/reports/" . $filename . ".csv", 0777);

        ///var/www/htmlVendorWiseReport_report_2018-01-22.csv
        $emailData = $mail->emailData('Vendor Wise Lead Allocation Report', $filename, $this->toDate);
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


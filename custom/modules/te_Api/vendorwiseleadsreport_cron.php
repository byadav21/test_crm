<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
ini_set('memory_limit', '1024M');
require_once('include/entryPoint.php');
require_once('custom/include/Email/sendmail.php');
global $db;
//error_reporting(-1);
//ini_set('display_errors', 'On');

class sendVisitReport
{

    public $fromDate;
    public $toDate;

    public function __construct()
    {
        $this->fromDate = date('Y-m-d');
        $this->toDate   = date('Y-m-d');
    }

    public function sendEmail($sentTo, $emailSubject, $emailMessage, $emailFromName = NULL, $emailFrom = NULL, $attachData = array())
    {
        $sentTo                = (!is_array($sentTo)) ? array($sentTo) : $sentTo;
        // $sentTo = "virendra.bhardwaj@talentedge.in;
        $data                  = array();
        $data['api_key']       = 'fbb5606b326850fce2fa335cdce8dc16';
        $data['email_details'] = array(
            'fromname' => rawurlencode("Talentedge"),
            'subject'  => rawurlencode($emailSubject),
            'from'     => "notifications@talentedge.in",
            'content'  => rawurlencode($emailMessage),
        );
        $data['recipients']    = $sentTo;
        if (!empty($attachData))
        {
            $data['files'] = $attachData;
        }

        $data = array('data' => json_encode($data));

        $url = "http://api.falconide.com/falconapi/web.send.json";
        $ch  = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RANGE, "1-2000000");

        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_REFERER, 'http://www.talentedge.in');
        $result = curl_exec($ch);
        $result = curl_error($ch) ? curl_error($ch) : $result;
        curl_close($ch);
        return $result;
    }

    public function sendCertificateEmail($emailData)
    {

        if (!empty($emailData))
        {
            $userId       = $emailData['userId'];
            $sentTo       = $emailData['email'];
            
            //print_r($sentTo); die;
            $emailSubject = $emailData['subject'];
            $emailMessage = $emailData['email_message'];
            $certFilePath = $emailData['certFilePath'];
            $attachData   = array();

            if (file_exists($certFilePath))
            {    
                $attachFile    = file_get_contents($certFilePath);
                $attachName    = $emailData['pdfFileName'] . ".csv";
                $attachContent = rawurlencode($attachFile);
                $attachData    = array($attachName => $attachContent);

                //$Notification = ClassRegistry::init('Notification');
                echo $this->sendEmail($sentTo, $emailSubject, $emailMessage, NULL, NULL, $attachData);
            }
        }
    }

    public function main()
    {
        global $sugar_config, $app_list_strings, $current_user, $db;

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
            $data .= "\"" . $councelor['name'];
            $data .= "\",\"" . $councelor['batch_code'];
            foreach ($VendorList as $key1 => $value)
            {
                $converted = $programList[$key][$key1]['lead_count'];
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
        chmod($filename. ".csv", 0777); 

        ///var/www/htmlVendorWiseReport_report_2018-01-22.csv

        $emailData = array('email'         => array('pawan.kumar@talentedge.in','ashwani.sharma@talentedge.in','ajay.kumar@talentedge.in','pritam.dutta@talentedge.in'),
            'subject'       => 'Vendor Wise Allocation Report - ' . date("F d, Y", strtotime($this->toDate)),
            'email_message' => '<p>Hi,</p> '
            . '<p>Please find in here attached, vendor wise lead allocation report for "' . date("F d, Y", strtotime($this->toDate)) . '"</p>',
            'pdfFileName'   => $filename,
            'certFilePath'  => $_SERVER['DOCUMENT_ROOT'] . "/reports/" . $filename . ".csv");

        $this->sendCertificateEmail($emailData);
    }

}

$mainObj = new sendVisitReport();

if (strtotime($mainObj->fromDate) == strtotime($mainObj->toDate))
{
    $fromDate = date('Y-m-d', (strtotime('-1 day', strtotime($mainObj->fromDate))));
}
$mainObj->toDate   = $fromDate;
$mainObj->fromDate = $fromDate;

$mainObj->main();


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

        $file     = "VendorWiseSubStatusDetail_report";
        $filename = $file . "_" . $this->toDate;
        $StatusList=array();
     

          $leadSql = "SELECT COUNT(l.id) AS lead_count,
                    l.date_entered,
                    te_ba_batch.id AS batch_id,
                    #p.name program_name,
                    te_ba_batch.name AS batch_name,
                    te_ba_batch.batch_code,
                    l.status,
                    l.vendor,
                    te_vendor.id vendor_id,
                    l.status_description
                FROM leads l
                INNER JOIN leads_cstm AS lc ON l.id=lc.id_c
                LEFT JOIN te_ba_batch ON lc.te_ba_batch_id_c = te_ba_batch.id
                LEFT JOIN te_vendor on lower(l.vendor)=lower(te_vendor.name)
                #LEFT JOIN te_pr_programs_te_ba_batch_1_c AS bpr ON bpr.te_pr_programs_te_ba_batch_1te_ba_batch_idb=te_ba_batch.id
                #LEFT JOIN te_pr_programs as p ON p.id=bpr.te_pr_programs_te_ba_batch_1te_pr_programs_ida
                WHERE l.date_entered >= '$this->toDate 00:00:00' AND l.date_entered <= '$this->toDate 23:59:59'
              GROUP BY l.status,te_vendor.id,te_ba_batch.batch_code order by  te_ba_batch.batch_code ";

        //echo $leadSql;exit();


        $leadObj = $db->query($leadSql);

        $vendor = 'NULL';

        while ($row = $db->fetchByAssoc($leadObj))
        {
            if ($row['vendor'] == '')
            {
                $row['vendor'] = $vendor;
            }
            
            $programList[strtolower($row['vendor']) .'_BATCH_'.$row['batch_id']]['batch_id']   = $row['batch_id'];
            //$programList[strtolower($row['vendor']) .'_BATCH_'.$row['batch_id']]['program_name'] = $row['program_name'];
            $programList[strtolower($row['vendor']) .'_BATCH_'.$row['batch_id']]['batch_name'] = isset($row['batch_name']) ? $row['batch_name'] : 'NULL';
            $programList[strtolower($row['vendor']) .'_BATCH_'.$row['batch_id']]['batch_code'] = isset($row['batch_code']) ? $row['batch_code'] : 'NULL';
            $programList[strtolower($row['vendor']) .'_BATCH_'.$row['batch_id']]['vendor']     = isset($row['vendor']) ? $row['vendor'] : 'NULL';
            $programList[strtolower($row['vendor']) .'_BATCH_'.$row['batch_id']]['lead_count'] = $row['lead_count'];
            $programList[strtolower($row['vendor']) .'_BATCH_'.$row['batch_id']]['status_description']     = $row['status_description'];

            $programList[strtolower($row['vendor']) .'_BATCH_'.$row['batch_id']][strtolower(str_replace(array(' ','-'),'_',$row['status_description']))] = $row['lead_count'];
            
            $StatusList[strtolower(str_replace(array(' ','-'),'_',$row['status_description']))]    = $row['status_description'];
        }



       
        # Create heading
            //$data = "Programme Name";
            $data='';
	    $data .= "Batch Name";
            $data .= ",Batch Code";
            $data .= ",Vendor";
            foreach ($StatusList as $key => $statusVal)
            {
                $data .= "," . $key;
            }
            $data .= ",Total";
            $data .= "\n";



            //echo "<pre>";print_r($programList);exit();
            foreach ($programList as $key => $councelor)
            {
                //$data .= "\"" . $councelor['program_name'];
                $data .= "\"" . $councelor['batch_name'];
                $data .= "\",\"" . $councelor['batch_code'];
		$data .= "\",\"" . $councelor['vendor'];
                $toal=0;
                foreach ($StatusList as $key1 => $value)
                {
                    $countedLead = (!empty($programList[$key][$key1])? $programList[$key][$key1] : 0);
                    $data      .= "\",\"" . $countedLead;
                    $toal      += $countedLead;
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
        $to = array(
                'pawan.kumar@talentedge.in'
                ,'pritam.dutta@talentedge.in',
                'ajay.kumar@talentedge.in', 'ashwani.sharma@talentedge.in',
                //B Head
                //'sreedevi.sreekumar@talentedge.in',
                //CC Team:
                //'ritika.nayak@talentedge.in','eleazer.rohit@talentedge.in', 'deepak.yadav@talentedge.in',
                //'amit.arora@talentedge.in', 'pramod.singh@talentedge.in','abha.saxena@talentedge.in',
                
                //Marketing Team :
                'karan.bhatia@talentedge.in', 'amit.sati@talentedge.in', 'sachin.jain@talentedge.in',
                'vivek.bathla@talentedge.in', 'rajendra.digari@talentedge.in','vaibhav.gupta@talentedge.in',
                //BA Team :
                'duke.banerjee@talentedge.in');
        $emailData = $mail->cron_email_Data('Vendor Wise Sub Status Detail Report', $filename, $this->toDate,$to,$email_summary);
        //$emailData = $mail->emailData('Vendor Wise Sub Status Detail Report', $filename, $this->toDate);
        $mail->sendCertificateEmail($emailData);
    }

}

$mainObj = new sendVisitReport();
//$mainObj->toDate   = '2017-11-04';
//$mainObj->fromDate = '2017-11-04';
if (strtotime($mainObj->fromDate) == strtotime($mainObj->toDate))
{
    $fromDate = date('Y-m-d', (strtotime('-1 day', strtotime($mainObj->fromDate))));
}

$mainObj->toDate   = $fromDate;
$mainObj->fromDate = $fromDate;

$mainObj->main();


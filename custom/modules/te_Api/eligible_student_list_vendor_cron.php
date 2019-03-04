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
        $email_summary='';

        $file        = "Eligible_Student_List_Report_Batch_Wise_report";
        $where       = '';
        $filename    = $file . "_" . $this->toDate;
        $AllLeadData = $this->getAll();
        
        if(empty($AllLeadData)){
            echo json_encode(array('status'=>'error','msg'=>'No Data found for Eligible Student!')); 
            return;
        }
        
        


        $fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/reports/" . $filename . ".csv", "wb");
        fwrite($fp, $AllLeadData);
        fclose($fp);
        chmod($_SERVER['DOCUMENT_ROOT'] . "/reports/" . $filename . ".csv", 0777);
        
        $emailData = $mail->toVendorData('Eligible Student List Report Batch Wise', $filename, $this->toDate, $email_summary);
        $mail->sendCertificateEmail($emailData);
    }

    public function getAll()
    {
        global $sugar_config, $app_list_strings, $current_user, $db;
        $leadSql = "SELECT 
                         l.first_name,
                         l.last_name,
                         #leads_cstm.email_add_c,
                         l.phone_mobile, 
                         bb.`id` batch_id,
                         bb.`name` as batch_name,
                         bb.`batch_code`,
                         #DATEDIFF(NOW(), bb.batch_completion_date_2) AS diff_of_days,
                         sb.srm_is_eligible
                        
                     FROM `te_ba_batch` bb
                     INNER JOIN te_student_batch sb ON bb.id=sb.te_ba_batch_id_c
                     INNER JOIN leads l on sb.leads_id=l.id
                     #LEFT JOIN leads_cstm ON l.id= leads_cstm.id_c
                     WHERE 
                     bb.deleted=0 
                     AND sb.deleted=0 
                     AND l.deleted=0 
                     AND sb.srm_is_eligible=1
                     AND DATEDIFF(NOW(), bb.batch_completion_date_2) =90 
                     #AND DATEDIFF(NOW(), bb.batch_completion_date_2) <=150
                     AND bb.batch_status IN ('closed','completed','enrollment_closed','planned')
                     order by bb.`batch_code`
                     ";

        $leadObj = $db->query($leadSql);

        $programList = array();
        while ($row         = $db->fetchByAssoc($leadObj))
        {
            $programList[] = $row;
        }



        $data = "Name";
        $data .= ",Batch Name";
        $data .= ",Batch Code";
        $data .= ",Phone number";
        $data .= "\n";




        foreach ($programList as $key => $councelor)
        {

            $data .= "\""    . $councelor['first_name'] . ' ' . $councelor['last_name'];
            $data .= "\",\"" . $councelor['batch_name'];
            $data .= "\",\"" . $councelor['batch_code'];
            $data .= "\",\"" . $councelor['phone_mobile'];
            $data .= "\"\n";
        }
        return $data;
    }

}

$mainObj = new sendVisitReport();
if (strtotime($mainObj->fromDate) == strtotime($mainObj->toDate))
{
    $fromDate = date('Y-m-d', (strtotime('-1 day', strtotime($mainObj->fromDate))));
    //$fromDate = '2018-09-28';
}

$mainObj->toDate   = $fromDate;
$mainObj->fromDate = $fromDate;

$mainObj->main();


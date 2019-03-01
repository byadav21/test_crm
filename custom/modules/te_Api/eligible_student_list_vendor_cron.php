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

        $file        = "TE_Focus_Leads_report";
        $where       = '';
        $filename    = $file . "_" . $this->toDate;
        //$AllLeadData = $this->getAll();
        $getBatches  = $this->getBatches();
        echo '<pre>'; print_r($getBatches); die;
        echo $data; die;

        $fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/reports/" . $filename . ".csv", "wb");
        fwrite($fp, $AllLeadData);
        fclose($fp);
        chmod($_SERVER['DOCUMENT_ROOT'] . "/reports/" . $filename . ".csv", 0777);

        $email_summary = '<table border="0" cellpadding="0" cellspacing="0" border="1" height="100%" width="100%" id="bodyTable">
            <tr>
                <td align="center" valign="top">
                    <table border="0" cellpadding="20" cellspacing="0" border="1" width="600" id="emailContainer">
                        <tr>
                            <td valign="top">
                                All Eligible Student List.
                            </td>
			    <td valign="top">
                                ' . $getSummary['total'] . '
                            </td>
                        </tr>
						
                    </table>
                </td>
            </tr>
        </table>';

        $emailData = $mail->emailData('Eligible Student List Report Batch Wise', $filename, $this->toDate, $email_summary);
        $mail->sendCertificateEmail($emailData);
    }

    public function getAll()
    {
        global $sugar_config, $app_list_strings, $current_user, $db;
        $leadSql = "SELECT 
                         l.first_name,
                         l.last_name,
                         leads_cstm.email_add_c,
                         l.phone_mobile, 
                         bb.`id` batch_id,
                         bb.`name` as batch_name,
                         bb.`batch_code`,
                         #DATEDIFF(NOW(), bb.batch_completion_date_2) AS diff_of_days,
                         sb.srm_is_eligible
                        
                     FROM `te_ba_batch` bb
                     INNER JOIN te_student_batch sb ON bb.id=sb.te_ba_batch_id_c
                     INNER JOIN leads l on sb.leads_id=l.id
                     LEFT JOIN leads_cstm ON l.id= leads_cstm.id_c
                     WHERE 
                     bb.deleted=0 
                     AND sb.deleted=0 
                     AND l.deleted=0 
                     AND sb.srm_is_eligible=1
                     AND DATEDIFF(NOW(), bb.batch_completion_date_2) =90 
                     #AND DATEDIFF(NOW(), bb.batch_completion_date_2) <=150
                     AND bb.batch_status IN ('closed','completed','enrollment_closed','planned')
                     ";
        //echo $leadSql;exit();


        $leadObj = $db->query($leadSql);

        $programList = array();
        while ($row         = $db->fetchByAssoc($leadObj))
        {


            $programList[$row['batch_id']][]                            = $row;
            
        }
        
        echo '<pre>'; print_r($programList); die;

        #Create Section
        $dataAllSecHed = "All Leads Data\n";
        $data          = $dataAllSecHed . "Programme Name";
        $data          .= ",Batch Code";
        $data          .= ",Total";
        $data          .= "\n";




        foreach ($programList as $key => $councelor)
        {
            $toal = 0;
            $data .= "\"" . $councelor['name'];
            $data .= "\",\"" . $councelor['batch_code'];
            foreach ($VendorList as $key1 => $value)
            {
                $converted = isset($programList[$key][$key1]) ? $programList[$key][$key1]['lead_count'] : 0;
                $toal      += $converted;
            }
            $data .= "\",\"" . $toal;
            $data .= "\"\n";
        }
        return $data;
    }

    public function getBatches()
    {
        global $sugar_config, $app_list_strings, $current_user, $db;
        $leadSql = "SELECT 
                    `id`,
                    `date_entered`,
                    `batch_status`, 
                    `batch_code`,
                    `batch_start_date`,
                    `duration`,
                    `batch_completion_date`,
                    `batch_completion_date_2`,
                    DATEDIFF(NOW(),batch_completion_date_2) as diff_of_days
                    FROM `te_ba_batch`
                    WHERE deleted=0
                    AND DATEDIFF(NOW(),batch_completion_date_2) =90
                    #AND DATEDIFF(NOW(),batch_completion_date_2) <=150
                    AND batch_status IN ('closed','completed','enrollment_closed','planned')";
        $leadObj = $db->query($leadSql);
        $vendorOptions = array();
        while ($row          = $db->fetchByAssoc($leadObj))
        {   
            $vendorOptions[$row['batch_code']] = $row['diff_of_days'];
        }
        return $vendorOptions;
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


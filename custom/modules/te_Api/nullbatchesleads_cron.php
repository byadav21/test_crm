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

        $file          = "leads_with_null_batch_report";
        $filename      = $file . "_" . $this->toDate;
        $StatusList    = array();
        $email_summary = '';
        $lastSevenDays = date('Y-m-d', strtotime('-7 days', strtotime(date('Y-m-d'))));
        
        $headers       = array('leads.id'                       => 'LeadID',
            'leads.date_entered'             => 'Date Entered',
            'leads.date_modified'            => 'Date Modified',
            'leads.first_name'               => 'First Name',
            'leads.last_name'                => 'Last Name',
            'leads_cstm.email_add_c'         => 'Email',
            'leads.phone_mobile'             => 'Mobile',
            'leads.status'                   => 'Status',
            'leads.status_description'       => 'Status Description',
            'leads.disposition_reason'       => 'Disposition Reason',
            'leads.lead_source'              => 'Lead Source',
            'leads.vendor'                   => 'Vendor',
            //'te_ba_batch.name AS batch_name' => 'Batch Name',
            'te_ba_batch.batch_code'         => 'Batch Code',
            'leads.lead_source_types'        => 'Lead Source Types',
            'leads.utm_term_c'               => 'UTM Term',
            'leads.utm_source_c'             => 'UTM Source',
            'leads.utm_contract_c'           => 'UTM Contract',
            'leads.utm_campaign'             => 'UTM Campaign');
        
        $stringHeaders = implode(",", array_keys($headers));

        $leadSql = "SELECT 
                           $stringHeaders
                        FROM leads 
                        LEFT JOIN users ON leads.assigned_user_id =users.id
                        LEFT JOIN leads_cstm ON leads.id= leads_cstm.id_c
                        LEFT JOIN te_ba_batch ON leads_cstm.te_ba_batch_id_c= te_ba_batch.id
                        where leads.deleted=0 
                        and (te_ba_batch.batch_code IS NULL || te_ba_batch.batch_code='')
                        and DATE(leads.date_entered) >=  '$this->fromDate'
                        order by leads.date_entered";

                        //echo $leadSql;exit();


                        $leadObj = $db->query($leadSql);

                        $vendor = 'NULL';

                        $data = "";
                        foreach ($headers as $key => $column)
                        {
                            $data .= $column . ",";
                        }
                        $data .= "\n";



                        while ($row = $db->fetchByAssoc($leadObj))
                        {

                            $data .= implode(',', $row);
                            $data .= "\n";
                        }




        $fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/reports/" . $filename . ".csv", "wb");
        fwrite($fp, $data);
        fclose($fp);
        chmod($_SERVER['DOCUMENT_ROOT'] . "/reports/" . $filename . ".csv", 0777);


        $to        = array('pawan.kumar@talentedge.in','sandeep.sharma@talentedge.in');
        $emailData = $mail->cron_email_Data('Leads With NULL Batch Report', $filename, $this->toDate, $to, $email_summary);
        $mail->sendCertificateEmail($emailData);
    }

}

$mainObj = new sendVisitReport();
//$mainObj->toDate   = '2017-11-04';
//$mainObj->fromDate = '2017-11-04';
if (strtotime($mainObj->fromDate) == strtotime($mainObj->toDate))
{   
    $toDate   = date('Y-m-d');
    $fromDate = date('Y-m-d', (strtotime('-7 day', strtotime($mainObj->fromDate))));
}

$mainObj->toDate   = $toDate;
$mainObj->fromDate = $fromDate;

$mainObj->main();


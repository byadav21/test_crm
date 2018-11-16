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
        $AllLeadData = $this->getAll();
        $getSummary  = $this->getSummary();
        //print_r($AllLeadData); die;
        //echo $data; die;

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
                                All TE_FOCUS Leads.
                            </td>
			    <td valign="top">
                                ' . $getSummary['total'] . '
                            </td>
                        </tr>
						
                    </table>
                </td>
            </tr>
        </table>';

        $emailData = $mail->TestemailData('TE_FOCUS Leads Report', $filename, $this->toDate, $email_summary);
        $mail->sendCertificateEmail($emailData);
    }

    public function getAll()
    {
        global $sugar_config, $app_list_strings, $current_user, $db;
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
             WHERE leads.date_entered >= '$this->fromDate 00:00:00' AND leads.date_entered <= '$this->toDate 23:59:59' 
             AND leads.vendor LIKE  '%te_focus%'
             GROUP BY leads.vendor,batch_code";
        //echo $leadSql;exit();


        $leadObj = $db->query($leadSql);

        $programList = array();
        while ($row         = $db->fetchByAssoc($leadObj))
        {


            $programList[$row['batch_id']]['id']         = $row['batch_id'];
            $programList[$row['batch_id']]['name']       = $row['batch_name'];
            $programList[$row['batch_id']]['batch_code'] = $row['batch_code'];


            $VendorList[$row['vendor_id']]['name']                          = $row['vendor'];
            $programList[$row['batch_id']][$row['vendor_id']]['lead_count'] = $row['lead_count'];
        }

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

    public function getSummary()
    {
        global $sugar_config, $app_list_strings, $current_user, $db;
        $leadSql = "SELECT COUNT(leads.id) AS lead_count
                         FROM leads
                         LEFT JOIN leads_cstm ON leads.id = leads_cstm.id_c
                         LEFT JOIN te_ba_batch ON leads_cstm.te_ba_batch_id_c = te_ba_batch.id
                         LEFT JOIN te_vendor on lower(leads.vendor)=lower(te_vendor.name)
                         WHERE leads.date_entered >= '$this->fromDate 00:00:00' AND leads.date_entered <= '$this->toDate 23:59:59' 
                         AND leads.vendor LIKE  '%te_focus%'";
        $leadObj = $db->query($leadSql);
        $row     = $db->fetchByAssoc($leadObj);
        return array('total' => $row['lead_count']);
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


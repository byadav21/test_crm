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
		$AllLeadData = $this->getAll();
		$FreshLeadData = $this->getFresh();
		$ReEnquiredLeadData = $this->getReEnquired();
		$DuplicateLeadData = $this->getDuplicate();
		$getSummary = $this->getSummary();
		
		$data = $AllLeadData;
		$data .= $FreshLeadData;
		$data .= $ReEnquiredLeadData;
		$data .= $DuplicateLeadData;
        //echo $data; die;
		
        $fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/reports/" . $filename . ".csv", "wb");
        fwrite($fp, $data);
        fclose($fp);
        chmod($_SERVER['DOCUMENT_ROOT'] . "/reports/" . $filename . ".csv", 0777);
		$email_summary = '<table border="0" cellpadding="0" cellspacing="0" border="1" height="100%" width="100%" id="bodyTable">
            <tr>
                <td align="center" valign="top">
                    <table border="0" cellpadding="20" cellspacing="0" border="1" width="600" id="emailContainer">
                        <tr>
                            <td valign="top">
                                All Leads.
                            </td>
							<td valign="top">
                                '.$getSummary['total'].'
                            </td>
                        </tr>
						<tr>
                            <td valign="top">
                                Fresh Leads.
                            </td>
							<td valign="top">
                                '.$getSummary['fresh'].'
                            </td>
                        </tr>
						<tr>
                            <td valign="top">
                                Duplicate Leads.
                            </td>
							<td valign="top">
                                '.$getSummary['duplicate'].'
                            </td>
                        </tr>
						<tr>
                            <td valign="top">
                                Re-Enquired Leads.
                            </td>
							<td valign="top">
                                '.$getSummary['re_enquired'].'
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>';

        $emailData = $mail->emailData('Vendor Wise Lead Allocation Report', $filename, $this->toDate,$email_summary);
        $mail->sendCertificateEmail($emailData);
    }
	public function getReEnquired(){
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
             WHERE leads.status_description IN ('Re-Enquired') AND leads.date_entered >= '$this->fromDate 00:00:00' AND leads.date_entered <= '$this->toDate 23:59:59'
  
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

		#Create Section
		$dataAllSecHed = "Re-Enquired Leads Data\n";
        # Create heading
        $data = $dataAllSecHed."Programme Name";
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
		return $data;
	}
	public function getDuplicate(){
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
             WHERE leads.status_description IN ('Duplicate') AND leads.date_entered >= '$this->fromDate 00:00:00' AND leads.date_entered <= '$this->toDate 23:59:59'
  
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

		#Create Section
		$dataAllSecHed = "Duplicate Leads Data\n";
        # Create heading
        $data = $dataAllSecHed."Programme Name";
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
		return $data;
	}
	public function getFresh(){
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
             WHERE leads.status_description IN ('Call Back','Converted','Follow Up','Miscellaneous','New Lead','Payment enquiry','Program enquiry','Prospect','Recycle','Dead Number','Fallout','Not Eligible','Not Enquired','Ringing Multiple Times','Wrong Number') AND leads.date_entered >= '$this->fromDate 00:00:00' AND leads.date_entered <= '$this->toDate 23:59:59'
  
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

		#Create Section
		$dataAllSecHed = "Fresh Leads Data\n";
        # Create heading
        $data = $dataAllSecHed."Programme Name";
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
		return $data;
	}
	public function getAll(){
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
             WHERE leads.date_entered >= '$this->fromDate 00:00:00' AND leads.date_entered <= '$this->toDate 23:59:59' AND leads.status_description IN ('Call Back','Converted','Follow Up','Miscellaneous','New Lead','Payment enquiry','Program enquiry','Prospect','Recycle','Dead Number','Fallout','Not Eligible','Not Enquired','Ringing Multiple Times','Wrong Number','Duplicate','Re-Enquired')
  
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

		#Create Section
		$dataAllSecHed = "All Leads Data\n";
        # Create heading
        $data = $dataAllSecHed."Programme Name";
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
		return $data;
	}
	public function getSummary(){
		global $sugar_config, $app_list_strings, $current_user, $db;
		$leadSql = "SELECT COUNT(leads.id) AS lead_count,
                    leads.status_description
             FROM leads
             WHERE leads.date_entered >= '$this->fromDate 00:00:00' AND leads.date_entered <= '$this->toDate 23:59:59' AND leads.status_description IN('Call Back','Converted','Follow Up','Miscellaneous','New Lead','Payment enquiry','Program enquiry','Prospect','Recycle','Dead Number','Fallout','Not Eligible','Not Enquired','Ringing Multiple Times','Wrong Number','Duplicate','Re-Enquired')
  
             GROUP BY leads.status_description";
        


        $leadObj = $db->query($leadSql);

		$programList['Call Back']=0;$programList['Converted']=0;$programList['Follow Up']=0;$programList['Miscellaneous']=0;
		$programList['New Lead']=0;$programList['Payment enquiry']=0;$programList['Program enquiry']=0;$programList['Prospect']=0;
		$programList['Recycle']=0;$programList['Dead Number']=0;$programList['Fallout']=0;$programList['Not Eligible']=0;
		$programList['Not Enquired']=0;$programList['Ringing Multiple Times']=0;$programList['Wrong Number']=0;$programList['Duplicate']=0;
		$programList['Re-Enquired']=0;
        while ($row = $db->fetchByAssoc($leadObj))
        {
            $programList[$row['status_description']]         = $row['lead_count'];
        }
		$re_enquired = $programList['Re-Enquired'];
		$duplicate = $programList['Duplicate'];
		unset($programList['Duplicate']);
		unset($programList['Re-Enquired']);
		
		$fresh = array_sum($programList);
		$total = $fresh+$duplicate+$re_enquired;
		return array('total'=>$total,'fresh'=>$fresh,'re_enquired'=>$re_enquired,'duplicate'=>$duplicate);
		
	}
}

$mainObj           = new sendVisitReport();
//$mainObj->toDate   = '2017-09-30';
//$mainObj->fromDate = '2017-09-01';
if (strtotime($mainObj->fromDate) == strtotime($mainObj->toDate))
{
    $fromDate = date('Y-m-d', (strtotime('-1 day', strtotime($mainObj->fromDate))));
}

$mainObj->toDate   = $fromDate;
$mainObj->fromDate = $fromDate;

$mainObj->main();


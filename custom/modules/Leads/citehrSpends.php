<?php

ini_set('max_execution_time', 3600);
set_time_limit(3600);
//echo "hello";exit(); 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class citehrSpends
{

    public $fromDate;

    public function __construct()
    {
        $this->fromDate = date('Y-m-d');
        $this->toDate   = date('Y-m-d');
    }
    
    public function getTotalC()
    {
        global $db;
        //$ignore_vendors = "'citehr','facebook','google','te_focus','taboola'";
        $sql       = "SELECT count(id)total
                 FROM `leads`
                 WHERE date(date_entered)='" . $this->fromDate . "'
                   AND vendor LIKE '%citehr%' ";
        $result    = $db->query($sql);
        return $db->fetchByAssoc($result);
    }


    public function get_data()
    {
        global $db;
        //$ignore_vendors = "'citehr','facebook','google','te_focus','taboola'";
        $sql       = "SELECT count(leads.id)total,
                        sum(CASE
                                WHEN leads.status ='Converted' THEN 1
                                ELSE 0
                            END) AS converted,
                        leads.utm_term_c,
                        leads_cstm.te_ba_batch_id_c
                 FROM `leads`
                 INNER JOIN leads_cstm ON leads.id= leads_cstm.id_c
                 WHERE date(date_entered)='" . $this->fromDate . "'
                   AND vendor LIKE '%citehr%' 
                   group by utm_term_c ";
        $result    = $db->query($sql);
        $resultArr = [];
        if ($db->getRowCount($result) > 0)
        {
            while ($row = $db->fetchByAssoc($result))
            {
                $resultArr[] = $row;
            }
        }
        return $resultArr;
    }

}

$mainObj           = new citehrSpends();
$mainObj->fromDate = (isset($_GET['today']) && !empty($_GET['today'])) ? $_GET['today'] : date('Y-m-d', (strtotime('-1 day', strtotime(date('Y-m-d')))));
//$mainObj->fromDate = '2018-11-05';

$citeData           = $mainObj->get_data();

//print_r($citeData); die;
$insertable_arr     = '';
$insertable_sub_arr = '';

$citeHRAmt = 200000;
$vendorID  = '14a4e733-b709-8c60-7731-590d5cb3b1f7';
echo '$maxDays=' . $maxDays   = date('t');
echo '$todayAmt=' . $todayAmt  = ($citeHRAmt / $maxDays);


$totalData                = $mainObj->getTotalC();

if ($citeData)
{
    foreach ($citeData as $key => $val)
    {
	$perLeadPrice   = $todayAmt / $totalData['total'];
        $cpl_sum        = ($perLeadPrice * $val['total']);
        
        $cpa            = ($cpl_sum > 0 && $val['converted']) ? $perLeadPrice / $val['converted'] : 0;
        $cpl            = ($cpl_sum > 0 && $val['total']) ? $perLeadPrice * $val['total'] : 0;
        

        $id               = create_guid();
        $totalLeads       = $val['total'];
        $totalConversion  = $val['converted'];
        $ActualLead       = $val['total'];
        $ActualConversion = $val['converted'];

        $insertable_arr[]     = " ('" . $id . "','citehr','" . $mainObj->fromDate . "',$ActualLead,'" . $totalLeads . "','" . $ActualConversion . "','" . $totalConversion . "','" . $cpl_sum . "','" . $cpl . "','" . $cpa . "','".$val['te_ba_batch_id_c']."','" . $vendorID . "','" . date('Y-m-d H:i:s') . "','" . date('Y-m-d H:i:s') . "') ";
        $insertable_sub_arr[] = " ('" . create_guid() . "','','" . $id . "','" . date('Y-m-d H:i:s') . "') ";
    }
}//exit();







global $db;
if ($insertable_arr)
{
    $insert_str = "INSERT INTO `te_actual_campaign`(`id`, `name`, `plan_date`,`leads`,`total_leads`,`actual_conversion`,`total_conversion`, `total_cost`, `cpl`, `cpa`, `te_ba_batch_id_c`, `vendor_id`,`date_entered`,`date_modified`) VALUES ";
    $insert_str .= implode(',', $insertable_arr);
    $db->query($insert_str);
    //echo $insert_str.'<br>';
}
if ($insertable_sub_arr)
{
    $insertable_sub_str = "INSERT INTO `te_utm_te_actual_campaign_1_c`(`id`, `te_utm_te_actual_campaign_1te_utm_ida`, `te_utm_te_actual_campaign_1te_actual_campaign_idb`,`date_modified`) VALUES ";
    $insertable_sub_str .= implode(',', $insertable_sub_arr);
    $db->query($insertable_sub_str);
    //echo $insertable_sub_str;exit();
}
echo "<pre>";
print_r($insertable_arr);
print_r($insertable_sub_arr);
//print_r($result);
//print_r($utm);
exit();



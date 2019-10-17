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

    public function get_data()
    {
        global $db;
        //$ignore_vendors = "'citehr','facebook','google','te_focus','taboola'";
        $sql       = "SELECT count(id)total,
                        sum(CASE
                                WHEN status ='Converted' THEN 1
                                ELSE 0
                            END) AS converted,
                        utm
                 FROM `leads`
                 WHERE date(date_entered)='" . $this->fromDate . "'
                   AND vendor LIKE '%citehr%' ";
        $result    = $db->query($sql);
        return $db->fetchByAssoc($result);
    }

}

    $mainObj           = new citehrSpends();
    $mainObj->fromDate = (isset($_GET['today']) && !empty($_GET['today'])) ? $_GET['today'] : date('Y-m-d', (strtotime('-1 day', strtotime(date('Y-m-d')))));
    //$mainObj->fromDate = '2019-09-27';
    
    $citeData                = $mainObj->get_utm();
    $insertable_arr     = '';
    $insertable_sub_arr = '';

    $citeHRAmt = 200000;
    echo '$maxDays=' . $maxDays   = date('t');
    echo '$todayAmt=' . $todayAmt  = ($citeHRAmt / $maxDays);

    $cpl_sum = $todayAmt;
    $cpa     = ($cpl_sum > 0 && $citeData['converted']) ? $cpl_sum / $citeData['converted'] : 0;
    $cpl     = ($cpl_sum > 0 && $citeData['total']) ? $cpl_sum / $citeData['total'] : 0;

    $id               = create_guid();
    $totalLeads       = $citeData['total'];
    $totalConversion  = $citeData['converted'];
    $ActualLead       = $citeData['total'];
    $ActualConversion = $citeData['converted'];

    $insertable_arr[]     = " ('" . $id . "','" . $key . "','" . $mainObj->fromDate . "',$ActualLead,'" . $totalLeads . "','" . $ActualConversion . "','" . $totalConversion . "','" . $cpl_sum . "','" . $cpl . "','" . $cpa . "','','" . $utm[$key]['vendor_id'] . "','" . date('Y-m-d H:i:s') . "','" . date('Y-m-d H:i:s') . "') ";
    $insertable_sub_arr[] = " ('" . create_guid() . "','','" . $id . "','" . date('Y-m-d H:i:s') . "') ";




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
    print_r($result);
    print_r($utm);
    exit();



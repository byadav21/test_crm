<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');

//error_reporting(-1);
//ini_set('display_errors', 'On');
ini_set('memory_limit', '-1');

class AOR_ReportsViewdashboardadityareportsnew extends SugarView
{

    var $report_to_id;
    var $counsellors_arr;

    public function __construct()
    {
        parent::SugarView();
    }

    public function getVendorBatchLeads($from_date, $to_date)
    {
        global $db;
        $proSql = 'SELECT COUNT(l.id) AS total_lead_count, DATE_FORMAT(l.date_entered, "%Y-%m-%d") as Createdate, b.batch_code, l.vendor, b.fees_inr FROM leads AS l LEFT JOIN leads_cstm AS lc ON l.id = lc.id_c LEFT JOIN te_ba_batch AS b ON lc.te_ba_batch_id_c = b.id LEFT JOIN te_vendor on lower(l.vendor)=lower(te_vendor.name) LEFT JOIN users ON l.assigned_user_id = users.id WHERE DATE_FORMAT(l.date_entered, "%Y-%m-%d") >= "'.$from_date.'" AND DATE_FORMAT(l.date_entered, "%Y-%m-%d") <= "'.$to_date.'" AND l.vendor NOT IN ("Crosssell_churned","TAcademy","Channel")  AND l.id NOT IN (SELECT leads.id FROM `leads` INNER JOIN users ON leads.assigned_user_id = users.id WHERE users.user_name LIKE "te.%") GROUP BY Createdate, l.vendor,b.batch_code ORDER BY DATE_FORMAT(l.date_entered, "%Y-%m-%d") DESC';
        $pro_Obj     = $db->query($proSql);
        // echo "<pre>"; print_r($pro_Obj);die('imh');
        while ($emapData   = $db->fetchByAssoc($pro_Obj))
        {
            $SQLSELECT = "SELECT COUNT(*) as countData FROM dashboard_expenses_report where batch_code= '".$emapData['batch_code']."' AND vendor = '".$emapData['vendor']."' AND DATE_FORMAT(date_entered = '".$emapData['Createdate']."', '%Y-%m-%d') ";
            $result_set =   $db->query($SQLSELECT);
            $contRow    =   $db->fetchByAssoc($result_set);
            // echo "<pre>"; print_r($result_set);die('imhere');
            if($contRow['countData'] > 0) {
                
                $updatesql = 'UPDATE dashboard_expenses_report SET batch_code = "'.$emapData['batch_code'].'", vendor = "'.$emapData['vendor'].'", date_modified = "'.date("Y-m-d").'", total_leads = "'.$emapData['total_lead_count'].'" WHERE batch_code = "'.$emapData['batch_code'].'" AND vendor = "'.$emapData['vendor'].'" AND  DATE_FORMAT(date_entered = "'.$emapData['Createdate'].'", "%Y-%m-%d") ';
                $result = $db->query($updatesql);
                                 
            } else {
                if($emapData['fees_inr'] != 0 && $emapData['batch_code'] != '' && $emapData['batch_code'] != NULL ){
                    $sql = 'INSERT INTO dashboard_expenses_report (batch_code, batch_fees, vendor, date_entered, date_modified, total_leads, fresh_leads, conversion, spends, revenue, budgeted_leads, budgeted_conversion, budgeted_spends, budgeted_revenue, batch_start_date, total_days_of_campaign, campaign_start_date, active ) values ("'.$emapData['batch_code'].'", "'.$emapData['fees_inr'].'", "'.$emapData['vendor'].'", "'.$emapData['Createdate'].'", "'.date("Y-m-d").'", "'.$emapData['total_lead_count'].'" , "0", "0", "0", "0", "0", "0", "0", "0", NULL, "0",NULL,"yes")';
                    $result = $db->query($sql);
                }
            }

            $getData = "SELECT * FROM dashboard_budgeted_report where batch_code= '".$emapData['batch_code']."' AND vendor = '".$emapData['vendor']."' ";
            $getresult_set =   $db->query($getData);
            $getcontRow    =   $db->fetchByAssoc($getresult_set);
            // echo "<pre>";print_r($getcontRow);die('die');
            if($getcontRow['id'] > 0  ) {
                $getActive = ($getcontRow['budgeted_spends'] == 0) ? 'NO':'Yes';
                $sql = 'UPDATE dashboard_expenses_report SET budgeted_leads = "'.$getcontRow['budgeted_leads'].'", type = "'.$getcontRow['type'].'", budgeted_conversion = "'.$getcontRow['budgeted_conversion'] .'", budgeted_spends = "'.$getcontRow['budgeted_spends'] .'", budgeted_revenue = "'.$getcontRow['budgeted_revenue'] .'", batch_start_date = "'.$getcontRow['batch_start_date'] .'", total_days_of_campaign = "'.$getcontRow['total_days_of_campaign'] .'", campaign_start_date = "'.$getcontRow['campaign_start_date'] .'", active = "'.$getActive.'", date_modified = "'.date("Y-m-d").'"  WHERE batch_code = "'.$emapData['batch_code'].'" AND vendor = "'.$emapData['vendor'].'" AND date_entered = "'.$emapData['Createdate'].'" ';
                $result = $db->query($sql);
            }
        }
    }

    public function getFressLeads($from_date, $to_date)
    {
        global $db;
        $proSql = 'SELECT COUNT(l.id) AS total_fress_lead, DATE_FORMAT(l.date_entered, "%Y-%m-%d") as Createdate, b.batch_code, l.vendor, b.fees_inr FROM leads AS l LEFT JOIN leads_cstm AS lc ON l.id = lc.id_c LEFT JOIN te_ba_batch AS b ON lc.te_ba_batch_id_c = b.id LEFT JOIN te_vendor on lower(l.vendor)=lower(te_vendor.name) LEFT JOIN users ON l.assigned_user_id = users.id WHERE DATE_FORMAT(l.date_entered, "%Y-%m-%d") >= "'.$from_date.'" AND DATE_FORMAT(l.date_entered, "%Y-%m-%d") <= "'.$to_date.'" AND l.vendor NOT IN ("Crosssell_churned","TAcademy","Channel") AND l.status_description NOT IN ("Duplicate","Re-Enquired") AND l.id NOT IN (SELECT leads.id FROM `leads` INNER JOIN users ON leads.assigned_user_id = users.id WHERE users.user_name LIKE "te.%") GROUP BY Createdate, l.vendor,b.batch_code ORDER BY DATE_FORMAT(l.date_entered, "%Y-%m-%d") DESC';
        $pro_Obj     = $db->query($proSql);
        while ($emapData   = $db->fetchByAssoc($pro_Obj))
        {
            $SQLSELECT = "SELECT COUNT(*) AS count FROM dashboard_expenses_report where batch_code= '".$emapData['batch_code']."' AND vendor = '".$emapData['vendor']."' AND date_entered = '".$emapData['Createdate']."' ";
            $result_set =   $db->query($SQLSELECT);
            $contRow    =   $db->fetchByAssoc($result_set);
            if($contRow['count'] > 0) {
                $sql = 'UPDATE dashboard_expenses_report SET fresh_leads = "'.$emapData['total_fress_lead'].'", date_modified = "'.date("Y-m-d").'" WHERE batch_code = "'.$emapData['batch_code'].'" AND vendor = "'.$emapData['vendor'].'" AND date_entered = "'.$emapData['Createdate'].'" ';
                $result = $db->query($sql);
                                 
            }
        }
    }

    public function getConvertedLeads($from_date, $to_date)
    {
        global $db;
        $proSql = 'SELECT COUNT(l.id) AS total_lead_converted, DATE_FORMAT(l.date_entered, "%Y-%m-%d") as Createdate, b.batch_code, l.vendor, b.fees_inr FROM leads AS l LEFT JOIN leads_cstm AS lc ON l.id = lc.id_c LEFT JOIN te_ba_batch AS b ON lc.te_ba_batch_id_c = b.id LEFT JOIN te_vendor on lower(l.vendor)=lower(te_vendor.name) LEFT JOIN users ON l.assigned_user_id = users.id WHERE DATE_FORMAT(l.date_entered, "%Y-%m-%d") >= "'.$from_date.'" AND DATE_FORMAT(l.date_entered, "%Y-%m-%d") <= "'.$to_date.'" AND l.vendor NOT IN ("Crosssell_churned","TAcademy","Channel") AND l.status IN ("Converted") AND l.id NOT IN (SELECT leads.id FROM `leads` INNER JOIN users ON leads.assigned_user_id = users.id WHERE users.user_name LIKE "te.%") GROUP BY Createdate, l.vendor,b.batch_code ORDER BY DATE_FORMAT(l.date_entered, "%Y-%m-%d") DESC';
        $pro_Obj     = $db->query($proSql);
        while ($emapData   = $db->fetchByAssoc($pro_Obj))
        {
            $SQLSELECT = "SELECT COUNT(*) as count FROM dashboard_expenses_report where batch_code= '".$emapData['batch_code']."' AND vendor = '".$emapData['vendor']."' AND  date_entered = '".$emapData['Createdate']."' ";
            $result_set =   $db->query($SQLSELECT);
            $contRow    =   $db->fetchByAssoc($result_set);

            if($contRow['count'] > 0) {
                $revenue = $emapData['fees_inr'] * $emapData['total_lead_converted'];
                $sql = 'UPDATE dashboard_expenses_report SET conversion = "'.$emapData['total_lead_converted'] .'", revenue = "'.$revenue .'", date_modified = "'.date("Y-m-d").'" WHERE batch_code = "'.$emapData['batch_code'].'" AND vendor = "'.$emapData['vendor'].'" AND  date_entered = "'.$emapData['Createdate'].'" ';
                $result = $db->query($sql);
                                 
            }
        }
    }

    public function display()
    {

        global $sugar_config, $app_list_strings, $current_user, $db;
       
        if (!isset($_SESSION['cccon_from_date']))
        {
            $_SESSION['cccon_from_date'] = date('Y-m-d', strtotime('-1 days'));
        }
        if (!isset($_SESSION['cccon_to_date']))
        {
            $_SESSION['cccon_to_date'] = date('Y-m-d', strtotime('-1 days'));
        }
        if (isset($_POST['button']) || isset($_POST['export']))
        {
            $_SESSION['cccon_from_date']    = $_REQUEST['from_date'];
            $_SESSION['cccon_to_date']      = $_REQUEST['to_date'];
            $_SESSION['cccon_exportwith']   = $_REQUEST['exportwith'];
        }
        if ($_SESSION['cccon_from_date'] != "" && $_SESSION['cccon_to_date'] != "")
        {
            $selected_from_date = $_SESSION['cccon_from_date'];
            $selected_to_date   = $_SESSION['cccon_to_date'];
            $from_date          = date('Y-m-d', strtotime(str_replace('/', '-', $_SESSION['cccon_from_date'])));
            $to_date            = date('Y-m-d', strtotime(str_replace('/', '-', $_SESSION['cccon_to_date'])));
            
        }
        elseif ($_SESSION['cccon_from_date'] != "" && $_SESSION['cccon_to_date'] == "")
        {
            $selected_from_date = $_SESSION['cccon_from_date'];
            $from_date          = date('Y-m-d', strtotime(str_replace('/', '-', $_SESSION['cccon_from_date'])));
            
        }
        elseif ($_SESSION['cccon_from_date'] == "" && $_SESSION['cccon_to_date'] != "")
        {
            $selected_to_date = $_SESSION['cccon_to_date'];
            $to_date          = date('Y-m-d', strtotime(str_replace('/', '-', $_SESSION['cccon_to_date'])));
            
        }
        
        $getVendorBatchLeads = $this->getVendorBatchLeads($from_date, $to_date);
        $getFressLeads       = $this->getFressLeads($from_date, $to_date);
        $getConvertedLeads   = $this->getConvertedLeads($from_date, $to_date);
        
        $getAllData = "SELECT * FROM dashboard_expenses_report where date_entered BETWEEN '".$from_date."' AND '".$to_date."' ";
        $getAllData =   $db->query($getAllData);
        $allResultSetsData = array();
        // $programList = array();

        while ($row = $db->fetchByAssoc($getAllData))
        {
            $allResultSetsData[] = $row;
        }
        $programList = $allResultSetsData;

        $total     = count($programList); #total records
        $start     = 0;
        $per_page  = 1000;//$total;
        $page      = 1;
        $pagenext  = 1;
        $last_page = ceil($total / $per_page);

        if (isset($_REQUEST['page']) && $_REQUEST['page'] > 0)
        {
            $start    = $per_page * ($_REQUEST['page'] - 1);
            $page     = ($_REQUEST['page'] - 1);
            $pagenext = ($_REQUEST['page'] + 1);
        }
        else
        {

            $pagenext++;
        }
        if (($start + $per_page) < $total)
        {
            $right = 1;
        }
        else
        {
            $right = 0;
        }
        if (isset($_REQUEST['page']) && $_REQUEST['page'] == 1)
        {
            $left = 0;
        }
        elseif (isset($_REQUEST['page']))
        {

            $left = 1;
        }

        $programList = array_slice($programList, $start, $per_page);
        if ($total > $per_page)
        {
            $current = "(" . ($start + 1) . "-" . ($start + $per_page) . " of " . $total . ")";
        }
        else
        {
            $current = "(" . ($start + 1) . "-" . count($programList) . " of " . $total . ")";
        }
        #pE
        $sugarSmarty = new Sugar_Smarty();

        $sugarSmarty->assign("programList", $programList);

        $sugarSmarty->assign("getVendorBatchLeads", $getVendorBatchLeads);
        $sugarSmarty->assign("getFressLeads", $getFressLeads);
        $sugarSmarty->assign("getConvertedLeads", $getConvertedLeads);
        $sugarSmarty->assign("allResultSetsData", $allResultSetsData);

        $sugarSmarty->assign("selected_from_date", $selected_from_date);
        $sugarSmarty->assign("selected_to_date", $selected_to_date);
        $sugarSmarty->assign("current_records", $current);
        $sugarSmarty->assign("page", $page);
        $sugarSmarty->assign("pagenext", $pagenext);
        $sugarSmarty->assign("right", $right);
        $sugarSmarty->assign("left", $left);
        $sugarSmarty->assign("last_page", $last_page);
        $sugarSmarty->display('custom/modules/AOR_Reports/tpls/dashboardadityareportsnew.tpl');
    }

}

?>

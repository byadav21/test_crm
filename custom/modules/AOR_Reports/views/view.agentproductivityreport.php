<?php

// Date: Created on : 27th FEB 2018

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');

//error_reporting(-1);
//ini_set('display_errors', 'On');

class AOR_ReportsViewagentproductivityreport extends SugarView
{

    var $report_to_id;
    var $counsellors_arr;

    public function __construct()
    {
        parent::SugarView();
    }

    function getCouncelorForAdmin($role = '')
    {
        global $db;
        $id = '';

        if ($role == 'manager')
        {
            $id = '7e225ca3-69fa-a75d-f3f2-581d88cafd9a';
        }
        else
        {
            $id = '270ce9dd-7f7d-a7bf-f758-582aeb4f2a45';
        }

        $userSql  = "SELECT u.first_name,
                                u.last_name,
                                u.id,
                                ru.first_name AS reporting_firstname,
                                ru.last_name AS reporting_lastname,
                                ru.id AS reporting_id
                         FROM users AS u
                         INNER JOIN acl_roles_users AS aru ON aru.user_id=u.id
 			 INNER join acl_roles on aru.role_id=acl_roles.id
                         INNER JOIN users AS ru ON ru.id=u.reports_to_id
                         WHERE aru.`role_id` IN ('$id')
                           AND u.deleted=0
                           AND aru.deleted=0 and acl_roles.deleted=0 ";
        $userObj  = $db->query($userSql);
        $usersArr = [];
        while ($user     = $db->fetchByAssoc($userObj))
        {

            $usersArr[$user['id']]['id']             = $user['id'];
            $usersArr[$user['id']]['name']           = $user['first_name'] . ' ' . $user['last_name'];
            $usersArr[$user['id']]['reporting_id']   = $user['reporting_id'];
            $usersArr[$user['id']]['reporting_name'] = $user['reporting_firstname'] . ' ' . $user['reporting_lastname'];
        }
        return $usersArr;
    }

    function getBatch()
    {
        global $db;
        $batchSql     = "SELECT id,name,batch_code,d_campaign_id,d_lead_id FROM te_ba_batch WHERE batch_status='enrollment_in_progress' AND deleted=0 order by name";
        $batchObj     = $db->query($batchSql);
        $batchOptions = array();
        while ($row          = $db->fetchByAssoc($batchObj))
        {
            $batchOptions[] = $row;
        }
        return $batchOptions;
    }

    function getConversion()
    {
        global $db;
        $leadList = array();
        $key      = '';
        if (isset($_SESSION['cccon_managers']) && !empty($_SESSION['cccon_managers']) && empty($_SESSION['cccon_councellors']))
        {
            //echo "ddd";
            $key = 'batch_code,';
        }
        $leadSql = "SELECT COUNT(leads.id) AS Convertedcount,
                                    leads.assigned_user_id user_id,
                                    MONTH(leads.converted_date) AS Converted_month,
                                    YEAR(leads.converted_date) AS Converted_Year,
                                    IF(te_ba_batch.batch_code IS NULL,'NULL',te_ba_batch.batch_code) AS batch_code,
                                    SUM(te_ba_batch.fees_inr) AS GSV,
                                    te_ba_batch.fees_inr
                             FROM leads
                             LEFT JOIN leads_cstm ON leads.id = leads_cstm.id_c
                             LEFT JOIN te_ba_batch ON leads_cstm.te_ba_batch_id_c = te_ba_batch.id
                             WHERE leads.deleted=0
                               AND leads.status='Converted'
                               AND leads.deleted=0
                               #AND YEAR(leads.converted_date)='2017'
                             GROUP BY $key user_id,
                                           Converted_month,
                                           Converted_Year ";

        $leadObj = $db->query($leadSql);



        while ($row = $db->fetchByAssoc($leadObj))
        {
            if (isset($_SESSION['cccon_managers']) && !empty($_SESSION['cccon_managers']) && empty($_SESSION['cccon_councellors']))
            {
                $leadList[$row['user_id'] . '_' . $row['Converted_month'] . '_' . $row['Converted_Year'] . '_' . $row['batch_code']]['Convertedcount'] = $row['Convertedcount'];
                $leadList[$row['user_id'] . '_' . $row['Converted_month'] . '_' . $row['Converted_Year'] . '_' . $row['batch_code']]['gsv']            = round($row['GSV'], 2);
                $leadList[$row['user_id'] . '_' . $row['Converted_month'] . '_' . $row['Converted_Year'] . '_' . $row['batch_code']]['batch_code']     = $row['batch_code'];
            }
            else
            {
                $leadList[$row['user_id'] . '_' . $row['Converted_month'] . '_' . $row['Converted_Year']]['Convertedcount'] = $row['Convertedcount'];
                $leadList[$row['user_id'] . '_' . $row['Converted_month'] . '_' . $row['Converted_Year']]['gsv']            = round($row['GSV'], 2);
                $leadList[$row['user_id'] . '_' . $row['Converted_month'] . '_' . $row['Converted_Year']]['batch_code']     = $row['batch_code'];
            }
        }

        return $leadList;
    }

    public function display()
    {

        global $sugar_config, $app_list_strings, $current_user, $db;


        $where      = "";
        $wherecl    = "";
        $campaignID = array();
        $leadID     = array();

        $BatchListData = $this->getBatch();

        $error = array();

        $managerSList    = $this->getCouncelorForAdmin('manager');
        $CouncellorsList = $this->getCouncelorForAdmin();
        
        

        if (isset($_POST['button']) || isset($_POST['export']))
        {
            $_SESSION['cccon_from_date']   = $_REQUEST['from_date'];
            $_SESSION['cccon_to_date']     = $_REQUEST['to_date'];
            $_SESSION['cccon_batch']       = $_REQUEST['batch'];
            $_SESSION['cccon_batch_code']  = $_REQUEST['batch_code'];
            $_SESSION['cccon_managers']    = $_REQUEST['managers'];
            $_SESSION['cccon_councellors'] = $_REQUEST['councellors'];
            $_SESSION['cccon_status']      = $_REQUEST['status'];
            $_SESSION['cccon_status']      = $_REQUEST['status'];

            $_SESSION['cccon_month'] = $_REQUEST['month'];
            $_SESSION['cccon_years'] = $_REQUEST['years'];
        }

      


        $findBatch = array();

        if (!empty($_SESSION['cccon_batch_code']))
        {
            $selected_batch_code = $_SESSION['cccon_batch_code'];
        }

        if (!empty($_SESSION['cccon_status']))
        {
            $selected_status = $_SESSION['cccon_status'];
        }
        if (!empty($_SESSION['cccon_councellors']))
        {
            $selected_councellors = $_SESSION['cccon_councellors'];
        }
        if (!empty($_SESSION['cccon_managers']))
        {
            $selected_managers = $_SESSION['cccon_managers'];
        }
        if (!empty($_SESSION['cccon_month']))
        {
            $selected_month = $_SESSION['cccon_month'];
        }
        if (!empty($_SESSION['cccon_years']))
        {
            $selected_years = $_SESSION['cccon_years'];
        }



        $leadList   = array();
        $StatusList = array();


        if (!empty($selected_batch_code))
        {
            $wherecl .= " AND  batch_id IN ('" . implode("','", $selected_batch_code) . "')";
        }



        if (!empty($selected_councellors))
        {
            $wherecl .= " AND  user_id IN ('" . implode("','", $selected_councellors) . "')";
        }
        
        if (!empty($selected_month))
        {
            $wherecl .= " AND  month IN ('" . implode("','", $selected_month) . "')";
        }
        if (!empty($selected_years))
        {
            $wherecl .= " AND  year IN ('" . implode("','", $selected_years) . "')";
        }


        $months = array(1  => 'January', 2  => 'February', 3  => 'March', 4  => 'April', 5  => 'May', 6  => 'June', 7  => 'July',
            8  => 'August', 9  => 'September', 10 => 'October', 11 => 'November', 12 => 'December');

        $current_year = date('Y');
        $range        = range($current_year, $current_year - 5);
        $yearsList    = array_combine($range, $range);




       $leadSql = "SELECT id,
                           user_name,
                           user_id,
                           reporting_to,
                           month,
                           year,
                           target_gsv,
                           target_unit,
                           batch_code,
                           batch_id,
                           status,
                           deleted,
                           created_date         
                     FROM agent_productivity_report
                     WHERE STATUS=1 
                     AND deleted=0 
                     #AND YEAR(created_date)='2017' 
                     $wherecl
                     ORDER BY user_id,created_date DESC";

        $leadObj = $db->query($leadSql);

        $ConversionArr = $this->getConversion();

        //echo '<pre>';
        //print_r($ConversionArr);

        $key             = '';
        $totalConversion = '';
        $GSV             = '';
        while ($row             = $db->fetchByAssoc($leadObj))
        {

            if (isset($_SESSION['cccon_councellors']) && !empty($_SESSION['cccon_councellors']) && empty($_SESSION['cccon_managers']))
            {
                //echo 'one';
                $key = $row['user_id'] . '_' . $row['month'] . '_' . $row['year'];
            }
            else if (isset($_SESSION['cccon_managers']) && !empty($_SESSION['cccon_managers']) && empty($_SESSION['cccon_councellors']))
            {
                //echo 'two';
                $key = $row['user_id'] . '_' . $row['month'] . '_' . $row['year'] . '_' . $row['batch_id'];
            }
            else if (isset($_SESSION['cccon_managers']) && !empty($_SESSION['cccon_managers']) && !empty($_SESSION['cccon_councellors']))
            {
                //echo 'three';
                $key = $row['user_id'] . '_' . $row['month'] . '_' . $row['year'];
            }

            $totalConversion = isset($ConversionArr[$key]['Convertedcount']) ? $ConversionArr[$key]['Convertedcount'] : 0;
            $GSV             = isset($ConversionArr[$key]['gsv']) ? $ConversionArr[$key]['gsv'] : 0;

            $leadList[$key]['user_name']    = $row['user_name'];
            $leadList[$key]['user_id']      = $row['user_id'];
            $leadList[$key]['reporting_to'] = $row['reporting_to'];
            $leadList[$key]['month']        = $row['month'];
            $leadList[$key]['year']         = $row['year'];
            $leadList[$key]['target_gsv']   = $row['target_gsv'];
            $leadList[$key]['target_unit']  = $row['target_unit'];
            $leadList[$key]['batch_code']   = $row['batch_code'];
            $leadList[$key]['batch_id']     = $row['batch_id'];
            $leadList[$key]['status']       = $row['status'];
            $leadList[$key]['deleted']      = $row['deleted'];
            $leadList[$key]['created_date'] = $row['created_date'];

            $leadList[$key]['Conversions'] = $totalConversion;
            $leadList[$key]['gsv']         = $GSV;

            $leadList[$key]['percentage_target_achieved_units'] = (($totalConversion / $row['target_unit']) * 100);
            $leadList[$key]['percentage_target_achieved_gsv']   = (($GSV / $row['target_gsv']) * 100);
            $leadList[$key]['remaining_units']                  = ($row['target_unit'] - $totalConversion);
            $leadList[$key]['remaining_gsv']                    = ($row['target_gsv'] - $GSV);
        }


        if ((!isset($_SESSION['cccon_managers']) && empty($_SESSION['cccon_managers'])) && (!isset($_SESSION['cccon_councellors']) && empty($_SESSION['cccon_councellors'])))
        {
            $leadList = array();
        }

        //echo '<pre>';
        //print_r($leadList);
        #PS @Pawan
        $total     = count($leadList); #total records
        $start     = 0;
        $per_page  = 60;
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

        $leadList = array_slice($leadList, $start, $per_page);
        if ($total > $per_page)
        {
            $current = "(" . ($start + 1) . "-" . ($start + $per_page) . " of " . $total . ")";
        }
        else
        {
            $current = "(" . ($start + 1) . "-" . count($leadList) . " of " . $total . ")";
        }
        #pE

        $sugarSmarty = new Sugar_Smarty();

        $sugarSmarty->assign("error", $error);
        $sugarSmarty->assign("leadList", $leadList);



        $sugarSmarty->assign("BatchListData", $BatchListData);

        $sugarSmarty->assign("StatusList", $StatusList);
        $sugarSmarty->assign("leadList", $leadList);

        $sugarSmarty->assign("selected_batch_code", $selected_batch_code);
        $sugarSmarty->assign("selected_from_date", $selected_from_date);
        $sugarSmarty->assign("selected_to_date", $selected_to_date);
        $sugarSmarty->assign("lead_source_type", $lead_source);



        $sugarSmarty->assign("selected_status", $selected_status);

        $sugarSmarty->assign("selected_source", $selected_source);
        $sugarSmarty->assign("selected_managers", $selected_managers);
        $sugarSmarty->assign("selected_councellors", $selected_councellors);

        $sugarSmarty->assign("selected_month", $selected_month);
        $sugarSmarty->assign("selected_years", $selected_years);

        $sugarSmarty->assign("CouncellorsList", $CouncellorsList);
        $sugarSmarty->assign("managerSList", $managerSList);
        $sugarSmarty->assign("month", $months);
        $sugarSmarty->assign("years", $yearsList);

        $sugarSmarty->assign("current_records", $current);
        $sugarSmarty->assign("page", $page);
        $sugarSmarty->assign("pagenext", $pagenext);
        $sugarSmarty->assign("right", $right);
        $sugarSmarty->assign("left", $left);
        $sugarSmarty->assign("last_page", $last_page);
        $sugarSmarty->display('custom/modules/AOR_Reports/tpls/agentproductivityreport.tpl');
    }

}
?>


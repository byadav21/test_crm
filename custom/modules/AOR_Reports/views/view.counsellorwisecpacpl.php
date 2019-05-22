<?php

// Last modified on:  03th APP 2019

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');
require_once('custom/modules/AOR_Reports/pagination.php');
require_once('custom/modules/AOR_Reports/UserInput.php');

//error_reporting(-1);
//ini_set('display_errors', 'On');
ini_set('memory_limit', '-1');

class AOR_ReportsViewCounsellorwisecpacpl extends SugarView
{

    var $report_to_id;
    var $counsellors_arr;
    private $objPagination;
    private $_objInputs;

    public function __construct()
    {
        parent::SugarView();
        $this->objPagination = new pagination(60, 'page');
        $this->_objInputs    = new UserInput();
        $this->_objInputs->syncSessions('counsellorwisecpacpl');
    }

    function getManagers($role = '')
    {
        global $db, $current_user;

        $userSql  = "SELECT u.id user_id,
                        CONCAT(u.first_name, ' ', u.last_name) User_Name,
                        u.user_name user_email,
                        u.status user_Status,
                        ru.id AS reporting_id,
                        CONCAT(ru.first_name, ' ', ru.last_name) Reporting_Name,
                        ru.user_name Reporting_Email,
                        acl_roles.name role_name,
                        ru.status Reporting_user_status
                 FROM users AS u
                 INNER JOIN acl_roles_users AS aru ON aru.user_id=u.id
                 INNER JOIN acl_roles ON aru.role_id=acl_roles.id
                 INNER JOIN users AS ru ON ru.id=u.reports_to_id
                 WHERE u.deleted=0
                   AND aru.deleted=0
                   AND acl_roles.deleted=0";
        $userObj  = $db->query($userSql);
        $usersArr = [];
        while ($user     = $db->fetchByAssoc($userObj))
        {

            $usersArr[$user['user_id']]['id']             = $user['id'];
            $usersArr[$user['user_id']]['name']           = $user['User_Name'];
            $usersArr[$user['user_id']]['reporting_id']   = $user['reporting_id'];
            $usersArr[$user['user_id']]['reporting_name'] = $user['Reporting_Name'];
        }
        return $usersArr;
    }

    function getConversion($fdate, $todate)
    {
        global $db, $current_user;



        $cSql    = "SELECT  
                        count(l.id) lead_count, 
                        l.assigned_user_id,
                        date(l.date_entered) date_entered, 
                        lc.te_ba_batch_id_c,
                        l.vendor
                                        FROM leads l
                                INNER JOIN leads_cstm AS lc ON l.id=lc.id_c
                         WHERE l.deleted=0
                        AND DATE(l.`date_entered`) >= '$fdate' 
                        AND DATE(l.`date_entered`) <= '$todate' 
                        AND l.status='Converted'
                        group by  l.assigned_user_id,date(l.date_entered),lc.te_ba_batch_id_c,l.vendor
                        order by  l.assigned_user_id,date(l.date_entered),lc.te_ba_batch_id_c,l.vendor";
        //echo $cSql;
        $cObj    = $db->query($cSql);
        $dateArr = [];
        while ($cdata   = $db->fetchByAssoc($cObj))
        {
            $keyX           = strtolower($cdata['assigned_user_id'] . '_' . $cdata['date_entered'] . '_' . $cdata['te_ba_batch_id_c'] . '_' . $cdata['vendor']);
            $dateArr[$keyX] = $cdata['lead_count'];
        }
        return $dateArr;
    }
    
    function getSpends($fdate, $todate)
    {
        global $db, $current_user;

        $cSql    = "SELECT 
            ac.`id`,
            ac.`plan_date`,
            ac.`total_cost`,
            ac.`te_ba_batch_id_c`,
            ac.`vendor_id`,
            te_vendor.name vendor_name
     FROM `te_actual_campaign ac`
     inner join te_vendor on ac.vendor_id=te_vendor.id
     WHERE deleted=0 
     and `plan_date` >='$fdate'
     and `plan_date` <='$todate'";
        //echo $cSql;
        $cObj    = $db->query($cSql);
        $dateArr = [];
        while ($cdata   = $db->fetchByAssoc($cObj))
        {
            $keyX           = strtolower($cdata['plan_date'] . '_' . $cdata['te_ba_batch_id_c'] . '_' . $cdata['vendor_name']);
            $dateArr[$keyX] = $cdata['total_cost'];
        }
        return $dateArr;
    }

    function Header()
    {
        $headerArr = array();

        $headerArr = array(
            'Counsellor Name',
            'Manager Name',
            'TL Name',
            'Date',
            'Batch Code',
            'Source/Vendor',
            'Leads',
            'Conversion',
            'Spend',
            'Revenue/gsv',
            'Conversion Rate',
            'CPL',
            'CPA');

        return $headerArr;
    }

    function getBetweenDays($fromData, $toDate)
    {

        $fromData   = strtotime($fromData);
        $toDate     = strtotime($toDate);
        $difference = $toDate - $fromData;
        $days       = floor($difference / (60 * 60 * 24));
        return $days;
    }

    public function display()
    {

        global $sugar_config, $app_list_strings, $current_user, $db;
        $current_user_id       = $current_user->id;
        $current_user_is_admin = $current_user->is_admin;
        $_export               = isset($this->_objInputs->post['export']) && $this->_objInputs->post['export'] == "Export";

        $report_action = '';
        $reportAccess  = reportAccessLog();

        $current_user_id = $current_user->id;
        $report_action   = isset($GLOBALS['action']) ? $GLOBALS['action'] : '';


        if (!in_array($current_user->id, $reportAccess[$report_action]) && ($current_user->is_admin != 1))
        {
            echo 'You are not authorized to access!';
            return;
        }

        $where            = "";
        $wherecl          = "";
        $selected_vendors = "";
        $programList      = array();
        $StatusList       = array();
        $leadList         = array();

        $selected_from_date = $this->_objInputs->getVal('from_date', 'post', date('Y-m-d', strtotime('-1 days')));
        $selected_to_date   = $this->_objInputs->getVal('to_date', 'post', date('Y-m-d', strtotime('-1 days')));

        $selected_batch_code = $this->_objInputs->getVal('batch_code', 'post', array());
        $selected_vendors    = $this->_objInputs->getVal('vendors', 'post', array());
        $selected_program    = $this->_objInputs->getVal('program', 'post', array());
        $selected_batch      = $this->_objInputs->getVal('batch', 'post', array());

        $error = array();
        $Days  = $this->getBetweenDays($selected_from_date, $selected_to_date);

        if ($Days >= 31)
        {

            $error['error'] = 'Only one month of data are allowed to export.';
        }
        //echo '$Days=='.$Days; 


        $statusHeader = $this->Header();
        $managerArr   = $this->getManagers();

        //$BatchListData  = $this->getBatch();
        //$VendorListData = $this->getVendors();



        if ($selected_from_date != "")
        {
            $from_date = date('Y-m-d', strtotime(str_replace('/', '-', $selected_from_date)));
            $wherecl   .= " AND DATE(l.`date_entered`) >= '" . $from_date . "'";
        }

        if ($selected_to_date != "")
        {
            $to_date = date('Y-m-d', strtotime(str_replace('/', '-', $selected_to_date)));
            $wherecl .= " AND DATE(l.`date_entered`) <= '" . $to_date . "' ";
        }

        $conversionArr  = $this->getConversion($from_date, $to_date);
        $spendsArr      = $this->getSpends($from_date, $to_date);
        

        //print_r($conversionArr);

        $headers = array(
            'count(l.id) lead_count'               => 'lead_count',
            'date(l.date_entered) date_entered'    => 'date_entered',
            'l.converted_date'                       => 'converted_date',
            'users.first_name as counsellor_fname' => 'counsellor_fname',
            'users.last_name as counsellor_lname'  => 'counsellor_lname',
            'l.assigned_user_id as counsellor_id'  => 'counsellor_id',
            'l.vendor'                             => 'vendor',
            'te_ba_batch.batch_code'               => 'batch_code',
            'te_ba_batch.id as batch_id'           => 'batch_id',
            'te_ba_batch.fees_inr'                 => 'fees_inr'
        );


        $headersss = implode(', ', array_keys($headers));


///wwww
        $sqlPart = "
                FROM leads l
                INNER JOIN leads_cstm AS lc ON l.id=lc.id_c
                INNER JOIN users ON l.assigned_user_id =users.id
                INNER JOIN te_ba_batch ON lc.te_ba_batch_id_c = te_ba_batch.id
                 WHERE l.deleted=0 and te_ba_batch.deleted=0 and users.deleted=0
                   $wherecl
               group by  date(l.date_entered),l.assigned_user_id,te_ba_batch.batch_code,l.vendor
               order by  date(l.date_entered),l.assigned_user_id,te_ba_batch.batch_code,l.vendor ";

        $countSql = "SELECT $headersss ". $sqlPart;


        $leadSql = "SELECT  $headersss " . $sqlPart;

        //echo '<pre>'.$leadSql;
        //die($leadSql);
        if (!$_export)
        {
            $limit   = $this->objPagination->get_limit();
            $leadSql .= ' ' . $limit;
        }
        $rowCount = 0;
        $leadObj  = null;

        if (empty($error))
        {
            if ($_export && empty($error))
            {
                $leadObj  = $db->query($leadSql);
                $rowCount = $leadObj->num_rows;
                if ($rowCount <= 0)
                {
                    $error['error'] = "No Data Found.";
                }
            }
            else
            {
                if ($this->objPagination->get_page() == 1 || !isset($_SESSION['_row_count']))
                {
                     $objLeadsCount          = $db->query($countSql);
                    //$row                    = $db->fetchByAssoc($objLeadsCount);
                    //echo 'xxx='.$rowCount               = count($row);
                    while ($row = $db->fetchByAssoc($objLeadsCount))
                    {   
                        $keyX        = strtolower($row['counsellor_id'] . '_' . $row['date_entered'] . '_' . $row['batch_id'] . '_' . $row['vendor']);
                        $leadList[$keyX] = $row;
                    }
                    $rowCount               = count($leadList);
                    $_SESSION['_row_count'] = $rowCount;
                }
                else
                {
                    $rowCount = $_SESSION['_row_count'];
                }
                $this->objPagination->set_total($rowCount);
                if ($rowCount <= 0)
                {
                    $error['error'] = "No Data Found.";
                }
                else
                {
                    $leadObj = $db->query($leadSql);
                }
            }
            //print_r($leadObj);

            $spend           = '';
            $gsv             = '';
            $conversion_rate = '';
            $cpl             = '';
            $cpa             = '';
            $conversion      = '';
            $coursefee       = '';

            while ($row = $db->fetchByAssoc($leadObj))
            {
                $keyX        = strtolower($row['counsellor_id'] . '_' . $row['date_entered'] . '_' . $row['batch_id'] . '_' . $row['vendor']);
                //$conversionX = strtolower($row['counsellor_id'] . '_' . $row['converted_date'] . '_' . $row['batch_id'] . '_' . $row['vendor']);
                $SpendskeyX  = strtolower($row['date_entered'] . '_' . $row['batch_id'] . '_' . $row['vendor']);

                $leadCount       = isset($row['lead_count']) ? $row['lead_count'] : 0;
                $conversion      = isset($conversionArr[$keyX]) ? $conversionArr[$keyX] : 0;
                $coursefee       = ($row['fees_inr']!='')? $row['fees_inr'] : 0;
                $spend           = isset($spendsArr[$SpendskeyX])? $spendsArr[$SpendskeyX] : 0;
                $gsv             = ($coursefee * $conversion);
                $conversion_rate = ($conversion / $leadCount);
                $cpl             = ($spend / $leadCount);
                $cpa             = ($spend / $gsv);

                $programList[$keyX]['counsellor_id']   = $row['counsellor_id'];
                $programList[$keyX]['date_entered']    = $row['date_entered'];
                $programList[$keyX]['counsellor_name'] = $row['counsellor_fname'] . ' ' . $row['counsellor_lname'];
                $programList[$keyX]['manager_name']    = isset($managerArr[$row['counsellor_id']]) ? $managerArr[$row['counsellor_id']]['reporting_name'] : 'NA';
                $programList[$keyX]['tl_name']         = 'NA';
                $programList[$keyX]['batch_code']      = isset($row['batch_code']) ? $row['batch_code'] : 'N/A';
                $programList[$keyX]['vendor']          = isset($row['vendor']) ? $row['vendor'] : 'N/A';
                $programList[$keyX]['lead_count']      = $leadCount;
                $programList[$keyX]['conversion']      = $conversion;
                $programList[$keyX]['spend']           = $spend;
                $programList[$keyX]['gsv']             = $gsv;
                $programList[$keyX]['conversion_rate'] = $conversion_rate;
                $programList[$keyX]['cpl']             = $cpl;
                $programList[$keyX]['cpa']             = $cpa;
            }

            $StatusList = $statusHeader;
        }// checking error end if line no. 226
        //echo "<pre>";print_r($programList);
        //exit();


        if ($_export && empty($error))
        {

            $file     = "counsellorwisecpacpl_report";
            $where    = '';
            $filename = $file . "_" . $from_date . "_" . $to_date;


            $StatusList = $statusHeader;
            
            

            $data .= "Counsellor Name";
            $data .= ",Manager Name";
            $data .= ",TL Name";
            $data .= ",Date";
            $data .= ",Batch Code";
            $data .= ",Source/Vendor";
            $data .= ",Leads";
            $data .= ",Conversion";
            $data .= ",Spend";
            $data .= ",gsv";
            $data .= ",Conversion Rate";
            $data .= ",CPL";
            $data .= ",CPA";
            $data .= "\n";
            
      


           foreach ($programList as $key => $councelor)
            {
                //$data .= "\"" . $councelor['program_name'];
                $data .= "\"" . $councelor['counsellor_name'];
                $data .= "\",\"" . $councelor['manager_name'];
                $data .= "\",\"" . $councelor['tl_name'];
                $data .= "\",\"" . $councelor['date_entered'];
                $data .= "\",\"" . $councelor['batch_code'];
                $data .= "\",\"" . $councelor['vendor'];
                $data .= "\",\"" . $councelor['lead_count'];
                $data .= "\",\"" . $councelor['conversion'];
                $data .= "\",\"" . $councelor['spend'];
                $data .= "\",\"" . $councelor['gsv'];
                $data .= "\",\"" . $councelor['conversion_rate'];
                $data .= "\",\"" . $councelor['cpl'];
                $data .= "\",\"" . $councelor['cpa'];
                $data .= "\"\n";
            }

            ob_end_clean();
            header("Content-type: application/csv");
            header('Content-disposition: attachment;filename=" ' . $filename . '.csv";');
            echo $data;
            exit;
        } // End Of Export Func
        #PS @Pawan

        $page         = $this->objPagination->get_page();
        $last_page    = $this->objPagination->get_last_page();
        $pagenext     = $page + 1;
        $pageprevious = $page - 1;

        $right = $page < $last_page;
        $left  = $page > 1;

        if (empty($error))
        {
            while ($row = $db->fetchByAssoc($leadObj))
            {   
                $keyX        = strtolower($row['counsellor_id'] . '_' . $row['date_entered'] . '_' . $row['batch_id'] . '_' . $row['vendor']);
                $leadList[$keyX] = $row;
            }
            $this->objPagination->set_found_rows(count($leadList));
        }
        $current = $this->objPagination->getHeading();

        #pE


        $sugarSmarty = new Sugar_Smarty();

        $sugarSmarty->assign("error", $error);

        $sugarSmarty->assign("headers", $headers);
        $sugarSmarty->assign("tablewidth", count($headers) * 130);

        $sugarSmarty->assign("programList", $programList);

        $sugarSmarty->assign("StatusList", $StatusList);

        $sugarSmarty->assign("selected_batch_code", $selected_batch_code);

        $sugarSmarty->assign("selected_batch", $selected_batch);
        $sugarSmarty->assign("selected_from_date", $selected_from_date);
        $sugarSmarty->assign("selected_to_date", $selected_to_date);
        $sugarSmarty->assign("selected_vendor", $selected_vendors);

        $sugarSmarty->assign("current_records", $current);
        $sugarSmarty->assign("page", $page);
        $sugarSmarty->assign("pagenext", $pagenext);
        $sugarSmarty->assign("pageprevious", $pageprevious);
        $sugarSmarty->assign("right", $right);
        $sugarSmarty->assign("left", $left);
        $sugarSmarty->assign("last_page", $last_page);
        $sugarSmarty->display('custom/modules/AOR_Reports/tpls/counsellorwisecpacpl.tpl');
    }

}
?>


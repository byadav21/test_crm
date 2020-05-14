<?php

// Last modified on:  03th APP 2019

if (!defined('sugarEntry') || !sugarEntry)
{
    die('Not A Valid Entry Point');
}
require_once('custom/include/Email/sendmail.php');
require_once('custom/modules/AOR_Reports/pagination.php');
require_once('custom/modules/AOR_Reports/UserInput.php');

//error_reporting(-1);
//ini_set('display_errors', 'On');


class AOR_ReportsViewLeadscore extends SugarView
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
        $this->_objInputs->syncSessions('vendorWiseCallDisposition');
    }

    function statusHeader()
    {
        $headerArr = array();

        $headerArr = array(
            'id'                      => 'Lead ID',
            'date_entered'            => 'Date',
            'user_name'               => 'Name',
            'phone_mobile'            => 'Mobile',
            'lead_score'              => 'Score',
            'Attempts'                => 'Attempts',
            'batch_code'              => 'Batch Code',
            'status'                  => 'Status',
            'status_description'      => 'Sub Status',
            'disposition_reason'      => 'Disposition Reason'
        );

        return $headerArr;
    }

    function getVendors()
    {
        global $db;
        $vendorSql      = "SELECT id,name FROM te_vendor WHERE deleted=0";
        $vendor_Obj     = $db->query($vendorSql);
        $vendor_Options = array();
        while ($row            = $db->fetchByAssoc($vendor_Obj))
        {
            $vendor_Options[] = $row;
        }
        return $vendor_Options;
    }

    function getBatch()
    {
        global $db;
        $batchSql     = "SELECT id,name,batch_code FROM te_ba_batch WHERE  deleted=0 order by batch_code";
        $batchObj     = $db->query($batchSql);
        $batchOptions = array();
        while ($row          = $db->fetchByAssoc($batchObj))
        {
            $batchOptions[] = $row;
        }
        return $batchOptions;
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


        $crmDispo = array(
            'Callback_Customer is Busy'         => array('status' => 'Alive', 'sub_status' => 'Call Back'),
            'Callback_RPC not available'        => array('status' => 'Alive', 'sub_status' => 'Call Back'),
            'Callback_Not Answering'            => array('status' => 'Alive', 'sub_status' => 'Call Back'),
            'Followup_Interested Followup'      => array('status' => 'Alive', 'sub_status' => 'Follow Up'),
            'Followup_Need Company Approval'    => array('status' => 'Alive', 'sub_status' => 'Follow Up'),
            'Followup_Not Answering'            => array('status' => 'Alive', 'sub_status' => 'Follow Up'),
            'Prospect'                          => array('status' => 'Warm', 'sub_status' => 'Prospect'),
            'Re-Enquired'                         => array('status' => 'Warm', 'sub_status' => 'Re-Enquired'), //System disposition
            //'Received Full Payment'               => array('status' => 'Converted', 'sub_status' => 'Converted'),
            //'Received Initial EMI'                => array('status' => 'Converted', 'sub_status' => 'Converted'),
            //'Received Partial EMI'                => array('status' => 'Converted', 'sub_status' => 'Converted'),
            'Instalment Payment'                => array('status' => 'Converted', 'sub_status' => 'Converted'),
            'Referral'                          => array('status' => 'Converted', 'sub_status' => 'Converted'),
            'Number belongs to someone else'    => array('status' => 'Dead', 'sub_status' => 'Wrong Number'),
            'invalid number'                    => array('status' => 'Dead', 'sub_status' => 'Wrong Number'),
            'Not Enquired'                      => array('status' => 'Dead', 'sub_status' => 'Not Enquired'),
            'Enquired by Mistake'               => array('status' => 'Dead', 'sub_status' => 'Not Enquired'),
            'Language Barrier'                  => array('status' => 'Dead', 'sub_status' => 'Not Eligible'),
            'Education'                         => array('status' => 'Dead', 'sub_status' => 'Not Eligible'),
            'Experience'                        => array('status' => 'Dead', 'sub_status' => 'Not Eligible'),
            'DNC'                               => array('status' => 'Dead', 'sub_status' => 'DNC'),
            'Not Answering'                     => array('status' => 'Dead', 'sub_status' => 'Not Answering'),
            'Not Interested'                    => array('status' => 'Dead', 'sub_status' => 'Not Interested'),
            'NI_Reason not shared'              => array('status' => 'Dead', 'sub_status' => 'Not Interested'),
            'NI_Time Constraint'                => array('status' => 'Dead', 'sub_status' => 'Not Interested'),
            'NI_Fees is high'                   => array('status' => 'Dead', 'sub_status' => 'Not Interested'),
            'NI_Looking for Job or Placement'   => array('status' => 'Dead', 'sub_status' => 'Not Interested'),
            'NI_Enrolled with other institutes' => array('status' => 'Dead', 'sub_status' => 'Not Interested'),
            'NI_Enrolled with TE'               => array('status' => 'Dead', 'sub_status' => 'Not Interested'),
            'NI_Looking for Degree Courses'     => array('status' => 'Dead', 'sub_status' => 'Not Interested'),
            'NI_Syllabus disinterest'           => array('status' => 'Dead', 'sub_status' => 'Not Interested'),
            'NI_Efforts Exhausted'              => array('status' => 'Dead', 'sub_status' => 'Not Interested'),
            'Next_batch'                        => array('status' => 'Dead', 'sub_status' => 'Next Batch'),
            'Reason not shared'                 => array('status' => 'Dead', 'sub_status' => 'Fallout'),
            'Next batch'                        => array('status' => 'Dead', 'sub_status' => 'Fallout'),
            'Time Constraint'                   => array('status' => 'Dead', 'sub_status' => 'Fallout'),
            'Fees is high'                      => array('status' => 'Dead', 'sub_status' => 'Fallout'),
            'Looking for Job or Placement'      => array('status' => 'Dead', 'sub_status' => 'Fallout'),
            'Enrolled with other institute'     => array('status' => 'Dead', 'sub_status' => 'Fallout'),
            'Enrolled with TE'                  => array('status' => 'Dead', 'sub_status' => 'Fallout'),
            'Looking for Degree Courses'        => array('status' => 'Dead', 'sub_status' => 'Fallout'),
            'Syllabus disinterest'              => array('status' => 'Dead', 'sub_status' => 'Fallout'),
            'Efforts Exhausted'                 => array('status' => 'Dead', 'sub_status' => 'Fallout'),
            'Cross Sell'                        => array('status' => 'Dead', 'sub_status' => 'Cross Sell'),
            'wrap.timeout'                      => array('status' => 'wrap.timeout', 'sub_status' => 'wrap.timeout'),
            'user.forced.logged.off'            => array('status' => 'user.forced.logged.off', 'sub_status' => 'user.forced.logged.off'),
            'Recycle'                               => array('status' => 'Recycle', 'sub_status' => 'Recycle'),
            'Reassigned'                            => array('status' => 'Reassigned', 'sub_status' => 'Reassigned'),
        );


        //echo '<pre>';
        //print_r($crmDispo);

        $statusArr         = array();
        $suBstatusArr      = array();
        $subChildstatusArr = array();
        foreach ($crmDispo as $key => $value)
        {

            $statusArr[$value['status']]        = $value['status'];
            $suBstatusArr[$value['sub_status']] = $value['status'];
            $subChildstatusArr[$key]            = $value['sub_status'];
        }


        if (!in_array($current_user->id, $reportAccess[$report_action]) && ($current_user->is_admin != 1))
        {
            echo 'You are not authorized to access!';
            return;
        }




        $where   = "";
        $wherecl = "";
        $headerArrList       = array();
        $programList      = array();







        $selected_from_date = $this->_objInputs->getVal('from_date', 'post', date('Y-m-d', strtotime('-1 days')));
        $selected_to_date   = $this->_objInputs->getVal('to_date', 'post', date('Y-m-d', strtotime('-1 days')));



        $selected_budget       = $this->_objInputs->getVal('budget', 'post', '');
        $selected_status       = $this->_objInputs->getVal('status', 'post', '');
        $selected_subStatus    = $this->_objInputs->getVal('subStatus', 'post', '');
        $selected_statusReason = $this->_objInputs->getVal('statusReason', 'post', '');

        $error = array();
        $Days  = $this->getBetweenDays($selected_from_date, $selected_to_date);

        if ($Days >= 31)
        {

            $error['error'] = 'Only one month of data are allowed to export.';
        }
        //echo '$Days=='.$Days; 


        $statusHeader   = $this->statusHeader();
        $BatchListData  = $this->getBatch();
        $VendorListData = $this->getVendors();



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


        if (!empty($selected_budget))
        {   
            if ($selected_budget == '0-25')
            {
                $wherecl .= " AND  lc.lead_score >= 1  AND  lc.lead_score <= 25 ";
            }
            elseif ($selected_budget == '26-50')
            {
                $wherecl .= " AND  lc.lead_score >= 26  AND  lc.lead_score <= 50";
            }
            elseif ($selected_budget == '51-100')
            {
                $wherecl .= " AND  lc.lead_score >= 51  AND  lc.lead_score <= 100";
            }
            
        }
        if (!empty($selected_status))
        {

            $wherecl .= " AND  l.status='".$selected_status."'";
        }

        if (!empty($selected_subStatus))
        {

            $wherecl .= " AND  l.status_description='".$selected_subStatus."'";
        }
        if (!empty($selected_statusReason))
        {

            $wherecl .= " AND  l.disposition_reason='".$selected_statusReason."'";
        }





        $headers = array('l.id'                                                             => 'id',
            'CONVERT_TZ(l.date_entered,"+00:00","+05:30") date_entered'                     => 'date_entered',
            'concat(IFNULL(l.first_name,"")," ",IFNULL(l.last_name,""))  user_name'         => 'user_name',
            'l.phone_mobile'                                                                => 'phone_mobile',
            'lc.lead_score'                                                                 => 'lead_score',
            'lc.attempts_c'                                                                 => 'attempts_c',
            'te_ba_batch.batch_code'                                                        => 'batch_code',
            'l.status'                                                                      => 'status',
            'l.status_description'                                                          => 'status_description',
            'l.disposition_reason'                                                          => 'disposition_reason'
        );


        $headersss = implode(', ', array_keys($headers));


///wwww
        $sqlPart = "
                FROM leads l
                LEFT JOIN leads_cstm AS lc ON l.id=lc.id_c
                LEFT JOIN te_ba_batch ON lc.te_ba_batch_id_c = te_ba_batch.id
                 WHERE l.deleted=0
                   $wherecl
               order by  l.date_entered,te_ba_batch.batch_code,l.vendor  ";

        $countSql = "SELECT count(1) as count " . $sqlPart;


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
                    $row                    = $db->fetchByAssoc($objLeadsCount);
                    $rowCount               = $row['count'];
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

            while ($row = $db->fetchByAssoc($leadObj))
            {

                $programList[$row['id']]['id']                      = $row['id'];
                $programList[$row['id']]['date_entered']          = $row['date_entered'];
                $programList[$row['id']]['user_name']               = $row['user_name'];
                $programList[$row['id']]['phone_mobile']            = isset($row['phone_mobile']) ? $row['phone_mobile'] : 'N/A';
                $programList[$row['id']]['batch_code']              = isset($row['batch_code']) ? $row['batch_code'] : 'N/A';
                $programList[$row['id']]['lead_score']              = addslashes(isset($row['lead_score']) ? $row['lead_score'] : 'N/A');
                $programList[$row['id']]['attempts_c']              = addslashes(isset($row['attempts_c']) ? $row['attempts_c'] : 'N/A');
                $programList[$row['id']]['status']                  = isset($row['status']) ? $row['status'] : 'N/A';
                $programList[$row['id']]['status_description']      = isset($row['status_description']) ? $row['status_description'] : 'N/A';
                $programList[$row['id']]['disposition_reason']      = isset($row['disposition_reason']) ? $row['disposition_reason'] : 'N/A';
                
                

            }

            $headerArrList = $statusHeader;
        }// checking error end if line no. 226
        //echo "<pre>";print_r($programList);exit();


        if ($_export && empty($error))
        {

            $file     = "lead_score_report";
            $where    = '';
            $filename = $file . "_" . $from_date . "_" . $to_date;


            $headerArrList = $statusHeader;

            $data .= "Lead ID";
            $data .= ",Date";
            $data .= ",Name";
            $data .= ",Phone Number";
            $data .= ",Score";
            $data .= ",Attempts";
            $data .= ",Batch Code";
            $data .= ",Status";
            $data .= ",Sub Status";
            $data .= ",Disposition Reason";
            $data .= "\n";


            foreach ($programList as $key => $councelor)
            {
                $i = 0;
                foreach ($headerArrList as $key1 => $value)
                {

                    if ($i == 0)
                    {
                        $data .= "\"" . $councelor[$key1];
                    }
                    else
                    {
                        $data .= "\",\"" . $councelor[$key1];
                    }
                    $i++;
                }

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
                $leadList[$row['id']] = $row;
            }
            $this->objPagination->set_found_rows(count($leadList));
        }
        $current = $this->objPagination->getHeading();

        #pE


        $sugarSmarty = new Sugar_Smarty();

        $sugarSmarty->assign("error", $error);

        $sugarSmarty->assign("headers", $headers);
        $sugarSmarty->assign("tablewidth", count($headers) * 130);

        $sugarSmarty->assign("statusList", $statusArr);
        $sugarSmarty->assign("subStatusList", $suBstatusArr);
        $sugarSmarty->assign("subStatusReasonList", $subChildstatusArr);

        //echo '$selected_budget'.$selected_budget;
        $sugarSmarty->assign("selected_budget", $selected_budget);
        $sugarSmarty->assign("selected_status", $selected_status);
        $sugarSmarty->assign("selected_subStatus", $selected_subStatus);
        $sugarSmarty->assign("selected_statusReason", $selected_statusReason);
        $sugarSmarty->assign("selected_from_date", $selected_from_date);
        $sugarSmarty->assign("selected_to_date", $selected_to_date);
        //print_r($programList);
        $sugarSmarty->assign("programList", $programList);
        $sugarSmarty->assign("StatusList", $headerArrList);
        $sugarSmarty->assign("current_records", $current);
        $sugarSmarty->assign("page", $page);
        $sugarSmarty->assign("pagenext", $pagenext);
        $sugarSmarty->assign("pageprevious", $pageprevious);
        $sugarSmarty->assign("right", $right);
        $sugarSmarty->assign("left", $left);
        $sugarSmarty->assign("last_page", $last_page);
        $sugarSmarty->display('custom/modules/AOR_Reports/tpls/leadscore.tpl');
    }

}
?>


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

class AOR_ReportsViewVendorwisecalldisposition extends SugarView
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
            'vendor'                  => 'Vendor',
            'batch_code'              => 'Batch Code',
            'status'                  => 'Status',
            'status_description'      => 'Sub Status',
            'disposition_reason'      => 'Disposition Reason',
            'primary_address_city'    => 'City',
            'note'                    => 'Note',
            'comment'                 => 'Comments',
            'primary_address_state'   => 'state',
            'primary_address_country' => 'country',
            'landing_url'             => 'Landing Url',
            'utm_campaign'            => 'UTM Campaign'
                #'id'                   =>'User Name',
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


        if (!empty($selected_batch))
        {

            $wherecl .= " AND  te_ba_batch.id IN ('" . implode("','", $selected_batch) . "')";
        }
        if (!empty($selected_batch_code))
        {

            $wherecl .= " AND  te_ba_batch.id IN ('" . implode("','", $selected_batch_code) . "')";
        }

        if (!empty($selected_vendors))
        {
            
            $wherecl .= " AND  l.vendor IN ('" . implode("','", $selected_vendors) . "')";
        }





        $headers = array('l.id'                              => 'id',
            //'date(l.date_entered) date_entered' => 'date_entered',
            'CONVERT_TZ(l.date_entered,"+00:00","+05:30") date_entered' => 'date_entered',
            'l.vendor'                          => 'vendor',
            'te_ba_batch.batch_code'            => 'batch_code',
            'l.status'                          => 'status',
            'l.status_description'              => 'status_description',
            'l.disposition_reason'              => 'disposition_reason',
            'l.primary_address_city'            => 'primary_address_city',
            'l.note'                            => 'note',
            'l.comment'                         => 'comment',
            'l.primary_address_state'           => 'primary_address_state',
            'l.primary_address_country'         => 'primary_address_country',
            'lc.landing_url'                    => 'landing_url',
            'l.utm_campaign'                    => 'utm_campaign');


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
                $programList[$row['id']]['date_entered']            = $row['date_entered'];
                $programList[$row['id']]['vendor']                  = isset($row['vendor']) ? $row['vendor'] : 'N/A';
                $programList[$row['id']]['batch_code']              = isset($row['batch_code']) ? $row['batch_code'] : 'N/A';
                $programList[$row['id']]['status']                  = isset($row['status']) ? $row['status'] : 'N/A';
                $programList[$row['id']]['status_description']      = isset($row['status_description']) ? $row['status_description'] : 'N/A';
                $programList[$row['id']]['disposition_reason']      = isset($row['disposition_reason']) ? $row['disposition_reason'] : 'N/A';
                $programList[$row['id']]['primary_address_city']    = isset($row['primary_address_city']) ? $row['primary_address_city'] : 'N/A';
                $programList[$row['id']]['note']                    = addslashes(isset($row['note']) ? $row['note'] : 'N/A');
                $programList[$row['id']]['comment']                 = addslashes(isset($row['comment']) ? $row['comment'] : 'N/A');
                $programList[$row['id']]['primary_address_state']   = addslashes(isset($row['primary_address_state']) ? $row['primary_address_state'] : 'N/A');
                $programList[$row['id']]['primary_address_country'] = addslashes(isset($row['primary_address_country']) ? $row['primary_address_country'] : 'N/A');
                $programList[$row['id']]['landing_url']             = addslashes(isset($row['landing_url']) ? $row['landing_url'] : 'N/A');
                $programList[$row['id']]['utm_campaign']            = addslashes(isset($row['utm_campaign']) ? $row['utm_campaign'] : 'N/A');
            }

            $StatusList = $statusHeader;
        }// checking error end if line no. 226
        //echo "<pre>";print_r($programList);exit();


        if ($_export && empty($error))
        {

            $file     = "VendorwiseCallDispositionReport_report";
            $where    = '';
            $filename = $file . "_" . $from_date . "_" . $to_date;


            $StatusList = $statusHeader;

            $data .= "Lead ID";
            $data .= ",Date";
            $data .= ",Vendor";
            $data .= ",Batch Code";
            $data .= ",Status";
            $data .= ",Sub Status";
            $data .= ",Disposition Reason";
            $data .= ",City";
            $data .= ",Note";
            $data .= ",Comments";
            $data .= ",State";
            $data .= ",Country";
            $data .= ",Landing Url";
            $data .= ",UTM Campaign";
            $data .= "\n";


            foreach ($programList as $key => $councelor)
            {
                $i = 0;
                foreach ($StatusList as $key1 => $value)
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

        $sugarSmarty->assign("programList", $programList);
        $sugarSmarty->assign("BatchListData", $BatchListData);
        $sugarSmarty->assign("VendorListData", $VendorListData);
        $sugarSmarty->assign("StatusList", $StatusList);

        $sugarSmarty->assign("selected_batch_code", $selected_batch_code);
        //$sugarSmarty->assign("selected_status", $selected_status);
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
        $sugarSmarty->display('custom/modules/AOR_Reports/tpls/vendorwisecalldisposition.tpl');
    }

}
?>


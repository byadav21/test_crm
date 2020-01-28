<?php

// Date: Created on : 27th FEB 2018
// Last modified on:  20th SEP 2018

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');
require_once('custom/modules/AOR_Reports/pagination.php');
require_once('custom/modules/AOR_Reports/UserInput.php');

//error_reporting(-1);
//ini_set('display_errors', 'On');

class AOR_ReportsViewdebtorreport extends SugarView
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
        $this->_objInputs->syncSessions('exportHeaderWiseReport');
    }

    function getBatch()
    {
        global $db;
        //batch_status='enrollment_in_progress' AND   {commented for getting old one alos}
        $batchSql     = "SELECT id,name,batch_code FROM te_ba_batch WHERE  deleted=0 order by batch_code   ";
        $batchObj     = $db->query($batchSql);
        $batchOptions = array();
        while ($row          = $db->fetchByAssoc($batchObj))
        {
            $batchOptions[] = $row;
        }
        return $batchOptions;
    }

    function getDueDate()
    {

        global $db;

        $batchSql     = "SELECT 
            bb.id batch_id, bb.batch_code, inst.due_date
        FROM te_ba_batch bb
            INNER JOIN  `te_ba_batch_te_installments_1_c` binst_rel ON bb.id = binst_rel.te_ba_batch_te_installments_1te_ba_batch_ida
            INNER JOIN te_installments inst ON binst_rel.te_ba_batch_te_installments_1te_installments_idb = inst.id
        WHERE bb.deleted =0
        AND binst_rel.deleted =0
        AND inst.deleted =0
        ORDER BY bb.id, inst.due_date";
        $batchObj     = $db->query($batchSql);
        $batchOptions = array();
        while ($row          = $db->fetchByAssoc($batchObj))
        {
            $batchOptions[$row['batch_id']][] = $row['due_date'];
        }
        return $batchOptions;
    }

    function getInstitute()
    {

        global $db;

        $batchSql     = "SELECT 
            bb.id batch_id, bb.batch_code, i.name
        FROM te_ba_batch bb
            INNER JOIN te_in_institutes_te_ba_batch_1_c AS ib ON bb.id=ib.te_in_institutes_te_ba_batch_1te_ba_batch_idb AND ib.deleted=0
            INNER JOIN te_in_institutes as i on ib.te_in_institutes_te_ba_batch_1te_in_institutes_ida=i.id AND i.deleted=0
        WHERE bb.deleted =0";
        $batchObj     = $db->query($batchSql);
        $batchOptions = array();
        while ($row          = $db->fetchByAssoc($batchObj))
        {
            $batchOptions[$row['batch_id']] = $row['name'];
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
        
        //~~~~~~~
            $report_action = '';
            $reportAccess  = reportAccessLog();

            $current_user_id = $current_user->id;
            $report_action   = isset($GLOBALS['action']) ? $GLOBALS['action'] : '';


                if (!in_array($current_user->id, $reportAccess[$report_action]) && ($current_user->is_admin != 1))
                {
                    echo 'You are not authorized to access!';
                    return;
                }
            //~~~~~~~

                
        $current_user_id       = $current_user->id;
        $current_user_is_admin = $current_user->is_admin;
        $_export               = isset($this->_objInputs->post['export']) && $this->_objInputs->post['export'] == "Export";
        $where                 = "";
        $wherecl               = "";
        $campaignID            = array();
        $leadID                = array();
        $BatchListData         = $this->getBatch();
        $getDueDateData        = $this->getDueDate();
        $getInstituteData      = $this->getInstitute();
        $error                 = array();

        $selected_from_date          = '';
        $selected_to_date            = '';
        $selected_batch              = '';
        $selected_batch_code         = '';
        $selected_vendor             = '';
        $selected_program            = '';
        $selected_mobile             = '';
        $selected_email              = '';
        $selected_status             = '';
        $selected_status_description = '';
        $selected_lead_source_types  = '';
        $selected_source             = '';
        $selected_autoassign         = '';
        $selected_ameyo_status       = '';
        $selected_campaignIDs        = '';
        $selected_leadIDs            = '';
        $left                        = '';
        $IDs                         = '';
     
        $findBatch                   = array();
        $leadList                    = array();
        $StatusList                  = array();




        $selected_from_date          = $this->_objInputs->getVal('from_date', 'post', date('Y-m-d', strtotime('-1 days')));
        $selected_to_date            = $this->_objInputs->getVal('to_date', 'post', date('Y-m-d', strtotime('-1 days')));
      
        $selected_batch_code         = $this->_objInputs->getVal('batch_code', 'post', array());
        $selected_vendor             = $this->_objInputs->getVal('vendors', 'post', array());
       





        if ($selected_from_date != "")
        {
            $from_date = date('Y-m-d', strtotime(str_replace('/', '-', $selected_from_date)));
            $wherecl   .= " AND DATE(pd.`date_of_payment`) >= '" . $from_date . "'";
        }

        if ($selected_to_date != "")
        {
            $to_date = date('Y-m-d', strtotime(str_replace('/', '-', $selected_to_date)));
            $wherecl .= " AND DATE(pd.`date_of_payment`) <= '" . $to_date . "' ";
        }

        

        if (!empty($selected_batch_code))
        {

            $wherecl .= " AND  sb.te_ba_batch_id_c IN ('" . implode("','", $selected_batch_code) . "')";
        }






        $headers = array(
            's.name  AS student_name'                                                => 'student_name',
            'sprel.`te_student_te_student_payment_1te_student_ida` AS student_id'    => 'student_id',
            'pd.id AS paymentID'                                                     => 'paymentID',
            'l.id AS lead_id'                                                        => 'lead_id',
            'l.vendor'                                                               => 'vendor',
            'l.utm_source_c'                                                         => 'utm_source_c',
            'l.converted_date'                                                       => 'converted_date',
            'te_ba_batch.fees_inr AS fee_inr'                                        => 'fee_inr',
            'pd.payment_source'                                                      => 'payment_source',
            'u.user_name'                                                            => 'user_name',
            'concat(counselor.first_name," ",counselor.last_name) AS counselor_name' => 'counselor_name',
            'te_ba_batch.name batch_name'                                            => 'batch_name',
            'l.assigned_user_id'                                                     => 'assigned_user_id',
            'te_ba_batch.id As batch_id'                                             => 'batch_id',
            'te_ba_batch.batch_code'                                                 => 'batch_code',
            'pd.`date_of_payment`'                                                   => 'date_of_payment',
            'l.phone_mobile'                                                         => 'phone_mobile',
            'leads_cstm.email_add_c student_email'                                   => 'student_email',
            'pd.`amount`'                                                            => 'amount',
            'pd.`reference_number`'                                                  => 'reference_number',
            'pd.`payment_type`'                                                      => 'payment_type',
            'pd.invoice_number'                                                      => 'invoice_number',
            'pd.invoice_order_number'                                                => 'invoice_order_number'
        );

        $headersss = implode(', ', array_keys($headers));

        $Days = $this->getBetweenDays($selected_from_date, $selected_to_date);

        $sqlPart = "
                FROM `te_student_payment` sp
                    LEFT JOIN `te_payment_details` pd ON pd.student_payment_id=sp.id
                    LEFT JOIN leads_te_payment_details_1_c AS lp ON lp.leads_te_payment_details_1te_payment_details_idb=pd.id
                    LEFT JOIN `te_student_batch` sb ON sb.id=sp.te_student_batch_id_c
                    LEFT JOIN `te_student_te_student_payment_1_c` sprel ON sprel.`te_student_te_student_payment_1te_student_payment_idb`=sp.id
                    LEFT JOIN  te_student s ON sprel.`te_student_te_student_payment_1te_student_ida`=s.id 
                    LEFT JOIN  users u ON sb.assigned_user_id=u.id
                    LEFT JOIN  leads l ON sb.leads_id=l.id
                    LEFT JOIN  users as counselor ON l.assigned_user_id=counselor.id
                    LEFT JOIN  leads_cstm ON l.id= leads_cstm.id_c
                    LEFT JOIN  te_ba_batch ON leads_cstm.te_ba_batch_id_c= te_ba_batch.id
                where l.deleted=0 
                and pd.deleted=0 
                and lp.deleted=0 
                $wherecl order by pd.`date_of_payment`,s.name  ";

        $countSql = "SELECT count(1) as count " . $sqlPart;


        $leadSql = "SELECT  $headersss " . $sqlPart;

        //die($leadSql);
        if (!$_export)
        {
            $limit   = $this->objPagination->get_limit();
            $leadSql .= ' ' . $limit;
        }
        $rowCount = 0;
        $leadObj  = null;

//      if ($Days >= 0 && $Days <= 93 && $wherecl != '') {
        if ($_export)
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


        while ($row = $db->fetchByAssoc($leadObj))
        {
            //$Amountpaid += $row['amount'];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['institute']        = $getInstituteData[$row['batch_id']];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['student_name']     = $row['student_name'];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['student_id']       = $row['student_id'];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['phone_mobile']     = $row['phone_mobile'];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['student_email']    = $row['student_email'];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['user_name']        = $row['user_name'];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['assigned_user_id'] = $row['assigned_user_id'];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['counselor_name']   = $row['counselor_name'];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['batch_id']         = $row['batch_id'];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['batch_name']       = $row['batch_name'];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['batch_code']       = $row['batch_code'];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['lead_id']          = $row['lead_id'];

            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['invoice_number'] = $row['invoice_number'];



            //$paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['program_name']   = $row['program_name'];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['Vendor']         = empty($row['vendor']) ? $row['utm_source_c'] : $row['vendor'];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['converted_date'] = $row['converted_date'];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['fee_inr']        = $row['fee_inr'];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['gst']            = (0.18 * $row['fee_inr']);
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['total_amount']   = ($row['fee_inr'] + (0.18 * $row['fee_inr']));
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['amt_tobe_pay']   += $row['amount'];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['payment_source'] = $row['payment_source'];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['due_date']       = '';



            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['installment'][] = array(
                ($row['invoice_order_number']) ? $row['invoice_order_number'] : 'N/A',
                ($row['amount']) ? $row['amount'] : 'N/A',
                //(in_array($row['payment_type'], $checkOffline)) ? 'Online' : $row['payment_type'],
                ($row['payment_source']) ? $row['payment_source'] : 'N/A',
                //($row['reference_number']) ? $row['reference_number'] : 'N/A',
                ($row['date_of_payment']) ? date('F', strtotime($row['date_of_payment'])) : 'N/A',
                ($row['date_of_payment']) ? $row['date_of_payment'] : 'N/A',
            );
        }
        //echo "<pre>";
        $i = 1;
        foreach ($paymentList as $key => $val)
        {
            $total_amount                      = $val['total_amount'];
            $amt_tobe_pay                      = $val['amt_tobe_pay'];
            $paymentList[$key]['srno']         = $i;
            //$paymentList[$key]['amt_tobe_pay'] = ($val['total_amount'] - $val['amt_tobe_pay']);
            $paymentList[$key]['amt_tobe_pay'] = ($total_amount != 0) ? ($total_amount - $amt_tobe_pay) : 0;

            foreach ($val['installment'] as $key2 => $val2)
            {
                $paymentList[$key]['installment'][$key2][6] = isset($getDueDateData[$val['batch_id']][$key2]) ? $getDueDateData[$val['batch_id']][$key2] : 'N/A';
            }
            $i++;
        }

        //echo "<pre>";print_r($paymentList);exit();


        if ($_export && empty($error))
        {

            $file     = "debtor_report";
            $where    = '';
            $filename = $file . "_" . $from_date . "_" . $to_date;

            //echo "<pre>";print_r($paymentList);exit();
            # Create heading
            $data = "Batch Code";


            $data .= ",Course Name";
            $data .= ",Lead Source Name";
            $data .= ",Institute Name";
            $data .= ",Registration Date";


            $data .= ",Student Name";

            $data .= ",Lead ID";
            $data .= ",Counselor Name";
            $data .= ",Invoice Number";


            $data .= ",Course Fee";
            $data .= ",GST";
            $data .= ",Total Amount";
            $data .= ",Outstanding Balance";


            $data .= ",Order Number";
            $data .= ",Instalment 1/Payment 1";
            $data .= ",Payment Source";
            $data .= ",Month";
            $data .= ",Date of Payment";
            $data .= ",Due Date";

            $data .= ",Order Number";
            $data .= ",Instalment 2/Payment 2";
            $data .= ",Payment Source";
            $data .= ",Month";
            $data .= ",Date of Payment";
            $data .= ",Due Date";

            $data .= ",Order Number";
            $data .= ",Instalment 3/Payment 3";
            $data .= ",Payment Source";
            $data .= ",Month";
            $data .= ",Date of Payment";
            $data .= ",Due Date";

            $data .= ",Order Number";
            $data .= ",Instalment 4/Payment 4";
            $data .= ",Payment Source";
            $data .= ",Month";
            $data .= ",Date of Payment";
            $data .= ",Due Date";

            $data .= ",Order Number";
            $data .= ",Instalment 5/Payment 5";
            $data .= ",Payment Source";
            $data .= ",Month";
            $data .= ",Date of Payment";
            $data .= ",Due Date";



            $data .= "\n";




            foreach ($paymentList as $key => $datax)
            {
                $data .= "\"" . $datax['batch_code'];


                $data .= "\",\"" . $datax['batch_name'];
                $data .= "\",\"" . $datax['Vendor'];
                $data .= "\",\"" . $datax['institute'];
                $data .= "\",\"" . $datax['converted_date'];

                $data .= "\",\"" . $datax['student_name'];

                $data .= "\",\"" . $datax['lead_id'];
                $data .= "\",\"" . $datax['counselor_name'];
                $data .= "\",\"" . $datax['invoice_number'];


                $data .= "\",\"" . $datax['fee_inr'];
                $data .= "\",\"" . $datax['gst'];
                $data .= "\",\"" . $datax['total_amount'];
                $data .= "\",\"" . $datax['amt_tobe_pay'];



                foreach ($datax['installment'] as $key => $value)
                {
                    foreach ($value as $key => $valY)
                    {
                        $data .= "\",\"" . $valY;
                        
                    }
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
        $sugarSmarty->assign("leadList", $leadList);
        $sugarSmarty->assign("headers", $headers);
        $sugarSmarty->assign("tablewidth", count($headers) * 130);


        $sugarSmarty->assign("selected_batch_code", $selected_batch_code);
        $sugarSmarty->assign("selected_status", $selected_status);
        $sugarSmarty->assign("paymentList", $paymentList);

        $sugarSmarty->assign("BatchListData", $BatchListData);

        $sugarSmarty->assign("selected_batch", $selected_batch);
        $sugarSmarty->assign("selected_from_date", $selected_from_date);
        $sugarSmarty->assign("selected_to_date", $selected_to_date);




        $sugarSmarty->assign("current_records", $current);
        $sugarSmarty->assign("page", $page);
        $sugarSmarty->assign("pagenext", $pagenext);
        $sugarSmarty->assign("pageprevious", $pageprevious);
        $sugarSmarty->assign("right", $right);
        $sugarSmarty->assign("left", $left);
        $sugarSmarty->assign("last_page", $last_page);
        $sugarSmarty->display('custom/modules/AOR_Reports/tpls/debtorreport.tpl');
    }

}
?>


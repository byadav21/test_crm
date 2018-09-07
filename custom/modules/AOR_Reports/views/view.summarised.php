<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');

class AOR_ReportsViewsummarised extends SugarView
{

    var $report_to_id;
    var $counsellors_arr;

    public function __construct()
    {
        parent::SugarView();
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
    
    function getPaymentSource()
    {
        global $db;
        //batch_status='enrollment_in_progress' AND   {commented for getting old one alos}
        $batchSql     = "SELECT payment_source FROM te_payment_details WHERE  deleted=0 group by payment_source order by payment_source   ";
        $batchObj     = $db->query($batchSql);
        $batchOptions = array();
        while ($row          = $db->fetchByAssoc($batchObj))
        {
            $batchOptions[] = $row;
        }
        return $batchOptions;
    }
    
    function getVendor()
    {
        global $db;
        //batch_status='enrollment_in_progress' AND   {commented for getting old one alos}
        $batchSql     = "SELECT name FROM te_vendor WHERE  deleted=0 order by name   ";
        $batchObj     = $db->query($batchSql);
        $batchOptions = array();
        while ($row          = $db->fetchByAssoc($batchObj))
        {
            $batchOptions[] = $row;
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

    public function display()
    {
        global $sugar_config, $app_list_strings, $current_user, $db;
        $current_user_id       = $current_user->id;
        $current_user_is_admin = $current_user->is_admin;
        $where                 = "";
        $wherecl               = "";
        $BatchListData         = $this->getBatch();
        
        $getPaymentSourceData  = $this->getPaymentSource();
        $getVendorData         = $this->getVendor();
        $getInstituteData      = $this->getInstitute();
        
        $usersdd = "";

        //echo "<pre>";print_r($getDueDateData);exit();



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

            $_SESSION['cccon_from_date']  = $_REQUEST['from_date'];
            $_SESSION['cccon_to_date']    = $_REQUEST['to_date'];
            $_SESSION['cccon_batch_code'] = $_REQUEST['batch_code'];
            
            $_SESSION['cccon_payment_source']   = $_REQUEST['payment_source'];
            $_SESSION['cccon_vendor_data']      = $_REQUEST['vendor_data'];
            $_SESSION['cccon_month']            = $_REQUEST['month'];
         
        }

        if ($_SESSION['cccon_from_date'] != "" && $_SESSION['cccon_to_date'] != "")
        {
            $selected_from_date = $_SESSION['cccon_from_date'];
            $selected_to_date   = $_SESSION['cccon_to_date'];
            $from_date          = date('Y-m-d', strtotime(str_replace('/', '-', $_SESSION['cccon_from_date'])));
            $to_date            = date('Y-m-d', strtotime(str_replace('/', '-', $_SESSION['cccon_to_date'])));
            $wherecl            .= " AND DATE(pd.`date_of_payment`)>='" . $from_date . "' AND DATE(pd.`date_of_payment`)<='" . $to_date . "'";
        }
        elseif ($_SESSION['cccon_from_date'] != "" && $_SESSION['cccon_to_date'] == "")
        {
            $selected_from_date = $_SESSION['cccon_from_date'];
            $from_date          = date('Y-m-d', strtotime(str_replace('/', '-', $_SESSION['cccon_from_date'])));
            $wherecl            .= " AND DATE(pd.`date_of_payment`)>='" . $from_date . "' ";
        }
        elseif ($_SESSION['cccon_from_date'] == "" && $_SESSION['cccon_to_date'] != "")
        {
            $selected_to_date = $_SESSION['cccon_to_date'];
            $to_date          = date('Y-m-d', strtotime(str_replace('/', '-', $_SESSION['cccon_to_date'])));
            $wherecl          .= " AND DATE(pd.`date_of_payment`)<='" . $to_date . "' ";
        }

        $findBatch = array();

        if (!empty($_SESSION['cccon_batch_code']))
        {
            $selected_batch_code = $_SESSION['cccon_batch_code'];
        }
        
        
        if (!empty($_SESSION['cccon_payment_source']))
        {
            $selected_payment_source = $_SESSION['cccon_payment_source'];
        }
        
        if (!empty($_SESSION['cccon_vendor_data']))
        {
            $selected_vendor_data = $_SESSION['cccon_vendor_data'];
        }
        if (!empty($_SESSION['cccon_month']))
        {
            $selected_month = $_SESSION['cccon_month'];
        }


        $paymentList = array();
        $StatusList  = array();

        
        
        if (!empty($selected_batch_code))
        {

            $wherecl .= " AND  sb.te_ba_batch_id_c IN ('" . implode("','", $selected_batch_code) . "')";
        }


        if (!empty($selected_payment_source))
        {

            $wherecl .= " AND  pd.payment_source IN ('" . implode("','", $selected_payment_source) . "')";
        }

        if (!empty($selected_vendor_data))
        {

            $wherecl .= " AND  l.vendor IN ('" . implode("','",$selected_vendor_data) . "')";
        }

        if (!empty($selected_month))
        {

            $wherecl .= " AND  MONTH(l.converted_date) IN ('" . implode("','", $selected_month) . "')";
        }


        $months  = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
        
        //echo
        $leadSql = "SELECT 
                            s.name student_name,
                            sprel.`te_student_te_student_payment_1te_student_ida` AS student_id,
                            pd.id paymentID,
                            l.id lead_id,
                            l.vendor,
                            l.converted_date,
                            te_ba_batch.fees_inr fee_inr,
                            pd.payment_source,
                            u.user_name,
                            concat(counselor.first_name,' ',counselor.last_name) as counselor_name,
                            te_ba_batch.name batch_name,
                            l.assigned_user_id,
                            te_ba_batch.id AS batch_id ,
                            te_ba_batch.batch_code,
                            pd.`date_of_payment`, 
                            l.phone_mobile,
                            l.primary_address_state,
                            pd.`state`, 
                            leads_cstm.email_add_c student_email,
                            pd.`amount`, 
                            pd.`reference_number`, 
                            pd.`payment_type`,
                            pd.invoice_number,
                            pd.invoice_order_number
        FROM `te_student_payment` sp
        LEFT JOIN `te_payment_details` pd ON pd.student_payment_id=sp.id
        LEFT JOIN `te_student_batch` sb ON sb.id=sp.te_student_batch_id_c
        LEFT JOIN `te_student_te_student_payment_1_c` sprel ON sprel.`te_student_te_student_payment_1te_student_payment_idb`=sp.id
        LEFT JOIN  te_student s ON sprel.`te_student_te_student_payment_1te_student_ida`=s.id 
        LEFT JOIN  users u ON sb.assigned_user_id=u.id
        LEFT JOIN  leads l ON sb.leads_id=l.id
        LEFT JOIN  users as counselor ON l.assigned_user_id=counselor.id
        LEFT JOIN  leads_cstm ON l.id= leads_cstm.id_c
        LEFT JOIN  te_ba_batch ON leads_cstm.te_ba_batch_id_c= te_ba_batch.id
    where l.deleted=0  $wherecl order by pd.`date_of_payment`,s.name";






        $checkOffline = array("Atom Gateway Payments", "paytm", "PayU");
        $Amountpaid   = 0;
        //$_SESSION['cccon_batch_code']=array();
        if (!empty($_SESSION['cccon_batch_code']))
        {

            $leadObj = $db->query($leadSql);

            while ($row = $db->fetchByAssoc($leadObj))
            {
                //$Amountpaid += $row['amount'];
                $lead_state = empty($row['primary_address_state'])? '': $row['primary_address_state'];
                $pay_state  = empty($row['state'])? '': $row['state'];
                
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
                
                $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['invoice_number']   = $row['invoice_number'];
                $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['student_state']    = empty($lead_state) ? $pay_state : $lead_state;

                $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['program_name']   = $row['program_name'];
                $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['Vendor']         = empty($row['vendor']) ? $row['utm_source_c'] : $row['vendor'];
                $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['converted_date'] = $row['converted_date'];
                
                 $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['registration_month'] = date('F', strtotime($row['converted_date']));
                 
                $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['fee_inr']        = $row['fee_inr'];
                $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['gst']            = (0.18 * $row['fee_inr']);
                $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['total_amount']   = ($row['fee_inr'] + (0.18 * $row['fee_inr']));
                $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['amt_tobe_pay']   += $row['amount'];
                $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['payment_source'] = $row['payment_source'];
                $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['due_date']       = '';
            }
            //echo "<pre>";
            $i = 1;
            foreach ($paymentList as $key => $val)
            {
                $paymentList[$key]['srno'] = $i;
                $i++;
            }
        }



        //echo "<pre>";print_r($paymentList);exit();



        if (isset($_POST['export']) && $_POST['export'] == "Export")
        {

            $file        = "summarised_report";
            $where       = '';
            $filename    = $file . "_" . $from_date . "_" . $to_date;
            $paymentList = array();

            $leadObj = $db->query($leadSql);

            if (!empty($_SESSION['cccon_batch_code']))
            {
                while ($row = $db->fetchByAssoc($leadObj))
                {
                    //$Amountpaid += $row['amount'];
                    $lead_state = empty($row['primary_address_state'])? '': $row['primary_address_state'];
                    $pay_state  = empty($row['state'])? '': $row['state'];
                
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
                    
                    $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['invoice_number']   = $row['invoice_number'];
                    $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['student_state']    = empty($lead_state) ? $pay_state : $lead_state;
                    
                    $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['program_name']   = $row['program_name'];
                    $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['Vendor']         = empty($row['vendor']) ? $row['utm_source_c'] : $row['vendor'];
                    $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['converted_date'] = $row['converted_date'];
                    $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['registration_month'] = date('F', strtotime($row['converted_date']));
                    $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['fee_inr']        = $row['fee_inr'];
                    $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['gst']            = (0.18 * $row['fee_inr']);
                    $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['total_amount']   = ($row['fee_inr'] + (0.18 * $row['fee_inr']));
                    $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['amt_tobe_pay']   += $row['amount'];
                    $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['payment_source'] = $row['payment_source'];
                    $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['due_date']       = '';
                }
            }






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
            
          
            $data .= ",Month of Registration";
            $data .= ",State of Student";

            $data .= ",Course Fee";
            $data .= ",GST";
            $data .= ",Total Amount";
            $data .= ",Payment Source";





//            foreach ($statusArr as $statusVal)
//            {
//                $data .= "," . ucfirst($statusVal);
//            }

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
                
                $data .= "\",\"" . $datax['registration_month'];
                $data .= "\",\"" . $datax['student_state'];
                

                $data .= "\",\"" . $datax['fee_inr'];
                $data .= "\",\"" . $datax['gst'];
                $data .= "\",\"" . $datax['total_amount'];
                $data .= "\",\"" . $datax['payment_source'];



                foreach ($datax['installment'] as $key => $value)
                {
                    foreach ($value as $key => $valY)
                    {
                        $data .= "\",\"" . $valY;
                        //$data .= $val . ",";
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
        //echo '<pre>';
        //print_r($paymentList); die;
        $total     = count($paymentList); #total records
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

        $paymentList = array_slice($paymentList, $start, $per_page);
        if ($total > $per_page)
        {
            $current = "(" . ($start + 1) . "-" . ($start + $per_page) . " of " . $total . ")";
        }
        else
        {
            $current = "(" . ($start + 1) . "-" . count($paymentList) . " of " . $total . ")";
        }
        #pE

        $sugarSmarty = new Sugar_Smarty();
        $sugarSmarty->assign("month", $months);
        
        $sugarSmarty->assign("PaymentSourceData", $getPaymentSourceData);
        $sugarSmarty->assign("VendorData", $getVendorData);
        
        $sugarSmarty->assign("selected_payment_source", $selected_payment_source);
        $sugarSmarty->assign("selected_vendor_data", $selected_vendor_data);
        $sugarSmarty->assign("selected_month", $selected_month);
        
        $sugarSmarty->assign("selected_batch_code", $selected_batch_code);
        $sugarSmarty->assign("selected_status", $selected_status);
        $sugarSmarty->assign("paymentList", $paymentList);
        $sugarSmarty->assign("PaymentsArray", $PaymentsArray);
        $sugarSmarty->assign("BatchListData", $BatchListData);
        $sugarSmarty->assign("CounselorList", $usersdd);
        $sugarSmarty->assign("selected_batch", $selected_batch);
        $sugarSmarty->assign("selected_from_date", $selected_from_date);
        $sugarSmarty->assign("selected_to_date", $selected_to_date);
 

        $sugarSmarty->assign("current_records", $current);
        $sugarSmarty->assign("page", $page);
        $sugarSmarty->assign("pagenext", $pagenext);
        $sugarSmarty->assign("right", $right);
        $sugarSmarty->assign("left", $left);
        $sugarSmarty->assign("last_page", $last_page);
        $sugarSmarty->display('custom/modules/AOR_Reports/tpls/summarised.tpl');
    }

}

?>

<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');

class AOR_ReportsViewsrmpaymentreceivedreport extends SugarView
{

    var $report_to_id;
    var $counsellors_arr;

    public function __construct()
    {
        parent::SugarView();
    }

    function reportingUser($currentUserId)
    {
        $userObj                             = new User();
        $userObj->disable_row_level_security = true;
        $userList                            = $userObj->get_full_list("", "users.reports_to_id='" . $currentUserId . "'");
        if (!empty($userList))
        {
            foreach ($userList as $record)
            {
                if (!empty($record->reports_to_id) && !empty($record->id))
                {
                    $this->report_to_id[] = $record->id;
                    $this->reportingUser($record->id);
                }
            }
        }
    }

    function getCouncelor($user_id)
    {
        global $db;
        $userSql = "SELECT CONCAT(first_name,' ',last_name) as name FROM users WHERE deleted=0 AND id='" . $user_id . "'";
        $userObj = $db->query($userSql);
        $user    = $db->fetchByAssoc($userObj);
        return $user['name'];
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

    function getCouncelorForAdmin($user_id = NULL)
    {
        global $db;
        $userSql  = "select u.first_name,u.last_name,u.id,ru.first_name AS reporting_firstname,ru.last_name AS reporting_lastname,ru.id AS reporting_id FROM users AS u INNER JOIN acl_roles_users AS aru ON aru.user_id=u.id LEFT JOIN users AS ru ON ru.id=u.reports_to_id WHERE aru.`role_id` IN ('7e225ca3-69fa-a75d-f3f2-581d88cafd9a',  '270ce9dd-7f7d-a7bf-f758-582aeb4f2a45',  'cc7133be-0db9-d50a-2684-582c0078e74e') AND u.deleted=0 AND aru.deleted=0";
        $userObj  = $db->query($userSql);
        $usersArr = [];
        while ($user     = $db->fetchByAssoc($userObj))
        {
            $usersArr[$user['id']] = array(
                'id'             => $user['id'],
                'name'           => $user['first_name'] . ' ' . $user['last_name'],
                'reporting_id'   => $user['reporting_id'],
                'reporting_name' => $user['reporting_firstname'] . ' ' . $user['reporting_lastname']
            );
        }
        return $usersArr;
    }

    function getCouncelorForUsers($user_ids = array())
    {
        global $db;
        $userSql  = "select u.first_name,u.last_name,u.id,ru.first_name AS reporting_firstname,ru.last_name AS reporting_lastname,ru.id AS reporting_id FROM users AS u LEFT JOIN users AS ru ON ru.id=u.reports_to_id WHERE u.id IN ('" . implode("','", $user_ids) . "') AND u.deleted=0";
        $userObj  = $db->query($userSql);
        $usersArr = [];
        while ($user     = $db->fetchByAssoc($userObj))
        {
            $usersArr[$user['id']] = array(
                'id'             => $user['id'],
                'name'           => $user['first_name'] . ' ' . $user['last_name'],
                'reporting_id'   => $user['reporting_id'],
                'reporting_name' => $user['reporting_firstname'] . ' ' . $user['reporting_lastname']
            );
        }
        return $usersArr;
    }

    public function display()
    {
        global $sugar_config, $app_list_strings, $current_user, $db;
        $current_user_id       = $current_user->id;
        $current_user_is_admin = $current_user->is_admin;
        $where                 = "";
        $wherecl               = "";
        $BatchListData         = $this->getBatch();
        $usersdd               = "";
        if ($current_user_is_admin == 1)
        {
            $usersdd = $this->getCouncelorForAdmin();
        }
        else
        {
            $this->report_to_id[] = $current_user_id;
            $reportingusersids    = $this->reportingUser($current_user_id);

            $uid = $this->report_to_id;

            $usersdd = $this->getCouncelorForUsers($uid);
        }
        #echo "<pre>";print_r($usersdd);exit();
        if (!isset($_SESSION['cccon_from_date']))
        {
            $_SESSION['cccon_from_date'] = date('Y-m-d', strtotime('-1 days'));
        }
        if (!isset($_SESSION['cccon_to_date']))
        {
            $_SESSION['cccon_to_date'] = date('Y-m-d', strtotime('-1 days'));
        }
        if (!isset($_SESSION['cccon_counselor']))
        {
            $_SESSION['cccon_counselor'] = array_keys($usersdd);
        }
        if (isset($_POST['button']) || isset($_POST['export']))
        {
            $_SESSION['cccon_from_date']  = $_REQUEST['from_date'];
            $_SESSION['cccon_to_date']    = $_REQUEST['to_date'];
            $_SESSION['cccon_batch']      = $_REQUEST['batch'];
            $_SESSION['cccon_batch_code'] = $_REQUEST['batch_code'];
            $_SESSION['cccon_counselor']  = $_REQUEST['counselor'];
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
        if (!empty($_SESSION['cccon_batch']))
        {
            $selected_batch = $_SESSION['cccon_batch'];
        }
        if (!empty($_SESSION['cccon_batch_code']))
        {
            $selected_batch_code = $_SESSION['cccon_batch_code'];
        }
        if (!empty($_SESSION['cccon_counselor']))
        {
            $selected_counselor = $_SESSION['cccon_counselor'];
        }


        $paymentList = array();
        $StatusList  = array();

        if (!empty($selected_batch))
        {

            $wherecl .= " AND  sb.te_ba_batch_id_c IN ('" . implode("','", $selected_batch) . "')";
        }
        if (!empty($selected_batch_code))
        {

            $wherecl .= " AND  sb.te_ba_batch_id_c IN ('" . implode("','", $selected_batch_code) . "')";
        }
//        if (!empty($selected_counselor))
//        {
//
//            $wherecl .= " AND  sb.assigned_user_id IN ('" . implode("','", $selected_counselor) . "')";
//        }
        //$statusArr = ['alive', 'dead', 'converted', 'warm', 'recycle', 'dropout'];
        //echo '<pre>'.
        $leadSql = "SELECT 
                                        s.name student_name,
                                        sprel.`te_student_te_student_payment_1te_student_ida` AS student_id,
                                        pd.id paymentID,
                                        
                                        p. name program_name,
                                        l.id lead_id,
                                        l.vendor,
                                        l.converted_date,
                                        sb.fee_inr,
                                        pd.payment_source,
                                        inst.due_date,
                                        
                                        u.user_name,
                                        sb.name batch_name,
                                        sb.assigned_user_id,
                                        sp.te_student_batch_id_c AS batch_id ,
                                        sb.batch_code,
                                        pd.`date_of_payment`, 
                                        l.phone_mobile,
                                        leads_cstm.email_add_c student_email,
                                        pd.`amount`, 
                                        pd.`reference_number`, 
                                        pd.`payment_type`

                            FROM `te_student_payment` sp
                    LEFT JOIN `te_payment_details` pd ON pd.student_payment_id=sp.id
                    LEFT JOIN `te_student_batch` sb ON sb.id=sp.te_student_batch_id_c
                    LEFT JOIN `te_ba_batch_te_installments_1_c` binst_rel ON sb.id=binst_rel.te_ba_batch_te_installments_1te_ba_batch_ida 
                    LEFT JOIN  te_installments inst on binst_rel.te_ba_batch_te_installments_1te_installments_idb = inst.id
                    LEFT JOIN `te_pr_programs` `p` ON`sb`.`te_pr_programs_id_c` = `p`.`id`
                    LEFT JOIN `te_student_te_student_payment_1_c` sprel ON sprel.`te_student_te_student_payment_1te_student_payment_idb`=sp.id
                    LEFT JOIN te_student s ON sprel.`te_student_te_student_payment_1te_student_ida`=s.id 
                    LEFT JOIN users u ON sb.assigned_user_id=u.id
                    LEFT JOIN leads l ON sb.leads_id=l.id
                    LEFT JOIN leads_cstm ON l.id= leads_cstm.id_c
                    where l.deleted=0  $wherecl  "
                #. "  and sprel.`te_student_te_student_payment_1te_student_ida` in ('47f844b9-5cf2-38bf-8609-5b603189a22d','bf0e02c2-c8a6-b4bc-2d40-5b57287a820f') "
                . "order by pd.`date_of_payment`,s.name ";





        $leadObj      = $db->query($leadSql);
        $checkOffline = array("Atom Gateway Payments", "paytm", "PayU");
        $Amountpaid = 0;
        while ($row          = $db->fetchByAssoc($leadObj))
        {
            //$Amountpaid += $row['amount'];

            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['student_name']     = $row['student_name'];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['student_id']       = $row['student_id'];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['phone_mobile']     = $row['phone_mobile'];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['student_email']    = $row['student_email'];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['user_name']        = $row['user_name'];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['assigned_user_id'] = $row['assigned_user_id'];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['batch_id']         = $row['batch_id'];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['batch_name']       = $row['batch_name'];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['batch_code']       = $row['batch_code'];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['lead_id']          = $row['lead_id'];


            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['program_name']   = $row['program_name'];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['Vendor']         = empty($row['vendor']) ? $row['utm_source_c'] : $row['vendor'];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['converted_date'] = $row['converted_date'];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['fee_inr']        = $row['fee_inr'];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['gst']            = (0.18 * $row['fee_inr']);
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['total_amount']   = ($row['fee_inr'] + (0.18 * $row['fee_inr']));
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['amt_tobe_pay']   += $row['amount'];
            //$paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['payment_source']     = $row['payment_source'];
            //$paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['due_date']           = $row['due_date'];



            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['installment'][] = array(
                ($row['amount']) ? $row['amount'] : 'N/A',
                (in_array($row['payment_type'], $checkOffline)) ? 'Online' : $row['payment_type'],
                ($row['payment_source']) ? $row['payment_source'] : 'N/A',
                ($row['reference_number']) ? $row['reference_number'] : 'N/A',
                ($row['date_of_payment']) ? $row['date_of_payment'] : 'N/A',
                ($row['due_date']) ? $row['due_date'] : 'N/A'
            );
        }

        //echo "<pre>";print_r($paymentList);exit();

        

        if (isset($_POST['export']) && $_POST['export'] == "Export")
        {

            $file        = "SrmPaymentReceived_report";
            $where       = '';
            $filename    = $file . "_" . $from_date . "_" . $to_date;
            $paymentList = array();

            $leadObj = $db->query($leadSql);

        while ($row          = $db->fetchByAssoc($leadObj))
        {
            //$Amountpaid += $row['amount'];

            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['student_name']     = $row['student_name'];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['student_id']       = $row['student_id'];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['phone_mobile']     = $row['phone_mobile'];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['student_email']    = $row['student_email'];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['user_name']        = $row['user_name'];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['assigned_user_id'] = $row['assigned_user_id'];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['batch_id']         = $row['batch_id'];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['batch_name']       = $row['batch_name'];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['batch_code']       = $row['batch_code'];


            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['program_name']     = $row['program_name'];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['Vendor']           = empty($row['vendor']) ? $row['utm_source_c'] : $row['vendor'];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['converted_date']   = $row['converted_date'];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['fee_inr']          = $row['fee_inr'];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['gst']              = (0.18 * $row['fee_inr']);
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['total_amount']     = ($row['fee_inr'] + (0.18 * $row['fee_inr']));
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['amt_tobe_pay']     += $row['amount'];
            //$paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['payment_source']     = $row['payment_source'];
            //$paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['due_date']           = $row['due_date'];



            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['installment'][] = array(
                    ($row['amount']) ? $row['amount'] : 'N/A',
                    (in_array($row['payment_type'], $checkOffline)) ? 'Online' : $row['payment_type'],
                    ($row['payment_source']) ? $row['payment_source'] : 'N/A',
                    ($row['reference_number']) ? $row['reference_number'] : 'N/A',
                    ($row['date_of_payment']) ? $row['date_of_payment'] : 'N/A',
                    ($row['due_date']) ? $row['due_date'] : 'N/A'
                );
            }
            
            foreach ($paymentList as $key=>$val){
                $paymentList[$key]['amt_tobe_pay'] = ($val['total_amount'] - $val['amt_tobe_pay']);
            }
                
            
            
            //echo "<pre>";print_r($paymentList);exit();
            # Create heading
            $data = "Batch Code";
            $data .= ",Batch Name";
            
            $data .= ",Program Name";
            $data .= ",Lead Source Name";
            $data .= ",Conversion Date";
           
            
            $data .= ",Student Name";
            $data .= ",Email ID";
            $data .= ",Phone Number";
            
            $data .= ",Course Fee";
            $data .= ",GST";
            $data .= ",Total Amount";
            $data .= ",Amount Left to be Paid";

           

            $data .= ",Instalment 1/Payment 1";
            $data .= ",Mode";
            $data .= ",Payment Source";
            $data .= ",Receipt number";
            $data .= ",Date of receipt";
            $data .= ",Due Date";

            $data .= ",Instalment 2/Payment 2";
            $data .= ",Mode";
            $data .= ",Payment Source";
            $data .= ",Receipt number";
            $data .= ",Date of receipt";
            $data .= ",Due Date";
            
            $data .= ",Instalment 3/Payment 3";
            $data .= ",Mode";
            $data .= ",Payment Source";
            $data .= ",Receipt number";
            $data .= ",Date of receipt";
            $data .= ",Due Date";
            
            $data .= ",Instalment 4/Payment 4";
            $data .= ",Mode";
            $data .= ",Payment Source";
            $data .= ",Receipt number";
            $data .= ",Date of receipt";
            $data .= ",Due Date";
            
            $data .= ",Instalment 5/Payment 5";
            $data .= ",Mode";
            $data .= ",Payment Source";
            $data .= ",Receipt number";
            $data .= ",Date of receipt";
            $data .= ",Due Date";


//            foreach ($statusArr as $statusVal)
//            {
//                $data .= "," . ucfirst($statusVal);
//            }

            $data .= "\n";




            foreach ($paymentList as $key => $datax)
            {
                $data .= "\"" . $datax['batch_code'];
                $data .= "\",\"" . $datax['batch_name'];
                
                $data .= "\",\"" . $datax['program_name'];
                $data .= "\",\"" . $datax['Vendor'];
                $data .= "\",\"" . $datax['converted_date'];
                   
                $data .= "\",\"" . $datax['student_name'];
                $data .= "\",\"" . $datax['student_email'];
                $data .= "\",\"" . $datax['phone_mobile'];
                
                $data .= "\",\"" . $datax['fee_inr'];
                $data .= "\",\"" . $datax['gst'];
                $data .= "\",\"" . $datax['total_amount'];
                $data .= "\",\"" . $datax['amt_tobe_pay'];
                
    

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

        $sugarSmarty->assign("paymentList", $paymentList);
        $sugarSmarty->assign("PaymentsArray", $PaymentsArray);
        $sugarSmarty->assign("BatchListData", $BatchListData);
        $sugarSmarty->assign("CounselorList", $usersdd);
        $sugarSmarty->assign("selected_batch", $selected_batch);
        $sugarSmarty->assign("selected_from_date", $selected_from_date);
        $sugarSmarty->assign("selected_to_date", $selected_to_date);
        $sugarSmarty->assign("selected_counselor", $selected_counselor);

        $sugarSmarty->assign("current_records", $current);
        $sugarSmarty->assign("page", $page);
        $sugarSmarty->assign("pagenext", $pagenext);
        $sugarSmarty->assign("right", $right);
        $sugarSmarty->assign("left", $left);
        $sugarSmarty->assign("last_page", $last_page);
        $sugarSmarty->display('custom/modules/AOR_Reports/tpls/srmpaymentreceivedreport.tpl');
    }

}

?>

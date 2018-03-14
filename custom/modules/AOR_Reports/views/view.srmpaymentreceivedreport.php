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
        $batchSql     = "SELECT id,name,batch_code FROM te_ba_batch WHERE batch_status='enrollment_in_progress' AND deleted=0";
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
        if (!empty($selected_counselor))
        {

            //$wherecl .= " AND  sb.assigned_user_id IN ('" . implode("','", $selected_counselor) . "')";
        }

        $statusArr = ['alive', 'dead', 'converted', 'warm', 'recycle', 'dropout'];


        echo $leadSql = "SELECT 
                                        s.name student_name,
                                        sprel.`te_student_te_student_payment_1te_student_ida` AS student_id,
                                        pd.id paymentID,

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
                    INNER JOIN `te_payment_details` pd ON pd.student_payment_id=sp.id
                    INNER JOIN `te_student_batch` sb ON sb.id=sp.te_student_batch_id_c 
                    INNER JOIN `te_student_te_student_payment_1_c` sprel ON sprel.`te_student_te_student_payment_1te_student_payment_idb`=sp.id
                    INNER JOIN te_student s ON sprel.`te_student_te_student_payment_1te_student_ida`=s.id
                    INNER JOIN users u ON sb.assigned_user_id=u.id
                    INNER JOIN leads l ON sb.leads_id=l.id
                    INNER JOIN leads_cstm ON l.id= leads_cstm.id_c
                    where 1=1 $wherecl  order by s.name";



        $PaymentsArray=array();

        $leadObj = $db->query($leadSql);
        while ($row     = $db->fetchByAssoc($leadObj))
        {


            //$paymentList[] = $row;

            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['student_name']     = $row['student_name'];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['student_id']       = $row['student_id'];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['phone_mobile']     = $row['phone_mobile'];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['student_email']    = $row['student_email'];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['user_name']        = $row['user_name'];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['assigned_user_id'] = $row['assigned_user_id'];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['batch_id']         = $row['batch_id'];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['batch_name']       = $row['batch_name'];
            $paymentList[$row['student_id'] . '_BATCH_' . $row['batch_id']]['batch_code']       = $row['batch_code'];

            
            
            $PaymentsArray[$row['paymentID']]['payment_type']       = $row['payment_type'];
            $PaymentsArray[$row['paymentID']]['payment_type']       = $row['payment_type'];
            $PaymentsArray[$row['paymentID']]['reference_number']   = $row['reference_number'];
            $PaymentsArray[$row['paymentID']]['date_of_payment']    = $row['date_of_payment'];
            $PaymentsArray[$row['paymentID']]['amount']             = $row['amount'];
            
//            $PaymentsArray[$row['student_id'] . '_BATCH_' . $row['batch_id']]['reference_number'][] = $row['reference_number'];
//            $PaymentsArray[$row['student_id'] . '_BATCH_' . $row['batch_id']]['date_of_payment'][]  = $row['date_of_payment'];
//            $PaymentsArray[$row['student_id'] . '_BATCH_' . $row['batch_id']]['amount'][]           = $row['amount'];
            
            
            
            
            
            
        }
//        $MyArr = array();
//        foreach($PaymentsArray as $key=>$val){
//            $MyArr=$val;
//        }
       echo '<pre>';
       print_r($PaymentsArray);

       


        if (isset($_POST['export']) && $_POST['export'] == "Export")
        {

            $file     = "CounselorWiseStatus_report";
            $where    = '';
            $filename = $file . "_" . $from_date . "_" . $to_date;


            //echo $leadSql;exit();


            $leadObj = $db->query($leadSql);


            $vendor = 'NULL';

            while ($row = $db->fetchByAssoc($leadObj))
            {

                $paymentList[$row['assigned_user_id'] . '_BATCH_' . $row['batch_id']]['batch_id']                 = $row['batch_id'];
                $paymentList[$row['assigned_user_id'] . '_BATCH_' . $row['batch_id']]['batch_name']               = $row['batch_name'];
                $paymentList[$row['assigned_user_id'] . '_BATCH_' . $row['batch_id']]['batch_code']               = $row['batch_code'];
                $paymentList[$row['assigned_user_id'] . '_BATCH_' . $row['batch_id']]['assigned_user']            = !empty($row['assigned_user_id']) ? $usersdd[$row['assigned_user_id']]['name'] : 'NA';
                $paymentList[$row['assigned_user_id'] . '_BATCH_' . $row['batch_id']]['reporting_user']           = !empty($row['assigned_user_id']) ? $usersdd[$row['assigned_user_id']]['reporting_name'] : 'NA';
                $paymentList[$row['assigned_user_id'] . '_BATCH_' . $row['batch_id']][strtolower($row['status'])] = $row['lead_count'];
            }
            foreach ($paymentList as $key => $val)
            {
                $total = 0;
                foreach ($statusArr as $value)
                {
                    $countedLead = (!empty($paymentList[$key][$value]) ? $paymentList[$key][$value] : 0);
                    $total       += $countedLead;
                }
                $paymentList[$key]['total'] = $total;
            }

            # Create heading
            $data = "Counsellor Name";
            $data .= "Reporting Manager";
            $data .= "Batch Name";
            $data .= ",Batch Code";
            $data .= ",Total";
            foreach ($statusArr as $statusVal)
            {
                $data .= "," . ucfirst($statusVal);
            }
            $data .= "\n";



            //echo "<pre>";print_r($paymentList);exit();
            foreach ($paymentList as $key => $councelor)
            {
                $data .= "\"" . $councelor['assigned_user'];
                $data .= "\"" . $councelor['reporting_user'];
                $data .= "\"" . $councelor['batch_name'];
                $data .= "\",\"" . $councelor['batch_code'];


                $data .= "\",\"" . $councelor['total'];
                $data .= "\",\"" . (!empty($councelor['alive']) ? $councelor['alive'] : 0);
                $data .= "\",\"" . (!empty($councelor['dead']) ? $councelor['dead'] : 0);
                $data .= "\",\"" . (!empty($councelor['converted']) ? $councelor['converted'] : 0);
                $data .= "\",\"" . (!empty($councelor['warm']) ? $councelor['warm'] : 0);
                $data .= "\",\"" . (!empty($councelor['recycle']) ? $councelor['recycle'] : 0);
                $data .= "\",\"" . (!empty($councelor['dropout']) ? $councelor['dropout'] : 0);
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

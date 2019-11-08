<?php

// Date: Created on : 16th APR 2018

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');

//error_reporting(-1);
//ini_set('display_errors', 'On');

class AOR_ReportsViewproductivityform extends SugarView
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
                         WHERE 
			   #aru.`role_id` IN ('$id')
                            u.deleted=0
			    AND  u.department='CC'
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
            $batchOptions[$row['id']] = $row;
        }
        return $batchOptions;
    }

    public function display()
    {

        global $sugar_config, $app_list_strings, $current_user, $db;


        $where      = "";
        $wherecl    = "";
        $campaignID = array();
        $leadID     = array();



        $error = array();

        //$managerSList    = $this->getCouncelorForAdmin('manager');
        $CouncellorsList = $this->getCouncelorForAdmin();


        $BatchListData = $this->getBatch();

        $left = '';




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
            $_SESSION['cccon_from_date']   = $_REQUEST['from_date'];
            $_SESSION['cccon_to_date']     = $_REQUEST['to_date'];
            $_SESSION['cccon_batch']       = $_REQUEST['batch'];
            $_SESSION['cccon_batch_code']  = $_REQUEST['batch_code'];
            $_SESSION['cccon_managers']    = $_REQUEST['managers'];
            $_SESSION['cccon_councellors'] = $_REQUEST['councellors'];
            $_SESSION['cccon_status']      = $_REQUEST['status'];
        }

        //$_SESSION['cccon_from_date']='2017-10-11';
        //$_SESSION['cccon_to_date']='2017-10-11'; 

        if ($_SESSION['cccon_from_date'] != "" && $_SESSION['cccon_to_date'] != "")
        {
            $selected_from_date = $_SESSION['cccon_from_date'];
            $selected_to_date   = $_SESSION['cccon_to_date'];
            $from_date          = date('Y-m-d', strtotime(str_replace('/', '-', $_SESSION['cccon_from_date'])));
            $to_date            = date('Y-m-d', strtotime(str_replace('/', '-', $_SESSION['cccon_to_date'])));
            //$from_date          = "2017-10-01";
            //$to_date            = "2017-10-05";
            $wherecl            .= " AND DATE(leads.date_entered) >= '" . $from_date . "' AND DATE(leads.date_entered) <= '" . $to_date . "'";
        }
        elseif ($_SESSION['cccon_from_date'] != "" && $_SESSION['cccon_to_date'] == "")
        {
            $selected_from_date = $_SESSION['cccon_from_date'];
            $from_date          = date('Y-m-d', strtotime(str_replace('/', '-', $_SESSION['cccon_from_date'])));
            $wherecl            .= " AND DATE(leads.date_entered) >= '" . $from_date . "' ";
        }
        elseif ($_SESSION['cccon_from_date'] == "" && $_SESSION['cccon_to_date'] != "")
        {
            $selected_to_date = $_SESSION['cccon_to_date'];
            $to_date          = date('Y-m-d', strtotime(str_replace('/', '-', $_SESSION['cccon_to_date'])));
            $wherecl          .= " AND DATE(leads.date_entered) <= '" . $to_date . "' ";
        }



        $findBatch = array();



        if (!empty($_SESSION['cccon_source']))
        {
            $selected_source = $_SESSION['cccon_source'];
        }







        $leadList   = array();
        $StatusList = array();



        if (!empty($selected_source))
        {
            $wherecl .= " AND  leads.lead_source IN ('" . implode("','", $selected_source) . "')";
        }

        if (!empty($selected_councellors))
        {
            $wherecl .= " AND  leads.assigned_user_id IN ('" . implode("','", $selected_councellors) . "')";
        }


        $months = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');

        $current_year = date('Y');
        $range        = range($current_year, $current_year - 5);
        $yearsList        = array_combine($range, $range);



        //$insertSql          = "INSERT INTO te_student_payment SET id='" . $student_payment_id . "', name='" . $bean->reference_number . "'";
        //$GLOBALS['db']->Query($insertSql);

        if (isset($_POST['button']))
        {

            $error        = array();
            $userArr      = array();
            $batchCodeArr = array();
            $monthArr     = array();
            $years        = '';
            $target_gsv   = '';
            $target_unit  = '';

            if (isset($_POST['users']) && !empty($_POST['users']))
            {

                $userArr = $_POST['users'];
            }

            if (isset($_POST['batch_code']) && !empty($_POST['batch_code']))
            {

                $batchCodeArr = $_POST['batch_code'];
            }

            if (isset($_POST['month']) && $_POST['month'] != '')
            {

                $month = $_POST['month'];
            }

            if (isset($_POST['years']) && $_POST['years'] != '')
            {

                $years = $_POST['years'];
            }
            if (isset($_POST['target_gsv']) && $_POST['target_gsv'] != '')
            {

                $target_gsv = $_POST['target_gsv'];
            }
            if (isset($_POST['target_unit']) && $_POST['target_unit'] != '')
            {

                $target_unit = $_POST['target_unit'];
            }



            if (!empty($userArr))
            {

                foreach ($userArr as $key => $userID)
                {
                    //$insertSql = "INSERT INTO agent_productivity_report SET user_id='" . $value . "', user_name='',reporting_to='',status=1,created_date='" . date('Y-m-d H:i:s') . "' ";
                    //$GLOBALS['db']->Query($insertSql);

                    if (!empty($batchCodeArr))
                    {

                        foreach ($batchCodeArr as $key => $value_id)
                        {
                            $insertSql = "INSERT INTO agent_productivity_report SET "
                                    . " user_id='" . $userID . "', "
                                    . "user_name='" . $CouncellorsList[$userID]['name'] . "',"
                                    . "reporting_to='" . $CouncellorsList[$userID]['reporting_id'] . "', "
                                    . "batch_code='" . $BatchListData[$value_id]['batch_code'] . "', "
                                    . "batch_id='$value_id',"
                                    . "status=1,"
                                    . "year='$years',"
                                    . "month=$month,"
                                    . "target_gsv='$target_gsv',"
                                    . "target_unit='$target_unit' , "
                                    . "modified_date='" . date('Y-m-d H:i:s') . "' , "
                                    . "created_date='" . date('Y-m-d H:i:s') . "'";
                            $GLOBALS['db']->Query($insertSql);
                        }
                    }
                    else if(empty($batchCodeArr)){
                        
                        $insertSql = "INSERT INTO agent_productivity_report SET "
                                    . " user_id='" . $userID . "', "
                                    . "user_name='" . $CouncellorsList[$userID]['name'] . "',"
                                    . "reporting_to='" . $CouncellorsList[$userID]['reporting_id'] . "', "
                                    . "batch_code='NULL', "
                                    . "batch_id='NULL',"
                                    . "status=1,"
                                    . "year='$years',"
                                    . "month=$month,"
                                    . "target_gsv='$target_gsv',"
                                    . "target_unit='$target_unit' , "
                                    . "modified_date='" . date('Y-m-d H:i:s') . "' , "
                                    . "created_date='" . date('Y-m-d H:i:s') . "'";
                            $GLOBALS['db']->Query($insertSql);
                        
                    }
                }
            }
        }

        $leadSql = "SELECT *
                     FROM agent_productivity_report
                     where status=1 and deleted=0 order by created_date desc";

        $leadObj = $db->query($leadSql) or die(mysqli_error());


        while ($row = $db->fetchByAssoc($leadObj))
        {

            $leadList[] = $row;
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





        $sugarSmarty->assign("StatusList", $StatusList);
        $sugarSmarty->assign("leadList", $leadList);
        $sugarSmarty->assign("BatchListData", $BatchListData);

        $sugarSmarty->assign("selected_from_date", $selected_from_date);
        $sugarSmarty->assign("selected_to_date", $selected_to_date);








        // $sugarSmarty->assign("selected_councellors", $selected_councellors);



        $sugarSmarty->assign("CouncellorsList", $CouncellorsList);

        $sugarSmarty->assign("month", $months);
        $sugarSmarty->assign("years", $yearsList);

        $sugarSmarty->assign("current_records", $current);
        $sugarSmarty->assign("page", $page);
        $sugarSmarty->assign("pagenext", $pagenext);
        $sugarSmarty->assign("right", $right);
        $sugarSmarty->assign("left", $left);
        $sugarSmarty->assign("last_page", $last_page);

        $sugarSmarty->display('custom/modules/AOR_Reports/tpls/productivityform.tpl');
    }

}
?>


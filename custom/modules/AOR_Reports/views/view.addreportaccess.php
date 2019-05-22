<?php

// Date: Created on : 27th March 2019

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');

//error_reporting(-1);
//ini_set('display_errors', 'On');

class AOR_ReportsViewaddreportaccess extends SugarView
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

        $userSql  = "SELECT     u.first_name,
                                u.last_name,
                                u.id
                         FROM users AS u
                         WHERE 
                            u.deleted=0
                           AND u.status='Active' ";
        $userObj  = $db->query($userSql);
        $usersArr = [];
        while ($user     = $db->fetchByAssoc($userObj))
        {
            $usersArr[$user['id']]['id']   = $user['id'];
            $usersArr[$user['id']]['name'] = $user['first_name'] . ' ' . $user['last_name'];
        }
        return $usersArr;
    }

    public function display()
    {

        global $sugar_config, $app_list_strings, $current_user, $db;


        $where      = "";
        $wherecl    = "";
        $campaignID = array();
        $leadID     = array();


        $report_action   = '';
        $reportAccess    = reportAccessLog();
        $current_user_id = $current_user->id;
        $report_action   = isset($GLOBALS['action']) ? $GLOBALS['action'] : '';

        if (!in_array($current_user->id, $reportAccess[$report_action]) && ($current_user->is_admin != 1))
        {
            echo 'You are not authorized to access!';
            return;
        }

        $error = array();

        $CouncellorsList = $this->getCouncelorForAdmin();
        $left            = '';
        if (isset($_POST['button']) || isset($_POST['export']))
        {

            $_SESSION['cccon_councellors'] = $_REQUEST['councellors'];
            $_SESSION['cccon_status']      = $_REQUEST['status'];
        }

        if (isset($_POST['button']))
        {

            $error        = array();
            $userArr      = array();
            $batchCodeArr = array();
            $monthArr     = array();
            $error_fields = array();
            $years        = '';
            $target_gsv   = '';
            $target_unit  = '';

            if (isset($_POST['users']) && !empty($_POST['users']))
            {

                $userArr = $_POST['users'];
            }


            if (isset($_POST['report_name']) && $_POST['report_name'] != '')
            {

                $report_name = $_POST['report_name'];
            }
            if (isset($_POST['report_url']) && $_POST['report_url'] != '')
            {

                $report_url = $_POST['report_url'];
                $query      = array();
                $exploadUrl = parse_url($report_url);
                parse_str($exploadUrl['query'], $query);


                $module = $query['module'];
                $action = $query['action'];
            }


            if (!isset($report_url) || empty($report_url))
            {
                $error_fields['test_status'] = ['Report URL field is required.'];
            }
            if (!isset($module) || empty($module))
            {
                $error_fields['test_status'] = ['Module name not found in URL'];
            }
            if (!isset($action) || empty($action))
            {
                $error_fields['test_status'] = ['Action name not found in URL'];
            }




            if ($error_fields)
            {
                //createLog('{while get an error}', 'web_onlinetest_status' . date('Y-m-d') . '_log.txt', $test_status, $data);

                $response_result = array('status' => '400', 'result' => $error_fields);
                echo json_encode($response_result);
                exit();
            }


            if (!empty($userArr))
            {

                foreach ($userArr as $key => $userID)
                {

                    $insertSql = "INSERT INTO report_access_log  SET "
                            . " assigned_user_id='" . $userID . "', "
                            . "	assigned_user_email='" . $CouncellorsList[$userID]['email'] . "',"
                            . "report_name='$report_name',"
                            . "module_name='$module' , "
                            . "report_action	='$action' , "
                            . "created_by	='$current_user->id' , "
                            . "is_enabled	='1' , "
                            . "modified_date='" . date('Y-m-d H:i:s') . "' , "
                            . "created_date='" . date('Y-m-d H:i:s') . "'";
                    //die;
                    $GLOBALS['db']->Query($insertSql);
                }
            }
        }

        $leadSql = "SELECT *
                     FROM  report_access_log
                     where is_enabled=1  order by created_date desc";

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
        $sugarSmarty->assign("CouncellorsList", $CouncellorsList);
        $sugarSmarty->assign("current_records", $current);
        $sugarSmarty->assign("leadList", $leadList);

        $sugarSmarty->assign("page", $page);
        $sugarSmarty->assign("pagenext", $pagenext);
        $sugarSmarty->assign("right", $right);
        $sugarSmarty->assign("left", $left);
        $sugarSmarty->assign("last_page", $last_page);

        $sugarSmarty->display('custom/modules/AOR_Reports/tpls/addreportaccess.tpl');
    }

}
?>


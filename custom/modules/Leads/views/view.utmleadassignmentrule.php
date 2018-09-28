<?php

//Date: Created on : 27th SEP 2018

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');


//error_reporting(-1);
//ini_set('display_errors', 'On');

class LeadsViewutmleadassignmentrule extends SugarView
{

    var $report_to_id;
    var $counsellors_arr;

    public function __construct()
    {
        parent::SugarView();
    }

   
    function getVendors()
    {
        global $db;
        $vendorSql      = "SELECT id,name FROM te_vendor WHERE deleted=0 order by name";
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
        
        $BatchListData = $this->getBatch();
        $VendorListData = $this->getVendors();
        
        
       
        
        $submit_button     = filter_var($_POST['button'], FILTER_SANITIZE_STRING);
        $submit_export     = filter_var($_POST['export'], FILTER_SANITIZE_STRING);

        $left = '';
        
        $vendor=''; $batch_code=''; $campaign_id=''; $lead_id='';



        if (isset($submit_button) || isset($submit_export))
        {
             $source_vendor      = filter_var($_POST['vendor'], FILTER_SANITIZE_STRING);
             $batch_code  = filter_var($_POST['batch_code'], FILTER_SANITIZE_STRING);
             $campaign_id = filter_var($_POST['campaign_id'], FILTER_SANITIZE_NUMBER_INT);
             $lead_id     = filter_var($_POST['lead_id'], FILTER_SANITIZE_NUMBER_INT);
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



        $sugarSmarty->assign("VendorListData", $VendorListData);

        $sugarSmarty->assign("month", $months);
        $sugarSmarty->assign("years", $yearsList);

        $sugarSmarty->assign("current_records", $current);
        $sugarSmarty->assign("page", $page);
        $sugarSmarty->assign("pagenext", $pagenext);
        $sugarSmarty->assign("right", $right);
        $sugarSmarty->assign("left", $left);
        $sugarSmarty->assign("last_page", $last_page);

        $sugarSmarty->display('custom/modules/Leads/tpls/utmleadassignmentrule.tpl');
    }

}
?>


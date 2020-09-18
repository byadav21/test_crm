<?php

// Date: Created on : 27th FEB 2018

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');

//error_reporting(E_ALL);
//ini_set('display_errors', 'On');

class AOR_ReportsViewagetnleads extends SugarView
{

    var $report_to_id;
    var $counsellors_arr;

    public function __construct()
    {
        parent::SugarView();
    }

    public function display()
    {

        global $sugar_config, $app_list_strings, $current_user, $db;
        $additionalUsr         = array('4fa58025-3c9d-aa2a-d355-59a062393942');
        $additionalUsrStatus   = 0;
        $current_user_id       = $current_user->id;
        $current_user_is_admin = $current_user->is_admin;
        
        if (in_array($current_user_id, $additionalUsr))
        {
             $additionalUsrStatus   = 1;
        }
        
        $wherecl = '';
        $left    = '';

        $batch_id      = '';
        $show          = '';
        $from_date     = '';
        $to_date       = '';
        $lcount        = '';
        $assigned_user = '';




        if (isset($_GET['batch']) && $_GET['batch'] != '')
        {
            $batch_id = $_GET['batch'];
        }
        if (isset($_GET['show']) && $_GET['show'] != '')
        {
            $statusBy = $_GET['show'];
        }

        if (isset($_GET['from_date']) && $_GET['from_date'] != '')
        {
            $from_date = $_GET['from_date'];
        }
        if (isset($_GET['to_date']) && $_GET['to_date'] != '')
        {
            $to_date = $_GET['to_date'];
        }
        if (isset($_GET['lcount']) && $_GET['lcount'] != '')
        {
            $lcount = $_GET['lcount'];
        }
        if (isset($_GET['assigned_user']) && $_GET['assigned_user'] != '')
        {
            $assigned_user = $_GET['assigned_user'];
        }
        if (isset($_GET['status_date']) && $_GET['status_date'] != '')
        {
            $status_date = $_GET['status_date'];
        }

        if (isset($_GET['date_of_prospect']) && $_GET['date_of_prospect'] != '')
        {
            $date_of_prospect = $_GET['date_of_prospect'];
        }

        if (isset($_GET['status_description']) && $_GET['status_description'] != '')
        {
            $status_description = $_GET['status_description'];
        }
        $StatusList['new_lead']               = 'New Lead';
        $StatusList['follow_up']              = 'Follow Up';
        $StatusList['call_back']              = 'Call back';
        $StatusList['dead_number']            = 'Dead Number';
        $StatusList['fallout']                = 'Fallout';
        $StatusList['not_eligible']           = 'Not Eligible';
        $StatusList['not_enquired']           = 'Not Enquired';
        $StatusList['retired']                = 'Retired';
        $StatusList['auto_retired']           = 'Auto Retired';
        $StatusList['ringing_multiple_times'] = 'Ringing Multiple Times';
        $StatusList['wrong_number']           = 'Wrong Number';
        $StatusList['converted']              = 'Converted';
        $StatusList['prospect']               = 'Prospect';
        $StatusList['re_enquired']            = 'Re-Enquired';
        $StatusList['recycle']                = 'Recycle';
        $StatusList['dropout']                = 'Dropout';
        $StatusList['duplicate']              = 'Duplicate';
        $StatusList['dnc']                    = 'DNC';
        $StatusList['not_answering']          = 'Not Answering';

        ///New added
        $StatusList['rejected']             = 'Rejected';
        $StatusList['not_interested']       = 'Not Interested';
        $StatusList['instalment_follow_up'] = 'Instalment Follow Up';
        $StatusList['referral_follow_up']   = 'Referral Follow Up';
        $StatusList['null']                 = 'null';
        $StatusList['cross_sell']           = 'Cross Sell';
        $StatusList['next_batch']           = 'Next Batch';
        $StatusList['program_enquiry']      = 'Program Enquiry';
        $StatusList['re-assigned']          = 'Re-Assigned';
        $StatusList['user_forced_logged_off'] = 'user.forced.logged.off'; 
        $StatusList['wrap_timeout']         = 'wrap.timeout';
        ///
        $StatusList['na']                   = 'NA';



        if(empty($date_of_prospect)){
        $status_date = ($status_date == 'date_modified') ? 'date_modified': 'date_entered';
        if ($from_date != "" && $to_date != "")
        {

            $wherecl .= " AND DATE(leads.".$status_date.") >= '" . $from_date . "' AND DATE(leads.".$status_date.") <= '" . $to_date . "'";
        }
        else
        {
            
            $wherecl .= " AND DATE(leads.".$status_date.") = '" . date('Y-m-d') . "'";
        }
    }

        if ($assigned_user != '')
        {

            $wherecl .= " AND leads.assigned_user_id = '" . $assigned_user . "'";
        }

        if ($statusBy != '' && $statusBy != 'total')
        {
            $wherecl .= " AND  leads.status_description='" . $StatusList[$statusBy] . "'";
        }
        if ($batch_id != '')
        {
            $wherecl .= " AND  te_ba_batch.id='" . $batch_id . "'";
        }

        if ($date_of_prospect != '')
        {
            $wherecl .= " AND  leads.date_of_prospect='" . $date_of_prospect . "'";
            $wherecl .= " AND  leads.status_description='" . $status_description . "'";
        }



        $headers = array(
            'leads.id'                                                    => 'ID',
            'leads.date_entered'                                          => 'Date Entered',
            'leads.date_modified'                                         => 'Date Modified',
            'leads.date_of_followup'                                      => 'Date of Followup',
            'leads.date_of_prospect'                                      => 'Date of Prospect',
            'leads.status'                                                => 'Status',
            'leads.status_description'                                    => 'Status Description',
            'leads.disposition_reason'                                    => 'Disposition Reason',
            "CONCAT(COALESCE(leads.first_name,''),' ',COALESCE(leads.last_name,'')) AS Reporting_Name"  => 'Customer Name',
            'leads_cstm.email_add_c'                                      => 'Email Address',
            'leads.phone_mobile'                                          => 'Mobile',
            'users.user_name'                                             => 'Agent Name',
            'te_ba_batch.batch_code'                                      => 'Batch Code',
            'leads.lead_source'                                           => 'Lead Source',
            'leads.vendor'                                                => 'Vendor',
            'leads_cstm.attempts_c'                                       => 'No of Attempts'
        );
        
        if($current_user_is_admin!=1){
            unset($headers['leads.lead_source']);
            unset($headers['leads.vendor']);
	    unset($headers['leads.phone_mobile']);
	    unset($headers['leads_cstm.email_add_c']);
        }
        //echo '<pre>';
        //print_r($headers);

        $headersss = implode(', ', array_keys($headers));
        
        

        $leadSql = "SELECT 
                    	    $headersss     
                                       
                    FROM leads
                    INNER JOIN users ON leads.assigned_user_id =users.id
                    INNER JOIN leads_cstm ON leads.id= leads_cstm.id_c
                    INNER JOIN te_ba_batch ON leads_cstm.te_ba_batch_id_c= te_ba_batch.id
                    WHERE leads.deleted=0 
                    AND te_ba_batch.deleted=0 
                    
                    $wherecl
                    order by leads.id";
        // echo $leadSql;
        $leadObj = $db->query($leadSql);


        $leadArr  = array();
        $leadList = array();
        while ($row      = $db->fetchByAssoc($leadObj))
        {
            $leadList[] = $row;
        }




        if (isset($_POST['export']) && $_POST['export'] == "Export")
        {

            $file     = "leadutilization_report";
            $where    = '';
            $filename = $file . "_" . $from_date . "_" . $to_date;

            $data = "";
            foreach ($headers as $key => $column)
            {
                $data .= $column . ",";
            }
            $data .= "\n";


            foreach ($leadList as $key => $value)
            {
                foreach ($value as $key1 => $column)
                {

                    $data .= $column . ",";
                }

                $data .= "\n";
            }

            ob_end_clean();
            header("Content-type: application/csv");
            header('Content-disposition: attachment;filename=" ' . $filename . '.csv";');
            echo $data;
            exit;
        } // End Of Export Func
        //
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

        $sugarSmarty->assign("batch_id", $batch_id);
        $sugarSmarty->assign("statusBy", $statusBy);
        $sugarSmarty->assign("from_date", $from_date);
        $sugarSmarty->assign("to_date", $to_date);
        $sugarSmarty->assign("lcount", $lcount);
        $sugarSmarty->assign("assigned_user", $assigned_user);
        $sugarSmarty->assign("current_user_is_admin", $current_user_is_admin);
         $sugarSmarty->assign("additionalUsrStatus", $additionalUsrStatus);

        $sugarSmarty->assign("leadList", $leadList);
        $sugarSmarty->assign("ExcelHeaders", $headers);
        $sugarSmarty->assign("current_records", $current);
        $sugarSmarty->assign("page", $page);
        $sugarSmarty->assign("pagenext", $pagenext);
        $sugarSmarty->assign("right", $right);
        $sugarSmarty->assign("left", $left);
        $sugarSmarty->assign("last_page", $last_page);
        $sugarSmarty->display('custom/modules/AOR_Reports/tpls/agetnleads.tpl');
    }

}
?>


<?php

// Date: Created on : 27th FEB 2018

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');

//error_reporting(-1);
//ini_set('display_errors', 'On');

class AOR_ReportsViewviewleads extends SugarView
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

        $wherecl = '';
        $left    = '';

        if (!isset($_SESSION['cccon_from_date']))
        {
            $_SESSION['cccon_from_date'] = date('Y-m-d', strtotime('-1 days'));
        }
        if (!isset($_SESSION['cccon_to_date']))
        {
            $_SESSION['cccon_to_date'] = date('Y-m-d', strtotime('-1 days'));
        }
        if (isset($_GET['batch']) && $_GET['batch'] != '')
        {
            $_SESSION['cccon_batch_codex'] = $_GET['batch'];
        }
        if (isset($_GET['show']) && $_GET['show'] != '')
        {
            $_SESSION['cccon_show'] = $_GET['show'];
        }
        //echo 'ccc'.$_SESSION['cccon_show'];
//        if (isset($_POST['button']) || isset($_POST['export']))
//        {
//            $_SESSION['cccon_from_date'] = $_REQUEST['from_date'];
//            $_SESSION['cccon_to_date']   = $_REQUEST['to_date'];
//        }
        if (isset($_GET['from_date']) && $_GET['from_date'] != '')
        {
            $_SESSION['cccon_from_date'] = $_GET['from_date'];
        }
        if (isset($_GET['to_date']) && $_GET['to_date'] != '')
        {
            $_SESSION['cccon_to_date'] = $_GET['to_date'];
        }
        
        //$_SESSION['cccon_from_date'] = '2017-10-11';
        //$_SESSION['cccon_to_date']   = '2017-10-11';
        
        //echo 'cccon_from_date=='.$_SESSION['cccon_from_date'] .'cccon_to_date'. $_SESSION['cccon_to_date'];

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







        $batchCode = '';
        if ($_SESSION['cccon_batch_codex'] != '')
        {
            $batchCode = $_SESSION['cccon_batch_codex'];
            $wherecl   .= " AND  te_ba_batch.batch_code='" . $batchCode . "'";
        }

        $showByClick = '';
        if ($_SESSION['cccon_show'] != '')
        {

            $showByClick = $_SESSION['cccon_show'];
        }



        if (!empty($selected_source))
        {
            $wherecl .= " AND  leads.lead_source IN ('" . implode("','", $selected_source) . "')";
        }

        $StatusList['new_lead']               = 'New Lead';
        $StatusList['follow_up']              = 'Follow Up';
        $StatusList['prospect']               = 'Prospect';
        
        $StatusList['dead_number']            = 'Dead Number';
        $StatusList['ringing_multiple_times'] = 'Ringing Multiple Times';
        $StatusList['dispositions']            = 'Non-connect';
        
        $StatusList['converted']              = 'converted'; 
        $StatusList['fallout']                = 'Fallout';       
        $StatusList['not_eligible']           = 'Not Eligible';
        $StatusList['not_enquired']           = 'Not Enquired';
        $StatusList['wrong_number']           = 'Wrong Number';

        if ($_SESSION['cccon_show']!='' && $StatusList[$_SESSION['cccon_show']]!='Non-connect')
        {
           $wherecl .= " AND  leads.status_description='".$StatusList[$_SESSION['cccon_show']]."'";
            
        }
        else if ($_SESSION['cccon_show']!='' && $StatusList[$_SESSION['cccon_show']]=='Non-connect')
        {
           $wherecl .= " AND leads.status_description!='Re-Enquired' and (leads.dispositionName!='CONNECTED' || leads.dispositionName IS NULL)";
            
        }
        



        //echo '<pre>';
        //print_r($showLeads);
        //$leadList = array(); die;


        $headers = array(
            'leads.id'                            => 'ID',
            'leads.date_entered'                  => 'Date Entered',
            'leads.date_modified'                 => 'Date Modified',
            'leads.converted_date'                => 'Converted Date',
            'leads_cstm.temp_lead_date_c'         => 'Temp Lead Date',
            'leads.date_of_followup'              => 'Date of Followup',
            'leads.date_of_prospect'              => 'Date of Prospect',
            'leads.status'                        => 'Status',
            'leads.status_description'            => 'Status Description',
            'leads.lead_source'                   => 'Lead Source',
            #'leads.vendor'                        => 'Vendor',
            'users.first_name as user_first_name' => 'Counsellor F.Name',
            'users.last_name as user_last_name'   => 'Counsellor L.Name',
            'leads.assigned_user_id'              => 'Assigned User',
            'te_ba_batch.name'                    => 'Batch Name',
            'te_ba_batch.batch_code'              => 'Batch Code',
            'leads_cstm.attempts_c'               => 'No of Attempts',
            'leads.autoassign'                    => 'Autoassign',
            'leads.dristi_campagain_id'           => 'Campagain ID',
            'leads.dristi_API_id'                 => 'API_id (LeadID)',
            'leads.neoxstatus'                    => 'Ameyo Status',
            'leads.deleted'                       => 'Deleted');






          //echo '<pre>';

         $leadSql = "SELECT 
                    	    leads.id,                            
                            leads.date_entered,                 
                            leads.date_modified,                
                            leads.converted_date,                
                            leads_cstm.temp_lead_date_c,        
                            leads.date_of_followup,             
                            leads.date_of_prospect,             
                            leads.status,                      
                            leads.status_description,           
                            leads.lead_source,                   
                            #leads.vendor,                       
                            users.first_name as user_first_name,
                            users.last_name as user_last_name,  
                            leads.assigned_user_id,             
                            te_ba_batch.name,                   
                            te_ba_batch.batch_code,             
                            leads_cstm.attempts_c,              
                            leads.autoassign,                  
                            leads.dristi_campagain_id,          
                            leads.dristi_API_id,                 
                            leads.neoxstatus,                    
                            leads.deleted             
                    FROM leads
                    INNER JOIN users ON leads.assigned_user_id =users.id
                    INNER JOIN leads_cstm ON leads.id= leads_cstm.id_c
                    INNER JOIN te_ba_batch ON leads_cstm.te_ba_batch_id_c= te_ba_batch.id
                    WHERE leads.deleted=0 
                    AND te_ba_batch.deleted=0 
                    AND users.deleted=0 
                    $wherecl
                    order by leads.id"; 

        $leadObj = $db->query($leadSql) or die(mysqli_error());

        //$FresleadArr = $this->getFresh();
        //$attemptArr  = $this->getAttempts();
        //$i   = 0;
        $leadArr = array();
        while ($row     = $db->fetchByAssoc($leadObj))
        {
            $leadArr[$row['id']] = $row;
        }

        foreach ($leadArr as $key => $val)
        {

            if (!empty($showLeads))
            {
                if (array_key_exists($key, $showLeads))
                    $leadList[$showLeads[$key]] = $val;
            }
            else
            {
                $leadList[$key] = $val;
            }
        }

        //echo '<pre>';
        //print_r($leadList); 

        if (isset($_POST['export']) && $_POST['export'] == "Export")
        {

            $file     = "leadutilization_report";
            $where    = '';
            $filename = $file . "_" . $from_date . "_" . $to_date;


            //print_r($leadList); die;
            # Create heading
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

        //$sugarSmarty->assign("error", $error);
        $sugarSmarty->assign("leadList", $leadList);


        $sugarSmarty->assign("leadList", $leadList);

        $sugarSmarty->assign("selected_from_date", $selected_from_date);
        $sugarSmarty->assign("selected_to_date", $selected_to_date);

        $sugarSmarty->assign("ExcelHeaders", $headers);

        $sugarSmarty->assign("current_records", $current);
        $sugarSmarty->assign("page", $page);
        $sugarSmarty->assign("pagenext", $pagenext);
        $sugarSmarty->assign("right", $right);
        $sugarSmarty->assign("left", $left);
        $sugarSmarty->assign("last_page", $last_page);
        $sugarSmarty->display('custom/modules/AOR_Reports/tpls/viewleads.tpl');
    }

}
?>


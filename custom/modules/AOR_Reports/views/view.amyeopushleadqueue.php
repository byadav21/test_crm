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
class AOR_ReportsViewamyeopushleadqueue extends SugarView
{

    var $report_to_id;
    var $counsellors_arr;
    private $objPagination;
    private $_objInputs;

    public function __construct()
    {
        parent::SugarView();
        $this->objPagination = new pagination(60, 'page');
        $this->_objInputs   = new UserInput();
        //$this->_objInputs->syncSessions('exportHeaderWiseReport');
    }

    public function display()
    {

        global $sugar_config, $app_list_strings, $current_user, $db;
        $current_user_id = $current_user->id;
        $_export         = isset($this->_objInputs->post['export']) && $this->_objInputs->post['export'] == "Export";
        $where           = "";
        $wherecl         = "";
       



      


        $headers = array(
            'l.id'=>'Lead ID',
            'l.first_name'=>'First Name',
            'l.last_name'=>'Last Name',
            'l.phone_mobile'=>'Phone Mobile',
            'l.phone_home'=>'Phone Home',
            'l.phone_work'=>'Phone Work',
            'l.phone_other'=>'Phone Other',
            'e.email_address'=>'Email Address',
            'dristi_campagain_id'=>'Dristi Campagain ID',
            'dristi_api_id'=>'Drisit API ID',
            'te_ba_batch.batch_code'=>'Batch Code',
            'te_ba_batch.d_campaign_id'=>'Batch Campagain ID',
            'te_ba_batch.d_lead_id'=>'Batch API ID');
        
        $stringHeaders = implode(",", array_keys($headers));
        
        $sqlPart = "
               FROM leads l
                 LEFT JOIN email_addr_bean_rel el ON l.id = el.bean_id
                 AND el.bean_module='Leads'
                 AND el.deleted=0
                 LEFT JOIN email_addresses e ON el.email_address_id = e.id
                 LEFT JOIN leads_cstm ON l.id= leads_cstm.id_c
                 LEFT JOIN te_ba_batch ON leads_cstm.te_ba_batch_id_c= te_ba_batch.id
                 AND e.deleted=0
                 WHERE l.deleted =0
                   AND l.status_description= 'New Lead'
                   AND l.neoxstatus='0'
                   AND dristi_campagain_id !=''
                   AND dristi_api_id !=''
                   AND (l.assigned_user_id= 'NULL'
                        OR l.assigned_user_id =''
                        OR l.assigned_user_id IS NULL)
                 ORDER BY concat (dristi_campagain_id,dristi_api_id) ";

        $countSql = "SELECT count(1) as count " . $sqlPart;


        $leadSql = "SELECT $stringHeaders " . $sqlPart;




        if (!$_export)
        {
            $limit   = $this->objPagination->get_limit();
            $leadSql .= ' ' . $limit;
        }
        //echo $leadSql;
        $rowCount = 0;
        $leadObj  = null;

//      if ($Days >= 0 && $Days <= 93 && $wherecl != '') {
        if ($_export)
        {
            $leadObj = $db->query($leadSql);
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


        if ($_export)
        {

            $file     = "HeaderWiseLead_report";
            $filename = $file . "_" . $from_date . "_" . $to_date;
            global $current_user;
            global $db;
            //$leadObj  = $db->query($leadSql);
            # Create heading
            $data = "";
            
            $data .= $stringHeaders;
            $data .= "\n";
            ob_end_clean();


            //$leadCount    = $rowCount; //count($leadList);
            //$userName     = $current_user->user_name;
            //$userID       = $current_user->id;
            //$ExportRecord = array('user_name' => $userName, 'user_id' => $userID, 'Lead_Count' => $leadCount, 'from_date' => $from_date, 'to_date' => $to_date, 'Headers' => array_values($ExcelHeaders), 'selected_batch' => $selected_batch, 'selected_batch_code' => $selected_batch_code, 'selected_vendor' => $selected_vendor, 'selected_status' => $selected_status, 'selected_status_description' => $selected_status_description);
            //$sql          = "insert into data_export_log set  source='Export tool',date_entered='" . date('Y-m-d H:i:s') . "',user_name='" . $userName . "',data_record='" . json_encode($ExportRecord) . "'";
            //$db->query($sql);


            header("Content-type: application/csv");
            header('Content-disposition: attachment;filename=" ' . $filename . '.csv";');
            echo $data;
            while ($row = $db->fetchByAssoc($leadObj))
            {

                $data = implode(',', $row);
                $data .= "\n";
                echo $data;
            }
//            echo $data;
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

        $sugarSmarty->assign("campaignIDs", $campaignID);
        $sugarSmarty->assign("leadIDs", $leadID);
        $sugarSmarty->assign("ExcelHeaders", $ExcelHeaders);
        $sugarSmarty->assign("current_records", $current);
        $sugarSmarty->assign("page", $page);
        $sugarSmarty->assign("pagenext", $pagenext);
        $sugarSmarty->assign("pageprevious", $pageprevious);
        $sugarSmarty->assign("right", $right);
        $sugarSmarty->assign("left", $left);
        $sugarSmarty->assign("last_page", $last_page);
        $sugarSmarty->display('custom/modules/AOR_Reports/tpls/amyeopushleadqueue.tpl');
    }

}
?>


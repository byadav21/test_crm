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
class AOR_ReportsViewexportheaderwisereporttest extends SugarView
{
    var $report_to_id;
    var $counsellors_arr;
    private $objPagination;
    private $_objInputs;
    public function __construct()
    {
        parent::SugarView();
        $this->objPagination = new pagination(60, 'page');
        $this-> _objInputs = new UserInput();
        $this->_objInputs->syncSessions('exportHeaderWiseReport');
    }

    function getProgram()
    {
        global $db;
        $proSql      = "SELECT id,name FROM te_pr_programs WHERE deleted=0";
        $pro_Obj     = $db->query($proSql);
        $pro_Options = array();
        while ($row         = $db->fetchByAssoc($pro_Obj))
        {
            $pro_Options[] = $row;
        }
        return $pro_Options;
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
            $batchOptions[] = $row;
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
        $current_user_id = $current_user->id;
        $_export = isset($this->_objInputs->post['export']) && $this->_objInputs->post['export'] == "Export";

	$report_action = '';
        $reportAccess  = reportAccessLog();

        $current_user_id = $current_user->id;
        $report_action   = isset($GLOBALS['action']) ? $GLOBALS['action'] : '';


        if (!in_array($current_user->id, $reportAccess[$report_action]) && ($current_user->is_admin != 1))
        {
            echo 'You are not authorized to access!';
            return;
        }

        $where           = "";
        $wherecl         = "";
        $campaignID      = array();
        $leadID          = array();
        $ProgramListData = $this->getProgram();
        $BatchListData   = $this->getBatch();
        $VendorListData  = $this->getVendors();
        $error           = array();
        
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
        $selected_headers            = array();
        $findBatch = array();
        $leadList   = array();
        $StatusList = array();
     
        
        $usersAccessId = array('d81fc9e1-91ae-eba3-19d9-5af02415c81c');
        
        foreach ($BatchListData as $val)
        {
            $d_campaign_id = $val['d_campaign_id'];

            if ($d_campaign_id != '')
            {
                $campaignID[$val['d_campaign_id']] = $val['d_campaign_id'];
                $leadID[$val['d_lead_id']]         = $val['d_lead_id'];
            }
        }

        /*
        if (!isset($_POST['from_date']))
        {
            $selected_from_date = date('Y-m-d', strtotime('-1 days'));
        }
        if (!isset($_POST['to_date']))
        {
            $selected_to_date = date('Y-m-d', strtotime('-1 days'));
        }
        */
        
//        if (isset($_POST['button']) || isset($_POST['export']))
//        {
            $selected_from_date          = $this->_objInputs->getVal('from_date', 'post', date('Y-m-d', strtotime('-1 days')));
            $selected_to_date            = $this->_objInputs->getVal('to_date', 'post', date('Y-m-d', strtotime('-1 days')));
            $selected_batch              = $this->_objInputs->getVal('batch', 'post', array());
            $selected_batch_code         = $this->_objInputs->getVal('batch_code', 'post', array());
            $selected_vendor             = $this->_objInputs->getVal('vendors', 'post', array());
            $selected_headers            = $this->_objInputs->getVal('headers', 'post', array());
            $selected_status             = $this->_objInputs->getVal('status', 'post', array());
            $selected_status_description = $this->_objInputs->getVal('status_description', 'post', '');
          
//        }
       
        
        if ($selected_from_date != "" ){
            $from_date  = date('Y-m-d', strtotime(str_replace('/', '-', $selected_from_date)));
            $wherecl    .= " AND DATE(leads.date_entered) >= '" . $from_date . "'";
        }

        if ($selected_to_date != ""){
            $to_date = date('Y-m-d', strtotime(str_replace('/', '-', $selected_to_date)));
            $wherecl .= " AND DATE(leads.date_entered) <= '" . $to_date . "' ";
        }

        if (!empty($selected_batch)){

            $wherecl .= " AND  te_ba_batch.id IN ('" . implode("','", $selected_batch) . "')";
        }

        if (!empty($selected_batch_code)){

            $wherecl .= " AND  te_ba_batch.id IN ('" . implode("','", $selected_batch_code) . "')";
        }

        if (!empty($selected_vendor)){

            $wherecl .= " AND  te_vendor.id IN ('" . implode("','", $selected_vendor) . "')";
        }

        if (!empty($selected_status)){
            
            $wherecl .= " AND  leads.status IN ('" . implode("','", $selected_status) . "')";
        }

        if (!empty($selected_status_description)){
            $wherecl .= " AND  leads.status_description IN ('" . implode("','", $selected_status_description) . "')";
        }
        
        // while CC team will use this
        if(in_array($current_user_id, $usersAccessId)){
            
            //$wherecl .= " AND  lead_source_types in ('CC','NULL','null','') ";
             $wherecl .= " and ( leads.lead_source_types is NULL or leads.lead_source_types is null or leads.lead_source_types='CC' or leads.lead_source_types='') ";
        }
        


        $lead_source        = $GLOBALS['app_list_strings']['lead_source_custom_dom'];
        $lead_source_custom = $GLOBALS['app_list_strings']['lead_source_custom_dom_type'];

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
            'leads.vendor'                        => 'Vendor',
            'leads.assigned_user_id'              => 'Assigned User',
            'users.user_name'                     => 'Customer Name',
            'te_ba_batch.name'                    => 'Batch Name',
            'te_ba_batch.batch_code'              => 'Batch Code',
            'leads_cstm.attempts_c'               => 'No of Attempts',
            'leads.first_name'                    => 'First Name',
            'leads.last_name'                     => 'Last Name',
            'leads_cstm.email_add_c'              => 'Email Address',
            'leads.phone_mobile'                  => 'Phone Mobile',
            'leads.phone_home'                    => 'Phone Home',
            'leads.phone_work'                    => 'Phone Work',
            'leads.phone_other'                   => 'Phone Other',
            'leads.utm'                           => 'UTM',
            'leads.callType'                      => 'Call Type',
            'leads.dispositionName'               => 'Disposition Name',
            'users.first_name as user_first_name' => 'Counsellor F.Name',
            'users.last_name as user_last_name'   => 'Counsellor L.Name',
            'leads.dristi_customer_id'            => 'Dristi Customer ID',
            'leads.is_sent_web'                   => 'IS Sent Web',
            'leads.web_lead_id'                   => 'Web Lead ID',
            'leads.lead_date'                     => 'Lead Date',
            'leads.utm_term_c'                    => 'UTM Term C',
            'leads.utm_source_c'                  => 'UTM Source C',
            'leads.autoassign'                    => 'Autoassign',
            'leads.dristi_campagain_id'           => 'Campagain ID',
            'leads.dristi_API_id'                 => 'API_id (LeadID)',
            'leads.neoxstatus'                    => 'Ameyo Status',
	    'leads.disposition_reason'            => 'Disposition Reason',
            'leads.deleted'                       => 'Deleted',
            'leads.comment'                       => 'Comment',
            'leads.note'                          => 'Note'
        );

        $StatusDetails = array(
            'Follow Up'              => 'Follow Up',
            'New Lead'               => 'New Lead',
            'Converted'              => 'Converted',
            'Instalment Follow up'   => 'Instalment Follow up',
            'Referral Follow up'     => 'Referral Follow up',
            'Dead Number'            => 'Dead Number',
            'Wrong Number'           => 'Wrong Number',
            'Ringing Multiple Times' => 'Ringing Multiple Times',
            'Not Enquired'           => 'Not Enquired',
            'Not Eligible'           => 'Not Eligible',
            'Fallout'                => 'Fallout',
            'Cross Sell'             => 'Cross Sell', //New
            'Not Interested'         => 'Not Interested', //New
            'Next Batch'             => 'Next Batch', //New
            'Retired'                => 'Retired', //New
            'Duplicate'              => 'Duplicate',
            'Dropout'                => 'Dropout',
            'Re-Enquired'            => 'Re-Enquired',
            'Prospect'               => 'Prospect',
            'Recycle'                => 'Recycle',
            'wrap.timeout'           => 'wrap.timeout',
            'Call Back'              => 'Call Back',
            'Re-Assigned'            =>  'Re-Assigned',
            'user.forced.logged.off' => 'user.forced.logged.off');

        if(!empty($selected_headers)){
        $headersss = implode(",", $selected_headers);
        }
        if (empty($selected_headers))
        {
            $headersss      = 'leads.id';
            $error['error'] = 'Please Select a Header.';
        }
        //print_r($selected_headers); die;
        if ((!empty($selected_headers)) && (!in_array("leads.id", $selected_headers)))
        {
            $IDs = "leads.id,";
        }

        $Days = $this->getBetweenDays($selected_from_date, $selected_to_date);

        $sqlPart = "
                FROM leads 
                LEFT JOIN users ON leads.assigned_user_id =users.id
                LEFT JOIN leads_cstm ON leads.id= leads_cstm.id_c
                LEFT JOIN te_ba_batch ON leads_cstm.te_ba_batch_id_c= te_ba_batch.id
                LEFT JOIN te_vendor on lower(leads.vendor)=lower(te_vendor.name)
                where leads.deleted=0  $wherecl  ";

        $countSql = "SELECT count(1) as count ". $sqlPart;
//        echo $countSql;

        $leadSql = "SELECT $IDs $headersss " . $sqlPart;

        if(!$_export) {
          $limit = $this->objPagination->get_limit();
          $leadSql .= ' ' . $limit;
        }
        $rowCount = 0;
        $leadObj = null;

//      if ($Days >= 0 && $Days <= 93 && $wherecl != '') {
        if($_export){
          $leadObj = $db->query($leadSql);
          $rowCount = $leadObj->num_rows;
          if($rowCount <= 0){
            $error['error'] = "No Data Found.";
          }
        }else {
          if ($this->objPagination->get_page() == 1 || !isset($_SESSION['_row_count'])) {
            $objLeadsCount = $db->query($countSql);
            $row = $db->fetchByAssoc($objLeadsCount);
            $rowCount = $row['count'];
            $_SESSION['_row_count'] = $rowCount;
          } else {
            $rowCount = $_SESSION['_row_count'];
          }
          $this->objPagination->set_total($rowCount);
          if ($rowCount <= 0) {
            $error['error'] = "No Data Found.";
          } else {
            $leadObj = $db->query($leadSql);
          }
        }
        
        if (empty($selected_headers))
        {
            $headersss      = 'leads.id';
            $error['error'] = 'Please Select a Header.';
        }
//        } else {
//          $error['error'] = 'Please Export Data between 3 months.';
//        }

        $ExcelHeaders        = array();
        $selected_headersKey = array();
        foreach ($selected_headers as $key => $val)
        {
            $ExcelHeaders[$val]        = $headers[$val];
            ($val == 'users.first_name as user_first_name') ? $val                       = '.user_first_name' : '';
            ($val == 'users.last_name as user_last_name') ? $val                       = '.user_last_name' : '';
            $selected_headersKey[$val] = substr($val, strpos($val, ".") + 1);
        }

        if ($_export && empty($error))
        {

            $file     = "HeaderWiseLead_report";
            $filename = $file . "_" . $from_date . "_" . $to_date;
            global $current_user;
            global $db;
//            $leadObj  = $db->query($leadSql);

            # Create heading
            $data = "";
            foreach ($ExcelHeaders as $key => $column)
            {
                $data .= $column . ",";
            }
            $data .= "\n";
          ob_end_clean();


            $leadCount    = $rowCount; //count($leadList);
            $userName     = $current_user->user_name;
            $userID       = $current_user->id;
            $ExportRecord = array('user_name' => $userName, 'user_id' => $userID, 'Lead_Count' => $leadCount, 'from_date' => $from_date, 'to_date' => $to_date, 'Headers' => array_values($ExcelHeaders),'selected_batch'=>$selected_batch,'selected_batch_code'=>$selected_batch_code,'selected_vendor'=>$selected_vendor,'selected_status'=>$selected_status,'selected_status_description'=>$selected_status_description);



            $sql = "insert into data_export_log set  source='Export tool',date_entered='" . date('Y-m-d H:i:s') . "',user_name='" . $userName . "',data_record='" . json_encode($ExportRecord) . "'";
            $db->query($sql);


            header("Content-type: application/csv");
            header('Content-disposition: attachment;filename=" ' . $filename . '.csv";');
            echo $data;
          while ($row = $db->fetchByAssoc($leadObj)){
//              $data='';
//            foreach ($selected_headersKey as $key1 => $column) {
//              $data .= $row[$column] . ",";
//            }
            $data = implode(',', $row);
            $data .= "\n";
            echo $data;
          }
//            echo $data;
            exit;
        } // End Of Export Func
        #PS @Pawan

        $page      = $this->objPagination->get_page();
        $last_page = $this->objPagination->get_last_page();
        $pagenext = $page + 1;
        $pageprevious = $page - 1;

        $right = $page < $last_page;
        $left = $page > 1;

        if(empty($error)) {
          while ($row = $db->fetchByAssoc($leadObj)) {
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
        $sugarSmarty->assign("lead_source_type", $lead_source);
        $sugarSmarty->assign("BatchListData", $BatchListData);
        $sugarSmarty->assign("ProgramListData", $ProgramListData);
        $sugarSmarty->assign("VendorListData", $VendorListData);
        $sugarSmarty->assign("StatusList", $StatusList);
        $sugarSmarty->assign("selected_batch", $selected_batch);
        $sugarSmarty->assign("selected_batch_code", $selected_batch_code);
        $sugarSmarty->assign("selected_from_date", $selected_from_date);
        $sugarSmarty->assign("selected_to_date", $selected_to_date);
        $sugarSmarty->assign("selected_vendor", $selected_vendor);
        $sugarSmarty->assign("selected_program", $selected_program);
        $sugarSmarty->assign("selected_headers", $selected_headers);
        $sugarSmarty->assign("selected_headersKey", $selected_headersKey);
        $sugarSmarty->assign("ExcelHeaders", $ExcelHeaders);


        $sugarSmarty->assign("selected_mobile", $selected_mobile);
        $sugarSmarty->assign("selected_email", $selected_email);
        $sugarSmarty->assign("selected_status", $selected_status);
        $sugarSmarty->assign("selected_status_description", $selected_status_description);
        $sugarSmarty->assign("selected_lead_source_types", $selected_lead_source_types);
        $sugarSmarty->assign("selected_source", $selected_source);
        $sugarSmarty->assign("selected_autoassign", $selected_autoassign);
        $sugarSmarty->assign("selected_ameyo_status", $selected_ameyo_status);
        $sugarSmarty->assign("selected_campaignIDs", $selected_campaignIDs);
        $sugarSmarty->assign("selected_leadIDs", $selected_leadIDs);
        $sugarSmarty->assign("StatusDetails", $StatusDetails);


        $sugarSmarty->assign("current_records", $current);
        $sugarSmarty->assign("page", $page);
        $sugarSmarty->assign("pagenext", $pagenext);
        $sugarSmarty->assign("pageprevious", $pageprevious);
        $sugarSmarty->assign("right", $right);
        $sugarSmarty->assign("left", $left);
        $sugarSmarty->assign("last_page", $last_page);
        $sugarSmarty->display('custom/modules/AOR_Reports/tpls/exportheaderwisereporttest.tpl');
    }

}
?>


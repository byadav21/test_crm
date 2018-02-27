<?php
// Date: Created on : 27th FEB 2018

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');

//error_reporting(-1);
//ini_set('display_errors', 'On');
class AOR_ReportsViewexportheaderwisereport extends SugarView
{

    var $report_to_id;
    var $counsellors_arr;

    public function __construct()
    {
        parent::SugarView();
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
        $vendorSql      = "SELECT id,name FROM te_vendor WHERE deleted=0";
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
        $batchSql     = "SELECT id,name,batch_code,d_campaign_id,d_lead_id FROM te_ba_batch WHERE batch_status='enrollment_in_progress' AND deleted=0";
        $batchObj     = $db->query($batchSql);
        $batchOptions = array();
        while ($row          = $db->fetchByAssoc($batchObj))
        {
            $batchOptions[] = $row;
        }
        return $batchOptions;
    }

    public function display()
    {

        global $sugar_config, $app_list_strings, $current_user, $db;

        $where           = "";
        $wherecl         = "";
        $campaignID      = array();
        $leadID          = array();
        $ProgramListData = $this->getProgram();
        $BatchListData   = $this->getBatch();
        $VendorListData  = $this->getVendors();

        foreach ($BatchListData as $val)
        {
            $d_campaign_id = $val['d_campaign_id'];

            if ($d_campaign_id != '')
            {
                $campaignID[$val['d_campaign_id']] = $val['d_campaign_id'];
                $leadID[$val['d_lead_id']]         = $val['d_lead_id'];
            }
        }



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
            $_SESSION['cccon_from_date']          = $_REQUEST['from_date'];
            $_SESSION['cccon_to_date']            = $_REQUEST['to_date'];
            $_SESSION['cccon_batch']              = $_REQUEST['batch'];
            $_SESSION['cccon_batch_code']         = $_REQUEST['batch_code'];
            $_SESSION['cccon_vendors']            = $_REQUEST['vendors'];
            $_SESSION['cccon_headers']            = $_REQUEST['headers'];
            $_SESSION['cccon_mobile']             = $_REQUEST['mobile'];
            $_SESSION['cccon_email']              = $_REQUEST['email'];
            $_SESSION['cccon_status']             = $_REQUEST['status'];
            $_SESSION['cccon_status_description'] = $_REQUEST['status_description'];
            $_SESSION['cccon_lead_source_types']  = $_REQUEST['lead_source_types'];
            $_SESSION['cccon_source']             = $_REQUEST['source'];
            $_SESSION['cccon_autoassign']         = $_REQUEST['autoassign'];
            $_SESSION['cccon_ameyo_status']       = $_REQUEST['ameyo_status'];
            $_SESSION['cccon_campaignIDs']        = $_REQUEST['campaignIDs'];
            $_SESSION['cccon_leadIDs']            = $_REQUEST['leadIDs'];
        }
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
        if (!empty($_SESSION['cccon_batch']))
        {
            $selected_batch = $_SESSION['cccon_batch'];
        }
        if (!empty($_SESSION['cccon_batch_code']))
        {
            $selected_batch_code = $_SESSION['cccon_batch_code'];
        }
        if (!empty($_SESSION['cccon_vendors']))
        {
            $selected_vendor = $_SESSION['cccon_vendors'];
        }
        if (!empty($_SESSION['cccon_program']))
        {
            $selected_program = $_SESSION['cccon_program'];
        }

        if (!empty($_SESSION['cccon_headers']))
        {
            $selected_headers = $_SESSION['cccon_headers'];
        }
        if (!empty($_SESSION['cccon_source']))
        {
            $selected_source = $_SESSION['cccon_source'];
        }

        $leadList   = array();
        $StatusList = array();

        if (!empty($selected_batch))
        {

            $wherecl .= " AND  te_ba_batch.id IN ('" . implode("','", $selected_batch) . "')";
        }
        if (!empty($selected_batch_code))
        {

            $wherecl .= " AND  te_ba_batch.id IN ('" . implode("','", $selected_batch_code) . "')";
        }

        if (!empty($selected_vendor))
        {

            $wherecl .= " AND  te_vendor.id IN ('" . implode("','", $selected_vendor) . "')";
        }

        //echo  "xx==".$_SESSION['cccon_mobile']; die;
        if ($_SESSION['cccon_mobile'] != "")
        {
            $selected_mobile = $_SESSION['cccon_mobile'];
            $wherecl         .= " AND (leads.phone_mobile='" . $_SESSION['cccon_mobile'] . "' || leads.phone_home='" . $_SESSION['cccon_mobile'] . "' "
                    . " || leads.phone_work='" . $_SESSION['cccon_mobile'] . "' || leads.phone_other='" . $_SESSION['cccon_mobile'] . "')";
        }

        if ($_SESSION['cccon_email'] != "")
        {
            $selected_email = $_SESSION['cccon_email'];
            $wherecl        .= " AND  ed.email_address ='" . $selected_email . "'";
        }

        if ($_SESSION['cccon_status'] != "")
        {
            $selected_status = $_SESSION['cccon_status'];
            $wherecl         .= " AND  leads.status ='" . $selected_status . "'";
        }
        if ($_SESSION['cccon_status_description'] != "")
        {
            $selected_status_description = $_SESSION['cccon_status_description'];
            $wherecl                     .= " AND  leads.status_description ='" . $selected_status_description . "'";
        }
        if ($_SESSION['cccon_lead_source_types'] != "")
        {
            $selected_lead_source_types = $_SESSION['cccon_lead_source_types'];
            $wherecl                    .= " AND  leads.lead_source_types ='" . $selected_lead_source_types . "'";
        }
        if (!empty($selected_source))
        {

            $wherecl .= " AND  leads.utm_source_c IN ('" . implode("','", $selected_source) . "')";
        }
        if ($_SESSION['cccon_autoassign'] != "")
        {
            $selected_autoassign = $_SESSION['cccon_autoassign'];
            $wherecl             .= " AND  leads.autoassign ='" . $selected_autoassign . "'";
        }
        if ($_SESSION['cccon_ameyo_status'] != "")
        {
            $selected_ameyo_status = $_SESSION['cccon_ameyo_status'];
            $wherecl               .= " AND  leads.neoxstatus ='" . $selected_ameyo_status . "'";
        }
        if ($_SESSION['cccon_campaignIDs'] != "")
        {
            $selected_campaignIDs = $_SESSION['cccon_campaignIDs'];
            $wherecl              .= " AND  leads.dristi_campagain_id ='" . $_SESSION['cccon_campaignIDs'] . "'";
        }
        if ($_SESSION['cccon_leadIDs'] != "")
        {
            $selected_leadIDs = $_SESSION['cccon_leadIDs'];
            $wherecl          .= " AND  leads.dristi_API_id ='" . $_SESSION['cccon_leadIDs'] . "'";
        }



        $lead_source        = $GLOBALS['app_list_strings']['lead_source_custom_dom'];
        $lead_source_custom = $GLOBALS['app_list_strings']['lead_source_custom_dom_type'];

        $headers = array(
            'leads.id'                            => 'ID',
            'leads.date_entered'                  => 'Date Entered',
            'leads.date_modified'                 => 'Date Modified',
            'leads.converted_date'                => 'Converted Date',
            'leads_cstm.temp_lead_date_c'         => 'Temp Lead Date',
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
            'ed.email_address'                    => 'Email Address',
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
            'leads.deleted'                       => 'Deleted');

        $StatusDetails = array(
            'Follow Up'              => 'Follow Up',
            'New Lead'               => 'New Lead',
            'Converted'              => 'Converted',
            'Dead Number'            => 'Converted Date',
            'Wrong Number'           => 'Wrong Number',
            'Ringing Multiple Times' => 'Ringing Multiple Times',
            'Not Enquired'           => 'Not Enquired',
            'Not Eligible'           => 'Not Eligible',
            'Fallout'                => 'Fallout',
            'Duplicate'              => 'Duplicate',
            'Dropout'                => 'Dropout',
            'Re-Enquired'            => 'Re-Enquired',
            'Prospect'               => 'Prospect',
            'Recycle'                => 'Recycle');

        $headersss = implode(",", $selected_headers);
        if (empty($headersss)){
        $headersss = 'leads.id';
        }
        if ((!empty($headersss)) && (!in_array("ID", $headersss))){
                $IDs = "leads.id,";
        }
        
        
        $leadSql   = "SELECT 
                       $IDs
                       $headersss
                FROM leads 
                LEFT JOIN users ON leads.assigned_user_id =users.id
                LEFT JOIN leads_cstm ON leads.id= leads_cstm.id_c
                LEFT JOIN te_ba_batch ON leads_cstm.te_ba_batch_id_c= te_ba_batch.id
                LEFT JOIN `email_addr_bean_rel` eabr ON  leads.id=eabr.bean_id
                LEFT JOIN `email_addresses` ed ON eabr.`email_address_id`=ed.id
                LEFT JOIN te_vendor on lower(leads.vendor)=lower(te_vendor.name)
                where 1=1 $wherecl  ";

        //echo ($leadSql);
        $ExcelHeaders        = array();
        $selected_headersKey = array();
        foreach ($selected_headers as $key => $val)
        {


            $ExcelHeaders[$val]        = $headers[$val];
            ($val == 'users.first_name as user_first_name') ? $val                       = '.user_first_name' : '';
            ($val == 'users.last_name as user_last_name') ? $val                       = '.user_last_name' : '';
            $selected_headersKey[$val] = substr($val, strpos($val, ".") + 1);
        }
        //print_r($ExcelHeaders); die;

        $leadObj = $db->query($leadSql) or die(mysqli_error());

       
        while ($row = $db->fetchByAssoc($leadObj))
        {
            $leadList[$row['id']] = $row;
        }
        
        if (isset($_POST['export']) && $_POST['export'] == "Export")
        {   
            
            $file     = "HeaderWiseLead_report";
            $where    = '';
            $filename = $file . "_" . $from_date . "_" . $to_date;

            $leadObj      = $db->query($leadSql);

       
                while ($row          = $db->fetchByAssoc($leadObj))
                {
                  $leadList[$row['id']] = $row;
                }


          
            # Create heading
            $data = "";
            foreach ($ExcelHeaders as $key => $column)
            {
                $data .=   $column.",";
            }
            $data .= "\n";




            foreach ($leadList as $key => $value)
            {
                
               
                foreach ($selected_headersKey as $key1 => $column)
                {
                    
                    $data      .= $value[$column]."," ;
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

        $sugarSmarty->assign("leadList", $leadList);
        $sugarSmarty->assign("headers", $headers);

        $sugarSmarty->assign("campaignIDs", $campaignID);
        $sugarSmarty->assign("leadIDs", $leadID);
        $sugarSmarty->assign("lead_source_type", $lead_source);
        $sugarSmarty->assign("BatchListData", $BatchListData);
        $sugarSmarty->assign("ProgramListData", $ProgramListData);
        $sugarSmarty->assign("VendorListData", $VendorListData);
        $sugarSmarty->assign("StatusList", $StatusList);
        $sugarSmarty->assign("selected_batch", $selected_batch);
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
        $sugarSmarty->assign("right", $right);
        $sugarSmarty->assign("left", $left);
        $sugarSmarty->assign("last_page", $last_page);
        $sugarSmarty->display('custom/modules/AOR_Reports/tpls/exportheaderwisereport.tpl');
    }

}
?>


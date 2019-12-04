<?php

// Last modified on:  03th APP 2019

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');
require_once('custom/modules/AOR_Reports/pagination.php');
require_once('custom/modules/AOR_Reports/UserInput.php');

///error_reporting(-1);
//ini_set('display_errors', 'On');
//ini_set('memory_limit', '-1');

class AOR_ReportsViewsrmstudentlist extends SugarView
{

    var $report_to_id;
    var $counsellors_arr;
    private $objPagination;
    private $_objInputs;

    public function __construct()
    {
        parent::SugarView();
        $this->objPagination = new pagination(60, 'page');
        $this->_objInputs    = new UserInput();
        $this->_objInputs->syncSessions('srmstudentlist');
    }

    function statusHeader()
    {
        $headerArr = array();

        $headerArr = array(
            'Customer_name'  => 'Customer Name',
            'email_add_c'    => 'Email',
            'phone_mobile'   => 'Mobile',
            'institute_name' => 'Institute Name',
            'batch_name'     => 'Batch Name',
            'batch_status'   => 'Batch Status',
            'dropout_type'   => 'Dropout Type',
            //'fee_inr'        => 'Fee',
            'name'           => 'Vendor',
            'batch_code'     => 'Batch Code',
            'student_status' => 'Student Status',
            'dropout_status' => 'Dropout Status',
            'bt_pre_dropped' => 'BT Pre Dropped'
        
        );

        return $headerArr;
    }

    function getBetweenDays($fromData, $toDate)
    {

        $fromData   = strtotime($fromData);
        $toDate     = strtotime($toDate);
        $difference = $toDate - $fromData;
        $days       = floor($difference / (60 * 60 * 24));
        return $days;
    }

    function getInstitutesDdown()
    {
        global $db;
        $batchSql     = "select id,name from te_in_institutes where deleted=0 order by name";
        $batchObj     = $db->query($batchSql);
        $batchOptions = array();
        while ($row          = $db->fetchByAssoc($batchObj))
        {
            $batchOptions[] = $row;
        }
        return $batchOptions;
    }
    
     function getProgramsDdown()
        {
            global $db;
            $batchSql     = "select id,name from te_pr_programs where deleted=0 order by name";
            $batchObj     = $db->query($batchSql);
            $batchOptions = array();
            while ($row          = $db->fetchByAssoc($batchObj))
            {
                $batchOptions[] = $row;
            }
            return $batchOptions;
        }
    
     function getBatchsDdown()
        {
            global $db;
            $batchSql     = "select id,name,batch_code from te_ba_batch where deleted=0 order by name";
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
        $current_user_id       = $current_user->id;
        $current_user_is_admin = $current_user->is_admin;
        $_export               = isset($this->_objInputs->post['export']) && $this->_objInputs->post['export'] == "Export";

        $report_action = '';
        $reportAccess  = reportAccessLog();

        $current_user_id = $current_user->id;
        $report_action   = isset($GLOBALS['action']) ? $GLOBALS['action'] : '';


        /*if (!in_array($current_user->id, isset($reportAccess[$report_action])? $reportAccess[$report_action]: array()) && ($current_user->is_admin != 1))
        {
            echo 'You are not authorized to access!';
            return;
        }*/




        $where            = "";
        $wherecl          = "";
        $selected_vendors = "";
        $programList      = array();
        $StatusList       = array();
        $leadList         = array();








        $selected_from_date = $this->_objInputs->getVal('from_date', 'post', date('Y-m-d', strtotime('-1 days')));
        $selected_to_date   = $this->_objInputs->getVal('to_date', 'post', date('Y-m-d', strtotime('-1 days')));



        $selected_institute = $this->_objInputs->getVal('institute_dropdown', 'post', array());

        $selected_program = $this->_objInputs->getVal('program_dropdown', 'post', array());
        $selected_batch   = $this->_objInputs->getVal('batch_dropdown', 'post', array());

        $selected_student_status_dropdown = $this->_objInputs->getVal('student_status_dropdown', 'post', array());
        $selected_dropout_type_dropdown   = $this->_objInputs->getVal('dropout_type_dropdown', 'post', array());
        $selected_student_name            = $this->_objInputs->getVal('student_name', 'post', array());
        $selected_student_email           = $this->_objInputs->getVal('student_email', 'post', array());
        $selected_student_mobile          = $this->_objInputs->getVal('student_mobile', 'post', array());
        $selected_bt_pre_dropped          = $this->_objInputs->getVal('bt_pre_dropped', 'post', array());
        


        $error = array();
        $Days  = $this->getBetweenDays($selected_from_date, $selected_to_date);

        if ($Days >= 31)
        {

            $error['error'] = 'Only one month of data are allowed to export.';
        }
        //echo '$Days=='.$Days; 


        $statusHeader         = $this->statusHeader();
        $getInstituteDropData = $this->getInstitutesDdown();
        
        $getProgramsDown      = $this->getProgramsDdown();
        $getBatchsDown        = $this->getBatchsDdown();
        





        if (!empty($selected_institute))
        {

            $wherecl .= " AND  inst.id='$selected_institute' ";
        }


        if (!empty($selected_program))
        {

            $wherecl .= " AND  p.id='$selected_program' ";
        }

        if (!empty($selected_batch))
        {

            $wherecl .= " AND  b.id='$selected_batch' ";
        }


        if (!empty($selected_student_status_dropdown))
        {

            $wherecl .= " AND  sb.status='$selected_student_status_dropdown' ";
        }

        if (!empty($selected_dropout_type_dropdown))
        {

            $wherecl .= " AND  sb.dropout_type ='$selected_dropout_type_dropdown' ";
        }

        if (!empty($selected_student_name))
        {
            $trimed_name= trim($selected_student_name);
            $wherecl .= " AND  (leads.first_name like '%$trimed_name%' || leads.last_name like '%$trimed_name%') ";
        }

        if (!empty($selected_student_email))
        {   
            $trimed_email= trim($selected_student_email);
            $wherecl .= " AND leads_cstm.email_add_c like '%$trimed_email%' ";
        }

        if (!empty($selected_student_mobile))
        {
            $trimed_mobile= trim($selected_student_mobile);
            $wherecl .= " AND  leads.phone_mobile like '%$trimed_mobile%' ";
        }
         if (!empty($selected_bt_pre_dropped))
        {

            $wherecl .= " AND  sb.bt_pre_dropped ='$selected_bt_pre_dropped' ";
        }



        //echo '$selected_bt_pre_dropped=='.$selected_bt_pre_dropped;die;

        $headers = array(
            'concat(IFNULL(leads.first_name,"")," ",IFNULL(leads.last_name,"")) as Customer_name' => 'Customer_name',
            'leads_cstm.email_add_c'                                                              => 'email_add_c',
            'leads.phone_mobile'                                                                  => 'phone_mobile',
            'inst.name institute_name'                                                            => 'institute_name',
            'b.name batch_name'                                                                   => 'batch_name',
            'b.batch_status'                                                                      => 'batch_status',
            'sb.dropout_type'                                                                     => 'dropout_type',
            //'sum(CASE WHEN (sb.status)= "Active" THEN (sp.amount) ELSE 0 END) AS fee_inr'         => 'fee_inr',
            'v.name'                                                                              => 'vendor_name',
            'b.batch_code'                                                                        => 'batch_code',
            'sb.status student_status'                                                            => 'student_status',
            'sb.dropout_status'                                                                   => 'dropout_status',
            'sb.bt_pre_dropped'                                                                   => 'bt_pre_dropped'
          
        );


        $headersss = implode(', ', array_keys($headers));


///wwww
        $sqlPart = " 
                        
                        from te_student_batch as sb
                        left join te_in_institutes as inst on sb.te_in_institutes_id_c=inst.id
                        left join te_vendor as v on sb.te_vendor_id_c=v.id
                        left join te_ba_batch b on sb.te_ba_batch_id_c=b.id
                        left join te_pr_programs AS p ON p.id=sb.te_pr_programs_id_c
                        left join leads on sb.leads_id=leads.id 
                        left join leads_cstm on leads.id=leads_cstm.id_c
                        
                        where sb.deleted=0
                        and inst.deleted=0
                        and b.deleted=0
                        $wherecl
                        and leads.deleted=0 
                        
                        order by leads_cstm.email_add_c, sb.date_entered desc ";

        $countSql = "SELECT count(1) as count " . $sqlPart;


        $leadSql = "SELECT  $headersss " . $sqlPart;

        //echo $countSql;
        //die($leadSql);
        if (!$_export)
        {
            $limit   = $this->objPagination->get_limit();
            $leadSql .= ' ' . $limit;
        }
        $rowCount = 0;
        $leadObj  = null;

        if (empty($error))
        {
            if ($_export && empty($error))
            {
                $leadObj  = $db->query($leadSql);
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
                    //echo '<pre>';die($leadSql);
                    $leadObj = $db->query($leadSql);
                }
            }
            //print_r($leadObj);



            $StatusList = $statusHeader;
        }// checking error end if line no. 226
        // echo "<pre>";print_r($programList);exit();


        if ($_export && empty($error))
        {

            $file     = "srmsutdentlist_report";
            $filename = $file . "_" . $from_date . "_" . $to_date;
            global $current_user;
            global $db;
//            $leadObj  = $db->query($leadSql);
            # Create heading
            $data     = "";
            foreach ($StatusList as $key => $column)
            {
                $data .= $column . ",";
            }
            $data .= "\n";
            ob_end_clean();


            $leadCount = $rowCount; //count($leadList);

            header("Content-type: application/csv");
            header('Content-disposition: attachment;filename=" ' . $filename . '.csv";');
            echo $data;
            while ($row = $db->fetchByAssoc($leadObj))
            {

                $data = implode(',', $row);
                $data .= "\n";
                echo $data;
            }

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
                $leadList[] = $row;
            }
            $this->objPagination->set_found_rows(count($leadList));
        }
        $current = $this->objPagination->getHeading();

        #pE
        //echo '<pre>';print_r($leadList);

        $sugarSmarty = new Sugar_Smarty();

        $sugarSmarty->assign("error", $error);

        $sugarSmarty->assign("headers", $headers);
        $sugarSmarty->assign("tablewidth", count($headers) * 130);

        
        $sugarSmarty->assign("StatusList", $StatusList);
        $sugarSmarty->assign("leadList", $leadList);
        //$sugarSmarty->assign("selected_batch_code", $selected_batch_code);
        //$sugarSmarty->assign("selected_status", $selected_status);
        $sugarSmarty->assign("selected_batch", $selected_batch);
        $sugarSmarty->assign("selected_from_date", $selected_from_date);
        $sugarSmarty->assign("selected_to_date", $selected_to_date);
        $sugarSmarty->assign("selected_vendor", $selected_vendors);
        $sugarSmarty->assign("getInstituteDropData", $getInstituteDropData);
        
        
        $sugarSmarty->assign("getProgramsDown", $getProgramsDown);
        $sugarSmarty->assign("getBatchsDown",$getBatchsDown);
        
        
        $sugarSmarty->assign("selected_institute", $selected_institute);
        $sugarSmarty->assign("selected_program", $selected_program);
        $sugarSmarty->assign("selected_batch", $selected_batch);
        $sugarSmarty->assign("selected_student_status_dropdown", $selected_student_status_dropdown);
        $sugarSmarty->assign("selected_dropout_type_dropdown", $selected_dropout_type_dropdown);
        $sugarSmarty->assign("selected_student_name", $selected_student_name);
        $sugarSmarty->assign("selected_student_email", $selected_student_email);
        $sugarSmarty->assign("selected_student_mobile", $selected_student_mobile);
        $sugarSmarty->assign("selected_bt_pre_dropped", $selected_bt_pre_dropped);


        

        $sugarSmarty->assign("current_records", $current);
        $sugarSmarty->assign("page", $page);
        $sugarSmarty->assign("pagenext", $pagenext);
        $sugarSmarty->assign("pageprevious", $pageprevious);
        $sugarSmarty->assign("right", $right);
        $sugarSmarty->assign("left", $left);
        $sugarSmarty->assign("last_page", $last_page);
        $sugarSmarty->display('custom/modules/AOR_Reports/tpls/srmstudentlist.tpl');
    }

}
?>


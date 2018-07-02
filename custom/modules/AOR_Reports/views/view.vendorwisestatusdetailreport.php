<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');

//error_reporting(-1);
//ini_set('display_errors', 'On');
class AOR_ReportsViewVendorwisestatusdetailreport extends SugarView
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
        $batchSql     = "SELECT id,name,batch_code FROM te_ba_batch WHERE batch_status='enrollment_in_progress' AND deleted=0";
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

        //echo '<pre>';print_r($current_user); die;
        $vendorID   = $current_user->te_vendor_users_1te_vendor_ida;
        $vendorName = $current_user->te_vendor_users_1_name;
        $is_Vendor  = 0;
        if ($vendorID != '' && $vendorName != '')
        {
            $is_Vendor = 1;
        }
        
        
        $UsersVendrArr = array(
            'e7c007d2-5ca7-57e5-64ba-5b23a435c4b7' => 'ileap',
            'b28d0f4a-b486-731e-2781-5b23a41da9cf' => 'TBS',
            'b80c8a52-5174-3d92-feae-5b23a453bbcf' => 'iimjobs',
            'ca7ed5d5-daaf-7bf9-110e-5b23a58965dd' => 'CiteHR',
            '3d29ebfb-23a7-ea3e-b4d8-5b23a590f80f' => 'Career360',
            '36990877-a094-db61-6610-5b20f95a6e6e' => 'Infoedge');
         
        
        /*
        $UsersVendrArr = array(
            '29a6c441-8c9c-a49a-a28e-5b234fa1ecf9' => 'ileap',
            '1cbd38c1-2a63-3ab8-a85c-5b234febc8a4' => 'TBS',
            '93e39ed4-487b-e35c-62bc-5b234f7cd078' => 'iimjobs',
            'e86be88c-3f72-3211-a058-5b2350c211cd' => 'CiteHR',
            'b27c5fd1-f781-bcab-a7e5-5b2350b22896' => 'Career360',
            '87d1f4da-c6c9-81fe-944a-5b1fb537fc1c' => 'Infoedge');
         
         */

        $vendorsIdArr = array(
            'ileap'=>'4a9e16bf-0396-fffc-b848-5b084550f2a8',
            'TBS'=>'abe14a6c-00cb-13d6-2e2e-590d6f806ff4',
            'iimjobs'=>'ee1d169a-ca0c-f3fe-d6d6-590d636bc19b',
            'CiteHR'=>'14a4e733-b709-8c60-7731-590d5cb3b1f7',
            'Career360'=>'71a590a5-0616-44d3-5248-590d5b158460',
            'Infoedge'=>'92f19224-b7b2-68e2-a112-590d64d59115');

        $where           = "";
        $wherecl         = "";
        $ProgramListData = $this->getProgram();
        $BatchListData   = $this->getBatch();
        $VendorListData  = $this->getVendors();

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
            $_SESSION['cccon_from_date']  = $_REQUEST['from_date'];
            $_SESSION['cccon_to_date']    = $_REQUEST['to_date'];
            $_SESSION['cccon_batch']      = $_REQUEST['batch'];
            $_SESSION['cccon_batch_code'] = $_REQUEST['batch_code'];
            $_SESSION['cccon_vendors']    = $_REQUEST['vendors'];
            $_SESSION['cccon_program']    = $_REQUEST['program'];
        }
        if ($_SESSION['cccon_from_date'] != "" && $_SESSION['cccon_to_date'] != "")
        {
            $selected_from_date = $_SESSION['cccon_from_date'];
            $selected_to_date   = $_SESSION['cccon_to_date'];
            $from_date          = date('Y-m-d', strtotime(str_replace('/', '-', $_SESSION['cccon_from_date'])));
            $to_date            = date('Y-m-d', strtotime(str_replace('/', '-', $_SESSION['cccon_to_date'])));
            $wherecl            .= " AND DATE(l.date_entered)>='" . $from_date . "' AND DATE(l.date_entered)<='" . $to_date . "'";
        }
        elseif ($_SESSION['cccon_from_date'] != "" && $_SESSION['cccon_to_date'] == "")
        {
            $selected_from_date = $_SESSION['cccon_from_date'];
            $from_date          = date('Y-m-d', strtotime(str_replace('/', '-', $_SESSION['cccon_from_date'])));
            $wherecl            .= " AND DATE(l.date_entered)>='" . $from_date . "' ";
        }
        elseif ($_SESSION['cccon_from_date'] == "" && $_SESSION['cccon_to_date'] != "")
        {
            $selected_to_date = $_SESSION['cccon_to_date'];
            $to_date          = date('Y-m-d', strtotime(str_replace('/', '-', $_SESSION['cccon_to_date'])));
            $wherecl          .= " AND DATE(l.date_entered)<='" . $to_date . "' ";
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

        $programList = array();
        $StatusList  = array();

        if (!empty($selected_batch))
        {

            $wherecl .= " AND  te_ba_batch.id IN ('" . implode("','", $selected_batch) . "')";
        }
        if (!empty($selected_batch_code))
        {

            $wherecl .= " AND  te_ba_batch.id IN ('" . implode("','", $selected_batch_code) . "')";
        }

     
        
        if (isset($UsersVendrArr[$current_user->id]) && $UsersVendrArr[$current_user->id] == 'Infoedge')
        {
            $selected_vendor = array($vendorsIdArr['Infoedge']);
            $VendorListData  = array(array('id' => $vendorsIdArr['Infoedge'], 'name' => 'Infoedge'));
        }
        if (isset($UsersVendrArr[$current_user->id]) && $UsersVendrArr[$current_user->id] == 'Career360')
        {
            $selected_vendor = array($vendorsIdArr['Career360']);
            $VendorListData  = array(array('id' => $vendorsIdArr['Career360'], 'name' => 'Career360'));
        }
        if (isset($UsersVendrArr[$current_user->id]) && $UsersVendrArr[$current_user->id] == 'CiteHR')
        {
            $selected_vendor = array($vendorsIdArr['CiteHR']);
            $VendorListData  = array(array('id' => $vendorsIdArr['CiteHR'], 'name' => 'CiteHR'));
        }
        if (isset($UsersVendrArr[$current_user->id]) && $UsersVendrArr[$current_user->id] == 'iimjobs')
        {
            $selected_vendor = array($vendorsIdArr['iimjobs']);
            $VendorListData  = array(array('id' => $vendorsIdArr['iimjobs'], 'name' => 'iimjobs'));
        }
        if (isset($UsersVendrArr[$current_user->id]) && $UsersVendrArr[$current_user->id] == 'TBS')
        {
            $selected_vendor = array($vendorsIdArr['TBS']);
            $VendorListData  = array(array('id' => $vendorsIdArr['TBS'], 'name' => 'TBS'));
        }
        if (isset($UsersVendrArr[$current_user->id]) && $UsersVendrArr[$current_user->id] == 'ileap')
        {
            $selected_vendor = array($vendorsIdArr['ileap']);
            $VendorListData  = array(array('id' => $vendorsIdArr['ileap'], 'name' => 'ileap'));
        }

        if (!empty($selected_vendor))
        {

            $wherecl .= " AND  te_vendor.id IN ('" . implode("','", $selected_vendor) . "')";
        }
        if (!empty($selected_program))
        {

            $wherecl .= " AND  p.id IN ('" . implode("','", $selected_program) . "')";
        }
//		$StatusList['new_lead']     = 'New Lead';
//		$StatusList['follow_up']     = 'Follow-Up';
//		$StatusList['call_back']     = 'Call-back';
//		$StatusList['dead_number']     = 'Dead Number';
//		$StatusList['fallout']     = 'Fallout';
//		$StatusList['not_eligible']     = 'Not Eligible';
//		$StatusList['not_enquired']     = 'Not Enquired';
//		$StatusList['retired']     = 'Retired';
//		$StatusList['ringing_multiple_times']     = 'Ringing Multiple Times';
//		$StatusList['wrong_number']     = 'Wrong Number';
//		$StatusList['converted']     = 'Converted';
//		$StatusList['prospect']     = 'Prospect';
//		$StatusList['re_enquired']     = 'Re-Enquired';
//		$StatusList['recycle']     = 'Recycle';
//		$StatusList['dropout']     = 'Dropout';
//		$StatusList['duplicate']     = 'Duplicate';
//		$StatusList['na']     = 'NA';

        if (isset($_POST['export']) && $_POST['export'] == "Export")
        {



            $file     = "VendorWiseStatusDetail_report";
            $where    = '';
            $filename = $file . "_" . $from_date . "_" . $to_date;

            echo $leadSql = "SELECT COUNT(l.id) AS lead_count,
                    l.date_entered,
                    te_ba_batch.id AS batch_id,
                    #p.name program_name,
                    te_ba_batch.name AS batch_name,
                    te_ba_batch.batch_code,
                    l.status,
                    l.vendor,
                    te_vendor.id vendor_id,
                    l.status_description
                FROM leads l
                INNER JOIN leads_cstm AS lc ON l.id=lc.id_c
                LEFT JOIN te_ba_batch ON lc.te_ba_batch_id_c = te_ba_batch.id
                LEFT JOIN te_vendor on lower(l.vendor)=lower(te_vendor.name)
                #LEFT JOIN te_pr_programs_te_ba_batch_1_c AS bpr ON bpr.te_pr_programs_te_ba_batch_1te_ba_batch_idb=te_ba_batch.id
                #LEFT JOIN te_pr_programs as p ON p.id=bpr.te_pr_programs_te_ba_batch_1te_pr_programs_ida
                 WHERE l.deleted=0
                   $wherecl
              GROUP BY l.status_description,te_vendor.id,te_ba_batch.batch_code order by  te_ba_batch.batch_code  ";
            //echo $leadSql;exit();


            $leadObj = $db->query($leadSql);


            $vendor = 'NULL';

            while ($row = $db->fetchByAssoc($leadObj))
            {
                if ($row['vendor'] == '')
                {
                    $row['vendor'] = $vendor;
                }



                $programList[strtolower($row['vendor']) . '_BATCH_' . $row['batch_id']]['batch_id']           = $row['batch_id'];
                //$programList[strtolower($row['vendor']) .'_BATCH_'.$row['batch_id']]['program_name'] = $row['program_name'];
                $programList[strtolower($row['vendor']) . '_BATCH_' . $row['batch_id']]['batch_name']         = isset($row['batch_name']) ? $row['batch_name'] : 'NULL';
                $programList[strtolower($row['vendor']) . '_BATCH_' . $row['batch_id']]['batch_code']         = isset($row['batch_code']) ? $row['batch_code'] : 'NULL';
                $programList[strtolower($row['vendor']) . '_BATCH_' . $row['batch_id']]['vendor']             = isset($row['vendor']) ? $row['vendor'] : 'NULL';
                $programList[strtolower($row['vendor']) . '_BATCH_' . $row['batch_id']]['lead_count']         = $row['lead_count'];
                $programList[strtolower($row['vendor']) . '_BATCH_' . $row['batch_id']]['status_description'] = $row['status_description'];

                $programList[strtolower($row['vendor']) . '_BATCH_' . $row['batch_id']][strtolower(str_replace(array(' ', '-'), '_', $row['status_description']))] = $row['lead_count'];

                $StatusList[strtolower(str_replace(array(' ', '-'), '_', $row['status_description']))] = $row['status_description'];
            }

            //echo "<pre>";
            //print_r($StatusList); die;
            # Create heading
            //$data = "Programme Name";
            $data .= "Batch Name";
            $data .= ",Batch Code";
            $data .= ",Vendor";
            foreach ($StatusList as $key => $statusVal)
            {
                $data .= "," . $key;
            }
            $data .= ",Total";
            $data .= "\n";



            //echo "<pre>";print_r($programList);exit();
            foreach ($programList as $key => $councelor)
            {
                //$data .= "\"" . $councelor['program_name'];
                $data .= "\"" . $councelor['batch_name'];
                $data .= "\",\"" . $councelor['batch_code'];
                $data .= "\",\"" . $councelor['vendor'];
                $toal = 0;
                foreach ($StatusList as $key1 => $value)
                {
                    $countedLead = (!empty($programList[$key][$key1]) ? $programList[$key][$key1] : 0);
                    $data        .= "\",\"" . $countedLead;
                    $toal        += $countedLead;
                }
                $data .= "\",\"" . $toal;
                $data .= "\"\n";
            }

            ob_end_clean();
            header("Content-type: application/csv");
            header('Content-disposition: attachment;filename=" ' . $filename . '.csv";');
            echo $data;
            exit;
        } // End Of Export Func








        $leadSql = "SELECT COUNT(l.id) AS lead_count,
                    l.date_entered,
                    te_ba_batch.id AS batch_id,
                    #p.name program_name,
                    te_ba_batch.name AS batch_name,
                    te_ba_batch.batch_code,
                    l.status,
                    l.vendor,
                    te_vendor.id vendor_id,
                    l.status_description
                FROM leads l
                INNER JOIN leads_cstm AS lc ON l.id=lc.id_c
                LEFT JOIN te_ba_batch ON lc.te_ba_batch_id_c = te_ba_batch.id
                LEFT JOIN te_vendor on lower(l.vendor)=lower(te_vendor.name)
                #LEFT JOIN te_pr_programs_te_ba_batch_1_c AS bpr ON bpr.te_pr_programs_te_ba_batch_1te_ba_batch_idb=te_ba_batch.id
                #LEFT JOIN te_pr_programs as p ON p.id=bpr.te_pr_programs_te_ba_batch_1te_pr_programs_ida
                 WHERE l.deleted=0
                   $wherecl
              GROUP BY l.status_description,te_vendor.id,te_ba_batch.batch_code order by  te_ba_batch.batch_code ";
        //echo $leadSql;exit();


        $leadObj = $db->query($leadSql);

        $vendor = 'NULL';

        while ($row = $db->fetchByAssoc($leadObj))
        {
            if ($row['vendor'] == '')
            {
                $row['vendor'] = $vendor;
            }

            $programList[strtolower($row['vendor']) . '_BATCH_' . $row['batch_id']]['batch_id']           = $row['batch_id'];
            //$programList[strtolower($row['vendor']) .'_BATCH_'.$row['batch_id']]['program_name'] = $row['program_name'];
            $programList[strtolower($row['vendor']) . '_BATCH_' . $row['batch_id']]['batch_name']         = isset($row['batch_name']) ? $row['batch_name'] : 'NULL';
            $programList[strtolower($row['vendor']) . '_BATCH_' . $row['batch_id']]['batch_code']         = isset($row['batch_code']) ? $row['batch_code'] : 'NULL';
            $programList[strtolower($row['vendor']) . '_BATCH_' . $row['batch_id']]['vendor']             = isset($row['vendor']) ? $row['vendor'] : 'NULL';
            $programList[strtolower($row['vendor']) . '_BATCH_' . $row['batch_id']]['lead_count']         = $row['lead_count'];
            $programList[strtolower($row['vendor']) . '_BATCH_' . $row['batch_id']]['status_description'] = $row['status_description'];

            $programList[strtolower($row['vendor']) . '_BATCH_' . $row['batch_id']][strtolower(str_replace(array(' ', '-'), '_', $row['status_description']))] = $row['lead_count'];

            $StatusList[strtolower(str_replace(array(' ', '-'), '_', $row['status_description']))] = $row['status_description'];
        }



        //echo '<pre>';
        //print_r($StatusList); die;
        #PS @Pawan
        $total     = count($programList); #total records
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

        $programList = array_slice($programList, $start, $per_page);
        if ($total > $per_page)
        {
            $current = "(" . ($start + 1) . "-" . ($start + $per_page) . " of " . $total . ")";
        }
        else
        {
            $current = "(" . ($start + 1) . "-" . count($programList) . " of " . $total . ")";
        }
        #pE

        $sugarSmarty = new Sugar_Smarty();

        $sugarSmarty->assign("programList", $programList);


        $sugarSmarty->assign("BatchListData", $BatchListData);
        $sugarSmarty->assign("ProgramListData", $ProgramListData);
        $sugarSmarty->assign("VendorListData", $VendorListData);
        $sugarSmarty->assign("StatusList", $StatusList);
        $sugarSmarty->assign("selected_batch", $selected_batch);
        $sugarSmarty->assign("selected_from_date", $selected_from_date);
        $sugarSmarty->assign("selected_to_date", $selected_to_date);
        $sugarSmarty->assign("selected_vendor", $selected_vendor);
        $sugarSmarty->assign("selected_program", $selected_program);

        $sugarSmarty->assign("current_records", $current);
        $sugarSmarty->assign("page", $page);
        $sugarSmarty->assign("pagenext", $pagenext);
        $sugarSmarty->assign("right", $right);
        $sugarSmarty->assign("left", $left);
        $sugarSmarty->assign("last_page", $last_page);
        $sugarSmarty->display('custom/modules/AOR_Reports/tpls/vendorwisestatusdetailreport.tpl');
    }

}

?>

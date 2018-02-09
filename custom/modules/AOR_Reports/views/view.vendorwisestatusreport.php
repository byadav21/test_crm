<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');

//error_reporting(-1);
//ini_set('display_errors', 'On');
class AOR_ReportsViewVendorwisestatusreport extends SugarView
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
        $vendorSql      = "SELECT id,name FROM te_vendor WHERE deleted=0";
        $vendor_Obj     = $db->query($vendorSql);
        $vendor_Options = array();
        while ($row            = $db->fetchByAssoc($vendor_Obj))
        {
            $vendor_Options[] = $row;
        }
        return $vendor_Options;
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

        $where             = "";
        $wherecl           = "";
        $BatchListData     = $this->getBatch();
        $ProgrammeListData = $this->getProgram();
        $VendorListData    = $this->getVendors();

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
            $_SESSION['cccon_program']    = $_REQUEST['program'];
            $_SESSION['cccon_from_date']  = $_REQUEST['from_date'];
            $_SESSION['cccon_to_date']    = $_REQUEST['to_date'];
            $_SESSION['cccon_counsellor'] = $_REQUEST['counsellor'];
            $_SESSION['cccon_batch']      = $_REQUEST['batch'];
            $_SESSION['cccon_batch_code'] = $_REQUEST['batch_code'];
            $_SESSION['cccon_vendors']    = $_REQUEST['vendors'];
            $_SESSION['cccon_medium_val'] = $_REQUEST['medium_val'];
            $_SESSION['cccon_status']     = $_REQUEST['status'];
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
        if (!empty($_SESSION['cccon_status']))
        {
            $selected_status = $_SESSION['cccon_status'];
        }
        if (!empty($_SESSION['cccon_program']))
        {
            $selected_program = $_SESSION['cccon_program'];
        }
        $findBatch = array();
        if (!empty($_SESSION['cccon_batch']))
        {
            $selected_batch = $_SESSION['cccon_batch'];
            //$batches        = $this->getBatch($_SESSION['cccon_batch']);
        }
        if (!empty($_SESSION['cccon_batch_code']))
        {
            $selected_batch_code = $_SESSION['cccon_batch_code'];
            //$batches        = $this->getBatch($_SESSION['cccon_batch']);
        }
        if (!empty($_SESSION['cccon_vendors']))
        {
            $selected_vendor = $_SESSION['cccon_vendors'];
        }

        $programList = array();
        $StatusList  = array();

        if (!empty($selected_program))
        {

            $wherecl .= " AND  p.id IN ('" . implode("','", $selected_program) . "')";
        }
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

        if (isset($_POST['export']) && $_POST['export'] == "Export")
        {



            $file     = "VendorWiseStatus_report";
            $where    = '';
            $filename = $file . "_" . $from_date . "_" . $to_date;

            $leadSql = "SELECT COUNT(l.id) AS lead_count,
                    l.date_entered,
                    te_ba_batch.id AS batch_id,
                    p.name program_name,
                    te_ba_batch.name AS batch_name,
                    te_ba_batch.batch_code,
                    l.status,
                    l.vendor,
                    te_vendor.id vendor_id
                FROM leads l
                INNER JOIN leads_cstm AS lc ON l.id=lc.id_c
                LEFT JOIN te_ba_batch ON lc.te_ba_batch_id_c = te_ba_batch.id
                LEFT JOIN te_vendor on lower(l.vendor)=lower(te_vendor.name)
                LEFT JOIN te_pr_programs_te_ba_batch_1_c AS bpr ON bpr.te_pr_programs_te_ba_batch_1te_ba_batch_idb=te_ba_batch.id
                LEFT JOIN te_pr_programs as p ON p.id=bpr.te_pr_programs_te_ba_batch_1te_pr_programs_ida
                 WHERE l.deleted=0
                   $wherecl
              GROUP BY l.status,te_vendor.id,te_ba_batch.batch_code order by  te_ba_batch.batch_code ";
            //echo $leadSql;exit();


            $leadObj = $db->query($leadSql);


            $vendor = 'NULL';

            while ($row = $db->fetchByAssoc($leadObj))
            {
                if ($row['vendor'] == '')
                {
                    $row['vendor'] = $vendor;
                }
              
            $programList[strtolower($row['vendor']) . '_BATCH_' . $row['batch_id']]['batch_id']     = $row['batch_id'];
            $programList[strtolower($row['vendor']) . '_BATCH_' . $row['batch_id']]['batch_name']   = isset($row['batch_name']) ? $row['batch_name'] : 'NULL';
            $programList[strtolower($row['vendor']) . '_BATCH_' . $row['batch_id']]['program_name'] = isset($row['program_name']) ? $row['program_name'] : 'NULL';
            $programList[strtolower($row['vendor']) . '_BATCH_' . $row['batch_id']]['batch_code']   = isset($row['batch_code']) ? $row['batch_code'] : 'NULL';
            $programList[strtolower($row['vendor']) . '_BATCH_' . $row['batch_id']]['vendor']       = isset($row['vendor']) ? $row['vendor'] : 'NULL';
            $programList[strtolower($row['vendor']) . '_BATCH_' . $row['batch_id']][ucwords($row['status'])] = $row['lead_count'];
            $StatusList[ucwords($row['status'])]                                                             = ucwords($row['status']);
            }




            # Create heading
            $data = "Programme Name";
            $data .= ",Batch Name";
            $data .= ",Batch Code";
            $data .= ",Vendor";
            foreach ($StatusList as $key => $statusVal)
            {
                $data .= "," . $key;
            }
            $data .= ",Total";
            $data .= "\n";




            foreach ($programList as $key => $valArr)
            {

                $data .= "\"" . $valArr['program_name'];
                $data .= "\",\"" . $valArr['batch_name'];
                $data .= "\",\"" . $valArr['batch_code'];
                $data .= "\",\"" . $valArr['vendor'];
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
                    p.name program_name,
                    te_ba_batch.id AS batch_id,
                    te_ba_batch.name AS batch_name,
                    te_ba_batch.batch_code,
                    l.status,
                    l.vendor,
                    te_vendor.id vendor_id
                FROM leads l
                INNER JOIN leads_cstm AS lc ON l.id=lc.id_c
                LEFT JOIN te_ba_batch ON lc.te_ba_batch_id_c = te_ba_batch.id
                LEFT JOIN te_vendor on lower(l.vendor)=lower(te_vendor.name)
                LEFT JOIN te_pr_programs_te_ba_batch_1_c AS bpr ON bpr.te_pr_programs_te_ba_batch_1te_ba_batch_idb=te_ba_batch.id
                LEFT JOIN te_pr_programs as p ON p.id=bpr.te_pr_programs_te_ba_batch_1te_pr_programs_ida
                 WHERE l.deleted=0
                   $wherecl
               GROUP BY l.status,te_vendor.id,te_ba_batch.batch_code order by  te_ba_batch.batch_code ";
        //echo $leadSql;exit();


        $leadObj = $db->query($leadSql);

        $vendor = 'NULL';

        while ($row = $db->fetchByAssoc($leadObj))
        {
            if ($row['vendor'] == '')
            {
                $row['vendor'] = $vendor;
            }


            $programList[strtolower($row['vendor']) . '_BATCH_' . $row['batch_id']]['batch_id']     = $row['batch_id'];
            $programList[strtolower($row['vendor']) . '_BATCH_' . $row['batch_id']]['batch_name']   = isset($row['batch_name']) ? $row['batch_name'] : 'NULL';
            $programList[strtolower($row['vendor']) . '_BATCH_' . $row['batch_id']]['program_name'] = isset($row['program_name']) ? $row['program_name'] : 'NULL';
            $programList[strtolower($row['vendor']) . '_BATCH_' . $row['batch_id']]['batch_code']   = isset($row['batch_code']) ? $row['batch_code'] : 'NULL';
            $programList[strtolower($row['vendor']) . '_BATCH_' . $row['batch_id']]['vendor']       = isset($row['vendor']) ? $row['vendor'] : 'NULL';
            $programList[strtolower($row['vendor']) . '_BATCH_' . $row['batch_id']][ucwords($row['status'])] = $row['lead_count'];
            $StatusList[ucwords($row['status'])]                                                             = ucwords($row['status']);
        }



        //echo 'xx='.count($programList);die;
        //echo '<pre>';
        //print_r($programList); die;
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
        $sugarSmarty->assign("ProgrammeListData", $ProgrammeListData);
        $sugarSmarty->assign("VendorListData", $VendorListData);
        $sugarSmarty->assign("StatusList", $StatusList);
        $sugarSmarty->assign("selected_batch", $selected_batch);
        $sugarSmarty->assign("selected_status", $selected_status);
        $sugarSmarty->assign("selected_from_date", $selected_from_date);
        $sugarSmarty->assign("selected_to_date", $selected_to_date);
        $sugarSmarty->assign("selected_vendor", $selected_vendor);
        $sugarSmarty->assign("selected_medium_val", $selected_medium_val);
        $sugarSmarty->assign("selected_counsellor", $selected_counsellor);

        $sugarSmarty->assign("current_records", $current);
        $sugarSmarty->assign("page", $page);
        $sugarSmarty->assign("pagenext", $pagenext);
        $sugarSmarty->assign("right", $right);
        $sugarSmarty->assign("left", $left);
        $sugarSmarty->assign("last_page", $last_page);
        $sugarSmarty->display('custom/modules/AOR_Reports/tpls/vendorwisestatusreport.tpl');
    }

}

?>

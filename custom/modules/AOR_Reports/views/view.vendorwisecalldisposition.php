<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

//error_reporting(-1);
//ini_set('display_errors', 'On');
class AOR_ReportsViewVendorwisecalldisposition extends SugarView
{

    var $report_to_id;
    var $counsellors_arr;

    public function __construct()
    {
        parent::SugarView();
    }

    function statusHeader()
    {
        $headerArr = array();

        $headerArr = array(
            'id'                   => 'Lead ID',
            'date_entered'         => 'Date',
            'vendor'               => 'Vendor',
            'batch_code'           => 'Batch Code',
            'status'               => 'Status',
            'status_description'   => 'Sub Status',
            'disposition_reason'   => 'Disposition Reason',
            'primary_address_city' => 'City',
            'comment'              => 'Comments',
            'note'                 => 'Note'
                #'id'                   =>'User Name',
        );

        return $headerArr;
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
        $batchSql     = "SELECT id,name,batch_code FROM te_ba_batch WHERE  deleted=0 order by batch_code";
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

        $report_action = '';
        $reportAccess  = reportAccessLog();

        $current_user_id = $current_user->id;
        $report_action   = isset($GLOBALS['action']) ? $GLOBALS['action'] : '';


        if (!in_array($current_user->id, $reportAccess[$report_action]) && ($current_user->is_admin != 1))
        {
            echo 'You are not authorized to access!';
            return;
        }



        $where          = "";
        $wherecl        = "";
        $statusHeader   = $this->statusHeader();
        $BatchListData  = $this->getBatch();
        $VendorListData = $this->getVendors();

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


        if (!empty($selected_vendor))
        {

            $wherecl .= " AND  te_vendor.id IN ('" . implode("','", $selected_vendor) . "')";
        }


        $leadSql = "SELECT 
                    l.id,
                    date(l.date_entered) date_entered,
                    l.vendor,
                    te_ba_batch.batch_code,
                    l.status,
                    l.status_description,
                    l.disposition_reason,
                    l.primary_address_city,
                    l.note,
                    l.comment
                    
                FROM leads l
                INNER JOIN leads_cstm AS lc ON l.id=lc.id_c
                LEFT JOIN te_ba_batch ON lc.te_ba_batch_id_c = te_ba_batch.id
                LEFT JOIN te_vendor on lower(l.vendor)=lower(te_vendor.name)
                 WHERE l.deleted=0
                   $wherecl
               order by  l.date_entered,te_ba_batch.batch_code,l.vendor ";
        //echo $leadSql;exit();


        $leadObj = $db->query($leadSql);



        while ($row = $db->fetchByAssoc($leadObj))
        {

            //isset($row['batch_name']) ? $row['batch_name'] : 'NULL';
            $programList[$row['id']]['id']                   = $row['id'];
            $programList[$row['id']]['date_entered']         = $row['date_entered'];
            $programList[$row['id']]['vendor']               = isset($row['vendor']) ? $row['vendor'] : 'N/A';
            $programList[$row['id']]['batch_code']           = isset($row['batch_code']) ? $row['batch_code'] : 'N/A';
            $programList[$row['id']]['status']               = isset($row['status']) ? $row['status'] : 'N/A';
            $programList[$row['id']]['status_description']   = isset($row['status_description']) ? $row['status_description'] : 'N/A';
            $programList[$row['id']]['disposition_reason']   = isset($row['disposition_reason']) ? $row['disposition_reason'] : 'N/A';
            $programList[$row['id']]['primary_address_city'] = isset($row['primary_address_city']) ? $row['primary_address_city'] : 'N/A';
            $programList[$row['id']]['note']                 = addslashes(isset($row['note']) ? $row['note'] : 'N/A');
            $programList[$row['id']]['comment']              = addslashes(isset($row['comment']) ? $row['comment'] : 'N/A');
        }

        $StatusList = $statusHeader;


        //echo '<pre>';
        //print_r($programList); die;
        #PS @Pawan
        if (isset($_POST['export']) && $_POST['export'] == "Export")
        {

            $file     = "VendorwiseCallDispositionReport_report";
            $where    = '';
            $filename = $file . "_" . $from_date . "_" . $to_date;


            $StatusList = $statusHeader;

            $data .= "Lead ID";
            $data .= ",Date";
            $data .= ",Vendor";
            $data .= ",Batch Code";
            $data .= ",Status";
            $data .= ",Sub Status";
            $data .= ",Disposition Reason";
            $data .= ",City";
            $data .= ",Comments";
            $data .= ",Note";
            $data .= "\n";

            
            foreach ($programList as $key => $councelor)
            {
                $i = 0;
                foreach ($StatusList as $key1 => $value)
                {

                    if ($i == 0)
                    {
                        $data .= "\"" . $councelor[$key1];
                    }
                    else
                    {
                        $data .= "\",\"" . $councelor[$key1];
                    }
                    $i++;
                }

                $data .= "\"\n";
            }

            ob_end_clean();
            header("Content-type: application/csv");
            header('Content-disposition: attachment;filename=" ' . $filename . '.csv";');
            echo $data;
            exit;
        } // End Of Export Func












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
        //$sugarSmarty->assign("ProgramListData", $ProgramListData);
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
        $sugarSmarty->display('custom/modules/AOR_Reports/tpls/vendorwisecalldisposition.tpl');
    }

}

?>

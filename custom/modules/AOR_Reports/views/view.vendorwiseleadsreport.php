<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');

class AOR_ReportsViewVendorwiseleadsreport extends SugarView
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

        $where     = "";
        $wherecl   = "";
        if (isset($_POST['button']) || isset($_POST['export']))
        {
            $_SESSION['cccon_from_date']  = $_REQUEST['from_date'];
            $_SESSION['cccon_to_date']    = $_REQUEST['to_date'];
            $_SESSION['cccon_counsellor'] = $_REQUEST['counsellor'];
            $_SESSION['cccon_batch']      = $_REQUEST['batch'];
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
            $wherecl            .= " AND DATE(leads.date_entered)>='" . $from_date . "' AND DATE(leads.date_entered)<='" . $to_date . "'";
        }
        elseif ($_SESSION['cccon_from_date'] != "" && $_SESSION['cccon_to_date'] == "")
        {
            $selected_from_date = $_SESSION['cccon_from_date'];
            $from_date          = date('Y-m-d', strtotime(str_replace('/', '-', $_SESSION['cccon_from_date'])));
            $wherecl            .= " AND DATE(leads.date_entered)>='" . $from_date . "' ";
        }
        elseif ($_SESSION['cccon_from_date'] == "" && $_SESSION['cccon_to_date'] != "")
        {
            $selected_to_date = $_SESSION['cccon_to_date'];
            $to_date          = date('Y-m-d', strtotime(str_replace('/', '-', $_SESSION['cccon_to_date'])));
            $wherecl          .= " AND DATE(leads.date_entered)<='" . $to_date . "' ";
        }
        if (!empty($_SESSION['cccon_status']))
        {
            $selected_status = $_SESSION['cccon_status'];
        }
        $findBatch = array();
        if (!empty($_SESSION['cccon_batch']))
        {
            $selected_batch = $_SESSION['cccon_batch'];
            //$batches        = $this->getBatch($_SESSION['cccon_batch']);
        }
        $programList = array();
        $VendorList   = array();
        
        if (!empty($selected_batch))
        {

            $wherecl .= " AND  te_ba_batch.id IN ('" . implode("','", $selected_batch) . "')";
        }

        if (isset($_POST['export']) && $_POST['export'] == "Export")
        {
            
            
            
            $file     = "VendorWiseReport_report";
            $where    = '';
            $filename = $file . "_" . $from_date . "_" . $to_date;
            
            $leadSql = "SELECT COUNT(leads.id) AS lead_count,
                    leads.date_entered,
                    te_ba_batch.id AS batch_id,
                    te_ba_batch.name AS batch_name,
                    te_ba_batch.batch_code,
                    leads.vendor,
                    te_vendor.id vendor_id
             FROM leads
          
             LEFT JOIN leads_cstm ON leads.id = leads_cstm.id_c
             LEFT JOIN te_ba_batch ON leads_cstm.te_ba_batch_id_c = te_ba_batch.id
             LEFT JOIN te_vendor on lower(leads.vendor)=lower(te_vendor.name)
             WHERE 1=1 $wherecl 
  
             GROUP BY leads.vendor,batch_code";
        //echo $leadSql;exit();


        $leadObj      = $db->query($leadSql);

       
                while ($row          = $db->fetchByAssoc($leadObj))
                {


                    $programList[$row['batch_id']]['id']         = $row['batch_id'];
                    $programList[$row['batch_id']]['name']       = $row['batch_name'];
                    $programList[$row['batch_id']]['batch_code'] = $row['batch_code'];


                    $VendorList[$row['vendor_id']]['name']                          = $row['vendor'];
                    $programList[$row['batch_id']][$row['vendor_id']]['lead_count'] = $row['lead_count'];
                }


          
            # Create heading
            $data = "Programme Name";
            $data .= ",Batch Code";
            foreach ($VendorList as $key => $vendorVal)
            {
                $data .= "," . $vendorVal['name'];
            }
            $data .= ",Total";
            $data .= "\n";




            foreach ($programList as $key => $councelor)
            {
                $data .= "\"" . $councelor['name'];
                $data .= "\",\"" . $councelor['batch_code'];
                foreach ($VendorList as $key1 => $value)
                {
                    $converted = $programList[$key][$key1]['lead_count'];
                    $data      .= "\",\"" . $converted;
                    $toal      += $converted;
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



        


        

        $leadSql = "SELECT COUNT(leads.id) AS lead_count,
                    leads.date_entered,
                    te_ba_batch.id AS batch_id,
                    te_ba_batch.name AS batch_name,
                    te_ba_batch.batch_code,
                    leads.vendor,
                    te_vendor.id vendor_id
             FROM leads
          
             LEFT JOIN leads_cstm ON leads.id = leads_cstm.id_c
             LEFT JOIN te_ba_batch ON leads_cstm.te_ba_batch_id_c = te_ba_batch.id
             LEFT JOIN te_vendor on lower(leads.vendor)=lower(te_vendor.name)
             WHERE 1=1 $wherecl 
  
             GROUP BY leads.vendor,batch_code";
        //echo $leadSql;exit();


        $leadObj      = $db->query($leadSql);

       
        while ($row          = $db->fetchByAssoc($leadObj))
        {


            $programList[$row['batch_id']]['id']         = $row['batch_id'];
            $programList[$row['batch_id']]['name']       = $row['batch_name'];
            $programList[$row['batch_id']]['batch_code'] = $row['batch_code'];


            $VendorList[$row['vendor_id']]['name']                          = $row['vendor'];
            $programList[$row['batch_id']][$row['vendor_id']]['lead_count'] = $row['lead_count'];
        }





        //echo '<pre>';
        //print_r($programList); die;
        #PS @Pawan
        $total     = count($programList); #total records
        $start     = 0;
        $per_page  = 10;
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

       
        $sugarSmarty->assign("VendorList", $VendorList);
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
        $sugarSmarty->display('custom/modules/AOR_Reports/tpls/vendorwiseleadsreport.tpl');
    }

}

?>

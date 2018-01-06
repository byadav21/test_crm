<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');

class AOR_ReportsViewCounselorconversionreport extends SugarView
{

    var $report_to_id;
    var $counsellors_arr;

    public function __construct()
    {
        parent::SugarView();
    }

    function reportingUser($currentUserId)
    {
        $userObj                             = new User();
        $userObj->disable_row_level_security = true;
        $userList                            = $userObj->get_full_list("", "users.reports_to_id='" . $currentUserId . "'");
        if (!empty($userList))
        {
            foreach ($userList as $record)
            {
                if (!empty($record->reports_to_id) && !empty($record->id))
                {
                    $this->report_to_id[]               = $record->id;
                    $this->counsellors_arr[$record->id] = $record->name;
                    $this->reportingUser($record->id);
                }
            }
        }
    }

    function getVendors()
    {
        global $db;
        $vendorArr = [];
        $vendorSql = "SELECT id,name FROM te_vendor WHERE deleted=0 AND vendor_status='Active'";
        $vendorObj = $db->query($vendorSql);
        while ($vendors   = $db->fetchByAssoc($vendorObj))
        {
            $vendorArr[] = $vendors;
        }
        return $vendorArr;
    }

    function getContracts()
    {
        global $db;
        $vendorArr = [];
        $vendorSql = "SELECT GROUP_CONCAT(DISTINCT u.contract_type)contract_type,v.id AS vendorid,v.name AS vendor,u.id,u.name FROM `te_utm` AS u INNER JOIN te_vendor_te_utm_1_c AS uv ON uv.te_vendor_te_utm_1te_utm_idb=u.id INNER JOIN te_vendor AS v ON v.id=uv.te_vendor_te_utm_1te_vendor_ida WHERE u.deleted=0 AND v.deleted=0 AND v.vendor_status='Active' GROUP BY v.id";
        $vendorObj = $db->query($vendorSql);
        while ($vendors   = $db->fetchByAssoc($vendorObj))
        {
            $contract_type = explode(',', $vendors['contract_type']);
            foreach ($contract_type as $cval)
            {
                $vendorArr[] = array(
                    'vendorid'      => $vendors['vendorid'],
                    'contract_type' => $cval,
                    'vendor'        => $vendors['vendor'],
                    'id'            => $vendors['id'],
                    'name'          => $vendors['name'],
                );
            }
        }
        return $vendorArr;
    }

    function getClosedBatch()
    {
        global $db;
        $batchSql     = "SELECT id,name from te_ba_batch WHERE deleted=0 AND batch_status NOT IN ('enrollment_in_progress','planned')";
        $batchObj     = $db->query($batchSql);
        $batchOptions = array();
        while ($row          = $db->fetchByAssoc($batchObj))
        {
            $batchOptions[] = $row;
        }
        return $batchOptions;
    }

    function getLiveBatch()
    {
        global $db;
        $batchSql     = "SELECT id,name,batch_code from te_ba_batch WHERE deleted=0 AND batch_status='enrollment_in_progress'";
        $batchObj     = $db->query($batchSql);
        $batchOptions = array();
        while ($row          = $db->fetchByAssoc($batchObj))
        {
            $batchOptions[] = $row;
        }
        return $batchOptions;
    }

    function getAllBatch()
    {
        global $db;
        $batchSql     = "SELECT id,name,CASE WHEN batch_status IN ('enrollment_in_progress') THEN 'Live' ELSE 'Closed' END AS status_filter FROM te_ba_batch WHERE deleted=0 AND batch_status NOT IN ('planned')";
        $batchObj     = $db->query($batchSql);
        $batchOptions = array();
        while ($row          = $db->fetchByAssoc($batchObj))
        {
            $batchOptions[] = $row;
        }
        return $batchOptions;
    }

    function getBatch($batchArr)
    {
        global $db;
        $batchSql     = "SELECT id,name,batch_code from te_ba_batch WHERE deleted=0 AND id IN ('" . implode("','", $batchArr) . "') ";
        $batchObj     = $db->query($batchSql);
        $batchOptions = array();
        while ($row          = $db->fetchByAssoc($batchObj))
        {
            $batchOptions[] = $row;
        }
        return $batchOptions;
    }

    function getVendorByID($vendorid)
    {
        global $db;
        $batchSql = "SELECT name from te_vendor WHERE id='" . $vendorid . "'";
        $batchObj = $db->query($batchSql);
        $row      = $db->fetchByAssoc($batchObj);
        return $row['name'];
    }

    function getUtmByContractIDs($vAndCtVendorArr, $vAndCtArr)
    {
        global $db;
        $batchSql     = "SELECT u.name from te_utm AS u INNER JOIN te_vendor_te_utm_1_c AS uv on uv.te_vendor_te_utm_1te_utm_idb=u.id WHERE u.deleted=0 AND uv.te_vendor_te_utm_1te_vendor_ida IN('" . implode("','", $vAndCtVendorArr) . "') AND u.contract_type IN('" . implode("','", $vAndCtArr) . "')";
        $batchObj     = $db->query($batchSql);
        $batchOptions = array();
        while ($row          = $db->fetchByAssoc($batchObj))
        {
            $batchOptions[] = $row['name'];
        }
        return $batchOptions;
    }

    function getCouncelor($user_id)
    {
        global $db;
        $userSql = "SELECT CONCAT(first_name,' ',last_name) as name FROM users WHERE deleted=0 AND id='" . $user_id . "'";
        $userObj = $db->query($userSql);
        $user    = $db->fetchByAssoc($userObj);
        return $user['name'];
    }
    
    
    function getCouncelordata($user_id)
    {
        global $db;
        $userSql = "SELECT CONCAT(first_name,' ',last_name) as name,id,reports_to_id FROM users WHERE deleted=0 AND is_admin=0";
        $userObj = $db->query($userSql);
        //$user    = $db->fetchByAssoc($userObj);
        
        $users = array();
        while ($row          = $db->fetchByAssoc($userObj))
        {
            $users[] = $row;
        }
        return $users;
        
    }

    function getConvertedLead($user_id, $batch_id)
    {
        global $db;
        $leadSql = "SELECT count(l.id) as total FROM leads AS l INNER JOIN leads_cstm AS lc ON l.id=lc.id_c WHERE l.deleted=0 AND l.status='Converted' AND l.assigned_user_id='" . $user_id . "' AND lc.te_ba_batch_id_c='" . $batch_id . "'";
        $leadObj = $db->query($leadSql);
        $lead    = $db->fetchByAssoc($leadObj);
        return $lead['total'];
    }

    public function display()
    {
        global $sugar_config, $app_list_strings, $current_user, $db;
        $is_admin                                 = $current_user->is_admin;
        $leadsData                                = array();
        $vendorList                               = $this->getVendors();
        $contractList                             = $this->getContracts();
        $this->counsellors_arr[$current_user->id] = $current_user->name;
        $user_id                                  = $current_user->id;
        $this->report_to_id[]                     = $user_id;
        $users                                    = $this->reportingUser($user_id);
        #Get batch drop down option
        $batchList                                = $this->getAllBatch();

        $uid     = $this->report_to_id; # list of user ids
        $batches = $this->getLiveBatch();
        # Query for batch drop down options
        $where   = "";
        $wherecl = "";
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
            $wherecl            .= " AND DATE(l.converted_date)>='" . $from_date . "' AND DATE(l.converted_date)<='" . $to_date . "'";
        }
        elseif ($_SESSION['cccon_from_date'] != "" && $_SESSION['cccon_to_date'] == "")
        {
            $selected_from_date = $_SESSION['cccon_from_date'];
            $from_date          = date('Y-m-d', strtotime(str_replace('/', '-', $_SESSION['cccon_from_date'])));
            $wherecl            .= " AND DATE(l.converted_date)>='" . $from_date . "' ";
        }
        elseif ($_SESSION['cccon_from_date'] == "" && $_SESSION['cccon_to_date'] != "")
        {
            $selected_to_date = $_SESSION['cccon_to_date'];
            $to_date          = date('Y-m-d', strtotime(str_replace('/', '-', $_SESSION['cccon_to_date'])));
            $wherecl          .= " AND DATE(l.converted_date)<='" . $to_date . "' ";
        }
        if (!empty($_SESSION['cccon_status']))
        {
            $selected_status = $_SESSION['cccon_status'];
        }
        if (!empty($_SESSION['cccon_batch']))
        {
            $selected_batch = $_SESSION['cccon_batch'];
            $batches        = $this->getBatch($_SESSION['cccon_batch']);
        }
        if (!empty($_SESSION['cccon_counsellor']))
        {
            $selected_counsellor = $_SESSION['cccon_counsellor'];
            $uid                 = $_SESSION['cccon_counsellor'];
        }
       
        if (isset($_POST['export']) && $_POST['export'] == "Export")
        {
            $councelorList = array();
            $programList   = array();
            $programListRs   = array();
             $uid = $this->getCouncelordata($user_id);
            foreach ($uid as $key => $value)
            {
                $ReportingManager = $this->getCouncelor($value['reports_to_id']);
                foreach ($batches as $batchkey => $batchvalue)
                {
                    $programList[$batchvalue['id']]                              = $batchvalue['batch_code'];
                    $programListRs[$batchvalue['id']]                              = $batchvalue['batch_code']."_Rs";
                    //$councelorList[$value['id']][$batchvalue['id']]['converted'] = 0;
                    //$councelorList[$value][$batchvalue['id']]['total']         = 0;
                    $councelorList[$value['id']]['name']                         = $value['name'];
                    $councelorList[$value['id']]['Reporting_to']                 = ($ReportingManager!='')?$ReportingManager:'N/A';
                }
            }
            $file     = "conversion_report";
            $where    = '';
            $filename = $file . "_" . date("Y-m-d");

            $leadSql = "SELECT COUNT(l.id)total,
                        COUNT(l.id)converted,
                        l.assigned_user_id,
                        lc.te_ba_batch_id_c,
                        tb.fees_inr
                 FROM `leads` AS l
                 INNER JOIN leads_cstm AS lc ON l.id=lc.id_c 
                 INNER JOIN te_ba_batch AS tb ON lc.te_ba_batch_id_c=tb.id 
                 WHERE l.deleted=0
                   AND l.status='Converted'
                   AND l.status IN('Alive',
                                   'Warm',
                                   'Dead',
                                   'Converted')
                   AND lc.te_ba_batch_id_c IN('" . implode("',
                                              '", array_keys($programList)) . "') $wherecl
                 GROUP BY l.assigned_user_id,
                          lc.te_ba_batch_id_c";
            $leadObj = $db->query($leadSql);
            while ($row     = $db->fetchByAssoc($leadObj))
            {
                 $councelorList[$row['assigned_user_id']][$row['te_ba_batch_id_c']]['converted'] = $row['converted'];
            $councelorList[$row['assigned_user_id']][$row['te_ba_batch_id_c']]['total']     = ($row['converted']==0)? 0 : ($row['converted'] * $row['fees_inr']);
            }
            
            # Create heading
            $data = "Reporting Manager";
            $data .= ",Counsellors";
            foreach ($programList as $key => $program)
            {
                $data .= "," . $program;
            }
             foreach ($programListRs as $key => $program)
            {
                $data .= "," . $program;
            }
            $data .= "\n";

            
            
            
            foreach ($councelorList as $key => $councelor)
            {   
                $data .= "\"" . $councelor['Reporting_to'];
                $data .= "\",\"" . $councelor['name'];
                foreach ($programList as $key1 => $value)
                {
                    $converted = $councelor[$key1]['converted'];
                    $data      .= "\",\"" . $converted;
                }
                foreach ($programListRs as $key1 => $value)
                {
                    $total     = $councelor[$key1]['total'];
                    $data      .= "\",\"" . $total;
                }
                $data .= "\"\n";
            }

            ob_end_clean();
            header("Content-type: application/csv");
            header('Content-disposition: attachment;filename=" ' . $filename . '.csv";');
            echo $data;
            exit;
        } // End Of Export Func
        
        
        $councelorList = array();
        $programList   = array();
        $programListRs   = array();
        $uid = $this->getCouncelordata($user_id);
        
        
        foreach ($uid as $key => $value)
        {
            $ReportingManager = $this->getCouncelor($value['reports_to_id']);
            foreach ($batches as $batchkey => $batchvalue)
            {
                //echo '<>>>---=='. $value['id'];
                
               
                
                $programList[$batchvalue['id']]                              = $batchvalue['batch_code'];
                $programListRs[$batchvalue['id']]                            = $batchvalue['batch_code']."_Rs";
                $councelorList[$value['id']][$batchvalue['id']]['converted'] = 0;
                //$councelorList[$value][$batchvalue['id']]['total']         = 0;
                $councelorList[$value['id']]['name']                         = $value['name'];
                $councelorList[$value['id']]['Reporting_to']                 = ($ReportingManager!='')?$ReportingManager:'N/A';
            }
            
        }
        
        
        
        //echo '<pre>';
        //print_r($batches);die;
        //echo count($councelorList); die;

        $leadSql = "SELECT COUNT(l.id)total,
                        COUNT(l.id)converted,
                        l.assigned_user_id,
                        lc.te_ba_batch_id_c,
                        tb.fees_inr
                 FROM `leads` AS l
                 INNER JOIN leads_cstm AS lc ON l.id=lc.id_c 
                 INNER JOIN te_ba_batch AS tb ON lc.te_ba_batch_id_c=tb.id 
                 WHERE l.deleted=0
                   AND l.status='Converted'
                   AND l.status IN('Alive',
                                   'Warm',
                                   'Dead',
                                   'Converted')
                   AND lc.te_ba_batch_id_c IN('" . implode("',
                                              '", array_keys($programList)) . "') $wherecl
                 GROUP BY l.assigned_user_id,
                          lc.te_ba_batch_id_c";
        //echo $leadSql;exit();
      

        $leadObj = $db->query($leadSql);

        while ($row = $db->fetchByAssoc($leadObj))
        {
            $amount = ($row['converted'] * $row['fees_inr']);
            $councelorList[$row['assigned_user_id']][$row['te_ba_batch_id_c']]['converted'] = $row['converted'];
            $councelorList[$row['assigned_user_id']][$row['te_ba_batch_id_c']]['total']     = $amount;
           
        }
        
        //echo '<pre>';
        //print_r($councelorList);
        /* foreach($councelorList as $key=>$councelor){
          foreach($programList as $key1=>$value){
          if(!isset($councelor[$key1]))
          $councelorList[$key][$key1]=0;
          }
          } */
        //echo "<pre>";print_r($councelorList);exit();
        #PS @Pawan
        $total     = count($councelorList); #total records
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

        $councelorList = array_slice($councelorList, $start, $per_page);
        if ($total > $per_page)
        {
            $current = "(" . ($start + 1) . "-" . ($start + $per_page) . " of " . $total . ")";
        }
        else
        {
            $current = "(" . ($start + 1) . "-" . count($councelorList) . " of " . $total . ")";
        }
        #pE
        $sugarSmarty = new Sugar_Smarty();
        $sugarSmarty->assign("councelorArr", $this->counsellors_arr);
        $sugarSmarty->assign("vendorList", $vendorList);
        $sugarSmarty->assign("contractList", $contractList);
        $sugarSmarty->assign("is_admin", $is_admin);

        $sugarSmarty->assign("councelorList", $councelorList);
        $sugarSmarty->assign("programList", $programList); 
        $sugarSmarty->assign("programListRs", $programListRs); 
        $sugarSmarty->assign("batchList", $batchList);

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
        $sugarSmarty->display('custom/modules/AOR_Reports/tpls/counselorconversionreport.tpl');
    }

}

?>

<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');

class AOR_ReportsViewUtmstatusreport extends SugarView
{

    public function __construct()
    {
        parent::SugarView();
    }

    function getBatch()
    {
        global $db;
        $batchSql     = "SELECT b.id,
                                b.name,
                                b.batch_code,
                                b.d_campaign_id,
                                b.d_lead_id,
                                b.batch_status,
                                b.fees_inr,
                                p.name AS program_name
                         FROM te_ba_batch AS b
                         INNER JOIN te_pr_programs_te_ba_batch_1_c AS pbr ON pbr.te_pr_programs_te_ba_batch_1te_ba_batch_idb=b.id
                         INNER JOIN te_pr_programs AS p ON p.id=pbr.te_pr_programs_te_ba_batch_1te_pr_programs_ida
                         WHERE b.deleted=0
                         ORDER BY b.name";
        $batchObj     = $db->query($batchSql);
        $batchOptions = array();
        while ($row          = $db->fetchByAssoc($batchObj))
        {
            $batchOptions[$row['id']] = $row;
        }
        return $batchOptions;
    }

    function getStatusDes()
    {
        global $db;
        $statusDesSql     = "SELECT DISTINCT status_description AS status_description
                                FROM leads
                                WHERE deleted=0";
        $statusDesSqlObj  = $db->query($statusDesSql);
        $statusDesOptions = array();
        while ($row              = $db->fetchByAssoc($statusDesSqlObj))
        {
            $row['status_description']                    = (empty($row['status_description'])) ? "Empty" : $row['status_description'];
            $statusDesOptions[$row['status_description']] = $row['status_description'];
        }
        return $statusDesOptions;
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
            '36990877-a094-db61-6610-5b20f95a6e6e' => 'Infoedge',
            'e7dafa0f-2d5e-9885-90d4-5c383bda6353' => 'intellactads');




        $vendorsIdArr = array(
            'ileap'        => '4a9e16bf-0396-fffc-b848-5b084550f2a8',
            'TBS'          => 'abe14a6c-00cb-13d6-2e2e-590d6f806ff4',
            'iimjobs'      => 'ee1d169a-ca0c-f3fe-d6d6-590d636bc19b',
            'CiteHR'       => '14a4e733-b709-8c60-7731-590d5cb3b1f7',
            'Career360'    => '71a590a5-0616-44d3-5248-590d5b158460',
            'Infoedge'     => '92f19224-b7b2-68e2-a112-590d64d59115',
            'intellactads' => '7eb40efc-b353-0885-1f7f-5c3733292e86');


        $batchList  = $this->getBatch();
        $statusList = $this->getStatusDes();

        $listCouncelorArr = [];
        if (isset($_REQUEST['button']) || isset($_REQUEST['export']))
        {
            $_SESSION['ur_from_date'] = ($_REQUEST['from_date']) ? date("Y-m-d", strtotime($_REQUEST['from_date'])) : '';
            $_SESSION['ur_to_date']   = ($_REQUEST['to_date']) ? date("Y-m-d", strtotime($_REQUEST['to_date'])) : '';
            $_SESSION['ur_batch']     = $_REQUEST['course'];
            $_SESSION['ur_status']    = $_REQUEST['status'];
        }
        if (!isset($_SESSION['ur_from_date']) || empty($_SESSION['ur_from_date']))
        {
            $_SESSION['ur_from_date'] = date('Y-m-d');
        }
        if (!isset($_SESSION['ur_to_date']) || empty($_SESSION['ur_to_date']))
        {
            $_SESSION['ur_to_date'] = date('Y-m-d');
        }

        $wheredr = "";
        if (!empty($_SESSION['ur_from_date']))
        {
            $selected_from_date = date("d-m-Y", strtotime($_SESSION['ur_from_date']));
            $wheredr            .= " AND DATE(l.date_entered)>='" . $_SESSION['ur_from_date'] . "'";
        }
        if (!empty($_SESSION['ur_to_date']))
        {
            $selected_to_date = date("d-m-Y", strtotime($_SESSION['ur_to_date']));
            $wheredr          .= " AND DATE(l.date_entered)<='" . $_SESSION['ur_to_date'] . "'";
        }
        if (!empty($_SESSION['ur_batch']))
        {
            $selected_course = $_SESSION['ur_batch'];
            $wheredr         .= " AND lc.te_ba_batch_id_c IN ('" . implode("','", $selected_course) . "')";
        }
        if (!empty($_SESSION['ur_status']))
        {
            $selected_status = $_SESSION['ur_status'];
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
	if (isset($UsersVendrArr[$current_user->id]) && $UsersVendrArr[$current_user->id] == 'intellactads')
        {
            $selected_vendor = array($vendorsIdArr['intellactads']);
            $VendorListData  = array(array('id' => $vendorsIdArr['intellactads'], 'name' => 'intellactads'));
        }

        if (!empty($selected_vendor))
        {

            $wheredr .= " AND  te_vendor.id IN ('" . implode("','", $selected_vendor) . "')";
        }

        /* Check Date Range */
        $filter_date_diff = $this->dateDiff($_SESSION['ur_from_date'], $_SESSION['ur_to_date']);
        if ($filter_date_diff > 186)
        {
            SugarApplication::appendErrorMessage('Action Prohibited: Please select a max of six months date range.');
            //set params
            $params = array(
                'module' => 'AOR_Reports', //the module you want to redirect to
                'action' => 'utmstatusreport', //the view within that module
            );
        }/* Date Range is <=90Days */
        else
        {
            $leadSql = "SELECT l.status_description,
                            lc.te_ba_batch_id_c,
                            l.utm_campaign,
                            l.utm_term_c,
                            l.utm_source_c,
                            l.utm_contract_c
                     FROM leads AS l
                     INNER JOIN leads_cstm AS lc ON l.id=lc.id_c
                     LEFT JOIN te_vendor on lower(l.vendor)=lower(te_vendor.name)
                     WHERE l.deleted=0 " . $wheredr;
            $leadObj = $db->query($leadSql);
            $dataArr = [];
            while ($row     = $db->fetchByAssoc($leadObj))
            {
                $dataArr[] = $row;
            }
            $councelorList = $this->__formate_data($dataArr, $batchList, $statusList);
            //echo "<pre>";print_r($councelorList);exit();
            if (isset($_REQUEST['export']))
            {
                $this->__export_data($councelorList, $statusList);
            }
            #Pagination
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
            #End Pagination
        }

        $sugarSmarty = new Sugar_Smarty();
        $sugarSmarty->assign("reportDataList", $councelorList);
        $sugarSmarty->assign("leadStatusList", $statusList);
        $sugarSmarty->assign("batchList", $batchList);

        $sugarSmarty->assign("selected_batch", $selected_course);
        $sugarSmarty->assign("selected_status", $selected_status);
        $sugarSmarty->assign("selected_from_date", $selected_from_date);
        $sugarSmarty->assign("selected_to_date", $selected_to_date);

        $sugarSmarty->assign("current_records", $current);
        $sugarSmarty->assign("page", $page);
        $sugarSmarty->assign("pagenext", $pagenext);
        $sugarSmarty->assign("right", $right);
        $sugarSmarty->assign("left", $left);
        $sugarSmarty->assign("last_page", $last_page);
        $sugarSmarty->display('custom/modules/AOR_Reports/tpls/utmstatusreport.tpl');
    }

    function __formate_data($dataArr, $batchArr, $statusList)
    {
        $formate_arr      = [];
        $formate__res_arr = [];
        $batchArr['']     = '';
        foreach ($dataArr as $val)
        {
            $batchID        = ($val['te_ba_batch_id_c']) ? $val['te_ba_batch_id_c'] : "NA";
            $utm_source_c   = ($val['utm_source_c']) ? $val['utm_source_c'] : "NA";
            $utm_contract_c = ($val['utm_contract_c']) ? $val['utm_contract_c'] : "NA";
            $utm_term_c     = ($val['utm_term_c']) ? $val['utm_term_c'] : "NA";
            $utm_campaign   = ($val['utm_campaign']) ? $val['utm_campaign'] : "NA";
            $root_key       = $batchID . '_UR_' . $utm_source_c . '_UR_' . $utm_contract_c . '_UR_' . $utm_term_c . '_UR_' . $utm_campaign;

            $formate_arr[$root_key]['utm_source_c']                         = $utm_source_c;
            $formate_arr[$root_key]['utm_term_c']                           = $utm_term_c;
            $formate_arr[$root_key]['utm_contract_c']                       = $utm_contract_c;
            $formate_arr[$root_key]['utm_campaign']                         = $utm_campaign;
            //$formate_arr[$root_key]['batch']=($batchArr[$val['te_ba_batch_id_c']]['name']) ? $batchArr[$val['te_ba_batch_id_c']]['name'] : "NA";
            $formate_arr[$root_key]['batch_code']                           = ($batchArr[$val['te_ba_batch_id_c']]['batch_code']) ? $batchArr[$val['te_ba_batch_id_c']]['batch_code'] : "NA";
            //$formate_arr[$root_key]['program_name']=($batchArr[$val['te_ba_batch_id_c']]['program_name']) ? $batchArr[$val['te_ba_batch_id_c']]['program_name'] : "NA";
            $formate_arr[$root_key]['status'][$val['status_description']][] = 1;
            foreach ($statusList as $statusVal)
            {
                $statusVal                          = (empty($statusVal)) ? "Empty" : $statusVal;
                $formate_arr[$root_key][$statusVal] = 0;
            }
        }//echo "<pre>";print_r($formate_arr);exit();
        if ($formate_arr)
        {
            foreach ($formate_arr as $key => $val)
            {
                $formate__res_arr[$key] = $val;
                $total                  = [];
                //echo "<pre>";print_r($val['status']);exit();

                foreach ($val['status'] as $statuskey => $statusval)
                {
                    $total[]                            = count($statusval);
                    $statuskey                          = (empty($statuskey)) ? "Empty" : $statuskey;
                    $formate__res_arr[$key][$statuskey] = count($statusval);
                }
                $formate__res_arr[$key]['total'] = array_sum($total);
                unset($formate__res_arr[$key]['status']);
            }
        }//echo "<pre>";print_r($formate__res_arr);exit();
        return $formate__res_arr;
    }

    function __export_data($row_data = array(), $status_data = array())
    {
        $data     = "Source, Term, Medium, Campaign, Batch Code,";
        $data     .= implode(',', $status_data);
        $data     .= ',Total';
        $data     .= "\n";
        $file     = "utm_report";
        $filename = $file . "_" . date("Y-m-d");
        foreach ($row_data as $key => $datax)
        {
            $data .= "\"" . $datax['utm_source_c'];
            $data .= "\",\"" . $datax['utm_term_c'];

            $data .= "\",\"" . $datax['utm_contract_c'];
            $data .= "\",\"" . $datax['utm_campaign'];
            $data .= "\",\"" . $datax['batch_code'];

            foreach ($status_data as $key => $status_val)
            {
                $data .= "\",\"" . $datax[$status_val];
            }
            $data .= "\",\"" . $datax['total'];
            $data .= "\"\n";
        }
        ob_end_clean();
        header("Content-type: application/csv");
        header('Content-disposition: attachment;filename=" ' . $filename . '.csv";');
        echo $data;
        exit;
    }

    function dateDiff($d1, $d2)
    {
        // Return the number of days between the two dates:
        return round(abs(strtotime($d1) - strtotime($d2)) / 86400);
    }

}

?>

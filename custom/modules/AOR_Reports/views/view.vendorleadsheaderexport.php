<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

//error_reporting(-1);
//ini_set('display_errors', 'On');
class AOR_ReportsViewVendorleadsheaderexport extends SugarView
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
            'e7dafa0f-2d5e-9885-90d4-5c383bda6353' => 'intellactads',
            'bbbea66c-1aee-a0bc-2654-5cb02b0123f0' => 'OneyearMBA',
            '80c3283f-97f4-06b3-c231-5d66510a463d' => 'Proformics',
            '98beaef1-89c8-b51e-68f0-5df21e3b40d9' => 'pointific',
            '67fe4fa4-3b45-9a7c-35c4-5efeed862529' => 'Connective9',
            '9ecbddae-7078-89f6-4cbb-5f1a854587fe' => 'Collegedunia',
            '2abde316-781b-2dce-4ba4-6051cd2c902c' => 'Shiksha',
            '5d31a08d-d23e-a7e5-e661-6034cbfba0f3' => 'Wheebox');




        $vendorsIdArr = array(
            'ileap'        => '4a9e16bf-0396-fffc-b848-5b084550f2a8',
            'TBS'          => 'abe14a6c-00cb-13d6-2e2e-590d6f806ff4',
            'iimjobs'      => 'ee1d169a-ca0c-f3fe-d6d6-590d636bc19b',
            'CiteHR'       => '14a4e733-b709-8c60-7731-590d5cb3b1f7',
            'Career360'    => '71a590a5-0616-44d3-5248-590d5b158460',
            'Infoedge'     => '92f19224-b7b2-68e2-a112-590d64d59115',
            'intellactads' => '7eb40efc-b353-0885-1f7f-5c3733292e86',
            'OneyearMBA'   => '189101d3-837e-ca93-43ee-5c4003d0586f',
            'Proformics'   => 'b7045019-6b1b-e69b-2a18-590d67814ab3',
            'pointific'   =>  '681ba8eb-34fd-0a41-dbea-5de7905fa337',
            'Connective9'  => '8c6a35d9-8cfd-ae0d-5338-5efe9c41d5dc',
            'Collegedunia' => 'b2ef6323-ea47-2605-59c9-590d5cae3850',
            'Shiksha'      => '47c6f465-82a1-39d0-c96f-590d6f34c0ca',
            'Wheebox'      => '71d437b6-cff2-8145-eac7-590d71acd731');

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
        if (isset($UsersVendrArr[$current_user->id]) && $UsersVendrArr[$current_user->id] == 'OneyearMBA')
        {
            $selected_vendor = array($vendorsIdArr['OneyearMBA']);
            $VendorListData  = array(array('id' => $vendorsIdArr['OneyearMBA'], 'name' => 'OneyearMBA'));
        }
        if (isset($UsersVendrArr[$current_user->id]) && $UsersVendrArr[$current_user->id] == 'Proformics')
        {
            $selected_vendor = array($vendorsIdArr['Proformics']);
            $VendorListData  = array(array('id' => $vendorsIdArr['Proformics'], 'name' => 'Proformics'));
        }
        if (isset($UsersVendrArr[$current_user->id]) && $UsersVendrArr[$current_user->id] == 'pointific')
        {
            $selected_vendor = array($vendorsIdArr['pointific']);
            $VendorListData  = array(array('id' => $vendorsIdArr['pointific'], 'name' => 'pointific'));
        }
        if (isset($UsersVendrArr[$current_user->id]) && $UsersVendrArr[$current_user->id] == 'Connective9')
        {
            $selected_vendor = array($vendorsIdArr['Connective9']);
            $VendorListData  = array(array('id' => $vendorsIdArr['Connective9'], 'name' => 'Connective9'));
        }
        if (isset($UsersVendrArr[$current_user->id]) && $UsersVendrArr[$current_user->id] == 'Collegedunia')
        {
            $selected_vendor = array($vendorsIdArr['Collegedunia']);
            $VendorListData  = array(array('id' => $vendorsIdArr['Collegedunia'], 'name' => 'Collegedunia'));
        }
        if (isset($UsersVendrArr[$current_user->id]) && $UsersVendrArr[$current_user->id] == 'Shiksha')
        {
            $selected_vendor = array($vendorsIdArr['Shiksha']);
            $VendorListData  = array(array('id' => $vendorsIdArr['Shiksha'], 'name' => 'Shiksha'));
        }

        if (!empty($selected_vendor))
        {

            $wherecl .= " AND  te_vendor.id IN ('" . implode("','", $selected_vendor) . "') and lc.te_ba_batch_id_c!='b18b861f-ed8d-75b6-7462-593fe8c96812' ";
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
        $sugarSmarty->display('custom/modules/AOR_Reports/tpls/vendorleadsheaderexport.tpl');
    }

}

?>

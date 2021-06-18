<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');

//error_reporting(-1);
//ini_set('display_errors', 'On');
ini_set('memory_limit', '-1');

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
        //~~~~~~~
        $report_action = '';
        $reportAccess  = reportAccessLog();

        $current_user_id = $current_user->id;
        $report_action   = isset($GLOBALS['action']) ? $GLOBALS['action'] : '';

        $exportwithArr = array();
        $exportwithArr = array(a=>'Basic',b=>'All With Cornell Column',c=>'Only Cornell Without Column');

        if (!in_array($current_user->id, $reportAccess[$report_action]) && ($current_user->is_admin != 1))
        {
            echo 'You are not authorized to access!';
            return;
        }
        //~~~~~~~
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
            '5d31a08d-d23e-a7e5-e661-6034cbfba0f3' => 'Wheebox',
            'af9384f4-266e-4de2-b036-6074239ec46d' => 'Freshersworld',
            '341b68ce-1143-3f8f-a8ea-60b48709398a' => 'Lucini',
            'f21fa038-cda9-4bb3-88c3-60b488b51675' => 'MC',
            '3db45eb8-5576-5484-43ed-60b48936fd05' => 'BQ',
            'd5ee4f91-38e1-ce31-870f-60b48a409931' => 'W2S',
            '428c236a-688c-264b-b503-60b48af4cb72' => 'BTS',
            '1d5548d6-eb8a-40c6-e1fb-60b491fcddb6' => 'Google',
            'abee435e-0fda-03ab-4013-60b492e08e72' => 'Facebook',
            '6ba222f6-c005-3be1-6bbe-60b4929e1ee9' => 'Te_Focus',
            '5feeb2dc-365b-7353-7e9a-60b492ea0f2f' => 'Linkedin',
            '2b98175d-6a90-d4ef-c751-60c093e77ee8' => 'htmedia',
            '21a9d904-4306-3814-bc3d-60c095d4daa3' => 'icubeswire',
            'f0163da1-502c-f65a-b2a0-60cc2b9a7421' => 'eweb');



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
            'ileap'        => '4a9e16bf-0396-fffc-b848-5b084550f2a8',
            'TBS'          => 'abe14a6c-00cb-13d6-2e2e-590d6f806ff4',
            'iimjobs'      => 'ee1d169a-ca0c-f3fe-d6d6-590d636bc19b',
            'CiteHR'       => '14a4e733-b709-8c60-7731-590d5cb3b1f7',
            'Career360'    => '71a590a5-0616-44d3-5248-590d5b158460',
            'Infoedge'     => '92f19224-b7b2-68e2-a112-590d64d59115',
            'intellactads' => '7eb40efc-b353-0885-1f7f-5c3733292e86',
            'OneyearMBA'   => '189101d3-837e-ca93-43ee-5c4003d0586f',
            'Proformics'   => 'b7045019-6b1b-e69b-2a18-590d67814ab3',
            'pointific'    => '681ba8eb-34fd-0a41-dbea-5de7905fa337',
            'Connective9'  => '8c6a35d9-8cfd-ae0d-5338-5efe9c41d5dc',
            'Collegedunia' => 'b2ef6323-ea47-2605-59c9-590d5cae3850',
            'Shiksha'      => '47c6f465-82a1-39d0-c96f-590d6f34c0ca',
            'Wheebox'      => '71d437b6-cff2-8145-eac7-590d71acd731',
            'Freshersworld'=> 'd1627f68-b398-e603-92a4-607424a45ab9',
            'Lucini'       => '2269098a-d030-9091-d995-60a3b764df42',
            'MC'           => '2f24b4d0-8efd-ab41-a8e1-60a3b6dae734',
            'BQ'           => '42713a80-5d94-6ea2-0c96-60a3b6412703',
            'W2S'          => 'ce78c409-86b6-9ed2-678c-60a3b7e5c0e0',
            'BTS'          => 'c69f1a11-a5bc-40ef-a6fb-60a3b77a06e6',
            'Google'       => '855c9d13-28e9-352a-2bad-590d7126ae38',
            'Facebook'     => 'becdd890-2eb2-203a-3a95-590d7161a65b',
            'Te_Focus'     => '219cf5f3-4c81-8d2c-9e30-590d708ef0fe',
            'Linkedin'     => '81e8c7cd-9501-65f2-7ac7-590d719aed14',
            'htmedia'      => '6b41a911-6080-4dc8-7306-60c093bd01e3',
            'icubeswire'   => 'be0e2ac7-8433-f864-c47d-60b5b0cfaaa4',
            'eweb'         => 'a812e51e-fa33-9945-dfd9-60c1cb93ac1a'
            );


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
            $_SESSION['cccon_exportwith']   = $_REQUEST['exportwith'];
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
        if (!empty($_SESSION['cccon_exportwith']))
        {
            $selected_exportwith = $_SESSION['cccon_exportwith'];
           
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
        if (isset($UsersVendrArr[$current_user->id]) && $UsersVendrArr[$current_user->id] == 'Wheebox')
        {
            $selected_vendor = array($vendorsIdArr['Wheebox']);
            $VendorListData  = array(array('id' => $vendorsIdArr['Wheebox'], 'name' => 'Wheebox'));
        }
        if (isset($UsersVendrArr[$current_user->id]) && $UsersVendrArr[$current_user->id] == 'Freshersworld')
        {
            $selected_vendor = array($vendorsIdArr['Freshersworld']);
            $VendorListData  = array(array('id' => $vendorsIdArr['Freshersworld'], 'name' => 'Freshersworld'));
        }
        if (isset($UsersVendrArr[$current_user->id]) && $UsersVendrArr[$current_user->id] == 'Lucini')
        {
            $selected_vendor = array($vendorsIdArr['Lucini']);
            $VendorListData  = array(array('id' => $vendorsIdArr['Lucini'], 'name' => 'Lucini'));
        }
        if (isset($UsersVendrArr[$current_user->id]) && $UsersVendrArr[$current_user->id] == 'MC')
        {
            $selected_vendor = array($vendorsIdArr['MC']);
            $VendorListData  = array(array('id' => $vendorsIdArr['MC'], 'name' => 'MC'));
        }
        if (isset($UsersVendrArr[$current_user->id]) && $UsersVendrArr[$current_user->id] == 'BQ')
        {
            $selected_vendor = array($vendorsIdArr['BQ']);
            $VendorListData  = array(array('id' => $vendorsIdArr['BQ'], 'name' => 'BQ'));
        }
        if (isset($UsersVendrArr[$current_user->id]) && $UsersVendrArr[$current_user->id] == 'W2S')
        {
            $selected_vendor = array($vendorsIdArr['W2S']);
            $VendorListData  = array(array('id' => $vendorsIdArr['W2S'], 'name' => 'W2S'));
        }
        if (isset($UsersVendrArr[$current_user->id]) && $UsersVendrArr[$current_user->id] == 'BTS')
        {
            $selected_vendor = array($vendorsIdArr['BTS']);
            $VendorListData  = array(array('id' => $vendorsIdArr['BTS'], 'name' => 'BTS'));
        }
        if (isset($UsersVendrArr[$current_user->id]) && $UsersVendrArr[$current_user->id] == 'Google')
        {
            $selected_vendor = array($vendorsIdArr['Google']);
            $VendorListData  = array(array('id' => $vendorsIdArr['Google'], 'name' => 'Google'));
        }
        if (isset($UsersVendrArr[$current_user->id]) && $UsersVendrArr[$current_user->id] == 'Facebook')
        {
            $selected_vendor = array($vendorsIdArr['Facebook']);
            $VendorListData  = array(array('id' => $vendorsIdArr['Facebook'], 'name' => 'Facebook'));
        }
        if (isset($UsersVendrArr[$current_user->id]) && $UsersVendrArr[$current_user->id] == 'TE_Focus')
        {
            $selected_vendor = array($vendorsIdArr['TE_Focus']);
            $VendorListData  = array(array('id' => $vendorsIdArr['TE_Focus'], 'name' => 'TE_Focus'));
        }
        if (isset($UsersVendrArr[$current_user->id]) && $UsersVendrArr[$current_user->id] == 'Linkedin')
        {
            $selected_vendor = array($vendorsIdArr['Linkedin']);
            $VendorListData  = array(array('id' => $vendorsIdArr['Linkedin'], 'name' => 'Linkedin'));
        }
        if (isset($UsersVendrArr[$current_user->id]) && $UsersVendrArr[$current_user->id] == 'htmedia')
        {
            $selected_vendor = array($vendorsIdArr['htmedia']);
            $VendorListData  = array(array('id' => $vendorsIdArr['htmedia'], 'name' => 'htmedia'));
        }
        if (isset($UsersVendrArr[$current_user->id]) && $UsersVendrArr[$current_user->id] == 'icubeswire')
        {
            $selected_vendor = array($vendorsIdArr['icubeswire']);
            $VendorListData  = array(array('id' => $vendorsIdArr['icubeswire'], 'name' => 'icubeswire'));
        }
        if (isset($UsersVendrArr[$current_user->id]) && $UsersVendrArr[$current_user->id] == 'eweb')
        {
            $selected_vendor = array($vendorsIdArr['eweb']);
            $VendorListData  = array(array('id' => $vendorsIdArr['eweb'], 'name' => 'eweb'));
        }

        if (!empty($selected_vendor))
        {

            $wherecl .= " AND  te_vendor.id IN ('" . implode("','", $selected_vendor) . "') and lc.te_ba_batch_id_c!='b18b861f-ed8d-75b6-7462-593fe8c96812' ";
        }
        if (!empty($selected_program))
        {

            $wherecl .= " AND  p.id IN ('" . implode("','", $selected_program) . "')";
        }

        $instField='';
        $tobeaddInstitute='';

        if (!empty($selected_exportwith) && ($selected_exportwith != 'a'))
        {   
             $instField="i.name institute,";
             $tobeaddInstitute .=" INNER JOIN te_in_institutes_te_ba_batch_1_c AS ib ON  lc.te_ba_batch_id_c=ib.te_in_institutes_te_ba_batch_1te_ba_batch_idb AND ib.deleted=0
                                   INNER JOIN te_in_institutes as i on ib.te_in_institutes_te_ba_batch_1te_in_institutes_ida=i.id AND i.deleted=0 ";

            if($selected_exportwith=='c'){
                $instField='';
                $tobeaddInstitute .=" AND i.name ='Cornell'";
            }

        }







        $leadSql = "SELECT COUNT(l.id) AS lead_count,
                    l.date_entered,
                    te_ba_batch.id AS batch_id,
                    te_ba_batch.name AS batch_name,
                    te_ba_batch.batch_code,
                    l.status,
                    $instField
                    l.vendor,
                    te_vendor.id vendor_id,
                    l.status_description
                FROM leads l
                INNER JOIN leads_cstm AS lc ON l.id=lc.id_c
                LEFT JOIN te_ba_batch ON lc.te_ba_batch_id_c = te_ba_batch.id
                LEFT JOIN te_vendor on lower(l.vendor)=lower(te_vendor.name)
                $tobeaddInstitute
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
            
            if($instField!=''){
            $programList[strtolower($row['vendor']) . '_BATCH_' . $row['batch_id']]['institute']             = isset($row['institute']) ? $row['institute'] : 'NULL';
            }


            $programList[strtolower($row['vendor']) . '_BATCH_' . $row['batch_id']]['lead_count']         = $row['lead_count'];
            $programList[strtolower($row['vendor']) . '_BATCH_' . $row['batch_id']]['status_description'] = $row['status_description'];

            $programList[strtolower($row['vendor']) . '_BATCH_' . $row['batch_id']][strtolower(str_replace(array(' ', '-'), '_', $row['status_description']))] = $row['lead_count'];

            $StatusList[strtolower(str_replace(array(' ', '-'), '_', $row['status_description']))] = $row['status_description'];
        }


        
        if (isset($_POST['export']) && $_POST['export'] == "Export")
        {



            $file     = "VendorWiseStatusDetail_report";
            $where    = '';
            $filename = $file . "_" . $from_date . "_" . $to_date;

            $data .= "Batch Name";
            $data .= ",Batch Code";
            $data .= ",Vendor";
            if($instField!=''){
            $data .= ",Institute";
            }

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
                if($instField!=''){
                $data .= "\",\"" . $councelor['institute'];
                }

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
        $sugarSmarty->assign("selected_exportwith", $selected_exportwith);
        $sugarSmarty->assign("exportwithArr", $exportwithArr);

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

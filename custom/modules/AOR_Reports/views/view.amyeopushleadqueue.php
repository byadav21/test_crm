<?php

// Date: Created on : 25th DEC 2018
//echo 'test'; die;

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
require_once('custom/modules/AOR_Reports/pagination.php');
require_once('custom/modules/AOR_Reports/UserInput.php');

//error_reporting(-1);
//ini_set('display_errors', 'On');
class AOR_ReportsViewamyeopushleadqueue extends SugarView
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
        //$this->_objInputs->syncSessions('exportHeaderWiseReport');
    }

    public function getAll($leadSql)
    {
        global $sugar_config, $app_list_strings, $current_user, $db;
        //$leadSql = "SELECT id,phone_mobile FROM  `leads` WHERE LENGTH( phone_mobile ) <>10 AND neoxstatus=0";

        $leadObj     = $db->query($leadSql);
        $programList = '';
        while ($row         = $db->fetchByAssoc($leadObj))
        {
            $programList[$row['id']]['id']                   = $row['id'];
            $programList[$row['id']]['first_name']           = $row['first_name'];
            $programList[$row['id']]['last_name']            = $row['last_name'];
            $programList[$row['id']]['phone_mobile']         = $row['phone_mobile'];
            $programList[$row['id']]['email_add_c']          = $row['email_add_c'];
            $programList[$row['id']]['planed_campagain_id']  = $row['planed_campagain_id'];
            $programList[$row['id']]['planed_api_id']        = $row['planed_api_id'];
            $programList[$row['id']]['batch_code']           = $row['batch_code'];
            $programList[$row['id']]['default_campagain_id'] = $row['default_campagain_id'];
            $programList[$row['id']]['default_api_id']       = $row['default_api_id'];
            $programList[$row['id']]['push_status']          = $row['push_status'];
            $programList[$row['id']]['reasons']              = $row['reasons'];
        }
        //echo "<pre>";print_r($programList);exit();
        # Create heading
        $data = "Id";
        $data .= ",first_name";
        $data .= ",last_name";
        $data .= ",phone_mobile";
        $data .= ",email_add_c";
        $data .= ",planed_campagain_id";
        $data .= ",planed_api_id";
        $data .= ",batch_code";
        $data .= ",default_campagain_id";
        $data .= ",default_api_id";
        $data .= ",push_status";
        $data .= ",reasons";
        $data .= "\n";
        foreach ($programList as $key => $councelor)
        {
            $data .= "\"" . $councelor['id'];
            $data .= "\",\"" . $councelor['first_name'];
            $data .= "\",\"" . $councelor['last_name'];
            $data .= "\",\"" . $councelor['phone_mobile'];
            $data .= "\",\"" . $councelor['email_add_c'];
            $data .= "\",\"" . $councelor['planed_campagain_id'];
            $data .= "\",\"" . $councelor['planed_api_id'];
            $data .= "\",\"" . $councelor['batch_code'];
            $data .= "\",\"" . $councelor['default_campagain_id'];
            $data .= "\",\"" . $councelor['default_api_id'];
            $data .= "\",\"" . $councelor['push_status'];
            $data .= "\",\"" . $councelor['reasons'];
            $data .= "\"\n";
        }
        return $data;
    }

    public function JunkCount($leadSql)
    {
        global $db;
        //$rowx = $db->fetchByAssoc($db->query($leadSql));
        $QueueCount = $db->getRowCount($db->query($leadSql));
        //echo $QueueCount;
        return $QueueCount;
    }

    public function updateLeads()
    {
        global $sugar_config, $app_list_strings, $current_user, $db;
        $headers  = array('id', 'dristi_campagain_id', 'dristi_API_id');
        //$headers2 = array();
        $filename = $_FILES["file"]["tmp_name"];

        $fileRows = file($filename);


        if (($_FILES["file"]["size"] > 1) && (count($fileRows) <= 51))
        {
            //echo count($fileRows); die;
            $file      = fopen($filename, "r");
            $headerRow = fgetcsv($file, 10000, ",");
            if (($headerRow == $headers) === FALSE)
            {
                //echo 'good'; die;
                //echo 'No';
                //echo '<pre>'; print_r($emapData);print_r($headers);die;
                echo "<script type=\"text/javascript\">
                                    alert(\"Please check the csv headers.\");
                                    window.location = \"index.php?module=AOR_Reports&action=amyeopushleadqueue\"
                                 </script>";
                die;
            }
            //fgetcsv($file);
            while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
            {
                $LeadID              = $emapData[0];
                $dristi_campagain_id = $emapData[1];
                $dristi_API_id       = $emapData[2];


                $bean = BeanFactory::getBean('Leads', $LeadID);
                //die($bean);

                if ($bean)
                {



                        $AtmpLogSql = "INSERT INTO amyeo_lead_push_tracker
                                        SET lead_id='$bean->id',
                                            last_status='$bean->status',
                                            last_sub_status='$bean->status_description',
                                            last_dristi_customer_id='$bean->dristi_customer_id',
                                            last_dristi_campagain_id='$bean->dristi_campagain_id',
                                            last_dristi_API_id='$bean->dristi_API_id',
                                            changed_dristi_campagain_id='$dristi_campagain_id',
                                            changed_dristi_API_id='$dristi_API_id',
                                            last_assigned_user_id='$bean->assigned_user_id',
                                            last_modified_user_id='$bean->modified_user_id',
                                            last_created_user_id='$bean->created_by',
                                            last_date_modified='$bean->date_modified',
                                            lead_pushed_by='$current_user->id',
                                        date_entered='" . date('Y-m-d H:i:s') . "'";

                        $res = $db->query($AtmpLogSql);
                    
                    

                        $updateSql = "update leads 
                                                SET
                                            autoassign          = 'Yes',
                                            neoxstatus          = '0',
                                            assigned_user_id    = '',
                                            status_description   = 'New Lead',
                                            status              = 'Alive',
                                            dristi_campagain_id = $dristi_campagain_id,
                                            dristi_API_id       = $dristi_API_id,
                                            date_modified       = NOW(),
                                            dristi_customer_id  = '' where id='$bean->id'"; 
                        $updateSqlres = $db->Query($updateSql);

                        if ($updateSqlres)
                        {
                            $guidid = create_guid();
                            $insertSql         = "INSERT INTO te_disposition
                                                SET id          =   '$guidid',
                                            status              =   'Alive',
                                            status_detail       =   'New Lead',
                                            date_modified       =   NOW(),
                                            date_entered        =   NOW()";
                            $te_disposition_id = $db->Query($insertSql);
                            
                            
                            $guidid2        = create_guid();
                            $insertDis_cSql = "INSERT INTO te_disposition_leads_c
                                                SET id          =   '$guidid2',
                          te_disposition_leadste_disposition_idb=   '$guidid',
                          te_disposition_leadsleads_ida         =   '$bean->id',
                                            date_modified=NOW()";
                            $db->Query($insertDis_cSql);
                        }
                   


                        /*$bean->autoassign          = 'Yes';
                          $bean->neoxstatus          = 0;
                          $bean->assigned_user_id    = '';
                          $bean->status_description  = 'New Lead';
                          $bean->status              = 'Alive';
                          $bean->dristi_campagain_id = $dristi_campagain_id;
                          $bean->dristi_API_id       = $dristi_API_id;
                          $bean->date_modified       = date('Y-m-d H:i:s');
                          $bean->dristi_customer_id  = '';
                          $checkSaveBean             = $bean->save();
                         */


                    
                }
            }


            fclose($file);
            clearstatcache();
            //throws a message if data successfully imported to mysql database from excel file
            echo "<script type=\"text/javascript\">
                        alert(\"CSV File has been successfully Imported.\");
                        window.location = \"index.php?module=AOR_Reports&action=amyeopushleadqueue\"
                     </script>";
            die;
        }
        else
        {

            echo "<script type=\"text/javascript\">
                        alert(\"error: Lead Records are up-to 5.\");
                        window.location = \"index.php?module=AOR_Reports&action=amyeopushleadqueue\"
                     </script>";
            die;
        }
    }

    public function display()
    {

        global $sugar_config, $app_list_strings, $current_user, $db;
        $current_user_id = $current_user->id;
        $_export         = isset($this->_objInputs->post['export_queue_list']) && $this->_objInputs->post['export_queue_list'] == "export_queue_list";
        $_export_junk    = isset($this->_objInputs->post['export_junk_leads']) && $this->_objInputs->post['export_junk_leads'] == "export_junk_leads";
        $_update_leadset = isset($this->_objInputs->post['update_leadset']) && $this->_objInputs->post['update_leadset'] == "Upload";


        $where   = "";
        $wherecl = "";

        $snagLeadSql = "SELECT  l.id,
                            l.first_name,
                            l.last_name,
                            l.phone_mobile,
                            leads_cstm.email_add_c,
                            dristi_campagain_id planed_campagain_id,
                            dristi_api_id as planed_api_id,
                            te_ba_batch.batch_code,
                            te_ba_batch.d_campaign_id as default_campagain_id,
                            te_ba_batch.d_lead_id as default_api_id,
                            dul.resultTypeString push_status,
                            dul.text reasons
                     FROM leads l
                     LEFT JOIN leads_cstm ON l.id= leads_cstm.id_c
                     LEFT JOIN te_ba_batch ON leads_cstm.te_ba_batch_id_c= te_ba_batch.id
                     LEFT JOIN dristi_upload_logs dul ON l.id= dul.lead_id
                     WHERE l.deleted =0
                       AND l.status_description= 'New Lead'
                       AND l.neoxstatus='0'
                       AND dristi_campagain_id !=''
                       AND dristi_api_id !=''
                       AND (l.assigned_user_id= 'NULL'
                            OR l.assigned_user_id =''
                            OR l.assigned_user_id IS NULL) 
                       and dul.resultTypeString!='ADDED'
                       and dul.dated >= NOW() - INTERVAL 10 DAY
                       and dul.dated <= NOW()
                     group by l.id
                     ORDER BY dul.dated desc";



        $junkCount = $this->JunkCount($snagLeadSql);




        $headers = array(
            'l.id'                      => 'Lead ID',
            'l.first_name'              => 'First Name',
            'l.last_name'               => 'Last Name',
            'l.phone_mobile'            => 'Phone Mobile',
            'leads_cstm.email_add_c'    => 'Email Address',
            'dristi_campagain_id'       => 'Planed Campagain ID',
            'dristi_api_id'             => 'Planed API ID',
            'te_ba_batch.batch_code'    => 'Batch Code',
            'te_ba_batch.d_campaign_id' => 'Defualt Campagain ID',
            'te_ba_batch.d_lead_id'     => 'Defualt API ID');

        $stringHeaders = implode(",", array_keys($headers));

        $sqlPart = "
               FROM leads l
                 LEFT JOIN leads_cstm ON l.id= leads_cstm.id_c
                 LEFT JOIN te_ba_batch ON leads_cstm.te_ba_batch_id_c= te_ba_batch.id
                 WHERE l.deleted =0
                   AND l.status_description= 'New Lead'
                   AND l.neoxstatus='0'
                   AND dristi_campagain_id !=''
                   AND dristi_api_id !=''
                   AND (l.assigned_user_id= 'NULL'
                        OR l.assigned_user_id =''
                        OR l.assigned_user_id IS NULL)
                 ORDER BY l.date_entered desc";

        $countSql = "SELECT count(1) as count " . $sqlPart;



        $leadSql    = "SELECT $stringHeaders " . $sqlPart;
        $QueueCount = $db->getRowCount($db->query($leadSql));
        if (!$_export)
        {
            $limit   = $this->objPagination->get_limit();
            $leadSql .= ' ' . $limit;
        }
        $rowCount = 0;
        $leadObj  = null;

        if ($_export)
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
                $leadObj = $db->query($leadSql);
            }
        }

        if ($_export_junk)
        {


            $data = $this->getAll($snagLeadSql);
            ob_end_clean();
            header("Content-type: application/csv");
            header('Content-disposition: attachment;filename="SnagList_' . date('Y-m-d H:i:s') . '.csv";');
            echo $data;
            exit;
        }

        if ($_export)
        {
            global $db;
            $data = "";
            $data .= implode(",", $headers);
            $data .= "\n";
            ob_end_clean();
            header("Content-type: application/csv");
            header('Content-disposition: attachment;filename="QueueListLeads_' . date('Y-m-d H:i:s') . '.csv";');
            echo $data;
            while ($row  = $db->fetchByAssoc($leadObj))
            {
                $data = implode(',', $row);
                $data .= "\n";
                echo $data;
            }
            exit;
        }
        if ($_update_leadset)
        {
            global $db, $current_user;
            $this->updateLeads();
            echo 'xx';
            die;
        }


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
                $leadList[$row['id']] = $row;
            }
            $this->objPagination->set_found_rows(count($leadList));
        }
        $current = $this->objPagination->getHeading();

        #pE


        $sugarSmarty = new Sugar_Smarty();

        $sugarSmarty->assign("error", $error);
        $sugarSmarty->assign("leadList", $leadList);
        $sugarSmarty->assign("headers", $headers);
        $sugarSmarty->assign("tablewidth", count($headers) * 130);
        $sugarSmarty->assign("QueueCount", $QueueCount);
        $sugarSmarty->assign("junkCount", $junkCount);

        $sugarSmarty->assign("campaignIDs", $campaignID);
        $sugarSmarty->assign("leadIDs", $leadID);
        $sugarSmarty->assign("ExcelHeaders", $ExcelHeaders);
        $sugarSmarty->assign("current_records", $current);
        $sugarSmarty->assign("page", $page);
        $sugarSmarty->assign("pagenext", $pagenext);
        $sugarSmarty->assign("pageprevious", $pageprevious);
        $sugarSmarty->assign("right", $right);
        $sugarSmarty->assign("left", $left);
        $sugarSmarty->assign("last_page", $last_page);
        $sugarSmarty->display('custom/modules/AOR_Reports/tpls/amyeopushleadqueue.tpl');
    }

}
?>


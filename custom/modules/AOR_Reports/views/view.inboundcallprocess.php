<?php

// Date: Created on : 25th DEC 2018
//echo 'test'; die;

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
require_once('custom/modules/AOR_Reports/pagination.php');
require_once('custom/modules/AOR_Reports/UserInput.php');
require_once('custom/include/Email/sendmail.php');
require_once('modules/EmailTemplates/EmailTemplate.php');

//error_reporting(E_ALL);
//ini_set('display_errors', 'On');
class AOR_ReportsViewinboundcallprocess extends SugarView
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

    public function createNewLead($mobileArr, $csvArray)
    {
        global $sugar_config, $app_list_strings, $current_user, $db;

        if (!empty($mobileArr))
        {


            foreach ($mobileArr as $key => $val)
            {
                //print_r($mobileArr); die;
                if ($val == 'false')
                {
                    //secho '$key==='.$key;

                    $newLeadArr = $csvArray[$key];
                    //echo '<pre>';
                    //print_r($newLeadArr); 
                    //die;
                    ////
                    $leadID     = create_guid();

                    $insertLeadSql = "insert into leads 
                                                SET
                                            id='$leadID',
                                            phone_mobile         = '$key',
                                            status_description   = '" . $newLeadArr['sub_status'] . "',
                                            status               = '" . $newLeadArr['status'] . "',
                                            vendor               = 'Generic_Abdn',
                                            lead_source          = 'CC_Generic_Abdn',
                                            utm_term_c           = '" . $newLeadArr['batch_code'] . "',
                                            date_entered         = '" . date('Y-m-d H:i:s') . "',
                                            date_modified        = '" . date('Y-m-d H:i:s') . "'";
                    $leadSqlres    = $db->Query($insertLeadSql);

                    if ($leadSqlres)
                    {



                        $insertLeadSql  = "insert into leads_cstm
                                                    SET
                                                id_c='$leadID',
                                                te_ba_batch_id_c     = '" . $newLeadArr['batch_id'] . "',
                                                email_add_c          = '" . $newLeadArr['dummy_email'] . "'";
                        $leadCSTMSqlres = $db->Query($insertLeadSql);


                        $emailIDadd     = create_guid();
                        $emailIDrel     = create_guid();
                        $emailaddSql    = "insert into email_addresses
                                                    SET
                                                id='$emailIDadd',
                                                email_address_caps     = '" . strtoupper($newLeadArr['dummy_email']) . "',
                                                date_created           = '" . date('Y-m-d H:i:s') . "',
                                                date_modified          = '" . date('Y-m-d H:i:s') . "',
                                                email_address          = '" . $newLeadArr['dummy_email'] . "'";
                        $leadCSTMSqlres = $db->Query($emailaddSql);

                        $insertLeadSql  = "insert into email_addr_bean_rel
                                                    SET
                                                id= '$emailIDrel',
                                                bean_module         ='Leads',
                                                bean_id             ='$leadID',
                                                date_created        = '" . date('Y-m-d H:i:s') . "',
                                                date_modified       = '" . date('Y-m-d H:i:s') . "',
                                                email_address_id    = '$emailIDadd'";
                        $leadCSTMSqlres = $db->Query($insertLeadSql);
                    }


                    if ($leadCSTMSqlres)
                    {
                        $guidid            = create_guid();
                        $insertSql         = "INSERT INTO te_disposition
                                                        SET id          =   '$guidid',
                                                    status              =   '" . $newLeadArr['status'] . "',
                                                    status_detail       =   '" . $newLeadArr['sub_status'] . "',
                                                    date_modified       =   '" . date('Y-m-d H:i:s') . "',
                                                    date_entered        =   '" . date('Y-m-d H:i:s') . "'";
                        $te_disposition_id = $db->Query($insertSql);


                        $guidid2        = create_guid();
                        $insertDis_cSql = "INSERT INTO te_disposition_leads_c
                                                        SET id          =   '$guidid2',
                                                    te_disposition_leadste_disposition_idb=   '$guidid',
                                                    te_disposition_leadsleads_ida         =   '$leadID',
                                                    date_modified='" . date('Y-m-d H:i:s') . "'";
                        $db->Query($insertDis_cSql);

                        $AtmpLogSql = "INSERT INTO inbound_abandon_leads
                                                    SET lead_id='$leadID',
                                            dummy_email='" . $newLeadArr['dummy_email'] . "',
                                            batch_id='" . $newLeadArr['batch_id'] . "',
                                            batch_code='" . $newLeadArr['batch_code'] . "',
                                            status='" . $newLeadArr['status'] . "',
                                            sub_status='" . $newLeadArr['sub_status'] . "',
                                            lead_pushed_by='$current_user->id',
                                            date_entered='" . date('Y-m-d H:i:s') . "'";

                        $res = $db->query($AtmpLogSql);
                    }

                    ////
                }//END of if false cond
            }
        }
    }

    public function updateLeads()
    {
        global $sugar_config, $app_list_strings, $current_user, $db;

        $exclude_newlead = $_POST['exclude_newlead'];
        $exclude_email   = $_POST['exclude_email'];
        $headers         = array('mobile', 'dummy_email', 'batch_id', 'batch_code', 'status', 'sub_status');
        //$headers2 = array();
        $filename        = $_FILES["file"]["tmp_name"];

        $fileRows = file($filename);


        if (($_FILES["file"]["size"] > 1) && (count($fileRows) <= 500))
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
                                    window.location = \"index.php?module=AOR_Reports&action=inboundcallprocess\"
                                 </script>";
                die;
            }
            //fgetcsv($file);

            $csvArray       = array();
            $csvMobile      = array();
            $mobileNotFound = array();
            $mobileQuery    = '';
            $dataFoundinCRM = array();

            $activeMobileData = array();

            $activeBatchStatus              = array('enrollment_in_progress', 'planned');
            $activeLeadStatus               = array('Alive', 'Warm');
            $inactiveLeadfind               = array('Alive', 'Warm', 'Converted');
            $inactiveBatchLeadsToNewLeadArr = array();
            while (($emapData                       = fgetcsv($file, 10000, ",")) !== FALSE)
            {
                $mobile           = $emapData[0];
                $dummy_email      = $emapData[1];
                $dummy_batch_id   = $emapData[2];
                $dummy_batch_code = $emapData[3];
                $dummy_status     = $emapData[4];
                $dummy_sub_status = $emapData[5];

                $csvArray[$mobile] = array('dummy_email' => $dummy_email,
                    'batch_id'    => $dummy_batch_id,
                    'batch_code'  => $dummy_batch_code,
                    'status'      => $dummy_status,
                    'sub_status'  => $dummy_sub_status);
                $csvMobile[]       = $mobile;
                $mobileQuery       .= " or leads.phone_mobile LIKE '$mobile%' ";
            }

            $mobileSql = substr($mobileQuery, 3);
            $queryX    = "SELECT leads.id,
                                leads.date_entered,
                                leads.date_modified,
                                leads.date_of_followup,
                                leads.assigned_user_id,
                                leads.date_of_prospect,
                                leads.status,
                                leads.status_description,
                                leads.disposition_reason,
                                users.user_name agentName,
                                leads.first_name,
                                leads.phone_mobile,
                                te_ba_batch.batch_code,
                                te_ba_batch.batch_status,
                                leads_cstm.`attempts_c`,
                                leads.`autoassign`,
                                leads.`dristi_campagain_id`,
                                leads.`dristi_API_id`,
                                leads.neoxstatus,
                                leads.`callType`,
                                leads.`dispositionName`,
                                leads.`dristi_customer_id`
                                
                         FROM leads
                            LEFT JOIN users ON leads.assigned_user_id =users.id
                            LEFT JOIN leads_cstm ON leads.id= leads_cstm.id_c
                            LEFT JOIN te_ba_batch ON leads_cstm.te_ba_batch_id_c= te_ba_batch.id
                         WHERE $mobileSql order by phone_mobile";
            //$dataQuery = $db->fetchByAssoc($db->query($queryX));
            $dataObj   = $db->query($queryX);
            while ($row       = $db->fetchByAssoc($dataObj))
            {
                $dataFoundinCRM[$row['phone_mobile']][] = $row;
                //echo 'batch_status=='.$row['batch_status'];
                if (in_array($row['batch_status'], $activeBatchStatus) && in_array($row['status'], $activeLeadStatus) && $row['agentName'] != '')
                {
                    //echo "Match found<br>";
                    $activeMobileData[$row['agentName']][] = $row;
                }
                else if (!in_array($row['batch_status'], $activeBatchStatus) && !in_array($row['status'], $inactiveLeadfind))
                {
                    //echo "No Match found".$row['phone_mobile']."<br>";
                    $inactiveBatchLeadsToNewLeadArr[$row['phone_mobile']] = isset($dataFoundinCRM[$row['phone_mobile']]) ? 'false' : 'true';
                }
            }

            foreach ($csvArray as $key => $val)
            {
                $mobileNotFound[$key] = isset($dataFoundinCRM[$key]) ? 'true' : 'false';
            }

            if ($exclude_newlead != 1)
            {
                //$this->createNewLead($mobileNotFound,$csvArray);
            }
            if (!empty($inactiveBatchLeadsToNewLeadArr) && $exclude_newlead !== 1)
            {

                //$this->createNewLead($inactiveBatchLeadsToNewLeadArr,$csvArray);
            }
            $mail = new NetCoreEmail();
            if ($exclude_email != 1)
            {



                foreach ($activeMobileData as $key => $val)
                {
                    //$urlx          = $GLOBALS['sugar_config']['site_url'];
                    //echo '<pre>'; print_r($activeMobileData); die;
                    $email_summary = '
        
   <table cellpadding="0" cellspacing="0" style="width: 600px; border:1px solid #999; padding: 10px;" align="center">
        
        <tr>
            <td style="font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#333; text-align: center; font-weight: bold;">Inbound Lead Request Details</td>
        </tr>
        <tr>
            <td><hr/></td>
        </tr>
        <tr>
            <td height="15"></td>
        </tr>
        <tr>
        	<td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333; text-align: left; font-weight: bold;">Hi,</td>
        </tr>
        
        <tr>
            <td height="15"></td>
        </tr>
        <tr>
            <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333; text-align: left; font-weight: bold;">Below is the information of inbound request</td>
        </tr>
        <tr>
        	<td height="15"></td>
        </tr>
        <tr>
            <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333; text-align: left; font-weight: bold;">
               <table cellpadding="0" cellspacing="0" style="width: 800px; border:1px solid #999; padding: 10px; border-collapse: collapse;" align="center">
                <tr>
                    <th style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif;   padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: bold;">Lead id</th>
                    <th style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif;   padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: bold;">Date Entered</th>
                    <th style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif;   padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: bold;">Date Modified</th>
                    <th style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif;   padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: bold;">Date of Followup</th>
                    <th style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif;   padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: bold;">Date of Prospect</th>
                    <th style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif;   padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: bold;">Status</th>
                    <th style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif;   padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: bold;">Status Description</th>
                    <th style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif;   padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: bold;">Disposition Reason</th>
                    <th style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif;   padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: bold;">Batch Code</th>
                    <th style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif;   padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: bold;">First Name</th>
                    <th style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif;   padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: bold;">Phone number</th>

                </tr>';
                    foreach ($val as $keyx => $val)
                    {
                        $email_summary .= '<tr>
                    <td style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif;   padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: bold;"> ' . $val['id'] . ' </td>
                    <td style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif;   padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: bold;"> ' . $val['date_entered'] . ' </td>
                    <td style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif;   padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: bold;"> ' . $val['date_modified'] . ' </td>
                    <td style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif;   padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: bold;"> ' . $val['date_of_followup'] . ' </td>
                    <td style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif;   padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: bold;"> ' . $val['date_of_prospect'] . ' </td>
                    <td style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif;   padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: bold;"> ' . $val['status'] . ' </td>
                    <td style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif;   padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: bold;"> ' . $val['status_description'] . ' </td>
                    <td style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif;   padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: bold;"> ' . $val['disposition_reason'] . ' </td>
                    <td style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif;   padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: bold;"> ' . $val['batch_code'] . ' </td>
                    <td style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif;   padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: bold;"> ' . $val['first_name'] . ' </td>
                    <td style="border:1px solid #999; font-family:Arial, Helvetica, sans-serif;   padding: 10px; font-size:12px; color:#333; text-align: left; font-weight: bold;"> ' . $val['phone_mobile'] . ' </td>
     
                </tr>';
                    }
                    $email_summary .= '</table> 
            </td>
        </tr>
       
        <tr>
            <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333; text-align: left; font-weight: bold;">Regards</td>
        </tr>
         <tr>
            <td height="8"></td>
        </tr>
        <tr>
            <td style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#333; text-align: left;">Pawan (IT)</td>
        </tr>
     </table>';
                    //echo $key;
                    //echo $email_summary; die;

                    if ($key == 'pawan.kumar@talentedge.in')
                    {
                        //echo $email_summary; die;
                        $emailData = $mail->sendEmail($key, 'Inbound request list_' . date('Y-m-d'), $email_summary);
                        //echo '$emailData'.$emailData; die;
                    }
                }
            }

            //echo 'exclude_email=' . $exclude_email;
            //echo 'exclude_newlead=' . $exclude_newlead;
            //echo '<pre>';
            //print_r($inactiveBatchLeadsToNewLeadArr);
            //die();



            fclose($file);
            clearstatcache();

            return array('activeMobileData'               => $activeMobileData,
                'inactiveBatchLeadsToNewLeadArr' => $inactiveBatchLeadsToNewLeadArr,
                'dataFoundinCRM'                 => $dataFoundinCRM,
                'mobileNotFound'                 => $mobileNotFound);
            //throws a message if data successfully imported to mysql database from excel file
            //            echo "<script type=\"text/javascript\">
            //                        alert(\"CSV File has been successfully Imported.\");
            //                        window.location = \"index.php?module=AOR_Reports&action=inboundcallprocess\"
            //                     </script>";
            //            die;
        }
        else
        {

            echo "<script type=\"text/javascript\">
                        alert(\"error: Lead Records are up-to 500.\");
                        window.location = \"index.php?module=AOR_Reports&action=inboundcallprocess\"
                     </script>";
            die;
        }
    }

    public function display()
    {

        global $sugar_config, $app_list_strings, $current_user, $db;
        $current_user_id = $current_user->id;

        $people = array("d81fc9e1-91ae-eba3-19d9-5af02415c81c", //kiran
            "c7e41406-1f7b-770e-6d0b-5ab0076957ce", //ritika
            "9e6a7631-ca80-74f6-b734-599b04f9af60", //anup
        );

        if (!in_array($current_user->id, $people) && ($current_user->is_admin != 1))
        {
            echo 'You are not authorized to access!';
            return;
        }
        $export_data_all_data_found = isset($this->_objInputs->post['export_data_all_data_found']) && $this->_objInputs->post['export_data_all_data_found'] == "export_data_all_data_found";
        $organicleads               = isset($this->_objInputs->post['organicleads']) && $this->_objInputs->post['organicleads'] == "organicleads";
        $_update_leadset            = isset($this->_objInputs->post['update_leadset']) && $this->_objInputs->post['update_leadset'] == "Upload";


        $where   = "";
        $wherecl = "";


        $dataFoundinCRMTPL   = array();
        $mobileNotFoundInCrm = array();
        if ($_update_leadset)
        {
            global $db, $current_user;
            $Data = $this->updateLeads();

            $_SESSION['dataFoundinCRMTPL']         = $Data['dataFoundinCRM'];
            $_SESSION['mobileNotFound']            = $Data['mobileNotFound'];
            $activeMobileDataTPL                   = $Data['activeMobileData'];
            $datainactiveBatchLeadsToNewLeadArrTPL = $Data['inactiveBatchLeadsToNewLeadArr'];

            //echo 'xx';
            //die;
        }



        $organicleadsX = array();

        $dataFoundinCRMTPL = isset($_SESSION['dataFoundinCRMTPL'])? $_SESSION['dataFoundinCRMTPL'] : array();;
        $organicleadsX     = isset($_SESSION['mobileNotFound'])? $_SESSION['mobileNotFound'] : array();

        if ($export_data_all_data_found)
        {



            $data = "Id";
            $data .= ",date_entered";
            $data .= ",date_modified";
            $data .= ",date_of_followup";
            $data .= ",assigned_user_id";
            $data .= ",date_of_prospect";
            $data .= ",status";
            $data .= ",status_description";
            $data .= ",disposition_reason";
            $data .= ",agentName";
            $data .= ",first_name";
            $data .= ",phone_mobile";
            $data .= ",batch_code";
            $data .= ",batch_status";
            $data .= ",attempts_c";
            $data .= ",autoassign";
            $data .= ",dristi_campagain_id";
            $data .= ",dristi_API_id";
            $data .= ",neoxstatus";
            $data .= ",callType";
            $data .= ",dispositionName";
            $data .= ",dristi_customer_id";
            $data .= "\n";
            //echo '<pre>';
            //print_r($dataFoundinCRMTPL);
            //die;
            foreach ($dataFoundinCRMTPL as $key => $val)
            {
                //print_r($val);
                foreach ($val as $key => $valx)
                {

                    $data .= "\"" . $valx['id'];
                    $data .= "\",\"" . $valx['date_entered'];
                    $data .= "\",\"" . $valx['date_modified'];
                    $data .= "\",\"" . $valx['date_of_followup'];
                    $data .= "\",\"" . $valx['assigned_user_id'];
                    $data .= "\",\"" . $valx['date_of_prospect'];
                    $data .= "\",\"" . $valx['status'];
                    $data .= "\",\"" . $valx['status_description'];
                    $data .= "\",\"" . $valx['disposition_reason'];
                    $data .= "\",\"" . $valx['agentName'];
                    $data .= "\",\"" . $valx['first_name'];
                    $data .= "\",\"" . $valx['phone_mobile'];
                    $data .= "\",\"" . $valx['batch_code'];
                    $data .= "\",\"" . $valx['batch_status'];

                    $data .= "\",\"" . $valx['attempts_c'];
                    $data .= "\",\"" . $valx['autoassign'];
                    $data .= "\",\"" . $valx['dristi_campagain_id'];
                    $data .= "\",\"" . $valx['dristi_API_id'];
                    $data .= "\",\"" . $valx['neoxstatus'];
                    $data .= "\",\"" . $valx['callType'];
                    $data .= "\",\"" . $valx['dispositionName'];
                    $data .= "\",\"" . $valx['dristi_customer_id'];
                    $data .= "\"\n";
                }
            }

            ob_end_clean();
            header("Content-type: application/csv");
            header('Content-disposition: attachment;filename="SnagList_' . date('Y-m-d H:i:s') . '.csv";');
            echo $data;
            //unset($_SESSION['dataFoundinCRMTPL']);
            exit;
        }

        $theActualnotFound = array();
        if ($organicleads)
        {
            global $db;


            foreach ($organicleadsX as $key => $val)
            {
                if ($val == 'false')
                {
                    $theActualnotFound[$key] = $val;
                }
            }
            $_SESSION['theActualnotFound'] = $theActualnotFound;
            //print_r($theActualnotFound);die;

            $data = "Mobile";
            $data .= ",Found Status";
            $data .= "\n";
            //echo '<pre>';
            //print_r($organicleadsX); die;
            foreach ($theActualnotFound as $key => $val)
            {

                $data .= "\"" . $key;
                $data .= "\",\"" . $val;
                $data .= "\"\n";
            }

            ob_end_clean();
            header("Content-type: application/csv");
            header('Content-disposition: attachment;filename="organicleads_' . date('Y-m-d H:i:s') . '.csv";');
            echo $data;
            //unset($_SESSION['mobileNotFound']);
            exit;
        }






        $sugarSmarty = new Sugar_Smarty();
        //echo 'ss=='.count($_SESSION['theActualnotFound']);
        //print_r($_SESSION['theActualnotFound']);
        $sugarSmarty->assign("dataFoundinCRMTPL", $dataFoundinCRMTPL);
        $sugarSmarty->assign("dataFoundinCRMTPLCount", count($dataFoundinCRMTPL));
        $sugarSmarty->assign("organicleadsXCount", count($_SESSION['theActualnotFound']));



        $sugarSmarty->display('custom/modules/AOR_Reports/tpls/inboundcallprocess.tpl');
    }

}
?>


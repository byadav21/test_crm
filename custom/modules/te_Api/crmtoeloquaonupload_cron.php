<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
ini_set('memory_limit', '1024M');
require_once('include/entryPoint.php');
require_once('custom/modules/Leads/eloqua/lib/eloquaRequest.php');

//error_reporting(-1);
//ini_set('display_errors', 'On');

global $db;
error_reporting(-1);
ini_set('display_errors', 'On');

class uploadToEloqua
{

    function createLog($req, $action)
    {
        $file = fopen(str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']) . "upload/apilog/eloqua_manual_upload_log.txt", "a");
        fwrite($file, date('Y-m-d H:i:s') . "\n");
        fwrite($file, $action . "\n");
        fwrite($file, print_r($req, TRUE) . "\n");
        fclose($file);
    }

    function getUploadedLeads()
    {

        global $db;
       $leadsCstmData= array();
       echo $query ="SELECT leads.`id`,
                                        lc.email_add_c,
                                        #'testcccWstests02@test.com' AS email_add_c,
                                        leads.`primary_address_street`,
                                        leads.`primary_address_city`,
                                        leads.`primary_address_state`,
                                        leads.`primary_address_country`,
                                        leads.`primary_address_postalcode`,
                                        leads.`comment`,
                                        leads.`first_name`,
                                        leads.`last_name`,
                                        leads.`phone_other`,
                                        leads.`phone_mobile`,
                                        #'9971502476' AS phone_mobile,
                                        leads.`status`,
                                        leads.`status_description`,
                                        leads.`lead_source`,
                                        leads.`utm`,
                                        leads.`vendor`,
                                        leads.`assigned_user_id`,
                                        leads.`utm_term_c`, 
                                        leads.`utm_source_c`,
                                        leads.`utm_campaign`,
                                        lc.`attempts_c`,
                                        lc.`company_c`,
                                        lc.`functional_area_c`,
                                        bb.id batch_id,
                                        bb.batch_code,
                                        #'XXX_YYY' AS batch_code,
                                        bb.batch_status,
                                        inst.name institutes_name,
                                        prog.name program_name
                                 FROM `leads`
                        LEFT JOIN  leads_cstm lc ON leads.id=lc.id_c
                        LEFT JOIN te_ba_batch bb ON lc.te_ba_batch_id_c= bb.id
                        LEFT JOIN `te_pr_programs_te_ba_batch_1_c` pr_rel ON bb.id=pr_rel.te_pr_programs_te_ba_batch_1te_ba_batch_idb
                        LEFT JOIN  `te_in_institutes_te_ba_batch_1_c` inst_rel ON bb.id=inst_rel.te_in_institutes_te_ba_batch_1te_ba_batch_idb
                        LEFT JOIN `te_in_institutes` inst ON inst_rel.te_in_institutes_te_ba_batch_1te_in_institutes_ida=inst.id
                        LEFT JOIN  `te_pr_programs` prog ON pr_rel.te_pr_programs_te_ba_batch_1te_pr_programs_ida=prog.id
                        WHERE DATE(leads.date_entered) =  '".date('Y-m-d')."' 
                        AND leads.upload_status=1 
                        AND eloqua_manual_up_status='0'";
        $leadObj = $db->query($query);
        if ($leadObj)
        {

            while ($row = $db->fetchByAssoc($leadObj))
            {
                $leadsCstmData[] = $row;
            }
        }

        return $leadsCstmData;
    }

    function main()
    {
        global $db;
        $leadsCstmData = array();

        $manualUploadDataArr = $this->getUploadedLeads();
        
        //echo "<pre>";  print_r($manualUploadDataArr); die;


        foreach ($manualUploadDataArr as $key => $data)
        {
         

            $client      = new EloquaRequest('https://secure.p07.eloqua.com/API/REST/1.0');
            $contact     = array();
            $contactIDXX = '';
            // instantiate a new instance of the Contact class  
            $contact     = array(
                'emailAddress'  => $data['email_add_c'],
                'accountName'   => isset($data['assigned_user_id']) ? $data['assigned_user_id'] : '',
                'address1'      => isset($data['primary_address_street']) ? $data['primary_address_street'] : '',
                'address2'      => isset($data['alt_address_street']) ? $data['alt_address_street'] : '',
                'businessPhone' => isset($data['phone_mobile']) ? $data['phone_mobile'] : '',
                'city'          => isset($data['primary_address_city']) ? $data['primary_address_city'] : '',
                'country'       => isset($data['primary_address_country']) ? $data['primary_address_country'] : '',
                'description'   => isset($data['comment']) ? $data['comment'] : '',
                'firstName'     => isset($data['first_name']) ? $data['first_name'] : '',
                'lastName'      => isset($data['last_name']) ? $data['last_name'] : '',
                'mobilePhone'   => isset($data['phone_other']) ? $data['phone_other'] : $data['phone_mobile'],
                'postalCode'    => isset($data['primary_address_postalcode']) ? $data['primary_address_postalcode'] : ''
            );

             //echo "<pre>";  print_r($contact); 
            //echo json_encode($contact);



            $responsex = $client->post('data/contact', $contact);

            $this->createLog($responsex, '{On lead Create}');

            //echo "<pre>bean="; print_r($bean);
            //echo 'leadId='.$bean->id.'$response->id='.$responsex->id."<pre>inCreate="; print_r($responsex); die;

            if (isset($responsex->id) && $responsex->id != '')
            {
                $contactIDXX = $responsex->id;
                $db->query("update leads_cstm  set eloqua_contact_id=$contactIDXX where  id_c='" . $data['id'] . "'");
            }

           // if ($contactId != '')
           // {
            $client = new EloquaRequest('https://secure.p07.eloqua.com/API/REST/1.0');
            

            $emailIDX  = isset($data['email_add_c']) ? $data['email_add_c'] : '';
            $batchCode = isset($data['batch_code']) ? $data['batch_code'] : 'Generic_2017-18';
            $contact   = array(
                'type'        => 'CustomObjectData',
                'contactId'   => $contactIDXX,
                'fieldValues' =>
                array(
                    0  => array('id' => '150', 'value' => $emailIDX),
                    1  => array('id' => 151, 'value' => $emailIDX . '_' . $batchCode),
                    2  => array('id' => 152, 'value' => $batchCode),
                    3  => array('id' => 171, 'value' => isset($data['batch_status']) ? $data['batch_status'] : ''),
                    4  => array('id' => 153, 'value' => isset($data['status']) ? $data['status'] : ''),
                    5  => array('id' => 154, 'value' => isset($data['status_description']) ? $data['status_description'] : ''),
                    6  => array('id' => 155, 'value' => isset($data['lead_source']) ? $data['lead_source'] : ''),
                    7  => array('id' => 156, 'value' => isset($data['phone_mobile']) ? $data['phone_mobile'] : ''),
                    8  => array('id' => 157, 'value' => isset($data['UTM']) ? $data['UTM'] : ''),
                    9  => array('id' => 158, 'value' => isset($data['vendor']) ? $data['vendor'] : ''),
                    10 => array('id' => 159, 'value' => isset($data['assigned_user_id']) ? $data['assigned_user_id'] : ''),
                    11 => array('id' => 160, 'value' => isset($data['first_name']) ? $data['first_name'] : ''),
                    12 => array('id' => 161, 'value' => isset($data['last_name']) ? $data['last_name'] : ''),
                    13 => array('id' => 162, 'value' => isset($data['program_name']) ? $data['program_name'] : ''),
                    14 => array('id' => 163, 'value' => isset($data['attempts_c']) ? $data['attempts_c'] : ''),
                    15 => array('id' => 164, 'value' => isset($data['utm_term_c']) ? $data['utm_term_c'] : ''),
                    16 => array('id' => 165, 'value' => isset($data['utm_source_c']) ? $data['utm_source_c'] : ''),
                    17 => array('id' => 166, 'value' => isset($data['utm_campaign']) ? $data['utm_campaign'] : ''),
                    18 => array('id' => 167, 'value' => isset($data['primary_address_city']) ? $data['primary_address_city'] : ''),
                    19 => array('id' => 168, 'value' => isset($data['company_c']) ? $data['company_c'] : ''),
                    20 => array('id' => 169, 'value' => isset($data['functional_area']) ? $data['functional_area'] : ''),
                    21 => array('id' => 170, 'value' => isset($data['institutes_name']) ? $data['institutes_name'] : '')
                ),
            );

            //echo "<pre>in Object Create="; print_r($contact); die;
           
            $response = $client->post('data/customObject/7', $contact);
            $this->createLog($contact, '{On LeadObjec param}');
            $this->createLog($response, '{On LeadObjec response}');
            
            $array    = json_decode(json_encode($response), true);
             
            echo '<pre>';
            print_r($array);
            //echo '$response->id'.$response->id;
            //echo '$response->parameter'.$array[0]['parameter'];
            if (isset($array['id']) && $array['id']!='')
            {
                //$contactIdx = $response->id;
                $db->query("update leads_cstm  set eloqua_customobject_id=".$array['id'].",eloqua_contact_id=".$array['contactId'].",eloqua_manual_up_status='1' where  id_c='" . $data['id'] . "'");
            }
            else if (isset($array[0]['parameter']) && $array[0]['parameter']=='DuplicateValue')
            {
                $db->query("update leads_cstm  set eloqua_manual_up_status='2' where  id_c='" . $data['id'] . "'");
            }
       // }// END of  if ($contactId != '')
    }

    }// END of Main
}

$mainObj = new uploadToEloqua();
$mainObj->main();


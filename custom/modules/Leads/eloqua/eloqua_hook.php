<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
include_once('lib/eloquaRequest.php');
//error_reporting(-1);
//ini_set('display_errors', 'On');

class eloqua_contact
{

    function createLog($req,$action)
    {
        $file = fopen(str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']) . "upload/apilog/eloqua_log.txt", "a");
        fwrite($file, date('Y-m-d H:i:s') . "\n");
        fwrite($file, $action . "\n");
        fwrite($file, print_r($req, TRUE) . "\n");
        fclose($file);
    }

    function add_leads_eloqua($bean, $event, $arguments)
    {
        global $db;

        //echo "<pre>"; print_r($bean);

        $leadObj       = $db->query("SELECT eloqua_contact_id,eloqua_customobject_id FROM leads_cstm where id_c='" . $bean->id . "'");
        $leadsCstmData = $db->fetchByAssoc($leadObj);


        if (!empty($leadsCstmData) && $leadsCstmData['eloqua_customobject_id'] != '')
        {

            $client = new EloquaRequest('https://secure.p07.eloqua.com/API/REST/2.0');


            $contact = array(
                'type'        => 'CustomObjectData',
                'contactId'   => $contactId,
                'fieldValues' =>
                array(
                    0 => array('id' => 171, 'value' => isset($BatchData['batch_status']) ? $BatchData['batch_status'] : ''),
                    1 => array('id' => 153, 'value' => $bean->status),
                    2 => array('id' => 154, 'value' => $bean->status_description),
                ),
            );

            //echo "<pre>inUpdate="; print_r($contact); die;

            $response = $client->put('/data/customObject/7/instance/' . $leadsCstmData['eloqua_customobject_id'], $contact);

            $this->createLog($response,'{On Refresh lead}');
        }
        else
        {

            $client  = new EloquaRequest('https://secure.p07.eloqua.com/API/REST/1.0');
            $contact = array();
            $contactId='';
            // instantiate a new instance of the Contact class  
            $contact = array(
                'emailAddress'  => $bean->email_add_c,
                'accountName'   => isset($bean->assigned_user_name) ? $bean->assigned_user_name : '',
                'address1'      => isset($bean->primary_address_street) ? $bean->primary_address_street : '',
                'address2'      => isset($bean->alt_address_street) ? $bean->alt_address_street : '',
                'businessPhone' => isset($bean->phone_mobile) ? $bean->phone_mobile : '',
                'city'          => isset($bean->primary_address_city) ? $bean->primary_address_city : '',
                'country'       => isset($bean->primary_address_country) ? $bean->primary_address_country : '',
                'description'   => isset($bean->comment) ? $bean->comment : '',
                'firstName'     => isset($bean->first_name) ? $bean->first_name : '',
                'lastName'      => isset($bean->last_name) ? $bean->last_name : '',
                'mobilePhone'   => isset($bean->phone_other) ? $bean->phone_other : $bean->phone_mobile,
                'postalCode'    => isset($bean->primary_address_postalcode) ? $bean->primary_address_postalcode : ''
            );

            //echo json_encode($contact);
           


            $responsex = $client->post('data/contact', $contact);

            $this->createLog($responsex,'{On lead Create}');
            
            //echo "<pre>bean="; print_r($bean);
            //echo 'leadId='.$bean->id.'$response->id='.$responsex->id."<pre>inCreate="; print_r($responsex); die;
            $contactIDXX='';
            if ($responsex->id!='')
            {   
                $contactIDXX = $responsex->id;
                $db->query("update leads_cstm  set eloqua_contact_id=$responsex->id where  id_c='" . $bean->id . "'");
            }

            //if ($contactId != '')
            //{
            //$client = new EloquaRequest('https://secure.p07.eloqua.com/API/REST/1.0');


            $result_c  = $db->query("SELECT 
                                    bb.batch_code,
                                    bb.batch_status,
                                    inst.name institutes_name,
                                    prog.name program_name
                                        FROM te_ba_batch bb
                        LEFT JOIN `te_pr_programs_te_ba_batch_1_c` pr_rel ON bb.id=pr_rel.te_pr_programs_te_ba_batch_1te_ba_batch_idb
                        LEFT JOIN  `te_in_institutes_te_ba_batch_1_c` inst_rel ON bb.id=inst_rel.te_in_institutes_te_ba_batch_1te_ba_batch_idb
                        LEFT JOIN `te_in_institutes` inst ON inst_rel.te_in_institutes_te_ba_batch_1te_in_institutes_ida=inst.id
                        LEFT JOIN  `te_pr_programs` prog ON pr_rel.te_pr_programs_te_ba_batch_1te_pr_programs_ida=prog.id 
                        WHERE  bb.id ='" . $bean->te_ba_batch_id_c . "'");
            $BatchData = $db->fetchByAssoc($result_c);


            $contact = array(
                'type'        => 'CustomObjectData',
                'contactId'   => $contactIDXX,
                'fieldValues' =>
                array(
                    0  => array('id' => '150', 'value' => isset($bean->email_add_c) ? $bean->email_add_c : ''),
                    1  => array('id' => 151, 'value' => $bean->email_add_c . '_' . isset($BatchData['batch_code']) ? $BatchData['batch_code'] : 'Generic_2017-18'),
                    2  => array('id' => 152, 'value' => isset($BatchData['batch_code']) ? $BatchData['batch_code'] : 'Generic_2017-18'),
                    3  => array('id' => 171, 'value' => isset($BatchData['batch_status']) ? $BatchData['batch_status'] : ''),
                    4  => array('id' => 153, 'value' => isset($bean->status) ? $bean->status : ''),
                    5  => array('id' => 154, 'value' => isset($bean->status_description) ? $bean->status_description : ''),
                    6  => array('id' => 155, 'value' => isset($bean->lead_source) ? $bean->lead_source : ''),
                    7  => array('id' => 156, 'value' => isset($bean->phone_mobile) ? $bean->phone_mobile : ''),
                    8  => array('id' => 157, 'value' => isset($bean->UTM) ? $bean->UTM : ''),
                    9  => array('id' => 158, 'value' => isset($bean->vendor) ? $bean->vendor : ''),
                    10 => array('id' => 159, 'value' => isset($bean->assigned_user_id) ? $bean->assigned_user_id : ''),
                    11 => array('id' => 160, 'value' => isset($bean->first_name) ? $bean->first_name : ''),
                    12 => array('id' => 161, 'value' => isset($bean->last_name) ? $bean->last_name : ''),
                    13 => array('id' => 162, 'value' => isset($BatchData['program_name']) ? $BatchData['program_name'] : ''),
                    14 => array('id' => 163, 'value' => isset($bean->attempts_c) ? $bean->attempts_c : ''),
                    15 => array('id' => 164, 'value' => isset($bean->utm_term_c) ? $bean->utm_term_c : ''),
                    16 => array('id' => 165, 'value' => isset($bean->utm_source_c) ? $bean->utm_source_c : ''),
                    17 => array('id' => 166, 'value' => isset($bean->utm_campaign) ? $bean->utm_campaign : ''),
                    18 => array('id' => 167, 'value' => isset($bean->primary_address_city) ? $bean->primary_address_city : ''),
                    19 => array('id' => 168, 'value' => isset($bean->company_c) ? $bean->company_c : ''),
                    20 => array('id' => 169, 'value' => isset($bean->functional_area) ? $bean->functional_area : ''),
                    21 => array('id' => 170, 'value' => isset($BatchData['institutes_name']) ? $BatchData['institutes_name'] : '')
                ),
            );

            //echo "<pre>in Object Create="; print_r($contact); die;
          
            $response = $client->post('data/customObject/7', $contact);
            $this->createLog($response,'{On LeadObjec Create}');

            if ($response->id!='')
            {
                //$contactIdx = $response->id;
                $db->query("update leads_cstm  set eloqua_customobject_id=$response->id where  id_c='" . $bean->id . "'");
              
            }
            //}
        }
    }

}

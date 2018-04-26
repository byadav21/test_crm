<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
include_once('lib/eloquaRequest.php');
error_reporting(-1);
ini_set('display_errors', 'On');

class eloqua_contact
{
    
    function createLog($req)
    {
        $file = fopen(str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']) . "upload/apilog/eloqua_log.txt", "a");
        fwrite($file, date('Y-m-d H:i:s') . "\n");
        fwrite($file, $req . "\n");
        fclose($file);
    }

    function add_leads_eloqua(&$bean, $event, $arguments)
    {
        global $db;
        //echo "<pre>";
        //print_r($bean);
        //die;
        $client  = new EloquaRequest('https://secure.p07.eloqua.com/API/REST/1.0');
        $contact = array();
        // instantiate a new instance of the Contact class  
        $contact = array(
            'emailAddress'  => $bean->email_add_c,
            #'accountId'     => '',
            #'id'            => '',
            'accountName'   => $bean->assigned_user_name,
            'address1'      => $bean->primary_address_street,
            'address2'      => $bean->alt_address_street,
            'businessPhone' => $bean->phone_mobile,
            'city'          => $bean->primary_address_city,
            'country'       => $bean->primary_address_country,
            'description'   => $bean->comment,
            'firstName'     => $bean->first_name,
            'lastName'      => $bean->last_name,
            'mobilePhone'   => $bean->phone_other,
            'postalCode'    => $bean->primary_address_postalcode);

        // retrieve the ID of the new contact  

        $response = $client->post('data/contact', $contact);

        $contactId = $response->id;
        
         if($contactId){
                $db->query("update leads_cstm  set eloqua_contact_id=$contactId where  id_c='" .$bean->id."'");
                $this->createLog($response);
            }

        if ($contactId != '')
        {

            $client = new EloquaRequest('https://secure.p07.eloqua.com/API/REST/1.0');
            
            
            $result_c =$db->query("SELECT 
                                    bb.batch_code,
                                    bb.batch_status,
                                    inst.name institutes_name,
                                    prog.name program_name
                                        FROM te_ba_batch bb
                        LEFT JOIN `te_pr_programs_te_ba_batch_1_c` pr_rel ON bb.id=pr_rel.te_pr_programs_te_ba_batch_1te_ba_batch_idb
                        LEFT JOIN  `te_in_institutes_te_ba_batch_1_c` inst_rel ON bb.id=inst_rel.te_in_institutes_te_ba_batch_1te_ba_batch_idb
                        LEFT JOIN `te_in_institutes` inst ON inst_rel.te_in_institutes_te_ba_batch_1te_in_institutes_ida=inst.id
                        LEFT JOIN  `te_pr_programs` prog ON pr_rel.te_pr_programs_te_ba_batch_1te_pr_programs_ida=prog.id 
                        WHERE  bb.id ='".$bean->te_ba_batch_id_c."'");
		       $BatchData =$db->fetchByAssoc($result_c);
					

            $contact = $contact = array(
                'type'        => 'CustomObjectData',
		'contactId'   =>$contactId,
                'fieldValues' =>
                array(
                    0  => array('id' => '150', 'value' => $bean->email_add_c),
                    1  => array('id' => 151, 'value' => $bean->email_add_c.'_'.$BatchData['batch_code']),
                    2  => array('id' => 152, 'value' => isset($BatchData['batch_code'])? $BatchData['batch_code']: ''),
                    3  => array('id' => 171, 'value' => isset($BatchData['batch_status'])? $BatchData['batch_status']: ''),
                    4  => array('id' => 153, 'value' => $bean->status),
                    5  => array('id' => 154, 'value' => $bean->status_description),
                    6  => array('id' => 155, 'value' => $bean->lead_source),
                    7  => array('id' => 156, 'value' => $bean->phone_mobile),
                    8  => array('id' => 157, 'value' => $bean->UTM),
                    9  => array('id' => 158, 'value' => $bean->vendor),
                    10 => array('id' => 159, 'value' => $bean->assigned_user_id),
                    11 => array('id' => 160, 'value' => $bean->first_name),
                    12 => array('id' => 161, 'value' => $bean->last_name),
                    13 => array('id' => 162, 'value' => isset($BatchData['program_name'])? $BatchData['program_name']: ''),
                    14 => array('id' => 163, 'value' => $bean->attempts_c),
                    15 => array('id' => 164, 'value' => $bean->utm_term_c),
                    16 => array('id' => 165, 'value' => $bean->utm_source_c),
                    17 => array('id' => 166, 'value' => $bean->utm_campaign),
                    18 => array('id' => 167, 'value' => $bean->primary_address_city),
                    19 => array('id' => 168, 'value' => $bean->company_c),
                    20 => array('id' => 169, 'value' => $bean->functional_area),
                    21 => array('id' => 170, 'value' => isset($BatchData['institutes_name'])? $BatchData['institutes_name']: '')
                ),
            );

      

            $response = $client->post('data/customObject/7', $contact);

            $contactId = $response->id;
            if($contactId){
                $db->query("update leads_cstm  set eloqua_customobject_id=$contactId where  id_c='" .$bean->id."'");
                $this->createLog($response);
            }
        }
       
    }

}

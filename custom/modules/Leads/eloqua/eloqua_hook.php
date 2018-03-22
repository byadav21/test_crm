<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
include_once('lib/eloquaRequest.php');
error_reporting(-1);
ini_set('display_errors', 'On');

class eloqua_contact
{

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

        if ($contactId != '')
        {

            //$client = new EloquaRequest('https://secure.p07.eloqua.com/API/REST/1.0');
            
            
            $result_c =$db->query("SELECT batch_code,batch_status FROM te_ba_batch WHERE id ='".$bean->te_ba_batch_id_c."'");
		       $BatchData =$db->fetchByAssoc($result_c);
					

            $contact = $contact = array(
                'type'        => 'CustomObjectData',
                'fieldValues' =>
                array(
                    0  => array('id' => '150', 'value' => $bean->email_add_c),
                    1  => array('id' => 151, 'value' => $bean->email_add_c),
                    2  => array('id' => 152, 'value' => $BatchData['batch_code']),
                    3  => array('id' => 171, 'value' => $BatchData['batch_status']),
                    4  => array('id' => 153, 'value' => $bean->status),
                    5  => array('id' => 154, 'value' => $bean->status_description),
                    6  => array('id' => 155, 'value' => $bean->lead_source),
                    7  => array('id' => 156, 'value' => $bean->phone_mobile),
                    8  => array('id' => 157, 'value' => $bean->UTM),
                    9  => array('id' => 158, 'value' => $bean->vendor),
                    10 => array('id' => 159, 'value' => $bean->assigned_user_id),
                    11 => array('id' => 160, 'value' => 'User_first_name'),
                    12 => array('id' => 161, 'value' => 'User_last_name'),
                    13 => array('id' => 162, 'value' => $bean->batch_c),
                    14 => array('id' => 163, 'value' => $bean->attempts_c),
                    15 => array('id' => 164, 'value' => $bean->utm_term_c),
                    16 => array('id' => 165, 'value' => $bean->utm_source_c),
                    17 => array('id' => 166, 'value' => $bean->utm_campaign),
                    18 => array('id' => 167, 'value' => $bean->primary_address_city),
                    19 => array('id' => 168, 'value' => $bean->company_c),
                    20 => array('id' => 169, 'value' => $bean->functional_area),
                    21 => array('id' => 170, 'value' => $bean->institute)
                ),
            );

      

            $response = $client->post('data/customObject/7', $contact);

            $contactId = $response->id;
        }
       
    }

}

<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

//error_reporting(-1);
//ini_set('display_errors', 'On');

class pushLeadClevertap
{

    function pushLead(&$bean, $event, $argument)
    {
        global $db;
        
        //echo '<pre>';print_r($bean); die;
        
        $beanId             = $bean->id;
        $cust_name          = $bean->first_name. ' '. $bean->last_name;
        $phone              = $bean->phone_mobile;
        $email              = $bean->email_add_c;
        $batchid            = $bean->te_ba_batch_id_c;
        $modified_user_id   = $bean->modified_user_id; 
        $assigned_user_id   = $bean->assigned_user_id; 
        $created_by         = $bean->created_by;
        $vendor             = $bean->vendor;
        $status             = $bean->status;
        $status_description = $bean->status_description;
        $term               = $bean->utm_term_c;
        $source             = $bean->utm_source_c;
        $medium             = $bean->utm_contract_c;

        
        $url = 'https://api.clevertap.com/1/upload';

        $headers = array(
            "Content-Type: application/json",
            "X-CleverTap-Account-Id: TEST-KZZ-RWR-655Z",
            "X-CleverTap-Passcode: CVK-IKC-OPKL",
        );



        $batchdata = array();
        $batchObj = $db->query("SELECT batch_code FROM te_ba_batch WHERE id='" . $bean->te_ba_batch_id_c . "' AND deleted=0");
        $batchdata= $db->fetchByAssoc($batchObj);
        
            
        $batchCode = isset($batchdata['batch_code']) ?  $batchdata['batch_code'] : $term;
        //echo 'xxx'.$batchCode; die;
        if (strpos($phone, '+') !== false)
        {
            $phoneNumber = trim(preg_replace('/\s+/', '', $phone));
        }
        else
        {
            $phoneNumber = trim(preg_replace('/\s+/', '', '+91' . $phone));
        }
        
        $emaibatch = $email.'_'.$batchCode;


        $Identity = str_replace("@", "", $emaibatch);
        # 1. profile
        $data     = array('d' => array('0' =>
                array('identity'    => $Identity,
                    'type'        => 'profile',
                    'profileData' =>
                    array('Name'               => $cust_name,
                        'Email'              => $email,
                        'Phone_l'            => $phoneNumber,
                        'Phone'              => $phoneNumber,
                        'Status_l'           => $status,
                        'status_description' => $status_description
                    )
        )));
        $payload  = json_encode($data);

        $ch     = curl_init($url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        # Return response instead of printing.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        # Send request.
        $result = curl_exec($ch);
        curl_close($ch);
        # Print response.
        echo "profile: <pre>$result</pre>";


        # 2. event

        $data = array('d' =>
            array('0' =>
                array('identity' => $Identity,
                    'type'     => 'event',
                    'evtName'  => 'Product viewed',
                    'evtData'  =>
                    array('Name'               => $cust_name,
                        'Email'              => $email,
                        'Phone_l'            => $phoneNumber,
                        'Phone'              => $phoneNumber,
                        'Status_l'           => $status,
                        'status_description' => $status_description,
                        'date_entered'       => $bean->date_entered,
                        'date_of_followup'   => $bean->date_of_followup,
                        'date_modified'      => $bean->date_modified,
                        'converted_date'     => $bean->converted_date,
                        'agent_id'         => $assigned_user_id,
                        'vendor'             => $bean->vendor,
                        'batch_code'         => $batchCode
                    )
        )));


        $payload = json_encode($data);




        $ch     = curl_init($url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        # Return response instead of printing.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        # Send request.
        $result = curl_exec($ch);
        curl_close($ch);
        # Print response.
        echo "Event: <pre>$result</pre>";




        $this->createLog('{Clevertap Log:}', 'push_lead_clevertap_' . date('Y-m-d') . '_log.txt', '', array('LeadID'   => $beanId,
            'vendor'   => $vendor,
            'email'    => $email,
            'phone'    => $phone,
            'batch_id' => $batchid,
            'utm_term' => $term,
            'source'   => $source,
            'medium'   => $medium));
    }

    function createLog($action, $filename, $field = '', $dataArray = array())
    {
        $file = fopen(str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']) . "upload/apilog/$filename", "a");
        fwrite($file, date('Y-m-d H:i:s') . "\n");
        fwrite($file, $action . "\n");
        fwrite($file, $field . "\n");
        fwrite($file, print_r($dataArray, TRUE) . "\n");
        fclose($file);
    }

}

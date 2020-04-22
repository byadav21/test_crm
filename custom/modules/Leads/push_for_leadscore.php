<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

//error_reporting(-1);
//ini_set('display_errors', 'On');

class pushforLeadscore
{

    function pushLead(&$bean, $event, $argument)
    {
        global $db;

        //$agentArr= getUsersName();
        //echo '<pre>';print_r($bean->assigned_user_name); die;
        if (isset($_REQUEST['import_module']) && $_REQUEST['module'] == "Import")
        {

            return;
        }

        $beanId       = $bean->id;
        $first_name   = isset($bean->first_name) ? $bean->first_name : '';
        $last_name    = isset($bean->last_name) ? $bean->last_name : '';
        $cust_name    = $first_name . ' ' . $last_name;
        $phone        = isset($bean->phone_mobile) ? $bean->phone_mobile : '';
        $email        = isset($bean->email_add_c) ? $bean->email_add_c : '';
        $status       = isset($bean->status) ? $bean->status : '';
        $term         = isset($bean->utm_term_c) ? $bean->utm_term_c : '';
        $date_entered = isset($bean->fetched_row['date_entered']) ? $bean->fetched_row['date_entered'] : '';
        $country      = isset($bean->primary_address_country) ? $bean->primary_address_country : '';
        //primary_address_country


        $batchdata = array();
        $batchObj  = $db->query("SELECT batch_code,name FROM te_ba_batch WHERE id='" . $bean->te_ba_batch_id_c . "' AND deleted=0");
        $batchdata = $db->fetchByAssoc($batchObj);


        $batchCode = isset($batchdata['batch_code']) ? $batchdata['batch_code'] : $term;
        $batchname = isset($batchdata['name']) ? $batchdata['name'] : '';
        $dob       = '';
        
        $url       = 'http://3.6.184.43:5000/storeCRMtoDatabase';
        $fields    = array(
            'lead_id'         => $beanId,
            'email'           => $email,
            'course_name'     => $batchname,
            'course_category' => $batchCode,
            'disposition'     => $status,
            'phone_number'    => $phone,
            'fname'           => $first_name,
            'lname'           => $last_name,
            'city'            => $city,
            'dob'             => $dob,
            'country'         => $country
        );

        //url-ify the data for the POST
        foreach ($fields as $key => $value)
        {
            $fields_string .= $key . '=' . $value . '&';
        }
        rtrim($fields_string, '&');

        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        //execute post
        $result = curl_exec($ch);
        $info   = curl_getinfo($ch);
        //echo 'http='.$info["http_code"];
        //echo 'xx' . $result;
        //print_r($result);
        //die;
        //close connection
        curl_close($ch);





        $this->createLog('{LeadScore Log:}', 'push_for_leadscore' . date('Y-m-d') . '_log.txt', '', array($fields, json_decode($result, true)));
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

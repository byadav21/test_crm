<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

error_reporting(E_ALL);
//ini_set('display_errors', 'On');

class pushLeadClevertap
{

    function pushLead(&$bean, $event, $argument)
    {
        global $db,$sugar_config;
        
        //$agentArr= getUsersName();
        //echo '<pre>';print_r($bean->assigned_user_name); die;
        if (isset($_REQUEST['import_module']) && $_REQUEST['module'] == "Import"){
             
             return;
         }
        
//echo "<pre>";print_r($bean);
        $first_name = isset($bean->first_name) ? $bean->first_name : '';
        $last_name  = isset($bean->last_name) ? $bean->last_name : '';
        
        $beanId             = $bean->id;
        $cust_name          = $first_name. ' '. $last_name;
        $phone              = isset($bean->phone_mobile) ? $bean->phone_mobile : '';
        $email              = isset($bean->email_add_c) ? $bean->email_add_c : '';
        $batchid            = isset($bean->te_ba_batch_id_c) ? $bean->te_ba_batch_id_c : '';
        $modified_user_id   = isset($bean->modified_user_id) ? $bean->modified_user_id : ''; 
        $assigned_user_id   = isset($bean->assigned_user_id) ? $bean->assigned_user_id : ''; 
        $created_by         = isset($bean->created_by) ? $bean->created_by : '';
        $vendor             = isset($bean->vendor) ? $bean->vendor : '';
        $status             = isset($bean->status) ? $bean->status : '';
        $status_description = isset($bean->status_description) ? $bean->status_description : '';
        $term               = isset($bean->utm_term_c) ? $bean->utm_term_c : '';
        $source             = isset($bean->utm_source_c) ? $bean->utm_source_c : '';
        $medium             = isset($bean->utm_contract_c) ? $bean->utm_contract_c : '';
        $date_of_prospect   = isset($bean->date_of_prospect) ? $bean->date_of_prospect : '';
        $agent_name	    = isset($bean->assigned_user_name) ? $bean->assigned_user_name : '';
        
        $date_entered       = isset($bean->fetched_row['date_entered']) ? $bean->fetched_row['date_entered'] : '';
        $date_of_followup   = isset($bean->date_of_followup) ? $bean->date_of_followup : '';
        $date_modified      = isset($bean->date_modified) ? $bean->date_modified : '';
        $converted_date     = isset($bean->converted_date) ? $bean->converted_date : '';
       // $whatsapp_clvrtp    = isset($bean->msg_whatsapp_clvrtp) ? $bean->msg_whatsapp_clvrtp : '';
       $whatsapp_clvrtp    = isset($bean->msg_whatsapp_clvrtp) && ($bean->msg_whatsapp_clvrtp=='TRUE') ? TRUE : FALSE;
        $whatsapp_gupshup    = isset($bean->msg_whatsapp_gupshup) && ($bean->msg_whatsapp_gupshup=='TRUE') ? TRUE : FALSE;
        
        $url = 'https://api.clevertap.com/1/upload';

        $headers = array(
            "Content-Type: application/json",
            "X-CleverTap-Account-Id: 867-RZ5-R75Z",
            "X-CleverTap-Passcode: SMQ-IOZ-MTKL",
        );



        $batchdata = array();
        $batchObj = $db->query("SELECT batch_code FROM te_ba_batch WHERE id='" . $bean->te_ba_batch_id_c . "' AND deleted=0");
        $batchdata= $db->fetchByAssoc($batchObj);
        
            
        $batchCode = isset($batchdata['batch_code']) ?  $batchdata['batch_code'] : $term;
        //echo 'xxx'.$batchCode; die;
echo "cust_name:- ". $cust_name ." phone:- ". $phone." email:- ".$email." batchCode:- ".$batchCode.'<br/>';
// $phone = "+919911198392";
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
                        'status_description' => $status_description,
                        'MSG-whatsapp'       => $whatsapp_clvrtp
                    )
        )));
        $payload  = json_encode($data);

        $ch     = curl_init($url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        # Return response instead of printing.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        # Send request.
        $result = curl_exec($ch);
        curl_close($ch);
        # Print response.
       // echo "profile: <pre>";print_r($data);

            $getQuery = "select * from gupshup_api_details where batch_code='".$batchCode."' ";
            $itemDetal=$db->query($getQuery);
	    $resultData = $db->fetchByAssoc($itemDetal);


//echo "<pre>"; print_r($resultData);
        //Start Using for WhatsApp Gupshup APi
        $url_gupshup  = 'https://media.smsgupshup.com/GatewayAPI/rest?';
        // $url_gupshup .= "userid=".$sugar_config['whatsapp_gupshup_userid'];
        // $url_gupshup .= "&password=".$sugar_config['whatsapp_gupshup_pass'];
        // $url_gupshup .= "phone_number=". $phoneNumber . "&v=1.1&auth_scheme=plain&channel=WHATSAPP";
        //https://media.smsgupshup.com/GatewayAPI/rest?userid=2000199169&method=OPT_IN&format=json&password=xHeVYaDP&phone_number=9011198392&v=1.1&auth_scheme=plain&channel=WHATSAPP

        if(!empty($phoneNumber)){
//echo "<pre>"; print_r($resultData);
            echo  $url_opt_in_gupshup = $url_gupshup.'method=OPT_IN&format=json&userid='.$sugar_config['whatsapp_gupshup_userid'].'&password='.$sugar_config['whatsapp_gupshup_pass'].'&phone_number='.$phone.'&v=1.1&auth_scheme=plain&channel=WHATSAPP';

            $ch     = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url_opt_in_gupshup);
            # Return response instead of printing.
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            # Send request.
            $result = curl_exec($ch);
            curl_close($ch);
            echo "<pre>";print_r($result)."<br />";

            if($result){
//echo urlencode($resultData['course_name']);
                echo "<br/>".$url_media_gupshup = $url_gupshup.'send_to='.$phone.'&msg_type=DOCUMENT&userid='.$sugar_config['whatsapp_gupshup_userid'].'&auth_scheme=plain&password='.$sugar_config['whatsapp_gupshup_pass'].'&v=1.1&format=json&caption=Your%20registration%20for%20*'.urlencode($resultData['institute_name']).'%20'.urlencode($resultData['course_name']).'*%20is%20successfully%20completed.%0A%0AFor%20the%20course%20details%2C%20download%20the%20attached%20brochure.%0A%0AYou%20can%20call%20us%20on%20*'.$resultData['number'].'*%20or%20reply%20*Hi*%20to%20this%20message%20to%20chat%20with%20our%20counsellor%20on%20WhatsApp.&method=SendmediaMessage&filename='.urlencode($resultData['course_name']).'&media_url='.$resultData['brochure_url'].'&footer=TALENTEDGE&isHSM=false';
                //https://media.smsgupshup.com/GatewayAPI/rest?send_to=6392472704&msg_type=DOCUMENT&userid=2000199169&auth_scheme=plain&password=xHeVYaDP&method=SendmediaMessage&v=1.1&media_url=http://d37c7ubwjknfep.cloudfront.net/wp-content/uploads/2021/05/IIML-SCM.pdf&caption=Your%20registration%20for%20*Business%20Analytics%20IIM%20Kozhikode*%20is%20successfully%20completed.%0A%0AFor%20the%20course%20details%2C%20download%20the%20attached%20brochure.%0A%0AYou%20can%20call%20us%20on%20*9582086600*%20or%20reply%20Hi%20to%20this%20message%20to%20chat%20with%20our%20counsellor%20on%20WhatsApp.&isHSM=True&footer=TALENTEDGE&filename=Business%20Analytics%20IIM%20Kozhikode&format=json


                //https://media.smsgupshup.com/GatewayAPI/rest?send_to=9911198392&msg_type=DOCUMENT&userid=2000199169&auth_scheme=plain&password=xHeVYaDP&v=1.1&format=text&caption=Your%20registration%20for%20*IIM%20Lucknow%20Supply%20Chain%20Management*%20is%20successfully%20completed.%0A%0AFor%20the%20course%20details%2C%20download%20the%20attached%20brochure.%0A%0AYou%20can%20call%20us%20on%20*9911198392*%20or%20reply%20*Hi*%20to%20this%20message%20to%20chat%20with%20our%20counsellor%20on%20WhatsApp.&method=SendmediaMessage&filename=Test12345&media_url=http://www.africau.edu/images/default/sample.pdf&footer=TALENTEDGE&isHSM=false

//echo $url_media_gupshup = 'https://media.smsgupshup.com/GatewayAPI/rest?send_to=9911198392&msg_type=DOCUMENT&userid=2000199169&auth_scheme=plain&password=xHeVYaDP&v=1.1&format=json&caption=Your%20registration%20for%20*Talentedge %20 Modern%20Business%20Masters%20-%20Jumpstart *%20 is%20successfully%20completed.%0A%0AFor%20the%20course%20details%2C%20download%20the%20attached%20brochure.%0A%0AYou%20can%20call%20us%20on%20*9911198392*%20or%20reply%20*Hi*%20to%20this%20message%20to%20chat%20with%20our%20counsellor%20on%20WhatsApp.&method=SendmediaMessage&filename=Modern%20Business%20Masters%20-%20Jumpstart&media_url=https://d37c7ubwjknfep.cloudfront.net/wp-content/uploads/2021/06/brochure_jumpstart.pdf&footer=TALENTEDGE&isHSM=false';
                // $curl = curl_init();

                // curl_setopt_array($curl, array(
                // CURLOPT_URL => "http://",
                // CURLOPT_RETURNTRANSFER => true,
                // CURLOPT_ENCODING => "",
                // CURLOPT_MAXREDIRS => 10,
                // CURLOPT_TIMEOUT => 30,
                // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                // CURLOPT_CUSTOMREQUEST => "GET",
                // CURLOPT_HTTPHEADER => array(
                //     "cache-control: no-cache",
                //     "postman-token: 3ac94fd3-af50-6a0d-4a02-26708918482a"
                // ),
                // ));

                // $response = curl_exec($curl);
                // $err = curl_error($curl);

                // curl_close($curl);

                $ch     = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url_media_gupshup);
                # Return response instead of printing.
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
                curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                # Send request.
                $result = curl_exec($ch);
                curl_close($ch);
                echo "<pre>";print_r($result);
            }
        }
        //End Using for WhatsApp Gupshup APi
        
        $date_entered_doller='';
        $date_of_followup_doller='';
        $date_modified_doller='';
        $converted_date_doller='';
        $date_of_prospect_doller='';
        
        
        if($date_entered!=''){
            $date_entered_doller = '$D_'.strtotime(gmdate('Y-m-d H:i:s', strtotime($date_entered)));
        }
        if($date_of_followup!=''){
            $date_of_followup_doller = '$D_'.strtotime(gmdate('Y-m-d H:i:s', strtotime($date_of_followup)));
        }
        if($date_modified!=''){
            $date_modified_doller = '$D_'.strtotime(gmdate('Y-m-d H:i:s', strtotime($date_modified)));
        }
        if($converted_date!=''){
            $converted_date_doller = '$D_'.strtotime($converted_date);
        }
        if($date_of_prospect!=''){
            $date_of_prospect_doller = '$D_'.strtotime(gmdate('Y-m-d H:i:s', strtotime($date_of_prospect)));
        }
        
        # 2. event

        $data = array('d' =>
            array('0' =>
                array('identity' => $Identity,
                    'type'     => 'event',
                    'evtName'  => 'CRM Update',
                    'evtData'  =>
                    array('Name'             => $cust_name,
                        'Email'              => $email,
                        'Phone_l'            => $phoneNumber,
                        'Phone'              => $phoneNumber,
                        'Status_l'           => $status,
                        'status_description' => $status_description,
                        'date_entered'       => $date_entered_doller,
                        'date_entered_I'     => $date_entered_doller,
                        'date_of_followup'   => $date_of_followup_doller,
                        'date_of_followup_I' => $date_of_followup_doller,
                        'date_modified'      => $date_modified_doller,
                        'date_modified_I'    => $date_modified_doller,
                        'converted_date'     => $converted_date_doller,
                        'converted_date_I'   => $converted_date_doller,
                        'agent_id'           => $assigned_user_id,
                        'vendor'             => $vendor,
                        'batch_code'         => $batchCode,
                        'counsellor_name'    => $agent_name,
                        'date_of_prospect'   => $date_of_prospect_doller,
                        'date_of_prospect_I' => $date_of_prospect_doller,
                        'MSG-whatsapp'       => $whatsapp_clvrtp
                    )
        )));

        //echo '<pre>';print_r($data);die;
        $payload = json_encode($data);




        $ch     = curl_init($url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        # Return response instead of printing.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        # Send request.
        $result = curl_exec($ch);
        curl_close($ch);
        # Print response.
        //echo "Event: <pre>$result</pre>";die;




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

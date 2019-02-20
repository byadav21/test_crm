<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
ini_set('memory_limit', '1024M');
require_once('include/entryPoint.php');
global $db;
$data         = json_decode(file_get_contents('php://input'), true);
$error_fields = [];
$discount     = ' 0';



$lead_id     = $data['crm_lead_id'];
$batch_id    = $data['batch_crm_id'];
$email       = $data['email'];
$mobile      = $data['mobile'];
$test_status = $data['test_status'];

if (!isset($data['test_status']) || empty($data['test_status']))
    {
        $error_fields['test_status'] = ['test_status field is required.'];
    }
if (!isset($data['email']) || empty($data['email']))
    {
        $error_fields['email'] = ['email field is required.'];
    }
if (!isset($data['mobile']) || empty($data['mobile']))
    {
        $error_fields['mobile'] = ['mobile field is required.'];
    }
if (!isset($data['batch_crm_id']) || empty($data['batch_crm_id']))
    {
        $error_fields['batch_crm_id'] = ['batch_crm_id field is required.'];
    }

if ($error_fields)
    {
        $response_result = array('status' => '400', 'result' => $error_fields);
        echo json_encode($response_result);
        exit();
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

function __get_lead_details($email = NULL, $mobile = NULL, $batch_id = NULL, $discountStr = NULL)
{
    $get_lead_sql = "SELECT leads.*,
                                leads_cstm.company_c,
                                leads_cstm.functional_area_c,
                                leads_cstm.work_experience_c,
                                leads_cstm.education_c,
                                leads_cstm.city_c,
                                leads_cstm.age_c
                         FROM leads
                         INNER JOIN leads_cstm ON leads.id=leads_cstm.id_c
                         WHERE leads.deleted=0
                           AND te_ba_batch_id_c='" . $batch_id . "'
                           AND (email_add_c='" . $email . "'
                                OR phone_mobile='" . $mobile . "')
                         ORDER BY date_entered ASC";

    $get_lead_sql_Obj = $GLOBALS['db']->query($get_lead_sql);
    $get_lead         = [];
    $found_lead_data  = [];
    while ($row              = $GLOBALS['db']->fetchByAssoc($get_lead_sql_Obj))
    {
        $get_lead[] = $row;
    }
}




    
 

    /* check valid crm_payment_id in case of update */
    if ($data['action'] == 'update')
    {
        $check_payment_sql = "SELECT p.* FROM `leads_te_payment_details_1_c` AS lpr INNER JOIN te_payment_details AS p ON p.id=lpr.`leads_te_payment_details_1te_payment_details_idb` WHERE lpr.`leads_te_payment_details_1te_payment_details_idb` ='" . $data['crm_payment_id'] . "'";
        $check_payment_Obj = $GLOBALS['db']->query($check_payment_sql);
        $check_payment_row = $GLOBALS['db']->fetchByAssoc($check_payment_Obj);
        if (!$check_payment_row)
        {
            $errors          = array('type' => 'Invalid crm_payment_id');
            $response_result = array('status' => '0', 'result' => $errors);
            echo json_encode($response_result);
            exit();
        }
    }
   
    $lead_data = __get_lead_details($email, $mobile, $batch_id, $discount);
   
    if ($lead_data)
    {

      
    }
    else
    {
        $errors          = array('type' => 'Invalid Lead with batch id');
        $response_result = array('status' => '0', 'result' => $errors);
        echo json_encode($response_result);
        createLog('{payment Error}', 'error_payment.txt', $errors['type'], $response_result);
        exit();
    }

    
    


<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
ini_set('memory_limit', '1024M');
require_once('include/entryPoint.php');
global $db;
$data         = json_decode(file_get_contents('php://input'), true);
$error_fields = [];
$discount     = ' 0';



$lead_id     = '';
$batch_id    = isset($data['batch_crm_id']) ? $data['batch_crm_id'] : '';
$email       = isset($data['email']) ? $data['email'] : '';
$mobile      = isset($data['mobile']) ? $data['mobile'] : '';
$test_status = isset($data['test_status']) ? $data['test_status'] : '';
$order_id    = isset($data['order_id']) ? $data['order_id'] : '';

function createLog($action, $filename, $field = '', $dataArray = array())
{
    $file = fopen(str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']) . "upload/apilog/$filename", "a");
    fwrite($file, date('Y-m-d H:i:s') . "\n");
    fwrite($file, $action . "\n");
    fwrite($file, $field . "\n");
    fwrite($file, print_r($dataArray, TRUE) . "\n");
    fclose($file);
}

if (!isset($data['test_status']) || empty($data['test_status']))
{
    $error_fields['test_status'] = ['test_status field is required.'];
}
if (!isset($data['order_id']) || empty($data['order_id']))
{
    $error_fields['order_id'] = ['order_id field is required.'];
}

createLog('{on initial action}', 'web_onlinetest_status' . date('Y-m-d') . '_log.txt', $test_status, $data);

if ($error_fields)
{
    createLog('{while get an error}', 'web_onlinetest_status' . date('Y-m-d') . '_log.txt', $test_status, $data);

    $response_result = array('status' => '400', 'result' => $error_fields);
    echo json_encode($response_result);
    exit();
}

function getLeadId($order_id)
{

    $getLeadSql  = "SELECT 
                         lp.leads_te_payment_details_1leads_ida as lead_id 
                         FROM `te_payment_details` pd
                 JOIN leads_te_payment_details_1_c AS lp ON lp.leads_te_payment_details_1te_payment_details_idb=pd.id
                 where lp.deleted=0 and pd.deleted=0 
                 and pd.`invoice_order_number`='$order_id' ";
    $leadObj     = $db->Query($getLeadSql);
    $leadObjData = $db->fetchByAssoc($leadObj);
    return $leadObjData['lead_id'];
}

if ($order_id != '' && $test_status != '')
{
    $lead_id = getLeadId($order_id);

    if ($lead_id)
    {
        if (isset($data['test_status']) && !empty($data['test_status']) && $data['test_status'] == 'pass')
        {
            $c_status             = 'Warm';
            $c_status_description = 'Prospect';
            
            createLog('{while get pass}', 'web_onlinetest_status' . date('Y-m-d') . '_log.txt', $test_status, $data);
        }
        if (isset($data['test_status']) && !empty($data['test_status']) && $data['test_status'] == 'fail')
        {
            $c_status             = 'Dead';
            $c_status_description = 'Not Eligible';
            
            createLog('{while get fail}', 'web_onlinetest_status' . date('Y-m-d') . '_log.txt', $test_status, $data);
        }
        if ($c_status != '' && $c_status_description != '')
        {
            $LBean                     = BeanFactory::getBean('Leads', $lead_id);
            $LBean->status             = $c_status;
            $LBean->status_description = $c_status_description;
            $LBean->test_status        = $c_test_status;
            $LBean->converted_date     = date('Y-m-d');
            $checkSaveBean             = $LBean->save();
            if ($checkSaveBean)
            {
                $sx = $c_status . '_' . $c_status_description;
                createLog('{while status get saved}', 'web_onlinetest_status' . date('Y-m-d') . '_log.txt', $sx, $data);
                echo json_encode(array('status' => 'success', 'msg' => 'Lead saved successfully!'));
                exit();
            }
            else
            {
                echo json_encode(array('status' => 'error', 'msg' => 'Some thing gone wrong!'));
                exit();
            }
        }
    }
    else
    {
       echo json_encode(array('status' => 'success', 'msg' => 'Lead ID not get fetched!'));  
    }
}



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
$test_status = isset($data['lead_source']) ? $data['lead_source'] : '';

//$order_id    = isset($data['order_id']) ? $data['order_id'] : '';

function createLog($action, $filename, $field = '', $dataArray = array())
{
    $file = fopen(str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']) . "upload/apilog/$filename", "a");
    fwrite($file, date('Y-m-d H:i:s') . "\n");
    fwrite($file, $action . "\n");
    fwrite($file, $field . "\n");
    fwrite($file, print_r($dataArray, TRUE) . "\n");
    fclose($file);
}

if (!isset($data['batch_crm_id']) || empty($data['batch_crm_id']))
{
    $error_fields['batch_crm_id'] = ['batch_crm_id field is required.'];
}
if (!isset($data['email']) || empty($data['email']))
{
    $error_fields['email'] = ['email field is required.'];
}
if (!isset($data['mobile']) || empty($data['mobile']))
{
    $error_fields['mobile'] = ['mobile field is required.'];
}
if (!isset($data['lead_source']) || empty($data['lead_source']))
{
    $error_fields['lead_source'] = ['lead_source field is required.'];
}


createLog('{on initial action}', 'web_lead_source_status' . date('Y-m-d') . '_log.txt', $test_status, $data);

if ($error_fields)
{
    createLog('{while get an error}', 'web_lead_source_status' . date('Y-m-d') . '_log.txt', $test_status, $data);

    $response_result = array('status' => '400', 'result' => $error_fields);
    echo json_encode($response_result);
    exit();
}


$sql = "SELECT  leads.id AS id,
                    leads.assigned_user_id,
                    status,
                    status_description
             FROM leads
             INNER JOIN leads_cstm ON leads.id = leads_cstm.id_c";
if ($email != "")
{
    $sql .= " INNER JOIN email_addr_bean_rel ON email_addr_bean_rel.bean_id = leads.id
                AND email_addr_bean_rel.bean_module ='Leads'";

    $sql .= " INNER JOIN email_addresses ON email_addresses.id =  email_addr_bean_rel.email_address_id ";
}

$sql .= " WHERE leads.deleted = 0 AND leads_cstm.te_ba_batch_id_c = '" . $batch_id . "'";

if ($phone != "" && $email != "")
{
    $sql .= " AND leads.phone_mobile = '$phone' AND email_addresses.email_address='" . $email . "'";
}

if ($GLOBALS['db']->getRowCount($re) > 0)
{
    
}
else
{
    echo json_encode(array('status' => 'success', 'msg' => 'Lead ID not get fetched!'));
}





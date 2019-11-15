<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
ini_set('memory_limit', '1024M');
require_once('include/entryPoint.php');
global $db;
$data         = json_decode(file_get_contents('php://input'), true);
$error_fields = [];
$discount     = ' 0';



$lead_id  = '';
$batch_id = isset($data['batch_crm_id']) ? $data['batch_crm_id'] : '';
$email    = isset($data['email']) ? $data['email'] : '';
$mobile   = isset($data['mobile']) ? $data['mobile'] : '';
$amt      = isset($data['amount']) ? $data['amount'] : '';

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
if (!isset($data['amount']) || empty($data['amount']))
{
    $error_fields['amount'] = ['amount field is required.'];
}


createLog('{on initial action}', 'web_lead_source_status_' . date('Y-m-d') . '_log.txt', $lead_source, $data);

if ($error_fields)
{
    createLog('{while get an error}', 'web_lead_source_status_' . date('Y-m-d') . '_log.txt', $lead_source, $data);

    $response_result = array('status' => '400', 'result' => $error_fields);
    echo json_encode($response_result);
    exit();
}


$sql = "SELECT  leads.id AS id,
                            leads.assigned_user_id,
                            leads.status,
                            leads.status_description
                     FROM leads
                     INNER JOIN leads_cstm ON leads.id = leads_cstm.id_c ";

$sql .= " WHERE leads.deleted = 0
                          AND leads_cstm.te_ba_batch_id_c = '" . $batch_id . "'
                          AND status_description!='Duplicate'
                          AND status_description!='Re-Enquired'
                          AND leads.deleted=0 ";
// AND DATE(date_entered) = '".date('Y-m-d')."'";
if ($phone && $email)
{

    $sql .= " AND ( leads.phone_mobile = '{$phone}' or email_add_c = '{$email}')";
}
elseif (!$phone && $email)
{

    $sql .= " AND email_add_c=  '{$email}'";
}
elseif ($phone && !$email)
{
    $sql .= " AND leads.phone_mobile = '{$phone}'";
}

echo $sql .= " order by date_entered limit 1";

$sqlobj = $db->query($sql);
if ($db->getRowCount($sqlobj) > 0)
{
    $records      = $db->fetchByAssoc($sqlobj);
    $leadID       = $records['id'];
    $updateSql    = "update leads
                        SET
                  web_rm_status         = '1',web_rm_amt= '$amt'
                  date_modified       = NOW()  where id='$leadID'";
    $updateSqlres = $db->Query($updateSql);

    createLog('{Lead get update on success:}', 'web_lead_source_status_' . date('Y-m-d') . '_log.txt', $sql, $data);
}
else
{
    echo json_encode(array('status' => 'failed', 'msg' => 'Lead ID not get fetched!'));

    createLog('{Lead ID not get fetched:}', 'web_lead_source_status_' . date('Y-m-d') . '_log.txt', $sql, $data);
}





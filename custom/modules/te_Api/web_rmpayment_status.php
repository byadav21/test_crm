<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
ini_set('memory_limit', '1024M');
require_once('include/entryPoint.php');
global $db;
$data         = json_decode(file_get_contents('php://input'), true);
$error_fields = [];
$discount     = ' 0';

 //$data= array('batch_crm_id'=>'8b6c11a8-64d5-4c94-0215-5bbb22d493af','email'=>'test@te.com','mobile'=>'9971502476','amount'=>'23');

$lead_id     = '';
$batch_id    = isset($data['batch_crm_id']) ? $data['batch_crm_id'] : '';
$email       = isset($data['email']) ? $data['email'] : '';
$mobile      = isset($data['mobile']) ? $data['mobile'] : '';
$amount      = isset($data['amount']) ? $data['amount'] : '';

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
    $error_fields['amount'] = ['lead_source field is required.'];
}


createLog('{on initial action}', 'web_rmpayment_status_' . date('Y-m-d') . '_log.txt', $amount, $data);

if ($error_fields)
{
    createLog('{while get an error}', 'web_rmpayment_status_' . date('Y-m-d') . '_log.txt', $amount, $data);

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
    if ($mobile && $email)
    {

        $sql .= " AND ( leads.phone_mobile = '{$mobile}' or email_add_c = '{$email}')";
    }
    elseif (!$mobile && $email)
    {

        $sql .= " AND email_add_c=  '{$email}'";
    }
    elseif ($mobile && !$email)
    {
        $sql .= " AND leads.phone_mobile = '{$mobile}'";
    }
    
    $sql .= " order by leads.date_entered limit 1";

  //die($sql);
    
$sqlobj = $db->query($sql);
if ($db->getRowCount($sqlobj) > 0)
{
    $records      = $db->fetchByAssoc($sqlobj);
    $leadID        = $records['id'];
    echo $updateSql    = "update leads_cstm
                        SET
                  web_rm_status         = '1',
                  web_rm_amt            = '$amount'
                  where id_c='$leadID'";
    $updateSqlres = $db->Query($updateSql);
    
    createLog('{Lead get update on success:}', 'web_rmpayment_status_' . date('Y-m-d') . '_log.txt',$sql, $data);
    echo json_encode(array('status' => 'success', 'msg' => 'Lead updated!'));
    
}
else
{
    echo json_encode(array('status' => 'failed', 'msg' => 'Lead ID not get fetched!'));
    
    createLog('{Lead ID not get fetched:}', 'web_rmpayment_status_' . date('Y-m-d') . '_log.txt', $sql, $data);
}





<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
ini_set('memory_limit', '1024M');
require_once('include/entryPoint.php');
global $db;
//$datas         = json_decode(file_get_contents('php://input'), true);
$error_fields = [];





$lead_id    = isset($_REQUEST['lead_id']) ? $_REQUEST['lead_id'] : '';
$leadscore  = isset($_REQUEST['lead_score']) ? $_REQUEST['lead_score'] : '';

//print_r($_POST);

function createLog($action, $filename, $field = '', $dataArray = array())
{
    $file = fopen(str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']) . "upload/apilog/$filename", "a");
    fwrite($file, date('Y-m-d H:i:s') . "\n");
    fwrite($file, $action . "\n");
    fwrite($file, $field . "\n");
    fwrite($file, print_r($dataArray, TRUE) . "\n");
    fclose($file);
}

if (empty($lead_id))
{
    $error_fields['lead_id'] = ['lead_id field is required.'];
}



if (empty($leadscore))
{
    $error_fields['lead_score'] = ['lead_score field is required.'];
}


createLog('{on initial action}', 'get_leadscore_status' . date('Y-m-d') . '_log.txt', $lead_id, $_REQUEST);

if ($error_fields)
{
    createLog('{while get an error}', 'get_leadscore_status' . date('Y-m-d') . '_log.txt', $test_status, $data);

    $response_result = array('status' => '400', 'result' => $error_fields);
    echo json_encode($response_result);
    exit();
}



  if ($lead_id && $leadscore)
    {
       
      
      
         
            $updateleadSql  = "UPDATE leads_cstm ls
                            LEFT JOIN leads l ON l.id = ls.id_c
                            SET ls.lead_score = '$leadscore',
                                l.date_modified=NOW()
                            WHERE l.id = '$lead_id'";
            
            $checkSaveBean     = $db->Query($updateleadSql);
            
            if ($checkSaveBean)
            {
                $sx = $c_status . '_' . $c_status_description;
                createLog('{while status get saved}', 'get_leadscore_status' . date('Y-m-d') . '_log.txt', $sx, $data);
                echo json_encode(array('status' => '200', 'msg' => 'Lead saved successfully!'));
                exit();
            }
            else
            {
                echo json_encode(array('status' => 'error', 'msg' => 'Some thing gone wrong!'));
                exit();
            }
            
        
    }
    else
    {
       echo json_encode(array('status' => 'success', 'msg' => 'Lead ID or Lead Score not get passed!'));  
    }

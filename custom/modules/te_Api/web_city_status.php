<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
ini_set('memory_limit', '1024M');
require_once('include/entryPoint.php');
global $db,$app_list_strings;
$data         = json_decode(file_get_contents('php://input'), true);
$error_fields = [];
$discount     = ' 0';



$lead_id         = '';
$site_lead_id    = isset($data['site_lead_id']) ? $data['site_lead_id'] : '';
$functional_area = isset($data['functional_area']) ? $data['functional_area'] : 'NA';
$experience      = isset($data['experience']) ? $data['experience'] : 'NA';
$qualification   = isset($data['qualification']) ? $data['qualification'] : 'NA';

$country_name = isset($data['country_name']) ? $data['country_name'] : 'NA';
$state        = isset($data['state']) ? $data['state'] : 'NA';
$city         = isset($data['city']) ? $data['city'] : 'NA';

if (isset($country_name) && $country_name != '')
{
     $country_code = isset($app_list_strings['countries_list_code'][$country_name]['code']) ? $app_list_strings['countries_list_code'][$country_name]['code'] : 'NA';
    
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

if (!isset($data['site_lead_id']) || empty($data['site_lead_id']))
{
    $error_fields['site_lead_id'] = ['site_lead_id field is required.'];
}


createLog('{on initial action}', 'web_city_status_' . date('Y-m-d') . '_log.txt', $site_lead_id, $data);

if ($error_fields)
{
    createLog('{while get an error}', 'web_city_status_' . date('Y-m-d') . '_log.txt', $site_lead_id, $data);

    $response_result = array('status' => '400', 'result' => $error_fields);
    echo json_encode($response_result);
    exit();
}

function getLeadId($site_lead_id)
{
    global $db;
    $getLeadSql  = "SELECT 
                         lc.id_c lead_id
                         FROM leads_cstm lc
                 where 
                 lc.`site_lead_id`='$site_lead_id' ";
    $leadObj     = $db->Query($getLeadSql);
    $leadObjData = $db->fetchByAssoc($leadObj);
    return $leadObjData['lead_id'];
}

if ($site_lead_id != '')
{
    $lead_id = getLeadId($order_id);

    if ($lead_id)
    {

        $LBean = BeanFactory::getBean('Leads', $lead_id);

        $site_lead_id    = isset($data['site_lead_id']) ? $data['site_lead_id'] : '';
        $functional_area = isset($data['functional_area']) ? $data['functional_area'] : 'NA';
        $experience      = isset($data['experience']) ? $data['experience'] : 'NA';
        $qualification   = isset($data['qualification']) ? $data['qualification'] : 'NA';

        $country_name = isset($data['country_name']) ? $data['country_name'] : 'NA';
        $state        = isset($data['state']) ? $data['state'] : 'NA';
        $city         = isset($data['city']) ? $data['city'] : 'NA';


        $LBean->primary_address_city    = $city;
        $LBean->functional_area_c       = $functional_area;
        $LBean->work_experience_c       = $experience;
        $LBean->education_c             = $qualification;
        $LBean->primary_address_state   = $state;
        $LBean->country_code            = $country_code;
        $LBean->primary_address_country = $country_name;
        $LBean->country_log             = $country_name;

        $checkSaveBean = $LBean->save();

        if ($checkSaveBean)
        {

            createLog('{while status get saved in DB}', 'web_city_status_' . date('Y-m-d') . '_log.txt', $checkSaveBean, $data);
            echo json_encode(array('status' => 'success', 'msg' => 'Lead saved successfully!'));
            exit();
        }
        else
        {
            echo json_encode(array('status' => 'error', 'msg' => 'Some thing gone wrong!'));
            createLog('{while status not get updated on DB:}', 'web_city_status_' . date('Y-m-d') . '_log.txt', $site_lead_id, $data);
            exit();
        }
    }
    else
    {
        echo json_encode(array('status' => 'success', 'msg' => 'Lead ID not get fetched!'));
        createLog('{while Lead ID not get Fetched from DB:}', 'web_city_status_' . date('Y-m-d') . '_log.txt', $site_lead_id, $data);
        exit();
    }
}


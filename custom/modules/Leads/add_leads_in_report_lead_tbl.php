<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class saveLeadClass
{

    function createLog($action, $filename, $field = '', $dataArray = array())
    {
        $file = fopen(str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']) . "upload/apilog/$filename", "a");
        fwrite($file, date('Y-m-d H:i:s') . "\n");
        fwrite($file, $action . "\n");
        fwrite($file, $field . "\n");
        fwrite($file, print_r($dataArray, TRUE) . "\n");
        fclose($file);
    }

    function add_lead(&$bean, $event, $argument)
    {
     global $db;
     $beanId       = $bean->id;

     
    $lead_rel   =$db->query($insert_query); 
    
    if($lead_rel){
        
        $this->createLog('{"LeadID:'.$beanId.'" sucsessfully insert into report_leads}', 'lead_created_"'.date('Y-m-d').'".txt', $lead_rel, $_REQUEST);
    }
     
    }

}

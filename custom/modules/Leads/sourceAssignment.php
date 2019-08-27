<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

//error_reporting(-1);
//ini_set('display_errors', 'On');

class leadAssignmentClass
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

    function getRules()
    {
        global $db;
        $ruleSql      = "SELECT   `rule_name`,
                                        `source_name`,
                                        `batch_code`,
                                        `campaign_id`,
                                        `lead_id`
                                 FROM source_lead_assignment_rule
                                 WHERE status=1
                                   AND deleted=0
                                 ORDER BY reg_date DESC";
        $rule_Obj     = $db->query($ruleSql);
        $rule_Options = array();
        while ($row          = $db->fetchByAssoc($rule_Obj))
        {
            $rule_Options[strtolower($row['source_name'] . '_' . $row['batch_code'])]['campaign_id'] = $row['campaign_id'];
            $rule_Options[strtolower($row['source_name'] . '_' . $row['batch_code'])]['lead_id']     = $row['lead_id'];
        }
        return $rule_Options;
    }

    function leadassignmentruleFunc($bean, $event, $arguments)
    {
        global $db;
        $ruleListData = $this->getRules();



        $webMatch = strtolower($bean->utm_source_c . '_' . $bean->utm_term_c);
        if (isset($ruleListData[$webMatch]))
        {


            $rule_campaign_id = $ruleListData[$webMatch]['campaign_id'];
            $rule_lead_id     = $ruleListData[$webMatch]['lead_id'];

            $bean->dristi_campagain_id = $rule_campaign_id;
            $bean->dristi_API_id       = $rule_lead_id;
            
            $this->createLog('{Source Lead Assignment Rule}','sourceleadassignmentrule_log'.date('Y-m-d').'.txt',$rule_campaign_id,$ruleListData[$webMatch]);    
        }
    }

}

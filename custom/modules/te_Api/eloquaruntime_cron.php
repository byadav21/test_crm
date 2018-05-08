<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
ini_set('memory_limit', '1024M');
require_once('include/entryPoint.php');
require_once('custom/modules/Leads/eloqua/lib/eloquaRequest.php');

//error_reporting(-1);
//ini_set('display_errors', 'On');

global $db;
error_reporting(-1);
ini_set('display_errors', 'On');

class eloquaRuntime
{
    
    public function getBatch()
    {
        global $db;
        $batchSql     = "SELECT id,batch_code FROM te_ba_batch WHERE  deleted=0 order by name";
        $batchObj     = $db->query($batchSql);
        $batchOptions = array();
        while ($row          = $db->fetchByAssoc($batchObj))
        {
            $batchOptions[$row['batch_code']] = $row['id'];
        }
        return $batchOptions;
    }
    
    public function main()
    {
        global $sugar_config, $app_list_strings, $current_user, $db;

        $client = new EloquaRequest('https://secure.p07.eloqua.com/API/REST/1.0');
        $batchData = $this->getBatch();
        
        //print_r($batchData); die;

        $leadListData = array();
        $restultCount = 1000;
        $page         = 1;
        $slug         = '';

        //$AutomateArr = array(1=>10,2=>20);
        //foreach ($AutomateArr as $key=>$val)  { }
        //700

        for ($i = 1; $i <= 700; $i++)
        {
            echo "data/customObject/7?count=$restultCount&page=$i<br>";
            $response = $client->get("data/customObject/7?count=$restultCount&page=$i");
            $array    = json_decode(json_encode($response), true);


            if (!empty($array['elements']))
            {
                foreach ($array['elements'] as $key => $val)
                {
                    $leadListData[$val['id']]['email'] = isset($val['fieldValues'][0]['value']) ? $val['fieldValues'][0]['value'] : '';
                    $leadListData[$val['id']]['batch_code'] = isset($val['fieldValues'][2]['value']) ? $val['fieldValues'][2]['value'] : '';
                    
                    $objectID                          = $val['id'];
                    $emailID                           = isset($val['fieldValues'][0]['value']) ? $val['fieldValues'][0]['value'] : '';
                    $bathCode                          = isset($val['fieldValues'][2]['value']) ? $val['fieldValues'][2]['value'] : '';

                    if ($emailID != '' && $bathCode!='')
                    {   
                        $batchID = isset($batchData[$bathCode])? $batchData[$bathCode] : '';
                  //echo "update leads_cstm set eloqua_customobject_id=$objectID where email_add_c='$emailID' and te_ba_batch_id_c='$batchID'<br>";
                        $re = $GLOBALS['db']->query("update leads_cstm set eloqua_customobject_id=$objectID where email_add_c='$emailID' and te_ba_batch_id_c='$batchID'");
                        
                    }
                    else if($emailID != '' && $bathCode==''){
                        
                         $re = $GLOBALS['db']->query("update leads_cstm set eloqua_customobject_id=$objectID where email_add_c='$emailID'");
                    }
                }
            } // End of empty array
        } // End of For loop
        echo '<pre>'; print_r($leadListData);
    }

}

$mainObj = new eloquaRuntime();
$mainObj->main();


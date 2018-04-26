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

    public $fromDate;
    public $toDate;

    public function __construct()
    {
        $this->fromDate = date('Y-m-d');
        $this->toDate   = date('Y-m-d');
    }

    public function main()
    {
        global $sugar_config, $app_list_strings, $current_user, $db;
        
         $client = new EloquaRequest('https://secure.p07.eloqua.com/API/REST/1.0');


        
        $leadListData = array();
        $restultCount = 10;
        $page =1;
        
        //700
        for ($i = 1; $i <= 1; $i++)
        {

            //$response = $client->get("data/contacts?count=$restultCount&page=$i" . $slug, $contact);
            
            $response = $client->get("data/customObject/7?count=$restultCount&page=$i" . $slug, $contact);
            if (!empty($response->elements))
            {

               /* 
                foreach ($response->elements as $key => $val)
                
                {
                    //echo 'xxx'.$val->id;
                    $leadList[$val->id]['id']           = $val->id;
                    $leadList[$val->id]['name']         = $val->name;
                    $leadList[$val->id]['emailAddress'] = $val->emailAddress;
                }
               */
                foreach ($response->elements as $key => $val)
                    {  

                        foreach ($val->fieldValues as $keyx => $valxx)
                        {
                            $leadList[$val->id]['email'][0] = isset($valxx)? $valxx :'N/A';
                            $leadList[$val->id]['email'][0] = isset($valxx)? $valxx :'N/A';
                        }
                    }

                echo '<pre>';
                print_r($leadList);
            }
        }
    }

}

$mainObj           = new eloquaRuntime();
//$mainObj->toDate   = '2017-09-30';
//$mainObj->fromDate = '2017-09-01';
if (strtotime($mainObj->fromDate) == strtotime($mainObj->toDate))
{
    $fromDate = date('Y-m-d', (strtotime('-1 day', strtotime($mainObj->fromDate))));
}

$mainObj->toDate   = $fromDate;
$mainObj->fromDate = $fromDate;

$mainObj->main();


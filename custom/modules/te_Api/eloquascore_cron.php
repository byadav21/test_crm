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

class eloquaScore
{

    public function main()
    {
        global $sugar_config, $app_list_strings, $current_user, $db;

        $client = new EloquaRequest('https://secure.p07.eloqua.com/api/bulk/2.0');

        $itemcount = 704182;
        $limit     = 1000;
        $interval  = $itemcount / $limit;

        for ($i = 1; $i <= $interval; $i++)
        {
            $offset = $i * $limit;

            echo "syncs/1/data?offset=$offset&limit=$limit<br>";
            $response = $client->get("syncs/1/data?offset=$offset&limit=$limit");
            $array    = json_decode(json_encode($response), true);


            if (!empty($array['items']))
            {
                foreach ($array['items'] as $key => $val)
                {

                    $Rating       = isset($val['Rating']) ? $val['Rating'] : '';
                    $EmailAddress = isset($val['EmailAddress']) ? $val['EmailAddress'] : '';

                    if ($Rating != '' && $EmailAddress != '')
                    {

                        $sql = "update leads_cstm set eloqua_lead_score='$Rating' where email_add_c='$EmailAddress'";
                        //$re  = $GLOBALS['db']->query($sql);
                    }
                }
            } // End of empty array

            echo '<pre>';
            print_r($array);
        } // End of For loop #
    }

}

$mainObj = new eloquaScore();
$mainObj->main();


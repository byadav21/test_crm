<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');


//error_reporting(-1);
//ini_set('display_errors', 'On');

class leadAssignmentClass
{

    function createLog($action,$filename,$field='',$dataArray=array())
    {
        $file = fopen(str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']) . "upload/apilog/$filename", "a");
        fwrite($file, date('Y-m-d H:i:s') . "\n");
        fwrite($file, $action . "\n");
        fwrite($file, $field . "\n");
        fwrite($file, print_r($dataArray, TRUE) . "\n");
        fclose($file);
    }

    function leadassignmentruleFunc($bean, $event, $arguments)
    {
        global $db;
        $leadsCstmData = array();
        $contactArr = array();
        $contactIDAPI ='';
        echo "<pre>"; print_r($bean); die;

    }

}

<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
ini_set('display_errors', '1');

error_reporting(E_ALL);
global $app_list_strings, $current_user, $sugar_config, $db;


if (isset($_POST['action']) && $_POST['action'] == 'updatenoteajax')
{
    global $db;
    $option = '';
   
    $param = $_POST['param']; $leadid = $_POST['leadid'];
   

    if ($param!='')
    {
        $updateSql = "UPDATE leads SET note='".$param."' where id='$leadid'";
        $usObj = $GLOBALS['db']->Query($updateSql);
       
        if($usObj){
            echo json_encode(array('status'=>'success','msg'=>'Note saved successfully!'));
        }
    }
    die;
}

if (isset($_POST['action']) && $_POST['action'] == 'updatecommentajax')
{
    global $db;
    $option = '';
   
    $param = $_POST['param']; $leadid = $_POST['leadid'];
   

    if ($param!='')
    {
        $updateSql = "UPDATE leads SET comment='".$param."' where id='$leadid'";
        $usObj = $GLOBALS['db']->Query($updateSql);
       
        if($usObj){
            echo json_encode(array('status'=>'success','msg'=>'Comment saved successfully!'));
        }
    }
    die;
}
?>

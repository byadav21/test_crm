<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
ini_set('display_errors', '1');

error_reporting(E_ALL);
global $app_list_strings, $current_user, $sugar_config, $db;

$action = filter_var($_POST['action'], FILTER_SANITIZE_STRING);
$param  = filter_var($_POST['param'], FILTER_SANITIZE_STRING);
$leadid = filter_var($_POST['leadid'], FILTER_SANITIZE_STRING);

if (isset($action) && $action == 'updatenoteajax')
{
    global $db;
    $option = '';

    if ($param != '')
    {

        $note = mysqli_real_escape_string($db->database, $param);

        $updateSql = "UPDATE leads SET note='" . $note . "' where id='$leadid'";
        $usObj     = $GLOBALS['db']->Query($updateSql);

        if ($usObj)
        {
            echo json_encode(array('status' => 'success', 'msg' => 'Note saved successfully!'));
        }
    }
    die;
}

if (isset($action) && $action == 'updatecommentajax')
{
    global $db;
    $option = '';

    if ($param != '')
    {
        $comment = mysqli_real_escape_string($db->database, $param);

        $updateSql = "UPDATE leads SET comment='" . $comment . "' where id='$leadid'";
        $usObj     = $GLOBALS['db']->Query($updateSql);

        if ($usObj)
        {
            echo json_encode(array('status' => 'success', 'msg' => 'Comment saved successfully!'));
        }
    }
    die;
}
?>

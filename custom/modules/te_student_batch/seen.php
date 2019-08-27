<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

require_once('custom/modules/te_student/te_student_override.php');
global $current_user;

$obj                               = new te_student_override();
global $current_user;
$currentUserId                     = $current_user->id;
$reportingUserIds                  = array();
$obj->reportingUser($currentUserId);
$obj->report_to_id[$currentUserId] = $current_user->name;
$reportingUserIds                  = $obj->report_to_id;
$user_ids                          = implode("', '", array_keys($reportingUserIds));


if ($current_user->isAdmin())
    $user_ids = '';

$new      = 0;


if ($_GET['type'] == 'new_conversion')
{

    $obj->setSeen('is_new', 'te_student_batch', $user_ids, 'Active');
    print json_encode(array('status' => '1'));
}
else if ($_GET['type'] == 'new_call_dropout')
{
    $obj->setSeenDropout('is_new_dropout', 'leads', $user_ids);
    header('Location: index.php?module=Leads&action=index');
}
else if ($_GET['type'] == 'new_transfer')
{

    $obj->setSeenTransfer('is_new_approved', 'te_transfer_batch', $user_ids);
    print json_encode(array('status' => 1));
}
else if ($_GET['type'] == 'approved_dropout')
{

    $obj->setApprovedDropout('is_new_dropout', 'te_student_batch', $user_ids);
    print json_encode(array('status' => 1));
}
else
{

    header('Location: index.php?module=te_transfer_batch');
} 

 

<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
//require_once('custom/modules/te_Api/sso.php');
require_once('modules/te_neox_call_details/te_neox_call_details.php');

print_r($_REQUEST);

$obj=new te_neox_call_details();
if($_REQUEST['Crtobjectid']) $obj->unique_id= $_REQUEST['Crtobjectid'];
if($_REQUEST['srmNumber']) $obj->srmno= $_REQUEST['srmNumber'];
if($_REQUEST['studentNumber']) $obj->student_no= $_REQUEST['studentNumber'];
if($_REQUEST['callTime']) $obj->calltime= $_REQUEST['callTime'];
if($_REQUEST['startTime']) $obj->starttime= $_REQUEST['startTime'];
if($_REQUEST['endTime']) $obj->endtime= $_REQUEST['endTime'];
if($_REQUEST['status']) $obj->status= $_REQUEST['status'];
if($_REQUEST['callDuration']) $obj->talk_duration= $_REQUEST['callDuration'];
$obj->save();

<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('custom/modules/te_Api/te_Api.php');
require_once('modules/te_neox_call_details/te_neox_call_details.php');
global $db;

 
$db->query("delete from  session_call where  session_id='" . session_id() ."'");
$objapi= new te_Api_override();
$objapi->createLog(print_r($_REQUEST,true),"dispose mannually ".session_id() );
 
/*$obj=new te_neox_call_details();
if($_REQUEST['phone']) $obj->phone_number= $_REQUEST['phone'];
if($_REQUEST['campaignId']) $obj->campaignid= $_REQUEST['campaignId'];
if($_REQUEST['customerCRTId']) $obj->userid= $_REQUEST['customerCRTId'];
if($_REQUEST['callType']) $obj->callType= $_REQUEST['callType'];
if($_REQUEST['recordingFileUrl']) $obj->recording_file= $_REQUEST['recordingFileUrl'];
if($_REQUEST['ringingTime']) $obj->ringingTime= $_REQUEST['ringingTime'];
if($_REQUEST['lastStatus']) $obj->status= $_REQUEST['lastStatus'];
if($_REQUEST['ivrTime']) $obj->ivrTime= $_REQUEST['ivrTime'];
if($_REQUEST['callId']) $obj->unique_id= $_REQUEST['callId'];
if($_REQUEST['setupTime']) $obj->setupTime= $_REQUEST['setupTime'];
if($_REQUEST['dialedTime']) $obj->dialedTime= $_REQUEST['dialedTime'];
if($_REQUEST['customerId']) $obj->customerId= $_REQUEST['customerId'];
if($_REQUEST['talkTime']) $obj->talk_duration= $_REQUEST['talkTime'];
if($_REQUEST['dispositionCode']) $obj->dispositionCode= $_REQUEST['dispositionCode'];
$obj->description=json_encode($_REQUEST);
$user=json_decode(html_entity_decode($_REQUEST['userAssociations']));
if(isset($user[0]->userId)) $obj->name=$user[0]->userId;
$obj->save();*/

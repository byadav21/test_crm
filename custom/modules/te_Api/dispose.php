<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('custom/modules/te_Api/te_Api.php');
require_once('modules/te_disposition/te_disposition.php');

require_once('modules/te_neox_call_details/te_neox_call_details.php');
global $db;


if(isset($_REQUEST['checkCallStatus']) && isset($_REQUEST['records']) && $_REQUEST['checkCallStatus']==1 && $_REQUEST['records'] ){
        //echo "select id from  session_call where lead_id='". $_REQUEST['records'] ."' session_id='" . session_id() ."'";
		$res=$db->query("select id from  session_call where lead_id='". $_REQUEST['records'] ."' and session_id='" . $_REQUEST['customerCRTId'] ."'");
        if($db->getRowCount($res)>0){
                echo '1';
        }
        exit();
}


$sql="delete from  session_call where  session_id='" . $_REQUEST['customerCRTId'] ."'";
$db->query($sql);
$objapi= new te_Api_override();
$objapi->createLog(print_r($_REQUEST,true),'disposeamyo',$_REQUEST);

if(isset($_REQUEST['customerCRTId']) && $_REQUEST['customerCRTId']){
  $sql="select id from te_neox_call_details where userid='".$_REQUEST['customerCRTId']."'";
  $res=$db->query($sql);
  if($db->getRowCount($res)>0){
                
     $records=$db->fetchByAssoc($res);  
     $id=$records['id']; 

     $sql ="update te_neox_call_details set ";
			if($_REQUEST['phone']) $sql .= "phone_number='". $_REQUEST['phone'] . " ' ,";
			if($_REQUEST['campaignId']) $sql .= " campaignid='". $_REQUEST['campaignId'] . " ' ,";		 
			if($_REQUEST['callType']) $sql .= " callType='". $_REQUEST['callType'] . " ' ,";
			if($_REQUEST['recordingFileUrl']) $sql .= " recording_file='". $_REQUEST['recordingFileUrl'] . " ' ,";
			if($_REQUEST['ringingTime']) $sql .= " ringingTime='". $_REQUEST['ringingTime'] . " ' ,";
			if($_REQUEST['lastStatus']) $sql .= " status='". $_REQUEST['lastStatus'] . " ' ,";
			if($_REQUEST['ivrTime']) $sql .= " ivrTime='". $_REQUEST['ivrTime'] . " ' ,";
			if($_REQUEST['callId'])$sql .= " unique_id='". $_REQUEST['callId'] . " ' ,";
			if($_REQUEST['setupTime']) $sql .= " setupTime='". $_REQUEST['setupTime'] . " ' ,";
			if($_REQUEST['dialedTime']) $sql .= " dialedTime='". $_REQUEST['dialedTime'] . " ' ,";
			if($_REQUEST['customerId'])$sql .= " customerId='". $_REQUEST['customerId'] . " ' ,";
			if($_REQUEST['talkTime']) $sql .= " talk_duration='". $_REQUEST['talkTime'] . " ' ,";
			if($_REQUEST['dispositionCode']) $sql .= " dispositionCode='". $_REQUEST['dispositionCode'] . " ' ,";  
			$user=json_decode(html_entity_decode($_REQUEST['userAssociations']));
			if(isset($user[0]->userId))$sql .= " name='". $user[0]->userId . " ' ,"; 
			$sql .= " description='". json_encode($_REQUEST) . " ' where id='". $id . "'";  
			$res=$db->query($sql);
           // $objapi->createLog(print_r($_REQUEST,true),$sql);
    
	if( $_REQUEST['callType']=='auto.dial.customer' && $_REQUEST['dispositionName']=='NO_ANSWER' && $_REQUEST['customerId'] ){
				
				$sql="select attempts_c,id_c from leads inner join  leads_cstm on id_c=id where dristi_customer_id='". $_REQUEST['customerId'] ."'";
				$res=$db->query($sql);
				 if($db->getRowCount($res)>0){
                
					 $records=$db->fetchByAssoc($res);  
					 $id=$records['id_c']; 
					 $attempid=intval($records['attempts_c']);
					 $attempid++; 
					 $sql="update leads_cstm set attempts_c='". $attempid."' where id_c='".  $id."'";
					 $res=$db->query($sql);

					$disposition = new te_disposition();
					$disposition->status 	   = 'No Answer';
					$disposition->status_detail  =  'No Answer';					 
					$disposition->name 		   	 =  'No Answer';
					$disposition->te_disposition_leadsleads_ida 		  = $id;
					$disposition->save();
                                            

				}
				
	}


         exit();
  } 

	$obj=new te_neox_call_details();	
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
	$obj->save();


	if( $_REQUEST['callType']=='auto.dial.customer' && $_REQUEST['dispositionName']=='NO_ANSWER' && $_REQUEST['customerId'] ){
				
				$sql="select attempts_c,id_c from leads inner join  leads_cstm on id_c=id where dristi_customer_id='". $_REQUEST['customerId'] ."'";
				$res=$db->query($sql);
				 if($db->getRowCount($res)>0){
                
					 $records=$db->fetchByAssoc($res);  
					 $id=$records['id_c']; 
					 $attempid=intval($records['attempts_c']);
					 $attempid++; 
					 $sql="update leads_cstm set attempts_c='". $attempid."' where id_c='".  $id."'";
					 $res=$db->query($sql);
					$disposition = new te_disposition();
					$disposition->status 	   = 'No Answer';
					$disposition->status_detail  =  'No Answer';					 
					$disposition->name 		   	 =  'No Answer';
					$disposition->te_disposition_leadsleads_ida 		  = $id;
					$disposition->save();
				}
				
	}

}


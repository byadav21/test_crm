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

    
	if( $_REQUEST['callType']=='auto.dial.customer' && $_REQUEST['dispositionName']=='NO_ANSWER' && $_REQUEST['lead_reference'] ){
				
				$sql="select attempts_c,id_c from leads inner join  leads_cstm on id_c=id where id='". $_REQUEST['lead_reference'] ."'";
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


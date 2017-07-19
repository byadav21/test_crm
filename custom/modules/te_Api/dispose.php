<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('custom/modules/te_Api/te_Api.php');
require_once('modules/te_disposition/te_disposition.php');
require_once('modules/te_neox_call_details/te_neox_call_details.php');
global $db;
 unset($_SESSION['temp_for_newUser']); 
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

if(isset($_REQUEST['customerCRTId']) && $_REQUEST['customerCRTId']){

 $objapi->createLog(print_r($_REQUEST,true),'disposeamyo',$_REQUEST);   
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
					 if($attempid==10){
						 $sql="update leads set status='Dead', status_description='Retired' where id='".  $id ."'";
						 $res=$db->query($sql);
					 }

					$disposition = new te_disposition();
					$disposition->status 	   = 'No Answer';
					$disposition->status_detail  =  'No Answer';					 
					$disposition->name 		   	 =  'No Answer';
					$disposition->te_disposition_leadsleads_ida 		  = $id;
					$disposition->save();
                                            

				}
				
	}


	$phone=$_REQUEST['phone'];	
	if(isset($_REQUEST['lead_reference'])  && $_REQUEST['lead_reference'] && $_REQUEST['lead_reference']!=''){
		$lead="select id,assigned_user_id,first_name,last_name,status,status_description,dristi_campagain_id from  leads where  id='". $_REQUEST['lead_reference'] ."' and deleted=0 and status!='Duplicate' ";
		 
	}else{
	 
		 $lead="select id,assigned_user_id,first_name,last_name,status,status_description,dristi_campagain_id from  leads where ( phone_mobile like '%$phone%' or    phone_other like '%$phone%' ) and status!='Duplicate' and deleted=0 ";
		
	}
	$res=$db->query($lead);
	if($db->getRowCount($res) > 0){
		$records=$db->fetchByAssoc($res);
		$db->query("update leads set dristi_request=null where id='". $records['id'] ."'");
	}


	
	if( $_REQUEST['callType']=='manual.dial.customer' ){
									
					
						//$res=$db->query($lead);
						if($db->getRowCount($res) > 0){
                                                        $campID=18;
                                                        $apiID=42;
							$records=$db->fetchByAssoc($res);		
							$api=new te_Api_override();
							$data=[];
							$session=$api->doLogin();								
							$data['sessionId']=$session;
							$data['properties']=array('update.customer'=>true,'migrate.customer'=>true);
							$data['customerRecords']=[];
							$customerRecords['name']= $records['first_name']." ". $records['last_name'];
							$customerRecords['first_name'] = $records['first_name'];
							$customerRecords['last_name'] = ($records['last_name'])? $records['last_name']:'';					
							$customerRecords['phone1'] =$phone;						 
							$customerRecords['lead_reference'] = $records['id'];
							$data['customerRecords'][]=$customerRecords;
                                                        
                                                        if($records['dristi_campagain_id']==18){
                                                            
                                                            $campID=18;
                                                            $apiID=46;
                                                        }
                                                        else if($records['dristi_campagain_id']==16){
                                                            
                                                            $campID=16;
                                                            $apiID=47;
                                                        }
                                                        else if($records['dristi_campagain_id']==17){
                                                            
                                                            $campID=17;
                                                            $apiID=48;
                                                        }
                                                        
							$responses=$api->uploadContacts($data,$campID,$apiID);
				         	}
	}
    exit();
 


}
die;

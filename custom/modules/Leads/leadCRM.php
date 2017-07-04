<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('custom/modules/te_Api/te_Api.php');
require_once('custom/modules/te_student/te_student_override.php');

global $current_user,$db;
$customerId= $_REQUEST['customerId'];
$userID= $_REQUEST['userId'];
$phone= $_REQUEST['phone'];
$callType= $_REQUEST['callType']; 
$callObjId= $_REQUEST['userCrtObjectId']; 
$mainMenu= $_REQUEST['mainMenu']; 
$_REQUEST['customerInfo']=$customers=json_decode(html_entity_decode($_REQUEST['customerInfo']));
$_SESSION['temp_for_newUser']= json_encode($_REQUEST) ;

try{
	$objapi= new te_Api_override();
	$objapi->createLog(print_r($_REQUEST,true),"crm popup url",$_REQUEST); 
		
	$getUserIDs= "select id,user_name from users where user_name='$userID'";
	$getUserID=$db->query($getUserIDs);
	if($db->getRowCount($getUserID) > 0){
		
		if($mainMenu==1 &&  $callType=='inbound.call.dial'){
			
			$student= "select id,assigned_user_id,name as first_name,'' as last_name,'Active','Student' from  te_student where    mobile like '%$phone%' and deleted=0";
			$res=$db->query($student);
			if($db->getRowCount($res) > 0){
				
				/*if($records['assigned_user_id']!=$userid['id']){
					header('Location: index.php?module=Leads&action=search_leads&Search=1&search_leads=1&mobile_number='. $phone);
				}*/
				$records=$db->fetchByAssoc($res);		
				header('Location: index.php?module=te_student&action=DetailView&record='. $records['id']); exit();	
				
			}else{
				header('Location: index.php?module=Leads&action=search_leads&Search=1&search_leads=1&mobile_number='. $phone);exit();
			}		
			
		}
		
		
		$userid=$db->fetchByAssoc($getUserID);
		if($callType=='outbound.auto.dial'){	
			$lead="select id,assigned_user_id,first_name,last_name,status,status_description,dristi_campagain_id from  leads where  id='". $customers->lead_reference ."' and deleted=0 and status!='Duplicate' ";
			$res=$db->query($lead); 
			
						
		}else if($callType=='outbound.manual.dial'){
			if(isset($customers->lead_reference) && $customers->lead_reference){
				$lead="select id,assigned_user_id,first_name,last_name,status,status_description,dristi_campagain_id from  leads where  id='". $customers->lead_reference ."' and deleted=0 and status!='Duplicate' ";
				$res=$db->query($lead);
			}
			if($db->getRowCount($res) == 0){	
				 $lead="select id,assigned_user_id,first_name,last_name,status,status_description,dristi_campagain_id from  leads where ( phone_mobile like '%$phone%' or    phone_other like '%$phone%' ) and status!='Duplicate' and deleted=0 ";
				 $res=$db->query($lead);
			}	
			
				
		}else if($callType=='inbound.call.dial'){
			
		 
				$lead="select id,assigned_user_id,first_name,last_name,status,status_description,dristi_campagain_id from  leads where (    phone_mobile like '%$phone%' or    phone_other like '%$phone%' )  and status!='Duplicate' and deleted=0  ";
				$res=$db->query($lead);			
		
			
		
		}else if($callType=='outbound.callback.dial'){	
			if(isset($customers->lead_reference) && $customers->lead_reference){
				$lead="select id,assigned_user_id,first_name,last_name,status,status_description,dristi_campagain_id from  leads where  id='". $customers->lead_reference ."' and deleted=0 and status!='Duplicate' ";
				$res=$db->query($lead);
			}	 
			
			if($db->getRowCount($res) == 0){	
				 $lead="select id,assigned_user_id,first_name,last_name,status,status_description,dristi_campagain_id from  leads where (    phone_mobile like '%$phone%' or    phone_other like '%$phone%' )  and deleted=0 and status!='Duplicate'";
				 $res=$db->query($lead);
			}	
			
		
		}	
	 
	  
	 
		if($db->getRowCount($res) > 0){	
			$records=$db->fetchByAssoc($res);	
			//print_r($records);die;
			if($callType=='outbound.auto.dial' || $callType=='outbound.callback.dial'){		

				if(empty($records['assigned_user_id']) ||  $records['assigned_user_id']==NULL ||  $records['assigned_user_id']=='NULL'){
					$db->query("update leads set call_object_id='". $callObjId  ."' , dristi_request='".  json_encode($_REQUEST) ."',assigned_user_id='". $userid['id'] ."',assigned_date='". date('Y-m-d H:i:s') ."'  where id='". $records['id'] ."'");	
					
					$db->query("insert into dristi_log set customer_id='". $customerId  ."', callType='". $callType ."', dated='". date('Y-m-d H:i:s')."', phone='". $phone ."',lead_id='". $records['id'] ."',entryPoint='assigned',dispositionName='". $userid['user_name'] ."',customerCRTId='". $userid['id']  ."', userId='". $userID  ."'");	
					 
					include_once("custom/modules/Leads/overview.php");
				}else if($records['assigned_user_id']!=$userid['id']){	
					header('Location: index.php?module=Leads&action=search_leads&Search=1&search_leads=1&mobile_number='. $phone);exit();
				}else{
					
					 
					
					$db->query("update leads set  call_object_id='". $callObjId  ."' , dristi_request='".  json_encode($_REQUEST) ."',assigned_user_id='". $userid['id'] ."'    where id='". $records['id'] ."'");	 
					
					$db->query("insert into dristi_log set customer_id='". $customerId  ."', callType='". $callType ."', dated='". date('Y-m-d H:i:s')."', phone='". $phone ."',lead_id='". $records['id'] ."',entryPoint='assigned',dispositionName='". $userid['user_name'] ."',customerCRTId='". $userid['id']  ."', userId='". $userID  ."'");	
					
					include_once("custom/modules/Leads/overview.php");
					
				}

			}else if($callType=='inbound.call.dial'){
				
				 
                if(empty($records['assigned_user_id']) ||  $records['assigned_user_id']==NULL ||  $records['assigned_user_id']=='NULL'){					
					$db->query("update leads set  call_object_id='". $callObjId  ."' , dristi_request='".  json_encode($_REQUEST) ."',assigned_user_id='". $userid['id'] ."',assigned_date='". date('Y-m-d H:i:s') ."'    where id='". $records['id'] ."'");	
						
					$db->query("insert into dristi_log set customer_id='". $customerId  ."', callType='". $callType ."', dated='". date('Y-m-d H:i:s')."', phone='". $phone ."',lead_id='". $records['id'] ."',entryPoint='assigned',dispositionName='". $userid['user_name'] ."',customerCRTId='". $userid['id']  ."', userId='". $userID  ."'");	
					include_once("custom/modules/Leads/overview.php");
					$api=new te_Api_override();
                                        $campID=18;
                                        $apiID=42;
					$data=[];
					$session=$api->doLogin();								
					$data['sessionId']=$session;
					$data['properties']=array('update.customer'=>'true','migrate.customer'=>'true');
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
					
				}else if($records['assigned_user_id']!=$userid['id']){
					 
					header('Location: index.php?module=Leads&action=search_leads&Search=1&search_leads=1&mobile_number='. $phone);
					 
				}else{
					
					$db->query("update leads set  call_object_id='". $callObjId  ."' , dristi_request='".  json_encode($_REQUEST) ."',assigned_user_id='". $userid['id'] ."'   where id='". $records['id'] ."'");	
					
					$db->query("insert into dristi_log set customer_id='". $customerId  ."', callType='". $callType ."', dated='". date('Y-m-d H:i:s')."', phone='". $phone ."',lead_id='". $records['id'] ."',entryPoint='assigned',dispositionName='". $userid['user_name'] ."',customerCRTId='". $userid['id']  ."', userId='". $userID  ."'");	
					
					include_once("custom/modules/Leads/overview.php");
				 
				}
				
				

			}else if($callType=='outbound.manual.dial'){
				
				 
               if(empty($records['assigned_user_id']) ||  $records['assigned_user_id']==NULL ||  $records['assigned_user_id']=='NULL'){					
					$db->query("update leads set  call_object_id='". $callObjId  ."' , dristi_request='".  json_encode($_REQUEST) ."',assigned_user_id='". $userid['id'] ."', assigned_date='". date('Y-m-d H:i:s') ."'   where id='". $records['id'] ."'");		
					
					$db->query("insert into dristi_log set customer_id='". $customerId  ."', callType='". $callType ."', dated='". date('Y-m-d H:i:s')."', phone='". $phone ."',lead_id='". $records['id'] ."',entryPoint='assigned',dispositionName='". $userid['user_name'] ."',customerCRTId='". $userid['id']  ."', userId='". $userID  ."'");	
				 
					include_once("custom/modules/Leads/overview.php");
				}else if($records['assigned_user_id']!=$userid['id']){
					 
					header('Location: index.php?module=Leads&action=search_leads&Search=1&search_leads=1&mobile_number='. $phone);
					 
				}else{
					
					$db->query("update leads set  call_object_id='". $callObjId  ."' , dristi_request='".  json_encode($_REQUEST) ."',assigned_user_id='". $userid['id'] ."'   where id='". $records['id'] ."'");	
					
					$db->query("insert into dristi_log set customer_id='". $customerId  ."', callType='". $callType ."', dated='". date('Y-m-d H:i:s')."', phone='". $phone ."',lead_id='". $records['id'] ."',entryPoint='assigned',dispositionName='". $userid['user_name'] ."',customerCRTId='". $userid['id']  ."', userId='". $userID  ."'");	
					
					include_once("custom/modules/Leads/overview.php");
					 
				}
				
				
				$api=new te_Api_override();
					$data=[];
					$session=$api->doLogin();								
					$data['sessionId']=$session;
					$data['properties']=array('update.customer'=>'true','migrate.customer'=>'true');
					$data['customerRecords']=[];
					$customerRecords['name']= $records['first_name']." ". $records['last_name'];
					$customerRecords['first_name'] = $records['first_name'];
					$customerRecords['last_name'] = ($records['last_name'])? $records['last_name']:'';					
					$customerRecords['phone1'] =$phone;						 
					$customerRecords['lead_reference'] = $records['id'];
					$data['customerRecords'][]=$customerRecords;
                                        $campID=18;
                                        $apiID=42;
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
		}else{
			 
			header('Location: index.php?module=Leads&action=EditView&return_module=Leads');
		}	
	}else{
		 
		header('Location: index.php?module=Leads&action=ListView');
	}

}catch(Exception $e){
	header('Location: index.php?module=Leads&action=EditView&return_module=Leads');
}
	
 
 

<?php
ini_set('max_execution_time', 3600);
set_time_limit(3600);
require_once('custom/modules/te_Api/te_Api.php');
$api=new te_Api_override();
global $db;

$sql="select lead_id from cron_job where session_id='cron_job'";
$result = $db->query($sql);
if($db->getRowCount($result)>0){
	$res=$db->fetchByAssoc($result);
	if($res['lead_id']==1) exit();
}


	

$sqll="SELECT count(l.id) as ctr  from leads l WHERE l.deleted =0 and l.neoxstatus='0'";
$res=$db->query($sqll);	
$countLead=$db->fetchByAssoc($res);
 
$db->query("update cron_job set lead_id='1' where session_id='cron_job'");
$sql="SELECT l.id,l.first_name,l.last_name,l.phone_mobile,l.phone_home,l.phone_work,l.phone_other,e.email_address , concat (dristi_campagain_id ,dristi_api_id) as drtord ,dristi_campagain_id ,dristi_api_id FROM leads l
 LEFT JOIN email_addr_bean_rel el ON l.id = el.bean_id AND el.bean_module='Leads' AND el.deleted=0
LEFT JOIN email_addresses e ON el.email_address_id = e.id AND e.deleted=0
WHERE l.deleted =0   AND l.status_description= 'New Lead' AND l.neoxstatus='0' and dristi_campagain_id !='' and dristi_api_id !='' AND (l.assigned_user_id= 'NULL' OR l.assigned_user_id ='' OR l.assigned_user_id IS NULL)  order by concat (dristi_campagain_id ,dristi_api_id)";
	
$allInserted=[];
$result = $db->query($sql);
$last='';
$ctr=0;
$currentCamp='';
$currentApi='';
$allInserted=[]; 
$pushed=false;
 
if($db->getRowCount($result)>0){
	
	$data=[];
	$session=$api->doLogin();								
	$data['sessionId']=$session;
	$data['properties']=array('update.customer'=>true,'migrate.customer'=>true);
	if(!$session){
		echo 'Invalid Session'; exit();
	}
	
	
	$customerRs=[];
	$data['customerRecords']=[];
	while($row =  $db->fetchByAssoc($result)){
		
		if($last!='' && $row['drtord']!=$last){
			$last=$row['drtord'];
			$request=$data;
			$data['customerRecords']=[];	
			$pushed=true; // print_r($request);
                        //echo count($request['customerRecords']);
			$responses=$api->uploadContacts($request,$currentCamp,$currentApi);
			if(isset($responses->beanResponse) && count($responses->beanResponse)>0){		
				foreach($responses->beanResponse as $key=>$res){
					if(isset($res->inserted) && ($res->inserted==1 or $res->inserted=='true') ){
						try{
							$update = "UPDATE leads set dristi_customer_id='".  $res->customerId ."', neoxstatus =1 WHERE id = '".  $allInserted[$key]['id']  ."'";
							$db->query($update);
							$sql="insert into dristi_upload_logs set lead_id='".  $allInserted[$key]['id'] ."',dated='". date('Y-m-d H:i:s') ."',customer_id='". $res->customerId ."',resultTypeString='". $res->resultTypeString ."',text='". json_encode($res)  ."'";
							$db->query($sql);	 
						}catch(Exception $e){
						   //crete log	
						}	
					}else{
						try{
							$sql="insert into dristi_upload_logs set lead_id='".  $allInserted[$key]['id'] ."',dated='". date('Y-m-d H:i:s') ."',customer_id='". $res->customerId ."',resultTypeString='". $res->resultTypeString ."',text='". json_encode($res)  ."'";
							$db->query($sql);
						}catch(Exception $e){
						   //crete log	
						}	
						
						
					}
				}
				
			}else{
				try{
					$sql="insert into dristi_upload_logs set lead_id='".  $allInserted[$key]['id'] ."',dated='". date('Y-m-d H:i:s') ."',customer_id='error',resultTypeString='error',text='". json_encode($responses)  ."'";
					$db->query($sql);
				}catch(Exception $e){
						   //crete log	
				}		
				
			} 
			$allInserted=[]; 
		} 
		if($last=='') $last=$row['drtord'];
		
		$allInserted[]=$row;
		if($row['first_name'] || $row['last_name']) $customerRecords['name']= $row['first_name']." ". $row['last_name'];
		if($row['first_name'] )  $customerRecords['first_name'] = $row['first_name'];
		if($row['last_name'] )  $customerRecords['last_name'] = $row['last_name'];
		if($row['email_address'] )  $customerRecords['email'] = $row['email_address'];
		if($row['phone_mobile'] )  $customerRecords['phone1'] = $row['phone_mobile'];
		if($row['phone_home'] )  $customerRecords['phone2'] = $row['phone_home'];
		if($row['phone_work'] )  $customerRecords['phone3'] = $row['phone_work'];
		if($row['phone_other'] )  $customerRecords['phone4'] = $row['phone_other'] ;	 
		if($row['id'] )  $customerRecords['lead_reference'] = $row['id'];
		$data['customerRecords'][]=$customerRecords;
		$currentCamp=$row['dristi_campagain_id'];
		$currentApi=$row['dristi_api_id'];
		$pushed=false;

		 
		
	}
	
	if(!$pushed){
	 
			$request=$data;
			$data['customerRecords']=[];	
			$pushed=true;
                        echo '=='.count($request);
			$responses=$api->uploadContacts($request,$currentCamp,$currentApi);
			if(isset($responses->beanResponse) && count($responses->beanResponse)>0){		
				foreach($responses->beanResponse as $key=>$res){
					if(isset($res->inserted) && ($res->inserted==1 or $res->inserted=='true') ){
						try{
							$update = "UPDATE leads set dristi_customer_id='".  $res->customerId ."', neoxstatus =1 WHERE id = '".$allInserted[$key]['id']."'";
							$db->query($update);
							$sql="insert into dristi_upload_logs set lead_id='". $allInserted[$key]['id'] ."',dated='". date('Y-m-d H:i:s') ."',customer_id='". $res->customerId ."',resultTypeString='". $res->resultTypeString ."',text='". json_encode($res)  ."'";
							$db->query($sql);	 
						}catch(Exception $e){
						   //crete log	
						}	
					}else{
						 try{	
							$sql="insert into dristi_upload_logs set lead_id='". $allInserted[$key]['id'] ."',dated='". date('Y-m-d H:i:s') ."',customer_id='". $res->customerId ."',resultTypeString='". $res->resultTypeString ."',text='". json_encode($res)  ."'";
								$db->query($sql);
						 }catch(Exception $e){
							 
						 }	
						
					}
				}
				
			}else{
			 	try{	
				$sql="insert into dristi_upload_logs set lead_id='". $allInserted[$key]['id'] ."',dated='". date('Y-m-d H:i:s') ."',customer_id='error',resultTypeString='error',text='". json_encode($responses)  ."'";
							$db->query($sql);
				}catch(Exception $e){
				 
				}			
				
			}
		
	}
	
	
	
	
	
}
 
 
 
if($countLead['ctr']>0){
	$sql="select distinct te_utm_te_actual_campaign_1te_utm_ida as utm,te_utm.name from te_utm_te_actual_campaign_1_c inner join te_utm on te_utm.id=te_utm_te_actual_campaign_1_c.te_utm_te_actual_campaign_1te_utm_ida where te_utm_te_actual_campaign_1_c.deleted=0 and te_utm.deleted=0";
	$result=$db->query($sql);
	while($row =  $db->fetchByAssoc($result)){

	            $leadSql     = "SELECT COUNT(*) as total FROM leads WHERE utm='" . $row['name'] . "' AND deleted=0 and status!='Duplicate'";
				$leadObj     = $db->Query($leadSql);
				$lead        = $db->fetchByAssoc($leadObj);
				$total_leads = $lead['total'];	
		 
				if($total_leads > 0){					
				  $db->query("update  te_actual_campaign t inner join te_utm_te_actual_campaign_1_c r on t.id=r.te_utm_te_actual_campaign_1te_actual_campaign_idb  set cpl=total_cost/$total_leads where r.te_utm_te_actual_campaign_1te_utm_ida='". $row['utm'] ."'");
				}else{
					$db->query("update  te_actual_campaign t inner join te_utm_te_actual_campaign_1_c r on t.id=r.te_utm_te_actual_campaign_1te_actual_campaign_idb  set cpl=0 where r.te_utm_te_actual_campaign_1te_utm_ida='". $row['utm'] ."'");
				}				
		
	}
}	

 
$db->query("update cron_job set lead_id='0' where session_id='cron_job'");
exit();

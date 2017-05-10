<?php


        $reponse=[];
        $reponse['success']=false;
        $reponse['message']=$error;
        $reponse['status']='Inactive';
        echo json_encode($reponse);exit();


	if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
	$error='';
	require('custom/modules/te_student/te_student_override.php');
	require_once('custom/modules/te_Api/te_Api.php');
	try{
		$objapi= new te_Api_override();
		$objapi->createLog(print_r($_REQUEST,true),'ivr CRM',$_REQUEST);
		$dataPOST = $_GET;
	 
		if($dataPOST){			
		 $mobile=''; 	
		 if(isset($dataPOST['data?mobile']) && $dataPOST['data?mobile']){
			 $mobile=$dataPOST['data?mobile'];
		 }else 	if(isset($dataPOST['data']) && $dataPOST['data']){ 
			 $jsonDecode= json_decode(html_entity_decode($dataPOST['data']));
			 $mobile=$jsonDecode->mobile;
		 }	 
			
				if($mobile){
					
						$obj=new te_student_override();
						$srm=$obj->getSRMByMobile($mobile);
						if($srm && count($srm)>0){
							$users=BeanFactory::getBean('Users')->retrieve_by_string_fields(array('id'=>$srm['assigned_user_id']));
						 
							if($users && count($users)>0){
								
								    $isActive="select id from te_api where dristi_session='".md5( $users->user_name) ."'";
									global $db;
									$status='Inactive';
									$active=$db->query($isActive); 
									if($db->getRowCount($active) > 0){
										$status='Active';
									}	
								
									$reponse=[];
									$reponse['success']=true;	
									$reponse['user_name']=$users->user_name;
									$reponse['mobile']=$users->phone_mobile;
									$reponse['phone']=$users->phone_work;
									$reponse['status']=$status;
									
									echo json_encode($reponse);exit();
								
							 }else{
								$error="User not found";
								 
							 }
						}else{
							$error="User not found";
						}
					
					
				}else{
					$error="Invalid json format";
				}
			
			
			
		}else{
			$error="Invalid Request format";
		}	

		 
	}catch(Exception $e){
			$error=$e->getMessage();	
				
	}
	$reponse=[];
	$reponse['success']=false;
	$reponse['message']=$error;
        $reponse['status']='Inactive';
	echo json_encode($reponse);
 

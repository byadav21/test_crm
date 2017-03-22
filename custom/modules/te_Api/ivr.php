<?php

	if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
	$error='';
	require('custom/modules/te_student/te_student_override.php');
	try{
		
		$dataPOST = $_GET;
	 
		if($dataPOST){
		 
			if(isset($dataPOST['data']) && $dataPOST['data']){ 
				 
				$jsonDecode= json_decode(html_entity_decode($dataPOST['data']));
			 
			
				if(isset($jsonDecode->mobile) && ($jsonDecode->mobile)){
					
						$obj=new te_student_override();
						$srm=$obj->getSRMByMobile($jsonDecode->mobile);
						if($srm && count($srm)>0){
							$users=BeanFactory::getBean('Users')->retrieve_by_string_fields(array('user_name'=>$srm['assigned_user_id']));
						 
							if($users && count($users)>0){
									$reponse=[];
									$reponse['success']=true;	
									$reponse['user_name']=$users->user_name;
									$reponse['mobile']=$users->phone_mobile;
									$reponse['phone']=$users->phone_work;
									$reponse['status']=$users->status;
									
									echo json_encode($reponse);exit();
								
							 }else{
								$error="User not found";
								 
							 }
						}
					
					
				}else{
					$error="Invalid json format";
				}
			
			}else{
				$error="Invalid command";
			}
			
		}else{
			$error="Invalid json format";
		}	

		 
	}catch(Exception $e){
			$error=$e->getMessage();	
				
	}
	$reponse=[];
	$reponse['success']=false;
	$reponse['message']=$error;
	echo json_encode($reponse);
 

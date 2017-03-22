<?php

	if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
	$error='';
	
	try{
		
		$dataPOST = $_GET;
	 
		if($dataPOST){
		 
			if(isset($dataPOST['data']) && $dataPOST['data']){ 
				 
				$jsonDecode= json_decode(html_entity_decode($dataPOST['data']));
			 
			
				if(isset($jsonDecode->userID) && ($jsonDecode->userID)){
					
						$users=BeanFactory::getBean('Users')->retrieve_by_string_fields(array('user_name'=>$jsonDecode->userID));
						//print_r($users);die;
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
 

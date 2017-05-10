<?php

	if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
	$error='';
	header('Content-type: application/xml');
	require_once('custom/modules/te_Api/te_Api.php');
	
	try{
		
		$dataPOST = $_REQUEST;
	 
		if($dataPOST['requestXml']){
			 
			$xmlData = simplexml_load_string(html_entity_decode($dataPOST['requestXml']));			 
			if(isset($xmlData->command) && $xmlData->command=='login'){ 
			
				if(isset($xmlData->userId) && isset($xmlData->password)){
					global $sugar_config;
					$url=$sugar_config['site_url'].'/service/v4_1/rest.php';
					
					$login_parameters = array(
							//user authentication
							"user_auth" => array(
								"user_name" => (String)$xmlData->userId,
								"password" => md5((String) $xmlData->password),
								 "version" => "4"
							),

							//application name
							"application_name" => "Ameyo",

							//name value list for 'language' and 'notifyonsave'
							"name_value_list" => array(),
						);
						
					 
						$jsonEncodedData = json_encode($login_parameters);
						$post = array(
							"method" => 'login',
							"input_type" => "JSON",
							"response_type" => "JSON",
							"rest_data" => $jsonEncodedData
							);
						
						$ch = curl_init(); 
						curl_setopt($ch, CURLOPT_URL, $url);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($ch, CURLOPT_TIMEOUT, 100);
						curl_setopt($ch, CURLOPT_POST, true);
						curl_setopt($ch, CURLOPT_POSTFIELDS, $post);					
						$data = curl_exec($ch);
						//print_r($data);
						$sessionArray=json_decode($data);
						//print_r($sessionArray);
						if(isset($sessionArray->id)){
			
							$obj= new te_Api_override();
							$obj->name=$sessionArray->id;							
							$obj->dristi_session=md5((String) $xmlData->userId)	;					
							$obj->description=base64_encode(serialize(array(rand(100,500),base64_encode((String) $xmlData->password))));
							if($obj->save()){


							
								$objapi= new te_Api_override();
								$objapi->createLog(print_r($_REQUEST,true),'login',$_REQUEST);	

								echo '<response><status>success</status><message>Auth Successful</message><crmSessionId>'. $sessionArray->id  .'</crmSessionId></response>'; exit();
							}else{
								$error="Error occured during saving session";
							}
						}else{
							
							$error=$sessionArray->description;
						}
					
						 
				}else{
					$error="Invalid XML format";
				}
			
			}elseif(isset($xmlData->command) && $xmlData->command=='logout'){ 
				
				
				if(isset($xmlData->crmSessionId) && ($xmlData->crmSessionId)){
					global $sugar_config;
					$url=$sugar_config['site_url'].'/service/v4_1/rest.php';
					
					$login_parameters = array(
							
							"session" => (String) $xmlData->crmSessionId,
 
						);
						
					 
						$jsonEncodedData = json_encode($login_parameters);
						$post = array(
							"method" => 'logout',
							"input_type" => "JSON",
							"response_type" => "JSON",
							"rest_data" => $jsonEncodedData
							);
						
						global $db;
						$sesstodel=(String) $xmlData->crmSessionId;
						$db->query("delete from te_api where name = '$sesstodel'");						
						$ch = curl_init(); 
						curl_setopt($ch, CURLOPT_URL, $url);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($ch, CURLOPT_TIMEOUT, 100);
						curl_setopt($ch, CURLOPT_POST, true);
						curl_setopt($ch, CURLOPT_POSTFIELDS, $post);					
						$data = curl_exec($ch);
						
						echo '<response>
							<status>success</status>
							<message></message>				 
							</response>'; exit();
						
					 
					
				}else{
					$error="Invalid XML format";
				}
				
				
			}else{
				$error="Invalid command";
			}
			
		}else{
			$error="Invalid XML format";
		}	

		 
	}catch(Exception $e){
			$error=$e->getMessage();	
				
	}
echo '<response>
				<status>failed</status>
				<message>'.  $error .'</message>
				<crmSessionId></crmSessionId>
				</response>';
							
								$objapi= new te_Api_override();
								$objapi->createLog(print_r($_REQUEST,true),$error,$_REQUEST);	

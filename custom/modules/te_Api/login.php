<?php

	if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
	$error='';
	header('Content-type: application/xml');
	
	try{
		
		$dataPOST = trim(file_get_contents('php://input'));
		if($dataPOST){
			$xmlData = simplexml_load_string($dataPOST);
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
						
						$sessionArray=json_decode($data);
						print_r($sessionArray);
						if(isset($sessionArray->id)){
							echo '<response>
								<status>success</status>
								<message>Auth Successful</message>
								<crmSessionId>'. $sessionArray->id  .'</crmSessionId>
						    </response>'; exit();
							
						}else{
							
							$error=$sessionArray->description;
						}
					
						;
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

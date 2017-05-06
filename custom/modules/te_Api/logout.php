<?php

	if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
	$error='';
	//header('Content-type: application/xml');
	
	try{
		
		$dataPOST = $_REQUEST;
 
		if($dataPOST['requestXml']){
			$xmlData = simplexml_load_string(html_entity_decode($dataPOST['requestXml']));	
		
			if(isset($xmlData->command) && $xmlData->command=='logout'){ 
			
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
				</response>';

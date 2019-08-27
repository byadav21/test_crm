
<?php				

ini_set('display_errors',1);
error_reporting(-1);



require_once('custom/modules/te_Api/te_Api.php');

				unset($_SESSION['AMUYSESSION']);
				$api=new te_Api_override();
				$session=(!isset($_SESSION['AMUYSESSION']) || $_SESSION['AMUYSESSION']=='')? $api->doLogin() : 	$_SESSION['AMUYSESSION'];				 
					 
				$data=[];							
				$data['sessionId']=$session;
				$data['properties']=array('update.customer'=>true,'migrate.customer'=>true);
				$data['customerRecords'][]=array('phone1'=>'9999999'. rand(100,999),'name'=>'Lead'." ".rand(100,500));
				//print_r($data);die;
				$error=false; 
				
				if($session){
					$error=(!$api->uploadContacts($data))?false:true;
				}
				
				if(!$error){
					$session=$api->doLogin();
					$data['sessionId']=$session;
					if(!$api->uploadContacts($data)){
					  echo 'error';
					}
				}


					/*$server = 'http://192.168.2.245:8888/ameyowebaccess/command/?command=force-login&data=';
					$serverContacts = 'http://192.168.2.245:8888/ameyowebaccess/command/?command=uploadContacts&data=';

					$data=[];
					$data['userId']= 'CustomerManager';
					$data['password']= 'CustomerManager';
					$data['terminal']= $_SERVER['REMOTE_ADDR'];				
					
					   $session= file_get_contents($server. json_encode($data)); 
					$jsonEncodedData = json_decode($session);
					
						if(isset($jsonEncodedData->sessionId) && !empty($jsonEncodedData->sessionId)){
							 
							$data=[];
							$data['campaignId']=4;
							$data['status']='NOT_TRIED';
							$data['leadId']=7;
							$data['sessionId']=$jsonEncodedData->sessionId;
							$data['properties']=array('update.customer'=>true,'migrate.customer'=>true);
							$data['customerRecords'][]=array('phone1'=>'9958483076','name'=>'paNKAj','login'=>'CustomerManager');
							
							  $serverContacts. json_encode($data); 
							echo file_get_contents($serverContacts. json_encode($data));
						
						}*/	

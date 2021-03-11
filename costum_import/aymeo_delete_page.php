<?php
// if(!defined('sugarEntry'))

// define('sugarEntry', true);

// require_once ('include/entryPoint.php');
// die('imhere');
error_reporting(E_ALL);
// ini_set('max_execution_time', 3600);
// set_time_limit(3600);

function createLog($action, $filename, $field = '', $dataArray = array())
{
    $file = fopen(str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']) . "upload/$filename", "a");
    fwrite($file, date('Y-m-d H:i:s') . "\n");
    fwrite($file, $action . "\n");
    fwrite($file, $field . "\n");
    fwrite($file, print_r($dataArray, TRUE) . "\n");
    fclose($file);
}



			$server = 'http://111.93.50.156:8888/ameyowebaccess/command/?command=force-login&data=';// live server
            // $server = 'http://111.93.50.157:8888/ameyowebaccess/command/?command=force-login&data='; //Staging server
			
			$data=[];
			$data['userId']= 'pankaj.jha@talentedge.in';//$sugar_config['ameyo_import_login'];
			$data['password']= '123456';
			$data['terminal']= $_SERVER['REMOTE_ADDR'];
			$ch = curl_init(); 
			curl_setopt($ch, CURLOPT_URL, $server. urlencode(json_encode($data)));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);						
			$session= curl_exec($ch); 
			 
			$jsonEncodedData = json_decode($session);
            // createLog('{check installment follow up things}', 'aymeo_delete_check_api_'.date('Y-m-d').'.txt','', $session);
            echo "imhere";
            echo "<pre>";print_r($jsonEncodedData->sessionId);//die('imhere1234568');ok

        // Delete API {"campaignId":"1","sessionId":"abc-133123-xyz","customerIds":[123456,123456,123456]}
        
        $campaignId                        = '16';
        $customerIds                       = '16788768';
        // $api                               = new te_Api_override();
        $data                              = [];
        $sessionId                           = $jsonEncodedData->sessionId;
        // $data['sessionId']                 = $session;
        // echo "Brijesh imhere";
        // echo $session;
        // echo "====================imhere========="; die('the end');
        
            // echo "brijesh";
            $request = [];
            $request['campaignId']	= '49';//'16';//($campaignId)? $campaignId :$sugar_config['ameyo_campaigainID'];
			$request['sessionId'] 	= $sessionId;
			$request['customerIds']	= [88126854,88126853,88126852];//'16788768';//($customerIds)? $customerIds : $sugar_config['ameyo_customerIds'];	
			 $data_url = 'http://111.93.50.156:8888/ameyowebaccess/command?command=removeContactsFromCampaign&data='; // Live server
            //  $data_url = 'http://111.93.50.157:8888/ameyowebaccess/command?command=removeContactsFromCampaign&data=';//Staging server
            $url = $data_url. (json_encode($request));
            echo "<br />";print_r($url);
            //http://111.93.50.156:8888/ameyowebaccess/command?command=removeContactsFromCampaign&data={"campaignId":"49","sessionId":"d426-60478059-ses-pankaj.jha@talentedge.in-0tBiw35D-5274","customerIds":[88126854,88126853,88126852]}Rachit 


            //http://192.168.1.230:8888/ameyowebaccess/command/?command=removeContactsFromCampaign&data={"campaignId":"1","sessionId":"abc-133123-xyz","customerIds":[123456,123456,123456]}
			$ch = curl_init(); 
            curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);	
			curl_setopt($ch, CURLOPT_POST, true);
			// curl_setopt($ch, CURLOPT_POSTFIELDS, "data=".urlencode(json_encode($request)));					
			$response = curl_exec($ch);
            // createLog('{check installment follow up things}', 'aymeo_delete_api_'.date('Y-m-d').'.txt','', $response);
			// $this->createLog(print_r($data,true),$response,$data);	
		   // $response= file_get_contents($server. urlencode(json_encode($request)));			
           echo "Rachit <pre>"; print_r($request);	 
           print_r($response);	 
           $responses=json_decode($response);		
           echo "bky <pre>"; //print_r($request);	 
           print_r($response);		
			// return $responses;
        

        echo "123:- <pre>";print_r($responses);
        exit('imhere the end');
   
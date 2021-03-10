<?php
error_reporting(E_ALL);
// ini_set('max_execution_time', 3600);
// set_time_limit(3600);
// require_once('../custom/modules/te_Api/te_Api.php');
// $api = new te_Api_override();

class aymeo_deleteAPI {

    private $url;
	public $importError;
	function __construct(){
		global $sugar_config;
		$this->url=$sugar_config['ameyo_URL'] . 'command/?command=';
		parent::__construct();
	}

    public function createLog($action, $filename, $field = '', $dataArray = array())
    {
        $file = fopen(str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']) . "upload/$filename", "a");
        fwrite($file, date('Y-m-d H:i:s') . "\n");
        fwrite($file, $action . "\n");
        fwrite($file, $field . "\n");
        fwrite($file, print_r($dataArray, TRUE) . "\n");
        fclose($file);
    }
    
    public function doLogin($user='',$pass=''){
		try{
			global $sugar_config;
			$server = 'http://180.151.225.244:8888/ameyowebaccess/force-login&data=';
			
			$data=[];
			$data['userId']= ($user)? $user : $sugar_config['ameyo_import_login'];
			$data['password']= ($pass)? $pass : $sugar_config['ameyo_import_pass'];
			$data['terminal']= $_SERVER['REMOTE_ADDR'];
			$ch = curl_init(); 
			curl_setopt($ch, CURLOPT_URL, $server. urlencode(json_encode($data)));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);						
			$session= curl_exec($ch); 
			 
			//$session= file_get_contents(  $server. urlencode(json_encode($data)));
			$this->createLog($server. urlencode(json_encode($data)),$session); 	
			$jsonEncodedData = json_decode($session);
			 
			if(isset($jsonEncodedData->sessionId) && !empty($jsonEncodedData->sessionId)){
				
						
				return $jsonEncodedData->sessionId;
				
			}else{
			  return false;	
			}	
	   }catch(Exception $e){
		  return false;   
	   }
		
	}

    // Delete API {"campaignId":"1","sessionId":"abc-133123-xyz","customerIds":[123456,123456,123456]}
    public function main(){
        
        $campaignId                        = 18;
        $customerIds                       = 42;
        // $api                               = new te_Api_override();
        $data                              = [];
        $session                           = doLogin('kiran.mathew@talentedge.in', 'kiran@321');
        $data['sessionId']                 = $session;
        echo "Brijesh imhere";
        echo $session;
        echo "====================imhere========="; die('the end');
        // removeContactsFromCampaign($campaignId='',$sessionId,$customerIds='')
        $responses = $api->removeContactsFromCampaign($campaignId, $data['sessionId'], $customerIds);


        echo "<pre>";print_r($responses);
        // $db->query("update cron_job set lead_id='0' where session_id='cron_job'");
        // echo json_encode(array('status'=>'success','current_queue'=>$db->getRowCount($result))); 
        exit();
    }
}

$mainObj = new aymeo_deleteAPI();
$mainObj->main();
<?php
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 ********************************************************************************/

/**
 * THIS CLASS IS FOR DEVELOPERS TO MAKE CUSTOMIZATIONS IN
 */
require_once('modules/te_Api/te_Api.php');
class te_Api_override extends te_Api {
	
	
	private $url;
	public $importError;
	function __construct(){
		global $sugar_config;
		$this->url=$sugar_config['ameyo_URL'] . 'command/?command=';
		parent::__construct();
	}
	 
	 function getUserCredential($sessioID){
	      try{	 
	      	 global $db;
	      	 // "select description from te_api where name='". $sessioID ."'";// die;
	      	 $itemDetal=$db->query("select description from te_api where name='". $sessioID ."'");
	      	 $rs=$db->fetchByAssoc($itemDetal);
	      	// print_r($rs);
	      	 if(!$rs) return false;
	      	 $reslt= unserialize(base64_decode($rs['description']));
	      	 return base64_decode($reslt[1]);
	      }catch(Exception $e){
			  return false;
		  }	 
	 }
	
	function doLogin($user='',$pass=''){
		try{
			global $sugar_config;
			$server = $this->url.'force-login&data=';
			
			$data=[];
			$data['userId']= ($user)? $user : $sugar_config['ameyo_import_login'];
			$data['password']= ($pass)? $pass : $sugar_config['ameyo_import_pass'];
			$data['terminal']= $_SERVER['REMOTE_ADDR'];
			$ch = curl_init(); 
			curl_setopt($ch, CURLOPT_URL, $server. urlencode(json_encode($data)));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT, 100);						
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
	
	function call($session,$request){		
		try{ 
			$server= $this->url . "manual-dial&data=";
			$ch = curl_init(); 
			curl_setopt($ch, CURLOPT_URL, $server. urlencode(json_encode($request)));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT, 100);						
			$data= curl_exec($ch);				
			//$data= file_get_contents(  $server. urlencode(json_encode($request)));
			$dataErr=json_decode($data);
			$this->createLog($server. urlencode(json_encode($request)),'manual',$request,$data); 		
			return ($dataErr->status=='error')?false:true;
		}catch(Exception $e){
			
		}
	}	
	
	function ping($session){		
		try{
			$request=[]; 
			$request['sessionId']=$session; 
			$request['sessionPushSeqNo']=0; 
			$request['session​ push​ seq​ no']=0; 
			$server= $this->url . "ping-session&data=";
			$data= file_get_contents(  $server. urlencode(json_encode($request)));
			$dataErr=json_decode($data);		
			return ($dataErr->status=='error')?false:true;
		}catch(Exception $e){
			
		}		
	}	
	
	function sendDisposition($callback='',$request,$date='',$lid){
		
		try{
				global $sugar_config,$db;				
				$url= $sugar_config['ameyo_BASEURL']. 'dacx/dispose?';
				$data=[];
				$session=$_SESSION['amyoSID'];
				$data['campaignId']=urlencode($_SESSION['amyoCID']);
				$data['sessionId']=urlencode($session);
				if($request['crtObjectId']) $data['crtObjectId']=urlencode($request['crtObjectId']);
				if($request['userCrtObjectId']) $data['userCrtObjectId']=urlencode($request['userCrtObjectId']);
				if($request['customerId']) $data['customerId']=urlencode($request['customerId']);
					   // if($request['sessionId']) $data['sessionId']=urlencode($request['sessionId']);
				
				if($request['phone']) $data['phone']=urlencode($request['phone']);
				if($request['userId']) $data['userId']=urlencode($request['userId']);
				$data['dispositionCode']=urlencode($callback);
				

				if($callback=='Call Back' || $callback=='Follow Up' || $callback=='Prospect'){
				  $data['selfCallback']='true';

					   //echo                  $date .'==';
				//echo date('Y-m-d H:i:s');die;
				  $callDate= date('d-m-Y H:i:s',strtotime($date));
				 // $diff= $callDate- $current;
				 
				   $start_date = new DateTime(date('Y-m-d H:i:s'));
				   $since_start = $start_date->diff(new DateTime($callDate));
		 
				 
					$year= $since_start->y;
					$month= $since_start->m;
					$day= $since_start->d;
					$hour= $since_start->h;
					$min= $since_start->i;
					$sec= $since_start->s;
				   
				  
				 $data['dispositionAttr']=urlencode('after-'. str_pad($day, 2, "0", STR_PAD_LEFT). '-'. str_pad($month, 2, "0", STR_PAD_LEFT).  '-'. str_pad($year, 4, "0", STR_PAD_LEFT).  ' '. str_pad($hour, 2, "0", STR_PAD_LEFT).  ':'. str_pad($min, 2, "0", STR_PAD_LEFT). ':'.  str_pad($sec, 2, "0", STR_PAD_LEFT));
				   
									//after-03-00-0000 02:01:00	
				}
				$qrystr='';
				foreach($data as $key=>$val){
					$qrystr .=$key .'='. $val . '&'; 
				}
				$qrystr=substr($qrystr,0,strlen($qrystr)-1);		
					

				$ch = curl_init(); 
				curl_setopt($ch, CURLOPT_URL, $url.$qrystr);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_TIMEOUT, 100);						
				$response = curl_exec($ch);
				//$response= file_get_contents($url. ($qrystr)); 
                                unset($_SESSION['temp_for_newUser']);
                                $db->query("update leads set dristi_request=null where id='". $lid ."'"); 
				$this->createLog($url. ($qrystr),'dispose',$data,$response);     
				if($response!=='Dispose Successfully'){
				  echo '<script>swal("You have to dispose manaually!")</script>';	
				}	
		
		}catch(Exception $e){
			
			 echo '<script>swal("You have to dispose manaually!")</script>';	
		}

	}
	
	function uploadContacts($data,$campID='',$api=''){
		try{	
			global $sugar_config;
			$this->importError='';
			//$server = $this->url.'uploadContacts&data=';
			$request=$data;
			$request['campaignId']=($campID)? $campID :$sugar_config['ameyo_campaigainID'];
			$request['status']='NOT_TRIED';
			$request['leadId']=($api)? $api : $sugar_config['ameyo_leadID'];	
			 
			$ch = curl_init(); 
			curl_setopt($ch, CURLOPT_URL, $sugar_config['ameyo_URL'] . 'command?command=uploadContacts');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT, 100);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, "data=".urlencode(json_encode($request)));					
			$response = curl_exec($ch);
			$this->createLog(print_r($data,true),$response,$data);	
		   // $response= file_get_contents($server. urlencode(json_encode($request)));			
			 $responses=json_decode($response);				
			return $responses;
			
		}catch(Exception $e){
			
		}	
	}
	
	/*function createLog($req,$res,$request=array()){
		 
		$file = fopen(str_replace('index.php','',$_SERVER['SCRIPT_FILENAME']) . "upload/apilog/apilog.txt","a");
		// var_dump($file);die;
		fwrite($file,date('Y-m-d H:i:s') ."\n");
		fwrite($file,$req ."\n");
		fwrite($file,$res ."\n");
		fclose($file);
		
	}*/

	function createLog($req,$res,$data=array(),$dispose=''){
		$querty=array();
		global $current_user;
		 
			  if($res=='dispose'){			
				$querty['userId'] = $data['userId'];
				$querty['customer_id'] = $data['customerId'];
				$querty['lead_id'] = $data['lead_reference'];

				$querty['dispositionCode'] =$data['dispositionCode']; 
				$querty['customerCRTId']  = $data['userCrtObjectId'];
				$querty['campaignId']  = $data['campaignId'];
				$querty['phone']  = $data['phone'];
				$querty['lastStatus']  ='selfCallback';
				$querty['callType'] ='dispose'; 
				$querty['entryPoint'] ='dispose system'; 
				$querty['response'] = json_encode($data);
			  }elseif($res=='manual'){	
				$querty['userId'] = $current_user->id;
				$querty['customer_id'] = 'manual';
				$querty['lead_id'] = $data['lead_refrence'];
				$querty['dispositionCode'] ='Manual'; 
				$querty['customerCRTId']  = 'Manual';
				$querty['campaignId']  = $data['campaignId'];
				$querty['phone']  = $data['phone'];
				$querty['lastStatus']  ='Manual';
				$querty['callType'] ='manual call'; 
				$querty['entryPoint'] ='manually calling'; 
				$querty['response'] = ($dispose);				  	
			  }elseif($res=='disposeamyo'){		
				$querty['dispositionName'] = $data['dispositionName'];
				$querty['userId'] = $data['userId'];
				$querty['lead_id'] = $data['lead_reference'];
				$querty['customer_id'] = $data['customerId'];
				$querty['dispositionCode'] =$data['dispositionCode']; 
				$querty['customerCRTId']  = $data['customerCRTId'];
				$querty['campaignId']  = $data['campaignId'];
				$querty['phone']  = $data['phone'];
				$querty['lastStatus']  =  $data['lastStatus'];
				$querty['callType'] = $data['callType'];
				$querty['entryPoint'] ='dispose amyo'; 
				$querty['response'] = json_encode($data);			  
				$querty['systemDisposition'] ='dispose';		 
				  
			 }elseif($res=='crm popup url'){		
				$querty['dispositionName'] ='Call start';
				$customers=json_decode(html_entity_decode($data['customerInfo']));
				$querty['lead_id'] = $customers->lead_reference;
				//$querty['lead_id'] = $data['lead_reference'];	
				$querty['userId'] = $data['userId'];
				$querty['customer_id'] = $data['customerId'];
				$querty['dispositionCode'] ='Call start';
				$querty['customerCRTId']  = $data['crtObjectId'];
				$querty['campaignId']  = $data['campaignId'];
				$querty['phone']  = $data['phone'];				 
				$querty['callType'] = $data['callType'];
				$querty['entryPoint'] ='call start'; 
				$querty['response'] = json_encode($data);		  
				$querty['systemDisposition'] ='call satrt'; 
				  
			 }elseif($res=='call Initiate'){		
				$querty['dispositionName'] ='call Initiate';
				$customers=json_decode(html_entity_decode($data['customerInfo']));
				$querty['lead_id'] = $customers->lead_reference;
				//$querty['lead_id'] = $data['lead_reference'];	
				$querty['userId'] = $data['userId'];
				$querty['customer_id'] = $data['customerId'];
				$querty['dispositionCode'] ='call Initiate';
				$querty['customerCRTId']  = $data['crtObjectId'];
				$querty['campaignId']  = $data['campaignId'];
				$querty['phone']  = $data['phone'];				 
				$querty['callType'] = $data['callType'];
				$querty['entryPoint'] ='call Initiate'; 
				$querty['response'] = json_encode($data);		  
				$querty['systemDisposition'] ='call Initiate'; 
			}	
            if($res=='dispose' || $res=='disposeamyo' ||$res=='crm popup url' || $res=='manual' || $res=='call Initiate'){
				 $querty['dated'] = date('Y-m-d H:i:s');				
				 foreach($querty as $key=>$val){
				   $sql .= " $key='". $val . "',";	
					
				 }
				 $sql="insert into dristi_log set " .substr($sql,0,strlen($sql)-1);//die;
				
				 global $db;
				 $db->query($sql);
           }else{			
		
		
                 	$file = fopen(str_replace('index.php','',$_SERVER['SCRIPT_FILENAME']) . "upload/apilog/apilog.txt","a");
			 
					fwrite($file,date('Y-m-d H:i:s') ."\n");
					fwrite($file,$req ."\n");   fwrite($file,$res ."\n");

		 
					fclose($file);
		      }
		
	}
	
}
?>

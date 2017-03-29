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
	
	function doLogin(){
		global $sugar_config;
		$server = $this->url.'force-login&data=';
		
		$data=[];
		$data['userId']= $sugar_config['ameyo_import_login'];
		$data['password']= $sugar_config['ameyo_import_pass'];
		$data['terminal']= $_SERVER['REMOTE_ADDR'];
		 
		
		$session= file_get_contents(  $server. urlencode(json_encode($data))); 
		$jsonEncodedData = json_decode($session);
		 
		if(isset($jsonEncodedData->sessionId) && !empty($jsonEncodedData->sessionId)){
			
			$_SESSION['AMUYSESSION']=$jsonEncodedData->sessionId;			
			return $jsonEncodedData->sessionId;
			
		}else{
		  return false;	
		}	
		
	}
	
	function uploadContacts($data){
			global $sugar_config;
			$this->importError='';
			$server = $this->url.'uploadContacts&data=';
			$request=$data;
			$request['campaignId']=$sugar_config['ameyo_campaigainID'];
			$request['status']='NOT_TRIED';
			$request['leadId']=$sugar_config['ameyo_leadID'];	
			//echo $server. urlencode(json_encode($request));die;		 
		    $response= @file_get_contents($server. urlencode(json_encode($request)));			
			$responses=json_decode($response);			
			if(isset($responses->beanResponse[0]->inserted) && $responses->beanResponse[0]->inserted==true){
			  return true;
			}else{
				$this->importError=$response;
				return false;
			}
	}
	
}
?>

<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Master Subscription
 * Agreement ("License") which can be viewed at
 * http://www.sugarcrm.com/crm/master-subscription-agreement
 * By installing or using this file, You have unconditionally agreed to the
 * terms and conditions of the License, and You may not use this file except in
 * compliance with the License.  Under the terms of the license, You shall not,
 * among other things: 1) sublicense, resell, rent, lease, redistribute, assign
 * or otherwise transfer Your rights to the Software, and 2) use the Software
 * for timesharing or service bureau purposes such as hosting the Software for
 * commercial gain and/or for the benefit of a third party.  Use of the Software
 * may be subject to applicable fees and any use of the Software without first
 * paying applicable fees is strictly prohibited.  You do not have the right to
 * remove SugarCRM copyrights from the source code or user interface.
 *
 * All copies of the Covered Code must include on each user interface screen:
 *  (i) the "Powered by SugarCRM" logo and
 *  (ii) the SugarCRM copyright notice
 * in the same form as they appear in the distribution.  See full license for
 * requirements.
 *
 * Your Warranty, Limitations of liability and Indemnity are expressly stated
 * in the License.  Please refer to the License for the specific language
 * governing these rights and limitations under the License.  Portions created
 * by SugarCRM are Copyright (C) 2004-2011 SugarCRM, Inc.; All Rights Reserved.
 ********************************************************************************/
require_once 'modules/Configurator/Configurator.php';
 class ServiceTax{
	var $id;
	var $service_tax;
	var $record;

	function handleAdd(){
		
		 if(isset($_REQUEST['service_tax'])){
			$configurator = new Configurator();
			#it will load existing configuration in config variable of object
			$configurator->loadConfig(); 	
			#declare new or change old value from sugar_config
			$configurator->config['tax']['service'] = $_REQUEST['service_tax']; 
			$configurator->saveConfig(); #save changes
			SugarApplication::redirect("index.php?module=Configurator&action=taxSettings");
			exit;
		}
	}
/*
*Function to get list of currency Conversion
*
*/

	function getList(){
		global $app_list_strings;
		$SQL= "SELECT * FROM service_tax where deleted=0;";
		$TaxResult=$GLOBALS["db"]->query($SQL);
		$i=0;
		$count=$GLOBALS['db']->getRowCount($TaxResult);
		while($TaxRow = $GLOBALS['db']->fetchByAssoc($TaxResult)){
			$Tax['id'][$i] 					= $TaxRow['id'];
			$Tax['service_tax'][$i] 			= $TaxRow['service_tax'];
			$Tax['sales_tax'][$i] 			= $TaxRow['sales_tax'];
			$Tax['education_cess'][$i] 			= $TaxRow['education_cess'];
			$Tax['higher_education_cess'][$i] 		= $TaxRow['higher_education_cess'];
			//$Tax['status'][$i] 				= $TaxRow['status'];
			if($vat='0.0000')
				$TaxRow['vat'] 				='';
			$Tax['vat'][$i] 				= $TaxRow['vat'];
                        $Tax['start_date'][$i] 				= $GLOBALS['timedate']->to_display_date($TaxRow['start_date'],false);
			$Tax['end_date'][$i] 				= $GLOBALS['timedate']->to_display_date($TaxRow['end_date'],false);
                        $Tax['territory'][$i] 				= $app_list_strings['territory_custom_list'][$TaxRow['territory']];
                           $i++;
		}
		$Tax["count"]=$count;
		return 	$Tax;

	}


/*
*Function for updation of records
*
*/
		
	function handleUpdate(){
		global $current_user;
			if($current_user->is_admin){
				if(isset($_REQUEST['record']) && !empty($_REQUEST['record']) && isset($_REQUEST['service_tax']) && !empty($_REQUEST['service_tax']) && isset($_REQUEST['end_date']) && !empty($_REQUEST['end_date']) && isset($_REQUEST['start_date']) && !empty($_REQUEST['start_date']) && isset($_REQUEST['territory']) && !empty($_REQUEST['territory'])  && isset($_REQUEST['education_cess']) && !empty($_REQUEST['education_cess'])  && isset($_REQUEST['higher_education_cess']) && !empty($_REQUEST['higher_education_cess'])){				
						
			$id 			= $_REQUEST['record'];
			$service_tax		= $_REQUEST['service_tax'];
			$education_cess		= $_REQUEST['education_cess'];
			$higher_education_cess	= $_REQUEST['higher_education_cess'];
			$vat 			= $_REQUEST['vat'];
			$sales_tax 			= $_REQUEST['sales_tax'];
			$start_date  		= $GLOBALS['timedate']->to_db_date($_REQUEST['start_date'],false);
			$end_date  		= $GLOBALS['timedate']->to_db_date($_REQUEST['end_date'],false);
			$territory		=$_REQUEST['territory'];
			//$status  		= $_REQUEST["status"];

				
						
			$SQL= "SELECT id FROM  service_tax where ((start_date <='".$start_date."' and end_date >='".$start_date."')  OR (start_date <='".$end_date."' and end_date >='".$end_date."')  OR (start_date >='".$start_date."' and end_date <='".$end_date."')) and territory='".$territory."' and deleted=0 and id <> '".$_REQUEST['record']."'";
			//echo $SQL;die;
			$TaxResult=$GLOBALS["db"]->query($SQL);
			if($GLOBALS['db']->getRowCount($TaxResult)>0){
				SugarApplication::redirect("index.php?module=Configurator&action=taxSettings&alert=2&territory=".$territory);
				exit;
			}
						
			   	
			$SQL="UPDATE service_tax set service_tax='".$service_tax."',education_cess='".$education_cess."',higher_education_cess='".$higher_education_cess."',vat='".$vat."',start_date='".$start_date."',end_date='".$end_date."',territory='".$territory."',sales_tax='".$sales_tax."'  where id='".$id."' and deleted=0 ";
			//echo $SQL;die;
			$TaxResult=$GLOBALS["db"]->query($SQL);
			SugarApplication::redirect("index.php?module=Configurator&action=taxSettings");
			exit;
			
		}
		}
	}


/*
*Function to get record for edit
*
*/

	function GetrecordForID($ID){
		global $current_user;
			if($current_user->is_admin){
					$SQL="SELECT * FROM service_tax where id='".$ID."' and deleted=0 ";
					//echo $SQL;
					$Service=$GLOBALS["db"]->query($SQL);
					$ServiceTax=array();
					if($GLOBALS['db']->getRowCount($Service) > 0){
					   	$ServiceTaxRow 				= $GLOBALS['db']->fetchByAssoc($Service);
						$ServiceTax["id"] 			= $ServiceTaxRow['id'];
						$ServiceTax["service_tax"] 		= $ServiceTaxRow['service_tax'];
						$ServiceTax["sales_tax"] 		= $ServiceTaxRow['sales_tax'];
						$ServiceTax["vat"] 			= $ServiceTaxRow['vat'];
						$ServiceTax["education_cess"] 		= $ServiceTaxRow['education_cess'];
						$ServiceTax["higher_education_cess"] 	= $ServiceTaxRow['higher_education_cess'];
						$ServiceTax["vat"] 			= $ServiceTaxRow['vat'];
						$ServiceTax["start_date"] 		= $GLOBALS['timedate']->to_display_date($ServiceTaxRow['start_date'],false);
						//$ServiceTax["status"]			= $ServiceTaxRow['status'];
						$ServiceTax["end_date"] 		= $GLOBALS['timedate']->to_display_date($ServiceTaxRow['end_date'],false);
						$ServiceTax["territory"] 		= $ServiceTaxRow['territory'];
						
						
					}
					return 	$ServiceTax;
				}
	}

/*
*Function to delete the particular record
*
*/
	function markdeleted($recordID){
		$SQL="delete from  service_tax where id='".$recordID."'";
		$CurrencyResult=$GLOBALS["db"]->query($SQL);
	}
	
	
	
	
	
	
		
		
}



?>

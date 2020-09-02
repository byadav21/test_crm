<?php
if(!defined('sugarEntry'))

  define('sugarEntry', true);

require_once ('include/entryPoint.php');

global $db;

error_reporting(E_ALL);

	if(!empty($_REQUEST['startdate']) && !empty($_REQUEST['enddate'])){
		$startDate 	= date("Y-m-d", strtotime($_REQUEST['startdate']));
		$endDate 	= date("Y-m-d", strtotime($_REQUEST['enddate']));	
		//echo $startDate."===".$endDate;
		
		$user = 'talentedgeadmin';
		$password = 'Inkoniq@2016';
		//$url = $sugar_config['website_URL']."/crmordersync.php?startdate='".$startDate."'&enddate='".$endDate."'";
		$url = "http://site.talentedge.in/crmordersync.php?startdate='".$startDate."'&enddate='".$endDate."'";
		
		//echo $url;
		$headers = array(
				'Authorization: Basic '. base64_encode("$user:$password")
		);
		$post = [
				'startdate' => $startDate,
				'enddate' 	=> $endDate
				
		];
		 
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);

		//curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$result = curl_exec($ch);
		$result = stripslashes(html_entity_decode($result));
		$res = json_decode(trim($result),TRUE);
		//echo "<pre>"; print_r($res);
		$i=0;
		
		foreach ($res as $value){
			
			if( !empty($value['taxtype']) && !empty($value['state']) ){
				
				$query = "UPDATE te_payment_details SET tax_type='".$value['taxtype']."', state='".$value['state']."' where invoice_order_number='".$value['payment_id']."' ";
				$qry1= $db->query($query);
				echo "Numbers of Rows:- ".$i;
				echo "</br>";
			}
		$i++;
		}
		
			
	}
?>

<?php
require_once('custom/modules/te_Api/te_Api.php');
//Client to test Neox Dial Call API with JSON format 
if(!empty($_REQUEST['lead']) && !empty($_REQUEST['number'])){
	
global $current_user,$db;

$lead=	"select * from leads where id='". $_REQUEST['lead'] ."'";
$res=$db->query($lead);
if($db->getRowCount($res)){
	$resdata=$db->fetchByAssoc($res);
	if($current_user->id==$resdata['assigned_user_id']){
		 $drobj= new te_Api_override();
		 $assinuserDristi="select neox_user,neox_password from users where id='". $current_user->id . "'";
		 $users=$db->query($assinuserDristi);
		 if($db->getRowCount($users)>0){
			 print_r($_SESSION);
			  $session=$_SESSION['amyoSID'];
				   if($session){
					     $arrReq=[];
					     $arrReq['campaignId']=$_SESSION['amyoCID'];
					     $arrReq['sessionId']=$session;
					     $arrReq['phone']=$_REQUEST['number'];
					     $customerRecords=[];
					    if($resdata['first_name'] || $resdata['last_name']) $customerRecords['name']= $resdata['first_name']." ". $resdata['last_name'];
						if($resdata['first_name'] )  $customerRecords['first_name'] = $resdata['first_name'];
						if($resdata['last_name'] )  $customerRecords['last_name'] = $resdata['last_name'];
						//if($resdata['email_address'] )  $customerRecords['email'] = $resdata['email_address'];
						if($resdata['phone_mobile'] )  $customerRecords['phone1'] = $resdata['phone_mobile'];
						if($resdata['phone_home'] )  $customerRecords['phone2'] = $resdata['phone_home'];
						if($resdata['phone_work'] )  $customerRecords['phone3'] = $resdata['phone_work'];
						if($resdata['phone_other'] )  $customerRecords['phone4'] = $resdata['phone_other'] ;	 
						if($resdata['id'] )  $customerRecords['lead_refrence'] = $resdata['id'];
					     
					     $arrReq['customerRecords'][]=$customerRecords;
					     
						 $drobj->call($session,$arrReq);
				   }
		 } 
		
	}else{
		echo "Call Can't be connected";
	}
}


/*	
$number = $_REQUEST['number'];
//~ $number = "9015306759";

	
		$server_ip = $GLOBALS['sugar_config']['neox']['server_ip'];
		$event          = "neox_agent_dial";
		$user           = $GLOBALS['current_user']->neox_user;
		$password       = $GLOBALS['current_user']->neox_password;
		$campaign       = $GLOBALS['sugar_config']['neox']['campaign'];
		$neoxKey   		= $GLOBALS['sugar_config']['neox']['secret_key'];



$URL = "http://$server_ip:9090/Neox_DialCenter_API/agent_dial_call.php?secret_key=".$neoxKey;

$QUERY_PARAM = "data={\"event\":\"$event\",\"user\":\"$user\",\"number\":\"$number\"}";

$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,"$URL");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "$QUERY_PARAM");
$buffer = curl_exec($ch);
$r = explode("|",$buffer);
 
echo json_encode($r);*/
}
else{
		echo "Call Can't be connected";
}
?>

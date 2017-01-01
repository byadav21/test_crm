<?php

//Client to test Neox Dial Call API with JSON format 
if(!empty($_REQUEST['number'])){
	
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
//~ print_r($r);
//~ echo $r[0];
echo json_encode($r);
}
else{
		echo "Success";
}
?>

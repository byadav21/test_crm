<?php

//Client to test Neox Agent Login API with WEBHOOK format 
//~ $server_ip = "10.106.1.213";
//~ 
//~ $event          = "";
//~ $user           = "33344403";
//~ $number		= "33344405";




//~ $number = "9015306759";
if(!empty($_REQUEST['number'])){
	
		$server_ip 		= $GLOBALS['sugar_config']['neox']['server_ip'];
		$event          = "neox_agent_hangup";
		$user           = $GLOBALS['current_user']->neox_user;
		$number 		= $_REQUEST['number'];
		$dispo			= "NI";
		$campaign       = $GLOBALS['sugar_config']['neox']['campaign'];
		$neoxKey   		= $GLOBALS['sugar_config']['neox']['secret_key'];



		$URL = "http://$server_ip:9090/Neox_DialCenter_API/agent_hangup.php?secret_key=".$neoxKey;

		$QUERY_PARAM = "data={\"event\":\"$event\",\"user\":\"$user\",\"number\":\"$number\",\"dispo\":\"$dispo\"}";

		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,"$URL");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "$QUERY_PARAM");
		$buffer = curl_exec($ch);
		$r = explode("|",$buffer);
		//~ print_r($r);
		echo $r[0];
		//~ echo json_encode($r);

		//~ echo "Result = $buffer\n";
}
else{
		echo "not valid";
}
?>

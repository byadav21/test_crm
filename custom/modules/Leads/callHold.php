<?php
if(!empty($_REQUEST['number'])){
	
		$server_ip 		= $GLOBALS['sugar_config']['neox']['server_ip'];
		$event          = "neox_agent_hold";
		$user           = $GLOBALS['current_user']->neox_user;
		$number 		= $_REQUEST['number'];
		$dispo			= "NI";
		$campaign       = $GLOBALS['sugar_config']['neox']['campaign'];
		$neoxKey   		= $GLOBALS['sugar_config']['neox']['secret_key'];
		if($_REQUEST['method']=='hold'){
			$value_park    = "Park"; //Change to "UnPark" for unhold the call
		}
		else{
			$value_park    = "UnPark"; //Change to "UnPark" for unhold the call
		}

		$URL = "http://$server_ip:9090/Neox_DialCenter_API/agent_hold.php?secret_key=".$neoxKey;

		$QUERY_PARAM = "data={\"event\":\"$event\",\"user\":\"$user\",\"number\":\"$number\",\"value_park\":\"$value_park\"}";

		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,"$URL");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "$QUERY_PARAM");
		$buffer = curl_exec($ch);

		//~ echo "Result = $buffer\n";
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

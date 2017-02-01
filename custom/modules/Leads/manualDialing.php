<?php
	   $server_ip = $GLOBALS['sugar_config']['neox']['server_ip'];
		$event          = "neox_agent_logout";
		$user           = $GLOBALS['current_user']->neox_user;
		//~ $user           = $GLOBALS['sugar_config']['neox']['user_id_predictive'];
		$password       = $GLOBALS['current_user']->neox_password;
		//~ $password       = $GLOBALS['sugar_config']['neox']['password_predictive'];
		$campaign       = $GLOBALS['sugar_config']['neox']['campaign_id_predictive'];
		$phone          = '2001';
		//~ $phone          = $GLOBALS['sugar_config']['neox']['number_predictive'];
		$neoxKey   		= $GLOBALS['sugar_config']['neox']['secret_key'];

		$URL = "http://$server_ip:9090/Neox_DialCenter_API/agent_login.php?secret_key=".$neoxKey;
//~ echo $URL;

	// First Logout From the Predictive	

		$QUERY_PARAM = "data={\"event\":\"$event\",\"user\":\"$user\"}";

		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,"$URL");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "$QUERY_PARAM");
		$buffer = curl_exec($ch);


// Login into the Manual ID
		$event          = "neox_agent_login";
		$QUERY_PARAM = "data={\"event\":\"$event\",\"user\":\"$user\",\"password\":\"$password\",\"campaign\":\"$campaign\",\"phone\":\"$phone\"}";

		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,"$URL");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "$QUERY_PARAM");
		$buffer = curl_exec($ch);

		//~ echo "Result = $buffer\n";

		$buffer = curl_exec($ch);
		$r = explode("|",$buffer);
		//~ print_r($r);
		if($r[0]=='200'){
			$_SESSION['dial_type'] = 'Manual';
		}
		
		echo $r[0];
		//~ echo json_encode($r);
		
		
	
?>

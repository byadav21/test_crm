<?php

//Client to test Neox DC Agent Pause/Resume API for JSON format

		$server_ip 		= $GLOBALS['sugar_config']['neox']['server_ip'];
		$event          = "neox_agent_pause";
		$user           = $GLOBALS['current_user']->neox_user;
		$password       = $GLOBALS['current_user']->neox_password;
		$value_pr       = "Resume"; 
		
		$neoxKey   		= $GLOBALS['sugar_config']['neox']['secret_key'];

		$URL = "http://$server_ip:9090/Neox_DialCenter_API/agent_pause_resume.php?secret_key=".$neoxKey;

		$QUERY_PARAM = "data={\"event\":\"$event\",\"user\":\"$user\",\"value_pr\":\"$value_pr\"}";


		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,"$URL");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "$QUERY_PARAM");
		$buffer = curl_exec($ch);
		$r = explode("|",$buffer);
		//~ print_r($r);
		if($r[0]=='200'){
			$_SESSION['dial_status'] = 'Resume';
		}
		
		echo $r[0];

?>

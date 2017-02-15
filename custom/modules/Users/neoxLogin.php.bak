
<?php
if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');

class neoxLogin {
    function neoxLoginFunc(&$bean, $event, $arguments){
	   $server_ip = $GLOBALS['sugar_config']['neox']['server_ip'];

		$event          = "neox_agent_login";

		$user           = $GLOBALS['current_user']->neox_user;
		//~ $user           = $GLOBALS['sugar_config']['neox']['user_id_predictive'];
		$password       = $GLOBALS['current_user']->neox_password;
		//~ $password       = $GLOBALS['sugar_config']['neox']['password_predictive'];
		$campaign       = $GLOBALS['sugar_config']['neox']['campaign_id_predictive'];
		$phone          = $GLOBALS['sugar_config']['neox']['number_predictive'];
		$neoxKey   		= $GLOBALS['sugar_config']['neox']['secret_key'];
		/*$user           = "33344406";
		$password       = "33344406";
		$campaign       = "Inbound";
		$phone          = "33344406";*/



		$URL = "http://$server_ip:9090/Neox_DialCenter_API/agent_login.php?secret_key=".$neoxKey;
echo $URL;
		$QUERY_PARAM = "data={\"event\":\"$event\",\"user\":\"$user\",\"password\":\"$password\",\"campaign\":\"$campaign\",\"phone\":\"$phone\"}";
echo $QUERY_PARAM;
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,"$URL");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "$QUERY_PARAM");
		$buffer = curl_exec($ch);
		$_SESSION['dial_type'] = 'Predictive';
		
		
// Pause the Calls		
		$neoxKey   		= $GLOBALS['sugar_config']['neox']['secret_key_pause_resume'];
		$event          = "neox_agent_pause";
		$value_pr       = "Pause"; 
		$URL = "http://$server_ip:9090/Neox_DialCenter_API/agent_pause_resume.php?secret_key=".$neoxKey;

		$QUERY_PARAM = "data={\"event\":\"$event\",\"user\":\"$user\",\"value_pr\":\"$value_pr\"}";

		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,"$URL");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "$QUERY_PARAM");
		$buffer = curl_exec($ch);

		$buffer = curl_exec($ch);
		
		$_SESSION['dial_status'] = 'Pause';
		echo "Result = $buffer\n";
//~ die;
	}
}

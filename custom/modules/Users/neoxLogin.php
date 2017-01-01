
<?php
if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');

class neoxLogin {
    function neoxLoginFunc(&$bean, $event, $arguments){
	   $server_ip = $GLOBALS['sugar_config']['neox']['server_ip'];

		$event          = "neox_agent_login";

		$user           = $GLOBALS['current_user']->neox_user;
		$password       = $GLOBALS['current_user']->neox_password;
		$campaign       = $GLOBALS['sugar_config']['neox']['campaign'];
		$phone          = "2001";
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

		echo "Result = $buffer\n";
//~ die;
	}
}

<?php
class NetCoreEmail{
	public function sendEmail($to,$subject,$body){
		$from = "falconadmin@talentedge.in";
		$fromname = "TalentEdge";
		$api_key = "fbb5606b326850fce2fa335cdce8dc16";
		$content = $body;
		$data=array();
		$data['subject']= $subject;
		$data['fromname']= rawurlencode($fromname);
		$data['api_key'] = $api_key;
		$data['from'] = $from;
		$data['content']= $content;
		$data['recipients']= $to;		
		$apiresult = $this->callApi($data);
		return trim($apiresult);
	}
	public function callApi($api_input='') {
		$result = $this->http_post_form("https://api.falconide.com/falconapi/web.send.rest",$api_input);
		return $result;
    }
	function http_post_form($url,$data,$timeout=20) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_FAILONERROR, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RANGE,"1-2000000");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_REFERER, @$_SERVER['REQUEST_URI']);

		$result = curl_exec($ch);
		$result = curl_error($ch) ? curl_error($ch) : $result;
		curl_close($ch);
		return $result;
    }
}
?>
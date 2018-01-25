<?php  
/* Db connection  @ manish 18jan2018*/
$challenge = $_REQUEST['hub_challenge'];
$verify_token = $_REQUEST['hub_verify_token'];

if ($verify_token === 'abc@123') {
echo $challenge;
}
require_once('modules/Leads/Lead.php'); 
function getFormName($form_id='',$furl='',$access_token='') {
	$form_name = '';
	global $db; 
	if($form_id) {
	  $furl = $furl.'/'.$form_id.'?fields=name&access_token='.$access_token;
	}
	$ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, $furl);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

    //execute post
    $formresponse = curl_exec($ch);

    //close connection
    curl_close($ch);
    header('Content-Type: application/json'); 
   
    /*inserting into leads*/
    $formresponsedata = json_decode($formresponse,true);
    $GLOBALS['log']->special($form_id.'#'.$furl);
    return $formresponsedata;
}

try { 
$input = json_decode(file_get_contents('php://input'), true); 
$url="https://graph.facebook.com/v2.9";
$GLOBALS['log']->special(json_encode($input));
$formData = ''; 
$form_id  = '';
if(!empty($input['entry'][0]['changes'][0]['value']['leadgen_id'])) {	
  $leadgen_id = $input['entry'][0]['changes'][0]['value']['leadgen_id'];	
  $access_token = 'EAAKcZB1mOFl4BACKJxZA5mqKZBzYtPu3KwYVGa1BEQm1uaDovstZC4V3x7JZBQH9UeOGZAmde7VkjoyQTiXcDWJSqsWZCeAgI8WgUzNPB4Om47cY2BE871ZAW8miY72kWGIPg8M3eZBjkxWD1uh4FnGp7jtgefgzmkvJH2leXycsl1gZDZD';
  $leadurl = $url.'/'.$leadgen_id.'?access_token='.$access_token;
  $formId = $input['entry'][0]['changes'][0]['value']['form_id'];
  $formData = getFormName($formId,$url,$access_token);
  
  $formName       = isset($formData['name'])?$formData['name']:''; 
  
  $ch = curl_init(); 
  curl_setopt($ch, CURLOPT_URL, $leadurl);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($ch, CURLOPT_TIMEOUT, 5);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

  //execute post
  $fbresponse = curl_exec($ch);

  //close connection
  curl_close($ch);
  header('Content-Type: application/json'); 
   
  /*inserting into leads*/
  $fbresponsedecode = json_decode($fbresponse,true);  
  
 
  if($fbresponsedecode['id']) {  
   $date_entered   = $fbresponsedecode['created_time']; /*facebook created time*/
   $source_lead_id = $fbresponsedecode['id'];  /*facebook lead id*/
   $source_type    = 'Facebook'; 
    
   
   $fieldArr = [];
   $replacestr = ['<','>',':']; 
   if($fbresponsedecode['field_data']){
	foreach($fbresponsedecode['field_data'] as $val){
		if($val['name'] && $val['name']=='email'){
				$fieldArr['email'] = str_replace($replacestr,'',$val['values'][0]);
		}
		if($val['name'] && $val['name']=='full_name'){
				$fieldArr['full_name'] = str_replace($replacestr,'',$val['values'][0]);
		}
		if($val['name'] && $val['name']=='phone_number'){
				$fieldArr['phone_number'] = str_replace($replacestr,'',$val['values'][0]);
		}
	}
   }
   $name           = explode(' ',$fieldArr['full_name']);/*facebook name*/
   $firstname      = ($name[0])?$name[0]:'';
   $lastname       = ($name[1])?$name[1]:'';
   
   /*$sql = "INSERT INTO leads (id,first_name, last_name, phone_mobile,utm_source_c,date_entered)
          VALUES ('".$source_lead_id."','".$firstname."','".$lastname."','".$fieldArr['phone_number']."','".$source_type."',NOW())"; 
    
   $result = mysqli_query($conn,$sql); */
   
   $bean_id = create_guid();
   $bean = new Lead();
   //$bean->id = $formId;//$bean_id;
   $bean->id = $bean_id;
   $bean->description = $formName."==>facebook";
   $bean->new_with_id = true;
   $bean->first_name = $firstname;
   $bean->last_name = $lastname;
   $bean->lead_source ="Campaign";
   $bean->vendor  = "Campaign";
   $bean->phone_mobile = $fieldArr['phone_number'];
   $beaninsert = $bean->save();
   $email = new SugarEmailAddress;
   $email->addAddress($fieldArr['email'], true); 
   $emailinsert = $email->save($bean_id, "Leads");
           
   if(!$beaninsert) {
	  $handle = fopen("leadlogs.txt", "w");
      fwrite($handle,'Message: lead id# '.$source_lead_id.' not inserted');
   }
   if(!$emailinsert) {
	  $handle = fopen("leadlogs.txt", "w");
      fwrite($handle,'Message: email id# '.$fieldArr['email'].' not inserted');
   }
 }
}
}catch(Exception $e) {
  $GLOBALS['log']->special($e->getMessage());	 
} 
?>

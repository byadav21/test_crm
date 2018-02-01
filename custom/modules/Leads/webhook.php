<?php				
	require_once('custom/modules/te_Api/leads_override.php');
	require_once('modules/Leads/Lead.php');
	ini_set('display_errors',0);
	error_reporting(0);
	/* Tocken Varifecation */
	$challenge = $_REQUEST['hub_challenge'];
	$verify_token = $_REQUEST['hub_verify_token'];
	if ($verify_token === 'abc@123') {
			echo $challenge;
	}
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
				
	
				/* Fb capture Data*/
				$name=$firstname;
				$lastnamel=$lastname;
				$phone= str_replace("+91","", $fieldArr['phone_number']);
				$email= $fieldArr['email'];
				$source= 'TE_Focus';
				$medium='facebook';
				$term=$formName;
				$campaign=$formName;
				$leadObj=new  leads_override();
				$batchid='';
				$status='Alive';
				$statusDetail='New Lead';
				$uname='';
				$campagain_d='';
				$lead_d='';
		//if($source && $medium && $term  && $email)
        //echo "LeadGenration";
        //print_r($_REQUEST); die;
        if($phone || $email)
            {

              $utm=	$leadObj->fetchUtm($source,$medium,$term);
                 if($utm)
                     {

                        $batchid=  $utm['te_ba_batch_id_c'];
                        $uname  =  $utm['name'];
                        $campagain_d  =  $utm['d_campaign_id'];
                        $lead_d =  $utm['d_lead_id'];
                     }
                      else
                     {
                            $batchQ = "SELECT b.id,b.name,b.d_campaign_id,b.d_lead_id,b.lastCampagain FROM  `te_ba_batch`  b WHERE b.`batch_code`='".$term."'"; 
                            $rex = $GLOBALS['db']->query($batchQ);
                            $BatchRow = $GLOBALS['db']->fetchByAssoc($rex);
                            $batchid=$BatchRow['id'];
                            $camID = $BatchRow['d_campaign_id'];
                            $leadID = $BatchRow['d_lead_id'];
//                            if(!$batchid)
//                                   {
//                                       echo json_encode(array('status'=>'error','msg'=>'Utm term is required field')); exit();
//                                   }
                            if($camID && $leadID)
                                   {
                                                $camID=explode(',',$BatchRow['d_campaign_id']);
                                                $leadID=explode(',',$BatchRow['d_lead_id']);
                                                if(count($camID)>1 && count($camID)==count($leadID))
                                                    {
                                                        $assigned=false;
                                                        for($i=0;$i<count($camID);$i++)
                                                          {
                                                               if($BatchRow['lastCampagain']==$camID[$i] . $leadID[$i] || $assigned ) continue; 
                                                                        $campagain_d=$camID[$i];
                                                                        $lead_d=$leadID[$i];
                                                                         $assigned=true;
                                                          } 
                                                    }
                                                    else
                                                    {
                                                        if($camID[0] && $leadID[0])
                                                            {						  
                                                                $campagain_d=$camID[0];
                                                                $lead_d=$leadID[0];
                                                            }					  
                                                    }
                                        }


                         }
            }
            else
            {
             //echo json_encode(array('status'=>'error','msg'=>'Email, Utm source, utm medium and utm term is required field')); exit();	
             echo json_encode(array('status'=>'error','msg'=>'Mobile or Email is required field')); exit();	
            }
 
	$sql = "SELECT leads.id as id,leads.assigned_user_id,status,status_description FROM leads INNER JOIN leads_cstm ON leads.id = leads_cstm.id_c ";
	if($email!=""){
		$sql.=" INNER JOIN email_addr_bean_rel ON email_addr_bean_rel.bean_id = leads.id AND email_addr_bean_rel.bean_module ='Leads' ";
		$sql.=" INNER JOIN email_addresses ON email_addresses.id =  email_addr_bean_rel.email_address_id ";
	}
	 
	$sql .=" WHERE leads.deleted = 0 AND leads_cstm.te_ba_batch_id_c = '".$batchid."'";
	 
	if($phone!="" && $email!=""){
		$sql.=" AND leads.phone_mobile = '$phone' AND email_addresses.email_address='".$email."'";
	}
	
        
        $autoassign='Yes';
        $assigned_user_id='NULL';
        $duplicate_check =0;
        
	$re = $GLOBALS['db']->query($sql);
	if($GLOBALS['db']->getRowCount($re)>0){
            
                //When Re-Enquired or New 
                $status = 'Warm';
		$statusDetail = 'Re-Enquired';
                $campagain_d='';
                $lead_d='';
                $autoassign='No';
                $duplicate_check=1;
                
	}
        
	$leadObj->first_name=$name;
	$leadObj->last_name = $lastnamel;
	$leadObj->duplicate_check= $duplicate_check;
	$leadObj->email1= $email;
    $leadObj->email_add_c= $email;
    $leadObj->phone_mobile= $phone;
	$leadObj->status=$status;
	$leadObj->status_description=$statusDetail;
	if($_REQUEST['work_experience'])  $leadObj->work_experience_c=$_REQUEST['work_experience'];
	if($_REQUEST['education']) $leadObj->education_c= $_REQUEST['education'];
	if($_REQUEST['city']) $leadObj->primary_address_city= $_REQUEST['city'];
	if($_REQUEST['functional_area']) $leadObj->functional_area_c=$_REQUEST['functional_area'];
	if($term) $leadObj->utm_term_c=$term;
	if($source) $leadObj->utm_source_c=$source;
	if($medium) $leadObj->utm_contract_c=$medium;
	if($campaign) $leadObj->utm_campaign=$campaign;
	if($source)  $leadObj->vendor=$source;
	if($uname)  $leadObj->utm=$uname;
        //if(!$uname) $leadObj->utm='NA';
	if($batchid) $leadObj->te_ba_batch_id_c=$batchid;
	if(!$source) $leadObj->vendor='NA_VENDOR';
	if($campagain_d)  $leadObj->dristi_campagain_id=$campagain_d;
	if($lead_d)  $leadObj->dristi_API_id= $lead_d;
	$leadObj->assigned_user_id= $assigned_user_id;
        $leadObj->autoassign= $autoassign;
	$leadObj->save();
	if(!$leadObj->id){
		echo json_encode(array('status'=>'error','msg'=>'Some thing gone wrong!')); exit();
	}
	if($campagain_d && $lead_d)	{
		$sql="update te_ba_batch set lastCampagain='". $campagain_d.$lead_d ."' where id='" .  $batchid ."'";   
		$db->query($sql);
	}
	echo json_encode(array('status'=>'success','msg'=>'Lead saved successfully!')); exit();
  }
 }

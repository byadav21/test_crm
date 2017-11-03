<?php				
	require_once('custom/modules/te_Api/leads_override.php');
	ini_set('display_errors',0);
	error_reporting(0);
	$name=$_REQUEST['name'];
	$phone=$_REQUEST['phone'];
	$email= $_REQUEST['email'];
	$source= $_REQUEST['utm_source'];
	$medium=$_REQUEST['utm_medium'];
	$term=$_REQUEST['utm_term'];//batchcode
	$campaign=$_REQUEST['utm_campaign'];
	$leadObj=new  leads_override();
	$batchid='';
	$status='Alive';
	$statusDetail='New Lead';
	 
	$uname='';
	$campagain_d='';
	$lead_d='';
	//if($source && $medium && $term  && $email)
        //print_r($_REQUEST); die;
        if($phone || $email)
            {

              $utm=	$leadObj->fetchUtm($source,$medium,$term);
                 if($utm)
                     {

                        $batchid=$utm['te_ba_batch_id_c'];
                        $uname=$utm['name'];
                     }
                      else
                     {
                            $batchQ = "SELECT b.id,b.name,b.d_campaign_id,b.d_lead_id,b.lastCampagain FROM  `te_ba_batch`  b WHERE b.`batch_code`='".$term."'"; 
                            $rex = $GLOBALS['db']->query($batchQ);
                            $BatchRow = $GLOBALS['db']->fetchByAssoc($rex);
                            $batchid=$BatchRow['id'];
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
 
	$sql = "SELECT leads.id as id FROM leads INNER JOIN leads_cstm ON leads.id = leads_cstm.id_c ";
	if($email!=""){
		$sql.=" INNER JOIN email_addr_bean_rel ON email_addr_bean_rel.bean_id = leads.id AND email_addr_bean_rel.bean_module ='Leads' ";
		$sql.=" INNER JOIN email_addresses ON email_addresses.id =  email_addr_bean_rel.email_address_id ";
	}
	 
	$sql .=" WHERE leads.deleted = 0 AND leads_cstm.te_ba_batch_id_c = '".$batchid."' AND DATE(date_entered) = '".date('Y-m-d')."'";
	 
	if($phone!=""){
		$sql.=" AND leads.phone_mobile = '$phone'";
	}
	if($email!=""){
		$sql.=" AND email_addresses.email_address='".$email."'";
	}
        
	$re = $GLOBALS['db']->query($sql);
	if($GLOBALS['db']->getRowCount($re)>0){
		$status = 'Warm';
		$statusDetail = 'Re-Enquired';
	}
        if(!$batchid && !$term){
            $campagain_d=16;   // when only Name, Mobile & Email
            $lead_d=92; 
            
        }

	$leadObj->first_name=$name;
	$leadObj->duplicate_check= 1;
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
	$leadObj->assigned_user_id= 'NULL';
	$leadObj->save();
	if(!$leadObj->id){
		echo json_encode(array('status'=>'error','msg'=>'Some thing gone wrong!')); exit();
	}
	if($campagain_d && $lead_d)	{
		$sql="update te_ba_batch set lastCampagain='". $campagain_d.$lead_d ."' where id='" .  $batchid ."'";   
		$db->query($sql);
	}
	echo json_encode(array('status'=>'success','msg'=>'Lead saved successfully!')); exit();

<?php
class duplicate_logic{
	function duplicate_logic_method(&$bean, $event, $arguments){
		global $db;
	if(!$bean->fetched_row || $bean->fetched_row ){
			
		     $qry ="select name from te_in_institutes where (deleted=0) and (id!='".$bean->id."') and (name='".$bean->name."')";
	    
	         $qry2= $db->query($qry);
		     while($row=$db->fetchByAssoc($qry2)){
				
             SugarApplication::redirect('index.php?module=te_in_institutes&action=ShowDuplicates_custom&name='.$bean->name.'');
			}
		}
		
		
		# Web Institute Sent Api While Insert NEw Istitute
		if(!$bean->fetched_row && $bean->is_sent_web=="0"){
		
				# ->  While insert New Institute sent to web
					
					$user = 'talentedgeadmin';
					$password = 'Inkoniq@2016';
					$url = 'http://talentedgewpe.wpengine.com/teapi';
					$headers = array(
					    'Authorization: Basic '. base64_encode("$user:$password")
					);
					$post = [
					    'action' => 'add', 
					    'instname' => $bean->name,
					    'insdescription'   => $bean->description,
						'crmid'   => $bean->id,
					];
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL,$url);

					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
					$result = curl_exec($ch);
					$res = json_decode($result);
					print_r($res);

						if(isset($res[0]->status) && $res[0]->status=='1'){
							echo "hello insert Success ";
							$bean->is_sent_web="1";
							$bean->web_institute_id=$res[0]->institute_id;

						}

						curl_close($ch);

		}
		else{
			# ->  While update Existing Institute Send to web
					
					$user = 'talentedgeadmin';
					$password = 'Inkoniq@2016';
					$url = 'http://talentedgewpe.wpengine.com/teapi';
					$headers = array(
					    'Authorization: Basic '. base64_encode("$user:$password")
					);
					$post = [
					    'action' => 'update', 
					    'instname' => $bean->name,
					    'insdescription'   => $bean->description,
						'crmid'   => $bean->id,
					];
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL,$url);

					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
					$result = curl_exec($ch);
					$res = json_decode($result);
					
					

						if(isset($res[0]->status) && $res[0]->status=='1'){
							echo "hello update Success";
							$bean->web_institute_id=$res[0]->institute_id;

						}

						curl_close($ch);
			
			}
			
	}
	 
}
?>
 

<?php
class first_logic{
	function first_logic_method(&$bean, $event, $arguments){
		global $db;
			
			/*
		     $qry ="select name from te_pr_programs where (deleted=0) and (id!='".$bean->id."') and (name='".$bean->name."')";

	         $qry2= $db->query($qry);
		     while($row=$db->fetchByAssoc($qry2)){

             SugarApplication::redirect('index.php?module=te_pr_Programs&action=ShowDuplicates_custom&name='.$bean->name.'');
			}
			*/
		  if(!empty($_REQUEST['te_in_institutes_te_pr_programs_1_name']))
			{
				if((!$bean->fetched_row)|| ($bean->fetched_row ))
				{
				 		$quer4="select COUNT(commap.te_in_institutes_te_pr_programs_1te_pr_programs_idb) AS yes from te_in_institutes_te_pr_programs_1_c as commap join te_pr_programs as prog on commap.te_in_institutes_te_pr_programs_1te_pr_programs_idb = prog.id join te_in_institutes as inst on
						commap.te_in_institutes_te_pr_programs_1te_in_institutes_ida = inst.id where  inst.name='".$bean->te_in_institutes_te_pr_programs_1_name."' AND prog.name='".$bean->name."' AND prog.id!='".$bean->id."'";
							$qry5= $db->query($quer4);
							$result=$db->fetchByAssoc($qry5);
							if($result['yes']!=0)
							{
							//$this->$bean->te_in_institutes_te_pr_programs_1_name->id;
							SugarApplication::appendErrorMessage('You have been redirected here because ....');
							SugarApplication::redirect('index.php?module=te_pr_Programs&action=ShowDuplicates_custom&name='.$bean->te_in_institutes_te_pr_programs_1_name.'');
							}
					}

			}
			if(!isset($bean->web_id) || empty($bean->web_id)){
				/*Insert program api call here*/
				$user = 'talentedgeadmin';
				$password = 'Inkoniq@2016';
				$url = 'http://talentedge.staging.wpengine.com/programme-api/';
				$headers = array(
						'Authorization: Basic '. base64_encode("$user:$password")
				);
				$post = [
						'action' => 'add',
						'pname' => $bean->name,
						'Inst_crm_id'   => $_REQUEST['te_in_institutes_te_pr_programs_1te_in_institutes_ida'],
						'programmed_crmid'   => $bean->id,
				];
				 
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL,$url);

				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
				$result = curl_exec($ch);
				$result = stripslashes(html_entity_decode($result));
				$res = json_decode(trim($result),TRUE);
				//header('Content-type: application/json;');
				echo $result.$res[0]->status.' - '.$res[0]->message;echo "<pre>";print_r($res);exit();
					if(isset($res[0]->status) && $res[0]->message=='Success'){
					//	echo "hello insert Success ";
						$bean->web_id=$res[0]->course_id;

					}

					curl_close($ch);
			}
			else{
				/*update program api call here*/
				$user = 'talentedgeadmin';
				$password = 'Inkoniq@2016';
				$url = 'http://talentedge.staging.wpengine.com/programme-api/';
				$headers = array(
						'Authorization: Basic '. base64_encode("$user:$password")
				);
				$post = [
						'action' => 'update',
						'pname' => $bean->name,
						'Inst_crm_id'   => $_REQUEST['te_in_institutes_te_pr_programs_1te_in_institutes_ida'],
						'programmed_crmid'   => $bean->id,
				];
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL,$url);

				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
				$result = curl_exec($ch);
				$result = stripslashes(html_entity_decode($result));
				$res = json_decode(trim($result),TRUE);
				//header('Content-type: application/json;');
				echo $result.$res[0]->status.' -update '.$res[0]->message;echo "<pre>";print_r($res);exit();
					if(isset($res[0]->status) && $res[0]->message=='Success'){

						$bean->web_id=$res[0]->course_id;
						
					}

					curl_close($ch);
			}

	}

}
?>

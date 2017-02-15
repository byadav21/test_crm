<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
//@Manish Gupta 9650211216

if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');
	global $db;

		$sql = "SELECT t1.id,t1.`parent_lead_id`,t1.`lead_id`,t2.assigned_user_id FROM `leads_duplicate` AS t1 INNER JOIN leads AS t2 ON t1.parent_lead_id=t2.id WHERE (t1.`is_assigened`=0) AND (t2.assigned_user_id!='NULL') LIMIT 0,50";
		$row = $db->query($sql);
			if($row->num_rows>0){
					$res='';
					while($records =$db->fetchByAssoc($row)){
					$res[] =$records;
					}	
					//echo '<pre>';
					//print_r($val);
					//echo '</pre>';	
		
				$update_leads = "UPDATE leads SET assigned_user_id = (CASE id ";
				$duplicate_id = '';
				$lead_id = '';
				foreach($res as $val){
					$update_leads .= "WHEN '".$val['lead_id']."' THEN '".$val['assigned_user_id']."' ";
					$lead_id[] = $val['lead_id'];
					$duplicate_id[] = $val['id'];
				}
				$imploded_lead_id = '"'.implode('","', $lead_id).'"';
				$update_leads .= "END) WHERE id IN($imploded_lead_id)";
				//echo $update_leads;exit();
				//$res_update_leads = $conn->query($update_leads);
				$res_update_leads = $db->query($update_leads);
				
					if($res_update_leads){
						$leads_id_for_update = '"'.implode('","', $duplicate_id).'"';
						$update_leads_duplicate = "UPDATE leads_duplicate SET is_assigened=1 WHERE id IN($leads_id_for_update)";
						//$res_update_leads_duplicate = $conn->query($update_leads_duplicate);
						$res_update_leads_duplicate = $db->query($update_leads_duplicate);
					}
		
		
		echo "sucess update";
		
	}
			else 
		{
			echo "0 Results ";
		}

?>


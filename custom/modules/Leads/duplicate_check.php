<?php
// @Manish.gimt12@gmail.com
if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');
	global $db;


	$sql = "SELECT GROUP_CONCAT(DISTINCT(l.`id`) ORDER BY l.date_entered)lead_id,count(l.id)total FROM `leads` AS l INNER JOIN leads_cstm lc ON l.id=lc.id_c LEFT JOIN email_addr_bean_rel el ON l.id = el.bean_id LEFT JOIN email_addresses e ON el.email_address_id = e.id WHERE l.deleted=0 AND l.status!='Duplicate'   GROUP BY  l.phone_other ,  l.`phone_mobile`,lc.te_ba_batch_id_c,e.email_address HAVING (COUNT(l.`phone_other`)>1 or COUNT(l.`phone_mobile`)>1 OR (COUNT(e.email_address)>1)) AND (COUNT(lc.te_ba_batch_id_c)>1) LIMIT 0,10";
	$row = $db->query($sql);
		if($row->num_rows>0){
			$res='';
			while($records =$db->fetchByAssoc($row)){
				$res[] =$records;
			}
			
			foreach ($res as $val){
				$leads = '';
				$parent_lead_id = '';
				$lvaldata = '';
				$child_leads = '';
				if($val['total']>1){
					$leads = explode(',',$val['lead_id']);
					$parent_lead_id =$leads[0];
					unset($leads[0]);
					$insert_leads = "INSERT INTO leads_duplicate (parent_lead_id, lead_id) VALUES ";
					foreach($leads as $lval){
						$lvaldata[]= "('".$parent_lead_id."','".$lval."')";
					}
					//echo $insert_leads.'<br>';
					$res_insert_leads = $db->query($insert_leads.implode(',',$lvaldata));
					//$conn->query($insert_leads.implode(',',$lvaldata));
					if($res_insert_leads==1){
						$leads_id_for_update = '"'.implode('","', $leads).'"';
						$update_leads_mark_duplicate = "UPDATE leads SET status='Warm',status_description='Re-Enquired',`duplicate_check`=1 WHERE id IN($leads_id_for_update)";
						$res_update_leads =  $db->query($update_leads_mark_duplicate);
						//$conn->query($update_leads_mark_duplicate);
						$update_parent_lead = "UPDATE leads SET `duplicate_check`=1 WHERE id='".$parent_lead_id."'";
						$res_update_parent_lead = $db->query($update_parent_lead);
						//$res_update_parent_lead = $conn->query($update_parent_lead);
						
					}
					
				}
			}
					echo "Sucess updated";
		}
			else
			{
			$update_lead = "UPDATE leads SET `duplicate_check`=1 WHERE id!=''";
			$res_update_lead = $db->query($update_lead);
			echo " 0 Result updated";
				
			}
		


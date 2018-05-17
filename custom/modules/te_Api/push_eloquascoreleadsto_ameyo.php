<?php
	if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');
global $db;
$query="SELECT lead.id, batch.d_campaign_id, batch.d_lead_id from `leads_cstm`  as `leadcstm`
  INNER JOIN `te_ba_batch` as `batch` on leadcstm.te_ba_batch_id_c = batch.id
  INNER JOIN `leads` as `lead` on leadcstm.id_c = lead.id
  where leadcstm.eloqua_lead_score IN ('A1', 'A2', 'A3', 'B1', 'B2')
  and lead.status_description IN ('Fallout', 'Not interested', 'Retired', 'Cross Sell', 'Not Enquired', 'Next Batch')
  and batch.batch_status = 'enrollment_in_progress'
  and lead.deleted = '0'
	and lead.update_flag = '0'
  group by leadcstm.te_ba_batch_id_c, lead.phone_mobile, leadcstm.email_add_c
  ORDER BY lead.date_entered ASC
  limit 10";
 	$result = $db->Query($query);
	print_r($result);
  while ($row =$db->fetchByAssoc($result)){
		print_r($row);

		$leadid=$row['id'];
		$d_campaign_id=$row['d_campaign_id'];
		$d_lead_id=$row['d_lead_id'];
    $querylead="SELECT * from `leads` WHERE `id`='$leadid' ";
    $resultlead = $db->Query($querylead);
    while ($rowlead =$db->fetchByAssoc($resultlead)){

		  $autoassign=$rowlead['autoassign'];
      $status=$rowlead['status'];
      $status_description=$rowlead['status_description'];
      $neoxstatus=$rowlead['neoxstatus'];
      $assigned_user_id=$rowlead['assigned_user_id'];
     	$update_flag=$rowlead['update_flag'];
      $dristi_campagain_id=$rowlead['dristi_campagain_id'];
      $dristi_API_id=$rowlead['dristi_API_id'];
      //insert query in lead table 'lead_logdata'
  echo	$insert_logdata="INSERT INTO `CRM_NEW26MARCH`.`leads_logdata` ( `lead_id`, `autoassign`, `status`, `status_description`, `neoxstatus`, `assigned_user_id`, `update_flag`, `dristi_campagain_id`, `dristi_API_id`)
	 		VALUES ( '$leadid', '$autoassign', '$status', '$status_description', '$neoxstatus', '$assigned_user_id', '$update_flag', '$dristi_campagain_id', '$dristi_API_id');";
     $db->Query($insert_logdata);
			      //update query in lead table
   $update_lead= "UPDATE `leads` SET `autoassign` = 'Yes', `status` = 'Alive', `status_description` = 'New Lead', `neoxstatus` = '0',`assigned_user_id` = '', `update_flag` = '1', `dristi_campagain_id` = '$d_campaign_id',   `dristi_API_id` = '$d_lead_id' WHERE `id` = '$leadid'";
  $db->Query($update_lead);

    }
  }

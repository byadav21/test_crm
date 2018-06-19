<?php
if(!defined('sugarEntry'))define('sugarEntry', true);
require_once('include/entryPoint.php');

$query ="SELECT lead_modified_date FROM dashboard_leads order by lead_modified_date desc limit 1";
$resultselect = $db->query($query);
$row = $db->fetchByAssoc($resultselect);
$modifieddate=$row['lead_modified_date'];
$query = "SELECT leads.id AS lead_id,leads.date_entered,leads.date_modified,
				leads.modified_user_id,leads.assigned_user_id,ru.reports_to_id,
				leads.deleted,leads.converted,leads.converted_date,leads.lead_source_types,
				leads.lead_source,leads.vendor,leads.lead_source_description,leads.status,
				leads.status_description,leads.campaign_id,leads.gender,
				(CASE WHEN leads_cstm.`attempts_c` IN ('','null') OR leads_cstm.`attempts_c` IS NULL THEN 0 ELSE leads_cstm.`attempts_c` END) attempts_c,
				(CASE WHEN leads.Amount IN ('','null') OR leads.Amount IS NULL THEN 0 ELSE leads.Amount END) amount,
				leads.utm,leads.fee_usd,leads.fee_inr,leads.converted_date,leads.utm_campaign,
				leads.neoxstatus,i.name institute_name,i.id institute_id,p.name program_name,
				p.id program_id,te_ba_batch.name AS batch_name,te_ba_batch.batch_code,te_ba_batch.batch_status,
				(CASE WHEN te_ba_batch.batch_size IN ('','null') OR te_ba_batch.batch_size IS NULL THEN 0 ELSE te_ba_batch.batch_size END) batch_size,
				leads.assigned_date,leads.channel,leads.`dispositionName`,te_ba_batch.no_of_installments instalment_no
			FROM leads 
			INNER JOIN leads_cstm ON leads.id= leads_cstm.id_c AND leads.deleted=0
			INNER JOIN te_ba_batch ON leads_cstm.te_ba_batch_id_c= te_ba_batch.id AND te_ba_batch.deleted=0
			INNER JOIN te_in_institutes_te_ba_batch_1_c AS ib ON leads_cstm.te_ba_batch_id_c=ib.te_in_institutes_te_ba_batch_1te_ba_batch_idb AND ib.deleted=0
			INNER JOIN te_in_institutes as i on ib.te_in_institutes_te_ba_batch_1te_in_institutes_ida=i.id AND i.deleted=0
			INNER JOIN te_pr_programs_te_ba_batch_1_c AS pb ON pb.te_pr_programs_te_ba_batch_1te_ba_batch_idb=leads_cstm.te_ba_batch_id_c AND pb.deleted=0
			INNER JOIN te_pr_programs AS p ON p.id=pb.te_pr_programs_te_ba_batch_1te_pr_programs_ida AND p.deleted=0
			LEFT JOIN users AS ru ON ru.id=leads.assigned_user_id 
			where leads.date_modified>='$modifieddate' order by leads.id limit 10";
$result = $db->query($query);
while (($row = $db->fetchByAssoc($result)) != null) {
	echo "<pre>";print_r($row);echo "</pre>";
	$query = "SELECT *  FROM dashboard_leads WHERE lead_id='".$row['lead_id']."' ";
	$resultselect = $db->query($query, false);
	//echo $resultselect->num_rows;
	//echo "<pre>";print_r($resultselect);echo "</pre>";exit;
	if($resultselect->num_rows==0){
		$insertdata="INSERT INTO `dashboard_leads` ( `lead_id`, `lead_entered_date`, `lead_modified_date`, `modified_user_id`, `lead_deleted`, `lead_converted`, `lead_converted_date`, `lead_source`, `vendor`, `lead_source_description`, `lead_status`, `lead_status_description`, `campaign_id`, `gender`, `no_attempts`, `amount`, `utm`, `fee_usd`, `fee_inr`, `utm_campaign`, `institute_name`, `institute_id`, `program_name`, `program_id`, `batch_name`, `batch_code`, `batch_status`, `lead_assigned_date`, `channel`, `disposition_name`, `no_instalment`, `neoxstatus`, `manager_id`, `btach_size`) VALUES (   '".$row['lead_id']."', '".$row['date_entered']."', '".$row['date_modified']."', '".$row['modified_user_id']."', '".$row['lead_deleted']."', '".$row['lead_converted']."', '".$row['lead_converted_date']."', '".$row['lead_source']."', '".$row['vendor']."', '".$row['lead_source_description']."', '".$row['status']."', '".$row['status_description']."', '".$row['campaign_id']."', '".$row['gender']."', '".$row['no_attempts']."', '".$row['amount']."', '".$row['utm']."', '".$row['fee_usd']."', '".$row['fee_inr']."', '".$row['utm_campaign']."', '".$row['institute_name']."', '".$row['institute_id']."', '".$row['program_name']."', '".$row['program_id']."', '".$row['batch_name']."', '".$row['batch_code']."', '".$row['batch_status']."', '".$row['lead_assigned_date']."', '".$row['channel']."', '".$row['disposition_name']."', '".$row['no_instalment']."', '".$row['neoxstatus']."', '".$row['manager_id']."', '".$row['btach_size']."');";
		$insertquerydata=$db->query($insertdata);
	}else{
		$updatedata="UPDATE `dashboard_leads` SET `lead_entered_date` = '".$row['date_entered']."',, `lead_modified_date` = '".$row['date_modified']."', `modified_user_id` = '".$row['modified_user_id']."', `lead_deleted` = '".$row['lead_deleted']."', `lead_converted` = '".$row['lead_converted']."', `lead_converted_date` = ".$row['lead_converted_date']."', `lead_source` = '".$row['lead_source']."', `vendor` = '".$row['vendor']."', `lead_source_description` = '".$row['lead_source_description']."', `lead_status` = '".$row['status']."', `lead_status_description` = '".$row['status_description']."', `campaign_id` = '".$row['campaign_id']."', `gender` = '".$row['gender']."', `no_attempts` = '".$row['no_attempts']."', `amount` = '".$row['amount']."', `utm` = '".$row['utm']."', `fee_usd` = '".$row['fee_usd']."', `fee_inr` = '".$row['fee_inr']."', `utm_campaign` = '".$row['utm_campaign']."', `institute_name` = '".$row['institute_name']."', `institute_id` =  '".$row['institute_id']."', `program_name` = '".$row['program_name']."', `program_id` = '".$row['program_id']."', `batch_name` = '".$row['batch_name']."', `batch_code` = '".$row['batch_code']."', `batch_status` = '".$row['batch_status']."', `channel` = '".$row['channel']."', `disposition_name` = '".$row['disposition_name']."', `no_instalment` = '".$row['no_instalment']."', `neoxstatus` = '".$row['neoxstatus']."', `manager_id` = '".$row['manager_id']."', `btach_size` = '".$row['btach_size']."' WHERE `dashboard_leads`.`lead_id` = '".$row['lead_id']."';";
		$updatequerydata=$db->query($updatedata);
	}
}
echo "done cron";exit;
 ?>
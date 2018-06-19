<?php
if(!defined('sugarEntry'))define('sugarEntry', true);
require_once('include/entryPoint.php');

$query ="SELECT lead_modified_date FROM dashboard_leads order by lead_modified_date desc limit 1";
$resultselect = $db->query($query);
$row = $db->fetchByAssoc($resultselect);
$modifieddate=$row['lead_modified_date'];
echo $query = "SELECT leads.id AS lead_id,leads.date_entered,leads.date_modified,
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
			where leads.date_modified>='$modifieddate' order by leads.id limit 10";exit;
$result = $db->query($query);
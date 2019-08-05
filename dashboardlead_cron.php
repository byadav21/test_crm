<?php
//return "test";exit;
//exit;
//print_r($_REQUEST);exit;
if(!defined('sugarEntry'))define('sugarEntry', true);
require_once('include/entryPoint.php'); 
//global $db;

//error_reporting(-1);
//ini_set('display_errors', 'On');



$con_list = DBManagerFactory::getInstance('cust_report_list');
//print_r($con_list); die;

//$_POST['daystart'] = '2';
//$_POST['dayend']='1';

$datestart=date("Y-m-d",strtotime("-".$_POST['daystart']." days"));
$dateend=date("Y-m-d",strtotime("-".$_POST['dayend']." days"));
$startdate = $datestart." 00:00:00";
$enddate = $dateend." 00:00:00";
//$modifieddate=$date;
$query = "SELECT leads.id AS lead_id,leads.date_entered,leads.date_modified,
				leads.modified_user_id,CONCAT(modifyusr.first_name,' ',modifyusr.last_name) as modified_user_name,leads.assigned_user_id,CONCAT(ru.first_name,' ',ru.last_name) as assigned_user_name,ru.employee_status as assigned_user_status,ru.reports_to_id,CONCAT(repotrty.first_name,' ',repotrty.last_name) as manager_name,repotrty.employee_status as manager_status,
				leads.deleted,leads.converted,leads.converted_date,leads.lead_source_types,
				leads.lead_source,leads.vendor,leads.lead_source_description,leads.status,
				leads.status_description,leads.dristi_campagain_id,leads.gender, leads.update_flag,
				(CASE WHEN leads_cstm.`attempts_c` IN ('','null') OR leads_cstm.`attempts_c` IS NULL THEN 0 ELSE leads_cstm.`attempts_c` END) attempts_c,
				(CASE WHEN leads.Amount IN ('','null') OR leads.Amount IS NULL THEN 0 ELSE leads.Amount END) amount,
				leads.utm,leads.fee_usd,te_ba_batch.fees_inr as fee_inr,leads.converted_date,leads.utm_campaign,
				leads.neoxstatus,i.name institute_name,i.id institute_id,p.name program_name,
				p.id program_id,te_ba_batch.name AS batch_name,te_ba_batch.batch_code,te_ba_batch.batch_status,
				(CASE WHEN te_ba_batch.batch_size IN ('','null') OR te_ba_batch.batch_size IS NULL THEN 0 ELSE te_ba_batch.batch_size END) batch_size,
				leads.assigned_date,leads.channel,leads.`dispositionName`,te_ba_batch.no_of_installments instalment_no,sum(te_payment_details.amount) as totalamount,leads.primary_vendor, leads_cstm.eloqua_lead_score
			FROM leads 
			INNER JOIN leads_cstm ON leads.id= leads_cstm.id_c AND leads.deleted=0
			LEFT JOIN leads_te_payment_details_1_c ON leads.id = leads_te_payment_details_1_c.leads_te_payment_details_1leads_ida
			LEFT JOIN te_payment_details ON te_payment_details.id = leads_te_payment_details_1_c.leads_te_payment_details_1te_payment_details_idb
			INNER JOIN te_ba_batch ON leads_cstm.te_ba_batch_id_c= te_ba_batch.id AND te_ba_batch.deleted=0
			INNER JOIN te_in_institutes_te_ba_batch_1_c AS ib ON leads_cstm.te_ba_batch_id_c=ib.te_in_institutes_te_ba_batch_1te_ba_batch_idb AND ib.deleted=0
			INNER JOIN te_in_institutes as i on ib.te_in_institutes_te_ba_batch_1te_in_institutes_ida=i.id AND i.deleted=0
			INNER JOIN te_pr_programs_te_ba_batch_1_c AS pb ON pb.te_pr_programs_te_ba_batch_1te_ba_batch_idb=leads_cstm.te_ba_batch_id_c AND pb.deleted=0
			INNER JOIN te_pr_programs AS p ON p.id=pb.te_pr_programs_te_ba_batch_1te_pr_programs_ida AND p.deleted=0
			LEFT JOIN users AS ru ON ru.id=leads.assigned_user_id
			LEFT JOIN users AS repotrty ON repotrty.id=ru.reports_to_id
			LEFT JOIN users AS modifyusr ON modifyusr.id=ru.modified_user_id			
			where leads.date_modified BETWEEN  '$startdate'
AND  '$enddate' group by lead_id order by leads.date_modified asc limit 5000";
$result = $con_list->query($query);
$data= array();
while (($row = $con_list->fetchByAssoc($result)) != null) {
	$data[]=$row;
}	
echo json_encode($data);exit;

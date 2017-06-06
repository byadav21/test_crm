<?php
if (!defined('sugarEntry') || !sugarEntry)
	die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');
class AOR_ReportsViewDailyreport extends SugarView {

	public function __construct() {
		parent::SugarView();
	}
	function getStartAndEndDate($week, $year) {
	  $dto = new DateTime();
	  $dto->setISODate($year, $week);
	  $ret['week_start'] = $dto->format('Y-m-d');
	  $dto->modify('+6 days');
	  $ret['week_end'] = $dto->format('Y-m-d');
	  return $ret;
	}
	function getVendors($vendor_id=""){
		global $db;
		$vendorSql="SELECT id,name FROM te_vendor WHERE deleted=0 AND vendor_status='Active'";
		$vendorObj =$db->query($vendorSql);
		$vendorOptions=array();
		$index=0;
		while($row =$db->fetchByAssoc($vendorObj)){
			$vendorOptions[$index]['id']=$row['id'];
			$vendorOptions[$index]['name']=$row['name'];
			$index++;
		}
		return $vendorOptions;
	}

	function getReportData($searchData){
		global $db;
		if($searchData['vendor_id']!=""){		#If vendor search filter is selected
			$vendorSql="SELECT count(*) as total_leads,v.name as vendor,b.id as batch_id, b.name as batch,b.batch_status,b.fees_inr as course_fee, v.id as vendor_id FROM te_vendor v INNER JOIN leads l ON v.name=l.vendor INNER JOIN leads_cstm lc ON l.id=lc.id_c INNER JOIN te_ba_batch b ON lc.te_ba_batch_id_c=b.id WHERE l.deleted=0 AND v.vendor_status='Active' AND v.id='".$searchData['vendor_id']."'";
		}elseif($searchData['batch_id']!=""){	#If Batch search filter is selected
			$vendorSql="SELECT count(*) as total_leads,v.name as vendor,b.id as batch_id, b.name as batch,b.batch_status,b.fees_inr as course_fee, v.id as vendor_id FROM te_vendor v INNER JOIN leads l ON v.name=l.vendor INNER JOIN leads_cstm lc ON l.id=lc.id_c INNER JOIN te_ba_batch b ON lc.te_ba_batch_id_c=b.id WHERE l.deleted=0 AND v.vendor_status='Active' AND b.id='".$searchData['batch_id']."'";
		}else{
			$vendorSql="SELECT count(*) as total_leads,v.name as vendor,b.id as batch_id, b.name as batch,b.batch_status,b.fees_inr as course_fee, v.id as vendor_id FROM te_vendor v INNER JOIN leads l ON v.name=l.vendor INNER JOIN leads_cstm lc ON l.id=lc.id_c INNER JOIN te_ba_batch b ON lc.te_ba_batch_id_c=b.id WHERE l.deleted=0 AND v.vendor_status='Active'";
		}
		if(isset($searchData['search_date'])&&$searchData['search_date']!=""){
			$searchData['search_date']=$GLOBALS['timedate']->to_db_date($searchData['search_date'],false);
			$vendorSql.=" AND l.date_modified LIKE '".$searchData['search_date']."%'";
		}
		#If batch status search filter is selected
		if($searchData['batch_status']!=""){
			$vendorSql.=" AND b.batch_status='".$searchData['batch_status']."' GROUP By v.name,b.name";
		}else{
			$vendorSql.=" GROUP By v.name,b.name";
		}

		$vendorObj =$db->query($vendorSql);
		$vendorOptions=array();
		while($row =$db->fetchByAssoc($vendorObj)){
			$vendorOptions[]=$row;
		}
		return $vendorOptions;
	}
	function getBatch(){
		global $db;
		$batchSql="SELECT id,name from te_ba_batch WHERE deleted=0 AND batch_status<>'Closed'";
		$batchObj =$db->query($batchSql);
		$batchOptions=array();
		while($row =$db->fetchByAssoc($batchObj)){
			$batchOptions[]=$row;
		}
		return $batchOptions;
	}
	function getRevenueFromLead($vendor,$batch_id,$search_date=""){
		global $db;
		$batchSql="SELECT SUM(lp.amount) as revenue FROM leads l INNER JOIN leads_cstm lc ON l.id=lc.id_c INNER JOIN leads_te_payment_details_1_c lpr ON lc.id_c=lpr.leads_te_payment_details_1leads_ida INNER JOIN te_payment_details lp ON lpr.leads_te_payment_details_1te_payment_details_idb=lp.id WHERE l.deleted=0 AND l.vendor='".$vendor."' AND lc.te_ba_batch_id_c='".$batch_id."'";
		if($search_date!=""){
			$search_date=$GLOBALS['timedate']->to_db_date($search_date,false);
			$batchSql.=" AND l.date_modified LIKE '".$search_date."%'";
		}
		$batchObj =$db->query($batchSql);
		$row =$db->fetchByAssoc($batchObj);
		return $row['revenue']?$row['revenue']:"0.00";
	}
	function getLeadByStatus($vendor="",$batch_id="",$search_date=""){
		global $db;
		if($vendor!=""&&$batch_id!=""){
			$vendorSql="SELECT count(*) as total,l.status FROM leads l INNER JOIN leads_cstm lc ON l.id=lc.id_c WHERE l.deleted=0 AND l.vendor='".$vendor."' AND lc.te_ba_batch_id_c='".$batch_id."' GROUP BY l.status";
		}elseif($vendor!=""&&$batch_id==""){
			$vendorSql="SELECT count(*) as total,l.status FROM leads l INNER JOIN leads_cstm lc ON l.id=lc.id_c WHERE l.deleted=0 AND l.vendor='".$vendor."' GROUP BY l.status";
		}elseif($vendor==""&&$batch_id!=""){
			$vendorSql="SELECT count(*) as total,l.status FROM leads l INNER JOIN leads_cstm lc ON l.id=lc.id_c WHERE l.deleted=0 AND lc.te_ba_batch_id_c='".$batch_id."' GROUP BY l.status";
		}
		if($search_date!=""){
			$search_date=$GLOBALS['timedate']->to_db_date($search_date,false);
			$batchSql.=" AND l.date_modified LIKE '".$search_date."%'";
		}
		$vendorObj =$db->query($vendorSql);
		$resultSet=array('registered'=>'','invalid'=>'');
		while($row =$db->fetchByAssoc($vendorObj)){
			if($row['status']=='Converted')
				$resultSet['registered']=$row['total'];
			if($row['status']=='Dead')
				$resultSet['invalid']=$row['total'];
		}

		return $resultSet;
	}
	function getActualPlanByVendor($vendor="",$batch="",$search_date=""){
		global $db;
		if($batch!=""&&$vendor!=""){
			$actualPlanSql=" SELECT sum(a.total_cost)total_cost FROM te_vendor_te_utm_1_c uvr INNER JOIN te_utm u ON uvr.te_vendor_te_utm_1te_utm_idb=u.id INNER JOIN te_utm_te_actual_campaign_1_c AS ua on ua.te_utm_te_actual_campaign_1te_utm_ida=u.id INNER JOIN te_actual_campaign a ON a.id=ua.te_utm_te_actual_campaign_1te_actual_campaign_idb WHERE uvr.te_vendor_te_utm_1te_vendor_ida='".$vendor."' AND a.te_ba_batch_id_c='".$batch."' AND a.type='paid' AND a.deleted=0";
		}elseif($vendor!=""&&$batch==""){
			$actualPlanSql=" SELECT a.total_cost,a.cpl FROM te_vendor_te_utm_1_c uvr INNER JOIN te_utm u ON uvr.te_vendor_te_utm_1te_utm_idb=u.id INNER JOIN te_actual_campaign a ON u.name=a.name WHERE uvr.te_vendor_te_utm_1te_vendor_ida='".$vendor."'";
		}elseif($vendor==""&&$batch!=""){
			$actualPlanSql=" SELECT a.total_cost,a.cpl FROM te_vendor_te_utm_1_c uvr INNER JOIN te_utm u ON uvr.te_vendor_te_utm_1te_utm_idb=u.id INNER JOIN te_actual_campaign a ON u.name=a.name WHERE  u.te_ba_batch_id_c='".$batch."'";
		}
		if($search_date!=""){
			$actualPlanSql.=$search_date;
		}
		$actualPlanObj =$db->query($actualPlanSql);
		$actualPlan =$db->fetchByAssoc($actualPlanObj);
		return $actualPlan;
	}
	public function display() {
		global $db;
		#Get vendor drop down option
		$vendorList=$this->getVendors();
		#Get batch drop down option
		$batchList=$this->getBatch();
		#batch status drop down option
		$batchStatusList=$GLOBALS['app_list_strings']['batch_status_list'];
		$reportDataList=array();
		$vendorOptionList=array();
		$selected_vendor="";
		$selected_batch="";
		$selected_status="";
		$search_date="";
		$searchData=array('batch_id'=>'','vendor_id'=>'','batch_status'=>'','search_date'=>'');

			$index=0;
			$whereVendor = '';
			$selected_vendor = '';
			$whereCourse = '';
			$whereactual = '';
			$selected_course = '';
			$selected_from_date = '';
			$selected_to_date = '';
			if(isset($_POST['button']) || isset($_POST['export'])) {
					$_SESSION['dsr_vendor'] = $_POST['vendor'];
					$_SESSION['dsr_course'] = $_POST['course'];
					$_SESSION['dsr_from_date'] = $_POST['from_date'];
					$_SESSION['dsr_to_date'] = $_POST['to_date'];
			}

			if(isset($_SESSION['dsr_vendor']) && !empty($_SESSION['dsr_vendor'])){
				$selected_vendor = $_SESSION['dsr_vendor'];
				$whereVendor = " AND v.id='".$_SESSION['dsr_vendor']."' ";
			}
			if(isset($_SESSION['dsr_course']) && !empty($_SESSION['dsr_course'])){
				$selected_course = $_SESSION['dsr_course'];
				$whereCourse = " AND id='".$_SESSION['dsr_course']."' ";
			}
			if(isset($_SESSION['dsr_from_date']) && !empty($_SESSION['dsr_from_date'])){
				$selected_from_date = $_SESSION['dsr_from_date'];
				$where.=" AND DATE(l.date_entered)>='".date('Y-m-d',strtotime($selected_from_date))."' ";
				$whereactual.=" AND DATE(a.plan_date)>='".date('Y-m-d',strtotime($selected_from_date))."' ";
			}
			if(isset($_SESSION['dsr_to_date']) && !empty($_SESSION['dsr_to_date'])){
				$selected_to_date = $_SESSION['dsr_to_date'];
				$where.=" AND DATE(l.date_entered)<='".date('Y-m-d',strtotime($selected_to_date))."'";
				$whereactual.=" AND DATE(a.plan_date)<='".date('Y-m-d',strtotime($selected_to_date))."' ";
			}

			$vendorSql="SELECT v.name,v.id,count(l.id)total_con FROM `te_vendor` AS v LEFT JOIN leads AS l ON l.vendor=v.name AND l.status='Converted' AND l.deleted=0 $where WHERE v.deleted=0 $whereVendor  group by v.name order by v.name asc";
			$vendorObj =$db->query($vendorSql);
			$vendorArr = [];
			while($vendor =$db->fetchByAssoc($vendorObj)){

				$actualPlanSql=" SELECT sum(a.total_cost)total_cost FROM te_vendor_te_utm_1_c uvr INNER JOIN te_utm u ON uvr.te_vendor_te_utm_1te_utm_idb=u.id INNER JOIN te_utm_te_actual_campaign_1_c AS ua on ua.te_utm_te_actual_campaign_1te_utm_ida=u.id INNER JOIN te_actual_campaign a ON a.id=ua.te_utm_te_actual_campaign_1te_actual_campaign_idb WHERE uvr.te_vendor_te_utm_1te_vendor_ida='".$vendor['id']."' AND a.type='paid' AND a.deleted=0 $whereactual";
				$actualPlanObj =$db->query($actualPlanSql);
				$actualPlanRes = $db->fetchByAssoc($actualPlanObj);
				$total_lead_con=0;
				$total_cost=0;
				if($vendor['total_con']){
					$total_lead_con = $vendor['total_con'];
				}
				if($actualPlanRes['total_cost']){
					$total_cost = $actualPlanRes['total_cost'];
				}
				$vendorArr[]=array('name'=>$vendor['name'],'id'=>$vendor['id'],'total_cost'=>$actualPlanRes['total_cost'],'vendor_con'=>$total_lead_con);
			}
			$vendors = $vendorArr;
			$batchSql="SELECT name,id,fees_inr,batch_status from te_ba_batch WHERE deleted=0  AND name!='' $whereCourse";
			$batchObj =$db->query($batchSql);
			$batchOptions=array();
			while($row =$db->fetchByAssoc($batchObj)){
				$actualPlanSql=" SELECT sum(a.total_cost)total_cost FROM te_actual_campaign AS a WHERE a.deleted=0 AND a.te_ba_batch_id_c='".$row['id']."' $whereactual";
				$actualPlanObj =$db->query($actualPlanSql);
				$actualPlanRes = $db->fetchByAssoc($actualPlanObj);

				$LeadConSql=" SELECT count(l.id)total_lead_con FROM te_ba_batch AS b INNER JOIN leads_cstm as lc on lc.te_ba_batch_id_c=b.id INNER JOIN leads as l on l.id=lc.id_c WHERE l.deleted=0 AND l.status='Converted' AND lc.te_ba_batch_id_c='".$row['id']."' $where";
				$LeadConObj =$db->query($LeadConSql);
				$LeadConRes = $db->fetchByAssoc($LeadConObj);
				$total_lead_con=0;
				$total_cost=0;
				if($LeadConRes['total_lead_con']){
					$total_lead_con = $LeadConRes['total_lead_con'];
				}
				if($actualPlanRes['total_cost']){
					$total_cost = $actualPlanRes['total_cost'];
				}
				$batchOptions[]=array('name'=>$row['name'],'id'=>$row['id'],'batch_total_cost'=>$total_cost,'fees_inr'=>$row['fees_inr'],'batch_status'=>$row['batch_status'],'total_lead_con'=>$total_lead_con);
			}

			$batches = $batchOptions;

			$batchVendorArr = array();
			if($batches && $vendors){
				foreach($batches as $batchval){
					foreach ($vendors as $vendorsVal) {
						$batchVendorArr[]=array(
							'batch_id'=>$batchval['id'],
							'batch_name'=>$batchval['name'],
							'fees_inr'=>$batchval['fees_inr'],
							'batch_status'=>$batchval['batch_status'],
							'vendor_id'=>$vendorsVal['id'],
							'vendor_name'=>$vendorsVal['name'],
							'vendor_cost'=>$vendorsVal['total_cost'],
							'vendor_con'=>$vendorsVal['vendor_con'],
							'batch_cost'=>$batchval['batch_total_cost'],
							'batch_con' => $batchval['total_lead_con']
						);
					}
				}

			}

			if(isset($_POST['export']) && $_POST['export']=="Export") {
				$councelorList = array();
				if($batchVendorArr){
					foreach ($batchVendorArr as $value) {
						$where_lead =" AND  l.vendor='".$value['vendor_name']."' AND lc.te_ba_batch_id_c='".$value['batch_id']."' $where";
						$leadSql="SELECT count(l.id) as total,l.status FROM leads l INNER JOIN leads_cstm lc ON l.id=lc.id_c where l.deleted=0 $where_lead GROUP BY l.status";
						$leadObj =$db->query($leadSql);

						$data['Alive'] = 0;
						$data['Converted'] = 0;
						$data['Dead'] = 0;
						$data['Duplicate'] = 0;
						$data['Warm'] = 0;
						while($row =$db->fetchByAssoc($leadObj)){
							$data[$row['status']]=$row['total'];
						}
						$total = $data['Alive'] +	$data['Converted'] + $data['Dead'] + $data['Duplicate'] + $data['Warm'];
						$validity = $total - $data['Dead'];
						$validity_per = ($validity && $total?($validity/$total)*100:0.00);
						$validity_per = number_format((float)$validity_per, 2, '.', '');
						$gsv = number_format($data['Converted']*$value['fees_inr']);
						$conversion_rate = ($data['Converted'] && $total?($data['Converted']/$total)*100:0.00);
						$conversion_rate = number_format((float)$conversion_rate, 2, '.', '');

						$councelorList[$index]['id'] = $value['vendor_id'];
						$councelorList[$index]['name'] = $value['vendor_name'];
						$councelorList[$index]['vendor'] = $value['vendor_name'];
						$councelorList[$index]['total_leads'] = $total;
						$councelorList[$index]['batch'] = $value['batch_name'];
						$councelorList[$index]['course_fee'] = number_format($value['fees_inr']);
						$councelorList[$index]['batch_status'] = $GLOBALS['app_list_strings']['batch_status_list'][$value['batch_status']];
						$councelorList[$index]['registered']=$data['Converted'];
						$councelorList[$index]['lead_validity'] = $validity;
						$councelorList[$index]['lead_validity_per'] = $validity_per;
						$councelorList[$index]['revenue'] =$gsv;
						$councelorList[$index]['conversion_rate'] = $conversion_rate;

						$actualCampaignData=$this->getActualPlanByVendor($value['vendor_id'],$value['batch_id'],$whereactual);
						$councelorList[$index]['spend']=($actualCampaignData['total_cost']?$actualCampaignData['total_cost']:0);
						$councelorList[$index]['cpl']= ($actualCampaignData['total_cost'] && $total?number_format($actualCampaignData['total_cost']/$total,2):0);
						$councelorList[$index]['cpa']=($actualCampaignData['total_cost'] && $councelorList[$index]['registered']?number_format($actualCampaignData['total_cost']/$councelorList[$index]['registered']):0);
						$councelorList[$index]['cpa_percent']=($councelorList[$index]['course_fee'] && $councelorList[$index]['cpa']?number_format((($councelorList[$index]['course_fee']/$councelorList[$index]['cpa'])*100),2):0);

						$source_cpa_percent = ($value['vendor_cost']/$value['vendor_con']);
						if($value['vendor_cost']==0 || $value['vendor_con']==0){
							$source_cpa_percent = 0;
						}
						$councelorList[$index]['source_cpa_percent']=number_format($source_cpa_percent,2);

						$batch_cpa_percent = ($value['batch_cost']/$value['batch_con']);
						if($value['batch_cost']==0 || $value['batch_con']==0){
							$batch_cpa_percent = 0;
						}
						$councelorList[$index]['course_cpa_percent']=number_format($batch_cpa_percent,2);



						$index++;
					}
				}
				$data="Vendor,Course,Total_Leads,Registered,Leads_Validity,Leads_Validity%,Spend,Conversion_Rate,CPL,CPA,Course_Fee,CPA%,GSV,Source_CPA,Course_CPA,Status\n";
				$file = "daily_report";
				$filename = $file . "_" . date ( "Y-m-d");

				foreach($councelorList as $vendors){
					$data.= "\"" . $vendors['vendor'] . "\",\"" . $vendors['batch'] . "\",\"" . $vendors['total_leads']."\",\"" . $vendors['registered']."\",\"". $vendors['lead_validity']."\",\"" . $vendors['lead_validity_per']."\",\"" . $vendors['spend']."\",\"" . $vendors['conversion_rate']."\",\"" . $vendors['cpl']."\",\"" . $vendors['cpa']."\",\"" . $vendors['course_fee']."\",\"" .$vendors['cpa_percent']."\",\"" . $vendors['revenue']."\",\"" . $vendors['source_cpa_percent']."\",\"" . $vendors['course_cpa_percent']."\",\"" . $vendors['batch_status']. "\"\n";
				}
				ob_end_clean();
				header("Content-type: application/csv");
				header ('Content-disposition: attachment;filename=" '. $filename . '.csv";' );
				echo $data;exit;
			}
			elseif(isset($_POST['sendemail']) && $_POST['sendemail']=="Send Email"){
				$councelorList = array();
				if($batchVendorArr){
					foreach ($batchVendorArr as $value) {
						$where_lead =" AND  l.vendor='".$value['vendor_name']."' AND lc.te_ba_batch_id_c='".$value['batch_id']."' $where";
						$leadSql="SELECT count(l.id) as total,l.status FROM leads l INNER JOIN leads_cstm lc ON l.id=lc.id_c where l.deleted=0 $where_lead GROUP BY l.status";
						$leadObj =$db->query($leadSql);

						$data['Alive'] = 0;
						$data['Converted'] = 0;
						$data['Dead'] = 0;
						$data['Duplicate'] = 0;
						$data['Warm'] = 0;
						while($row =$db->fetchByAssoc($leadObj)){
							$data[$row['status']]=$row['total'];
						}
						$total = $data['Alive'] +	$data['Converted'] + $data['Dead'] + $data['Duplicate'] + $data['Warm'];
						$validity = $total - $data['Dead'];
						$validity_per = ($validity && $total?($validity/$total)*100:0.00);
						$validity_per = number_format((float)$validity_per, 2, '.', '');
						$gsv = number_format($data['Converted']*$value['fees_inr']);
						$conversion_rate = ($data['Converted'] && $total?($data['Converted']/$total)*100:0.00);
						$conversion_rate = number_format((float)$conversion_rate, 2, '.', '');

						$councelorList[$index]['id'] = $value['vendor_id'];
						$councelorList[$index]['name'] = $value['vendor_name'];
						$councelorList[$index]['vendor'] = $value['vendor_name'];
						$councelorList[$index]['total_leads'] = $total;
						$councelorList[$index]['batch'] = $value['batch_name'];
						$councelorList[$index]['course_fee'] = number_format($value['fees_inr']);
						$councelorList[$index]['batch_status'] = $GLOBALS['app_list_strings']['batch_status_list'][$value['batch_status']];
						$councelorList[$index]['registered']=$data['Converted'];
						$councelorList[$index]['lead_validity'] = $validity;
						$councelorList[$index]['lead_validity_per'] = $validity_per;
						$councelorList[$index]['revenue'] =$gsv;
						$councelorList[$index]['conversion_rate'] = $conversion_rate;

						$actualCampaignData=$this->getActualPlanByVendor($value['vendor_id'],$value['batch_id'],$whereactual);
						$councelorList[$index]['spend']=($actualCampaignData['total_cost']?$actualCampaignData['total_cost']:0);
						$councelorList[$index]['cpl']= ($actualCampaignData['total_cost'] && $total?number_format($actualCampaignData['total_cost']/$total,2):0);
						$councelorList[$index]['cpa']=($actualCampaignData['total_cost'] && $councelorList[$index]['registered']?number_format($actualCampaignData['total_cost']/$councelorList[$index]['registered']):0);
						$councelorList[$index]['cpa_percent']=($councelorList[$index]['course_fee'] && $councelorList[$index]['cpa']?number_format((($councelorList[$index]['course_fee']/$councelorList[$index]['cpa'])*100),2):0);

						$source_cpa_percent = ($value['vendor_cost']/$value['vendor_con']);
						if($value['vendor_cost']==0 || $value['vendor_con']==0){
							$source_cpa_percent = 0;
						}
						$councelorList[$index]['source_cpa_percent']=number_format($source_cpa_percent,2);

						$batch_cpa_percent = ($value['batch_cost']/$value['batch_con']);
						if($value['batch_cost']==0 || $value['batch_con']==0){
							$batch_cpa_percent = 0;
						}
						$councelorList[$index]['course_cpa_percent']=number_format($batch_cpa_percent,2);
						$index++;
					}
					$template='<table cellpadding="0" cellspacing="0" width="100%" border="1">
					<tr height="20">
						<th><strong>Vendor</strong></th><th><strong>Course</strong></th><th><strong>Total Leads</strong></th>
						<th><strong>Registered</strong></th><th><strong>Leads Validity</strong></th><th><strong>Leads Validity%</strong></th><th><strong>Spend</strong></th><th>
						<strong>Conversion Rate</strong></th>
						<th><strong>CPL</strong></th><th><strong>CPA</strong></th><th><strong>Course Fee</strong></th>
						<th><strong>CPA%</strong></th><th><strong>GSV</strong></th><th><strong>Source CPA</strong></th>
						<th><strong>Course CPA</strong></th><th><strong>Status</strong></th>
					</tr>';
					foreach($councelorList as $vendors){
						$template.='<tr height="20"><td>'.$vendors['vendor'].'</td><td>'.$vendors['batch'].'</td><td>'.$vendors['total_leads'].'</td><td>'.$vendors['registered'].'</td><td>'.$vendors['lead_validity'].'</td><td>'.$vendors['lead_validity_per'].'</td><td>'.$vendors['spend'].'</td><td>'.$vendors['conversion_rate'].'</td><td>'.$vendors['cpl'].'</td><td>'.$vendors['cpa'].'</td><td>'.$vendors['course_fee'].'</td><td>'.$vendors['cpa_percent'].'</td><td>'.$vendors['revenue'].'</td><td>'.$vendors['source_cpa_percent'].'</td><td>'.$vendors['course_cpa_percent'].'</td><td>'.$vendors['batch_status'].'</td></tr>';
					}
					$template.="</table>";
					$recipientsSql="SELECT name,email,report FROM te_report_recipients WHERE deleted=0 AND report='Daily'";
					$recipientsObj =$db->query($recipientsSql);
					$recipients="";
					while($row =$db->fetchByAssoc($recipientsObj)){
						$recipients.=$row['email'].",";
					}
					if($recipients!=""){
						$recipients=substr($recipients,0,-1);
						$mail = new NetCoreEmail();
					  $mail->sendEmail($recipients,"Daily Report",$template);
					}
				}

			}
			#Custom Pagination
			$total=count($batchVendorArr); #total records
			$start=0;
			$per_page=10;
			$page=1;
			$leftpage=0;
			$last_page=ceil($total/$per_page);

			if(isset($_REQUEST['page'])&&$_REQUEST['page']>0){
				$start=$per_page*($_REQUEST['page']-1);
				$page=($_REQUEST['page']+1);
			}else{
				$page++;
			}
			if(($start+$per_page)<$total){
				$right=1;
			}else{
				$right=0;
			}
			if(isset($_REQUEST['page'])&&$_REQUEST['page']==1){
				$left=0;
			}elseif(isset($_REQUEST['page'])){
				$page=($_REQUEST['page']+1);
				$leftpage = ($_REQUEST['page']-1);
				$left=1;
			}
			$batchVendorArr=array_slice($batchVendorArr,$start,$per_page);
			if($total>$per_page){
				$current="(".($start+1)."-".($start+$per_page)." of ".$total.")";
			}else{
				$current="(".($start+1)."-".count($batchVendorArr)." of ".$total.")";
			}

			# Pagination end

			$councelorList = array();
			if($batchVendorArr){
				foreach ($batchVendorArr as $value) {
					$where_lead =" AND  l.vendor='".$value['vendor_name']."' AND lc.te_ba_batch_id_c='".$value['batch_id']."' $where";
					//echo $where_lead.'<br>';
					$leadSql="SELECT count(l.id) as total,l.status FROM leads l INNER JOIN leads_cstm lc ON l.id=lc.id_c where l.deleted=0 $where_lead GROUP BY l.status";
					$leadObj =$db->query($leadSql);

					$data['Alive'] = 0;
					$data['Converted'] = 0;
					$data['Dead'] = 0;
					$data['Duplicate'] = 0;
					$data['Warm'] = 0;
					while($row =$db->fetchByAssoc($leadObj)){
						$data[$row['status']]=$row['total'];
					}
					$total = $data['Alive'] +	$data['Converted'] + $data['Dead'] + $data['Duplicate'] + $data['Warm'];
					$validity = $total - $data['Dead'];
					$validity_per = ($validity && $total?($validity/$total)*100:0.00);
					$validity_per = number_format((float)$validity_per, 2, '.', '');
					$gsv = number_format($data['Converted']*$value['fees_inr']);
					$conversion_rate = ($data['Converted'] && $total?($data['Converted']/$total)*100:0.00);
					$conversion_rate = number_format((float)$conversion_rate, 2, '.', '');

					$councelorList[$index]['id'] = $value['vendor_id'];
					$councelorList[$index]['name'] = $value['vendor_name'];
					$councelorList[$index]['vendor'] = $value['vendor_name'];
					$councelorList[$index]['total_leads'] = $total;
					$councelorList[$index]['batch'] = $value['batch_name'];
					$councelorList[$index]['course_fee'] = number_format($value['fees_inr']);
					$councelorList[$index]['batch_status'] = $GLOBALS['app_list_strings']['batch_status_list'][$value['batch_status']];
					$councelorList[$index]['registered']=$data['Converted'];
					$councelorList[$index]['lead_validity'] = $validity;
					$councelorList[$index]['lead_validity_per'] = $validity_per;
					$councelorList[$index]['revenue'] =$gsv;
					$councelorList[$index]['conversion_rate'] = $conversion_rate;

					$actualCampaignData=$this->getActualPlanByVendor($value['vendor_id'],$value['batch_id'],$whereactual);
					$councelorList[$index]['spend']=($actualCampaignData['total_cost']?$actualCampaignData['total_cost']:0);
					$councelorList[$index]['cpl']= ($actualCampaignData['total_cost'] && $total?number_format($actualCampaignData['total_cost']/$total,2):0);
					$councelorList[$index]['cpa']=($actualCampaignData['total_cost'] && $councelorList[$index]['registered']?number_format($actualCampaignData['total_cost']/$councelorList[$index]['registered']):0);
					$councelorList[$index]['cpa_percent']=($councelorList[$index]['course_fee'] && $councelorList[$index]['cpa']?number_format((($councelorList[$index]['course_fee']/$councelorList[$index]['cpa'])*100),2):0);

					$source_cpa_percent = ($value['vendor_cost']/$value['vendor_con']);
					if($value['vendor_cost']==0 || $value['vendor_con']==0){
						$source_cpa_percent = 0;
					}
					$councelorList[$index]['source_cpa_percent']=number_format($source_cpa_percent,2);

					$batch_cpa_percent = ($value['batch_cost']/$value['batch_con']);
					if($value['batch_cost']==0 || $value['batch_con']==0){
						$batch_cpa_percent = 0;
					}
					$councelorList[$index]['course_cpa_percent']=number_format($batch_cpa_percent,2);



					$index++;
				}
			}


		$sugarSmarty = new Sugar_Smarty();
		$sugarSmarty->assign("batchList",$batchList);
		$sugarSmarty->assign("vendorOptionList",$vendorList);
		$sugarSmarty->assign("batchStatusList",$batchStatusList);
		$sugarSmarty->assign("reportDataList",$councelorList);
		$sugarSmarty->assign("selected_batch",$selected_course);
		$sugarSmarty->assign("selected_vendor",$selected_vendor);
		$sugarSmarty->assign("selected_status",$selected_status);
		$sugarSmarty->assign("selected_from_date",$selected_from_date);
		$sugarSmarty->assign("selected_to_date",$selected_to_date);
		$sugarSmarty->assign("current_records",$current);
		$sugarSmarty->assign("page",$page);
		$sugarSmarty->assign("right",$right);
		$sugarSmarty->assign("leftpage",$leftpage);
		$sugarSmarty->assign("left",$left);
		$sugarSmarty->assign("last_page",$last_page);
		$sugarSmarty->display('custom/modules/AOR_Reports/tpls/dailyreport.tpl');
	}
}
?>

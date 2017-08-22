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
			if(isset($_POST['button']) || isset($_POST['export']) || isset($_POST['sendemail'])) {
					$_SESSION['dsr_vendor'] = $_POST['vendor'];
					$_SESSION['dsr_course'] = $_POST['course'];
					$_SESSION['dsr_from_date'] = $_POST['from_date'];
					$_SESSION['dsr_to_date'] = $_POST['to_date'];
			}

			if(isset($_SESSION['dsr_vendor']) && !empty($_SESSION['dsr_vendor'])){
				$selected_vendor = $_SESSION['dsr_vendor'];
				$whereVendor = " AND v.id='".$_SESSION['dsr_vendor']."' ";
				$whereAll.=" AND l.vendor=(select name from te_vendor where id='".$_SESSION['dsr_vendor']."') ";
			}
			if(isset($_SESSION['dsr_course']) && !empty($_SESSION['dsr_course'])){
				$selected_course = $_SESSION['dsr_course'];
				$whereCourse = " AND b.id='".$_SESSION['dsr_course']."' ";
				$whereAll.=" AND lc.te_ba_batch_id_c='".$_SESSION['dsr_course']."' ";
			}
			if(isset($_SESSION['dsr_from_date']) && !empty($_SESSION['dsr_from_date'])){
				$selected_from_date = $_SESSION['dsr_from_date'];
				$where.=" AND DATE(l.date_entered)>='".date('Y-m-d',strtotime($selected_from_date))."' ";
				$whereactual.=" AND DATE(a.plan_date)>='".date('Y-m-d',strtotime($selected_from_date))."' ";
				$filterwhere.=" AND DATE(te_actual_campaign.plan_date)>='".date('Y-m-d',strtotime($selected_from_date))."' ";
				$whereAll.=" AND DATE(l.date_entered)>='".date('Y-m-d',strtotime($selected_from_date))."' ";
			}
			if(isset($_SESSION['dsr_to_date']) && !empty($_SESSION['dsr_to_date'])){
				$selected_to_date = $_SESSION['dsr_to_date'];
				$where.=" AND DATE(l.date_entered)<='".date('Y-m-d',strtotime($selected_to_date))."'";
				$whereactual.=" AND DATE(a.plan_date)<='".date('Y-m-d',strtotime($selected_to_date))."' ";
				$filterwhere.=" AND DATE(te_actual_campaign.plan_date)<='".date('Y-m-d',strtotime($selected_to_date))."' ";
				$whereAll.=" AND DATE(l.date_entered)<='".date('Y-m-d',strtotime($selected_to_date))."'";
			}

			//$vendorSql="SELECT v.name,v.id,count(l.id)total_con FROM `te_vendor` AS v LEFT JOIN leads AS l ON l.vendor=v.name AND l.status='Converted' AND l.deleted=0 $where WHERE v.deleted=0 $whereVendor  group by v.name order by v.name asc";
			$vendorSql="SELECT v.name, v.id, COUNT(l.id) total_con, ( SELECT sum(te_actual_campaign.total_cost) from te_actual_campaign where te_actual_campaign.vendor_id=v.id $filterwhere) as total_cost FROM `te_vendor` AS v LEFT JOIN leads AS l ON l.vendor = v.name AND l.status = 'Converted' AND l.deleted = 0 LEFT JOIN te_actual_campaign AS a ON v.id=a.vendor_id AND a.type = 'paid' AND a.deleted = 0 WHERE v.deleted = 0 $whereVendor GROUP BY v.id ORDER BY v.name ASC";
			$vendorObj =$db->query($vendorSql);
			$vendorArr = [];
			while($vendor =$db->fetchByAssoc($vendorObj)){
				$vendorGSVSql="SELECT SUM(X.total_cost)total_gsv FROM (SELECT (COUNT(l.id)*b.fees_inr)total_cost FROM leads l INNER JOIN leads_cstm AS lc ON l.id=lc.id_c INNER JOIN te_ba_batch AS b ON b.id=lc.te_ba_batch_id_c WHERE l.vendor='".$vendor["name"]."' AND l.status='Converted' GROUP BY lc.te_ba_batch_id_c)X";
				$vendorGSVObj =$db->query($vendorGSVSql);
				$vendorGSV =$db->fetchByAssoc($vendorGSVObj);
				$total_lead_con = ($vendor['total_con']?$vendor['total_con']:0);
				$total_cost = ($vendor['total_cost']?$vendor['total_cost']:0);
				$total_gsv = ($vendorGSV['total_gsv']?$vendorGSV['total_gsv']:0);
				$vendorArr[]=array('name'=>$vendor['name'],'id'=>$vendor['id'],'total_cost'=>$total_cost,'vendor_con'=>$total_lead_con,'total_gsv'=>$total_gsv);
			}
			$vendors = $vendorArr;
			$batchSql="SELECT b.name,b.id,b.fees_inr,b.batch_status,( SELECT sum(te_actual_campaign.total_cost) from te_actual_campaign where te_actual_campaign.te_ba_batch_id_c=b.id AND te_actual_campaign.type='paid' AND te_actual_campaign.deleted=0 ) as total_cost,(SELECT count(leads.id) FROM leads INNER JOIN leads_cstm ON leads_cstm.id_c=leads.id WHERE leads_cstm.te_ba_batch_id_c=b.id AND leads.status='Converted' AND leads.deleted=0)total_con from te_ba_batch AS b where b.deleted=0 $whereCourse group by b.id ORDER BY b.name ASC";
			$batchObj =$db->query($batchSql);
			$batchOptions=array();
			while($row =$db->fetchByAssoc($batchObj)){

				$total_lead_con=($row['total_con']?$row['total_con']:0);
				$total_cost=($row['total_cost']?$row['total_cost']:0);

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
							'vendor_name'=>strtolower($vendorsVal['name']),
							'vendor_cost'=>$vendorsVal['total_cost'],
							'vendor_con'=>$vendorsVal['vendor_con'],
							'batch_cost'=>$batchval['batch_total_cost'],
							'batch_con' => $batchval['total_lead_con'],
							'vendor_gsv'=>$vendorsVal['total_gsv']
						);
					}
				}
				//echo "<pre>";print_r($batchVendorArr);exit();

			}

			if(isset($_POST['export']) && $_POST['export']=="Export") {
				$councelorList = array();
				if($batchVendorArr){
					foreach ($batchVendorArr as $value) {
						$councelorList[$value['batch_name']][$value['vendor_name']]['course_fee'] = $value['fees_inr'];
						$councelorList[$value['batch_name']][$value['vendor_name']]['batch_status'] = $GLOBALS['app_list_strings']['batch_status_list'][$value['batch_status']];
						$councelorList[$value['batch_name']][$value['vendor_name']]['Fallout'] = 0;
						$councelorList[$value['batch_name']][$value['vendor_name']]['New_Lead'] = 0;
						$councelorList[$value['batch_name']][$value['vendor_name']]['Prospect'] = 0;
						$councelorList[$value['batch_name']][$value['vendor_name']]['Ringing_Multiple_Times'] = 0;
						$councelorList[$value['batch_name']][$value['vendor_name']]['Follow_Up'] = 0;
						$councelorList[$value['batch_name']][$value['vendor_name']]['Not_Eligible'] = 0;
						$councelorList[$value['batch_name']][$value['vendor_name']]['Duplicate'] = 0;
						$councelorList[$value['batch_name']][$value['vendor_name']]['Not_Enquired'] = 0;
						$councelorList[$value['batch_name']][$value['vendor_name']]['Dead_Number'] = 0;
						$councelorList[$value['batch_name']][$value['vendor_name']]['Retired'] = 0;
						$councelorList[$value['batch_name']][$value['vendor_name']]['Wrong_Number'] = 0;
						$councelorList[$value['batch_name']][$value['vendor_name']]['Call_Back'] = 0;
						$councelorList[$value['batch_name']][$value['vendor_name']]['No_Answer'] = 0;
						$councelorList[$value['batch_name']][$value['vendor_name']]['Re_Enquired'] = 0;
						$councelorList[$value['batch_name']][$value['vendor_name']]['Converted'] = 0;
						$councelorList[$value['batch_name']][$value['vendor_name']]['Rejected'] = 0;
						$councelorList[$value['batch_name']][$value['vendor_name']]['Dropout'] = 0;
						$councelorList[$value['batch_name']][$value['vendor_name']]['spend'] = 0;

						$s_cpa_per = 0.00;
						$source_cpa_percent = (round($value['vendor_cost'])/round($value['vendor_gsv']));
						if($value['vendor_cost']==0 || $value['vendor_gsv']==0){
							$source_cpa_percent = 0;
						}
						if($source_cpa_percent){
							$s_cpa_per = round(($source_cpa_percent*100),2);
						}
						$councelorList[$value['batch_name']][$value['vendor_name']]['source_cpa_percent']=$s_cpa_per;

						$c_cpa_per = 0.00;
						$batch_cpa_percent = (round($value['batch_cost'])/(round($value['batch_con'])*round($value['fees_inr'])));
						if($value['batch_cost']==0 || $value['batch_con']==0){
							$batch_cpa_percent = 0;
						}
						if($batch_cpa_percent){
							$c_cpa_per = round(($batch_cpa_percent*100),2);
						}
						$councelorList[$value['batch_name']][$value['vendor_name']]['course_cpa_percent']=$c_cpa_per;
					}

					$leadSql="SELECT COUNT(l.id)total,l.status_description,l.vendor,(SELECT name FROM te_ba_batch WHERE te_ba_batch.id=lc.te_ba_batch_id_c)batch,(SELECT SUM(total_cost) FROM te_actual_campaign as a WHERE a.te_ba_batch_id_c=lc.te_ba_batch_id_c  AND a.vendor_id=(SELECT id FROM te_vendor WHERE name=l.vendor) AND a.type='paid' AND a.deleted=0)cost FROM leads AS l INNER JOIN leads_cstm AS lc ON l.id=lc.id_c AND l.deleted=0 WHERE l.vendor!='' AND lc.te_ba_batch_id_c!='' $whereAll GROUP BY l.vendor,lc.te_ba_batch_id_c,l.status_description ORDER BY batch ASC,l.vendor ASC";
					$leadObj =$db->query($leadSql);


					while($row =$db->fetchByAssoc($leadObj)){
						$row['status_description'] = str_replace(array(' ','-'),'_',$row['status_description']);
						$councelorList[$row['batch']][strtolower($row['vendor'])][$row['status_description']]=$row['total'];
						$councelorList[$row['batch']][[strtolower($row['vendor'])]]['spend']=($row['cost']?$row['cost']:0);
					}
				}
				//echo "<pre>";print_r($councelorList);exit();
				$data="Vendor,Course,Total_Leads,Registered,Leads_Validity,Leads_Validity%,Spend,Conversion_Rate,CPL,CPA,Course_Fee,CPA%,GSV,Source_CPA%,Course_CPA%,Status\n";
				$file = "daily_report";
				$filename = $file . "_" . date ( "Y-m-d");
				foreach($councelorList as $key=>$vendorsval){
					foreach($vendorsval as $vendorskey=>$vendors){
						$total = $vendors['Dropout'] +	$vendors['Rejected'] + $vendors['Converted'] + $vendors['Re_Enquired'] + $vendors['No_Answer']+ $vendors['Call_Back']+ $vendors['Wrong_Number']+ $vendors['Retired']+ $vendors['Dead_Number']+ $vendors['Not_Enquired']+ $vendors['Duplicate']+ $vendors['Not_Eligible']+ $vendors['Follow_Up']+ $vendors['Ringing_Multiple_Times']+ $vendors['Prospect']+ $vendors['New_Lead']+ $vendors['Fallout'];
						$validity = $vendors['Dropout'] + $vendors['Fallout']+$vendors['Retired']+$vendors['Converted']+$vendors['Call_Back']+$vendors['Follow_Up']+$vendors['Prospect']+$vendors['New_Lead'];

						$validity_per = ($validity && $total?($validity/$total)*100:0.00);
						$validity_per = number_format((float)$validity_per, 2, '.', '');
						$gsv = number_format($vendors['Converted']*$vendors['course_fee']);
						$conversion_rate = ($vendors['Converted'] && $total?($vendors['Converted']/$total)*100:0.00);
						$conversion_rate = number_format((float)$conversion_rate, 2, '.', '');
						$cpl= ($vendors['spend'] && $total?number_format($vendors['spend']/$total,2):0);
						$cpa=($vendors['spend'] && $vendors['Converted']?number_format($vendors['spend']/$vendors['Converted']):0);
						$cpa_percent=($vendors['spend'] && $gsv?(($vendors['spend']/str_replace(',','',$gsv))*100):0);
						if($total>0){
							$data.= "\"" . $vendorskey . "\",\"" . $key . "\",\"" . $total."\",\"" . $vendors['Converted']."\",\"". $validity."\",\"" . $validity_per."\",\"" . $vendors['spend']."\",\"" . $conversion_rate."\",\"" . $cpl."\",\"" . $cpa."\",\"" . number_format($vendors['course_fee'])."\",\"" .$cpa_percent."\",\"" . $gsv."\",\"" . $vendors['source_cpa_percent']."\",\"" . $vendors['course_cpa_percent']."\",\"" . $vendors['batch_status']. "\"\n";
						}

					}
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
  						$councelorList[$value['batch_name']][$value['vendor_name']]['course_fee'] = $value['fees_inr'];
  						$councelorList[$value['batch_name']][$value['vendor_name']]['batch_status'] = $GLOBALS['app_list_strings']['batch_status_list'][$value['batch_status']];
  						$councelorList[$value['batch_name']][$value['vendor_name']]['Fallout'] = 0;
  						$councelorList[$value['batch_name']][$value['vendor_name']]['New_Lead'] = 0;
  						$councelorList[$value['batch_name']][$value['vendor_name']]['Prospect'] = 0;
  						$councelorList[$value['batch_name']][$value['vendor_name']]['Ringing_Multiple_Times'] = 0;
  						$councelorList[$value['batch_name']][$value['vendor_name']]['Follow_Up'] = 0;
  						$councelorList[$value['batch_name']][$value['vendor_name']]['Not_Eligible'] = 0;
  						$councelorList[$value['batch_name']][$value['vendor_name']]['Duplicate'] = 0;
  						$councelorList[$value['batch_name']][$value['vendor_name']]['Not_Enquired'] = 0;
  						$councelorList[$value['batch_name']][$value['vendor_name']]['Dead_Number'] = 0;
  						$councelorList[$value['batch_name']][$value['vendor_name']]['Retired'] = 0;
  						$councelorList[$value['batch_name']][$value['vendor_name']]['Wrong_Number'] = 0;
  						$councelorList[$value['batch_name']][$value['vendor_name']]['Call_Back'] = 0;
  						$councelorList[$value['batch_name']][$value['vendor_name']]['No_Answer'] = 0;
  						$councelorList[$value['batch_name']][$value['vendor_name']]['Re_Enquired'] = 0;
  						$councelorList[$value['batch_name']][$value['vendor_name']]['Converted'] = 0;
  						$councelorList[$value['batch_name']][$value['vendor_name']]['Rejected'] = 0;
  						$councelorList[$value['batch_name']][$value['vendor_name']]['Dropout'] = 0;
  						$councelorList[$value['batch_name']][$value['vendor_name']]['spend'] = 0;

  						$s_cpa_per = 0.00;
  						$source_cpa_percent = (round($value['vendor_cost'])/round($value['vendor_gsv']));
  						if($value['vendor_cost']==0 || $value['vendor_gsv']==0){
  							$source_cpa_percent = 0;
  						}
  						if($source_cpa_percent){
  							$s_cpa_per = round(($source_cpa_percent*100),2);
  						}
  						$councelorList[$value['batch_name']][$value['vendor_name']]['source_cpa_percent']=$s_cpa_per;

  						$c_cpa_per = 0.00;
  						$batch_cpa_percent = (round($value['batch_cost'])/(round($value['batch_con'])*round($value['fees_inr'])));
  						if($value['batch_cost']==0 || $value['batch_con']==0){
  							$batch_cpa_percent = 0;
  						}
  						if($batch_cpa_percent){
  							$c_cpa_per = round(($batch_cpa_percent*100),2);
  						}
  						$councelorList[$value['batch_name']][$value['vendor_name']]['course_cpa_percent']=$c_cpa_per;
				  }
					$leadSql="SELECT COUNT(l.id)total,l.status_description,l.vendor,(SELECT name FROM te_ba_batch WHERE te_ba_batch.id=lc.te_ba_batch_id_c)batch,(SELECT SUM(total_cost) FROM te_actual_campaign as a WHERE a.te_ba_batch_id_c=lc.te_ba_batch_id_c  AND a.vendor_id=(SELECT id FROM te_vendor WHERE name=l.vendor) AND a.type='paid' AND a.deleted=0)cost FROM leads AS l INNER JOIN leads_cstm AS lc ON l.id=lc.id_c AND l.deleted=0 WHERE l.vendor!='' AND lc.te_ba_batch_id_c!='' $whereAll GROUP BY l.vendor,lc.te_ba_batch_id_c,l.status_description ORDER BY batch ASC,l.vendor ASC";
					$leadObj =$db->query($leadSql);


					while($row =$db->fetchByAssoc($leadObj)){
						$row['status_description'] = str_replace(array(' ','-'),'_',$row['status_description']);
						$councelorList[$row['batch']][$row['vendor']][$row['status_description']]=$row['total'];
						$councelorList[$row['batch']][$row['vendor']]['spend']=($row['cost']?$row['cost']:0);
					}
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
			  foreach($councelorList as $key=>$vendorsval){
			    foreach($vendorsval as $vendorskey=>$vendors){
			      $total = $vendors['Alive']+$vendors['Converted']+$vendors['Dead']+$vendors['Warm']+$vendors['Duplicate'];
			      $validity = $total - ($vendors['Dead']+$vendors['Duplicate']);
			      $validity_per = ($validity && $total?($validity/$total)*100:0.00);
			      $validity_per = number_format((float)$validity_per, 2, '.', '');
			      $gsv = number_format($vendors['Converted']*$vendors['course_fee']);
			      $conversion_rate = ($vendors['Converted'] && $total?($vendors['Converted']/$total)*100:0.00);
			      $conversion_rate = number_format((float)$conversion_rate, 2, '.', '');
			      $cpl= ($vendors['spend'] && $total?number_format($vendors['spend']/$total,2):0);
			      $cpa=($vendors['spend'] && $vendors['Converted']?number_format($vendors['spend']/$vendors['Converted']):0);
			      $cpa_percent=($vendors['spend'] && $gsv?(($vendors['spend']/str_replace(',','',$gsv))*100):0);

			      $template.='<tr height="20"><td>'.$vendorskey.'</td><td>'.$key.'</td><td>'.$total.'</td><td>'.$vendors['Converted'].'</td><td>'.$validity.'</td><td>'.$validity_per.'</td><td>'.$vendors['spend'].'</td><td>'.$conversion_rate.'</td><td>'.$cpl.'</td><td>'.$cpa.'</td><td>'.round($vendors['course_fee'],2).'</td><td>'.$cpa_percent.'</td><td>'.$gsv.'</td><td>'.$vendors['source_cpa_percent'].'</td><td>'.$vendors['course_cpa_percent'].'</td><td>'.$vendors['batch_status'].'</td></tr>';
			    }
			  }
				//echo $template;exit();
			}

			$councelorList = array();
			if($batchVendorArr){
				foreach ($batchVendorArr as $value) {
					$councelorList[$value['batch_name']][$value['vendor_name']]['course_fee'] = $value['fees_inr'];
					$councelorList[$value['batch_name']][$value['vendor_name']]['batch_status'] = $GLOBALS['app_list_strings']['batch_status_list'][$value['batch_status']];
					$councelorList[$value['batch_name']][$value['vendor_name']]['Fallout'] = 0;
					$councelorList[$value['batch_name']][$value['vendor_name']]['New_Lead'] = 0;
					$councelorList[$value['batch_name']][$value['vendor_name']]['Prospect'] = 0;
					$councelorList[$value['batch_name']][$value['vendor_name']]['Ringing_Multiple_Times'] = 0;
					$councelorList[$value['batch_name']][$value['vendor_name']]['Follow_Up'] = 0;
					$councelorList[$value['batch_name']][$value['vendor_name']]['Not_Eligible'] = 0;
					$councelorList[$value['batch_name']][$value['vendor_name']]['Duplicate'] = 0;
					$councelorList[$value['batch_name']][$value['vendor_name']]['Not_Enquired'] = 0;
					$councelorList[$value['batch_name']][$value['vendor_name']]['Dead_Number'] = 0;
					$councelorList[$value['batch_name']][$value['vendor_name']]['Retired'] = 0;
					$councelorList[$value['batch_name']][$value['vendor_name']]['Wrong_Number'] = 0;
					$councelorList[$value['batch_name']][$value['vendor_name']]['Call_Back'] = 0;
					$councelorList[$value['batch_name']][$value['vendor_name']]['No_Answer'] = 0;
					$councelorList[$value['batch_name']][$value['vendor_name']]['Re_Enquired'] = 0;
					$councelorList[$value['batch_name']][$value['vendor_name']]['Converted'] = 0;
					$councelorList[$value['batch_name']][$value['vendor_name']]['Rejected'] = 0;
					$councelorList[$value['batch_name']][$value['vendor_name']]['Dropout'] = 0;
					$councelorList[$value['batch_name']][$value['vendor_name']]['spend'] = 0;

					$s_cpa_per = 0.00;
					$source_cpa_percent = (round($value['vendor_cost'])/round($value['vendor_gsv']));
					if($value['vendor_cost']==0 || $value['vendor_gsv']==0){
						$source_cpa_percent = 0;
					}
					if($source_cpa_percent){
						$s_cpa_per = round(($source_cpa_percent*100),2);
					}
					$councelorList[$value['batch_name']][$value['vendor_name']]['source_cpa_percent']=$s_cpa_per;

					$c_cpa_per = 0.00;
					$batch_cpa_percent = (round($value['batch_cost'])/(round($value['batch_con'])*round($value['fees_inr'])));
					if($value['batch_cost']==0 || $value['batch_con']==0){
						$batch_cpa_percent = 0;
					}
					if($batch_cpa_percent){
						$c_cpa_per = round(($batch_cpa_percent*100),2);
					}
					$councelorList[$value['batch_name']][$value['vendor_name']]['course_cpa_percent']=$c_cpa_per;
				}

				$leadSql="SELECT COUNT(l.id)total,l.status_description,l.vendor,(SELECT name FROM te_ba_batch WHERE te_ba_batch.id=lc.te_ba_batch_id_c)batch,(SELECT SUM(total_cost) FROM te_actual_campaign as a WHERE a.te_ba_batch_id_c=lc.te_ba_batch_id_c  AND a.vendor_id=(SELECT id FROM te_vendor WHERE name=l.vendor) AND a.type='paid' AND a.deleted=0)cost FROM leads AS l INNER JOIN leads_cstm AS lc ON l.id=lc.id_c AND l.deleted=0 WHERE l.vendor!='' AND lc.te_ba_batch_id_c!='' $whereAll GROUP BY l.vendor,lc.te_ba_batch_id_c,l.status_description ORDER BY batch ASC,l.vendor ASC";
				$leadObj =$db->query($leadSql);


				while($row =$db->fetchByAssoc($leadObj)){
					$row['status_description'] = str_replace(array(' ','-'),'_',$row['status_description']);
					$councelorList[$row['batch']][strtolower($row['vendor'])][$row['status_description']]=$row['total'];
					$councelorList[$row['batch']][[strtolower($row['vendor'])]]['spend']=($row['cost']?$row['cost']:0);
				}
			}
			$listCouncelorArr = array();
			foreach($councelorList as $key=>$vendorsval){
				foreach($vendorsval as $vendorskey=>$vendors){
					$total = $vendors['Dropout'] +	$vendors['Rejected'] + $vendors['Converted'] + $vendors['Re_Enquired'] + $vendors['No_Answer']+ $vendors['Call_Back']+ $vendors['Wrong_Number']+ $vendors['Retired']+ $vendors['Dead_Number']+ $vendors['Not_Enquired']+ $vendors['Duplicate']+ $vendors['Not_Eligible']+ $vendors['Follow_Up']+ $vendors['Ringing_Multiple_Times']+ $vendors['Prospect']+ $vendors['New_Lead']+ $vendors['Fallout'];
					$validity = $vendors['Dropout'] + $vendors['Fallout']+$vendors['Retired']+$vendors['Converted']+$vendors['Call_Back']+$vendors['Follow_Up']+$vendors['Prospect']+$vendors['New_Lead'];

					$validity_per = ($validity && $total?($validity/$total)*100:0.00);
					$validity_per = number_format((float)$validity_per, 2, '.', '');
					$gsv = number_format($vendors['Converted']*$vendors['course_fee']);
					$conversion_rate = ($vendors['Converted'] && $total?($vendors['Converted']/$total)*100:0.00);
					$conversion_rate = number_format((float)$conversion_rate, 2, '.', '');
					$cpl= ($vendors['spend'] && $total?number_format($vendors['spend']/$total,2):0);
					$cpa=($vendors['spend'] && $vendors['Converted']?number_format($vendors['spend']/$vendors['Converted']):0);
					$cpa_percent=($vendors['spend'] && $gsv?(($vendors['spend']/str_replace(',','',$gsv))*100):0);
					if($total>0){
						$listCouncelorArr[$index]['name'] = $vendorskey;
						$listCouncelorArr[$index]['vendor'] = $vendorskey;
						$listCouncelorArr[$index]['total_leads'] = $total;
						$listCouncelorArr[$index]['batch'] = $key;
						$listCouncelorArr[$index]['course_fee'] = number_format($vendors['course_fee']);
						$listCouncelorArr[$index]['batch_status'] = $vendors['batch_status'];
						$listCouncelorArr[$index]['registered']=$vendors['Converted'];
						$listCouncelorArr[$index]['lead_validity'] = $validity;
						$listCouncelorArr[$index]['lead_validity_per'] = $validity_per;
						$listCouncelorArr[$index]['revenue'] =$gsv;
						$listCouncelorArr[$index]['conversion_rate'] = $conversion_rate;

						$listCouncelorArr[$index]['spend']=$vendors['spend'];
						$listCouncelorArr[$index]['cpl']= $cpl;
						$listCouncelorArr[$index]['cpa']=$cpa;
						$listCouncelorArr[$index]['cpa_percent']=$vendors['source_cpa_percent'];

						$listCouncelorArr[$index]['source_cpa_percent']=$vendors['source_cpa_percent'];
						$listCouncelorArr[$index]['course_cpa_percent']=$vendors['course_cpa_percent'];
						$index++;
					}

				}
			}
			#Custom Pagination
			$total=count($listCouncelorArr); #total records
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
			$listCouncelorArr=array_slice($listCouncelorArr,$start,$per_page);
			if($total>$per_page){
				$current="(".($start+1)."-".($start+$per_page)." of ".$total.")";
			}else{
				$current="(".($start+1)."-".count($listCouncelorArr)." of ".$total.")";
			}

			# Pagination end
		$sugarSmarty = new Sugar_Smarty();
		$sugarSmarty->assign("batchList",$batchList);
		$sugarSmarty->assign("vendorOptionList",$vendorList);
		$sugarSmarty->assign("batchStatusList",$batchStatusList);
		$sugarSmarty->assign("reportDataList",$listCouncelorArr);
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

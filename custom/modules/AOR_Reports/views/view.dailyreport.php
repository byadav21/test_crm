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
			$actualPlanSql=" SELECT a.total_cost,a.cpl FROM te_vendor_te_utm_1_c uvr INNER JOIN te_utm u ON uvr.te_vendor_te_utm_1te_utm_idb=u.id INNER JOIN te_actual_campaign a ON u.name=a.name WHERE uvr.te_vendor_te_utm_1te_vendor_ida='".$vendor."' AND u.te_ba_batch_id_c='".$batch."'";
		}elseif($vendor!=""&&$batch==""){
			$actualPlanSql=" SELECT a.total_cost,a.cpl FROM te_vendor_te_utm_1_c uvr INNER JOIN te_utm u ON uvr.te_vendor_te_utm_1te_utm_idb=u.id INNER JOIN te_actual_campaign a ON u.name=a.name WHERE uvr.te_vendor_te_utm_1te_vendor_ida='".$vendor."'";
		}elseif($vendor==""&&$batch!=""){
			$actualPlanSql=" SELECT a.total_cost,a.cpl FROM te_vendor_te_utm_1_c uvr INNER JOIN te_utm u ON uvr.te_vendor_te_utm_1te_utm_idb=u.id INNER JOIN te_actual_campaign a ON u.name=a.name WHERE  u.te_ba_batch_id_c='".$batch."'";
		}		
		if($search_date!=""){
			$actualPlanSql.=" AND a.date_modified LIKE '".$search_date."%'";
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
		if(isset($_POST['button']) && $_POST['button']=="Search") {
			if($_POST['vendor']!=""){
				$searchData['vendor_id']=$_POST['vendor'];
				$selected_vendor=$_POST['vendor'];
			}elseif($_POST['course']!=""&&$_POST['vendor']==""){
				$searchData['batch_id']=$_POST['course'];
				$selected_batch=$_POST['course'];
			}		
			if($_POST['course_status']!=""){
				$searchData['batch_status']=$_POST['course_status'];
				$selected_status=$_POST['course_status'];
			}
			if($_POST['search_date']!=""){
				$searchData['search_date']=$_POST['search_date'];
				$search_date=$_POST['search_date'];
			}
			$vendorListData=$this->getReportData($searchData);
			foreach($vendorListData as $vendors){
				$vendorOptionList[$index]['id']=$vendors['vendor_id'];
				$vendorOptionList[$index]['name']=$vendors['vendor'];
				$reportDataList[$index]['vendor']=$vendors['vendor'];
				$reportDataList[$index]['total_leads']=$vendors['total_leads'];
				$reportDataList[$index]['batch']=$vendors['batch'];
				$reportDataList[$index]['course_fee']=number_format($vendors['course_fee']);
				$reportDataList[$index]['batch_status']=$GLOBALS['app_list_strings']['batch_status_list'][$vendors['batch_status']];
				$leadsByStatus=$this->getLeadByStatus($vendors['vendor'],$vendors['batch_id'],$search_date);
				$reportDataList[$index]['registered']=$leadsByStatus['registered'];
				$reportDataList[$index]['lead_validity']=$leadsByStatus['invalid'];
				$reportDataList[$index]['revenue']=$this->getRevenueFromLead($vendors['vendor'],$vendors['batch_id']);
				$reportDataList[$index]['conversion_rate']=number_format((($reportDataList[$index]['registered']/$vendors['total_leads'])*100),2);
				$actualCampaignData=$this->getActualPlanByVendor($vendors['vendor_id'],$vendors['batch_id'],$search_date);
				$reportDataList[$index]['spend']=$actualCampaignData['total_cost'];
				$reportDataList[$index]['cpl']=$actualCampaignData['cpl'];
				$reportDataList[$index]['cpa']=number_format($actualCampaignData['total_cost']/$reportDataList[$index]['registered']);
				$reportDataList[$index]['cpa_percent']=number_format((($reportDataList[$index]['cpa']/$reportDataList[$index]['course_fee'])*100),2);
				#calculate source CPA & Course CPA
				$leadsByStatus=$this->getLeadByStatus($vendors['vendor'],"",$search_date); # without batch
				$registered_byvendor=$leadsByStatus['registered'];
				$actual_data_byvendor=$this->getActualPlanByVendor($vendors['vendor_id']); #without batch
				$cpa=number_format($actual_data_byvendor['total_cost']/$registered_byvendor);
				$source_cpa_percent=number_format((($cpa/$reportDataList[$index]['course_fee'])*100),2);
				$reportDataList[$index]['source_cpa_percent']=$source_cpa_percent;
				#Course CPA
				$leadsByStatus=$this->getLeadByStatus("",$vendors['batch_id'],$search_date); # without batch
				$registered_bybatch=$leadsByStatus['registered'];
				$actual_data_bybatch=$this->getActualPlanByVendor("",$vendors['batch_id'],$search_date); #without batch
				$cpa=number_format($actual_data_bybatch['total_cost']/$registered_bybatch);
				$course_cpa_percent=number_format((($cpa/$reportDataList[$index]['course_fee'])*100),2);
				$reportDataList[$index]['course_cpa_percent']=$course_cpa_percent;				
				$index++;
			}
		}elseif(isset($_POST['export']) && $_POST['export']=="Export"){
			$data="Vendor,Course,Total Leads,Registered,Leads Validity,Spend,Conversion Rate,CPL,CPA,Course Fee,CPA%,Revenue,Source CPA%,Course CPA,Status\n";
			$file = "daily_report";
			$filename = $file . "_" . date ( "Y-m-d");
			if($_POST['vendor']!=""){
				$searchData['vendor_id']=$_POST['vendor'];
				$selected_vendor=$_POST['vendor'];
			}elseif($_POST['course']!=""&&$_POST['vendor']==""){
				$searchData['batch_id']=$_POST['course'];
				$selected_batch=$_POST['course'];
			}		
			if($_POST['course_status']!=""){
				$searchData['batch_status']=$_POST['course_status'];
				$selected_status=$_POST['course_status'];
			}
			if($_POST['search_date']!=""){
				$searchData['search_date']=$_POST['search_date'];
				$search_date=$_POST['search_date'];
			}
			$vendorListData=$this->getReportData($searchData);
			foreach($vendorListData as $vendors){
				$leadsByStatus=$this->getLeadByStatus($vendors['vendor'],$vendors['batch_id'],$search_date);
				$total_registered=$leadsByStatus['registered'];
				$lead_validity=$leadsByStatus['invalid'];
				$actualCampaignData=$this->getActualPlanByVendor($vendors['vendor_id'],$vendors['batch_id'],$search_date);
				$conversion_rate=number_format((($total_registered/$vendors['total_leads'])*100),2);
				$spend=$actualCampaignData['total_cost'];
				$cpl=$actualCampaignData['cpl'];
				$course_fee=number_format($vendors['course_fee']);
				$cpa=number_format($spend/$total_registered);
				$cpa_percent=number_format((($cpa/$course_fee)*100),2);
				$revenue=$this->getRevenueFromLead($vendors['vendor'],$vendors['batch_id']);
				#calculate source CPA & Course CPA
				$leadsByStatus=$this->getLeadByStatus($vendors['vendor'],"",$search_date); # without batch
				$registered_byvendor=$leadsByStatus['registered'];
				$actual_data_byvendor=$this->getActualPlanByVendor($vendors['vendor_id'],"",$search_date); #without batch
				$cpa=number_format($actual_data_byvendor['total_cost']/$registered_byvendor);
				$source_cpa_percent=number_format((($cpa/$course_fee)*100),2);
				#Course CPA
				$leadsByStatus=$this->getLeadByStatus("",$vendors['batch_id'],$search_date); # without batch
				$registered_bybatch=$leadsByStatus['registered'];
				$actual_data_bybatch=$this->getActualPlanByVendor("",$vendors['batch_id'],$search_date); #without batch
				$cpa=number_format($actual_data_bybatch['total_cost']/$registered_bybatch);
				$course_cpa_percent=number_format((($cpa/$course_fee)*100),2);
				
				$data.= "\"" . $vendors['vendor'] . "\",\"" . $vendors['batch'] . "\",\"" . $vendors['total_leads']."\",\"" . $total_registered."\",\"". $lead_validity."\",\"" . $spend."\",\"" . $conversion_rate."\",\"" . $cpl."\",\"" . $cpa."\",\"" . number_format($vendors['course_fee'])."\",\"" . $cpa_percent."\",\"" .$revenue."\",\"" . $source_cpa_percent."\",\"" . $course_cpa_percent."\",\"" . $GLOBALS['app_list_strings']['batch_status_list'][$vendors['batch_status']]. "\"\n";			
			}
			ob_end_clean();
			header("Content-type: application/csv");
			header ('Content-disposition: attachment;filename=" '. $filename . '.csv";' );
			echo $data;exit;
			
		}elseif(isset($_POST['sendemail']) && $_POST['sendemail']=="Send Email"){
			$template='<table cellpadding="0" cellspacing="0" width="100%" border="1">
			<tr height="20">
				<th><strong>Vendor</strong></th><th><strong>Course</strong></th><th><strong>Total Leads</strong></th>
				<th><strong>Registered</strong></th><th><strong>Leads Validity</strong></th><th><strong>Spend</strong></th><th>
				<strong>Conversion Rate</strong></th>
				<th><strong>CPL</strong></th><th><strong>CPA</strong></th><th><strong>Course Fee</strong></th>
				<th><strong>CPA%</strong></th><th><strong>revenue</strong></th><th><strong>Source CPA%</strong></th>
				<th><strong>Course CPA%</strong></th><th><strong>Status</strong></th>
			</tr>';
			if($_POST['vendor']!=""){
				$searchData['vendor_id']=$_POST['vendor'];
				$selected_vendor=$_POST['vendor'];
			}elseif($_POST['course']!=""&&$_POST['vendor']==""){
				$searchData['batch_id']=$_POST['course'];
				$selected_batch=$_POST['course'];
			}		
			if($_POST['course_status']!=""){
				$searchData['batch_status']=$_POST['course_status'];
				$selected_status=$_POST['course_status'];
			}
			if($_POST['search_date']!=""){
				$searchData['search_date']=$_POST['search_date'];
				$search_date=$_POST['search_date'];
			}
			$vendorListData=$this->getReportData($searchData);
			$index=0;
			foreach($vendorListData as $vendors){
				$reportDataList[$index]['vendor']=$vendors['vendor'];
				$reportDataList[$index]['total_leads']=$vendors['total_leads'];
				$reportDataList[$index]['batch']=$vendors['batch'];
				$reportDataList[$index]['course_fee']=number_format($vendors['course_fee']);
				$reportDataList[$index]['batch_status']=$GLOBALS['app_list_strings']['batch_status_list'][$vendors['batch_status']];
				$leadsByStatus=$this->getLeadByStatus($vendors['vendor'],$vendors['batch_id'],$search_date);
				$reportDataList[$index]['registered']=$leadsByStatus['registered'];
				$reportDataList[$index]['lead_validity']=$leadsByStatus['invalid'];
				$reportDataList[$index]['revenue']=$this->getRevenueFromLead($vendors['vendor'],$vendors['batch_id']);
				$reportDataList[$index]['conversion_rate']=number_format((($reportDataList[$index]['registered']/$vendors['total_leads'])*100),2);
				$actualCampaignData=$this->getActualPlanByVendor($vendors['vendor_id'],$vendors['batch_id'],$search_date);
				$reportDataList[$index]['spend']=$actualCampaignData['total_cost'];
				$reportDataList[$index]['cpl']=$actualCampaignData['cpl'];
				$reportDataList[$index]['cpa']=number_format($actualCampaignData['total_cost']/$reportDataList[$index]['registered']);
				$reportDataList[$index]['cpa_percent']=number_format((($reportDataList[$index]['cpa']/$reportDataList[$index]['course_fee'])*100),2);
				#calculate source CPA & Course CPA
				$leadsByStatus=$this->getLeadByStatus($vendors['vendor'],"",$search_date); # without batch
				$registered_byvendor=$leadsByStatus['registered'];
				$actual_data_byvendor=$this->getActualPlanByVendor($vendors['vendor_id'],"",$search_date); #without batch
				$cpa=number_format($actual_data_byvendor['total_cost']/$registered_byvendor);
				$source_cpa_percent=number_format((($cpa/$reportDataList[$index]['course_fee'])*100),2);
				$reportDataList[$index]['source_cpa_percent']=$source_cpa_percent;
				#Course CPA
				$leadsByStatus=$this->getLeadByStatus("",$vendors['batch_id'],$search_date); # without batch
				$registered_bybatch=$leadsByStatus['registered'];
				$actual_data_bybatch=$this->getActualPlanByVendor("",$vendors['batch_id'],$search_date); #without batch
				$cpa=number_format($actual_data_bybatch['total_cost']/$registered_bybatch);
				$course_cpa_percent=number_format((($cpa/$reportDataList[$index]['course_fee'])*100),2);
				$reportDataList[$index]['course_cpa_percent']=$course_cpa_percent;
					
				$template.='<tr height="20">
				   <td align="left" valign="top" >'.$vendors['vendor'].'</td>
				   <td align="left" valign="top" >'.$vendors['batch'].'</td> 
				   <td align="left" valign="top">'.$vendors['total_leads'].'</td>
					<td align="left" valign="top">'.$reportDataList[$index]['registered'].'</td>
					<td align="left" valign="top">'.$reportDataList[$index]['lead_validity'].'</td>
					<td align="left" valign="top">'.$reportDataList[$index]['spend'].'</td>
					<td align="left" valign="top">'.$reportDataList[$index]['conversion_rate'].'</td>
					<td align="left" valign="top">'.$reportDataList[$index]['cpl'].'</td>
					<td align="left" valign="top">'.$reportDataList[$index]['cpa'].'</td>
					<td align="left" valign="top">'.number_format($vendors['course_fee']).'</td>
					<td align="left" valign="top">'.$reportDataList[$index]['cpa_percent'].'</td>
					<td align="left" valign="top">'.$reportDataList[$index]['revenue'].'</td>
					<td align="left" valign="top">'.$source_cpa_percent.'</td>
					<td align="left" valign="top">'.$course_cpa_percent.'</td>
					<td align="left" valign="top">'.$GLOBALS['app_list_strings']['batch_status_list'][$vendors['batch_status']].'</td>
				</tr>';	
				$index++;
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
		}else{			
			$vendorListData=$this->getReportData($searchData);
			foreach($vendorListData as $vendors){
				$reportDataList[$index]['vendor']=$vendors['vendor'];
				$reportDataList[$index]['total_leads']=$vendors['total_leads'];
				$reportDataList[$index]['batch']=$vendors['batch'];
				$reportDataList[$index]['course_fee']=number_format($vendors['course_fee']);
				$reportDataList[$index]['batch_status']=$GLOBALS['app_list_strings']['batch_status_list'][$vendors['batch_status']];
				$leadsByStatus=$this->getLeadByStatus($vendors['vendor'],$vendors['batch_id']);
				$reportDataList[$index]['registered']=$leadsByStatus['registered'];
				$reportDataList[$index]['lead_validity']=$leadsByStatus['invalid'];
				$reportDataList[$index]['revenue']=$this->getRevenueFromLead($vendors['vendor'],$vendors['batch_id']);
				$reportDataList[$index]['conversion_rate']=number_format((($reportDataList[$index]['registered']/$vendors['total_leads'])*100),2);
				$actualCampaignData=$this->getActualPlanByVendor($vendors['vendor_id'],$vendors['batch_id']);
				$reportDataList[$index]['spend']=$actualCampaignData['total_cost'];
				$reportDataList[$index]['cpl']=$actualCampaignData['cpl'];
				$reportDataList[$index]['cpa']=number_format($actualCampaignData['total_cost']/$reportDataList[$index]['registered']);
				$reportDataList[$index]['course_fee'];
				$reportDataList[$index]['cpa_percent']=number_format((($reportDataList[$index]['cpa']/$reportDataList[$index]['course_fee'])*100),2);

				#calculate source CPA & Course CPA
				$leadsByStatus=$this->getLeadByStatus($vendors['vendor']); # without batch
				$registered_byvendor=$leadsByStatus['registered'];
				$actual_data_byvendor=$this->getActualPlanByVendor($vendors['vendor_id']); #without batch
				$cpa=number_format($actual_data_byvendor['total_cost']/$registered_byvendor);
				$source_cpa_percent=number_format((($cpa/$reportDataList[$index]['course_fee'])*100),2);
				$reportDataList[$index]['source_cpa_percent']=$source_cpa_percent;
				#Course CPA
				$leadsByStatus=$this->getLeadByStatus("",$vendors['batch_id']); # without batch
				$registered_bybatch=$leadsByStatus['registered'];
				$actual_data_bybatch=$this->getActualPlanByVendor("",$vendors['batch_id']); #without batch
				$cpa=number_format($actual_data_bybatch['total_cost']/$registered_bybatch);
				$course_cpa_percent=number_format((($cpa/$reportDataList[$index]['course_fee'])*100),2);
				$reportDataList[$index]['course_cpa_percent']=$course_cpa_percent;
				
				$index++;
			}
		}		
        #Custom Pagination
		$total=count($reportDataList); #total records			
		$start=0;
		$per_page=10;
		$page=1;
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
			$page=($_REQUEST['page']-1);
			$left=1;
		}
		$reportDataList=array_slice($reportDataList,$start,$per_page);
		if($total>$per_page){
			$current="(".($start+1)."-".($start+$per_page)." of ".$total.")";
		}else{
			$current="(".($start+1)."-".count($reportDataList)." of ".$total.")";
		}
		# Pagination end
		
		$sugarSmarty = new Sugar_Smarty();
		$sugarSmarty->assign("batchList",$batchList);
		$sugarSmarty->assign("vendorOptionList",$vendorList);
		$sugarSmarty->assign("batchStatusList",$batchStatusList);
		$sugarSmarty->assign("reportDataList",$reportDataList);
		$sugarSmarty->assign("selected_batch",$selected_batch);
		$sugarSmarty->assign("selected_vendor",$selected_vendor);
		$sugarSmarty->assign("selected_status",$selected_status);
		$sugarSmarty->assign("selected_date",$search_date);
		$sugarSmarty->assign("current_records",$current);
		$sugarSmarty->assign("page",$page);
		$sugarSmarty->assign("right",$right);
		$sugarSmarty->assign("left",$left);
		$sugarSmarty->assign("last_page",$last_page);
		$sugarSmarty->display('custom/modules/AOR_Reports/tpls/dailyreport.tpl');
	}
}
?>
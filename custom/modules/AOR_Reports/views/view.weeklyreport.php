<?php
if (!defined('sugarEntry') || !sugarEntry)
	die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php'); 
class AOR_ReportsViewWeeklyreport extends SugarView {
	
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
	function getUtm($vendors){
		global $db;
		$vendorSql="SELECT u.name FROM te_utm u INNER JOIN  te_vendor_te_utm_1_c uvr ON u.id=uvr.te_vendor_te_utm_1te_utm_idb INNER JOIN te_vendor v ON uvr.te_vendor_te_utm_1te_vendor_ida=v.id WHERE v.id IN('".implode("','",$vendors)."') AND u.utm_status='Live'";
		$vendorObj =$db->query($vendorSql);
		$utms=array();
		while($row =$db->fetchByAssoc($vendorObj)){ 
			$utms[]=$row['name'];
		}
		return $utms;
	}
	function getVendors($batch){
		global $db;
		$vendorSql="SELECT distinct(v.id),v.name,date(te_ba_batch.date_entered) as date_entered FROM te_ba_batch INNER JOIN te_utm u on u.te_ba_batch_id_c=te_ba_batch.id INNER JOIN  te_vendor_te_utm_1_c uvr ON u.id=uvr.te_vendor_te_utm_1te_utm_idb INNER JOIN te_vendor v ON uvr.te_vendor_te_utm_1te_vendor_ida=v.id WHERE te_ba_batch.id='".$batch."' AND u.utm_status='Live'";
		$vendorObj =$db->query($vendorSql);
		$vendorOptions=array();
		while($row =$db->fetchByAssoc($vendorObj)){ 
			$vendorOptions[]=$row;
		}
		return $vendorOptions;
	}
	function getActualPlanByBatch($batch_id,$week_date){
		global $db;
		$actualPlanSql="SELECT sum(cpl) as cpl, sum(cpa) as cpa FROM te_actual_campaign WHERE te_ba_batch_id_c='".$batch_id."' AND deleted=0 AND date(date_entered) >='".$week_date['week_start']."' AND date(date_entered)<='".$week_date['week_end']."'";
		$actualPlanObj =$db->query($actualPlanSql);
		$actualPlan =$db->fetchByAssoc($actualPlanObj);
		return $actualPlan;
	}
	function getActualPlanByUtm($utms,$week_date){
		global $db;
		$actualPlanSql="SELECT sum(cpl) as cpl, sum(cpa) as cpa FROM te_actual_campaign WHERE name IN ('".implode("','",$utms)."') AND deleted=0 AND date(date_entered) >='".$week_date['week_start']."' AND date(date_entered)<='".$week_date['week_end']."'";
		$actualPlanObj =$db->query($actualPlanSql);
		$actualPlan =$db->fetchByAssoc($actualPlanObj);
		return $actualPlan;
	}
	public function display() {
		global $db;
		# Query for batch drop down options
		$batchSql="SELECT id,name FROM te_ba_batch WHERE batch_status='enrollment_in_progress' AND deleted=0";
		$batchObj =$db->query($batchSql);
		$batchList=array();
		while($row =$db->fetchByAssoc($batchObj)){
			$batchList[]=$row;
		}	
		$selected_batch="";
		$batch_created_date="";
		$utms=array();
		$vendorList=array();
		$reportData=array();
		if(isset($_POST['button']) && $_POST['button']=="Search") {
			#Weeks of the batch created date and till date
			$vendorList=$this->getVendors($_POST['batch_val']);
			$utms=$this->getUtm($_REQUEST['vendor_val']);
			$weeks=array();
			$selected_batch=$_POST['batch_val'];
			$batch_created_date=$_POST['batch_created_date'];
			$date=explode("-",$batch_created_date);
			$y=$date[0];
			$m=$date[1];
			$d=$date[2];
			for($x=0;$x<date('d');$x++){
				$week=(Integer)date("W", mktime(0,0,0,$m,$d+$x,$y));
				$weeks[$week]=$week;
			}			
			foreach($weeks as $key=>$value){
				if(!empty($utms))
					$reportData[$key]=$this->getActualPlanByUtm($utms,$this->getStartAndEndDate($value,$y));
				else
					$reportData[$key]=$this->getActualPlanByBatch($_POST['batch_val'],$this->getStartAndEndDate($value,$y));
			}
		}elseif(isset($_POST['export']) && $_POST['export']=="Export"){
			$data="Week,CPL,CPA\n";
			$file = "weekly_report";
			$filename = $file . "_" . date ( "Y-m-d");
			#Weeks of the batch created date and till date
			$vendorList=$this->getVendors($_POST['batch_val']);
			$utms=$this->getUtm($_REQUEST['vendor_val']);
			$weeks=array();
			$selected_batch=$_POST['batch_val'];
			$batch_created_date=$_POST['batch_created_date'];
			$date=explode("-",$batch_created_date);
			$y=$date[0];
			$m=$date[1];
			$d=$date[2];
			for($x=0;$x<date('d');$x++){
				$week=(Integer)date("W", mktime(0,0,0,$m,$d+$x,$y));
				$weeks[$week]=$week;
			} 
			foreach($weeks as $key=>$value){				
				if(!empty($utms))
					$reportData=$this->getActualPlanByUtm($utms,$this->getStartAndEndDate($value,$y));
				else
					$reportData=$this->getActualPlanByBatch($_POST['batch_val'],$this->getStartAndEndDate($value,$y));
				
				$reportData['cpl']=$reportData['cpl']?number_format($reportData['cpl'],2):"0.00";
				$reportData['cpa']=$reportData['cpa']?number_format($reportData['cpa'],2):"0.00";
				$data.= "\"" . $key . "\",\"" . $reportData ['cpl'] . "\",\"" . $reportData ['cpa']. "\"\n";
			}
			ob_end_clean();
			header("Content-type: application/csv");
			header ('Content-disposition: attachment;filename=" '. $filename . '.csv";' );
			echo $data; exit;
		}elseif(isset($_POST['sendemail']) && $_POST['sendemail']=="Send Email"){
			$template='<table cellpadding="0" cellspacing="0" width="100%" border="1">
			<tr height="20">
				<th><strong>Week</strong></th>
				<th><strong>CPL</strong></th>
				<th><strong>CPA</strong></th>
			</tr>';
			$file = "weekly_report";
			$filename = $file . "_" . date ( "Y-m-d");
			#Weeks of the batch created date and till date
			$vendorList=$this->getVendors($_POST['batch_val']);
			$utms=$this->getUtm($_REQUEST['vendor_val']);
			$weeks=array();
			$selected_batch=$_POST['batch_val'];
			$batch_created_date=$_POST['batch_created_date'];
			$date=explode("-",$batch_created_date);
			$y=$date[0];
			$m=$date[1];
			$d=$date[2];
			for($x=0;$x<date('d');$x++){
				$week=(Integer)date("W", mktime(0,0,0,$m,$d+$x,$y));
				$weeks[$week]=$week;
			} 
			foreach($weeks as $key=>$value){	
				if(!empty($utms)){
					$templateData=$this->getActualPlanByUtm($utms,$this->getStartAndEndDate($value,$y));
					$reportData[$key]=$templateData;
				}else{
					$templateData=$this->getActualPlanByBatch($_POST['batch_val'],$this->getStartAndEndDate($value,$y));
					$reportData[$key]=$templateData;
				}
				$template.='<tr height="20">
				   <td align="left" valign="top" >'.$key.'</td>
				   <td align="left" valign="top" >'.number_format($templateData['cpl'],2).'</td> 
				   <td align="left" valign="top">'.number_format($templateData['cpa'],2).'</td>					
				</tr>';
			}
			$template.="</table>";
			$recipientsSql="SELECT name,email,report FROM te_report_recipients WHERE deleted=0 AND report='Weekly'";
			$recipientsObj =$db->query($recipientsSql);
			$recipients="";
			while($row =$db->fetchByAssoc($recipientsObj)){
				$recipients.=$row['email'].",";
			}			
			if($recipients!=""){
				$recipients=substr($recipients,0,-1);
				$mail = new NetCoreEmail();			
				$mail->sendEmail($recipients,"Weekly Report",$template);
			}			
		}	

		$sugarSmarty = new Sugar_Smarty();
		$sugarSmarty->assign("batchList",$batchList);
		$sugarSmarty->assign("vendorList",$vendorList);
		$sugarSmarty->assign("reportData",$reportData);
		$sugarSmarty->assign("selected_batch",$selected_batch);
		$sugarSmarty->assign("batch_created_date",$batch_created_date);
		$sugarSmarty->assign("selected_vendor",$_REQUEST['vendor_val']);
		$sugarSmarty->display('custom/modules/AOR_Reports/tpls/weeklyreport.tpl');
	}
}
?>
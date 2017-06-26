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
	function getActualPlanByBatch($batch_id,$week_date,$week=NULL){
		//echo $batch_id; print_r($week_date);exit();
		global $db;
		$query3="SELECT count(l.id)total_leads,count(l2.id)converted,(SELECT te_ba_batch.fees_inr FROM te_ba_batch WHERE te_ba_batch.id=lc.te_ba_batch_id_c)fee FROM leads l inner join leads_cstm lc ON l.id = lc.id_c AND lc.te_ba_batch_id_c='".$batch_id."' AND l.status IN('Alive','Warm','Dead','Converted','Dropout') AND l.deleted=0  left join leads l2 on l2.id=l.id AND l2.status='Converted' AND l2.deleted=0 WHERE l.date_entered >= '".$week_date['week_start']."' AND l.date_entered <= '".$week_date['week_end']."'";
		//echo $query3;exit();
		$row3 =$db->query($query3);
		$reco3 =$db->fetchByAssoc($row3);

		//$actualPlanSql="SELECT sum(cpl) as cpl, sum(cpa) as cpa FROM te_actual_campaign WHERE te_ba_batch_id_c='".$batch_id."' AND deleted=0 AND date(plan_date) >='".$week_date['week_start']."' AND date(plan_date)<='".$week_date['week_end']."'";
		//echo $actualPlanSql;exit();
		$query4="SELECT sum(t3.rate)rate,sum(t3.volume)volume,sum(t3.total_cost)total_cost FROM `te_ba_batch` INNER JOIN te_actual_campaign as t3 on t3.te_ba_batch_id_c=te_ba_batch.id AND t3.deleted=0 AND t3.type='paid' AND  t3.plan_date >= '".$week_date['week_start']."' AND t3.plan_date <= '".$week_date['week_end']."' WHERE t3.te_ba_batch_id_c='".$batch_id."'";
		$query4Obj =$db->query($query4);
		$reco4 =$db->fetchByAssoc($query4Obj);
		//echo "<pre>";print_r($reco3);print_r($reco4);

		$actualPlan['cpl'] = $reco4['total_cost']/$reco3['total_leads'];
		$actualPlan['cpa']= $reco4['total_cost']/$reco3['converted'];
		$actualPlan['gsv']= round($reco3['fee'])*$reco3['converted'];
		$cpa_percent = 0.00;
		$cpa_percent= ($actualPlan['gsv'] && $reco4['total_cost']?round($reco4['total_cost'])/round($actualPlan['gsv']):0);
		$cpa_percent=round($cpa_percent*100,2);
		$actualPlan['cpa_percent'] = $cpa_percent;
		$actualPlan['week']= $week;
		return $actualPlan;
	}
	function getActualPlanByUtm($utms,$week_date,$week=NULL,$vendor=NULL,$batch_id=NULL){
		global $db;
		if($utms){
			$query3="SELECT count(l.id)total_leads,count(l2.id)converted,(SELECT te_ba_batch.fees_inr FROM te_ba_batch WHERE te_ba_batch.id=lc.te_ba_batch_id_c)fee FROM leads l inner join leads_cstm lc ON l.id = lc.id_c AND lc.te_ba_batch_id_c='".$batch_id."' AND l.status IN('Alive','Warm','Dead','Converted','Dropout') AND l.deleted=0  AND l.utm in('".implode("','",$utms)."') left join leads l2 on l2.id=l.id AND l2.status='Converted' AND l2.deleted=0 WHERE l.date_entered >= '".$week_date['week_start']."' AND l.date_entered <= '".$week_date['week_end']."' ";
			$row3 =$db->query($query3);
			$reco3 =$db->fetchByAssoc($row3);

			$query4="SELECT sum(t3.rate)rate,sum(t3.volume)volume,sum(t3.total_cost)total_cost FROM `te_ba_batch` INNER JOIN te_actual_campaign as t3 on t3.te_ba_batch_id_c=te_ba_batch.id AND t3.deleted=0 AND t3.type='paid' AND t3.vendor_id in('".implode("','",$vendor)."') AND  t3.plan_date >= '".$week_date['week_start']."' AND t3.plan_date <= '".$week_date['week_end']."' WHERE t3.te_ba_batch_id_c='".$batch_id."'";
			$query4Obj =$db->query($query4);
			$reco4 =$db->fetchByAssoc($query4Obj);

			$actualPlan['cpl'] = $reco4['total_cost']/$reco3['total_leads'];
			$actualPlan['cpa']= $reco4['total_cost']/$reco3['converted'];
			$actualPlan['gsv']= round($reco3['fee'])*$reco3['converted'];
			$cpa_percent = 0.00;
			$cpa_percent= ($actualPlan['gsv'] && $reco4['total_cost']?round($reco4['total_cost'])/round($actualPlan['gsv']):0);
			$cpa_percent=round($cpa_percent*100,2);
			$actualPlan['cpa_percent'] = $cpa_percent;
			$actualPlan['week']= $week;
			return $actualPlan;
		}

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
			//echo "<pre>";print_r($utms);print_r($_REQUEST['vendor_val']);exit();
			if(isset($_REQUEST['vendor_val']) && !empty($_REQUEST['vendor_val'])){
				$where = " AND (vendor_id IN('".implode("','",$_REQUEST['vendor_val'])."')) ";
			}
			$weeks=array();
			$selected_batch=$_POST['batch_val'];
			$batch_created_date=$_POST['batch_created_date'];
			$date=explode("-",$batch_created_date);
			$y=$date[0];
			$m=$date[1];
			$d=$date[2];
			$get_min_max_actual_date = "SELECT MIN(plan_date)min_date,MAX(plan_date)max_date FROM te_actual_campaign WHERE te_ba_batch_id_c='".$_POST['batch_val']."' AND deleted=0 $where";
			$get_min_max_actual_dateObj = $db->query($get_min_max_actual_date);
			$row_get_min_max_actual_date =$db->fetchByAssoc($get_min_max_actual_dateObj);

			if($row_get_min_max_actual_date['min_date'] && $row_get_min_max_actual_date['max_date']){
				$start = $row_get_min_max_actual_date['min_date'];
				$end = $row_get_min_max_actual_date['max_date'];

				$dates = range(strtotime($start), strtotime($end),604800);
				$weeks = array_map(function($v){return date('W', $v);}, $dates);
				foreach($weeks as $key=>$value){
					if(!empty($utms)){
						$reportData[$value]=$this->getActualPlanByUtm($utms,$this->getStartAndEndDate($value,$y),$value,$_REQUEST['vendor_val'],$_REQUEST['batch_val']);
					}
					else{
						$reportData[$value]=$this->getActualPlanByBatch($_POST['batch_val'],$this->getStartAndEndDate($value,$y),$value);
					}
				}
				//echo "<pre>";print_r($reportData);exit();
			}


		}elseif(isset($_POST['export']) && $_POST['export']=="Export"){
			$data="Week,CPL,CPA,CPA%\n";
			$file = "weekly_report";
			$filename = $file . "_" . date ( "Y-m-d");
			#Weeks of the batch created date and till date
			$vendorList=$this->getVendors($_POST['batch_val']);
			$utms=$this->getUtm($_REQUEST['vendor_val']);
			if(isset($_REQUEST['vendor_val']) && !empty($_REQUEST['vendor_val'])){
				$where = " AND (vendor_id IN('".implode("','",$_REQUEST['vendor_val'])."')) ";
			}
			$weeks=array();
			$selected_batch=$_POST['batch_val'];
			$batch_created_date=$_POST['batch_created_date'];
			$date=explode("-",$batch_created_date);
			$y=$date[0];
			$m=$date[1];
			$d=$date[2];
			$get_min_max_actual_date = "SELECT MIN(plan_date)min_date,MAX(plan_date)max_date FROM te_actual_campaign WHERE te_ba_batch_id_c='".$_POST['batch_val']."' AND deleted=0 $where";
			$get_min_max_actual_dateObj = $db->query($get_min_max_actual_date);
			$row_get_min_max_actual_date =$db->fetchByAssoc($get_min_max_actual_dateObj);

			if($row_get_min_max_actual_date['min_date'] && $row_get_min_max_actual_date['max_date']){
				$start = $row_get_min_max_actual_date['min_date'];
				$end = $row_get_min_max_actual_date['max_date'];

				$dates = range(strtotime($start), strtotime($end),604800);
				$weeks = array_map(function($v){return date('W', $v);}, $dates);
				foreach($weeks as $key=>$value){
					if(!empty($utms)){
						$reportData[$value]=$this->getActualPlanByUtm($utms,$this->getStartAndEndDate($value,$y),$value,$_REQUEST['vendor_val']);
					}
					else{
						$reportData[$value]=$this->getActualPlanByBatch($_POST['batch_val'],$this->getStartAndEndDate($value,$y),$value);
					}
				}
			}
			foreach($reportData as $key=>$value){
				if(!$value['cpl']){
					$value['cpl']='0.00';
				}
				if(!$value['cpa']){
					$value['cpa']='0.00';
				}
				if(!$value['cpa_percent']){
					$value['cpa_percent']='0.00';
				}

				$data.= "\"" . $key . "\",\"" . round($value['cpl'],2) . "\",\"" . round($value['cpa'],2). "\",\"" . round($value['cpa_percent'],2). "\"\n";
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
				<th><strong>CPA%</strong></th>
			</tr>';
			$file = "weekly_report";
			$filename = $file . "_" . date ( "Y-m-d");

			$vendorList=$this->getVendors($_POST['batch_val']);
			$utms=$this->getUtm($_REQUEST['vendor_val']);
			if(isset($_REQUEST['vendor_val']) && !empty($_REQUEST['vendor_val'])){
				$where = " AND (vendor_id IN('".implode("','",$_REQUEST['vendor_val'])."')) ";
			}
			$weeks=array();
			$selected_batch=$_POST['batch_val'];
			$batch_created_date=$_POST['batch_created_date'];
			$date=explode("-",$batch_created_date);
			$y=$date[0];
			$m=$date[1];
			$d=$date[2];
			$get_min_max_actual_date = "SELECT MIN(plan_date)min_date,MAX(plan_date)max_date FROM te_actual_campaign WHERE te_ba_batch_id_c='".$_POST['batch_val']."' AND deleted=0 $where";
			$get_min_max_actual_dateObj = $db->query($get_min_max_actual_date);
			$row_get_min_max_actual_date =$db->fetchByAssoc($get_min_max_actual_dateObj);

			if($row_get_min_max_actual_date['min_date'] && $row_get_min_max_actual_date['max_date']){
				$start = $row_get_min_max_actual_date['min_date'];
				$end = $row_get_min_max_actual_date['max_date'];

				$dates = range(strtotime($start), strtotime($end),604800);
				$weeks = array_map(function($v){return date('W', $v);}, $dates);
				foreach($weeks as $key=>$value){
					if(!empty($utms)){
						$reportData[$value]=$this->getActualPlanByUtm($utms,$this->getStartAndEndDate($value,$y),$value,$_REQUEST['vendor_val']);
					}
					else{
						$reportData[$value]=$this->getActualPlanByBatch($_POST['batch_val'],$this->getStartAndEndDate($value,$y),$value);
					}
				}
			}
			foreach($reportData as $key=>$value){
				if(!$value['cpl']){
					$value['cpl']='0.00';
				}
				if(!$value['cpa']){
					$value['cpa']='0.00';
				}
				if(!$value['cpa_percent']){
					$value['cpa_percent']='0.00';
				}
				$template.='<tr height="20">
				   <td align="left" valign="top" >'.$key.'</td>
				   <td align="left" valign="top" >'.number_format($value['cpl'],2).'</td>
				   <td align="left" valign="top">'.number_format($value['cpa'],2).'</td>
					 <td align="left" valign="top">'.$value['cpa_percent'].'</td>
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
#PS @Manish
			/*$total=count($reportData); #total records

			$start=0;
			$per_page=10;
			$page=1;
			$pagenext=1;
			$last_page=ceil($total/$per_page);

			if(isset($_REQUEST['page'])&&$_REQUEST['page']>0){
				$start=$per_page*($_REQUEST['page']-1);
				$page=($_REQUEST['page']-1);
				$pagenext = ($_REQUEST['page']+1);

			}else{
				//$page++;
				$pagenext++;
			}
			if(($start+$per_page)<$total){
				$right=1;
			}else{
				$right=0;
			}
			if(isset($_REQUEST['page'])&&$_REQUEST['page']==1){
				$left=0;
			}elseif(isset($_REQUEST['page'])){
				//$page=($_REQUEST['page']-1);
				$left=1;
			}

			$reportData=array_slice($reportData,$start,$per_page);
			if($total>$per_page){
				$current="(".($start+1)."-".($start+$per_page)." of ".$total.")";

			}else{
				$current="(".($start+1)."-".count($reportData)." of ".$total.")";

			}*/
		#pE
		//echo "<pre>";print_r($reportData);exit();
		$sugarSmarty = new Sugar_Smarty();
		$sugarSmarty->assign("batchList",$batchList);
		$sugarSmarty->assign("vendorList",$vendorList);
		$sugarSmarty->assign("reportData",$reportData);
		$sugarSmarty->assign("selected_batch",$selected_batch);
		$sugarSmarty->assign("batch_created_date",$batch_created_date);
		$sugarSmarty->assign("selected_vendor",$_REQUEST['vendor_val']);
		$sugarSmarty->assign("current_records",$current);
		$sugarSmarty->assign("page",$page);
		$sugarSmarty->assign("pagenext",$pagenext);
		$sugarSmarty->assign("right",$right);
		$sugarSmarty->assign("left",$left);
		$sugarSmarty->assign("last_page",$last_page);
		$sugarSmarty->display('custom/modules/AOR_Reports/tpls/weeklyreport.tpl');
	}
}
?>

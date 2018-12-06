<?php
ini_set('max_execution_time', 3600);
set_time_limit(3600);
//echo "hello";exit(); 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class pushActualLeads
{

	public $fromDate;

	public function __construct()
	{
		$this->fromDate = date('Y-m-d');
		$this->toDate   = date('Y-m-d');
	}

	public function get_data(){
		global $db;
		$ignore_vendors = "'citehr','facebook','google','te_focus','taboola'";
		$sql="SELECT count(id)total,sum(case when status ='Converted' then 1 else 0 end) as converted,utm FROM `leads` WHERE date(date_entered)='".$this->fromDate."' AND vendor NOT IN ($ignore_vendors) group by utm";
		$result = $db->query($sql);
		$resultArr = [];
		if($db->getRowCount($result)>0){
			while ($row = $db->fetchByAssoc($result)){
				$resultArr[$row['utm']]=$row;
			}
		}
		return $resultArr;
	}
	
	public function get_total_data($utms){
		global $db;
		$ignore_vendors = "'citehr','facebook','google','te_focus','taboola'";
		$sql="SELECT count(id)total,sum(case when status ='Converted' then 1 else 0 end) as converted,utm FROM `leads` WHERE date(date_entered)<='".$this->fromDate."' AND vendor NOT IN ($ignore_vendors) AND utm IN ($utms) group by utm";
		$result = $db->query($sql);
		$resultArr = [];
		if($db->getRowCount($result)>0){
			while ($row = $db->fetchByAssoc($result)){
				$resultArr[$row['utm']]=$row;
			}
		}
		return $resultArr;
	}
	
	public function get_utm(){
		global $db;
		//$ignore_vendors = "'citehr','facebook','google','te_focus','taboola'";
		$sql="SELECT 
			u.id utm_id,
			u.name AS utm_name,
			b.id batch_id,
			b.fees_inr,
			v.id vendor_id,
			cc.rate_c,
			c.contract_type,
			c.performance_metrics,
			cc.target_c
			FROM te_utm u
			INNER JOIN te_vendor_te_utm_1_c v ON v.te_vendor_te_utm_1te_utm_idb=u.id
			INNER JOIN te_vendor tv ON tv.id=v.te_vendor_te_utm_1te_vendor_ida 
			INNER JOIN te_ba_batch b ON b.id=u.te_ba_batch_id_c 
			INNER JOIN aos_contracts c ON c.id=u.aos_contracts_id_c 
			INNER JOIN aos_contracts_cstm cc ON c.id=cc.id_c 
			WHERE utm_status!='Expired'
			AND u.deleted=0
			AND v.deleted=0
			AND tv.deleted=0
			AND c.deleted=0
			AND b.deleted=0";
			//AND v.name NOTIN ($ignore_vendors)";
		$result = $db->query($sql);
		$resultArr = [];
		if($db->getRowCount($result)>0){
			while ($row = $db->fetchByAssoc($result)){
				$resultArr[$row['utm_name']]=$row;
			}
		}
		return $resultArr;
	}
    
	
}

$mainObj           = new pushActualLeads();
$mainObj->fromDate = (isset($_GET['today']) && !empty($_GET['today'])) ? $_GET['today']: date('Y-m-d', (strtotime('-1 day', strtotime(date('Y-m-d')))));

$result = $mainObj->get_data();
$utms_arr = [];
$utm_str = '';
if($result){
	foreach($result as $rval){
		$utms_arr[] = $rval['utm'];
	}
	$utm_str = "'".implode("','",$utms_arr)."'";
}
$total_data_res = $mainObj->get_total_data($utm_str);
$utm = $mainObj->get_utm();
$insertable_arr = '';
$insertable_sub_arr = '';

if($result && $utm){
	foreach($result as $key => $val){
		if(isset($utm[$key]['performance_metrics']) && $utm[$key]['performance_metrics']=='CPA'){

			$target_c = (!empty($utm[$key]['target_c'])) ? str_replace('%','',$utm[$key]['target_c']): 0;
			$target_per = $target_c/100;

			$cpl_sum = ($target_c>0 && !empty($utm[$key]['fees_inr']) && $val['converted']>0 && $target_per>0) ? ($utm[$key]['fees_inr'] * $val['converted']) * $target_per : 0;
			$cpa = ($cpl_sum>0 && $val['converted']) ? $cpl_sum/$val['converted'] : 0;
			$cpl = ($cpl_sum>0 && $val['total']) ? $cpl_sum/$val['total'] : 0;
		}else{
			$cpl = (isset($utm[$key]['rate_c']) && !empty($utm[$key]['rate_c'])) ? $utm[$key]['rate_c']  : 0;
			$cpl_sum = (isset($utm[$key]['rate_c']) && !empty($utm[$key]['rate_c'])) ? $utm[$key]['rate_c'] * $val['total'] : 0;
		        $cpa = ($cpl_sum>0 && $val['converted']) ? $cpl_sum/$val['converted'] : 0;
		}
		
		if($cpl>0){
			$id = create_guid();
			$totalLeads = $total_data_res[$key]['total'];
			$totalConversion = $total_data_res[$key]['converted'];
			$ActualLead = $val['total'];
			$ActualConversion = $val['converted'];
			$insertable_arr[] = " ('".$id."','".$key."','".$mainObj->fromDate."',$ActualLead,'".$totalLeads."','".$ActualConversion."','".$totalConversion."','".$cpl_sum."','".$cpl."','".$cpa."','".$utm[$key]['batch_id']."','".$utm[$key]['vendor_id']."','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."') ";
			$insertable_sub_arr[] = " ('".create_guid()."','".$utm[$key]['utm_id']."','".$id."','".date('Y-m-d H:i:s')."') ";		
		}//echo $mainObj->fromDate.'<br>';
	}
}//exit();
global $db;
if($insertable_arr){
	$insert_str = "INSERT INTO `te_actual_campaign`(`id`, `name`, `plan_date`,`leads`,`total_leads`,`actual_conversion`,`total_conversion`, `total_cost`, `cpl`, `cpa`, `te_ba_batch_id_c`, `vendor_id`,`date_entered`,`date_modified`) VALUES ";
	$insert_str .= implode(',',$insertable_arr);
	$db->query($insert_str);
	//echo $insert_str.'<br>';
}
if($insertable_sub_arr){
	$insertable_sub_str = "INSERT INTO `te_utm_te_actual_campaign_1_c`(`id`, `te_utm_te_actual_campaign_1te_utm_ida`, `te_utm_te_actual_campaign_1te_actual_campaign_idb`,`date_modified`) VALUES ";
	$insertable_sub_str .= implode(',',$insertable_sub_arr);
	$db->query($insertable_sub_str);
	//echo $insertable_sub_str;exit();
}
/*echo "<pre>";
print_r($insertable_arr);
print_r($insertable_sub_arr);
//print_r($result);
//print_r($utm);
exit();*/



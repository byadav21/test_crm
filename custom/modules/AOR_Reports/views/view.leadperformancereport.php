<?php
if (!defined('sugarEntry') || !sugarEntry)
	die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');
class AOR_ReportsViewLeadperformancereport extends SugarView {

	public function __construct() {
		parent::SugarView();
	}

	function getVendor(){
		global $db;
		$vendorSql="SELECT name,id FROM `te_vendor` WHERE deleted=0 group by name order by name asc";
		$vendorObj =$db->query($vendorSql);
		$vendorArr = [];
		while($vendor =$db->fetchByAssoc($vendorObj)){
			$vendorArr[]=$vendor;
		}
		return $vendorArr;
	}
	function getbatchforlead($batch_arr=NULL){
		$where = '';
		if($batch_arr){
			$where =" AND id IN('".implode("','",$batch_arr)."')";
		}
		global $db;
		$batchSql="SELECT id,name from te_ba_batch WHERE deleted=0 AND batch_status<>'Closed' $where";
		$batchObj =$db->query($batchSql);
		$batchOptions=array();
		while($row =$db->fetchByAssoc($batchObj)){
			$batchOptions[]=$row;
		}
		return $batchOptions;
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
	public function display() {
		global $sugar_config,$app_list_strings,$current_user,$db;
        $leadsData=array();

		#Get lead status drop down option
		$leadStatusList=$GLOBALS['app_list_strings']['lead_status_dom'];
		#Get batch drop down option
		$batchList=$this->getBatch();

		# Query for batch drop down options
		$where="";
		$from_date="";
		$to_date="";
		if(isset($_POST['button']) && $_POST['button']=="Search") {
			if($_POST['from_date']!=""&&$_POST['to_date']){
				$from_date=date('Y-m-d',strtotime(str_replace('/','-',$_POST['from_date'])));
				$to_date=date('Y-m-d',strtotime(str_replace('/','-',$_POST['to_date'])));
				$where.=" AND DATE(l.date_entered)>='".$from_date."' AND DATE(l.date_entered)<='".$to_date."'";
			}elseif($_POST['from_date']!=""&&$_POST['to_date']==""){
				$from_date=date('Y-m-d',strtotime(str_replace('/','-',$_POST['from_date'])));
				$where.=" AND DATE(date_entered)='".$from_date."' ";
			}elseif($_POST['from_date']==""&&$_POST['to_date']!=""){
				$to_date=date('Y-m-d',strtotime(str_replace('/','-',$_POST['to_date'])));
				$where.=" AND DATE(date_entered)='".$to_date."' ";
			}
			if(!empty($_POST['batch'])){
				$where.=" AND lc.te_ba_batch_id_c IN('".implode("','",$_POST['batch'])."') ";
			}

		}elseif(isset($_POST['export']) && $_POST['export']=="Export"){
			$data="Batch,Duplicate,Dead-Number,Fallout,Not-Eligible,Not-Enquired,Rejected,Retired,Ringing-Multiple-Times,Wrong-Number,Call-Back,Converted,Follow-Up,New-Lead,Prospect,Re-Enquired,Grand-Total\n";
			$file = "leads_performance_report";
			$where='';
			$from_date="";
			$to_date="";
			$filename = $file . "_" . date ( "Y-m-d");
			if($_POST['from_date']!=""&&$_POST['to_date']){
				$from_date=date('Y-m-d',strtotime(str_replace('/','-',$_POST['from_date'])));
				$to_date=date('Y-m-d',strtotime(str_replace('/','-',$_POST['to_date'])));
				$where.=" AND DATE(l.date_entered)>='".$from_date."' AND DATE(l.date_entered)<='".$to_date."'";
			}elseif($_POST['from_date']!=""&&$_POST['to_date']==""){
				$from_date=date('Y-m-d',strtotime(str_replace('/','-',$_POST['from_date'])));
				$where.=" AND DATE(date_entered)='".$from_date."' ";
			}elseif($_POST['from_date']==""&&$_POST['to_date']!=""){
				$to_date=date('Y-m-d',strtotime(str_replace('/','-',$_POST['to_date'])));
				$where.=" AND DATE(date_entered)='".$to_date."' ";
			}
			if(!empty($_POST['batch'])){
				$where.=" AND lc.te_ba_batch_id_c IN('".implode("','",$_POST['batch'])."') ";
			}

			$councelorList=array();
			$leadSql="SELECT vendor.name,vendor.id ,count(l.id) as total,l.status_description from te_vendor AS vendor LEFT JOIN leads l ON trim(vendor.name)=trim(l.vendor) AND l.deleted=0 AND vendor.deleted=0 LEFT JOIN leads_cstm AS lc ON l.id=lc.id_c WHERE vendor.name!='' $where GROUP BY vendor.name,l.status_description";
			$leadObj =$db->query($leadSql);

			while($row =$db->fetchByAssoc($leadObj)){
				$row['status_description'] = str_replace(array(' ','-'),'_',$row['status_description']);
				$councelorList[$row['id']]['name']=$row['name'];
				$councelorList[$row['id']][$row['status_description']]=$row['total'];
			}


			foreach($councelorList as $key=>$councelor){
				if(!isset($councelor['Call_Back']))
					$councelorList[$key]['Call_Back']=0;
				if(!isset($councelor['Converted']))
					$councelorList[$key]['Converted']=0;
				if(!isset($councelor['Dead_Number']))
					$councelorList[$key]['Dead_Number']=0;
				if(!isset($councelor['Duplicate']))
					$councelorList[$key]['Duplicate']=0;
				if(!isset($councelor['Fallout']))
					$councelorList[$key]['Fallout']=0;
				if(!isset($councelor['Follow_Up']))
					$councelorList[$key]['Follow_Up']=0;
				if(!isset($councelor['New_Lead']))
					$councelorList[$key]['New_Lead']=0;
				if(!isset($councelor['Not_Eligible']))
					$councelorList[$key]['Not_Eligible']=0;
				if(!isset($councelor['Not_Enquired']))
					$councelorList[$key]['Not_Enquired']=0;
				if(!isset($councelor['Prospect']))
					$councelorList[$key]['Prospect']=0;
				if(!isset($councelor['Re_Enquired']))
					$councelorList[$key]['Re_Enquired']=0;
				if(!isset($councelor['Rejected']))
					$councelorList[$key]['Rejected']=0;
				if(!isset($councelor['Retired']))
					$councelorList[$key]['Retired']=0;
				if(!isset($councelor['Ringing_Multiple_Times']))
					$councelorList[$key]['Ringing_Multiple_Times']=0;
				if(!isset($councelor['Wrong_Number']))
					$councelorList[$key]['Wrong_Number']=0;
				if(!isset($councelor['Invalid_Total'])){
					$councelorList[$key]['Invalid_Total']=$councelorList[$key]['Wrong_Number']
					+$councelorList[$key]['Dead_Number']
					+$councelorList[$key]['Duplicate']
					+$councelorList[$key]['Fallout']
					+$councelorList[$key]['Ringing_Multiple_Times']
					+$councelorList[$key]['Not_Enquired']
					+$councelorList[$key]['Not_Eligible']
					+$councelorList[$key]['Rejected']
					+$councelorList[$key]['Retired'];
				}
				if(!isset($councelor['Valid_Total'])){
					$councelorList[$key]['Valid_Total']=$councelorList[$key]['Call_Back']
					+$councelorList[$key]['Follow_Up']
					+$councelorList[$key]['New_Lead']
					+$councelorList[$key]['Converted']
					+$councelorList[$key]['Re_Enquired']
					+$councelorList[$key]['Prospect'];
				}
				if(!isset($councelor['Grand_Total'])){
					$councelorList[$key]['Grand_Total']=$councelorList[$key]['Valid_Total']+$councelorList[$key]['Invalid_Total'];
				}

			}


			foreach($councelorList as $key=>$councelor){
				$data.= "\"" . $councelor['name'] . "\",\"" . $councelor['Duplicate'] . "\",\"" . $councelor['Dead_Number']."\",\"" . $councelor['Fallout']."\",\"" . $councelor['Not_Eligible']. "\",\"" . $councelor['Not_Enquired'] . "\",\"" . $councelor['Rejected'] . "\",\"" . $councelor['Retired'] . "\",\"" . $councelor['Ringing_Multiple_Times'] . "\",\"" . $councelor['Wrong_Number'] . "\",\"" . $councelor['Call_Back'] . "\",\"" . $councelor['Converted'] . "\",\"" . $councelor['Follow_Up'] . "\",\"" . $councelor['New_Lead'] . "\",\"" . $councelor['Prospect'] . "\",\"" . $councelor['Re_Enquired'] . "\",\"" . $councelor['Grand_Total'] . "\"\n";
			}
			ob_end_clean();
			header("Content-type: application/csv");
			header ('Content-disposition: attachment;filename=" '. $filename . '.csv";' );
			echo $data; exit;
		}
		$councelorList=array();

		$leadSql="SELECT vendor.name,vendor.id ,count(l.id) as total,l.status_description from te_vendor AS vendor LEFT JOIN leads l ON trim(vendor.name)=trim(l.vendor) AND l.deleted=0 AND vendor.deleted=0 LEFT JOIN leads_cstm AS lc ON l.id=lc.id_c WHERE vendor.name!='' $where GROUP BY vendor.name,l.status_description";
		$leadObj =$db->query($leadSql);

		while($row =$db->fetchByAssoc($leadObj)){
			$row['status_description'] = str_replace(array(' ','-'),'_',$row['status_description']);
			$councelorList[$row['id']]['name']=$row['name'];
			$councelorList[$row['id']][$row['status_description']]=$row['total'];
		}



		foreach($councelorList as $key=>$councelor){
			if(!isset($councelor['Call_Back']))
				$councelorList[$key]['Call_Back']=0;
			if(!isset($councelor['Converted']))
				$councelorList[$key]['Converted']=0;
			if(!isset($councelor['Dead_Number']))
				$councelorList[$key]['Dead_Number']=0;
			if(!isset($councelor['Duplicate']))
				$councelorList[$key]['Duplicate']=0;
			if(!isset($councelor['Fallout']))
				$councelorList[$key]['Fallout']=0;
			if(!isset($councelor['Follow_Up']))
				$councelorList[$key]['Follow_Up']=0;
			if(!isset($councelor['New_Lead']))
				$councelorList[$key]['New_Lead']=0;
			if(!isset($councelor['Not_Eligible']))
				$councelorList[$key]['Not_Eligible']=0;
			if(!isset($councelor['Not_Enquired']))
				$councelorList[$key]['Not_Enquired']=0;
			if(!isset($councelor['Prospect']))
				$councelorList[$key]['Prospect']=0;
			if(!isset($councelor['Re_Enquired']))
				$councelorList[$key]['Re_Enquired']=0;
			if(!isset($councelor['Rejected']))
				$councelorList[$key]['Rejected']=0;
			if(!isset($councelor['Retired']))
				$councelorList[$key]['Retired']=0;
			if(!isset($councelor['Ringing_Multiple_Times']))
				$councelorList[$key]['Ringing_Multiple_Times']=0;
			if(!isset($councelor['Wrong_Number']))
				$councelorList[$key]['Wrong_Number']=0;
			if(!isset($councelor['Invalid_Total'])){
				$councelorList[$key]['Invalid_Total']=$councelorList[$key]['Wrong_Number']
				+$councelorList[$key]['Dead_Number']
				+$councelorList[$key]['Duplicate']
				+$councelorList[$key]['Fallout']
				+$councelorList[$key]['Ringing_Multiple_Times']
				+$councelorList[$key]['Not_Enquired']
				+$councelorList[$key]['Not_Eligible']
				+$councelorList[$key]['Rejected']
				+$councelorList[$key]['Retired'];
			}
			if(!isset($councelor['Valid_Total'])){
				$councelorList[$key]['Valid_Total']=$councelorList[$key]['Call_Back']
				+$councelorList[$key]['Follow_Up']
				+$councelorList[$key]['New_Lead']
				+$councelorList[$key]['Converted']
				+$councelorList[$key]['Re_Enquired']
				+$councelorList[$key]['Prospect'];
			}
			if(!isset($councelor['Grand_Total'])){
				$councelorList[$key]['Grand_Total']=$councelorList[$key]['Valid_Total']+$councelorList[$key]['Invalid_Total'];
			}

		}

		//echo "<pre>";print_r($councelorList);exit();
		$sugarSmarty = new Sugar_Smarty();
		$sugarSmarty->assign("councelorList",$councelorList);
		$sugarSmarty->assign("leadStatusList",$leadStatusList);
		$sugarSmarty->assign("batchList",$batchList);
		$sugarSmarty->assign("selected_from_date",$GLOBALS['timedate']->to_display_date($from_date));
		$sugarSmarty->assign("selected_to_date",$GLOBALS['timedate']->to_display_date($to_date));
		//$sugarSmarty->assign("selected_status",$search_status);
		$sugarSmarty->display('custom/modules/AOR_Reports/tpls/leadperformancereport.tpl');
	}
}
?>

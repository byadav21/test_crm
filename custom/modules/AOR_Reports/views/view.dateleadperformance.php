<?php
if (!defined('sugarEntry') || !sugarEntry)
	die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php'); 
class AOR_ReportsViewDateleadperformance extends SugarView {
	
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
	function getUTM($vendor_id){
		global $db;
		$utmSql="SELECT utm.name FROM `te_vendor_te_utm_1_c` as vur INNER JOIN te_utm AS utm ON utm.id=vur.te_vendor_te_utm_1te_utm_idb WHERE utm.deleted=0 AND vur.te_vendor_te_utm_1te_vendor_ida='".$vendor_id."'";
		$utmObj =$db->query($utmSql);
		$utmArr = [];
		while($utm =$db->fetchByAssoc($utmObj)){
			$utmArr[] = $utm['name'];
		}
		return implode("','",$utmArr);
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
				$from_date=$GLOBALS['timedate']->to_db_date($_POST['from_date'],false);
				$to_date=$GLOBALS['timedate']->to_db_date($_POST['to_date'],false);
				$where.=" AND DATE(date_modified)>='".$from_date."' AND DATE(date_modified)<='".$to_date."'";
			}elseif($_POST['from_date']!=""&&$_POST['to_date']==""){
				$from_date=$GLOBALS['timedate']->to_db_date($_POST['from_date'],false);
				$where.=" AND DATE(date_modified)='".$from_date."' ";
			}elseif($_POST['from_date']==""&&$_POST['to_date']!=""){
				$to_date=$GLOBALS['timedate']->to_db_date($_POST['to_date'],false);
				$where.=" AND DATE(date_modified)='".$to_date."' ";
			}
			
			if(!empty($_POST['batch'])){	
				$where.=" AND lc.te_ba_batch_id_c IN('".implode("','",$_POST['batch'])."') ";
			}
		}elseif(isset($_POST['export']) && $_POST['export']=="Export"){
			$data="Batch Name,Vendor,Duplicate,Dead-Number,Fallout,Not-Eligible,Not-Enquired,Rejected,Retired,Ringing-Multiple-Times,Wrong-Number,Call-Back,Converted,Follow-Up,New-Lead,Prospect,Re-Enquired,Grand-Total\n";
			$file = "status_report";
			$where='';
			$from_date="";
			$to_date="";
			$filename = $file . "_" . date ( "Y-m-d");
			if($_POST['from_date']!=""&&$_POST['to_date']){				
				$from_date=$GLOBALS['timedate']->to_db_date($_POST['from_date'],false);
				$to_date=$GLOBALS['timedate']->to_db_date($_POST['to_date'],false);
				$where.=" AND DATE(date_modified)>='".$from_date."' AND DATE(date_modified)<='".$to_date."'";
			}elseif($_POST['from_date']!=""&&$_POST['to_date']==""){
				$from_date=$GLOBALS['timedate']->to_db_date($_POST['from_date'],false);
				$where.=" AND DATE(date_modified)='".$from_date."' ";
			}elseif($_POST['from_date']==""&&$_POST['to_date']!=""){
				$to_date=$GLOBALS['timedate']->to_db_date($_POST['to_date'],false);
				$where.=" AND DATE(date_modified)='".$to_date."' ";
			}
			
			if(!empty($_POST['batch'])){	
				$where.=" AND lc.te_ba_batch_id_c IN('".implode("','",$_POST['batch'])."') ";
			}

			$councelorList=array();
			$vendors = $this->getVendor();
			if($vendors){
				foreach($vendors as $vendorval){
					$utm = $this->getUTM($vendorval['id']);
					if($utm){
						$whereutm="AND  (l.utm IN('".$utm."') OR l.vendor='".$vendorval['name']."') ";
					}
					else{
						$whereutm="AND  l.vendor='".$vendorval['name']."' ";
					}
					$leadSql="SELECT batch.name as Batchname,count(l.id) as total,l.status_description FROM leads l INNER JOIN leads_cstm lc ON l.id=lc.id_c INNER JOIN te_ba_batch as batch ON batch.id=lc.te_ba_batch_id_c  where l.deleted=0 $whereutm $where GROUP BY l.status_description,batch.id";
					$leadObj =$db->query($leadSql);
					
					$councelorList[$vendorval['id']]['name']=$vendorval['name'];
					while($row =$db->fetchByAssoc($leadObj)){
						$councelorList[$vendorval['id']][$row['status_description']]=$row['total'];
						$councelorList[$vendorval['id']]['Batchname']=$row['Batchname'];
					}
				}
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
			if(!isset($councelor['Re_Enquired']))
				$councelorList[$key]['Re_Enquired']=0;
			if(!isset($councelor['Wrong_Number']))
				$councelorList[$key]['Wrong_Number']=0;
				
			if(!isset($councelor['Grand_Total'])){
					$councelorList[$key]['Grand_Total']=$councelorList[$key]['Call_Back']
					+$councelorList[$key]['Converted']
					+$councelorList[$key]['Dead_Number']
					+$councelorList[$key]['Duplicate']
					+$councelorList[$key]['Fallout']
					+$councelorList[$key]['Follow_Up']
					+$councelorList[$key]['New_Lead']
					+$councelorList[$key]['Not_Eligible']
					+$councelorList[$key]['Not_Enquired']
					+$councelorList[$key]['Rejected']
					+$councelorList[$key]['Retired']
					+$councelorList[$key]['Ringing_Multiple_Times']
					+$councelorList[$key]['Re_Enquired']
					+$councelorList[$key]['Wrong_Number'];
					 
					 }		
			}
			
			foreach($councelorList as $key=>$councelor){
				$data.= "\"" . $councelor['Batchname'] . "\",\"" . $councelor['name'] . "\",\"" . $councelor['Duplicate'] . "\",\"" . $councelor['Dead_Number']."\",\"" . $councelor['Fallout']."\",\"" . $councelor['Not_Eligible']. "\",\"" . $councelor['Not_Enquired'] . "\",\"" . $councelor['Rejected'] . "\",\"" . $councelor['Retired'] . "\",\"" . $councelor['Ringing_Multiple_Times'] . "\",\"" . $councelor['Wrong_Number'] . "\",\"" . $councelor['Call_Back'] . "\",\"" . $councelor['Converted'] . "\",\"" . $councelor['Follow_Up'] . "\",\"" . $councelor['New_Lead'] . "\",\"" . $councelor['Prospect'] . "\",\"" . $councelor['Re_Enquired'] . "\",\"" . $councelor['Grand_Total'] . "\"\n";
			}
			
			ob_end_clean();
			header("Content-type: application/csv");
			header ('Content-disposition: attachment;filename=" '. $filename . '.csv";' );
			echo $data; exit;
		}
		$councelorList=array();
		$vendors = $this->getVendor();
		if($vendors){
		 
			foreach($vendors as $vendorval){
				$utm = $this->getUTM($vendorval['id']);
				if($utm){
					$whereutm="AND  (l.utm IN('".$utm."') OR l.vendor='".$vendorval['name']."') ";
				}
				else{
					$whereutm="AND  l.vendor='".$vendorval['name']."' ";
				}
				$leadSql="SELECT batch.name as Batchname,count(l.id) as total,l.status_description FROM leads l INNER JOIN leads_cstm lc ON l.id=lc.id_c INNER JOIN te_ba_batch as batch ON batch.id=lc.te_ba_batch_id_c  where l.deleted=0 $whereutm $where GROUP BY l.status_description,batch.id";
				$leadObj =$db->query($leadSql);
				
				$councelorList[$vendorval['id']]['name']=$vendorval['name'];
			 
				while($row =$db->fetchByAssoc($leadObj)){
					$row['status_description'] = str_replace(array(' ','-'),'_',$row['status_description']);
					$councelorList[$vendorval['id']][$row['status_description']]=$row['total'];
					$councelorList[$vendorval['id']]['Batchname']=$row['Batchname'];
				
				}
			}
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
			if(!isset($councelor['Re_Enquired']))
				$councelorList[$key]['Re_Enquired']=0;
			if(!isset($councelor['Wrong_Number']))
				$councelorList[$key]['Wrong_Number']=0;
				
			if(!isset($councelor['Grand_Total'])){
					$councelorList[$key]['Grand_Total']=$councelorList[$key]['Call_Back']
					+$councelorList[$key]['Converted']
					+$councelorList[$key]['Dead_Number']
					+$councelorList[$key]['Duplicate']
					+$councelorList[$key]['Fallout']
					+$councelorList[$key]['Follow_Up']
					+$councelorList[$key]['New_Lead']
					+$councelorList[$key]['Not_Eligible']
					+$councelorList[$key]['Not_Enquired']
					+$councelorList[$key]['Rejected']
					+$councelorList[$key]['Retired']
					+$councelorList[$key]['Ringing_Multiple_Times']
					+$councelorList[$key]['Re_Enquired']
					+$councelorList[$key]['Wrong_Number'];
					 
					 }		
					if(!isset($councelor['Batchvalue'])){
					$councelorList[$key]['Batchvalue']=$councelorList[$key]['Batchname'];
					//if(!isset($councelor['Batchname'])){
					//$councelorList[$key]['Batchname']="NA";
				
				}
				
		}
		
		$sugarSmarty = new Sugar_Smarty();
		$sugarSmarty->assign("councelorList",$councelorList);
		$sugarSmarty->assign("leadStatusList",$leadStatusList);
		$sugarSmarty->assign("batchList",$batchList);
		$sugarSmarty->assign("selected_from_date",$GLOBALS['timedate']->to_display_date($from_date));
		$sugarSmarty->assign("selected_to_date",$GLOBALS['timedate']->to_display_date($to_date));
		$sugarSmarty->assign("selected_status",$search_status);
		$sugarSmarty->display('custom/modules/AOR_Reports/tpls/dateleadperformance.tpl');
	}
}
?>

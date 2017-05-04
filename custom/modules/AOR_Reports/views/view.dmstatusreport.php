<?php
if (!defined('sugarEntry') || !sugarEntry)
	die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php'); 
class AOR_ReportsViewDmstatusreport extends SugarView {
	
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
			$data="Vendor,Alive,Warm,Dead,Converted\n";
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
					$leadSql="SELECT count(l.id) as total,l.status FROM leads l INNER JOIN leads_cstm lc ON l.id=lc.id_c where l.deleted=0 $whereutm $where GROUP BY l.status";
					$leadObj =$db->query($leadSql);
					
					$councelorList[$vendorval['id']]['name']=$vendorval['name'];
					while($row =$db->fetchByAssoc($leadObj)){
						$councelorList[$vendorval['id']][$row['status']]=$row['total'];
					}
				}
			}
			
			foreach($councelorList as $key=>$councelor){
				if(!isset($councelor['Alive']))
					$councelorList[$key]['Alive']=0;
				if(!isset($councelor['Warm']))
					$councelorList[$key]['Warm']=0;
				if(!isset($councelor['Dead']))
					$councelorList[$key]['Dead']=0;
				if(!isset($councelor['Converted']))
					$councelorList[$key]['Converted']=0;
			}
			
			
			foreach($councelorList as $key=>$councelor){	
				$data.= "\"" . $councelor['name'] . "\",\"" . $councelor['Alive'] . "\",\"" . $councelor['Warm']."\",\"" . $councelor['Dead']."\",\"" . $councelor['Converted']. "\"\n";
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
				$leadSql="SELECT count(l.id) as total,l.status FROM leads l INNER JOIN leads_cstm lc ON l.id=lc.id_c where l.deleted=0 $whereutm $where GROUP BY l.status";
				$leadObj =$db->query($leadSql);
				
				$councelorList[$vendorval['id']]['name']=$vendorval['name'];
				while($row =$db->fetchByAssoc($leadObj)){
					$councelorList[$vendorval['id']][$row['status']]=$row['total'];
				}
			}
		}
		
			
	
		foreach($councelorList as $key=>$councelor){
			if(!isset($councelor['Alive']))
				$councelorList[$key]['Alive']=0;
			if(!isset($councelor['Warm']))
				$councelorList[$key]['Warm']=0;
			if(!isset($councelor['Dead']))
				$councelorList[$key]['Dead']=0;
			if(!isset($councelor['Converted']))
				$councelorList[$key]['Converted']=0;
		}
		
		
		$sugarSmarty = new Sugar_Smarty();
		$sugarSmarty->assign("councelorList",$councelorList);
		$sugarSmarty->assign("leadStatusList",$leadStatusList);
		$sugarSmarty->assign("batchList",$batchList);
		$sugarSmarty->assign("selected_from_date",$GLOBALS['timedate']->to_display_date($from_date));
		$sugarSmarty->assign("selected_to_date",$GLOBALS['timedate']->to_display_date($to_date));
		$sugarSmarty->assign("selected_status",$search_status);
		$sugarSmarty->display('custom/modules/AOR_Reports/tpls/dmstatusreport.tpl');
	}
}
?>
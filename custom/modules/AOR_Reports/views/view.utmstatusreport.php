<?php
if (!defined('sugarEntry') || !sugarEntry)
	die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php'); 
class AOR_ReportsViewUtmstatusreport extends SugarView {
	
	public function __construct() {
		parent::SugarView();
	}	
	
	function getUTM(){
		global $db;
		$vendorSql="SELECT name,id FROM `te_utm` WHERE utm_status IN ('Live') AND deleted=0 order by date_modified desc";
		$vendorObj =$db->query($vendorSql);
		$vendorArr = [];
		while($vendor =$db->fetchByAssoc($vendorObj)){
			$vendorArr[]=$vendor;
		}
		return $vendorArr;
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
			$data="UTM,Alive,Warm,Dead,Converted\n";
			$file = "utm_status_report";
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
			$vendors = $this->getUTM();
			if($vendors){
				foreach($vendors as $vendorval){
					$leadSql="SELECT count(l.id) as total,l.status FROM leads l INNER JOIN leads_cstm lc ON l.id=lc.id_c where l.deleted=0 AND l.utm='".$vendorval['name']."' $where GROUP BY l.status";
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
		$vendors = $this->getUTM();
		if($vendors){
			foreach($vendors as $vendorval){
				$leadSql="SELECT count(l.id) as total,l.status FROM leads l INNER JOIN leads_cstm lc ON l.id=lc.id_c where l.deleted=0 AND l.utm='".$vendorval['name']."' $where GROUP BY l.status";
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
		$sugarSmarty->display('custom/modules/AOR_Reports/tpls/utmstatusreport.tpl');
	}
}
?>
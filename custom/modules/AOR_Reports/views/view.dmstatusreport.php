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
		$vendorSql="SELECT distinct(trim(name))name,id FROM `te_vendor` WHERE deleted=0 order by name asc";
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
			$_SESSION['ds_from_date'] = $_REQUEST['from_date'];
			$_SESSION['ds_to_date'] = $_REQUEST['to_date'];
			$_SESSION['ds_batch'] = $_REQUEST['batch'];
			if($_SESSION['ds_from_date']!=""&&$_SESSION['ds_to_date']){
				$from_date=date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['ds_from_date'])));
				$to_date=date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['ds_to_date'])));
				$where.=" AND DATE(l.date_entered)>='".$from_date."' AND DATE(l.date_entered)<='".$to_date."'";
			}elseif($_SESSION['ds_from_date']!=""&&$_SESSION['ds_to_date']==""){
				$from_date=date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['ds_from_date'])));
				$where.=" AND DATE(date_entered)='".$from_date."' ";
			}elseif($_SESSION['ds_from_date']==""&&$_SESSION['ds_to_date']!=""){
				$to_date=date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['ds_to_date'])));
				$where.=" AND DATE(date_entered)='".$to_date."' ";
			}

			if(!empty($_SESSION['ds_batch'])){
				$where.=" AND lc.te_ba_batch_id_c IN('".implode("','",$_SESSION['ds_batch'])."') ";
			}
		}elseif(isset($_POST['export']) && $_POST['export']=="Export"){
			$data="Vendor,Alive,Warm,Dead,Converted\n";
			$file = "status_report";
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

		$vendors_data = $this->getVendor();
		$total=count($vendors_data); #total records
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
			$page=($_REQUEST['page']-1);
			$left=1;
		}

		//$vendors=array_slice($vendors,$start,$per_page);
		if($total>$per_page){
			$current="(".($start+1)."-".($start+$per_page)." of ".$total.")";

		}else{
			$current="(".($start+1)."-".count($vendors_data)." of ".$total.")";

		}

		$leadSql="SELECT COUNT(l.id)total,vendor.name,vendor.id FROM `te_vendor` AS vendor LEFT JOIN leads AS l ON l.vendor=vendor.name AND l.deleted=0 WHERE vendor.deleted=0  GROUP BY vendor.id LIMIT $start,$per_page";
		$leadObj =$db->query($leadSql);


		while($row =$db->fetchByAssoc($leadObj)){
			$councelorList[$row['id']]['name']=$row['name'];
			$where.="AND  l.vendor='".$row['name']."' ";
			$result = $this->getLeadStatusCountByVendor($where);
			if($result){
				foreach ($result as $key => $value) {
					$councelorList[$row['id']][$value['status']]=$value['total'];
				}
			}
			else{
				$councelorList[$row['id']]['Alive']=0;
				$councelorList[$row['id']]['Warm']=0;
				$councelorList[$row['id']]['Dead']=0;
				$councelorList[$row['id']]['Converted']=0;
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

		if(isset($_SESSION['ds_from_date']) && !empty($_SESSION['ds_from_date'])){
			$from_date = date('d-m-Y',strtotime($_SESSION['ds_from_date']));
		}
		if(isset($_SESSION['ds_to_date']) && !empty($_SESSION['ds_to_date'])){
			$to_date = date('d-m-Y',strtotime($_SESSION['ds_to_date']));
		}
		if(isset($_SESSION['ds_batch']) && !empty($_SESSION['ds_batch'])){
			$selected_batch = $_SESSION['ds_batch'];
		}

		$sugarSmarty = new Sugar_Smarty();
		$sugarSmarty->assign("councelorList",$councelorList);
		$sugarSmarty->assign("leadStatusList",$leadStatusList);
		$sugarSmarty->assign("batchList",$batchList);
		$sugarSmarty->assign("selected_from_date",$from_date);
		$sugarSmarty->assign("selected_to_date",$to_date);
		$sugarSmarty->assign("selected_batch",$selected_batch);

		$sugarSmarty->assign("current_records",$current);
		$sugarSmarty->assign("page",$page);
		$sugarSmarty->assign("pagenext",$pagenext);
		$sugarSmarty->assign("right",$right);
		$sugarSmarty->assign("left",$left);
		$sugarSmarty->assign("last_page",$last_page);
		$sugarSmarty->display('custom/modules/AOR_Reports/tpls/dmstatusreport.tpl');
	}

	function getLeadStatusCountByVendor($where){
		global $db;
		$leadSql="SELECT count(l.id) as total,l.status FROM leads l INNER JOIN leads_cstm lc ON l.id=lc.id_c where l.deleted=0  $where GROUP BY l.status";
		$leadObj =$db->query($leadSql);
		$statusArr=[];
		while($row =$db->fetchByAssoc($leadObj)){
			$statusArr[]=$row;
		}
		return $statusArr;
	}
}
?>

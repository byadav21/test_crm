<?php
if (!defined('sugarEntry') || !sugarEntry)
	die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');
class AOR_ReportsViewStatusreport extends SugarView {

	var $report_to_id;
	var $counsellors_arr;
	public function __construct() {
		parent::SugarView();
	}
	function reportingUser($currentUserId){
		$userObj = new User();
		$userObj->disable_row_level_security = true;
		$userList = $userObj->get_full_list("", "users.reports_to_id='".$currentUserId."'");
		if(!empty($userList)){
			foreach($userList as $record){
				if(!empty($record->reports_to_id) && !empty($record->id)){
					$this->report_to_id[] = $record->id;
					$this->counsellors_arr[$record->id] = $record->name;
					$this->reportingUser($record->id);
				}
			}
		}
	}
	function getCouncelor($user_id){
		global $db;
		$userSql="SELECT CONCAT(first_name,' ',last_name) as name FROM users WHERE deleted=0 AND id='".$user_id."'";
		$userObj =$db->query($userSql);
		$user =$db->fetchByAssoc($userObj);
		return $user['name'];
	}
	function getVendors(){
		global $db;
		$vendorArr = [];
		$vendorSql="SELECT id,name FROM te_vendor WHERE deleted=0 AND vendor_status='Active'";
		$vendorObj =$db->query($vendorSql);
		while($vendors =$db->fetchByAssoc($vendorObj)){
			$vendorArr[] = $vendors;
		}
		return $vendorArr;
	}
	function getContracts(){
		global $db;
		$vendorArr = [];
		$vendorSql="SELECT GROUP_CONCAT(DISTINCT u.contract_type)contract_type,v.id AS vendorid,v.name AS vendor,u.id,u.name FROM `te_utm` AS u INNER JOIN te_vendor_te_utm_1_c AS uv ON uv.te_vendor_te_utm_1te_utm_idb=u.id INNER JOIN te_vendor AS v ON v.id=uv.te_vendor_te_utm_1te_vendor_ida WHERE u.deleted=0 AND v.deleted=0 AND v.vendor_status='Active' GROUP BY v.id";
		$vendorObj =$db->query($vendorSql);
		while($vendors =$db->fetchByAssoc($vendorObj)){
			$contract_type = explode(',',$vendors['contract_type']);
			foreach($contract_type as $cval){
				$vendorArr[] = array(
					'vendorid'=>$vendors['vendorid'],
					'contract_type'=>$cval,
					'vendor'=>$vendors['vendor'],
					'id'=>$vendors['id'],
					'name'=>$vendors['name'],
				);
			}

		}
		return $vendorArr;
	}

	function getUtmContract(){
		global $db;
		$vendorArr = [];
		$vendorSql="SELECT v.id AS vendorid,v.name AS vendor,u.id,u.name,u.contract_type,(select name from aos_contracts WHERE deleted=0 and id=u.`aos_contracts_id_c`)contract FROM `te_utm` AS u INNER JOIN te_vendor_te_utm_1_c AS uv ON uv.te_vendor_te_utm_1te_utm_idb=u.id INNER JOIN te_vendor AS v ON v.id=uv.te_vendor_te_utm_1te_vendor_ida WHERE u.deleted=0";
		$vendorObj =$db->query($vendorSql);
		while($vendors =$db->fetchByAssoc($vendorObj)){
			$vendorArr[] = $vendors;
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
	function getVendorByID($vendorid){
		global $db;
		$batchSql="SELECT name from te_vendor WHERE id='".$vendorid."'";
		$batchObj =$db->query($batchSql);
		$row =$db->fetchByAssoc($batchObj);
		return $row['name'];
	}
	function getUtmByContractIDs($vAndCtVendorArr,$vAndCtArr){
		global $db;
		$batchSql="SELECT u.name from te_utm AS u INNER JOIN te_vendor_te_utm_1_c AS uv on uv.te_vendor_te_utm_1te_utm_idb=u.id WHERE u.deleted=0 AND uv.te_vendor_te_utm_1te_vendor_ida IN('".implode("','",$vAndCtVendorArr)."') AND u.contract_type IN('".implode("','",$vAndCtArr)."')";
		$batchObj =$db->query($batchSql);
		$batchOptions=array();
		while($row =$db->fetchByAssoc($batchObj)){
			$batchOptions[]=$row['name'];
		}
		return $batchOptions;
	}
	public function display() {
		global $sugar_config,$app_list_strings,$current_user,$db;
    $leadsData=array();
		$is_admin = $current_user->is_admin;
		$vendorList = $this->getVendors();
		$contractList = $this->getContracts();
		$utmContracts = $this->getUtmContract();
		$utmContractArr['NA'] = 'NA';
		$utmVendorArr['NA'] = 'NA';
		$utmContractTypeArr['NA'] = 'NA';
		foreach($utmContracts as $val){
			$utmContractArr[$val['name']] = $val['contract'];
			$utmVendorArr[$val['name']] = $val['vendor'];
			$utmContractTypeArr[$val['name']] = $val['contract_type'];
		}

		$this->counsellors_arr[$current_user->id] = $current_user->name;
		$user_id=$current_user->id;
		$this->report_to_id[]=$user_id;
		$users = $this->reportingUser($user_id);
		#Get lead status drop down option
		$leadStatusList=$GLOBALS['app_list_strings']['lead_status_dom'];
		#Get batch drop down option
		$batchList=$this->getBatch();

		$uid=$this->report_to_id;# list of user ids
		# Query for batch drop down options
		$where="";
		$from_date="";
		$to_date="";
		if(isset($_POST['button']) || isset($_POST['export'])) {
			$_SESSION['ccstatus_from_date'] = $_REQUEST['from_date'];
			$_SESSION['ccstatus_to_date'] = $_REQUEST['to_date'];
			$_SESSION['ccstatus_counsellor'] = $_REQUEST['counsellor'];
			$_SESSION['ccstatus_batch'] = $_REQUEST['batch'];
			$_SESSION['ccstatus_vendors'] = $_REQUEST['vendors'];
			$_SESSION['ccstatus_medium_val'] = $_REQUEST['medium_val'];
			$selected_from_date=$_SESSION['ccstatus_from_date'];
			$selected_to_date=$_SESSION['ccstatus_to_date'];
		}

		if($_SESSION['ccstatus_from_date']!="" && $_SESSION['ccstatus_to_date']!=""){
			$from_date=date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['ccstatus_from_date'])));
			$to_date=date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['ccstatus_to_date'])));
			$where.=" AND DATE(l.date_entered)>='".$from_date."' AND DATE(l.date_entered)<='".$to_date."'";
		}elseif($_SESSION['ccstatus_from_date']!="" && $_SESSION['ccstatus_to_date']==""){
			$from_date=date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['ccstatus_from_date'])));
			$where.=" AND DATE(l.date_entered)>='".$from_date."' ";
		}elseif($_SESSION['ccstatus_from_date']=="" && $_SESSION['ccstatus_to_date']!=""){
			$to_date=date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['ccstatus_to_date'])));
			$where.=" AND DATE(l.date_entered)<='".$to_date."' ";
		}
		if(!empty($_SESSION['ccstatus_counsellor'])){
			 $selected_counsellor=$_SESSION['ccstatus_counsellor'];
			 $uid=$_SESSION['ccstatus_counsellor'];
		}
		if(!empty($_SESSION['ccstatus_batch'])){
			$selected_batch = $_SESSION['ccstatus_batch'];
			$where.=" AND lc.te_ba_batch_id_c IN('".implode("','",$_SESSION['ccstatus_batch'])."') ";
		}
		if($is_admin==1){
			$selected_vendor = $_SESSION['ccstatus_vendors'];
			$selected_medium_val = $_SESSION['ccstatus_medium_val'];
			if(!empty($_SESSION['ccstatus_vendors']) && empty($_SESSION['ccstatus_medium_val'])){
				 $vendor_name=$this->getVendorByID($_SESSION['ccstatus_vendors']);
				 if($vendor_name){
					 $where.=" AND l.vendor IN('".$vendor_name."') ";
				 }
			}
			elseif(!empty($_SESSION['ccstatus_medium_val']) && empty($_SESSION['ccstatus_vendors'])){
				$vAndCtVendorArr=[];
				$vAndCtArr=[];
				foreach($_SESSION['ccstatus_medium_val'] as $val){
					$valVandCT = explode('_TE_',$val);
					if(count($valVandCT)>1){
						$vAndCtVendorArr[]=$valVandCT[0];
						$vAndCtArr[]=$valVandCT[1];
					}

				}
				$utm_names=$this->getUtmByContractIDs($vAndCtVendorArr,$vAndCtArr);
				if($utm_names){
					$where.=" AND l.utm IN('".implode("','",$utm_names)."') ";
				}
			}
			elseif(!empty($_SESSION['ccstatus_medium_val']) && !empty($_SESSION['ccstatus_vendors'])){
				$vAndCtVendorArr=[];
				$vAndCtArr=[];
				foreach($_SESSION['ccstatus_medium_val'] as $val){
					$valVandCT = explode('_TE_',$val);
					if(count($valVandCT)>1){
						$vAndCtVendorArr[]=$valVandCT[0];
						$vAndCtArr[]=$valVandCT[1];
					}

				}
				$utm_names=$this->getUtmByContractIDs($vAndCtVendorArr,$vAndCtArr);
				if($utm_names){
					$where.=" AND l.utm IN('".implode("','",$utm_names)."') ";
				}
			}
		}
		if(isset($_POST['export']) && $_POST['export']=="Export"){

			if($is_admin==1){
					$data="Counsellors,Vendor,Medium,Batch,Alive,Warm,Dead\n";
			}
			else{
					$data="Counsellors,Alive,Warm,Dead\n";
			}
			$file = "status_report";
			$from_date="";
			$to_date="";
			$filename = $file . "_" . date ( "Y-m-d");
			/*if($_POST['from_date']!=""&&$_POST['to_date']){
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
			}*/
			if($is_admin==1){
				$leadSql="SELECT count(l.id) as total,(select name FROM te_ba_batch where id=lc.te_ba_batch_id_c)batch,l.utm,l.assigned_user_id,l.status FROM leads l INNER JOIN leads_cstm lc ON l.id=lc.id_c where l.deleted=0 AND l.assigned_user_id IN('".implode("','",$uid)."') ".$where." GROUP BY l.assigned_user_id,l.status,l.utm";
				$leadObj =$db->query($leadSql);
				$councelorList=array();
				while($row =$db->fetchByAssoc($leadObj)){
					if(trim($row['batch'])==''){
						$row['batch']='NA';
					}
					if(trim($row['utm'])==''){
						$row['utm']='NA';
					}
					$utmv = ($utmVendorArr[$row['utm']]?$utmVendorArr[$row['utm']]:'Invalid');
					$utmct = ($utmVendorArr[$row['utm']]?$utmContractTypeArr[$row['utm']]:'Invalid');

					$councelorList[$row['assigned_user_id'].'_TE_'.$row['utm']][$row['status']]=$row['total'];
					$councelorList[$row['assigned_user_id'].'_TE_'.$row['utm']]['vendor']=($utmVendorArr[$row['utm']]?$utmVendorArr[$row['utm']]:'Invalid');
					$councelorList[$row['assigned_user_id'].'_TE_'.$row['utm']]['batch']=$row['batch'];
					$councelorList[$row['assigned_user_id'].'_TE_'.$row['utm']]['contract']=$utmct;
					$councelorList[$row['assigned_user_id'].'_TE_'.$row['utm']]['name']=$this->counsellors_arr[$row['assigned_user_id']];
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
					$data.= "\"" . $councelor['name'] . "\",\"" . $councelor['vendor'] . "\",\"" . $councelor['contract'] . "\",\"" . $councelor['batch'] . "\",\"" . $councelor['Alive'] . "\",\"" . $councelor['Warm']."\",\"" . $councelor['Dead']."\"\n";
				}

			}
			else{
				$leadSql="SELECT count(l.assigned_user_id) as total,l.assigned_user_id,l.status FROM leads l INNER JOIN leads_cstm lc ON l.id=lc.id_c where l.deleted=0 AND  l.assigned_user_id IN('".implode("','",$uid)."') ".$where." GROUP BY l.assigned_user_id,l.status";

				$leadObj =$db->query($leadSql);
				$councelorList=array();
				while($row =$db->fetchByAssoc($leadObj)){
					$councelorList[$row['assigned_user_id']][$row['status']]=$row['total'];
					$councelorList[$row['assigned_user_id']]['name']=$this->getCouncelor($row['assigned_user_id']);
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
					$data.= "\"" . $councelor['name'] . "\",\"" . $councelor['Alive'] . "\",\"" . $councelor['Warm']."\",\"" . $councelor['Dead']."\"\n";
				}
			}

			ob_end_clean();
			header("Content-type: application/csv");
			header ('Content-disposition: attachment;filename=" '. $filename . '.csv";' );
			echo $data; exit;
		}

		if($is_admin==1){
			$leadSql="SELECT count(l.id) as total,(select name FROM te_ba_batch where id=lc.te_ba_batch_id_c)batch,l.utm,l.assigned_user_id,l.status FROM leads l INNER JOIN leads_cstm lc ON l.id=lc.id_c where l.deleted=0 AND l.assigned_user_id IN('".implode("','",$uid)."') ".$where." GROUP BY l.assigned_user_id,l.status,l.utm";

			$leadObj =$db->query($leadSql);
			$councelorList=array();
			while($row =$db->fetchByAssoc($leadObj)){
				if(trim($row['batch'])==''){
					$row['batch']='NA';
				}
				if(trim($row['utm'])==''){
					$row['utm']='NA';
				}
				$utmv = ($utmVendorArr[$row['utm']]?$utmVendorArr[$row['utm']]:'Invalid');
				$utmct = ($utmVendorArr[$row['utm']]?$utmContractTypeArr[$row['utm']]:'Invalid');

				$councelorList[$row['assigned_user_id'].'_TE_'.$row['utm']][$row['status']]=$row['total'];
				$councelorList[$row['assigned_user_id'].'_TE_'.$row['utm']]['vendor']=($utmVendorArr[$row['utm']]?$utmVendorArr[$row['utm']]:'Invalid');
				$councelorList[$row['assigned_user_id'].'_TE_'.$row['utm']]['batch']=$row['batch'];
				$councelorList[$row['assigned_user_id'].'_TE_'.$row['utm']]['contract']=$utmct;
				$councelorList[$row['assigned_user_id'].'_TE_'.$row['utm']]['name']=$this->counsellors_arr[$row['assigned_user_id']];
			}
		}
		else{
			$leadSql="SELECT count(l.assigned_user_id) as total,l.assigned_user_id,l.status FROM leads l INNER JOIN leads_cstm lc ON l.id=lc.id_c where l.deleted=0 AND  l.assigned_user_id IN('".implode("','",$uid)."') ".$where." GROUP BY l.assigned_user_id,l.status";
			$leadObj =$db->query($leadSql);
			$councelorList=array();
			while($row =$db->fetchByAssoc($leadObj)){
				$councelorList[$row['assigned_user_id']][$row['status']]=$row['total'];
				$councelorList[$row['assigned_user_id']]['name']=$this->counsellors_arr[$row['assigned_user_id']];
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
		//echo "<pre>";print_r($councelorList);
		$total=count($councelorList); #total records
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

		$councelorList=array_slice($councelorList,$start,$per_page);
		if($total>$per_page){
			$current="(".($start+1)."-".($start+$per_page)." of ".$total.")";

		}else{
			$current="(".($start+1)."-".count($councelorList)." of ".$total.")";

		}
	#pE
		$sugarSmarty = new Sugar_Smarty();
		$sugarSmarty->assign("councelorList",$councelorList);
		$sugarSmarty->assign("councelorArr",$this->counsellors_arr);
		$sugarSmarty->assign("vendorList",$vendorList);
		$sugarSmarty->assign("contractList",$contractList);
		$sugarSmarty->assign("is_admin",$is_admin);
		$sugarSmarty->assign("leadStatusList",$leadStatusList);
		$sugarSmarty->assign("batchList",$batchList);

		$sugarSmarty->assign("selected_from_date",$selected_from_date);
		$sugarSmarty->assign("selected_to_date",$selected_to_date);
		$sugarSmarty->assign("selected_vendor",$selected_vendor);
		$sugarSmarty->assign("selected_medium_val",$selected_medium_val);
		$sugarSmarty->assign("selected_batch",$selected_batch);
		$sugarSmarty->assign("selected_counsellor",$selected_counsellor);

		$sugarSmarty->assign("current_records",$current);
		$sugarSmarty->assign("page",$page);
		$sugarSmarty->assign("pagenext",$pagenext);
		$sugarSmarty->assign("right",$right);
		$sugarSmarty->assign("left",$left);
		$sugarSmarty->assign("last_page",$last_page);
		$sugarSmarty->display('custom/modules/AOR_Reports/tpls/statusreport.tpl');
	}
}
?>

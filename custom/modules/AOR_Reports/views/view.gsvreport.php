<?php
if (!defined('sugarEntry') || !sugarEntry)
	die('Not A Valid Entry Point');
	require_once('custom/include/Email/sendmail.php');
class AOR_ReportsViewGsvreport extends SugarView {
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
		$userSql="SELECT id,CONCAT(first_name,' ',last_name) as name FROM users WHERE deleted=0 AND id='".$user_id."'";
		$userObj =$db->query($userSql);
		$user =$db->fetchByAssoc($userObj);
		return $user['name'];
	}

	function getCouncelorid($user_id){
		global $db;
		$userSql="SELECT id,CONCAT(first_name,' ',last_name) as name FROM users WHERE deleted=0 AND id='".$user_id."'";
		$userObj =$db->query($userSql);
		$user =$db->fetchByAssoc($userObj);
		$useropt[]=$user;
		return $user;
	}


	function getGSV($user_id,$wheregsv=NULL){
		global $db;
	  $batchSql="SELECT b.fees_inr as gsv,count(l.id)totalleads,b.id FROM leads l INNER JOIN leads_cstm lc on l.id=lc.id_c INNER JOIN te_ba_batch b ON lc.te_ba_batch_id_c=b.id where l.deleted=0 AND l.status='Converted' AND l.assigned_user_id='".$user_id."' $wheregsv GROUP BY b.id ";
		$batchObj =$db->query($batchSql);
		$batch_gsv=[];
		while($batch =$db->fetchByAssoc($batchObj)){
			$batch_gsv[]=($batch['gsv'] && $batch['totalleads']?$batch['gsv'] * $batch['totalleads']:'0.00');
		}
		if($batch_gsv){
			return array_sum($batch_gsv);
		}
		else{
			return 0;
		}
		return $batch['gsv'];
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
		$this->counsellors_arr[$current_user->id] = $current_user->name;
    $leadsData=array();
		$user_id=$current_user->id;
		$this->report_to_id[]=$user_id;
		$users = $this->reportingUser($user_id);

		#Get lead status drop down option
		$leadStatusList=$GLOBALS['app_list_strings']['lead_status_dom'];
		#Get batch drop down option
		$batchList=$this->getBatch();
		#print_r($users);
		#print_r($this->report_to_id);die;
		$uid=$this->report_to_id;# list of user ids

		# Query for batch drop down options
		$where="";
		$from_date="";
		$to_date="";
		$selected_counsellor="";
		if(isset($_POST['button']) || $_POST['export']) {
			$_SESSION['ccgsv_from_date'] = $_REQUEST['from_date'];
			$_SESSION['ccgsv_to_date'] = $_REQUEST['to_date'];
			$_SESSION['ccgsv_counsellor'] = $_REQUEST['counsellor'];
		}

			if($_SESSION['ccgsv_from_date']!="" && $_SESSION['ccgsv_to_date']!=""){
				$from_date=date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['ccgsv_from_date'])));
				$to_date=date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['ccgsv_to_date'])));
				$where.=" AND DATE(l.converted_date)>='".$from_date."' AND DATE(l.converted_date)<='".$to_date."'";
				$wheregsv.=" AND DATE(l.converted_date)>='".$from_date."' AND DATE(l.converted_date)<='".$to_date."'";
			}elseif($_SESSION['ccgsv_from_date']!="" && $_SESSION['ccgsv_to_date']==""){
				$from_date=date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['ccgsv_from_date'])));
				$where.=" AND DATE(l.converted_date)>='".$from_date."' ";
				$wheregsv.=" AND DATE(l.converted_date)>='".$from_date."' ";
			}elseif($_SESSION['ccgsv_from_date']=="" && $_SESSION['ccgsv_to_date']!=""){
				$to_date=date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['ccgsv_to_date'])));
				$where.=" AND DATE(l.converted_date)<='".$to_date."' ";
				$wheregsv.=" AND DATE(l.converted_date)<='".$to_date."' ";
			}
			if(!empty($_SESSION['ccgsv_counsellor'])){
				 $selected_counsellor=$_SESSION['ccgsv_counsellor'];
				 $uid=$_SESSION['ccgsv_counsellor'];
			}
		if(isset($_POST['export']) && $_POST['export']=="Export"){
			$data="Counsellors,Conversion,GSV\n";
			$file = "status_report";
			$where='';
			$from_date="";
			$to_date="";
			$filename = $file . "_" . date ( "Y-m-d");

			$leadSql="SELECT count(l.id) as total,l.assigned_user_id,l.status FROM leads l INNER JOIN leads_cstm lc ON l.id=lc.id_c where l.deleted=0 AND  l.assigned_user_id IN('".implode("','",$uid)."') ".$where." GROUP BY l.assigned_user_id,l.status";

			$leadObj =$db->query($leadSql);
			$councelorList=array();
			while($row =$db->fetchByAssoc($leadObj)){
				$councelorList[$row['assigned_user_id']][$row['status']]=$row['total'];
				$councelorList[$row['assigned_user_id']]['name']=$this->counsellors_arr[$row['assigned_user_id']];
				$councelorList[$row['assigned_user_id']]['gsv']=$this->getGSV($row['assigned_user_id'],$wheregsv);

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
				$data.= "\"" . $councelor['name'] . "\",\"" . $councelor['Converted'] . "\",\"". $councelor['gsv']. "\"\n";
			}
			ob_end_clean();
			header("Content-type: application/csv");
			header ('Content-disposition: attachment;filename=" '. $filename . '.csv";' );
			echo $data; exit;
		}

		$leadSql="SELECT count(l.id) as total,l.assigned_user_id,l.status FROM leads l INNER JOIN leads_cstm lc ON l.id=lc.id_c where l.deleted=0 AND  l.assigned_user_id IN('".implode("','",$uid)."') ".$where." GROUP BY l.assigned_user_id,l.status";
		$leadObj =$db->query($leadSql);
		$councelorList=array();
		while($row =$db->fetchByAssoc($leadObj)){

			$councelorList[$row['assigned_user_id']][$row['status']]=$row['total'];
			$councelorList[$row['assigned_user_id']]['name']=$this->counsellors_arr[$row['assigned_user_id']];
			$councelorList[$row['assigned_user_id']]['gsv']=$this->getGSV($row['assigned_user_id'],$wheregsv);
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


			#PS @Manish
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

		if(isset($_SESSION['ccgsv_from_date']) && !empty($_SESSION['ccgsv_from_date'])){
			$from_date = date('d-m-Y',strtotime($_SESSION['ccgsv_from_date']));
		}
		if(isset($_SESSION['ccgsv_to_date']) && !empty($_SESSION['ccgsv_to_date'])){
			$to_date = date('d-m-Y',strtotime($_SESSION['ccgsv_to_date']));
		}
		if(isset($_SESSION['ccgsv_counsellor']) && !empty($_SESSION['ccgsv_counsellor'])){
			$selected_counsellor = $_SESSION['ccgsv_counsellor'];
		}
		$sugarSmarty = new Sugar_Smarty();
		$sugarSmarty->assign("councelorList",$councelorList);
		$sugarSmarty->assign("councelorArr",$this->counsellors_arr);
		$sugarSmarty->assign("leadStatusList",$leadStatusList);
		$sugarSmarty->assign("batchList",$batchList);
		$sugarSmarty->assign("selected_from_date",$from_date);
		$sugarSmarty->assign("selected_to_date",$to_date);
		$sugarSmarty->assign("selected_counsellor",$selected_counsellor);
		$sugarSmarty->assign("current_records",$current);
		$sugarSmarty->assign("page",$page);
		$sugarSmarty->assign("pagenext",$pagenext);
		$sugarSmarty->assign("right",$right);
		$sugarSmarty->assign("left",$left);
		$sugarSmarty->assign("last_page",$last_page);
		$sugarSmarty->display('custom/modules/AOR_Reports/tpls/gsvreport.tpl');
	}
}
?>

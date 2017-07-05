<?php
if (!defined('sugarEntry') || !sugarEntry)
	die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');
class AOR_ReportsViewPipelinereport extends SugarView {

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
	function getGSV($user_id,$wheregsv=NULL){
		global $db;
		$batchSql="SELECT b.fees_inr as gsv,count(l.id)totalleads,b.id FROM leads l INNER JOIN leads_cstm lc on l.id=lc.id_c INNER JOIN te_ba_batch b ON lc.te_ba_batch_id_c=b.id where l.deleted=0 AND l.status='Warm' AND b.deleted=0 AND l.assigned_user_id='".$user_id."' $wheregsv GROUP BY b.id ";
		$batchObj =$db->query($batchSql);
		$gsvArr=[];
		while($batch =$db->fetchByAssoc($batchObj)){
			$gsvArr[]=($batch['gsv'] && $batch['totalleads']?$batch['gsv'] * $batch['totalleads']:'0.00');
		}
		if($gsvArr){
			return array_sum($gsvArr);
		}
		else{
			return '0.00';
		}
	}
	public function display() {
		global $sugar_config,$app_list_strings,$current_user,$db;
        $leadsData=array();
		$user_id=$current_user->id;
		$this->report_to_id[]=$user_id;
		$users = $this->reportingUser($user_id);
		#print_r($users);
		#print_r($this->report_to_id);die;
		$uid=$this->report_to_id;# list of user ids

		# Query for batch drop down options
		$where="";
		$wheregsv="";
		$from_date="";
		$to_date="";
		if(isset($_POST['button']) || $_POST['export']) {
			$_SESSION['ccp_from_date'] = $_REQUEST['from_date'];
			$_SESSION['ccp_to_date'] = $_REQUEST['to_date'];
		}
		if(isset($_POST['export']) && $_POST['export']=="Export"){
			$data="Counsellors,Warm,GSV\n";
			$file = "pipeline_report";
			$where='';
			$from_date="";
			$to_date="";
			$filename = $file . "_" . date ( "Y-m-d");
			if($_SESSION['ccp_from_date']!="" && $_SESSION['ccp_to_date']){
				$from_date=date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['ccp_from_date'])));
				$to_date=date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['ccp_to_date'])));
				$where.=" AND DATE(date_entered)>='".$from_date."' AND DATE(date_entered)<='".$to_date."'";
				$wheregsv.=" AND DATE(l.date_entered)>='".$from_date."' AND DATE(l.date_entered)<='".$to_date."'";
			}elseif($_SESSION['ccp_from_date']!="" && $_SESSION['ccp_to_date']==""){
				$from_date=date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['ccp_from_date'])));
				$where.=" AND DATE(date_entered)>='".$from_date."' ";
				$wheregsv.=" AND DATE(l.date_entered)>='".$from_date."' ";
			}elseif($_SESSION['ccp_from_date']=="" && $_SESSION['ccp_to_date']!=""){
				$to_date=date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['ccp_to_date'])));
				$where.=" AND DATE(date_entered)<='".$to_date."' ";
				$wheregsv.=" AND DATE(l.date_entered)<='".$to_date."' ";
			}
			$leadSql="SELECT count(id) as warm,assigned_user_id FROM leads  where status='Warm' AND assigned_user_id IN('".implode("','",$uid)."') ".$where." GROUP BY assigned_user_id";

			$leadObj =$db->query($leadSql);
			$councelorList=array();
			while($row =$db->fetchByAssoc($leadObj)){
				$row['gsv']=$this->getGSV($row['assigned_user_id'],$wheregsv);
				$row['name']=$this->getCouncelor($row['assigned_user_id']);
				$councelorList[]=$row;
			}
			foreach($councelorList as $key=>$councelor){
				$data.= "\"" . $councelor['name'] . "\",\"" . $councelor['warm'] . "\",\"" . $councelor['gsv']."\",\"". "\"\n";
			}
			ob_end_clean();
			header("Content-type: application/csv");
			header ('Content-disposition: attachment;filename=" '. $filename . '.csv";' );
			echo $data; exit;
		}


		if($_SESSION['ccp_from_date']!="" && $_SESSION['ccp_to_date']){
			$from_date=date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['ccp_from_date'])));
			$to_date=date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['ccp_to_date'])));
			$where.=" AND DATE(date_entered)>='".$from_date."' AND DATE(date_entered)<='".$to_date."'";
			$wheregsv.=" AND DATE(l.date_entered)>='".$from_date."' AND DATE(l.date_entered)<='".$to_date."'";
		}elseif($_SESSION['ccp_from_date']!="" && $_SESSION['ccp_to_date']==""){
			$from_date=date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['ccp_from_date'])));
			$where.=" AND DATE(date_entered)>='".$from_date."' ";
			$wheregsv.=" AND DATE(l.date_entered)>='".$from_date."' ";
		}elseif($_SESSION['ccp_from_date']=="" && $_SESSION['ccp_to_date']!=""){
			$to_date=date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['ccp_to_date'])));
			$where.=" AND DATE(date_entered)<='".$to_date."' ";
			$wheregsv.=" AND DATE(l.date_entered)<='".$to_date."' ";
		}


		$leadSql="SELECT count(id) as warm,assigned_user_id FROM leads  where status='Warm' AND assigned_user_id IN('".implode("','",$uid)."') ".$where." GROUP BY assigned_user_id";

		$leadObj =$db->query($leadSql);
		$councelorList=array();
		while($row =$db->fetchByAssoc($leadObj)){
			$row['gsv']=$this->getGSV($row['assigned_user_id'],$wheregsv);
			$row['name']=$this->getCouncelor($row['assigned_user_id']);
			$councelorList[]=$row;
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
		if(isset($_SESSION['ccp_from_date']) && !empty($_SESSION['ccp_from_date'])){
			$from_date = date('d-m-Y',strtotime($_SESSION['ccp_from_date']));
		}
		if(isset($_SESSION['ccp_to_date']) && !empty($_SESSION['ccp_to_date'])){
			$to_date = date('d-m-Y',strtotime($_SESSION['ccp_to_date']));
		}
		$sugarSmarty = new Sugar_Smarty();
		$sugarSmarty->assign("councelorList",$councelorList);
		$sugarSmarty->assign("selected_from_date",$from_date);
		$sugarSmarty->assign("selected_to_date",$to_date);
		$sugarSmarty->assign("current_records",$current);
		$sugarSmarty->assign("page",$page);
		$sugarSmarty->assign("pagenext",$pagenext);
		$sugarSmarty->assign("right",$right);
		$sugarSmarty->assign("left",$left);
		$sugarSmarty->assign("last_page",$last_page);
		$sugarSmarty->display('custom/modules/AOR_Reports/tpls/pipelinereport.tpl');
	}
}
?>

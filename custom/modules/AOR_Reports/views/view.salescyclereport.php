<?php
if (!defined('sugarEntry') || !sugarEntry)
	die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');
class AOR_ReportsViewSalescyclereport extends SugarView {

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
		$user_id=$current_user->id;
		$this->report_to_id[]=$user_id;
		$users = $this->reportingUser($user_id);
		#Get batch drop down option
		$batchList=$this->getBatch();
		#print_r($users);
		#print_r($this->report_to_id);die;
		$uid=$this->report_to_id;# list of user ids

		# Query for batch drop down options
		$where="";
		if(isset($_POST['button']) || isset($_POST['export'])) {
			$_SESSION['ccsales_batch'] = $_REQUEST['batch'];
		}
		if(!empty($_SESSION['ccsales_batch'])) {
				$selected_batch=$_SESSION['ccsales_batch'];
				$where.=" AND lc.te_ba_batch_id_c IN('".implode("','",$_SESSION['ccsales_batch'])."') ";
		}
		if(isset($_POST['export']) && $_POST['export']=="Export"){
			$data="Counsellors,Average Conversion Time\n";
			$file = "sales_cycle_report";
			$from_date="";
			$to_date="";
			$filename = $file . "_" . date ( "Y-m-d");


			$leadSql=" SELECT AVG(DATEDIFF(l.converted_date,DATE(l.assigned_date))) as avg_conversion_time,l.assigned_user_id  FROM leads l INNER JOIN leads_cstm lc ON l.id=lc.id_c where l.deleted=0 AND l.status='Converted' AND l.assigned_user_id IN('".implode("','",$uid)."') $where GROUP BY l.assigned_user_id";

			$leadObj =$db->query($leadSql);
			$councelorList=array();
			while($row =$db->fetchByAssoc($leadObj)){
				$row['name']=$this->getCouncelor($row['assigned_user_id']);
				$councelorList[]=$row;
			}

			foreach($councelorList as $key=>$councelor){
				$data.= "\"" . $councelor['name'] . "\",\"" . $councelor['avg_conversion_time'] . "\"\n";
			}
			ob_end_clean();
			header("Content-type: application/csv");
			header ('Content-disposition: attachment;filename=" '. $filename . '.csv";' );
			echo $data; exit;
		}

		#$leadSql="SELECT count(l.assigned_user_id) as total,l.assigned_user_id,l.status FROM leads l INNER JOIN leads_cstm lc ON l.id=lc.id_c where l.deleted=0 ".$where." GROUP BY assigned_user_id,status";

		$leadSql=" SELECT AVG(DATEDIFF(l.converted_date,DATE(l.assigned_date))) as avg_conversion_time,l.assigned_user_id FROM leads l INNER JOIN leads_cstm lc ON l.id=lc.id_c where l.deleted=0 AND l.status='Converted' AND l.assigned_user_id IN('".implode("','",$uid)."') $where GROUP BY l.assigned_user_id";

		$leadObj =$db->query($leadSql);
		$councelorList=array();
		while($row =$db->fetchByAssoc($leadObj)){
			$row['name']=$this->getCouncelor($row['assigned_user_id']);
			$councelorList[]=$row;
		}

		$sugarSmarty = new Sugar_Smarty();
		$sugarSmarty->assign("councelorList",$councelorList);
		$sugarSmarty->assign("leadStatusList",$leadStatusList);
		$sugarSmarty->assign("batchList",$batchList);
		$sugarSmarty->assign("selected_batch",$selected_batch);
		$sugarSmarty->display('custom/modules/AOR_Reports/tpls/salescyclereport.tpl');
	}
}
?>

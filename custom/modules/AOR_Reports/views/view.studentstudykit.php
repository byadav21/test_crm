<?php
if (!defined('sugarEntry') || !sugarEntry)
	die('Not A Valid Entry Point');

require_once('custom/include/Email/sendmail.php');
class AOR_ReportsViewStudentStudyKit extends SugarView {


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
		$batchSql="SELECT b.name,b.id FROM te_ba_batch AS b INNER JOIN te_student_batch AS sb WHERE b.id=sb.te_ba_batch_id_c GROUP BY b.id";
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
		$srmrow =$db->query("SELECT user_id FROM `acl_roles_users` WHERE `role_id` IN('86800aa5-c8c2-5868-a690-58a88d188265') AND deleted=0");
		$srmArr=[];
		while($srmres =$db->fetchByAssoc($srmrow)){
		  $srmArr[]=$srmres['user_id'];
		}

		$uid=$this->report_to_id;# list of user ids
		$user_ids = "'" . implode("','", $uid) . "'";

		# Query for batch drop down options
		$where="";
		$selected_batch="";
			if(!empty($_POST['batch'])){
				$selected_batch=$_POST['batch'];
				$where.=" AND b.id IN('".implode("','",$_POST['batch'])."') ";
			}
			if(!empty($_POST['result'])){
				$where.=" AND sb.kit_status='".$_POST['result']."' ";
			}
			if(!empty($user_ids) && ($current_user->is_admin==0 && !in_array($current_user->id,$srmArr))){
				$where.=" AND sb.assigned_user_id IN($user_ids)";
			}

		#Manish Kumar
		$leadSql="SELECT b.name AS batch,s.name AS student,s.email AS email,s.mobile AS mobile,sb.`address_confirmed`,sb.`kit_status`,sb.`completion_certificate_address` FROM te_student AS s INNER JOIN te_student_te_student_batch_1_c AS ssb ON s.id=ssb.te_student_te_student_batch_1te_student_ida INNER JOIN te_student_batch AS sb ON sb.id=ssb.te_student_te_student_batch_1te_student_batch_idb INNER JOIN te_ba_batch as b ON b.id=sb.te_ba_batch_id_c WHERE sb.status='Active' AND s.deleted=0 AND sb.deleted=0 ".$where."";

		$leadObj =$db->query($leadSql);
		$councelorList=array();
		while($row =$db->fetchByAssoc($leadObj)){
			$councelorList[]=$row;
		}
		if(isset($_POST['export']) && $_POST['export']=="Export"){
			$data="Student,Batch,Email,Phone,Address,Address Confirmed,Status\n";
			$file = "certificate_report";
			$filename = $file . "_" . date ( "Y-m-d");
			foreach($councelorList as $key=>$councelor){
				if($councelor['address_confirmed']==1){
					$status='Yes';
				}
				else if($councelor['address_confirmed']==2){
					$status='Yes';
				}
				else{
					$status='NA';
				}
				$data.= "\"" . $councelor['student'] . "\",\"" . $councelor['batch'] . "\",\"". $councelor['email']. "\",\"". $councelor['mobile']. "\",\"". $councelor['completion_certificate_address']. "\",\"". $status. "\",\"". $councelor['kit_status']. "\"\n";
			}
			ob_end_clean();
			header("Content-type: application/csv");
			header ('Content-disposition: attachment;filename=" '. $filename . '.csv";' );
			echo $data; exit;
		}
		$sugarSmarty = new Sugar_Smarty();
		$sugarSmarty->assign("councelorList",$councelorList);
		$sugarSmarty->assign("batchList",$batchList);
		$sugarSmarty->assign("selected_batch",$selected_batch);
		$sugarSmarty->display('custom/modules/AOR_Reports/tpls/studentstudykit.tpl');
	}
}
?>

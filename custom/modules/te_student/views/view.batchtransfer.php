<?php
if (!defined('sugarEntry') || !sugarEntry)
	die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php'); 
class te_studentViewBatchtransfer extends SugarView {
	
	public function __construct() {
		parent::SugarView();
	}
	function getBatch($studentId,$programId){
		global $db;	
		$studentBatchSql="SELECT sb.te_ba_batch_id_c as batch_id FROM te_student_te_student_batch_1_c sbr INNER JOIN `te_student_batch` sb ON sbr.te_student_te_student_batch_1te_student_batch_idb=sb.id WHERE sbr.te_student_te_student_batch_1te_student_ida='".$studentId."'";
		$studentBatchObj=$db->query($studentBatchSql);
		$currentBatch=array();
		while($student =$db->fetchByAssoc($studentBatchObj)){ 
			$currentBatch[]=$student['batch_id'];
		}
			
		$batchSql="SELECT b.id,b.name FROM te_pr_programs_te_ba_batch_1_c bpr INNER JOIN te_ba_batch b ON bpr.te_pr_programs_te_ba_batch_1te_ba_batch_idb=b.id  WHERE b.deleted=0 AND bpr.te_pr_programs_te_ba_batch_1te_pr_programs_ida='".$programId."' AND b.id NOT IN('".implode("','",$currentBatch)."')";
		$batchObj =$db->query($batchSql);
		$batchOptions=array();
		while($row =$db->fetchByAssoc($batchObj)){ 
			$batchOptions[]=$row;
		}
		return $batchOptions;
	}
	function getPrograms(){
		global $db;
		$programsList=array();
		$programSql="SELECT id, name FROM te_pr_programs WHERE deleted=0 ";
		$programObj =$db->query($programSql);
		while($row =$db->fetchByAssoc($programObj)){ 
			$programsList[]=$row;
		}
		return $programsList;
	}
	
	public function display() {
		global $sugar_config,$app_list_strings,$current_user,$db;
        $studentList=array();
		$studentBatchList=array();
		$where="";
		if(isset($_POST['button']) && $_POST['button']=="Search") {
			if($_POST['email']!=""){				
				$selected_email=$_POST['email'];
				$where.=" AND email='".$selected_email."' ";
			}
			if(!empty($_POST['phone'])){	
				$selected_phone=$_POST['phone'];
				$where.=" AND mobile='".$selected_phone."'";
			}
			$studentSql="SELECT id,name,email,mobile,country FROM te_student WHERE 1 ".$where;	
			$studentObj =$db->query($studentSql);
			while($row =$db->fetchByAssoc($studentObj)){
				$studentList[]=$row;
			}
			$studentBatchSql="SELECT sb.id,sb.name,sb.batch_start_date,sb.te_pr_programs_id_c as program_id FROM te_student_te_student_batch_1_c sbr INNER JOIN `te_student_batch` sb ON sbr.te_student_te_student_batch_1te_student_batch_idb=sb.id WHERE sb.deleted=0 AND sbr.te_student_te_student_batch_1te_student_ida='".$studentList[0]['id']."'";
			$studentBatchObj=$db->query($studentBatchSql);			
			while($row =$db->fetchByAssoc($studentBatchObj)){
				#if batch is started
				if($row['batch_start_date']<=date("Y-m-d")){
					$row['transferProgramList']=array();
					$row['transferBatchList']=$this->getBatch($studentList[0]['id'],$row['program_id']);
				}else{
					$row['transferProgramList']=$this->getPrograms();
					$row['transferBatchList']=array();					
				}
				$studentBatchList[]=$row;
			}
		}		
		$sugarSmarty = new Sugar_Smarty();
		$sugarSmarty->assign("studentList",$studentList);
		$sugarSmarty->assign("studentBatchList",$studentBatchList);
		$sugarSmarty->assign("selected_phone",$selected_phone);
		$sugarSmarty->assign("selected_email",$selected_email);
		$sugarSmarty->display('custom/modules/te_student/tpls/batchtransfer.tpl');
	}
}
?>
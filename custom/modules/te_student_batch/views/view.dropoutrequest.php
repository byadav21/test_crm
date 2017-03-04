<?php
if (!defined('sugarEntry') || !sugarEntry)
	die('Not A Valid Entry Point');
class te_student_batchViewDropoutrequest extends SugarView {
	public function __construct() {
		parent::SugarView();
	}
	function getInstitute($institute_id){
		global $db;
		$instituteSql="SELECT name FROM te_in_institutes WHERE id='".$institute_id."'";
		$instituteObj =$db->query($instituteSql);
		$institute =$db->fetchByAssoc($instituteObj);
		return $institute['name'];
	}
	function getProgram($program_id){
		global $db;
		$programSql="SELECT name FROM te_pr_programs WHERE id='".$program_id."'";
		$programObj =$db->query($programSql);
		$program =$db->fetchByAssoc($programObj);
		return $program['name'];
	}
	public function display() {
		global $db,$current_user;
		$resultSet=array();
		if($current_user->designation=="BUH"){
			$studentBatchSql="SELECT sb.*,s.name as student FROM te_student s INNER JOIN te_student_te_student_batch_1_c sbr ON s.id=sbr.te_student_te_student_batch_1te_student_ida INNER JOIN te_student_batch sb ON sbr.te_student_te_student_batch_1te_student_batch_idb=sb.id WHERE sb.dropout_status='Pending'  AND sb.deleted=0";
			$studentBatchObj =$db->query($studentBatchSql);
				
			$dropout_status_list =$GLOBALS['app_list_strings']['dropuout_status_list'];
			$dropout_type_list =$GLOBALS['app_list_strings']['student_batch_dropout_list'];
			$rowcount=0;
			while($row =$db->fetchByAssoc($studentBatchObj)){
				$rowcount++;
				$row['program']=$this->getProgram($row['te_pr_programs_id_c']);
				$row['institute']=$this->getInstitute($row['te_in_institutes_id_c']);
				
				$dropout_status="<span id='dropout_request_".$row['id']."'></span><select name='dropout_status' id='".$row['id']."' onchange='return changeDropoutStatus(this.id,this.value,".$rowcount.");' style='width:113PX !IMPORTANT'><option value=''></option>";
				foreach($dropout_status_list as $key=>$value){
					if($row['dropout_status']==$key)
						$dropout_status.="<option value='".$key."' selected>".$value."</option>";
					else
						$dropout_status.="<option value='".$key."'>".$value."</option>";			
				}
				$dropout_status.="</select>";
				$dropout_type="<select name='dropout_type' id='dropout_type_".$rowcount."'  style='width:90PX !IMPORTANT'>";
				foreach($dropout_type_list as $key=>$value){
					if($row['dropout_type']==$key)
						$dropout_type.="<option value='".$key."' selected>".$value."</option>";
					else
						$dropout_type.="<option value='".$key."'>".$value."</option>";			
				}
				$dropout_type.="</select>";
				$row['dropout_type']=$dropout_type;
				$row['dropout_status']=$dropout_status;
				$resultSet[]=$row;
			}		
		}
		
		$sugarSmarty = new Sugar_Smarty();
		$sugarSmarty->assign("resultSet",$resultSet);
		$sugarSmarty->display('custom/modules/te_student_batch/tpls/dropoutapprove.tpl');
	}
}
?>
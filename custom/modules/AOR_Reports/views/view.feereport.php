<?php
if (!defined('sugarEntry') || !sugarEntry)
	die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');
class AOR_ReportsViewFeereport extends SugarView {

	public function __construct() {
		parent::SugarView();
	}
	function getBatch(){
		global $db;
		$batchSql="SELECT id,name from te_ba_batch WHERE deleted=0 AND batch_status='enrollment_in_progress'";
		$batchObj =$db->query($batchSql);
		$batchOptions=array();
		while($row =$db->fetchByAssoc($batchObj)){
			$batchOptions[]=$row;
		}
		return $batchOptions;
	}
	public function display() {
		global $db;
       	#Get batch drop down option
		$batchList=$this->getBatch();
		# Query for batch drop down options
		$where="";
		$selected_batch="";
		if(isset($_POST['button']) && $_POST['button']=="Search") {
			if(!empty($_POST['batch'])){
				$selected_batch=$_POST['batch'];
				$where.=" AND sb.te_ba_batch_id_c = '".$_POST['batch']."'";
			}
		}

		$installmentSql="SELECT count(spp.name)as total FROM te_student s INNER JOIN te_student_te_student_batch_1_c sbr ON s.id=sbr.te_student_te_student_batch_1te_student_ida INNER JOIN te_student_batch sb ON sbr.te_student_te_student_batch_1te_student_batch_idb=sb.id INNER JOIN te_student_batch_te_student_payment_plan_1_c sbpr ON sb.id=sbpr.te_student_batch_te_student_payment_plan_1te_student_batch_ida INNER JOIN te_student_payment_plan spp ON sbpr.te_student9d1ant_plan_idb=spp.id WHERE sb.status='Active' AND sb.deleted=0 AND spp.name<>'Initial Payment'GROUP BY s.name,sb.name order by total desc limit 0,1";
		$installmentObj=$db->query($installmentSql);
		$installment =$db->fetchByAssoc($installmentObj);

		$feeSql="SELECT s.name as student,s.email,s.mobile,sb.name as batch,spp.name as instalment,spp.due_date,spp.total_amount as due_amount,spp.paid_amount_inr as paid_amount FROM te_student s INNER JOIN te_student_te_student_batch_1_c sbr ON s.id=sbr.te_student_te_student_batch_1te_student_ida INNER JOIN te_student_batch sb ON sbr.te_student_te_student_batch_1te_student_batch_idb=sb.id INNER JOIN te_student_batch_te_student_payment_plan_1_c sbpr ON sb.id=sbpr.te_student_batch_te_student_payment_plan_1te_student_batch_ida INNER JOIN te_student_payment_plan spp ON sbpr.te_student9d1ant_plan_idb=spp.id WHERE sb.status='Active' AND sb.deleted=0 ".$where." ORDER BY s.name,sb.name,spp.due_date";

		$feeObj =$db->query($feeSql);
		$councelorList=array();
		$feeList=array();
		$installmentList=array('1'=>'1st instalment','2'=>'2nd instalment','3'=>'3rd instalment','4'=>'4th instalment','5'=>'5th instalment','6'=>'6th instalment','7'=>'7th instalment');
		$index=0;
		$next=0;
		while($row =$db->fetchByAssoc($feeObj)){
			if(isset($feeList[$index-1]['Student'])&&$feeList[$index-1]['Student']==$row['student']&&$feeList[$index-1]['Batch']==$row['batch']){
				$feeList[$index-1]['Instalment '.$next.' Due Date']=$row['due_date'];
				$feeList[$index-1]['Instalment '.$next.' Due Amount']=$row['due_amount'];
				$feeList[$index-1]['Instalment '.$next.' Paid Amount']=$row['paid_amount'];
				$next++;
			}else{
				$feeList[$index]['Student']=$row['student'];
				$feeList[$index]['Email']=$row['email'];
				$feeList[$index]['Batch']=$row['batch'];
				$feeList[$index]['Phone']=$row['mobile'];
				$feeList[$index]['Initial Due Date']=$row['due_date'];
				$feeList[$index]['Initial Due Amount']=$row['due_amount'];
				$feeList[$index]['Initial Paid Amount']=$row['paid_amount'];
				$index++;
				$next=1;
			}
		}
		$reportHeader=array("Student","Email","Phone","Batch","Initial Due Date","Initial Due Amount","Initial Paid Amount");
		for($x=1;$x<=$installment['total'];$x++){
			$reportHeader[]='Instalment '.$x.' Due Date';
			$reportHeader[]='Instalment '.$x.' Due Amount';
			$reportHeader[]='Instalment '.$x.' Paid Amount';
		}
		$sugarSmarty = new Sugar_Smarty();
		$sugarSmarty->assign("reportHeader",$reportHeader);
		$sugarSmarty->assign("feeList",$feeList);
		$sugarSmarty->assign("batchList",$batchList);
		$sugarSmarty->assign("selected_batch",$selected_batch);
		$sugarSmarty->display('custom/modules/AOR_Reports/tpls/feereport.tpl');
	}
}
?>

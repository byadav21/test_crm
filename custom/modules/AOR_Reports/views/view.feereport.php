<?php
if (!defined('sugarEntry') || !sugarEntry)
	die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php'); 
class AOR_ReportsViewFeereport extends SugarView {
	
	public function __construct() {
		parent::SugarView();
	}
	
	public function display() {
		global $db;
       	
		$installmentSql="SELECT count(spp.name)as total FROM te_student s INNER JOIN te_student_te_student_batch_1_c sbr ON s.id=sbr.te_student_te_student_batch_1te_student_ida INNER JOIN te_student_batch sb ON sbr.te_student_te_student_batch_1te_student_batch_idb=sb.id INNER JOIN te_student_batch_te_student_payment_plan_1_c sbpr ON sb.id=sbpr.te_student_batch_te_student_payment_plan_1te_student_batch_ida INNER JOIN te_student_payment_plan spp ON sbpr.te_student9d1ant_plan_idb=spp.id WHERE sb.status='Active' AND sb.deleted=0 AND spp.name<>'Initial Payment'GROUP BY s.name,sb.name order by total desc limit 0,1";
		$installmentObj=$db->query($installmentSql);
		$installment =$db->fetchByAssoc($installmentObj);
				
		$feeSql="SELECT s.name as student,s.email,s.mobile,sb.name as batch,spp.name as instalment,spp.due_date,spp.total_amount as due_amount,spp.paid_amount_inr as paid_amount FROM te_student s INNER JOIN te_student_te_student_batch_1_c sbr ON s.id=sbr.te_student_te_student_batch_1te_student_ida INNER JOIN te_student_batch sb ON sbr.te_student_te_student_batch_1te_student_batch_idb=sb.id INNER JOIN te_student_batch_te_student_payment_plan_1_c sbpr ON sb.id=sbpr.te_student_batch_te_student_payment_plan_1te_student_batch_ida INNER JOIN te_student_payment_plan spp ON sbpr.te_student9d1ant_plan_idb=spp.id WHERE sb.status='Active' AND sb.deleted=0 AND spp.name<>'Initial Payment' ORDER BY s.name,sb.name,spp.name";
		
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
				$feeList[$index]['Instalment 1 Due Date']=$row['due_date'];
				$feeList[$index]['Instalment 1 Due Amount']=$row['due_amount'];
				$feeList[$index]['Instalment 1 Paid Amount']=$row['paid_amount'];
				$index++;
				$next=2;
			}		
		}	
		$reportHeader=array("Student","Email","Phone","Batch");
		for($x=1;$x<=$installment['total'];$x++){
			$reportHeader[]='Instalment '.$x.' Due Date';
			$reportHeader[]='Instalment '.$x.' Due Amount';
			$reportHeader[]='Instalment '.$x.' Paid Amount';
		}
	
		$sugarSmarty = new Sugar_Smarty();
		$sugarSmarty->assign("reportHeader",$reportHeader);
		$sugarSmarty->assign("feeList",$feeList);
		$sugarSmarty->display('custom/modules/AOR_Reports/tpls/feereport.tpl');
	}
}
?>
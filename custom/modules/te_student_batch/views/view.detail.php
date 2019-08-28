<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('include/MVC/View/views/view.detail.php');
class te_student_batchViewDetail extends ViewDetail {
		public function display(){
			global $current_user,$db;
			$row =$db->query("SELECT SUM(`amount`)amt_paid FROM `te_student_payment` WHERE `te_student_batch_id_c`='".$this->bean->id."'  AND payment_realized=1 AND deleted=0");
			$res =$db->fetchByAssoc($row);
			$rownew =$db->query("SELECT fee_inr FROM `te_student_batch` WHERE `id`='".$this->bean->id."'  AND payment_realized=1 AND deleted=0");
			$resnew =$db->fetchByAssoc($rownew);
			$this->bean->total_payment=$res['amt_paid'];
			$this->bean->total_payment='5000';
			//$this->bean->pending_amount=$resnew['fee_inr']-$res['amt_paid'];
			$this->bean->pending_amount	= '1000';
			parent::display();
		}

}
?>

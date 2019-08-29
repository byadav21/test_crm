<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('include/MVC/View/views/view.detail.php');
class te_student_batchViewDetail extends ViewDetail {
		public function display(){
			global $current_user,$db;
			$row =$db->query("SELECT SUM(`amount`)amt_paid FROM `te_student_payment` WHERE `te_student_batch_id_c`='".$this->bean->id."'  AND payment_realized=1 AND deleted=0");
			$res =$db->fetchByAssoc($row);
			$rownew =$db->query("SELECT fee_inr,bt_fee_waiver FROM `te_student_batch` WHERE `id`='".$this->bean->id."' AND deleted=0");
			$resnew =$db->fetchByAssoc($rownew);
			$this->bean->total_payment=$res['amt_paid'];
			$amountpaid=($res['amt_paid']*100)/118;
			$totalfee=($resnew['fee_inr']*100)/118;
			$this->bean->initial_payment_inr=$totalfee;
			$this->bean->bt_fee_waiver=$resnew['bt_fee_waiver'];
			//$this->bean->initial_payment_inr	= '1000';
			parent::display();
		}

}
?>

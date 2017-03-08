<?php
if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');

class listviewClass {
    function listview(&$bean, $event, $arguments) {
    global $db;
    
    
       //**** Student list View Details **************/ 
	//	$aa="SELECT mobile,email,country FROM te_student WHERE id=(SELECT te_student_te_student_batch_1te_student_ida FROM te_student_te_student_batch_1_c WHERE 'te_student_te_student_batch_1te_student_batch_idb'='".$bean->id."'";
			
			$row1 =$db->query("SELECT mobile,email,country FROM te_student WHERE id=(SELECT te_student_te_student_batch_1te_student_ida FROM te_student_te_student_batch_1_c WHERE `te_student_te_student_batch_1te_student_batch_idb`='".$bean->id."')");                                             
			$res1 =$db->fetchByAssoc($row1);
			
			
			$bean->email=$res1['email'];
			$bean->mobile=$res1['mobile'];
			  
			$row =$db->query("SELECT fee_usd,fee_inr FROM te_student_batch where id='".$bean->id."'");                                             
			$res =$db->fetchByAssoc($row); 
		  
		//$bean->feepaid=$res['fee_usd'];
    
			if($res['fee_inr']==0.00 || $res['fee_inr']==0.00)
					{
				$bean->feepaid="NA";
				}
		else{
			
			if($res1['country']=="INDIA" || $res1['country']=="india" || $res1['country']=="India" || $res1['country']=="")
			{
						
				$inr=$res['fee_inr'];
				$bean->feepaid=number_format($inr, 2, ',', ' ')."-INR";
				}
				else
				{
				$bean->feepaid=$res['fee_usd']."-USD";
				}
			  }
			// $bean->feepaid=$row1;
			 
		}
 }
 
 
 
			// New Update file 3nov @MAnish Gupta manish.outright@gmail.com

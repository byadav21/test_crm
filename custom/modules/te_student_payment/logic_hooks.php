<?php
// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
 $hook_version = 1; 
$hook_array = Array(); 
// position, file, function 
$hook_array['before_save'] = Array(); 
$hook_array['before_save'][] = Array(1,'Update Payment Name','custom/modules/te_student_payment/student_payment_hook.php','StudentPayment','updateName');
$hook_array['after_save'] = Array(); 
$hook_array['after_save'][] = Array(1,'Update Student Payment Details','custom/modules/te_student_payment/student_payment_hook.php','StudentPayment','UpdatePaymentDetails');

?>

<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

require_once('custom/modules/te_student/te_student_override.php');
global  $current_user;
 
$obj=new te_student_override();
global  $current_user;


 

$page=(isset($_REQUEST['page']) && intval($_REQUEST['page'])>0)? intval($_REQUEST['page']) : 1;
$noofRow=18;
$obj=new te_student_override();
$start=$noofRow*($page-1);
if(!$current_user->is_admin){
   $results=$obj->getTransferRequests($current_user->id);
}else{
	$results=$obj->getTransferRequests($current_user->id,1);	
}
$isload=0;//($results && count($results)>17)?1 :0;
$page=$page+1;
//print_r($results);
echo json_encode(['data'=>$results,'page'=>$page,'isload'=>$isload]);die;

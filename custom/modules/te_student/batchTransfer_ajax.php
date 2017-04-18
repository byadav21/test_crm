<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

require_once('custom/modules/te_student/te_student_override.php');
require_once('modules/te_student_batch/te_student_batch.php');

global  $current_user;

$studentObj=new te_student_override();
$studentBatchObj=new te_student_batch();

switch ($_REQUEST['type']) {
    case 'fetch_student':
    
		$batchID=$_REQUEST['records'];
		$batches=$studentBatchObj->retrieve($_REQUEST['records']);

      // print_r($batches);
        if($batches && count($batches)>0){
			//echo $batches->id; die;
			$batches=$studentObj->getStudentBatch($batches->id);
			 
			$isTransfer=1;
			if($batches['te_student_batch']>date("Y-m-d")){
				$isTransfer=0;
				$programm=array();
				$selBatch=$studentObj->getBatch($data->id,$batches['te_pr_programs_id_c']);
			}else{
				$programm=$studentObj->getPrograms();
				$selBatch=[];
			}	
			
			
			$data = $studentObj->getStudentID($batchID);
 
			echo json_encode(array('result'=>array('id'=>$data['sid'],'name'=>$data['name'],'email'=>$data['email'],'status'=>$data['status']),'programme'=>$programm,'selbatch'=>$selBatch,'batch'=>array('id'=>$batches['id'],'name'=>$batches['name'],'id_org'=>$batches['batch_id'],'is_transfer'=>$isTransfer),'currentbatchid'=>$batches['id']));
		}else{
			echo json_encode(['result'=>array(),'batch'=>array(),'programme'=>array(),'selbatch'=>array(),'currentbatchid'=>'']);die;	
		}
        break;
   
    
} 


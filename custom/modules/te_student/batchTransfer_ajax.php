<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

require_once('custom/modules/te_student/te_student_override.php');

global  $current_user;

$studentObj=new te_student_override();

switch ($_REQUEST['type']) {
    case 'fetch_student':
        $data=$studentObj->retrieve($_REQUEST['records']);
     
       
        if($data && count($data)>0){
			
			$batches=$studentObj->getStudentBatch($data->id);
			$isTransfer=1;
			if($batches['te_student_batch']>date("Y-m-d")){
				$isTransfer=0;
				$programm=array();
				$selBatch=$studentObj->getBatch($data->id,$batches['te_pr_programs_id_c']);
			}else{
				$programm=$studentObj->getPrograms();
				$selBatch=[];
			}	
			
			
			
			echo json_encode(array('result'=>array('id'=>$data->id,'name'=>$data->name,'email'=>$data->email,'status'=>$data->status),'programme'=>$programm,'selbatch'=>$selBatch,'batch'=>array('id'=>$batches['id'],'name'=>$batches['name'],'id_org'=>$batches['batch_id'],'is_transfer'=>$isTransfer)));
		}else{
			echo json_encode(['result'=>array(),'batch'=>array(),'programme'=>array(),'selbatch'=>array()]);die;	
		}
        break;
   
    
} 


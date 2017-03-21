<?php

require_once('modules/te_student/te_student.php');
class te_student_override extends te_student {
	
	public $dbinstance;
	function __construct(){
		parent::__construct();
		$this->dbinstance= DBManagerFactory::getInstance();
	}
	
	function getAllStudentInstallment($email='',$batches='',$installment='',$start=0,$noofRow=18){
		 
		$sql="select s.id,s.name as sname,s.email,s.status,p.due_date, p.name, p.paid_amount_inr,batch_code,b.name as batchname from te_student as s 
		inner join te_student_payment_plan as p on s.id=p.te_student_id_c inner join te_student_te_student_batch_1_c as br on s.id=br.te_student_te_student_batch_1te_student_ida
		inner join te_student_batch as b on b.id=br.te_student_te_student_batch_1te_student_batch_idb and b.deleted=0 where s.deleted=0 and p.deleted=0 ";
		if($batches) $sql .=" and b.te_ba_batch_id_c='". $batches . "' ";
		if($installment) $sql .=" and p.name='". $installment . "' ";
		if($email) $sql .=" and s.email like '%". $email . "%' ";
		$sql .="order by s.id asc, p.name='Initial Payment' desc, p.name asc limit $start,$noofRow";
		$itemDetal=	$this->dbinstance->query($sql);
		$rowData=[];
		$current='';
		while($row=$this->dbinstance->fetchByAssoc($itemDetal)){			
			
			
			$row['showrow']=0;
			if($current==$row['id']){
				$row['showrow']=1;
			}
			$rowData[]=$row;
			$current=$row['id'];			
		}	
		return $rowData;
	}
	
	function getAllStudentInstallmentSummary($isadmin='0',$batches='',$userID='',$start=0,$noofRow=18){
		 
		$sql="select b.id,i.name as iname, b.batch_start_date,b.duration,b.fees_inr, b.batch_status,p.name as pname, b.name as bname , 
						sum(amount) as amt from te_student_batch as tsb  
						inner join  te_ba_batch as b  on  tsb.te_ba_batch_id_c=b.id " ;
		if($userID) $sql .=" inner join te_srm_auto_assignment as tsaa on  tsaa.te_ba_batch_id_c =b.id ";
					$sql .="	inner join te_pr_programs_te_ba_batch_1_c as ib on ib.te_pr_programs_te_ba_batch_1te_ba_batch_idb=b.id
						inner join te_pr_programs as p on p.id=ib.te_pr_programs_te_ba_batch_1te_pr_programs_ida
						inner join te_in_institutes_te_ba_batch_1_c as bi on bi.te_in_institutes_te_ba_batch_1te_ba_batch_idb=b.id
						inner join te_in_institutes as i on i.id=bi.te_in_institutes_te_ba_batch_1te_in_institutes_ida
						left join te_student_payment as sp on sp.te_student_batch_id_c=tsb.id
						 where b.deleted=0 and p.deleted=0  and i.deleted=0 and bi.deleted=0 and ib.deleted=0 ";
						 
						 
					if($batches) $sql .=" and b.batch_status in (". $batches .") ";
					if($userID) $sql .=" and tsaa.assigned_user_id in ('".$userID .  "')";
					//if($email) $sql .=" and s.email like '%". $email . "%' ";
					//$sql .="group by s.id,s.name,s.email,s.status,batch_code,b.name,b.id ";
					  $sql .="group by  b.id,p.id,i.name,  p.name , b.name order by i.name"; 
		$itemDetal=	$this->dbinstance->query($sql);
		$rowData=[];
		$current='';
		while($row=$this->dbinstance->fetchByAssoc($itemDetal)){			
			
			$addrows=$row;
			if(empty($addrows['amt']) || $addrows['amt']==null) $addrows['amt']=0;
			$addrows['activeStudent']=	$this->getStudentStatusCount($row['id'],'',$isadmin,$userID);		
			$addrows['dropOutStudent']=	intval($this->getStudentStatusCount($row['id'],'Dropout',$isadmin,$userID));	
			$addrows['totalamt']=	 number_format(floatval($row['fees_inr'])*$addrows['activeStudent'], 2, '.', '');	
			$addrows['batch_status']=	 str_replace('_',' ',$row['batch_status']);	
			$rowData[]=	$addrows;
		}	
		return $rowData;
	}
	
	function getStudentStatusCount($id,$status='',$isadmin='0',$userID=''){
		if($status){
			$sql="select count(te_student_batch.id) as ctr from te_student_batch ";
			if($userID) $sql .=" inner join te_srm_auto_assignment as tsaa on  tsaa.te_ba_batch_id_c =te_student_batch.te_ba_batch_id_c "; 
			$sql .=" where te_student_batch.te_ba_batch_id_c='$id' and te_student_batch.status='$status' and te_student_batch.deleted=0";
			if($isadmin==0 && $userID){
				$sql .= " and tsaa.assigned_user_id in ('".$userID."')";
			}
			
		}else{
			$sql="select count(te_student_batch.id) as ctr from te_student_batch ";
			if($userID) $sql .=" inner join te_srm_auto_assignment as tsaa on  tsaa.te_ba_batch_id_c =te_student_batch.te_ba_batch_id_c "; 
			$sql .=" where te_student_batch.te_ba_batch_id_c='$id'   and te_student_batch.deleted=0";
			if($isadmin==0 && $userID){
				$sql .= " and tsaa.assigned_user_id in ('".$userID."')";
			}
			//echo $sql;	
			 		
		}
		$itemDetal=	$this->dbinstance->query($sql);
		$data= $this->dbinstance->fetchByAssoc($itemDetal);
		 
		return ($data && count($data)>0) ? intval($data['ctr']) :0;
	}
	function getAllStudentBatch(){
		
		$sql="select  te_ba_batch_id_c as id,name from te_student_batch where deleted=0 group by te_ba_batch_id_c,name order by name";
		$itemDetal=	$this->dbinstance->query($sql);
		$rowData=[];
		while($row=$this->dbinstance->fetchByAssoc($itemDetal)){			
			$rowData[]=$row;			
		}	
		return $rowData;
	}
	
	function getStudentBatch($id){
		
		$sql="select te_student_batch.te_pr_programs_id_c, te_student_batch.id,te_student_batch.te_ba_batch_id_c as batch_id,te_student_batch.name,te_student_batch.batch_start_date from te_student_te_student_batch_1_c inner join te_student_batch on te_student_batch.id=te_student_te_student_batch_1_c.te_student_te_student_batch_1te_student_batch_idb and te_student_te_student_batch_1te_student_ida='$id' where te_student_te_student_batch_1_c.deleted=0 and te_student_batch.deleted=0";
		$itemDetal=	$this->dbinstance->query($sql);
		return $this->dbinstance->fetchByAssoc($itemDetal);
		
	}
	
	function getAllStudentInstallmentLabel(){
		
		$sql="select distinct name from te_student_payment_plan where deleted=0 order by name='Initial Payment' desc, name asc";
		$itemDetal=	$this->dbinstance->query($sql);
		$rowData=[];
		while($row=$this->dbinstance->fetchByAssoc($itemDetal)){			
			$rowData[]=$row;			
		}	
		return $rowData;
	}
	
	function getAllRefrals($start=0,$limit=18){
		
	   $sql="select s.id,s.name as sname,s.email,s.status,s1.name as refree from te_student as s
			inner join leads_leads_1_c as l on l.leads_leads_1leads_idb=s.lead_id_c
			inner join te_student as s1 on s1.lead_id_c=l.leads_leads_1leads_ida
			inner join te_student_payment_plan as pp on pp.te_student_id_c=s1.id
			where s.deleted=0 and s.status='Active' and s1.deleted=0 and  pp.deleted=0
			group by s.name,s.email,s.status,s1.name having sum(balance_inr)=0 limit $start,$limit";	
	   $itemDetal=	$this->dbinstance->query($sql);
		$rowData=[];
		while($row=$this->dbinstance->fetchByAssoc($itemDetal)){			
			$rowData[]=$row;			
		}	
		return $rowData;		
		
	}
	
	
	function getBatch($studentId,$programId){
	 
		$studentBatchSql="SELECT sb.te_ba_batch_id_c as batch_id FROM te_student_te_student_batch_1_c sbr INNER JOIN `te_student_batch` sb ON sbr.te_student_te_student_batch_1te_student_batch_idb=sb.id WHERE sbr.te_student_te_student_batch_1te_student_ida='".$studentId."'";
		$studentBatchObj=$this->dbinstance->query($studentBatchSql);
		$currentBatch=array();
		while($student =$this->dbinstance->fetchByAssoc($studentBatchObj)){ 
			$currentBatch[]=$student['batch_id'];
		}
			
		$batchSql="SELECT b.id,b.name FROM te_pr_programs_te_ba_batch_1_c bpr INNER JOIN te_ba_batch b ON bpr.te_pr_programs_te_ba_batch_1te_ba_batch_idb=b.id  WHERE b.deleted=0 AND bpr.te_pr_programs_te_ba_batch_1te_pr_programs_ida='".$programId."' AND b.id NOT IN('".implode("','",$currentBatch)."')";
		$batchObj =$this->dbinstance->query($batchSql);
		$batchOptions=array();
		while($row =$this->dbinstance->fetchByAssoc($batchObj)){ 
			$batchOptions[]=$row;
		}
		return $batchOptions;
	}
	
	function getPrograms(){
	 
		$programsList=array();
		$programSql="SELECT id, name FROM te_pr_programs WHERE deleted=0 ";
		$programObj =$this->dbinstance->query($programSql);
		while($row =$this->dbinstance->fetchByAssoc($programObj)){ 
			$programsList[]=$row;
		}
		return $programsList;
	}
	
	public function getApproval($id){
	
		$programsList=array();
		$programSql="SELECT status FROM te_transfer_batch WHERE te_student_id_c='$id' and status='Pending'  and deleted='0' ";
		$programObj =$this->dbinstance->query($programSql);
		return $this->dbinstance->fetchByAssoc($programObj);
	}
	
	public function getStudentID($id){
	
		$programsList=array();
		$programSql="SELECT te_student_te_student_batch_1te_student_ida as sid FROM te_student_te_student_batch_1_c WHERE te_student_te_student_batch_1te_student_batch_idb='$id' and deleted='0' ";
		$programObj =$this->dbinstance->query($programSql);
		return $this->dbinstance->fetchByAssoc($programObj);
	}
	
	public function getTransferRequests($id,$isadmin=0){
	
		$programsList=array();
		if($isadmin==1){
			$programSql="select s.name as sname,s.email,s.status,b1.name as oldbatch,b2.name as newbatch,users.user_name,tb.status as transfer_status from te_student as s
						inner join te_transfer_batch as tb on s.id=tb.te_student_id_c
						inner join te_ba_batch as b1 on b1.id=tb.te_student_batch_id_c
						inner join te_ba_batch as b2 on b2.id=tb.te_ba_batch_id_c left join users on users.id=tb.assigned_user_id";
		}else{
			$programSql="select s.name as sname,s.email,s.status,b1.name as oldbatch,b2.name as newbatch,tb.status as transfer_status  from te_student as s
						inner join te_transfer_batch as tb on s.id=tb.te_student_id_c
						inner join te_ba_batch as b1 on b1.id=tb.te_student_batch_id_c
						inner join te_ba_batch as b2 on b2.id=tb.te_ba_batch_id_c where assigned_user_id='$id'";
		}				
		$programObj =$this->dbinstance->query($programSql);
		while($row =$this->dbinstance->fetchByAssoc($programObj)){ 
			$programsList[]=$row;
		}
		return $programsList;
	}
	
	function setSeen($col,$tbl,$user_ids='',$status='Active'){
		$sql="update te_student_batch as t  ";
		if($user_ids) $sql .=" inner join te_srm_auto_assignment as tsaa on  tsaa.te_ba_batch_id_c =t.te_ba_batch_id_c ";
		$sql .=" set t.is_new=0
		 where  t.status='Active' and t.is_new='1' and t.deleted=0 ";
		if($user_ids) $sql .="  and tsaa.assigned_user_id in ('".$user_ids."')";

		$programObj =$this->dbinstance->query($sql);
	}
	
	function setSeenDropoutIN($col,$tbl,$user_ids='',$status='Dropout'){
		
		$sql="update te_student_batch as t  ";
		if($user_ids) $sql .=" inner join te_srm_auto_assignment as tsaa on  tsaa.te_ba_batch_id_c =t.te_ba_batch_id_c ";
		$sql .=" set t.is_new=0
		 where  t.status='Dropout' and t.is_new_dropout='1' and t.deleted=0 ";
		if($user_ids) $sql .="  and tsaa.assigned_user_id in ('".$user_ids."')";
		 
		
		$programObj =$this->dbinstance->query($sql);
	}
	
	function setSeenDropout($col,$tbl,$user_ids){
		$sql="update $tbl set $col='0' where deleted=0 and status='Dropout'  and assigned_user_id in ('".$user_ids."')";
		$programObj =$this->dbinstance->query($sql);
	}
	
	function setSeenRefrals($col,$tbl,$user_ids){
		$sql="update $tbl set $col='0' where deleted=0 and parent_type LIKE 'Users'  and parent_id in ('".$user_ids."')";
		$programObj =$this->dbinstance->query($sql);
	}
	
	function newConversion($user_ids=''){
	 
		$sql="select count(te_student_batch.id) as newconv, te_student_batch.leads_id from te_student_batch ";
		if($user_ids) $sql .=" inner join te_srm_auto_assignment as tsaa on  tsaa.te_ba_batch_id_c =te_student_batch.te_ba_batch_id_c "; 
		
		$sql .=" where te_student_batch.status='Active' and te_student_batch.is_new='1' and te_student_batch.deleted=0 ";//and created_by in ('".$user_ids."')";
		
		if($user_ids){
				$sql .= " and tsaa.assigned_user_id in ('".$user_ids."')";
		}
		
		$programObj =$this->dbinstance->query($sql);
		return $this->dbinstance->fetchByAssoc($programObj);
		
	}
	
	function newDropOut($user_ids=""){
		
		$sql="select count(te_student_batch.id) as newconv, te_student_batch.leads_id from te_student_batch ";
		if($user_ids) $sql .=" inner join te_srm_auto_assignment as tsaa on  tsaa.te_ba_batch_id_c =te_student_batch.te_ba_batch_id_c "; 
		
		$sql .=" where te_student_batch.status='Dropout' and te_student_batch.is_new_dropout='1' and te_student_batch.deleted=0 ";//and created_by in ('".$user_ids."')";
		
		if($user_ids){
				$sql .= " and tsaa.assigned_user_id in ('".$user_ids."')";
		}
	 
		$programObj =$this->dbinstance->query($sql);
		return $this->dbinstance->fetchByAssoc($programObj);
		
	}
	
	function newDropOutCallcenter($user_ids){
		$sql="SELECT  count(status) as newconv FROM leads WHERE deleted =0 AND status LIKE 'Dropout' and is_new_dropout='1'  AND leads.assigned_user_id IN ('".$user_ids."')";
		$programObj =$this->dbinstance->query($sql);
		return $this->dbinstance->fetchByAssoc($programObj);
		
	}
	
	function getMyreferals($user_ids){
		$sql="SELECT  count(status) as newconv FROM leads WHERE deleted =0 and is_new_referalls='1' AND parent_type LIKE 'Users'  AND leads.parent_id ='".$user_ids."'";
		$programObj =$this->dbinstance->query($sql);
		return $this->dbinstance->fetchByAssoc($programObj);
		
	}
	public $report_to_id;
	function reportingUser($currentUserId){
		
			$userObj = new User();
			$userObj->disable_row_level_security = true;
			$userList = $userObj->get_full_list("", "users.reports_to_id='".$currentUserId."'");
			
			if(!empty($userList)){
				
				foreach($userList as $record){

					if(!empty($record->reports_to_id)){

						$this->report_to_id[$record->id] = $record->name."(".$record->id.")";
						$this->reportingUser($record->id);
					}
				}
			}
		}
	
}
?>

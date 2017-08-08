<?php
if (!defined('sugarEntry') || !sugarEntry)
	die('Not A Valid Entry Point');
	require_once('custom/include/Email/sendmail.php');
class AOR_ReportsViewStudentgsv extends SugarView {
	var $report_to_id;
	var $counsellors_arr;
	public function __construct() {
		parent::SugarView();
	}
	
	function getBatch(){
		global $db;
		$batchSql="SELECT id,name from te_student_batch WHERE deleted=0 ";
		$batchObj =$db->query($batchSql);
		$batchOptions=array();
		while($row =$db->fetchByAssoc($batchObj)){
			$batchOptions[]=$row;
		}
		return $batchOptions;
	}

	public function display() {
		global $sugar_config,$app_list_strings,$current_user,$db;
		 
		echo $sql="select te_student_payment.date_of_payment,te_pr_programs.name,b.batch_code,s.name as fname,s.state,fee_inr from te_student_batch b
				inner join te_student_te_student_batch_1_c  r on r.te_student_te_student_batch_1te_student_batch_idb=b.id
				inner join te_student s on  te_student_te_student_batch_1te_student_ida=s.id
				inner join te_pr_programs_te_ba_batch_1_c on b.te_ba_batch_id_c=te_pr_programs_te_ba_batch_1te_ba_batch_idb
				inner join te_pr_programs on te_pr_programs.id=te_pr_programs_te_ba_batch_1te_pr_programs_ida
				inner  join te_student_payment on te_student_payment.te_student_batch_id_c=b.id
				WHERE b.deleted=0 and s.deleted=0 and te_student_payment.deleted=0 ";
				
		if(isset($_POST['batches']) && $_POST['batches']){
		  $batches=implode(",'",$_POST['batches']);
		  if($batches)	 $sql .=" and b.id in ('$batches') ";
		}		
				
		if(isset($_POST['from_date']) && $_POST['from_date']){
		   
		    $sql .=" and te_student_payment.date_of_payment >= '" . date('Y-m-d',strtotime($_POST['from_date'])) ."'";
		}		
				
		if(isset($_POST['to_date']) && $_POST['to_date']){
		   
		   $sql .=" and te_student_payment.date_of_payment <= '" . date('Y-m-d',strtotime($_POST['to_date'])) ."'";
		}		
				
		$sql .=" group by s.name,b.name,te_pr_programs.name,fee_inr order by s.name";
					   
		$leadObj =$db->query($sql);
		if(isset($_POST['export']) && $_POST['export']=="Export"){
			
			
			
			$data = "Date,Course,Batch,Student,State,GSV\n";
		 
			while($row =$db->fetchByAssoc($leadObj)){
				 $i=0;
				foreach($row as $key1=>$value){
					 
					$data.= str_replace(',',' ' ,$value) ;
					if($i++ < count($row)-1) $data.= ",";
				}
				$data.= "\n";
			}
			//echo $data;die;
			ob_end_clean();
			header("Content-type: application/csv");
			header ('Content-disposition: attachment;filename="collection.csv";' );
			echo $data; exit;
			
		}
		while($row =$db->fetchByAssoc($leadObj)){
			$councelorList[]=$row;
		}
		
			$total=count($councelorList); #total records
			$start=0;
			$per_page=10;
			$page=1;
			$pagenext=1;
			$last_page=ceil($total/$per_page);

			if(isset($_REQUEST['page'])&&$_REQUEST['page']>0){
				$start=$per_page*($_REQUEST['page']-1);
				$page=($_REQUEST['page']-1);
				$pagenext = ($_REQUEST['page']+1);

			}else{

				$pagenext++;
			}
			if(($start+$per_page)<$total){
				$right=1;
			}else{
				$right=0;
			}
			if(isset($_REQUEST['page'])&&$_REQUEST['page']==1){
				$left=0;
			}elseif(isset($_REQUEST['page'])){

				$left=1;
			}

			$councelorList=array_slice($councelorList,$start,$per_page);
			if($total>$per_page){
				$current="(".($start+1)."-".($start+$per_page)." of ".$total.")";

			}else{
				$current="(".($start+1)."-".count($councelorList)." of ".$total.")";


			}
			
			$batchList=$this->getBatch();	
			$sugarSmarty = new Sugar_Smarty();
			$sugarSmarty->assign("councelorList",$councelorList);
			$sugarSmarty->assign("batchList",$batchList);
			$sugarSmarty->assign("selected_batch",$_POST['batches']);
			$sugarSmarty->assign("selected_from_date",$_POST['from_date']);
			$sugarSmarty->assign("selected_to_date",$_POST['to_date']);
			
		 
			$sugarSmarty->assign("current_records",$current);
			$sugarSmarty->assign("selected_from_date",$selected_from_date);
			$sugarSmarty->assign("selected_to_date",$selected_to_date);			
			$sugarSmarty->assign("page",$page);
			$sugarSmarty->assign("pagenext",$pagenext);
			$sugarSmarty->assign("right",$right);
			$sugarSmarty->assign("left",$left);
			$sugarSmarty->assign("last_page",$last_page);
			$sugarSmarty->display('custom/modules/AOR_Reports/tpls/studentgsv.tpl');
		
	}
}
?>

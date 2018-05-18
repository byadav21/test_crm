<?php
if (!defined('sugarEntry') || !sugarEntry)
	die('Not A Valid Entry Point');
	require_once('custom/include/Email/sendmail.php');
class AOR_ReportsViewEloquareport extends SugarView {
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

		$sql="SELECT lead.id as lead_id,
		lead.date_entered as date_entered,
		lead.date_modified as date_modified,
		batch.d_campaign_id as campaign_id,
		batch.d_lead_id as d_lead_id,
		leadcstm.email_add_c as email_id,
		batch.name as batch_name,
		batch.batch_code as batch_code,
		batch.batch_status as batch_status,
		leadcstm.eloqua_lead_score as eloqua_score,
		leadlog.status as CRM_status,
		leadlog.status_description as CRM_description,
		lead.status as new_status,
		lead.status_description as new_description
		 from `leads_cstm`  as `leadcstm`
		  INNER JOIN `te_ba_batch` as `batch` on leadcstm.te_ba_batch_id_c = batch.id
			INNER JOIN `leads_logdata` as `leadlog` on leadcstm.id_c = leadlog.lead_id
		  INNER JOIN `leads` as `lead` on leadcstm.id_c = lead.id ";

		if(isset($_POST['batches']) && $_POST['batches']){
		  $batches=implode(",'",$_POST['batches']);
		  if($batches)	 $sql .=" and b.id in ('$batches') ";
		}

		if(isset($_POST['from_date']) && $_POST['from_date']){

		 //   $sql .=" and te_student_payment.date_of_payment >= '" . date('Y-m-d',strtotime($_POST['from_date'])) ."'";
		}

		if(isset($_POST['to_date']) && $_POST['to_date']){

		//   $sql .=" and te_student_payment.date_of_payment <= '" . date('Y-m-d',strtotime($_POST['to_date'])) ."'";
		}

	//	$sql .=" group by s.name,b.name,te_pr_programs.name,fee_inr order by s.name";

		$leadObj =$db->query($sql);
		if(isset($_POST['export']) && $_POST['export']=="Export"){



			$data = "Invoice_No,Invoice_URL,Date,Course,Batch,Student,State,GSV\n";

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
			$sugarSmarty->display('custom/modules/AOR_Reports/tpls/eloquareport.tpl');

	}
}
?>

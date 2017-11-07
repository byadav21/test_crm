<?php
if (!defined('sugarEntry') || !sugarEntry)
	die('Not A Valid Entry Point');
	require_once('custom/include/Email/sendmail.php');	
	class AOR_ReportsViewStudentJourney extends SugarView {
	var $report_to_id;
	var $counsellors_arr;
	public function __construct() {
		parent::SugarView();
	}
	
	public function display() {
		global $sugar_config,$app_list_strings,$current_user,$db;
			
		$where="";
		$from_date="";
		$to_date="";
		if(isset($_POST['button']) && $_POST['button']=="Search") {
				$_SESSION['lp_from_date'] = $_REQUEST['from_date'];
				$_SESSION['lp_to_date'] = $_REQUEST['to_date'];
			//$_SESSION['lp_batch'] = $_REQUEST['batch'];
			if($_SESSION['lp_from_date']!="" && $_SESSION['lp_to_date']){
				
    			$from_date=date('Y-m-d',strtotime(str_replace('/','-',$_POST['from_date'])));
				$to_date=date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['lp_to_date'])));
				$where.=" AND DATE(l.date_entered)>='".$from_date."' AND DATE(l.date_entered)<='".$to_date."'";
			}elseif($_SESSION['lp_from_date']!=""&&$_SESSION['lp_to_date']==""){
				$from_date=date('Y-m-d',strtotime(str_replace('/','-',$_POST['from_date'])));
				$where.=" AND DATE(l.date_entered)='".$from_date."' ";
			}elseif($_SESSION['lp_from_date']==""&&$_SESSION['lp_to_date']!=""){
				$to_date=date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['lp_to_date'])));
				$where.=" AND DATE(l.date_entered)='".$to_date."' ";
			}
				
		}
		
		 $sql="SELECT p.name AS pname,i.name AS insname,l.status_description,l.status AS lstatus,l.converted_date,l.utm_campaign,l.utm_contract_c,l.phone_mobile,l.primary_address_city,l.primary_address_state, l.primary_address_postalcode AS pin,l.vendor,s.work_experience,s.functional_area,s.name AS stuname,s.country,s.email,s.dob,s.gender,s.education,s.company,b.batch_code,b.name AS bname, b.date_entered,b.te_in_institutes_id_c,b.te_pr_programs_id_c,b.te_vendor_id_c AS srmid,b.leads_id,b.batch_code,b.fee_inr,b.fee_usd,(SELECT SUM(amount) FROM te_student_payment where te_student_batch_id_c=b.id AND deleted=0)total_amount_paid,OutstandingFee(b.id)outstanding,CONCAT(cu.first_name,' ',cu.last_name)agent_name,CONCAT(sbu.first_name,' ',sbu.last_name)srm, b.status AS dropout,b.qualify_for_refund AS courcetrnsfer FROM te_student_batch b INNER JOIN te_pr_programs AS p ON p.id = b.te_pr_programs_id_c INNER JOIN te_in_institutes AS i ON i.id = b.te_in_institutes_id_c INNER JOIN leads AS l ON l.id = b.leads_id INNER JOIN te_student AS s ON s.lead_id_c = b.leads_id INNER JOIN users AS cu ON cu.id = l.assigned_user_id INNER JOIN users AS sbu ON sbu.id = b.assigned_user_id WHERE b.deleted = 0 AND s.deleted = 0".$where." ORDER BY b.name ASC";
		// ? New $sql="SELECT l.status_description, l.status AS lead_status, l.converted_date, l.utm_campaign, l.utm_contract_c, l.phone_mobile, l.primary_address_city, l.primary_address_state, l.primary_address_postalcode AS pin, l.vendor, s.work_experience, s.functional_area, s.name AS stuname, s.country, s.email, s.dob, s.gender, s.education, s.company, p.name AS pname, i.name AS insname, batch.name AS bname, batch.batch_code, batch.fees_inr, batch.fees_in_usd, l.date_entered, b.te_in_institutes_id_c, b.te_pr_programs_id_c, b.te_vendor_id_c AS srmid, b.leads_id, b.status AS dropout, b.qualify_for_refund AS courcetrnsfer, CONCAT(cu.first_name,' ',cu.last_name)agent_name, CONCAT(sbu.first_name,' ',sbu.last_name)srm FROM leads AS l INNER JOIN leads_cstm AS lc on l.id=lc.id_c LEFT JOIN te_ba_batch AS batch on batch.id=lc.te_ba_batch_id_c LEFT JOIN te_in_institutes_te_ba_batch_1_c AS batchIns on batchIns.te_in_institutes_te_ba_batch_1te_ba_batch_idb=batch.id LEFT JOIN te_pr_programs_te_ba_batch_1_c AS batchPro on batchPro.te_pr_programs_te_ba_batch_1te_ba_batch_idb=batch.id LEFT JOIN te_student_batch b ON b.leads_id=l.id LEFT JOIN te_student_te_student_batch_1_c sbRel ON sbRel.te_student_te_student_batch_1te_student_batch_idb=b.id LEFT JOIN te_student AS s ON s.id = sbRel.te_student_te_student_batch_1te_student_ida LEFT JOIN te_pr_programs AS p ON p.id = batchPro.te_pr_programs_te_ba_batch_1te_pr_programs_ida LEFT JOIN te_in_institutes AS i ON i.id = batchIns.te_in_institutes_te_ba_batch_1te_in_institutes_ida LEFT JOIN users AS cu ON cu.id = l.assigned_user_id LEFT JOIN users AS sbu ON sbu.id = b.assigned_user_id WHERE l.deleted=0".$where."";
		
		// $sql="SELECT * FROM `te_student` WHERE deleted=0";	
		/*old code
		if(isset($_POST['batches']) && $_POST['batches']){
		  $batches=implode(",'",$_POST['batches']);
		  if($batches)	 $sql .=" and b.id in ('$batches') ";
		}
		*/ 		
				
		/* Old Code 		
		if(isset($_POST['pmode']) && $_POST['pmode']){
		   
		   $sql .=" and te_student_payment.payment_type = '" .  $_POST['pmode']  ."'";
		}		
		*/	
				
		$leadObj =$db->query($sql);
		if(isset($_POST['export']) && $_POST['export']=="Export"){
				$_SESSION['lp_from_date'] = $_REQUEST['from_date'];
				$_SESSION['lp_to_date'] = $_REQUEST['to_date'];	
				if($_SESSION['lp_from_date']!="" && $_SESSION['lp_to_date']){
    			$from_date=date('Y-m-d',strtotime(str_replace('/','-',$_POST['from_date'])));
				$to_date=date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['lp_to_date'])));
				$where.=" AND DATE(l.date_entered)>='".$from_date."' AND DATE(l.date_entered)<='".$to_date."'";
			}elseif($_SESSION['lp_from_date']!=""&&$_SESSION['lp_to_date']==""){
				$from_date=date('Y-m-d',strtotime(str_replace('/','-',$_POST['from_date'])));
				$where.=" AND DATE(l.date_entered)='".$from_date."' ";
			}elseif($_SESSION['lp_from_date']==""&&$_SESSION['lp_to_date']!=""){
				$to_date=date('Y-m-d',strtotime(str_replace('/','-',$_SESSION['lp_to_date'])));
				$where.=" AND DATE(l.date_entered)='".$to_date."' ";
			}
			
			$data = "Institute Name,Course Name,Batch ID,Course Fees,Lead enquiry date,Dropout,Course Transfer,Source,Medium,Campaign Name,Student Name,Mobile No.,Email ID,Gender,Date of Birth,Address,City,State,Country,PIN,Company,Functional Area,Highest Qualification,Work Experience,Conversion Date,Status,Sub Status,Agent,Total Amount Paid,Outstanding,SRM\n";
			$file = "Studentjourney";
			$filename = $file . "_" . date ( "Y-m-d");
			//$sql="SELECT l.status_description, l.status AS lead_status, l.converted_date, l.utm_campaign, l.utm_contract_c, l.phone_mobile, l.primary_address_city, l.primary_address_state, l.primary_address_postalcode AS pin, l.vendor, s.work_experience, s.functional_area, s.name AS stuname, s.country, s.email, s.dob, s.gender, s.education, s.company, p.name AS pname, i.name AS insname, batch.name AS bname, batch.batch_code, batch.fees_inr, batch.fees_in_usd, l.date_entered, b.te_in_institutes_id_c, b.te_pr_programs_id_c, b.te_vendor_id_c AS srmid, b.leads_id, b.status AS dropout, b.qualify_for_refund AS courcetrnsfer, CONCAT(cu.first_name,' ',cu.last_name)agent_name, CONCAT(sbu.first_name,' ',sbu.last_name)srm FROM leads AS l INNER JOIN leads_cstm AS lc on l.id=lc.id_c LEFT JOIN te_ba_batch AS batch on batch.id=lc.te_ba_batch_id_c LEFT JOIN te_in_institutes_te_ba_batch_1_c AS batchIns on batchIns.te_in_institutes_te_ba_batch_1te_ba_batch_idb=batch.id LEFT JOIN te_pr_programs_te_ba_batch_1_c AS batchPro on batchPro.te_pr_programs_te_ba_batch_1te_ba_batch_idb=batch.id LEFT JOIN te_student_batch b ON b.leads_id=l.id LEFT JOIN te_student_te_student_batch_1_c sbRel ON sbRel.te_student_te_student_batch_1te_student_batch_idb=b.id LEFT JOIN te_student AS s ON s.id = sbRel.te_student_te_student_batch_1te_student_ida LEFT JOIN te_pr_programs AS p ON p.id = batchPro.te_pr_programs_te_ba_batch_1te_pr_programs_ida LEFT JOIN te_in_institutes AS i ON i.id = batchIns.te_in_institutes_te_ba_batch_1te_in_institutes_ida LEFT JOIN users AS cu ON cu.id = l.assigned_user_id LEFT JOIN users AS sbu ON sbu.id = b.assigned_user_id WHERE l.deleted=0".$where."";
			$sql="SELECT p.name AS pname,i.name AS insname,l.status_description,l.status AS lstatus,l.converted_date,l.utm_campaign,l.utm_contract_c,l.phone_mobile,l.primary_address_city,l.primary_address_state, l.primary_address_postalcode AS pin,l.vendor,s.work_experience,s.functional_area,s.name AS stuname,s.country,s.email,s.dob,s.gender,s.education,s.company,b.batch_code,b.name AS bname, b.date_entered,b.te_in_institutes_id_c,b.te_pr_programs_id_c,b.te_vendor_id_c AS srmid,b.leads_id,b.batch_code,b.fee_inr,b.fee_usd,(SELECT SUM(amount) FROM te_student_payment where te_student_batch_id_c=b.id AND deleted=0)total_amount_paid,OutstandingFee(b.id)outstanding,CONCAT(cu.first_name,' ',cu.last_name)agent_name,CONCAT(sbu.first_name,' ',sbu.last_name)srm, b.status AS dropout,b.qualify_for_refund AS courcetrnsfer FROM te_student_batch b INNER JOIN te_pr_programs AS p ON p.id = b.te_pr_programs_id_c INNER JOIN te_in_institutes AS i ON i.id = b.te_in_institutes_id_c INNER JOIN leads AS l ON l.id = b.leads_id INNER JOIN te_student AS s ON s.lead_id_c = b.leads_id INNER JOIN users AS cu ON cu.id = l.assigned_user_id INNER JOIN users AS sbu ON sbu.id = b.assigned_user_id WHERE b.deleted = 0 AND s.deleted = 0".$where." ORDER BY b.name ASC";
			$councelorList=array();
			$leadObj =$db->query($sql);
			while($row =$db->fetchByAssoc($leadObj)){
			$councelorList[]=$row;
			}
			
			foreach($councelorList as $key=>$councelor){
				if($councelor['dropout']=='Dropout'){
					$councelor['dropout']='Yes';
				 }
					else{
						$councelor['dropout']='No';
						}
				if($councelor['functional_area']==''){
				   $councelor['functional_area']='N/A';
				 }
				if($councelor['qualify_for_refund']!=''){
				   $councelor['qualify_for_refund']='Yes';
				 }
					 else{
					   $councelor['qualify_for_refund']='No';
					 }
				 if($councelor['insname']==''){
				   $councelor['insname']='N/A';
				 }
				 if($councelor['pname']==''){
				   $councelor['pname']='N/A';
				 }
				 if($councelor['batch_code']==''){
				   $councelor['batch_code']='N/A';
				 }
				 if($councelor['fee_inr']==''){
				   $councelor['fee_inr']='N/A';
				 }
				 if($councelor['date_entered']==''){
				   $councelor['date_entered']='N/A';
				 }
				 if($councelor['dropout']==''){
				   $councelor['dropout']='N/A';
				 }
				 if($councelor['vendor']==''){
				   $councelor['vendor']='N/A';
				 }
				 if($councelor['utm_contract_c']==''){
				   $councelor['utm_contract_c']='N/A';
				 }
				 if($councelor['utm_campaign']==''){
				   $councelor['utm_campaign']='N/A';
				 }
				 if($councelor['stuname']==''){
				   $councelor['stuname']='N/A';
				 }
				 if($councelor['phone_mobile']==''){
				   $councelor['phone_mobile']='N/A';
				 }
				 if($councelor['email']==''){
				   $councelor['email']='N/A';
				 }
				 if($councelor['gender']==''){
				   $councelor['gender']='N/A';
				 }
				 if($councelor['dob']==''){
				   $councelor['dob']='N/A';
				 }
				 if($councelor['primary_address_city']==''){
				   $councelor['primary_address_city']='N/A';
				 }
				  if($councelor['city']==''){
				   $councelor['city']='N/A';
				 }
				  if($councelor['primary_address_state']==''){
				   $councelor['primary_address_state']='N/A';
				 }
				  if($councelor['country']==''){
				   $councelor['country']='N/A';
				 }
				  if($councelor['pin']==''){
				   $councelor['pin']='N/A';
				 }
				  if($councelor['company']==''){
				   $councelor['company']='N/A';
				 }
				  if($councelor['functional_area']==''){
				   $councelor['functional_area']='N/A';
				 }
				 if($councelor['education']==''){
				   $councelor['education']='N/A';
				 }
				 if($councelor['work_experience']==''){
				   $councelor['work_experience']='N/A';
				 }
				 if($councelor['converted_date']==''){
				   $councelor['converted_date']='N/A';
				 }
				 if($councelor['lstatus']==''){
				   $councelor['lstatus']='N/A';
				 }
				 if($councelor['status_description']==''){
				   $councelor['status_description']='N/A';
				 }
				  if($councelor['agent_name']==''){
				   $councelor['agent_name']='N/A';
				 }
				  if($councelor['srm']==''){
				   $councelor['srm']='N/A';
				 }
				 if($councelor['total_amount_paid']==''){
				   $councelor['total_amount_paid']='N/A';
				 }
				  if($councelor['outstanding']!=''){
				   $councelor['outstanding']=$councelor['outstanding']-$councelor['total_amount_paid'];
				 }
				
				$data.= "\"" . $councelor['insname'] . "\",\"" . $councelor['pname'] . "\",\"". $councelor['batch_code']. "\",\"". $councelor['fee_inr']. "\",\"". $councelor['date_entered']. "\",\"". $councelor['dropout']. "\",\"".$councelor['qualify_for_refund']."\",\"". $councelor['vendor']. "\",\"". $councelor['utm_contract_c']. "\",\"". $councelor['utm_campaign']. "\",\"". $councelor['stuname']. "\",\"". $councelor['phone_mobile']. "\",\"". $councelor['email']. "\",\"". $councelor['gender']. "\",\"". $councelor['dob']. "\",\"". $councelor['primary_address_city']. "\",\"". $councelor['city']. "\",\"". $councelor['primary_address_state']. "\",\"". $councelor['country']. "\",\"". $councelor['pin']. "\",\"". $councelor['company']. "\",\"". $councelor['functional_area']. "\",\"". $councelor['education']. "\",\"". $councelor['work_experience']. "\",\"". $councelor['converted_date']. "\",\"". $councelor['lstatus']. "\",\"". $councelor['status_description']. "\",\"". $councelor['agent_name']. "\",\"". $councelor['total_amount_paid']. "\",\"". $councelor['outstanding']. "\",\"". $councelor['srm']. "\"\n";
				}	
			//echo $data;die;
			ob_end_clean();
			header("Content-type: application/csv");
			header ('Content-disposition: attachment;filename="Studentjourney.csv";' );
			echo $data; exit;
			
		}
		$councelorList=array();
		while($row =$db->fetchByAssoc($leadObj)){
			$councelorList[]=$row;
		}
		/*
		foreach($councelorList as $key=>$councelor){
				if(!isset($councelor['osb'])){
					$councelor['osb']=$councelor['total_amount_paid']-$councelor['outstanding'];
				}

					}
					
		*/
		
		
		
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
			if(isset($_SESSION['lp_from_date']) && !empty($_SESSION['lp_from_date'])){
			$selected_from_date = date('d-m-Y',strtotime($_SESSION['lp_from_date']));
			}
			if(isset($_SESSION['lp_to_date']) && !empty($_SESSION['lp_to_date'])){
			$selected_to_date = date('d-m-Y',strtotime($_SESSION['lp_to_date']));
			}
			$sugarSmarty = new Sugar_Smarty();
			$sugarSmarty->assign("councelorList",$councelorList);
			$sugarSmarty->assign("selected_from_date",$_POST['from_date']);
			$sugarSmarty->assign("selected_to_date",$_POST['to_date']);
			//$sugarSmarty->assign("retmode",$_POST['pmode']);		 
			$sugarSmarty->assign("current_records",$current);
			$sugarSmarty->assign("selected_from_date",$selected_from_date);
			$sugarSmarty->assign("selected_to_date",$selected_to_date);			
			$sugarSmarty->assign("page",$page);
			$sugarSmarty->assign("pagenext",$pagenext);
			$sugarSmarty->assign("right",$right);
			$sugarSmarty->assign("left",$left);
			$sugarSmarty->assign("last_page",$last_page);
			$sugarSmarty->display('custom/modules/AOR_Reports/tpls/studentjourney.tpl');		
	}
}

?>

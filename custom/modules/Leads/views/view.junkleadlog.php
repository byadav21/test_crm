<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');
class LeadsViewJunkleadlog extends SugarView
{
    public function __construct()
    {
        parent::SugarView();
    }
    
    public function display()
    {
        global $db, $current_user;
        $logID = $current_user->id;
	$councelorList = [];
        if (isset($_REQUEST['button']) || isset($_REQUEST['export']))
	{
	    $_SESSION['jl_from_date']   = ($_REQUEST['from_date']) ? date("Y-m-d",strtotime($_REQUEST['from_date'])) : '';
	    $_SESSION['jl_to_date']     = ($_REQUEST['to_date']) ? date("Y-m-d",strtotime($_REQUEST['to_date'])) : '';
	}
	if(!isset($_SESSION['jl_from_date']) || empty($_SESSION['jl_from_date'])){
		$_SESSION['jl_from_date'] = date('Y-m-d');
	}
	if(!isset($_SESSION['jl_to_date']) || empty($_SESSION['jl_to_date'])){
		$_SESSION['jl_to_date'] = date('Y-m-d');
	}
        $wheredr = "";
	if (!empty($_SESSION['jl_from_date']))
	{
	    $selected_from_date = date("d-m-Y",strtotime($_SESSION['jl_from_date']));
	    $wheredr .= " AND DATE(l.date_entered)>='" . $_SESSION['jl_from_date'] . "'";
	}
	if (!empty($_SESSION['jl_to_date']))
	{
	   $selected_to_date = date("d-m-Y",strtotime($_SESSION['jl_to_date']));
	   $wheredr .= " AND DATE(l.date_entered)<='" . $_SESSION['jl_to_date'] . "'";
	}
		$sqlRel = "SELECT l.id,l.date_entered,l.first_name, l.last_name, l.phone_mobile, l.date_entered, lc.email_add_c, b.name AS batch_name, b.batch_code, l.autoassign, l.dristi_campagain_id, l.dristi_API_id, l.assigned_user_id,l.utm_term_c
FROM  `leads` AS l
INNER JOIN leads_cstm AS lc ON l.id = lc.id_c
LEFT JOIN te_ba_batch AS b ON b.id = lc.te_ba_batch_id_c
WHERE l.neoxstatus =0
AND l.deleted =0
AND l.status_description='New Lead'
AND (l.assigned_user_id='' || l.assigned_user_id='NULL' || l.assigned_user_id=null) $wheredr
ORDER BY l.date_entered DESC ";
      		$rel    = $db->query($sqlRel);
		if($db->getRowCount($rel) > 0){
			$i = 0;
			while($row = $db->fetchByAssoc($rel)){
				$reason='';
				$is_correct=0;
				$councelorList[$i] = $row;
				if(strlen($row['phone_mobile'])!=10){
					$reason='Incorrect phone number format';
				}
				else if(empty($row['batch_name']) && !empty($row['utm_term_c'])){
					$reason='Batch code is Missing due to INCORRECT UTM ';
				}
				else if(empty($row['batch_name'])){
					$reason='Batch ID is missing on CRM ';
				}
				else if(empty($row['autoassign']) || $row['autoassign']=='No'){
					$reason='Autoassign Flag is missing on CRM ';
				}
				else if(empty($row['dristi_campagain_id'])){
					$reason='Campaign ID missing on CRM ';
				}
				else if(empty($row['dristi_API_id'])){
					$reason='Api ID missing on CRM ';
				}
				
				else{
					$is_correct=1;
					$reason='All fields are correct. Lead is yet to go into Ameyo ';
				}
				$councelorList[$i]['reason']=$reason;
				if($is_correct==1){
					unset($councelorList[$i]);
				}
				$i++;
				
			}
		}
			if(isset($_REQUEST['export'])){
				$this->__export_data($councelorList);
			}
			#Pagination
			$total=count($councelorList); #total records
			$start=0;
			$per_page=50;
			$page=1;
			$pagenext=1;
			$last_page=ceil($total/$per_page);

			if(isset($_REQUEST['page']) && $_REQUEST['page']>0){
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

        $sugarSmarty = new Sugar_Smarty();
	$sugarSmarty->assign("result_data", $councelorList);
	
	$sugarSmarty->assign("selected_from_date",$selected_from_date);
	$sugarSmarty->assign("selected_to_date",$selected_to_date);

	$sugarSmarty->assign("current_records",$current);
	$sugarSmarty->assign("page",$page);
	$sugarSmarty->assign("pagenext", $pagenext);
	$sugarSmarty->assign("right",$right);
	$sugarSmarty->assign("leftpage",$leftpage);
	$sugarSmarty->assign("left",$left);
	$sugarSmarty->assign("last_page",$last_page);
        $sugarSmarty->display('custom/modules/Leads/tpls/junkleadlog.tpl');
    }
    function __export_data($row_data=array()){
	    $data     = "Lead ID, Full Name,Email,Mobile No,Date Entered,Batch Code,UTM Term,Campaign ID,API ID, Reason\n";
	    $file     = "junk_lead_log".$_SESSION['jl_from_date']."_".$_SESSION['jl_to_date'];
	    $filename = $file;
	    foreach ($row_data as $key => $councelor)
	    {
	        $full_name = $councelor['first_name']." ".$councelor['last_name'];
	        $data .= "\"" . $councelor['id'] . "\",\"" . $full_name . "\",\"" . $councelor['email_add_c'] . "\",\"" . $councelor['phone_mobile'] . "\",\"" .$councelor['date_entered'] . "\",\"" .$councelor['batch_code'] . "\",\"" .$councelor['utm_term_c'] . "\",\"" .$councelor['dristi_campagain_id'] . "\",\"" .$councelor['dristi_API_id'] . "\",\"" . $councelor['reason'] . "\"\n";
	    }
	    ob_end_clean();
	    header("Content-type: application/csv");
	    header('Content-disposition: attachment;filename=" ' . $filename . '.csv";');
	    echo $data;
	    exit;
  }
}
?>

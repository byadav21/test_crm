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
//SELECT l.id,l.first_name,l.last_name,l.phone_mobile,l.date_entered,lc.email_add_c,lc.te_ba_batch_id_c,l.autoassign,l.dristi_campagain_id,dristi_API_id FROM  `leads` AS l INNER JOIN leads_cstm AS lc ON l.id=lc.id_c WHERE LENGTH( l.phone_mobile ) <>10 AND l.neoxstatus=0  AND l.deleted=0 order by l.date_entered DESC limit 0,100
        global $db, $current_user;
        $logID = $current_user->id;
	if($current_user->is_admin==1){}
	$councelorList = [];
        
        
		$sqlRel = "SELECT l.id,l.date_entered,l.first_name, l.last_name, l.phone_mobile, l.date_entered, lc.email_add_c, b.name AS batch_name, b.batch_code, l.autoassign, l.dristi_campagain_id, l.dristi_API_id, l.assigned_user_id
FROM  `leads` AS l
INNER JOIN leads_cstm AS lc ON l.id = lc.id_c
LEFT JOIN te_ba_batch AS b ON b.id = lc.te_ba_batch_id_c
WHERE l.neoxstatus =0
AND l.deleted =0
AND l.status_description='New Lead'
AND (l.assigned_user_id='' || l.assigned_user_id='NULL' || l.assigned_user_id=null)
ORDER BY l.date_entered DESC ";
      		$rel    = $db->query($sqlRel);
		if($db->getRowCount($rel) > 0){
			$i = 0;
			while($row = $db->fetchByAssoc($rel)){
				$reason='';
				$councelorList[$i] = $row;
				if(strlen($row['phone_mobile'])!=10){
					$reason='Incorrect phone number format';
				}
				else if(empty($row['batch_name'])){
					$reason='Batch ID is missing on CRM ';
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
					$reason='Pass ';
				}
				$councelorList[$i]['reason']=$reason;
				$i++;
				
			}
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
	
	$sugarSmarty->assign("current_records",$current);
	$sugarSmarty->assign("page",$page);
	$sugarSmarty->assign("pagenext", $pagenext);
	$sugarSmarty->assign("right",$right);
	$sugarSmarty->assign("leftpage",$leftpage);
	$sugarSmarty->assign("left",$left);
	$sugarSmarty->assign("last_page",$last_page);
        $sugarSmarty->display('custom/modules/Leads/tpls/junkleadlog.tpl');
    }
    public function get_user_role($user_id=NULL){
	
   }
}
?>

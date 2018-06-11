<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');
class LeadsViewIndivisuallog extends SugarView
{
    public function __construct()
    {
        parent::SugarView();
    }
    
    public function display()
    {
        global $db, $current_user;
        $logID = $current_user->id;
	$resArr = [];
        
        if (!isset($_GET['ivd']) || empty($_GET['ivd'])) {
            SugarApplication::appendErrorMessage('Action Prohibited: Individual Id is missing');
        //set params
        $params = array(
            'module'=> 'Leads', //the module you want to redirect to
            'action'=>'index', //the view within that module
            //'record' => $_REQUEST['record'], //the record id
        );
	//redirect      
	SugarApplication::redirect('index.php?' . http_build_query($params));
            
        }
	else{
		$sqlRel = "SELECT l.id,lc.te_ba_batch_id_c,l.date_entered,lc.email_add_c,l.status,l.status_description,lc.individual_id_c,lc.individual_idstatus_c,lc.individual_idbatchstatus_c,l.first_name,l.last_name,b.name AS batch_name,b.batch_code,u.first_name AS user_fname,u.last_name AS user_lname FROM leads l INNER JOIN leads_cstm lc ON l.id=lc.id_c AND l.deleted=0 LEFT JOIN te_ba_batch AS b ON b.id=lc.te_ba_batch_id_c LEFT JOIN users  AS u ON u.id=l.assigned_user_id WHERE lc.individual_id_c='" . trim($_GET['ivd']) . "' ORDER BY l.date_entered ASC";
      		$rel    = $db->query($sqlRel);
		if($db->getRowCount($rel) > 0){
			while($row = $db->fetchByAssoc($rel)){
			$resArr[] = $row;
			}
		}
        }
        //echo "<pre>";print_r($resArr);exit();
        
        
        $sugarSmarty = new Sugar_Smarty();
        $sugarSmarty->assign("List", $List);
	$sugarSmarty->assign("result_data", $resArr);
        $sugarSmarty->display('custom/modules/Leads/tpls/indivisuallog.tpl');
    }
}
?>

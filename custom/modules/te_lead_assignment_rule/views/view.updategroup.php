<?php
if (!defined('sugarEntry') || !sugarEntry)
	die('Not A Valid Entry Point');

class te_lead_assignment_ruleViewupdategroup extends SugarView {
	
	public function __construct() {
		
		parent::SugarView();
	}
	
	public function display() {
		//~ echo "----------------";die;
		global $db;
		$queryParams = array(
			'module' => 'te_lead_assignment_rule',
			'action' => 'updategroup',
			'record' => trim($_REQUEST['record']),
		);	
//~ print_r($_REQUEST);
//~ die;
// Remove the user from security Group		
		if(isset($_REQUEST['removerecord']) && !empty($_REQUEST['removerecord'])){
			$sqlupdate = "UPDATE securitygroups_users SET deleted =1 WHERE user_id LIKE '".trim($_REQUEST['removerecord'])."'";
			$db->query($sqlupdate);
			SugarApplication::redirect('index.php?' . http_build_query($queryParams));
		}
// Prepare the User Drop Down

		$sqlUsers = "SELECT id,first_name,last_name FROM users WHERE status ='Active' AND deleted =0 ORDER BY first_name"; 
		
		$usersListObj =$db->query($sqlUsers);
		$usersListOptions=array();
		while($u =$db->fetchByAssoc($usersListObj)){ 
			$usersListOptions[$u['id']]=$u['first_name']." ".$u['last_name'];
		}
// Add the user in the selected Group		

	if(isset($_REQUEST['adrecord']) && !empty($_REQUEST['adrecord']) && isset($_REQUEST['record']) && !empty($_REQUEST['record'])){
			$sqlCheck = "SELECT * FROM securitygroups_users WHERE securitygroup_id='".$_REQUEST['record']."' AND user_id='".$_REQUEST['adrecord']."' AND deleted =0";
			
			$rCheck = $db->query($sqlCheck);
			if($db->getRowCount($rCheck) > 0){
				echo "User Already exist in the Group !!";
			}
			else{
				$addUser = "INSERT INTO securitygroups_users SET id='".create_guid()."', date_modified='".date('Y-m-d h:i:s')."',
							securitygroup_id='".$_REQUEST['record']."',user_id='".$_REQUEST['adrecord']."'";
					//~ echo $addUser; 
				$db->query($addUser);
			}
			SugarApplication::redirect('index.php?' . http_build_query($queryParams));
		}
		
// Show the Users List of existing users associated with Group		
		$groupSql = "SELECT name FROM securitygroups WHERE id LIKE '".trim($_REQUEST['record'])."' AND deleted =0 ";
		$groupObj =$db->query($groupSql);
		$row =$db->fetchByAssoc($groupObj);
		$groupName = $row['name'];
		$groupid = trim($_REQUEST['record']);
		//~ echo $groupName;die;



		
		$userSql = "SELECT u.* FROM users u INNER JOIN securitygroups_users su ON u.id=su.user_id WHERE su.securitygroup_id LIKE '".trim($_REQUEST['record'])."' AND su.deleted =0 ORDER BY u.first_name";
		//~ echo $userSql;
		$userObj =$db->query($userSql);
		//~ $batchOptions=array();
		while($user =$db->fetchByAssoc($userObj)){ 
			$userDataList[]=$user;
		}
		//~ echo "<pre>";
		//~ print_r($usersListOptions);
		//~ echo "</pre>";
		$sugarSmarty = new Sugar_Smarty();
		$sugarSmarty->assign("groupName",$groupName);
		$sugarSmarty->assign("groupid",$groupid);
		$sugarSmarty->assign("usersListOptions",$usersListOptions);
		//~ $sugarSmarty->assign("batchStatusList",$batchStatusList);
		//~ $sugarSmarty->assign("groupDataList",$groupDataList);
		$sugarSmarty->assign("userDataList",$userDataList);
		//~ $sugarSmarty->assign("selected_vendor",$selected_vendor);
		//~ $sugarSmarty->assign("selected_status",$selected_status);
		//~ $sugarSmarty->assign("selected_date",$search_date);
		//~ 
		$sugarSmarty->display('custom/modules/te_lead_assignment_rule/tpls/updategroup.tpl');
	}
}






?>

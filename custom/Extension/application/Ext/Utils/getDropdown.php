<?php 
function getRoleList(){
	static $dropDown = null;
	if(!$dropDown){
		global $db;
		$query = "SELECT id,name  FROM acl_roles WHERE deleted=0 ORDER BY name ASC ";
		$result = $db->query($query, false);
		$dropDown = array();
		$dropDown[''] = '';
		while (($row = $db->fetchByAssoc($result)) != null) {
			$dropDown[$row['id']] = $row['name'];
		}
	}
	return $dropDown;
}
# function will return list of vendors drop down in assignment rule module
function getVendorList(){
	static $dropDown = null;
	if(!$dropDown){
		global $db;
		$query = "SELECT id,name  FROM te_vendor WHERE deleted=0 ORDER BY name ASC ";
		$result = $db->query($query, false);
		$dropDown = array();
		$dropDown[''] = '';
		while (($row = $db->fetchByAssoc($result)) != null) {
			$dropDown[$row['name']] = $row['name'];
		}
	}
	return $dropDown;
}
# function will return list of vendors drop down in target campaign module
function getProgramList(){
	static $dropDown = null;
	if(!$dropDown){
		global $db;
		$query = "SELECT id,name  FROM te_pr_programs WHERE deleted=0 ORDER BY name ASC ";
		$result = $db->query($query, false);
		$dropDown = array();
		$dropDown[''] = '';
		while (($row = $db->fetchByAssoc($result)) != null) {
			$dropDown[$row['id']] = $row['name'];
		}
	}
	return $dropDown;
}
# function will return list of vendors drop down in target campaign module
function getTemplateList(){
	static $dropDown = null;
	if(!$dropDown){
		global $db;
		$query = "SELECT id,name FROM email_templates WHERE type='email' AND deleted=0";
		$result = $db->query($query, false);
		$dropDown = array();
		$dropDown[''] = '';
		while (($row = $db->fetchByAssoc($result)) != null) {
			$dropDown[$row['id']] = $row['name'];
		}
	}
	return $dropDown;
}
# function will return list of batch drop down in leads module
function getBatchList(){
	static $dropDown = null;
	if(!$dropDown){
		global $db;
		$query = "SELECT distinct(b.id),b.name,b.batch_code FROM `te_ba_batch` "
                        . "b INNER JOIN leads_cstm lc ON b.id=lc.te_ba_batch_id_c "
                        . " where b.deleted=0 "
                        . " and b.batch_status in ('enrollment_in_progress')";
		$result = $db->query($query, false);
		$dropDown = array();
		$dropDown[''] = '';
		while (($row = $db->fetchByAssoc($result)) != null) {
			$dropDown[$row['id']] = $row['name'].' ( '.$row['batch_code'].' ) ';
		}
	}
       
        
	return $dropDown;
}
# Current Users Details
$userArr=[];
function assigned_users_list(){
	global $current_user;
	$currentUserId = $current_user->id;
	static $dropDown = null;
	if(!$dropDown){
		$result[] = reportingUser($currentUserId);
		if($GLOBALS['userArr']){
			foreach($GLOBALS['userArr'] as $val){
				$userList = explode('__',$val);
				$dropDown[$userList[1]]=$userList[0];
			}	
		}
		
	}
        $dropDown[$currentUserId]= $current_user->name;
	return $dropDown;
}
function massReportingUsers(){
    global $current_user;
    $userObj                             = new User();
    $userObj->disable_row_level_security = true;
    $dropDown = array();
    $userList = $userObj->get_full_list("", "users.employee_status='Active'");

        if (!empty($userList))
        {

            foreach ($userList as $record)
            {
                $dropDown[$record->id] = $record->name;
            }
        }
    return $dropDown;
}
function reportingUser($currentUserId)
{
    global $current_user;
    $userObj                             = new User();
    $userObj->disable_row_level_security = true;

    if ($current_user->is_admin == 1)
    {
        $userList = $userObj->get_full_list("", "users.employee_status='Active'");

        if (!empty($userList))
        {

            foreach ($userList as $record)
            {
                $GLOBALS['userArr'][] = $record->name . "__" . $record->id;
            }
        }
    }
    else
    {

        $userList = $userObj->get_full_list("", "users.reports_to_id='" . $currentUserId . "' AND users.employee_status='Active'");

        if (!empty($userList))
        {

            foreach ($userList as $record)
            {

                if (!empty($record->reports_to_id))
                {
                    $GLOBALS['userArr'][] = $record->name . "__" . $record->id;
                    reportingUser($record->id);
                }
            }
        }
    }
}

?>

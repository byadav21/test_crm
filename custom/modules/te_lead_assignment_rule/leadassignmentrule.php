<?php
if(!defined('sugarEntry')) {
	define('sugarEntry', true);
}
ini_set('display_errors', 0);
ini_set("memory_limit","512M");
global $db;

//~ $leadSql="SELECT l.id,l.lead_source,l.status,lc.te_ba_batch_id_c FROM leads l INNER JOIN leads_cstm lc ON l.id=lc.id_c WHERE l.deleted=0 AND l.assigned_user_id is NULL ORDER BY date_entered DESC LIMIT 0,50";

$leadSql="SELECT l.id,l.vendor as lead_source,l.status,lc.te_ba_batch_id_c FROM leads l LEFT JOIN leads_cstm lc ON l.id=lc.id_c WHERE l.deleted=0 AND l.status<>'Duplicate' AND l.assigned_flag = 0 AND l.vendor<>'' ORDER BY date_entered DESC LIMIT 0,50";
//~ echo $leadSql."----";
$leadObj = $db->query($leadSql);
$flag=0;
//~ echo "<pre>";236*5=118000
$i = 0;
while($row=$db->fetchByAssoc($leadObj)){
	//
	$ruleSql="SELECT * FROM  te_lead_assignment_rule WHERE  rule_status='active' AND te_ba_batch_id_c='".$row['te_ba_batch_id_c']."' AND deleted=0";
	$lruleObj = $db->query($ruleSql);
	$rules=$db->fetchByAssoc($lruleObj);
	if($lruleObj->num_rows==0)
		continue;
	$source=explode(",",str_replace("^","",$rules['lead_source']));
	if(!in_array($row['lead_source'],$source))
		continue;
	
	# Assign leads to a particular agent/user
	 if(!empty($rules['user_id_c'])){
		$assql = "UPDATE leads SET assigned_user_id='".$rules['user_id_c']."',assigned_flag=1 WHERE id='".$row['id']."'";
		$db->query($assql);
		$i++;
	}else{
		
		if(!empty($rules['securitygroup_id_c'])){  
		# Assign leads to security groups
			if(!$flag){
				$createSql="CREATE TEMPORARY TABLE agent(
				user_id varchar(36) NULL 
				,assigned int(2) NULL
				,total int(5) default 0)";
				$db->query($createSql);
				#get users 
				if($rules['method']=="round_robin"){
					$userSql="SELECT user_id FROM securitygroups_users WHERE securitygroup_id='".$rules['securitygroup_id_c']."'";
					$userObj=$db->query($userSql);
					while($res=$db->fetchByAssoc($userObj)){
						$db->query("INSERT INTO agent SET user_id='".$res['user_id']."',assigned=0");			
					}
					#get users from associated roles
					$roleUsersSql="select ru.user_id,ru.role_id,ru.deleted,sr.deleted as sr_deleted from securitygroups_acl_roles sr INNER JOIN acl_roles_users ru ON sr.role_id=ru.role_id WHERE sr.deleted=0 AND ru.deleted=0 AND sr.securitygroup_id='".$rules['securitygroup_id_c']."'";
					$roleUsersObj=$db->query($roleUsersSql);
					while($res=$db->fetchByAssoc($roleUsersObj)){
						$db->query("INSERT INTO agent SET user_id='".$res['user_id']."',assigned=0");			
					}
				}else{
					$userSql="SELECT su.user_id,count(l.id) as total from securitygroups_users su LEFT JOIN leads l ON su.user_id=l.assigned_user_id WHERE su.deleted=0 AND su.securitygroup_id='".$rules['securitygroup_id_c']."' GROUP BY su.user_id";
					
					$userObj=$db->query($userSql);
					while($res=$db->fetchByAssoc($userObj)){
						$db->query("INSERT INTO agent SET user_id='".$res['user_id']."',assigned=0,total='".$res['total']."'");	
					}
					#get users from associated roles
					$roleUsersSql="select ru.user_id,ru.deleted, count(l.id) as total from securitygroups_acl_roles sr INNER JOIN acl_roles_users ru ON sr.role_id=ru.role_id LEFT JOIN leads l ON ru.user_id=l.assigned_user_id WHERE ru.deleted=0 AND sr.securitygroup_id='".$rules['securitygroup_id_c']."' GROUP BY ru.user_id";
					$roleUsersObj=$db->query($roleUsersSql);
					while($res=$db->fetchByAssoc($roleUsersObj)){
						$db->query("INSERT INTO agent SET user_id='".$res['user_id']."',assigned=0,total='".$res['total']."'");			
					}
				}						
				$flag++;
			}
			if($rules['method']=="round_robin"){
				$agentSql="SELECT user_id FROM agent WHERE assigned=0 limit 0,1";
				$agentObj=$db->query($agentSql);
				if($agentObj->num_rows==0){
					$db->query("UPDATE agent set assigned=0");
					$agentSql="SELECT user_id FROM agent WHERE assigned=0 limit 0,1";
					$agentObj=$db->query($agentSql);
				}		
				$agent=$db->fetchByAssoc($agentObj);
				$db->query("UPDATE leads set assigned_user_id='".$agent['user_id']."',assigned_flag=1 WHERE id='".$row['id']."'");
				$i++;
				$db->query("UPDATE agent set assigned=1 WHERE user_id='".$agent['user_id']."'");
			}else{
				$agentSql="SELECT user_id FROM agent ORDER BY total ASC limit 0,1";
				$agentObj=$db->query($agentSql);
				$agent=$db->fetchByAssoc($agentObj);
				$db->query("UPDATE leads set assigned_user_id='".$agent['user_id']."',assigned_flag=1 WHERE id='".$row['id']."'");
				$i++;
				$db->query("UPDATE agent set total=total+1 WHERE user_id='".$agent['user_id']."'");
			}
		}
	} 
}

echo "Total Lead Assigned --".$i;


?>

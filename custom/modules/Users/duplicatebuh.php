<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

ini_set('memory_limit','1024M');
require_once('include/entryPoint.php');
global $db;
$designation=$_REQUEST['designation'];

$userSql = "SELECT count(id) as total FROM users WHERE deleted=0 AND status='Active' AND designation='BUH'";
$userObj = $db->query($userSql);
$user = $db->fetchByAssoc($userObj);
if($user['total']>0){
	echo json_encode(array('message'=>'yes'));
}else{
	echo json_encode(array('message'=>'no'));
}
<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

ini_set('memory_limit','1024M');
require_once('include/entryPoint.php');
global $db;
$record=$_REQUEST['record_id'];
$updateSql="UPDATE te_utm SET utm_status='Expired' WHERE id='".$record."'";
$db->query($updateSql);
echo json_encode(array('status'=>$updateSql));	

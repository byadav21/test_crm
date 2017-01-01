<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

ini_set('memory_limit','1024M');
require_once('include/entryPoint.php');
global $db;
$vendor_id=$_REQUEST['vender_id_c'];
$contract_type=$_REQUEST['contract_type'];

$contractSql = "SELECT c.id FROM aos_contracts c INNER JOIN te_vendor_aos_contracts_1_c r ON c.id=r.te_vendor_aos_contracts_1aos_contracts_idb AND r.deleted=0  WHERE r.te_vendor_aos_contracts_1te_vendor_ida='".$vendor_id."' AND c.contract_type='".$contract_type."' AND c.deleted=0";
$contractObj = $db->query($contractSql);
$contract = $db->fetchByAssoc($contractObj);
if($contract['id']!=null){
	echo json_encode(array('message'=>'yes'));
}else{
	echo json_encode(array('message'=>'no'));
}
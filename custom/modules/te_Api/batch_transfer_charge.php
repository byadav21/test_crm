<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
ini_set('memory_limit', '1024M');
require_once('include/entryPoint.php');
global $db;

$emailid=$_REQUEST['email'];
$batchcode=	$_REQUEST['batchcode'];
$studentbatch	=	$_REQUEST['crm_student_batch'];
$updatedata="UPDATE te_student_batch set bt_fee_waiver='4' where id='".$studentbatch."'";
$updatequerydata=$db->query($updatedata);
echo 'Hello world';

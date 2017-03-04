<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

ini_set('memory_limit','1024M');
require_once('include/entryPoint.php');
global $db;

$dropoutSql="UPDATE te_student_batch SET dropout_status='".$_REQUEST['request_status']."',refund_date='".$GLOBALS['timedate']->to_db_date($_REQUEST['refund_date'],false)."',refund_amount='".$_REQUEST['refund_amount']."',dropout_type='".$_REQUEST['dropout_type']."' WHERE id='".$_REQUEST['request_id']."'";
$GLOBALS['db']->query($dropoutSql);

$dropoutStatue['status']="Approved";
echo json_encode($dropoutStatue);
return false;

?>
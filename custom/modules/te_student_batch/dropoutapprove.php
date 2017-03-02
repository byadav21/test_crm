<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

ini_set('memory_limit','1024M');
require_once('include/entryPoint.php');
global $db;

$dropoutSql="UPDATE te_student_batch SET dropout_status='".$_REQUEST['request_status']."' WHERE id='".$_REQUEST['request_id']."' AND deleted=0";
$GLOBALS['db']->query($dropoutSql);

$dropoutStatue['status']="Approved";
echo json_encode($dropoutStatue);
return false;

?>
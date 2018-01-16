<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
ini_set('memory_limit','1024M');
require_once('include/entryPoint.php');
global $db;
$data = json_decode(file_get_contents('php://input'), true);
$error_fields=[];
$discount=' 0';

            
            
if(empty($data)){
	$error_fields['error:']=['empty data'];

}


if($error_fields){
	$response_result = array('status' => '400','result' => $error_fields);
	echo json_encode($response_result);
	exit();
}
else{
    
    
      foreach($data as $key=>$val){
          
          
        $crm_orderid=$val['crm_orderid'];
        
        if(!$crm_orderid){  continue; }

	/*check valid crm_payment_id in case of update*/
	if($crm_orderid!='')
            {
            
            
                $GLOBALS['db']->query("UPDATE te_payment_details SET invoice_number='".$val['invno']."' WHERE id='".$crm_orderid."'");
            
                $fp = fopen('invoiceNo2_API_log_.txt', 'a'); 
                fwrite($fp,print_r($val,TRUE)); 
                fclose($fp);
	
            }
	
      }
    
    
	
	
}


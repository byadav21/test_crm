<?php 

if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');
require_once('modules/te_expense_vendor/te_expense_vendor.php');
global $db;
$vendorObj = new te_expense_vendor();
$vendor_id = $_POST['id'];
$data = $vendorObj->retrieve($vendor_id);

$data= array();


 //$db=DBManagerFactory::getInstance();
 $proQuery ="SELECT ep.id,ep.name FROM `te_expense_vendor` ev 
            INNER JOIN `te_expense_vendor_cstm` evc ON ev.id=evc.id_c
            INNER JOIN `te_expense_product` ep ON evc.te_department_expense_id_c=ep.te_department_expense_id_c 
            WHERE ev.id='".$vendor_id."'";
 $itemDetal=$db->query($proQuery);
 $drop='';
 while($row=$db->fetchByAssoc($itemDetal)){
    
      $drop .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
 }

 


$data['product_drop']=$drop;
$data['gl_code']=$vendorObj->glcode;
$data['cost_center']= '<option label="'.$vendorObj->cost_center.'" value="'.$vendorObj->cost_center.'">'.$vendorObj->cost_center.'</option>';
echo json_encode($data);

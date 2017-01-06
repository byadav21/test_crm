<?php
if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');

class vc_class{
    function vc_method(&$bean, $event, $arguments) {
    global $db;
				
       // Total Programs 
     
				$row1 =$db->query("SELECT c.te_vendor_aos_contracts_1aos_contracts_idb FROM  te_vendor v LEFT JOIN  te_vendor_aos_contracts_1_c c ON c.te_vendor_aos_contracts_1te_vendor_ida =v.id WHERE c.deleted=0 AND v.deleted=0 AND v.id='".$bean->id."'");								                                       
						   if($row1->num_rows>0){
							echo "<style>
							#edit-".$bean->id." {
							display: none;
							}
							input[type='checkbox'][value='".$bean->id."'] {
							 display: none;
							}
							</style>";
							
							echo"
							<script>
							$(document).ready(function(){
							$('.checkbox').prop('disabled', true);
							});
							</script>";
							
						  
								}
		 }
    }
?>

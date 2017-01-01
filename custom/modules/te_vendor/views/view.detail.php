<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once 'include/MVC/View/views/view.detail.php';
class te_vendorViewDetail extends ViewDetail
{
    public function preDisplay()
    {
        parent::preDisplay();
    }
	public function display()
    { 
		global $db;
			$row1 =$db->query("SELECT COUNT(c.te_vendor_aos_contracts_1aos_contracts_idb) AS TOTAL FROM  te_vendor v LEFT JOIN  te_vendor_aos_contracts_1_c c ON c.te_vendor_aos_contracts_1te_vendor_ida =v.id WHERE c.deleted=0 AND v.deleted=0 AND v.id='".$this->bean->id."'");
			//echo $QT="(SELECT COUNT(id) AS TOTAL FROM `te_vendor_aos_contracts_1_c` WHERE deleted=0 AND te_vendor_aos_contracts_1te_vendor_ida='".$this->bean->id."'");
						$res1 =$db->fetchByAssoc($row1);				
						if(!empty($res1['TOTAL'])){
			   echo '<script>
					$(document).ready(function(){
						$("#delete_button").hide();
						$("#edit_button_old").hide();
						$("#edit_button").hide();
						});
						</script>'; 
					//	unset($this->dv->defs['templateMeta']['form']['buttons'][0]);
						//unset($this->dv->defs['templateMeta']['form']['buttons'][2]);
								}
		parent::display();
	}
} 

?>

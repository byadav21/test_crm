<?php
class vendor_class{
	function vendor_method(&$bean, $event, $arguments){
		global $db;
	

		if(!$bean->fetched_row){

		     echo $qry ="select name from te_vendor where (deleted=0) and (id!='".$bean->id."') and (name='".$bean->name."')";
	    
	         $qry2= $db->query($qry);
		     while($row=$db->fetchByAssoc($qry2)){
				
             SugarApplication::redirect('index.php?module=te_vendor&action=ShowDuplicates_custom&name='.$bean->name.'');
			}
		}
			
	}
	 
}
?>
 

<?php

class duplicate_logic{
	function duplicate_logic_method(&$bean, $event, $arguments){
		global $db;
	
		
	if(!$bean->fetched_row || $bean->fetched_row ){
			
		     echo $qry ="select name from te_in_institutes where (deleted=0) and (id!='".$bean->id."') and (name='".$bean->name."')";
	    
	         $qry2= $db->query($qry);
		     while($row=$db->fetchByAssoc($qry2)){
				
             SugarApplication::redirect('index.php?module=te_in_institutes&action=ShowDuplicates_custom&name='.$bean->name.'');
			}
		}
			
	}
	 
}
?>
 

<?php
class duplicate_category{
	function duplicate_category_logic_method(&$bean, $event, $arguments){
		global $db;
	
	
		if(!$bean->fetched_row || $bean->fetched_row ){
			
		     echo $qry ="select name from te_program_category where (deleted=0) and (id!='".$bean->id."') and (name='".$bean->name."')";
	    
	         $qry2= $db->query($qry);
		     while($row=$db->fetchByAssoc($qry2)){
				
             SugarApplication::redirect('index.php?module=te_Program_category&action=ShowDuplicatesprogram&name='.$bean->name.'');
			}
		}
			
	}
	 
}
?>
 

<?php
class first_logic{
	function first_logic_method(&$bean, $event, $arguments){
		global $db;
	
	/*
	
		$qry ="select name from te_pr_Programs where deleted=0 and id!='".$bean->id."'";
		$qry1= $db->query($qry);
		while($row=$db->fetchByAssoc($qry1)){
             SugarApplication::redirect('index.php?module=te_pr_Programs&action=ShowDuplicates_custom');
			}
		}
		*/	
		
		if(!$bean->fetched_row){
			
		     echo $qry ="select name from te_pr_programs where (deleted=0) and (id!='".$bean->id."') and (name='".$bean->name."')";
	    
	         $qry2= $db->query($qry);
		     while($row=$db->fetchByAssoc($qry2)){
				
             SugarApplication::redirect('index.php?module=te_pr_Programs&action=ShowDuplicates_custom&name='.$bean->name.'');
			}
		}
			
	}
	 
}
?>
 

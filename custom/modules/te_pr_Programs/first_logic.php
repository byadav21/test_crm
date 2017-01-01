<?php
class first_logic{
	function first_logic_method(&$bean, $event, $arguments){
		global $db;
			
			/*
		     $qry ="select name from te_pr_programs where (deleted=0) and (id!='".$bean->id."') and (name='".$bean->name."')";
	  
	         $qry2= $db->query($qry);
		     while($row=$db->fetchByAssoc($qry2)){
				
             SugarApplication::redirect('index.php?module=te_pr_Programs&action=ShowDuplicates_custom&name='.$bean->name.'');
			}
			*/
		  if(!empty($_REQUEST['te_in_institutes_te_pr_programs_1_name']))
			{
				if((!$bean->fetched_row)|| ($bean->fetched_row ))
				{
				$quer4="select COUNT(commap.te_in_institutes_te_pr_programs_1te_pr_programs_idb) AS yes from te_in_institutes_te_pr_programs_1_c as commap join te_pr_programs as prog on commap.te_in_institutes_te_pr_programs_1te_pr_programs_idb = prog.id join te_in_institutes as inst on 
						commap.te_in_institutes_te_pr_programs_1te_in_institutes_ida = inst.id where  inst.name='".$bean->te_in_institutes_te_pr_programs_1_name."' and prog.name='".$bean->name."'";	
					
							$qry5= $db->query($quer4);
							$result=$db->fetchByAssoc($qry5);
							if($result['yes']!=0)
							{
							//$this->$bean->te_in_institutes_te_pr_programs_1_name->id;
							SugarApplication::appendErrorMessage('You have been redirected here because ....');    
							SugarApplication::redirect('index.php?module=te_pr_Programs&action=ShowDuplicates_custom&name='.$bean->te_in_institutes_te_pr_programs_1_name.'');
							}			 
					}
					 
			}	
						
	}
	 
}
?>
 

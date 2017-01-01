
<?php
if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');

class listview_program_cetegory {
    function display_program_cetegory(&$bean, $event, $arguments) {
    global $db;
      
     // Total Prohrams 
       
        $Quer1 =$db->query("SELECT COUNT(id) AS totalprog FROM te_program_category_te_pr_programs_c WHERE deleted=0 AND te_program_category_te_pr_programste_program_category_ida='".$bean->id."'");                         
				$result1 =$db->fetchByAssoc($Quer1);
				
				if($result1['totalprog']==0)
				{
				  $bean->programs=$result1['totalprog'];			 
                }
                else
                {
				$bean->programs="<a href='index.php?module=te_Program_category&action=view_cetegory&record=".$bean->id."'>".$result1['totalprog']."</a>";	
				$bean->istitutes_list="<a href='index.php?module=te_Program_category&action=view_cetegory&record=".$bean->id."'>".$result1['totalprog']."</a>";
				}
    
    // @MANISH kUMAR 06-OCT update to 4 nov links 
       
     
		}
 }

              


<?php
if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');

class status_listview {
    function display_list(&$bean, $event, $arguments) {
    global $db;
    $bean->enrolled_students_c="1";

    /*
       // Total Programs
       
        $row1 =$db->query("SELECT COUNT(*) AS Total FROM te_in_institutes_te_pr_programs_1_c WHERE deleted=0 AND 
                          te_in_institutes_te_pr_programs_1te_in_institutes_ida='".$bean->id."'");                         
				$res1 =$db->fetchByAssoc($row1);
				$bean->total_programs_c=$res1['Total'];
			  
       
       
       
       
      */ 
     
		}
 }

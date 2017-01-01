<?php
if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');

class listviewlead {
    function lead_report(&$bean, $event, $arguments) {
    global $db;
    //global $current_user;
    //$Us=$current_user->id;
     
     
     // $bean->report_to_name=
     
     
       // report to display list       
        $row1 =$db->query("SELECT reports_to_id,first_name FROM users WHERE deleted=0 AND id='".$bean->assigned_user_id."'"); 
       // $row1 =$db->query("SELECT reports_to_id,first_name FROM users WHERE deleted=0 AND id='".$current_user->id."'");                         
			   $res1 =$db->fetchByAssoc($row1);			
			   $rid=$res1['reports_to_id'];
				$myUser = new User();
				$myUser->retrieve($rid);
				//echo 
                $bean->report_to_name=$myUser->full_name;
    
		}
 }
// New Update file 18nov $@manish


<?php
if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');

class status_listview {
    function display_list(&$bean, $event, $arguments) {
    global $db;
  //  $bean->enrolled_students_c="1";

    
       // Total Programs
       
        $row1 =$db->query("SELECT COUNT(*)total_enrolled FROM `te_student_batch` WHERE status='active' AND deleted=0 AND te_ba_batch_id_c='".$bean->id."'");                         
				$res1 =$db->fetchByAssoc($row1);
			//$bean->total_programs_c=$res1['Total'];
			  $bean->enrolled_students_c=$res1['total_enrolled'];
       
       
       
       
     
     
		}
 }

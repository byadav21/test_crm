
<?php
if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');

class detail_view {
    function detail_pro_ins(&$bean, $event, $arguments) {
    global $db;
    
       // Display istitute leads
                     
        $row1 =$db->query("select te_in_institutes.name AS institute2 from te_in_institutes left join te_in_institutes_te_ba_batch_1_c on te_in_institutes.id = te_in_institutes_te_ba_batch_1_c. te_in_institutes_te_ba_batch_1te_in_institutes_ida left join te_ba_batch on te_in_institutes_te_ba_batch_1_c.te_in_institutes_te_ba_batch_1te_ba_batch_idb=te_ba_batch.id where te_ba_batch.name ='".$bean->batch_c."'");                         
				$res1 =$db->fetchByAssoc($row1);
				$bean->institute_c=$res1['institute2'];
		        
       // Query for Program display

        $row =$db->query("select te_pr_programs.name from te_pr_programs
                           left join te_pr_programs_te_ba_batch_1_c on te_pr_programs.id = te_pr_programs_te_ba_batch_1_c. te_pr_programs_te_ba_batch_1te_pr_programs_ida
                           left join te_ba_batch on te_pr_programs_te_ba_batch_1_c.te_pr_programs_te_ba_batch_1te_ba_batch_idb=te_ba_batch.id where te_ba_batch.name ='".$bean->batch_c."'"); 
			   $res =$db->fetchByAssoc($row);
			   $bean->program_c=$res['name'];
			   
			   
			   // Batch Attendance 
		$bean->program_c=$res['name'];   
			   $result =$db->query("SELECT minimum_attendance_criteria FROM te_ba_batch WHERE id ='".$bean->te_ba_batch_id_c."'"); 
			   $re1 =$db->fetchByAssoc($result);
			   $bean->min_attendance_c=(int)$re1['minimum_attendance_criteria'];
			   
		}
 }

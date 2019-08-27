
<?php
if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');

class status_listview {
    function display_list(&$bean, $event, $arguments) {
    global $db;
  //  $bean->enrolled_students_c="1";

    
       // Total Programs update 30aprl17 Manish
       
        $row1 =$db->query("SELECT COUNT(*)total_enrolled FROM `te_student_batch` WHERE status='active' AND deleted=0 AND te_ba_batch_id_c='".$bean->id."'");                         
				$res1 =$db->fetchByAssoc($row1);
			//$bean->total_programs_c=$res1['Total'];
			  
       
       
       if($res1['total_enrolled']==0)
				{
				$bean->enrolled_students_c=$res1['total_enrolled'];
				//$res1['Totalbatch'];
				}
				else
				{
				$bean->enrolled_students_c="<a href='index.php?module=te_student_batch&action=index&batch=".$bean->id."'>".$res1['total_enrolled']."</a>";
				//index.php?module=te_pr_Programs&action=statusview&Stw=total&record=
				}  
     
		}
 }

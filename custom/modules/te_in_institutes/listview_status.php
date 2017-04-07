<?php
if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');

class status_listview {
    function display_list(&$bean, $event, $arguments) {
    global $db;
    
       // Total Programs 
       
				$row1 =$db->query("SELECT COUNT(p.id) AS Total FROM te_in_institutes_te_pr_programs_1_c t LEFT JOIN te_pr_programs p ON t.te_in_institutes_te_pr_programs_1te_pr_programs_idb =p.id WHERE p.deleted=0 AND t.deleted=0 AND t.te_in_institutes_te_pr_programs_1te_in_institutes_ida='".$bean->id."'"); 
                          
                         // echo $qt="SELECT COUNT(*) AS Total FROM te_in_institutes_te_pr_programs_1_c WHERE deleted=0 AND 
							//		te_in_institutes_te_pr_programs_1te_in_institutes_ida='".$bean->id."'";
                                                  
				$res1 =$db->fetchByAssoc($row1);
				//$bean->total_programs_c=$res1['Total'];
				
				
				if($res1['Total']==0)
               {
			   $bean->total_programs_c=$res1['Total'];
			   }
			   else
			    {
                $bean->total_programs_c="<a href='index.php?module=te_in_institutes&action=view&record_program=totalprogram&insname=".$bean->name."&record=".$bean->id."'>".$res1['Total']."</a>";
                }  
				
			
       
							// Query for Status for Btach Whos Closed batch
				$row =$db->query("SELECT tbl1.id, COUNT(tbl3.batch_status) AS Total_b FROM te_in_institutes tbl1 INNER JOIN te_in_institutes_te_ba_batch_1_c tbl2 ON tbl1.id = tbl2.te_in_institutes_te_ba_batch_1te_in_institutes_ida 
                          LEFT JOIN te_ba_batch tbl3 ON tbl2.te_in_institutes_te_ba_batch_1te_ba_batch_idb = tbl3.id WHERE tbl3.batch_status= 'closed' 
                          AND tbl1.deleted=0 AND tbl2.deleted=0 AND tbl3.deleted=0 AND tbl1.id='".$bean->id."'"); 
                          
				$res =$db->fetchByAssoc($row);
				if($res['Total_b']==0)
                {
			    $bean->planned_batch_c=$res['Total_b'];
			    }
			    else
			    {
				$bean->planned_batch_c="<a href='index.php?module=te_in_institutes&action=view&insname=".$bean->name."&Stw=closed&record=".$bean->id."'>".$res['Total_b']."</a>";
                }
           
					// Query for Status for Btach Whos 
			   $row3 =$db->query("SELECT tbl1.id, COUNT(tbl3.batch_status) AS Total_c FROM te_in_institutes tbl1 INNER JOIN te_in_institutes_te_ba_batch_1_c tbl2 ON tbl1.id = tbl2.te_in_institutes_te_ba_batch_1te_in_institutes_ida 
						  LEFT JOIN te_ba_batch tbl3 ON tbl2.te_in_institutes_te_ba_batch_1te_ba_batch_idb = tbl3.id WHERE tbl3.batch_status= 'classes_in_progress' 
						  AND tbl1.deleted=0 AND tbl2.deleted=0 AND tbl3.deleted=0 AND tbl1.id='".$bean->id."'"); 
               $res3 =$db->fetchByAssoc($row3);
               if($res3['Total_c']==0)
               {
			   $bean->batch_status_class_c=$res3['Total_c'];
			   }
			   else
			    {
                $bean->batch_status_class_c="<a href='index.php?module=te_in_institutes&action=view&Stw=classes_in_progress&insname=".$bean->name."&record=".$bean->id."'>".$res3['Total_c']."</a>";
                }  
			      
				// Query for Status for Enrollment-in-progress 
				$row4 =$db->query("SELECT tbl1.id, COUNT(tbl3.batch_status) AS Total_d FROM te_in_institutes tbl1 INNER JOIN te_in_institutes_te_ba_batch_1_c tbl2 ON tbl1.id = tbl2.te_in_institutes_te_ba_batch_1te_in_institutes_ida 
						  LEFT JOIN te_ba_batch tbl3 ON tbl2.te_in_institutes_te_ba_batch_1te_ba_batch_idb = tbl3.id WHERE tbl3.batch_status= 'enrollment_in_progress' 
						  AND tbl1.deleted=0 AND tbl2.deleted=0 AND tbl3.deleted=0 AND tbl1.id='".$bean->id."'"); 
				$res4 =$db->fetchByAssoc($row4);
                if($res4['Total_d']==0)
                {
			    $bean->enrollment_in_progress_c=$res4['Total_d'];
			    }
			    else
			    {
                $bean->enrollment_in_progress_c= "<a href='index.php?module=te_in_institutes&action=view&Stw=enrollment_in_progress&insname=".$bean->name."&record=".$bean->id."'>".$res4['Total_d']."</a>";
                }
       
       
     
		}
 }
			// New Update file 3nov @MAnish Gupta manish.outright@gmail.com

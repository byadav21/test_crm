
<?php
if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');

class status_listview_program {
    function display_list_program(&$bean, $event, $arguments) {
    global $db;
    
    
    
     // Total Batch 
       
        $row1 =$db->query("SELECT COUNT(te_pr_programs_te_ba_batch_1te_ba_batch_idb) AS Totalbatch from te_pr_programs_te_ba_batch_1_c where deleted=0 AND te_pr_programs_te_ba_batch_1te_pr_programs_ida='".$bean->id."'");                         
				$res1 =$db->fetchByAssoc($row1);
				$bean->total_p_c=$res1['Totalbatch'];
			  
    
    
    // Query for Closed Batch
       $row2 =$db->query("SELECT tab1.te_pr_programs_te_ba_batch_1te_ba_batch_idb,COUNT(tab2.batch_status) AS Total_cl from te_pr_programs_te_ba_batch_1_c AS tab1 INNER JOIN te_ba_batch AS tab2 ON tab1.te_pr_programs_te_ba_batch_1te_ba_batch_idb = tab2.id WHERE tab2.deleted=0 AND tab2.batch_status= 'closed' AND tab1.te_pr_programs_te_ba_batch_1te_pr_programs_ida='".$bean->id."'"); 
               $res2 =$db->fetchByAssoc($row2);               
              
                if($res2['Total_cl']==0)
                {
			    $bean->closed_batch_c= $res2['Total_cl'];			    }
			    else
			    {
				$bean->closed_batch_c="<a href='index.php?module=te_pr_Programs&action=statusview&Stw=closed&record=".$bean->id."'>".$res2['Total_cl']."</a>";
                }
     
    // Query for Status for Enrollment-in-progress 
        $row3 =$db->query("SELECT tab1.te_pr_programs_te_ba_batch_1te_ba_batch_idb,COUNT(tab2.batch_status) AS Total_ce from te_pr_programs_te_ba_batch_1_c AS tab1 INNER JOIN te_ba_batch AS tab2 ON tab1.te_pr_programs_te_ba_batch_1te_ba_batch_idb = tab2.id WHERE tab2.deleted=0 AND tab2.batch_status= 'enrollment_in_progress' AND tab1.te_pr_programs_te_ba_batch_1te_pr_programs_ida='".$bean->id."'"); 	 	  
                $res3 =$db->fetchByAssoc($row3);
                if($res3['Total_ce']==0)
                {
			    $bean->enrollment_in_progress_c= $res3['Total_ce'];			    }
			    else
			    {
				$bean->enrollment_in_progress_c="<a href='index.php?module=te_pr_Programs&action=statusview&Stw=enrollment_in_progress&record=".$bean->id."'>".$res3['Total_ce']."</a>";
                }
                
               
    
              // Query for Closed Batch classin progress
       $row4 =$db->query("SELECT tab1.te_pr_programs_te_ba_batch_1te_ba_batch_idb,COUNT(tab2.batch_status) AS Total_cc from te_pr_programs_te_ba_batch_1_c AS tab1 INNER JOIN te_ba_batch AS tab2 ON tab1.te_pr_programs_te_ba_batch_1te_ba_batch_idb = tab2.id WHERE tab2.deleted=0 AND tab2.batch_status= 'classes_in_progress' AND tab1.te_pr_programs_te_ba_batch_1te_pr_programs_ida='".$bean->id."'"); 
               $res4 =$db->fetchByAssoc($row4);
                if($res4['Total_cc']==0)
                {
			    $bean->classes_in_progress_c= $res4['Total_cc'];			    }
			    else
			    {
				$bean->classes_in_progress_c="<a href='index.php?module=te_pr_Programs&action=statusview&Stw=classes_in_progress&record=".$bean->id."'>".$res4['Total_cc']."</a>";
                }
               
               $row8 =$db->query("SELECT te_pr_programs_te_ba_batch_1te_ba_batch_idb Totalbatch from te_pr_programs_te_ba_batch_1_c where deleted=0 AND te_pr_programs_te_ba_batch_1te_pr_programs_ida='".$bean->id."'");                                                  
               //echo $td="SELECT te_pr_programs_te_ba_batch_1te_ba_batch_idb Totalbatch from te_pr_programs_te_ba_batch_1_c where deleted=0 AND te_pr_programs_te_ba_batch_1te_pr_programs_ida='".$bean->id."'";                                                  
			   //$res8 =$db->fetchByAssoc($row8);
			   //echo $res1['Totalbatch'];
										
					   if($row8->num_rows>0){
						echo "<style>
						#edit-".$bean->id." {
						display: none;
						}
						.checkbox[value='".$bean->id."'] {
						 display: none;
						}
						</style>";
		  
							}
         
    
    // @MANISH kUMAR 06-OCT update to 4 nov links 
       
     
		}
 }

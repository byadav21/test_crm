
<?php
if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');

class status_listview_program {
    function display_list_program(&$bean, $event, $arguments) {
    global $db;
    
    
  // Total Batch update 3Aprl17 Manish gupta
       
        $row1 =$db->query("SELECT COUNT(te_pr_programs_te_ba_batch_1te_ba_batch_idb) AS Totalbatch from te_pr_programs_te_ba_batch_1_c where deleted=0 AND te_pr_programs_te_ba_batch_1te_pr_programs_ida='".$bean->id."'");                         
       // $amt="SELECT COUNT(te_pr_programs_te_ba_batch_1te_ba_batch_idb) AS Totalbatch from te_pr_programs_te_ba_batch_1_c where deleted=0 AND te_pr_programs_te_ba_batch_1te_pr_programs_ida='".$bean->id."'";                         
				$res1 =$db->fetchByAssoc($row1);
				
				if($res1['Totalbatch']==0)
				{
				$bean->total_p_c=$res1['Totalbatch'];
				//$res1['Totalbatch'];
				}
				else
				{
				$bean->total_p_c="<a href='index.php?module=te_pr_Programs&action=statusview&total=".$bean->name."&&record=".$bean->id."'>".$res1['Totalbatch']."</a>";
				//index.php?module=te_pr_Programs&action=statusview&Stw=total&record=
					
				}
			  
    
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
               
               
         
    
    // @MANISH kUMAR 06-OCT update to 4 nov links 
       
     
		}
 }

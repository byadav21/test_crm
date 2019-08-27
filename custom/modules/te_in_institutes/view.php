<?php

    if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
     global $db;
 
    if((isset($_REQUEST['record'])) && (isset($_REQUEST['Stw'])))
    {
	     $am=$_REQUEST['record'];
	     $SW=$_REQUEST['Stw'];
	// Query For te_in_institutes_te_ba_batch_1_c
	
                       $row =$db->query(" SELECT te_in_institutes_te_ba_batch_1te_ba_batch_idb FROM `te_in_institutes_te_ba_batch_1_c` WHERE deleted=0 AND te_in_institutes_te_ba_batch_1te_in_institutes_ida ='".$am."'");
                            // echo $QT="SELECT te_in_institutes_te_ba_batch_1te_ba_batch_idb FROM `te_in_institutes_te_ba_batch_1_c` WHERE deleted=0 AND te_in_institutes_te_ba_batch_1te_in_institutes_ida ='".$am."'";
                                while($res =$db->fetchByAssoc($row)){		 
					                  $TeId[]=$res['te_in_institutes_te_ba_batch_1te_ba_batch_idb'];   			             
		}
		                //  print_r( $TeId);
?>
 <html>
    <title>Status</title>
  <head>
    <style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}
td, th {
    border: 1px solid #b1c0ed;
    text-align: left;
    padding: 9px;
}
tr:nth-child(even) {
    background-color: #f0efee;
}
</style>
<h1><b> BATCH STATUS-<?php echo strtoupper($_REQUEST['insname']); ?></b></h1><br/><br/>
<?php

 	 echo '<table>';
		 echo ' <tr>
                <th>Batch Name</th>
                <th>Batch Status</th>
                <th>Program Name</th>   
                </tr>';
			//http://localhost:8080/18oct_crm/index.php?action=ajaxui#ajaxUILoc=index.php%3Fmodule%3Dte_ba_Batch%26action%3DDetailView%26record%3D83b0ad2a-01f6-6ebb-e2d5-57da059e115c 
				   
	  foreach($TeId as $Val)
		                    {
	
							//echo $PR="SELECT name,batch_status,date_modified FROM `te_ba_batch` WHERE batch_status='".$SW."' AND id='".$Val."'";
		                      $row1 =$db->query("SELECT id,name,batch_status,date_modified FROM `te_ba_batch` WHERE deleted=0 AND batch_status='".$SW."' AND id='".$Val."'");
		                      while($res1 =$db->fetchByAssoc($row1))		                      
		                    {	
								  $text = str_replace("_",' ',$res1['batch_status']);
								  
							  $row10 =$db->query("SELECT te_pr_programs.id,
							  te_pr_programs_te_ba_batch_1_c.te_pr_programs_te_ba_batch_1te_pr_programs_ida,
							  te_pr_programs.name
								FROM
							  te_pr_programs_te_ba_batch_1_c AS te_pr_programs_te_ba_batch_1_c
								RIGHT JOIN
							  te_pr_programs AS te_pr_programs
								ON
							  te_pr_programs_te_ba_batch_1_c.te_pr_programs_te_ba_batch_1te_pr_programs_ida = te_pr_programs.id WHERE te_pr_programs_te_ba_batch_1_c.te_pr_programs_te_ba_batch_1te_ba_batch_idb ='".$res1['id']."'");	
						      $res3 =$db->fetchByAssoc($row10);
						      $Id=$res3['id'];			 	 										
			?>
     <tr> 					 
     <td><?php echo "<a href=index.php?action=ajaxui#ajaxUILoc=index.php%3Fmodule%3Dte_ba_Batch%26action%3DDetailView%26record%3D$Val >"?> <?php echo str_replace("_",' ',$res1['name']);"</a>"?></td>
     <td> <?php echo ucwords("$text")?> </td>
     <td> <?php echo "<a href=index.php?action=ajaxui#ajaxUILoc=index.php%3Fmodule%3Dte_pr_Programs%26action%3DDetailView%26record%3D$Id>"?><?php echo $res3['name'];"</a>"?>  </td>
   
    <?php 	}}?>
		                          
    </tr>
  
	<?php

	echo '</table>';
		  
}
 if((isset($_REQUEST['record'])) && (isset($_REQUEST['record_program'])))
    {
		
	$as=$_REQUEST['record'];
	$program_id=$_REQUEST['record_program'];
		
	?>	
		 <html>
    <title>Status</title>
  <head>
    <style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}
td, th {
    border: 1px solid #b1c0ed;
    text-align: left;
    padding: 9px;
}
tr:nth-child(even) {
    background-color: #f0efee;
}
</style>
<h1><b>PROGRAMS FOR-<?php echo strtoupper($_REQUEST['insname']); ?></b></h1><br/><br/> 
<?php

 	 echo '<table>';
		 echo ' <tr>
                <th>Program Name</th> 
                </tr>';
                
          
		$row6 =$db->query("SELECT p.name,p.id AS Total FROM te_in_institutes_te_pr_programs_1_c t LEFT JOIN te_pr_programs p ON t.te_in_institutes_te_pr_programs_1te_pr_programs_idb =p.id WHERE p.deleted=0 AND t.deleted=0 AND t.te_in_institutes_te_pr_programs_1te_in_institutes_ida='".$as."'");              
        while($res6 =$db->fetchByAssoc($row6))		                      
		                  {
							 ?>
	<tr> 					 
     <td><?php echo"<a href= index.php?action=ajaxui#ajaxUILoc=index.php%3Fmodule%3Dte_pr_Programs%26offset%3D1%26return_module%3Dte_pr_Programs%26action%3DDetailView%26record%3D".$res6['Total'].">"?><?php echo $res6['name'];"</a>"?></td>
	<?php }	?>          
   </tr>          
        <?php        
		echo '</table>';
			
	}
  //New updated file for links @manish 3Nov
	?>

<!DOCTYPE html>
<html>
<head>
<title>Status for Programs</title>
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
</head>
<body>
<?php

    if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
    global $db;
    if((isset($_REQUEST['record'])) && (isset($_REQUEST['Stw'])))
    {
	     $am=$_REQUEST['record'];
	     $SW=$_REQUEST['Stw'];
	   
	    //echo $row ="SELECT * FROM te_pr_programs_te_ba_batch_1_c WHERE te_pr_programs_te_ba_batch_1te_pr_programs_ida='".$am."'";
        $row =$db->query("SELECT te_pr_programs_te_ba_batch_1te_ba_batch_idb FROM te_pr_programs_te_ba_batch_1_c WHERE te_pr_programs_te_ba_batch_1te_pr_programs_ida='".$am."'");
        // echo $QT="SELECT * FROM `te_in_institutes_te_ba_batch_1_c` WHERE te_in_institutes_te_ba_batch_1te_in_institutes_ida ='".$am."'";
                                $TeId='';
                                while($res =$db->fetchByAssoc($row)){		 
					                  $TeId[]=$res['te_pr_programs_te_ba_batch_1te_ba_batch_idb'];   
					             }
		  // Display Program Name
				$row6 =$db->query("SELECT name FROM te_pr_programs WHERE deleted='0' AND id ='".$am."'");
                $res6 =$db->fetchByAssoc($row6);
	      //print_r( $TeId);		                
?> 
<h1><b>PROGRAM STATUS OF- <?php echo strtoupper($res6['name'])?></b></h1></br> 
<?php				               
 	 echo '<table>';
		 echo ' <tr>
                <th>Batch Name</th>
                <th>Batch Status</th>
                <th>Last Modified date</th>   
                </tr>';
				//http://localhost:8080/18oct_crm/index.php?action=ajaxui#ajaxUILoc=index.php%3Fmodule%3Dte_ba_Batch%26action%3DDetailView%26record%3D83b0ad2a-01f6-6ebb-e2d5-57da059e115c 
				//index.php?action=ajaxui#ajaxUILoc=index.php%3Fmodule%3Dte_ba_Batch%26action%3DDetailView%26record%3D226b2ef1-ac5d-0802-0e0c-580f37fd1240   
	 foreach($TeId as $Val)
		                    {
							
		                     $row1 =$db->query("SELECT name,batch_status,date_modified FROM te_ba_batch WHERE batch_status ='".$SW."' AND deleted='0' AND id='".$Val."'");
		                     // $row1 =$db->query("SELECT name,batch_status,date_modified FROM `te_ba_batch` WHERE batch_status='".$SW."' AND id='".$Val."'");
		                      while($res1 =$db->fetchByAssoc($row1))		                      
		                      {	
						     $text = str_replace("_",' ',$res1['batch_status']);?>
     <tr> 					 
     <td> <?php echo "<a href=index.php?action=ajaxui#ajaxUILoc=index.php%3Fmodule%3Dte_ba_Batch%26action%3DDetailView%26record%3D$Val" ?>> <?php echo str_replace("_",' ',$res1['name']);"</a>"?></td>
     <td> <?php echo ucwords("$text")?> </td>
     <td> <?php echo $res1['date_modified'];?> </td>
   
    <?php 	}
		                 
		                 }?>
    </tr>
     
	<?php

	echo '</table>'; 
		  
}
if((isset($_REQUEST['record'])) && (isset($_REQUEST['total'])))
    {
?>
<h1><b>BATCH FOR PROGRAMS-<?php echo strtoupper($_REQUEST['total']) ?></b></h1></br> 
	<?php	
	
	     $am=$_REQUEST['record'];
	     $SW=$_REQUEST['total'];
	     $row =$db->query("SELECT te_pr_programs_te_ba_batch_1te_ba_batch_idb FROM te_pr_programs_te_ba_batch_1_c WHERE te_pr_programs_te_ba_batch_1te_pr_programs_ida='".$am."'");
       
                                $TeId='';
                                while($res =$db->fetchByAssoc($row)){		 
					                  $TeId[]=$res['te_pr_programs_te_ba_batch_1te_ba_batch_idb'];   
					             }
					        
	echo '<table>';
		 echo ' <tr>
                <th>Batch Name</th>
                <th>Batch Status</th>
                <th>Last Modified date</th>   
                </tr>';
					        
					  
					         foreach($TeId as $Val)
		                    {
					             
					            $row6 =$db->query("SELECT name,batch_status,date_modified FROM te_ba_batch WHERE id='".$Val."' AND deleted='0'");
								  while($res6 =$db->fetchByAssoc($row6))		                      
		                      {	
								  
						   	  $text = str_replace("_",' ',$res6['batch_status']);										
			?>
     <tr> 					 
     <td> <?php echo "<a href=index.php?action=ajaxui#ajaxUILoc=index.php%3Fmodule%3Dte_ba_Batch%26action%3DDetailView%26record%3D$Val" ?>> <?php echo str_replace("_",' ',$res6['name']);"</a>"?></td>
     <td> <?php echo ucwords("$text")?> </td>
     <td> <?php echo $res6['date_modified'];?> </td>
   
    <?php 	}
		                 
		                 }
	   echo  '</tr>'.'</table>';   
	 }
//@Manish 2nov
	?>
	</body>
</html>

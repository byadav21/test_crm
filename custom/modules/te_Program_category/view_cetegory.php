<?php
    if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
    global $db;
    if((isset($_REQUEST['record'])))
    {
		
		$am=$_REQUEST['record'];   
        $row =$db->query("SELECT te_program_category_te_pr_programste_pr_programs_idb FROM te_program_category_te_pr_programs_c WHERE deleted=0 AND te_program_category_te_pr_programste_program_category_ida='".$am."'");
                                $TId='';
                                while($res =$db->fetchByAssoc($row)){
	                            $TId[]=$res['te_program_category_te_pr_programste_pr_programs_idb'];
					               
					             }					            
?>							 
<html>
    <title>Program category </title>
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
<h3><b>Program Category</b></h3></br> 
<?php				               
 	 echo '<table>';
		 echo ' <tr>
                <th>Program Name</th>
                <th> Institute Name</th> 
                </tr>';
	 
	   foreach($TId as $Val)
		                    {
							   
		                    $row1 =$db->query("SELECT name,id FROM te_pr_programs WHERE deleted=0 AND id='".$Val."'");
		                                while($res1 =$db->fetchByAssoc($row1))		                      
		                     {	
						       $text = str_replace("_",' ',$res1['name']);
						       $idp=$res1['id'];?>
     <tr> 					 
     <td> <?php echo " <a href=index.php?action=ajaxui#ajaxUILoc=index.php%3Fmodule%3Dte_pr_Programs%26action%3DDetailView%26record%3D$idp"?>> <?php echo str_replace("_",' ',$res1['name']);"</a>"?></td><?php }
     $row5 =$db->query("SELECT tbl1.name,tbl1.id FROM te_in_institutes tbl1 INNER JOIN te_in_institutes_te_pr_programs_1_c tbl2 on tbl1.id=tbl2.te_in_institutes_te_pr_programs_1te_in_institutes_ida where tbl1.deleted=0 AND tbl2.deleted=0 AND tbl2.te_in_institutes_te_pr_programs_1te_pr_programs_idb='".$Val."'");
		               while($res5 =$db->fetchByAssoc($row5))            
															{
						 $iId=$res5['id'];  ?>							 
   <td> <?php echo "<a href=index.php?action=ajaxui#ajaxUILoc=index.php%3Fmodule%3Dte_in_institutes%26action%3DDetailView%26record%3D$iId"?>> <?php echo str_replace("_",' ',$res5['name']);"</a>"?></td>	  
		 	<?php }}?>
    </tr>
	<?php
	echo '</table>'; 		  
}
//@Manish 10nov
	?>
 


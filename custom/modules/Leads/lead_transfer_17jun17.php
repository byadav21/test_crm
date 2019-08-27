<?php
ini_set('display_errors','0');
error_reporting(E_ALL);
global $db; 
?>
<html>
    <title>Bulk Lead transfer</title>
  <head>
    <style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}
td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}
tr:nth-child(even) {
    background-color: #dddddd;
}
input[type=text], select {
    WIDTH: 172PX !IMPORTANT;
}
</style>
         <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
           <link rel="stylesheet" href="/resources/demos/style.css">
            <script>
              $(function() {
                $("#datepicker").datepicker({ dateFormat: "yy-mm-dd" }).val()
                } );
                $(function() {
                $("#enddate").datepicker({ dateFormat: "yy-mm-dd" }).val()
                } );
            </script> 
     <script type="text/javascript">
							$( document ).ready(function() {
								$( "#Lead_source,#Lead_status").find("option").eq(0).remove();
							});
							$(function () {
								$('#Lead_source,#Lead_status').multiselect({
									includeSelectAllOption: true,numberDisplayed:0
								});
							});
</script>       
            
    </head>
        <body>
             <section class="moduleTitle">
                <fieldset>
                    <form action="index.php?module=Leads&action=lead_transfer&search_leads=1" method="post" id="lead_trans">
                      <h2>Search Leads</h2><br/><br/>
                      
                      <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr style="background-color:#fff;">
    <td><table width="92%" border="0" cellpadding="0" cellspacing="0">
  <tr>
   <td><b>Start Date</b></td>
    <td><input type="text" name="start_date" id="datepicker"/></td>
     <td><b>End Date</b></td>
     <td><input type="text" name="end_date" id="enddate"/></td>
  </tr>
  <tr>
  <td><b>Lead Source</b></td>
     <td><select name="Lead_source[]" multiple id="Lead_source">
                                  <option  value="Campaign">Campaign</option>
								  <option  value="Web Site">Web Site</option>	
								  <option  value="Converted">Chat</option>
								  <option  value="InboundCalls">Inbound Calls</option>
								  <option  value="Referrals">Referrals</option>
								  <option  value="Chat">Chat</option>
								  <option  value="Inbound Calls">InboundCalls</option>
								  <option  value="Email Enquiries">Email Enquiries</option>
								  <option  value="Channel">Channel</option>
								  <option  value="Email Enquiries">Email Enquiries</option>
								  <option  value="ABND">ABND</option>
								  <option  value="Fail Payment">Fail Payment</option>
								  <option value="Crosssell">Cross sell</option> 
								  </select></td>
    
      
        <td><b>Lead Status</b></td>
    <td><select name="Lead_status[]" multiple id="Lead_status">
									<option  value="Converted">Converted</option>
									<option  value="Alive">Alive</option>
									<option  value="New">New</option>
									<option  value="Dead">Dead</option>
									<option  value="Duplicate">Duplicate</option>  
									<option  value="Dropout">Dropout</option>
									<option  value="Warm">Warm</option>
									</select></td>
  </tr>
  <tr>
  <td><b>Number Of Leads</b></td>
  <td><input type="text" name="number_lead" id="no_lead"/></td>
                                	<td>  <input type="Submit" name="Search" value="Search Lead"></td>
  </tr>
</table>
</td>
  </tr>
</table>

                         
                    </fieldset>
            </section>
            <br/>
</form>
<?php
if(isset($_POST['Search'])) {
		extract($_POST);
		$where="";
		

		if(!empty($start_date)&&!empty($end_date)){
		$where.=" (CAST(date_entered AS DATE) BETWEEN '".$start_date."' AND '".$end_date."')";
		}
		if(!empty($start_date)&&empty($end_date)){
		if($where!=''){
		$where.=" AND (CAST(date_entered AS DATE) > '".$start_date."')";
		}
		else{
		$where.=" (CAST(date_entered AS DATE) > '".$start_date."')";
		}
		}
		if(empty($start_date)&&!empty($end_date)){
		if($where!=''){
		$where.=" AND (CAST(date_entered AS DATE) < '".$end_date."')";
		}
		else{
		$where.=" (CAST(date_entered AS DATE) < '".$end_date."')";
		}
		}
		if(!empty($Lead_status)){
		$status_str=implode("','",$Lead_status);
		$status_str="'".$status_str."'";
		if($where!=''){
		$where.=" AND (status in (".$status_str."))";
		}
		else{
		$where.=" (status in (".$status_str."))";
		}
		}
		if(!empty($Lead_source)){
		$source_str=implode("','",$Lead_source);
		$source_str="'".$source_str."'";
		if($where!=''){
		$where.=" AND (lead_source in (".$source_str."))";
		}
		else{
		$where.=" (lead_source in (".$source_str."))";
		}
		}
		if(!empty($number_lead)){
		if($where!=''){
		$where.=" AND (deleted=0) LIMIT 0,".$number_lead."";
		}
		else{
		$where.=" (deleted=0) LIMIT 0,".$number_lead."";
		}
		
		}
		if (strpos($where, 'deleted') == false&&$where!='') {
		$where.=" and deleted=0 limit 0,100";
		}
		
			
		 $fetch="SELECT id,salutation,first_name,last_name,status,date_entered,lead_source FROM leads WHERE ".$where;
		// echo $fetch;
		 //$fetch= "SELECT salutation,id,first_name, last_name, status, date_entered, lead_source FROM leads WHERE date_entered BETWEEN '".$start_date."' AND '".$end_date."' AND status='".$Lead_tatus."'  LIMIT 0,".$number_lead."";
		 //$row =$db->query($fetch); 
		 $row = $db->query($fetch);
					
if($row->num_rows>0){
		
		 $lead_ids='';
		 while($records =$db->fetchByAssoc($row))
            {
			$lead_ids[]=$records['id'];
			$records_arr[]=$records;
			}
		
				    }
                       else
	                {	
		  echo '<script>';
		  echo "alert('Search Leads Not Found')";  
		  echo '</script>'; 
		  exit;
					}
       
	        
			$_SESSION['records_fetch']=$records_arr;
            $_SESSION['leds_id']=$lead_ids;
			
			}
        //  $lead_ids = implode("__",$lead_ids);
	  
 if(isset($_REQUEST['search_leads'])&& $_REQUEST['search_leads']==1){
	  	 echo '<table>';
		 echo ' <tr>
                <th>Name</th>
                <th>Status</th>
                <th>Date Entered</th>
                <th>Lead Source</th>    
                </tr>';
			  
		foreach($_SESSION['records_fetch'] as $key=>$value){
			?>

           <tr>
	<?php $_SESSION['records_fetch'][$key]['id'];?>
    <td><?php echo $_SESSION['records_fetch'][$key]['salutation'].$_SESSION['records_fetch'][$key]['first_name'].'&nbsp;'.$_SESSION['records_fetch'][$key]['last_name']; ?></td>
    <td><?php echo $_SESSION['records_fetch'][$key]['status'];?></td>
    <td><?php echo $_SESSION['records_fetch'][$key]['date_entered'];?></td>
    <td><?php echo $_SESSION['records_fetch'][$key]['lead_source'];?></td>
	</tr>
    <?php 
	}
	
	echo '</table>';   
if(isset($_REQUEST['transfer_leads'])&&$_REQUEST['transfer_leads']==1){
 
  //form submit of checkbox
   if(isset($_REQUEST['transfer'])){
	   extract($_POST);
	   $ledt=$_SESSION['leds_id'];
	    //$leadArr=explode("__",$_POST['lead_i']);
		 $num_users=sizeof($_REQUEST['check_list']);
		 $num_leads=COUNT($_SESSION['leds_id']);
		 if($num_users>$num_leads){
		  echo '<script>';
		  echo "alert('Number of Users Should be less than number of leads')";  
		  echo '</script>';  
        }
          else{
						$tot_User=count($_POST['check_list']);
						$user_list=$_POST['check_list'];
						$_SESSION['user_listsession']=$user_list;
	                    $update_Arr[]='';
						$sesV=$_SESSION['user_listsession'];

						if($tot_User > $num_leads)
					     {
						 
						    for($i=0;$i < $num_leads;$i++)
						  	{
							 // $update_Arr[]=array("$leads_ID"=>$leadArr[$i],"$User_ID"=>$user_list[$i]);
						     $fetch3="update leads SET assigned_user_id='".$user_list[$i]."'where id='".$ledt[$i]."'";
                               
                              $row3 =$db->query($fetch3);
							   
							           // echo '<pre>';
							            //print_r($update_Arr);
							            //echo '</pre>'; 
						     }
			 
				          }
						 if($num_leads==$tot_User){

						  $i=0;
						 foreach($ledt as $leadval)
							{
						       $fetch3="update leads SET assigned_user_id='".$_POST['check_list'][$i]."'where id='$leadval'";
							   $row3 =$db->query($fetch3);
							    
								$i++;
								
							}
								echo "<font color='green'>Transfer..Success</font>";
											}
	//if ($row3) {
    //echo "<script type='text/javascript'>alert('submitted successfully!')</script>";
//}
							else
							
					 { // else start
						 
								 
								   $leads = $_SESSION['leds_id'];
								   $users = $_POST['check_list'];
								
								   $max = count($leads);
								   
									// FOR COUNT LEADS & USER	   
									 echo '<h3>'.'<b>'.'Selected User'.'&nbsp';
									 print_r ($max1 = count($users));
									 echo 'and Leads ';
									 print_r($max = count($leads));
									 
									 echo "<font color='green'>Transfer..Success</font>";
									 echo '</h3>'.'</b>';
									// END	   
											   
								 
									$each = round($max/count($users));
									$arrays = array_chunk($leads, $each);
								
									//echo $each;
									//echo count($arrays);
								//	echo "<pre>";
									//print_r($arrays);
									$j=0;
									$newArr=array();
									for($i=0;$i<count($arrays);$i++){
									if($j==count($users)){
									$j = 0;
										}
										    foreach($arrays[$i] as $val){
											$newArr[]=array('lead_id'=>$val,'user_id'=>$users[$j]);
											
										    $fetch4="update leads SET assigned_user_id='".$users[$j]."'where id='".$val."'";
			                				$row4 =$db->query($fetch4);
			                				
											
			                				
										}
										
										$j++;
										
										
									}
								//print_r($newArr);
							 
									//Loop to query newAr				 
								 
					} // else close
					 
  //code for ech

}
			
	 }
  }
  ?>
  <?php
  echo '<form action="index.php?module=Leads&action=lead_transfer&search_leads=1&transfer_leads=1" name="transfer" method="post" id="trnsfer">';
	echo '<br/><br/><h1>Transfer Leads</h1><br/>';
	  $fetch1="SELECT name,id FROM acl_roles where deleted=0";
      $row1 =$db->query($fetch1); ?>
    
			   <tr>
			   <td><b>User Type</b></td>
			   <td><select name="user" id="user_type" onChange="this.form.submit()">
			     <option >Select User</option>
	
					<?php while($records1 =$db->fetchByAssoc($row1))
							{ 
						$id=$records1['id']; ?>
 
				<option  value="<?php echo $id ?>"><?php echo $records1['name'];?></option>
						<?php } ?>

				</select>
				  </td></tr></table><br><br>
				  <h1>Select Users</h1>
				<?php $fetch2 = "SELECT acl_roles.id, acl_roles_users.user_id, users.id, users.user_name FROM acl_roles JOIN acl_roles_users ON acl_roles.id = acl_roles_users.role_id JOIN users ON  acl_roles_users.user_id = users.id WHERE acl_roles.id = '".$_REQUEST['user']."' ";

                      $row2 =$db->query($fetch2); 

                while($records2 =$db->fetchByAssoc($row2))
					{ 	 	 
					  ?>
					  <input type="checkbox" name='check_list[]' value="<?php echo $records2['id']?>" ><?php echo $records2['user_name']?> <br>
			  <?php } ?>
					  <input type="hidden" name="lead_i" value="<?php echo $lead_ids; ?>">
					  <div colspan="2" align="center">
					  <input type="submit" name="transfer" value="Transfer" id="transfer">
  
			   </div>
             </form>
  </body>
       </html>
<?php
}

?>

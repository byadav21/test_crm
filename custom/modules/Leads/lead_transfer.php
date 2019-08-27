<?php
ini_set('display_errors','1');
//error_reporting(E_ALL);
require_once('custom/modules/Leads/customfunctionforcrm.php');
require_once('modules/ACL/ACLController.php');
 
global $db,$current_user,$mod_strings, $app_strings;
$vendorArr='';$mediumArr='';
$customfunctionforcrmObj = new customfunctionforcrm();
$customfunctionforcrmObj->reportingUser($current_user->id);
$current_userData[$current_user->id]=$current_user->name;
if($customfunctionforcrmObj->report_to_id_transfer && $current_userData){
  $counsellorArr = array_merge($current_userData,$customfunctionforcrmObj->report_to_id_transfer);
}
else{
  $counsellorArr = $current_userData;
}

//echo "<pre>";print_r($customfunctionforcrmObj->report_to_id_transfer);
/*$userObj = new User();
$userObj->disable_row_level_security = true;
$userList = $userObj->get_full_list("", "users.reports_to_id='".$current_user->id."'");*/

function getBatch(){
  global $db;
  $batchSql="SELECT id,name from te_ba_batch WHERE deleted=0 ";
  $batchObj =$db->query($batchSql);
  $batchOptions=array();
  while($row =$db->fetchByAssoc($batchObj)){
    $batchOptions[]=$row;
  }
  return $batchOptions;
}
function getUtmByContractIDs($vAndCtVendorArr,$vAndCtArr){
  global $db;
  $batchSql="SELECT u.name from te_utm AS u INNER JOIN te_vendor_te_utm_1_c AS uv on uv.te_vendor_te_utm_1te_utm_idb=u.id WHERE u.deleted=0 AND uv.te_vendor_te_utm_1te_vendor_ida IN('".implode("','",$vAndCtVendorArr)."') AND u.contract_type IN('".implode("','",$vAndCtArr)."')";
  $batchObj =$db->query($batchSql);
  $batchOptions=array();
  while($row =$db->fetchByAssoc($batchObj)){
    $batchOptions[]=$row['name'];
  }
  return $batchOptions;
}
?>
 
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
								$('#Lead_source,#Lead_status,#status_details,#counsellor').multiselect({
									selectAll: true,includeSelectAllOption: true,numberDisplayed:0
								});
							});	</script>
  
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
      <td><b>Batch</b></td>
      <?php
        $batches = getBatch();
      ?>
			<td>
        <select name="batch[]" multiple id="Lead_status">
					<?php if($batches){?>
            <?php foreach ($batches as $key => $value) {?>
              <option value="<?php echo $value['id'];?>"><?php echo $value['name'];?></option>
            <?php }?>
          <?php }?>
				</select>
      </td>
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
    <td>
		
			<select name="Lead_status[]" multiple id="Lead_status">		 
				<option label="Alive" value="Alive" >Alive</option>
				<option label="Converted" value="Converted">Converted</option>
				<option label="Dead" value="Dead">Dead</option>
				<option label="Duplicate" value="Duplicate">Duplicate</option>
				<option label="Dropout" value="Dropout">Dropout</option>
				<option label="Warm" value="Warm">Warm</option>
				<option label="Recycle" value="Recycle">Recycle</option>
			</select>
		</td>
	<td><b>Counsellor</b></td>

							<td><select name="counsellor[]" multiple id="counsellor">
							 
								<?php
                  if($counsellorArr){
                  foreach($counsellorArr as $key=>$counsellorval){?>
									<option  value=<?php echo $key; ?> ><?php echo $counsellorval; ?></option>
									<?php }}?>
									</select></td>
  </tr>
  <td><b>Status Details</b></td>
    <td>
		<select name="status_details[]" multiple id="status_details">

			 <option value="Call Back">Call Back</option><option value="Follow Up">Follow Up</option><option value="New Lead" selected="selected">New Lead</option></select>
		
		
		 </td>
		<?php
		$acl_obj = new ACLController();
		if($current_user->is_admin==1){ ?>
			<td><b>Vendors</b></td>
			<td><select name="vendors" id="vendors">
				<option value="">--Select Vendor--</option>
				 <?php
				 $fetch_vendor="SELECT name,id FROM te_vendor where deleted=0 GROUP by name";
				 $row4 =$db->query($fetch_vendor);
				 while($result_vendor =$db->fetchByAssoc($row4)){$vendorArr[$result_vendor['id']]=$result_vendor['name'];?>
							<option  value="<?php echo $result_vendor['id']; ?>"><?php echo $result_vendor['name']; ?></option>
							<?php }?>
									</select></td>
				<td><b>Medium</b></td>
					 <td><select name="medium_val[]" multiple id="medium_val"></select></td>
				 </tr>
				 <?php } ?>
					<tr>
					  <td><b>Number Of Leads</b></td>
					  <td><input type="text" name="number_lead" id="no_lead"/></td>
					<!--  <td><input type="checkbox" name="notAssigned" id="no_assigned"/> Not Assigned</td> -->
					   <td><input type="Submit" name="Search" value="Search Lead"></td>
				</tr>
			</table>
					</table>
                    </fieldset>
            </section>
            <br/>
</form>

<?php

 
    if(isset($_POST['Search'])) {
		
			unset($_SESSION['leds_id']);
			unset($_SESSION['records_fetch']);
		
    		extract($_POST);
    		$where="";
    		if(!empty($start_date)&&!empty($end_date)){
    		$where.=" (CAST(l.date_entered AS DATE) BETWEEN '".$start_date."' AND '".$end_date."')";
		}
		if(!empty($start_date)&&empty($end_date)){
  		if($where!=''){
  		$where.=" AND (CAST(l.date_entered AS DATE) > '".$start_date."')";
  		}
  		else{
  		$where.=" (CAST(l.date_entered AS DATE) > '".$start_date."')";
  		}
		}
		if(empty($start_date)&&!empty($end_date)){
  		if($where!=''){
  		$where.=" AND (CAST(l.date_entered AS DATE) < '".$end_date."')";
  		}
  		else{
  		$where.=" (CAST(l.date_entered AS DATE) < '".$end_date."')";
  		}
		}
    if(!empty($batch)){
      $batch_str=implode("','",$batch);
  		$batch_str="'".$batch_str."'";
  		if($where!=''){
  		$where.=" AND (lc.te_ba_batch_id_c in (".$batch_str."))";
  		}
  		else{
  		$where.=" (lc.te_ba_batch_id_c in (".$batch_str."))";
  		}
		}
		if(!empty($Lead_status)){
  		$status_str=implode("','",$Lead_status);
  		$status_str="'".$status_str."'";
  		if($where!=''){
  		$where.=" AND (l.status in (".$status_str."))";
  		}
  		else{
  		$where.=" (l.status in (".$status_str."))";
  		}
		}
		if(!empty($counsellor)){
  		$counsellor_str=implode("','",$counsellor);
  		$counsellor_str="'".$counsellor_str."'";
  		if($where!=''){
  		$where.=" AND (l.assigned_user_id in (".$counsellor_str."))";
  		}
  		else{
  		$where.=" (l.assigned_user_id in (".$counsellor_str."))";
  		}
		}

    if(empty($counsellor) && !empty($counsellorArr)){
		$counsellorArr_str=array_keys($counsellorArr);
    $counsellorArr_str=implode("','",$counsellorArr_str);
		$counsellorArr_str="'".$counsellorArr_str."'";
  		if($where!=''){
  		$where.=" AND (l.assigned_user_id in (".$counsellorArr_str."))";
  		}
  		else{
  		$where.=" (l.assigned_user_id in (".$counsellorArr_str."))";
  		}
		}


    if(empty($medium_val) && trim($vendors) && $vendorArr){
  		if($where!=''){
  		$where.=" AND (l.vendor in ('".$vendorArr[$vendors]."'))";
  		}
  		else{
  		$where.=" (l.vendor in ('".$vendorArr[$vendors]."'))";
  		}
		}
    if(!empty($medium_val)){
      $vAndCtVendorArr=[];
      $vAndCtArr=[];
      foreach($medium_val as $val){
        $valVandCT = explode('_TE_',$val);
        if(count($valVandCT)>1){
          $vAndCtVendorArr[]=$valVandCT[0];
          $vAndCtArr[]=$valVandCT[1];
        }
      }
      $utm_names=getUtmByContractIDs($vAndCtVendorArr,$vAndCtArr);
      if($utm_names){
        $where.=" AND l.utm IN('".implode("','",$utm_names)."') ";
      }
      /*$medium_str=implode("','",$medium_val);
  		$medium_str="'".$medium_str."'";
      $fetch_utm="SELECT GROUP_CONCAT(`name`)utm FROM `te_utm` WHERE `aos_contracts_id_c` IN ($medium_str) AND deleted=0";
      $rowmedium =$db->query($fetch_utm);
      $result_utm =$db->fetchByAssoc($rowmedium);
      if(isset($result_utm['utm']) && !empty($result_utm['utm'])){
        $utmArr= explode(',',$result_utm['utm']);
        $utm_str=implode("','",$utmArr);
    		$utm_str="'".$utm_str."'";
        if($where!=''){
    		    $where.=" AND (l.utm in (".$utm_str."))";
    		}
    		else{
    		    $where.=" (l.utm in (".$utm_str."))";
    		}
      }*/

		}

		if(!empty($status_details)){
  		$status_details_str=implode("','",$status_details);
  		$status_details_str="'".$status_details_str."'";
  		if($where!=''){
  		$where.=" AND (l.status_description in (".$status_details_str."))";
  		}
  		else{
  		$where.=" (l.status_description in (".$status_details_str."))";
  		}
		}

		if(!empty($Lead_source)){
		$source_str=implode("','",$Lead_source);
		$source_str="'".$source_str."'";
  		if($where!=''){
  		$where.=" AND (l.lead_source in (".$source_str."))";
  		}
  		else{
  		$where.=" (l.lead_source in (".$source_str."))";
  		}
		}

		if(!empty($number_lead)){
  		if($where!=''){
  		$where.=" AND (l.deleted=0) LIMIT 0,".$number_lead."";
  		}
  		else{
  		$where.=" (l.deleted=0) LIMIT 0,".$number_lead."";
  		}
		}
		if(strpos($where, 'deleted') == false && $where!='') {
		    $where.=" and l.deleted=0 limit 0,100";
		}
    //echo $where;exit();
		$fetch="SELECT l.id,l.salutation,l.first_name,l.last_name,l.status,l.date_entered,l.lead_source FROM leads AS l INNER JOIN leads_cstm AS lc on l.id=lc.id_c WHERE ".$where;
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
		  //exit;
}
	$_SESSION['records_fetch']=$records_arr;
      $_SESSION['leds_id']=$lead_ids;

}
 
        //  $lead_ids = implode("__",$lead_ids);
 if(isset($_REQUEST['search_leads']) && $_REQUEST['search_leads']==1 && isset($_SESSION['leds_id']) && !empty($_SESSION['leds_id'])){
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
       echo '</table>';
	}

	
	
 
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
						     $fetch3="update leads SET assigned_user_id='".$user_list[$i]."'where id='".$ledt[$i]."'";
                 $row3 =$db->query($fetch3);
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
			else
					 {
								   $leads = $_SESSION['leds_id'];
								   $users = $_POST['check_list'];
								   $max = count($leads);
									// FOR COUNT LEADS & USER
									 echo '<h3>'.'<b>'.'Selected User'.'&nbsp';
									 print_r ($max1 = count($users));
									 echo ' and Leads ';
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

					}
					unset($_SESSION['records_fetch']);
		unset($_SESSION['leds_id']);
		?>
		 <script>
		  alert( 'Lead transfered successfully'); window.location.reload();
		 </script>
		<?php
					
}
		
	 }
  }
  ?>
  <?php

	echo '<form action="index.php?module=Leads&action=lead_transfer&search_leads=1&transfer_leads=1" name="transfer" method="post" id="trnsfer">';
	echo '<br/><br/><h1>Transfer Leads</h1><br/>';
	 ?>


				  <h1>Select Users For Transfer Leads</h1>
				<?php $fetch2 = "SELECT acl_roles.id, acl_roles_users.user_id, users.id, users.user_name FROM acl_roles JOIN acl_roles_users ON acl_roles.id = acl_roles_users.role_id JOIN users ON  acl_roles_users.user_id = users.id WHERE acl_roles.id = '270ce9dd-7f7d-a7bf-f758-582aeb4f2a45' ";

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
             <?php } ?>

 

<script>
$(function(){
	$("#vendors").change(function(){
		$("#medium_val").html('');
		if($(this).val()!=''){
			$.ajax({url: "index.php?entryPoint=budgtedvsactual&vendors="+$(this).val()+"", success: function(result){
				var result = JSON.parse(result);
				if(result.status=='ok'){
				var medium='';
				 for(var i=0;i<result.res.length;i++){
						var id = result.res[i].id;
						var name = result.res[i].name;
						medium+='<option value="'+id+'">'+name+'</option>'
				 }
				 $("#medium_val").html(medium);
				}
			}});
		}
	});
});

</script>

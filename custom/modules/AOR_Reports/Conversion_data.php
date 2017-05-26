<?php
/* This is Custom file  For Budgeted vs Compaign
 * Display menu from Action at Module te_budgeted campaign
 *  Created date -02-dec-2016 @Manish Gupta 9650211216
 * */
if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');
	ini_set('display_errors','0');
	error_reporting(E_ALL);
	global $app_list_strings,$current_user,$sugar_config,$db;
?>
<html>
    <title>Conversion Data</title>
  <head>
    <style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}
td, th {
    border-top: 1px solid #dddddd;
    border-bottom: 1px solid #dddddd;
    border-left: 1px solid #dddddd;
    border-right: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}
input[type=text], select {
    WIDTH: 132PX !IMPORTANT;
}
</style>
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
</head>
 <table width="100%">
	<form action="index.php?module=AOR_Reports&action=Conversion_data" method="post" id="lead_trans">
		<tbody>
			<tr>
	<td><b>Select Batch</b></td>
					      <td>
								<select name="batch_val[]" multiple="1" class="multiselbox" id="batch_val">
								<option  value="">Select Batch</option>
									<?php
									  $fetch1="SELECT id,name FROM te_ba_batch WHERE batch_status='enrollment_in_progress' AND deleted=0";
									  $row1 =$db->query($fetch1);
									while($records =$db->fetchByAssoc($row1)){ ?>
									<option  value="<?php echo $records['id']?>"><?php echo $records['name']?></option>
									<?php }?>
                                </select></td>
                                <td><b>Start Date</b></td>
										<td><input type="text" name="start_date" id="datepicker"/></td>
										<td><b>End Date</b></td>
									<td>	<input type="text" name="end_date" id="enddate"/></td>
										<td align='center' style="border:none;"><input type="Submit" name="Submit" value="Find Report"></td></tr>
										</tbody></table>
				</form>

        <body>
			<?php
			 //@ Get All Vendor  details
			 $where='';
			 if(isset($_POST['Submit']) &&!empty($_POST['Submit'])) {
				 extract($_POST);
			// $whereBatch = implode ( "', '",$_POST['batch_val']);
			// $where=" AND ID IN('".$whereBatch."')";
			 if(!empty($start_date)&&!empty($end_date)){
				$where.=" AND (CAST(date_entered AS DATE) BETWEEN '".$start_date."' AND '".$end_date."')";
				}
				if(!empty($start_date)&&empty($end_date)){
				if($where!=''){
				$where.=" AND (CAST(date_entered AS DATE) > '".$start_date."')";
				}
				else{
				$where.=" AND (CAST(date_entered AS DATE) > '".$start_date."')";
				}
				}
				if(empty($start_date)&&!empty($end_date)){
				if($where!=''){
				$where.=" AND (CAST(date_entered AS DATE) < '".$end_date."')";
				}
				else{
				$where.=" AND (CAST(date_entered AS DATE) < '".$end_date."')";
				}
				}
			 if(!empty($batch_val)){
				$source_str=implode("','",$batch_val);
				//$source_str="'".$source_str."'";
				if($where!=''){
				$where.=" AND id in('".$source_str."')";
				}
				else{
				$where.=" AND id in('".$source_str."')";
				}
				}
			 }

			  $vendorlist= array();
			  $fetch="SELECT id,name FROM te_vendor WHERE deleted=0";
			  $row =$db->query($fetch);
			  $vendorlist='';
			  $batchnamelist='';
			  $batchidlist='';
			  while($records =$db->fetchByAssoc($row)){
				 $vendorlist[]=$records['name'];
			  }
			  $fetch1="SELECT id,name FROM te_ba_batch WHERE batch_status='enrollment_in_progress' AND deleted=0 ".$where."";
			  $row1 =$db->query($fetch1);
			  while($records1 =$db->fetchByAssoc($row1)){
				  $batchnamelist[]=$records1['name'];
				  $batchidlist[]=$records1['id'];
			  }
			  ?>
			  <h1><b>Conversion Data Report</b></h1><br/><br/>
			  <table border="1">
				<thead>
					<tr>
						<th>&nbsp;</th>
					<?php for($i=0;$i<count($batchnamelist);$i++){ ?>
						<th><?php echo $batchnamelist[$i];?></th>

					<?php }?>
						<th>Grand Total</th>
					</tr>
				</thead>
				<tbody>
				<?php $gt='';
				$column_sum = array();?>
				<?php for($v=0;$v<count($vendorlist);$v++){ ?>
					<tr>
						<?php $tdarr='';?>
						<th><?php echo $vendorlist[$v];?></th>

						<?php for($b=0;$b<count($batchidlist);$b++){
							// $leadcount=getLeadCount($vendorlist[$v],$batchidlist[$b]);
							   $fetch3="SELECT count(leads.id)total FROM `leads` INNER JOIN leads_cstm ON leads.id=leads_cstm.id_c WHERE leads.deleted=0 AND leads.status='Converted' AND leads.vendor='".$vendorlist[$v]."'
									   AND leads_cstm.te_ba_batch_id_c='".$batchidlist[$b]."'";
							  $row3 =$db->query($fetch3);
							  $recordscount =$db->fetchByAssoc($row3);
							  $recordscount=$recordscount['total'];
							 $column_sum[$batchidlist[$b]][]=$recordscount;
						?>
						<td>
							<?php $tdarr[]=$recordscount;
											// echo $vendorlist[$v].'X'.$batchidlist[$b].'-';
											//echo $leadcount;
											echo $recordscount;
											//array sum here
							?>
						</td>
						<?php }?>
						<th><?php echo array_sum($tdarr);$gt['gt'][]=array_sum($tdarr);?></th>
					</tr>

				<?php }?>
				<tr>
					<th>Grand Total</th>

					<?php foreach($column_sum as $val){?>
					<th><?php echo array_sum($val);?></th>
					<?php }?>
					<th><?php echo array_sum($gt['gt']);?></th>
				</tr>
				</tbody>
			  </table>
				<script>
				  $(function() {
						$(".multiselbox").each(function(){
				      if($(this).find("option").eq(0).val()==''){
				        $(this).find("option").eq(0).remove();
				      }
				    })
					 $(".multiselbox").multiselect({
				     includeSelectAllOption: true
				   });
					});
			 </script>
        </body>
</html>

<?php
function getLeadCount($vendorname='',$batchid='') {
	$recordscount = 0;

	if($vendorname!='' && $batchid!='') {

	$fetch3="SELECT count(leads.id)total FROM `leads` INNER JOIN leads_cstm ON leads.id=leads_cstm.id_c WHERE leads.deleted=0 AND leads.vendor='".$vendorname."'
					      AND leads_cstm.te_ba_batch_id_c='".$batchid."'";
					      $row3 =$db->query($fetch3);
						  $recordscount =$db->fetchByAssoc($row3);
						  $recordscount=$recordscount['total'];


	}
	return $recordscount;
}
?>

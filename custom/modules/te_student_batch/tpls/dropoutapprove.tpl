
<section class="moduleTitle"> <h2>Student Batch For Dropout Approval</h2><br/><br/>

<table cellpadding="0" cellspacing="0" width="100%" border="0" class="list view table footable-loaded footable default">
	<thead>    	
	<tr height="20">
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">	
			<strong>Student</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
			<strong>Batch Name</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
			<strong>Program</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
			<strong>Institute</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
			<strong>Batch Code</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
			<strong>Fee INR</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
			<strong>Fee USD</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
			<strong>Dropout Status</strong>
		</th>
	</tr>
	</thead>  
	{if $resultSet|@count > 0}
	{foreach from = $resultSet key=key item=result}
		<tr height="20" class="oddListRowS1">
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$result.student}</td>
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$result.batch}</td> 	
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$result.program}</td>
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$result.institute}</td> 
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$result.batch_code}</td> 
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$result.fee_usd}</td>
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$result.fee_inr}</td> 			
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$result.action}</td> 
		</tr>				
	{/foreach}
	{else}
		<tr height="20" class="oddListRowS1">
			<td colspan="8">No Data</td>
		</tr>
	{/if}
</table>
{literal}
<script language="javascript">
function changeDropoutStatus(request_id,value){

	var span_id="dropout_request_"+request_id;	
	$("#"+span_id).html('<img id="previewimage" src="custom/themes/default/images/spin.gif" width="32" height="32"/>');	
	jQuery.ajax({
		type: "POST",
		url: 'index.php?entryPoint=dropoutapprove',
		data: {request_id: request_id,request_status: value},
		success: function (result)
		{
			var result = JSON.parse(result);		
			if(result.status=='Approved'){
				 window.location.reload();
			}
		}
	}); 	
}
</script>
{/literal}

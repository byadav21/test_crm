
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
			<strong>Dropout Type</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
			<strong>Refund Amount</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
			<strong>Refund Date</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
			<strong>Dropout Status</strong>
		</th>
		
	</tr>
	</thead>  
	{if $resultSet|@count > 0}
	{assign var='rowcount' value=0}
	{foreach from = $resultSet key=key item=result}
		{assign var='rowcount' value=$rowcount+1}
		<tr height="20" class="oddListRowS1">
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column"><a href="index.php?module=te_student&return_module=te_student&action=DetailView&record={$result.idstudent}">{$result.student}</a></td>
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$result.name}</td> 	
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$result.program}</td>
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$result.institute}</td> 
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$result.batch_code}</td> 
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$result.fee_usd}</td>
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$result.fee_inr}</td> 			
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">
				{$result.dropout_type}
			</td>
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">
				{if $designation eq "BUH"}
					<input type="text" name="refund_amount" id="refund_amount_{$rowcount}" size="30" maxlength="5" value="{$result.refund_amount}" title="" tabindex="0" style='width:80PX !IMPORTANT'>
				{else}
					{$result.refund_amount}
				{/if}
				<input type="hidden" name="lead_id" id="lead_id_{$rowcount}" value="{$result.leads_id}">
				<input type="hidden" name="current_user_id" id="current_user_id_{$rowcount}" value="{$current_user_id}">
			</td>
			<td>
				{if $designation eq "BUH"}
				<input name="refund_date_{$rowcount}" type="text"  value="" id='refund_date_{$rowcount}' style='width:113PX !IMPORTANT' />
				<img src="themes/SuiteP/images/jscalendar.gif?v=yt-yazfsU-Y9uR7ixqf7Lg" alt="Enter Date" style="position:relative; top:-1px" border="0" id="refund_date_trigger_{$rowcount}">
				{else}
					{$result.refund_date}
				{/if}
				
			</td>
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$result.dropout_status}</td> 
			
		</tr>				
	{/foreach}
	{else}
		<tr height="20" class="oddListRowS1">
			<td colspan="11">No Data</td>
		</tr>
	{/if}
</table>
{literal}
<script language="javascript">
function changeDropoutStatus(request_id,value,rowcount){
	var dropout_type=$("#dropout_type_"+rowcount).val();
	var refund_amount=$("#refund_amount_"+rowcount).val();
	var refund_date=$("#refund_date_"+rowcount).val();
	var lead_id=$("#lead_id_"+rowcount).val();
	var current_user_id=$("#current_user_id_"+rowcount).val();
	var span_id="dropout_request_"+request_id;		 
	 
	if(value!='Pending' && value!='') {
	 var conf = confirm("Are you sure you want change the status to "+value+" ?");	
	 if(conf==true) {
	  $("#"+span_id).html('<img id="previewimage" src="custom/themes/default/images/spin.gif" width="32" height="32"/>');	 	
	  jQuery.ajax({
		type: "POST",
		url: 'index.php?entryPoint=dropoutapprove',
		data: {request_id: request_id,request_status: value,dropout_type: dropout_type,refund_amount: refund_amount,refund_date: refund_date,lead_id:lead_id,current_user_id:current_user_id},
		success: function (result)
		{
			var result = JSON.parse(result);		
			if(result.status=='Approved'){
				 window.location.reload();
			}
		}
	  });
     } else { 	
	  jQuery('select[name=dropout_status] option[value='+value+']').removeAttr('selected');	 
	  jQuery('select[name=dropout_status] option[value=Pending]').prop('selected','selected');	 
 	 }	
    }
}
Calendar.setup ({
   inputField : "refund_date_1",
   daFormat : "%m/%d/%Y %I:%M%P",
   button : "refund_date_trigger_1",
   singleClick : true,
   dateStr : "",
   step : 1,
   weekNumbers:false,
});
Calendar.setup ({
   inputField : "refund_date_2",
   daFormat : "%m/%d/%Y %I:%M%P",
   button : "refund_date_trigger_2",
   singleClick : true,
   dateStr : "",
   step : 1,
   weekNumbers:false,
});
Calendar.setup ({
   inputField : "refund_date_3",
   daFormat : "%m/%d/%Y %I:%M%P",
   button : "refund_date_trigger_3",
   singleClick : true,
   dateStr : "",
   step : 1,
   weekNumbers:false,
});
Calendar.setup ({
   inputField : "refund_date_4",
   daFormat : "%m/%d/%Y %I:%M%P",
   button : "refund_date_trigger_4",
   singleClick : true,
   dateStr : "",
   step : 1,
   weekNumbers:false,
});
Calendar.setup ({
   inputField : "refund_date_5",
   daFormat : "%m/%d/%Y %I:%M%P",
   button : "refund_date_trigger_5",
   singleClick : true,
   dateStr : "",
   step : 1,
   weekNumbers:false,
});
Calendar.setup ({
   inputField : "refund_date_6",
   daFormat : "%m/%d/%Y %I:%M%P",
   button : "refund_date_trigger_6",
   singleClick : true,
   dateStr : "",
   step : 1,
   weekNumbers:false,
});
Calendar.setup ({
   inputField : "refund_date_7",
   daFormat : "%m/%d/%Y %I:%M%P",
   button : "refund_date_trigger_7",
   singleClick : true,
   dateStr : "",
   step : 1,
   weekNumbers:false,
});
Calendar.setup ({
   inputField : "refund_date_8",
   daFormat : "%m/%d/%Y %I:%M%P",
   button : "refund_date_trigger_8",
   singleClick : true,
   dateStr : "",
   step : 1,
   weekNumbers:false,
});
Calendar.setup ({
   inputField : "refund_date_9",
   daFormat : "%m/%d/%Y %I:%M%P",
   button : "refund_date_trigger_9",
   singleClick : true,
   dateStr : "",
   step : 1,
   weekNumbers:false,
});
Calendar.setup ({
   inputField : "refund_date_10",
   daFormat : "%m/%d/%Y %I:%M%P",
   button : "refund_date_trigger_10",
   singleClick : true,
   dateStr : "",
   step : 1,
   weekNumbers:false,
});						
</script>
{/literal}
<!-- View COde added-->
{if $designation eq "BUH" }
<section class="moduleTitle"> <h2>Student Batch For Dropout Past Details</h2><br/><br/>

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
			<strong>Dropout Type</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
			<strong>Refund Amount</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
			<strong>Refund Date</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
			<strong>Dropout Status</strong>
		</th>
		
	</tr>
	</thead>  
	
	{if $resultSethis|@count > 0}
	{foreach from = $resultSethis key=key item=result}
		<tr height="20" class="oddListRowS1">
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column"><a href="index.php?module=te_student&return_module=te_student&action=DetailView&record={$result.idstudent}">{$result.student}</a></td>
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$result.name}</td> 	
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$result.program}</td>
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$result.institute}</td> 
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$result.batch_code}</td> 
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$result.fee_usd}</td>
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$result.fee_inr}</td> 			
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$result.dropout_type}</td>
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$result.refund_amount}</td>
			<td>{$result.refund_date}</td>
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$result.dropout_status}</td> 
			
		</tr>				
	{/foreach}
	{/if}
</table>

{/if}


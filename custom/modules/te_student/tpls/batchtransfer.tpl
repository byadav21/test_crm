<section class="moduleTitle"> <h2>Student Batch Transfer</h2><br/><br/>
<form name="search_form" id="search_form" class="search_form" method="post" action="index.php?module=te_student&action=batchtransfer">
<div id="te_budgeted_campaignbasic_searchSearchForm" style="" class="edit view search basic">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
		<tr>      
			<td scope="row" nowrap="nowrap" width="1%">		
				<label for="email_basic">Email</label>
			</td>
			<td nowrap="nowrap" width="10%">			
				<input type="text" name="email" id="email" value="{$selected_email}">
			</td>	
			<td scope="row" nowrap="nowrap" width="1%">		
				<label for="phone_basic">phone</label>
			</td>	
			<td nowrap="nowrap" width="10%">			
				<input type="text" name="phone" id="phone" value="{$phone}">
			</td>				
			
			<td class="sumbitButtons">
				<input tabindex="2" title="Search" onclick="SUGAR.savedViews.setChooser();" class="button" type="submit" name="button" value="Search" id="search_form_submit">&nbsp;
				<input tabindex="2" title="Clear" onclick="SUGAR.searchForm.clear_form(this.form); return false;" class="button" type="button" name="clear" id="search_form_clear" value="Clear">
	        </td>
			<td nowrap="nowrap" width="10%">&nbsp;</td>
			<td class="helpIcon" width="*"><img alt="Help" border="0" id="filterHelp" src="themes/SuiteR/images/help-dashlet.png?v=mjry3sKU3KG11ojfGn-sdg"></td>
		</tr>
		</tbody>
	</table>
</div>
</form>
<table cellpadding="0" cellspacing="0" width="100%" border="0" class="list view table footable-loaded footable default">
	<thead>    	
	<tr height="20">
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">	
			<strong>Name</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
			<strong>Email</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
			<strong>Phone</strong>
		</th>
	</tr>
	{foreach from = $studentList key=key item=student}
		<tr height="20" class="oddListRowS1">
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">
				<a href="index.php?module=te_student&return_module=te_student&action=DetailView&record={$student.id}" target="_blank"> {$student.name}
				</a>
			</td>
		  	<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">
			{$student.email}
		   </td>
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">
			{$student.mobile}
		   </td>
		</tr>				
	{/foreach}
</table>
<section> <br/><h4>Student Batch List</h4><br/>
<table cellpadding="0" cellspacing="0" width="100%" border="0" class="list view table footable-loaded footable default">
	<thead>    	
	<tr height="20">
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">	
			<strong>Current Batch</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">	
			<strong>Start Date</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
			<strong>Programs</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
			<strong>Transfer Batch</strong>
		</th>		
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
			<strong>Action</strong>
		</th>	
	</tr>
	</thead>
	{assign var='rowcount' value=1}
	{foreach from = $studentBatchList key=key item=studentBatch}		
		<tr height="20" class="oddListRowS1">
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">
				 {$studentBatch.name}
				 <input type="hidden" id="old_batch{$rowcount}" value="{$studentBatch.id}">
				 <input type="hidden" id="student_country{$rowcount}" value="{$student.country}">
			</td>
		  	<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">
			{$studentBatch.batch_start_date}
		   </td>			
		   <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">
				<select name="transfer_to_program" id="transfer_to_program{$rowcount}" onchange="getBatchOption({$rowcount});">
					<option value="">--Select Program--</option>
					{foreach from = $studentBatch.transferProgramList key=key1 item=transferProgram}
						<option value="{$transferProgram.id}">{$transferProgram.name}</option>
					{/foreach}
				</select>
		   </td>
		   <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">
				<select name="transfer_to_batch"id="transfer_to_batch{$rowcount}">
					<option value="">--Select Batch--</option>
					{foreach from = $studentBatch.transferBatchList key=key1 item=transferBatch}
						<option value="{$transferBatch.id}">{$transferBatch.name}</option>
					{/foreach}
				</select>
		   </td>
		   <td align="left" valign="top" type="relate" id="transfer_batch_button{$rowcount}">
				<input tabindex="2" title="Batch Transfer" class="button" type="button" name="button" value="Transfer Batch" id="batch_transfer_form_submit" onclick="transferStudentBatch('{$student.id}',{$rowcount});">
				<span id="batch_transfer{$rowcount}"></span>
		   </td>
		</tr>	
		{assign var='rowcount' value=$rowcount+1}
	{/foreach}
</table>
{literal}
<script>
function getBatchOption(rowcount){
	var programId= $("#transfer_to_program"+rowcount).val();
	if(programId!=''){
		$.ajax({url: "index.php?entryPoint=getbatch&programId="+programId, success: function(result){
			var result = JSON.parse(result);
			if(result.status=='ok'){
				var batch='<option value=""></option>';
				 for(var i=0;i<result.res.length;i++){
						var id = result.res[i].id;
						var name = result.res[i].name;
						batch+='<option value="'+id+'">'+name+'</option>'
				 }
				 $("#transfer_to_batch"+rowcount).html(batch);
			}
		}});
	}
	
}

function transferStudentBatch(student_id,rowcount){
	var span_id="batch_transfer"+rowcount;
	var old_batch= $("#old_batch"+rowcount).val();
	var new_batch= $("#transfer_to_batch"+rowcount).val();
	var student_country= $("#student_country"+rowcount).val();
	if(new_batch!=""){
		$("#"+span_id).html('<img id="previewimage" src="custom/themes/default/images/spin.gif" width="32" height="32"/>');	
		jQuery.ajax({
		type: "POST",
		url: 'index.php?entryPoint=transferbatchrequest',
		data: {student_id: student_id,old_batch: old_batch,new_batch: new_batch,student_country:student_country},
		success: function (result)
		{
			var result = JSON.parse(result);		
			if(result.status=='queued'){
				 $("#transfer_batch_button"+rowcount).html("Sent Request");
			}
		}
		}); 
	}	 
}
</script>
{/literal}

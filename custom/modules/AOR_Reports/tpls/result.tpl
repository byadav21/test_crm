{literal}
<script>
$(function(){
	$("#status").change(function(){		
		if($(this).val()!=''){
			$.ajax({url: "index.php?entryPoint=getbatchbyleadstatus&status="+$(this).val()+"", success: function(result){
				var result = JSON.parse(result);
				if(result.status=='ok'){				
				var utm='';
				 for(var i=0;i<result.res.length;i++){
						var id = result.res[i].id;
						var name = result.res[i].name;
						utm+='<option value="'+id+'">'+name+'</option>'
				 }
				 $("#batch").html(utm);				
				}
			}});
		}
	});
});
</script>
{/literal}
<section class="moduleTitle"> <h2>Result Report</h2><br/><br/>
<form name="search_form" id="search_form" class="search_form" method="post" action="index.php?module=AOR_Reports&action=result">
<input type="hidden" name="batch_created_date" id="batch_created_date" value="{$batch_created_date}">
<div id="te_budgeted_campaignbasic_searchSearchForm" style="" class="edit view search basic">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
		<tr>      
			<td scope="row" nowrap="nowrap" width="1%">		
				<label for="batch_basic">Status</label>
			</td>
			<td nowrap="nowrap" width="10%">			
				<select name="status" id="status">
					{if $selected_status eq 'Live'}
						<option value="Pass" selected>Pass</option>
					{else}
						<option value="pass">Pass</option>
					{/if}
					{if $selected_status eq 'fail'}
						<option value="fail" selected>Fail</option>
					{else}
						<option value="fail">Fail</option>
					{/if}
				</select>
			</td>	
			<td scope="row" nowrap="nowrap" width="1%">		
				<label for="batch_basic">Batch</label>
			</td>	
			<td nowrap="nowrap" width="10%">			
				<select name="batch[]" id="batch"  class="multiselbox" multiple>
					<option  value=""></option>
					{foreach from = $batchList key=key item=batch}
						<option value="{$batch.id}"{if in_array($batch.id, $selected_batch)} selected="selected"{/if}>{$batch.name}</option>							
					{/foreach}							
				</select>
			</td>				
			
			<td class="sumbitButtons">
				<input tabindex="2" title="Search" onclick="SUGAR.savedViews.setChooser();" class="button" type="submit" name="button" value="Search" id="search_form_submit">&nbsp;
				<input tabindex="2" title="Clear" onclick="SUGAR.searchForm.clear_form(this.form); return false;" class="button" type="button" name="clear" id="search_form_clear" value="Clear">
	        </td>
			<td nowrap="nowrap" width="10%">&nbsp;</td>
			<td class="helpIcon" width="*"><img alt="Help" border="0" id="filterHelp" src="themes/SuiteR/images/help-dashlet.png?v=mjry3sKU3KG11ojfGn-sdg"></td>
		</tr>
		<tr>
			<td scope="row" nowrap="nowrap" width="1%">
				<input tabindex="2" title="Export" onclick="SUGAR.savedViews.setChooser();" class="button" type="submit" name="export" value="Export" id="export_form_submit">
			</td>
		</tr>
		</tbody>
	</table>
</div>
</form>
<table cellpadding="0" cellspacing="0" width="100%" border="0" class="list view table footable-loaded footable default">
	<thead>    	
	<tr height="20">
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">	
			<strong>Counsellors</strong>
		</th>
		{foreach from = $programList key=key item=program}
			<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
				<strong>{$program}</strong>
			</th>
		{/foreach}		
	</tr>
	{foreach from = $councelorList key=key item=councelor}
		<tr height="20" class="oddListRowS1">
		   <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.name}</td>
		   {foreach from = $programList key=key item=program}
				<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.$key}</td> 
		   {/foreach}		  				
		</tr>				
	{/foreach}
</table>

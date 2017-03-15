<section class="moduleTitle"> <h2>Fee Report</h2><br/><br/>
<form name="search_form" id="search_form" class="search_form" method="post" action="index.php?module=AOR_Reports&action=feereport">
<input type="hidden" name="batch_created_date" id="batch_created_date" value="{$batch_created_date}">
<div id="te_budgeted_campaignbasic_searchSearchForm" style="" class="edit view search basic">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
		<tr>      
			<td scope="row" nowrap="nowrap" width="1%">		
				<label for="batch_basic">Batch</label>
			</td>	
			<td nowrap="nowrap" width="10%">			
				<select name="batch" id="batch">
					<option  value=""></option>
					{foreach from = $batchList key=key item=batch}
						<option value="{$batch.id}"{if $batch.id eq $selected_batch} selected="selected"{/if}>{$batch.name}</option>							
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
		</tbody>
	</table>
</div>
</form>
<table cellpadding="0" cellspacing="0" width="100%" border="0" class="list view table footable-loaded footable default">
	<thead>    	
	<tr height="20">
		{foreach from = $reportHeader key=key item=value}
			<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
				<strong>{$value}</strong>
			</th>
		{/foreach}		
	</tr>
	{foreach from = $feeList key=key item=data}
		<tr height="20" class="oddListRowS1">
			{foreach from = $reportHeader key=key item=value}
				<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{if $data.$value neq ""} {$data.$value} {else}NA{/if}</td>
			{/foreach}
		</tr>				
	{/foreach}
</table>

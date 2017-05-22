<section class="moduleTitle"> <h2>Daily Report Report</h2><br/><br/>
<form name="search_form" id="search_form" class="search_form" method="post" action="index.php?module=AOR_Reports&action=dailyuploadreport">
<div id="te_budgeted_campaignbasic_searchSearchForm" style="" class="edit view search basic">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
		<tr>      

			
			<td scope="row" nowrap="nowrap" width="1%">		
				<label for="batch_basic">Date</label>
			</td>
			<td nowrap="nowrap" width="10%">			
				<input name="search_date" type="text"  value="{$selected_date}" id='search_date'/>
				<img src="themes/SuiteP/images/jscalendar.gif?v=yt-yazfsU-Y9uR7ixqf7Lg" alt="Enter Date" style="position:relative; top:-1px" border="0" id="search_date_trigger">
			</td>
		</tr>
		<tr><td colspan="8">&nbsp;</td></tr>
		<tr>
			<td  colspan="8">
				<input tabindex="2" title="Search" onclick="SUGAR.savedViews.setChooser();" class="button" type="submit" name="button" value="Search" id="search_form_submit">&nbsp;
				<input tabindex="2" title="Clear" onclick="SUGAR.searchForm.clear_form(this.form); return false;" class="button" type="button" name="clear" id="search_form_clear" value="Clear">
				<input tabindex="2" title="Export" onclick="SUGAR.savedViews.setChooser();" class="button" type="submit" name="export" value="Export" id="export_form_submit">
				
	        </td>
		</tr>
		</tbody>
	</table>
</div>
</form>
<table cellpadding="0" cellspacing="0" width="100%" border="0" class="list view table footable-loaded footable default">
	<thead> 
	{*Start Pagination*}
	<tr id="pagination" role="presentation">
		<td colspan="20">
			<table border="0" cellpadding="0" cellspacing="0" width="100%" class="paginationTable">
				<tbody><tr>
					<td nowrap="nowrap" class="paginationActionButtons">&nbsp;</td>
					
					<td nowrap="nowrap" align="right" class="paginationChangeButtons" width="1%">
						
						{if $left eq 1}
							<a href="index.php?module=AOR_Reports&action=dailyuploadreport"  name="listViewStartButton" title="Start" class="button" >
							<img src="themes/SuiteR/images/start_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Start">
							</a>
						
							<a href="index.php?module=AOR_Reports&action=dailyuploadreport&page={$page}"  class="button" title="Previous">
							<img src="themes/SuiteR/images/previous_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Previous">
							</a>						
						{else}
							<button type="button" id="listViewStartButton_top" name="listViewStartButton" title="Start" class="button" disabled="disabled">
							<img src="themes/SuiteR/images/start_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Start">
							</button>
						
							<button type="button" id="listViewPrevButton_top" name="listViewPrevButton" class="button" title="Previous" disabled="disabled">
							<img src="themes/SuiteR/images/previous_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Previous">
							</button>
						{/if}
						
					</td>
					<td nowrap="nowrap" width="1%" class="paginationActionButtons">
						<div class="pageNumbers">{$current_records}</div>
					</td>
					<td nowrap="nowrap" align="right" class="paginationActionButtons" width="1%">
						{if $right eq 1}
						<a href="index.php?module=AOR_Reports&action=dailyuploadreport&page={$page}"  class="button" title="Next" disabled="disabled">
							<img src="themes/SuiteR/images/next_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Next">
						</a>
						<a href="index.php?module=AOR_Reports&action=dailyuploadreport&page={$last_page}"  class="button" title="End" disabled="disabled">
							<img src="themes/SuiteR/images/end_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" alt="End">
						</a>
						{else}
							<button type="button" id="listViewNextButton_top" name="listViewNextButton" class="button" title="Next" disabled="disabled">
							<img src="themes/SuiteR/images/next_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Next">
							</button>
							<button type="button" id="listViewEndButton_top" name="listViewEndButton" title="End" class="button" disabled="disabled">
							<img src="themes/SuiteR/images/end_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" alt="End">
							</button>
						{/if}
						
					
					</td>
					<td nowrap="nowrap" width="4px" class="paginationActionButtons"></td>
				</tr>
			</tbody>
		</table>
		</td>
	</tr>
	{*End Pagination*}
	<tr height="20">
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">	
			<strong>Vendor</strong>
		</th>
		
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
			<strong>Total Leads</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
			<strong>New Lead</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
			<strong>Duplicate</strong>
		</th>		
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
			<strong>Dristi Uploaded</strong>
		</th>		
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
			<strong>Called</strong>
		</th>		
	</tr>
	{foreach from = $reportDataList key=key item=data}
	<tr height="20" class="oddListRowS1">
		<td align="left" valign="top" type="relate" field="vendor" class="inlineEdit footable-visible footable-last-column">{$data.name}</td>
		<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$data.total}</td>	
		<td align="left" valign="top" type="relate" field="total_leads" class="inlineEdit footable-visible footable-last-column">{$data.alive}</td> 
		<td align="left" valign="top" type="relate" field="total_leads" class="inlineEdit footable-visible footable-last-column">{$data.duplicate}</td> 
		<td align="left" valign="top" type="relate" field="total_leads" class="inlineEdit footable-visible footable-last-column">{$data.uploaded}</td> 
		<td align="left" valign="top" type="relate" field="total_leads" class="inlineEdit footable-visible footable-last-column">{$data.called}</td> 
		</tr>				
	{/foreach}
	
</table>
<script>
{literal}
Calendar.setup ({
   inputField : "search_date",
   daFormat : "%m/%d/%Y %I:%M%P",
   button : "search_date_trigger",
   singleClick : true,
   dateStr : "",
   step : 1,
   weekNumbers:false,
});
</script>
{/literal}



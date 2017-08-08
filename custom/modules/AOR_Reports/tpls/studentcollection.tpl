<section class="moduleTitle"> <h2>Collection Report</h2><br/><br/><br>
<form name="search_form" id="search_form" class="search_form" method="post" action="index.php?module=AOR_Reports&action=studentcollection">
<input type="hidden" name="batch_created_date" id="batch_created_date" value="{$batch_created_date}">
<div id="te_budgeted_campaignbasic_searchSearchForm" style="" class="edit view search basic">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>

			<td scope="row" nowrap="nowrap" width="1%">
				<label for="batch_basic">From Date</label>
			</td>
			<td nowrap="nowrap" width="10%" class="caltd">
				<input name="from_date" type="text"  value="{$selected_from_date}" id='from_date'/>
				<img src="themes/SuiteP/images/jscalendar.gif?v=yt-yazfsU-Y9uR7ixqf7Lg" alt="Enter Date" style="position:relative; top:-1px" border="0" id="from_date_trigger">
			</td>
			<td scope="row" nowrap="nowrap" width="1%" >
				<label for="batch_basic">To Date</label>
			</td>
			<td nowrap="nowrap" width="10%" class="caltd">
				<input name="to_date" type="text"  value="{$selected_to_date}" id='to_date'/>
				<img src="themes/SuiteP/images/jscalendar.gif?v=yt-yazfsU-Y9uR7ixqf7Lg" alt="Enter Date" style="position:relative; top:-1px" border="0" id="to_date_trigger">
			</td>
			 
			<td scope="row" nowrap="nowrap" width="1%">
				<label for="batch_basic">Batch</label>
			</td>
			<td nowrap="nowrap" width="10%">
				<select name="batches[]" id="batches"  class="multiselbox" multiple>
					<option  value=""></option>
						{foreach from = $batchList key=key item=batch}
							<option value="{$batch.id}" {if array_search($batch.id,$selected_batch) } selected="selected" {/if}>{$batch.name}</option>
						{/foreach}
				</select>
			</td>
			<td scope="row" nowrap="nowrap" width="1%" class="caltd">
				<label for="batch_basic">Payment Mode</label>
			</td>
			<td nowrap="nowrap" width="10%">
				<select name="pmode" id="pmode"  >
					<option  value=""></option>
					<option {if $retmode=='online'} selected  {/if} value="Online">Online</option>
					<option  {if $retmode=='offline'} selected  {/if} value="Offline">Offline</option>
				</select>
			</td>
	</tr>
	<tr>		
			<td class="sumbitButtons" colspan=8 style="text-align: right;">
				<input tabindex="2" title="Search" onclick="SUGAR.savedViews.setChooser();" class="button" type="submit" name="button" value="Search" id="search_form_submit">&nbsp;
				<input tabindex="2" title="Clear" onclick="SUGAR.searchForm.clear_form(this.form); return false;" class="button" type="button" name="clear" id="search_form_clear" value="Clear">
	            <input tabindex="2" title="Export" onclick="SUGAR.savedViews.setChooser();" class="button" type="submit" name="export" value="Export" id="export_form_submit">

	        
			</td>
		</tr>
		</tbody>
	</table>
	<br><br>
	{*Start Pagination*}
					<tr id="pagination" role="presentation">
						<td colspan="20">
							<table border="0" cellpadding="0" cellspacing="0" width="100%" class="paginationTable">
								<tbody><tr>
									<td nowrap="nowrap" class="paginationActionButtons">&nbsp;</td>

									<td nowrap="nowrap" align="right" class="paginationChangeButtons" width="1%">

										{if $left eq 1}
											<a href="index.php?module=AOR_Reports&action=gsvreport"  name="listViewStartButton" title="Start" class="button" >
											<img src="themes/SuiteR/images/start_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Start">
											</a>

											<a href="index.php?module=AOR_Reports&action=studentcollection&page={$page}"  class="button" title="Previous">
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
										<a href="index.php?module=AOR_Reports&action=studentcollection&page={$pagenext}"  class="button" title="Next" disabled="disabled">
											<img src="themes/SuiteR/images/next_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Next">
										</a>
										<a href="index.php?module=AOR_Reports&action=studentcollection&page={$last_page}"  class="button" title="End" disabled="disabled">
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
</div>
</form>
<table cellpadding="0" cellspacing="0" width="100%" border="0" class="list view table footable-loaded footable default">
	<thead>
	<tr height="20">
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Date</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Course</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Batch</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Student</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>State</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>GSV</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Amount Collected</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Payment Mode</strong>
		</th>
	 </tr>
	{foreach from = $councelorList key=key item=councelor}
		<tr height="20" class="oddListRowS1">
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.date_of_payment}</td>
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.name}</td>
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.batch_code}</td>
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.fname}</td>
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.state}</td>
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.fee_inr|number_format:2:".":","}</td>
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.amount|number_format:2:".":","}</td>
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.payment_type }</td>

		</tr>
	{/foreach}
</table>
<style>
{literal}
   .caltd img{ position: absolute!important;
    top: 19px!important;
    right: 8px;} 
    .caltd{ position :relative!important}
{/literal}
</style>
<script>
{literal}
Calendar.setup ({
   inputField : "from_date",
   daFormat : "%d-%m-%Y %I:%M%P",
   button : "from_date_trigger",
   singleClick : true,
   dateStr : "",
   step : 1,
   weekNumbers:false,
});
</script>
{/literal}
<script>
{literal}
Calendar.setup ({
   inputField : "to_date",
   daFormat : "%d-%m-%Y %I:%M%P",
   button : "to_date_trigger",
   singleClick : true,
   dateStr : "",
   step : 1,
   weekNumbers:false,
});
</script>
{/literal}

<section class="moduleTitle"> <h2>Daily Report</h2><br/><br/>
<form name="search_form" id="search_form" class="search_form" method="post" action="index.php?module=AOR_Reports&action=dailyreport">
<div id="te_budgeted_campaignbasic_searchSearchForm" style="" class="edit view search basic">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
		<tr>

			<td scope="row" nowrap="nowrap" width="1%">
				<label for="batch_basic">Vendor</label>
			</td>
			<td nowrap="nowrap" width="10%">
				<select name="vendor"  id="vendor">
					<option  value="">Select Vendor</option>
					{foreach from = $vendorOptionList key=key item=vendor}
						<option value="{$vendor.id}" {if $selected_vendor eq $vendor.id} selected="selected" {/if}>{$vendor.name}</option>
					{/foreach}
				</select>
			</td>
			<td scope="row" nowrap="nowrap" width="1%">
				<label for="batch_basic">Course</label>
			</td>
			<td nowrap="nowrap" width="10%">
				<select name="course" id="course">
					<option  value="">Select Batch</option>
					{foreach from = $batchList key=key item=batch}
						<option value="{$batch.id}" {if $selected_batch eq $batch.id} selected="selected" {/if}>{$batch.name}</option>
					{/foreach}
				</select>
			</td>
			<!--<td scope="row" nowrap="nowrap" width="1%">
				<label for="batch_basic">Course Status</label>
			</td>
			<td nowrap="nowrap" width="10%">
				<select name="course_status" id="course_status">
					<option  value="">Select Batch</option>
					{foreach from = $batchStatusList key=key item=status}
						<option value="{$key}" {if $selected_status eq $key} selected="selected" {/if}>{$status}</option>
					{/foreach}
				</select>
			</td>-->
      <td scope="row" nowrap="nowrap" width="1%">
				<label for="batch_basic">From Date</label>
			</td>
			<td nowrap="nowrap" width="10%">
				<input name="from_date" type="text"  value="{$selected_from_date}" id='from_date'/>
				<img src="themes/SuiteP/images/jscalendar.gif?v=yt-yazfsU-Y9uR7ixqf7Lg" alt="Enter Date" style="position:relative; top:-1px" border="0" id="from_date_trigger">
			</td>
			<td scope="row" nowrap="nowrap" width="1%">
				<label for="batch_basic">To Date</label>
			</td>
			<td nowrap="nowrap" width="10%">
				<input name="to_date" type="text"  value="{$selected_to_date}" id='to_date'/>
				<img src="themes/SuiteP/images/jscalendar.gif?v=yt-yazfsU-Y9uR7ixqf7Lg" alt="Enter Date" style="position:relative; top:-1px" border="0" id="to_date_trigger">
			</td>
		</tr>
		<tr><td colspan="8">&nbsp;</td></tr>
		<tr>
			<td  colspan="8">
				<input tabindex="2" title="Search" onclick="SUGAR.savedViews.setChooser();" class="button" type="submit" name="button" value="Search" id="search_form_submit">&nbsp;
				<input tabindex="2" title="Clear" onclick="SUGAR.searchForm.clear_form(this.form); return false;" class="button" type="button" name="clear" id="search_form_clear" value="Clear">
				<input tabindex="2" title="Export" onclick="SUGAR.savedViews.setChooser();" class="button" type="submit" name="export" value="Export" id="export_form_submit">
				<input tabindex="2" title="Send Email" onclick="SUGAR.savedViews.setChooser();" class="button" type="submit" name="sendemail" value="Send Email" id="sendemail_form_submit">
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
							<a href="index.php?module=AOR_Reports&action=dailyreport"  name="listViewStartButton" title="Start" class="button" >
							<img src="themes/SuiteR/images/start_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Start">
							</a>

							<a href="index.php?module=AOR_Reports&action=dailyreport&page={$leftpage}"  class="button" title="Previous">
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
						<a href="index.php?module=AOR_Reports&action=dailyreport&page={$page}"  class="button" title="Next" disabled="disabled">
							<img src="themes/SuiteR/images/next_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Next">
						</a>
						<a href="index.php?module=AOR_Reports&action=dailyreport&page={$last_page}"  class="button" title="End" disabled="disabled">
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
			<strong>Course</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Total Leads</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Registered</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Leads Validity</strong>
		</th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Leads Validity%</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Spend</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Conversion Rate</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>CPL</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>CPA</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Course Fee</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>CPA%</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>GSV</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Source CPA%</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Course CPA%</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Status</strong>
		</th>
	</tr>
	{foreach from = $reportDataList key=key item=data}
	<tr height="20" class="oddListRowS1">
		<td align="left" valign="top" type="relate" field="vendor" class="inlineEdit footable-visible footable-last-column">{$data.vendor}</td>
		<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$data.batch}</td>
		<td align="left" valign="top" type="relate" field="total_leads" class="inlineEdit footable-visible footable-last-column">{$data.total_leads}</td>
		<td align="left" valign="top" type="relate" field="total_leads" class="inlineEdit footable-visible footable-last-column">{$data.registered}</td>
		<td align="left" valign="top" type="relate" field="total_leads" class="inlineEdit footable-visible footable-last-column">{$data.lead_validity}</td>
    <td align="left" valign="top" type="relate" field="total_leads" class="inlineEdit footable-visible footable-last-column">{$data.lead_validity_per}</td>
		<td align="left" valign="top" type="relate" field="total_leads" class="inlineEdit footable-visible footable-last-column">{$data.spend}</td>
		<td align="left" valign="top" type="relate" field="total_leads" class="inlineEdit footable-visible footable-last-column">{$data.conversion_rate}%</td>
		<td align="left" valign="top" type="relate" field="total_leads" class="inlineEdit footable-visible footable-last-column">{$data.cpl}</td>
		<td align="left" valign="top" type="relate" field="total_leads" class="inlineEdit footable-visible footable-last-column">{$data.cpa}</td>
		<td align="left" valign="top" type="relate" field="total_leads" class="inlineEdit footable-visible footable-last-column">{$data.course_fee}</td>
		<td align="left" valign="top" type="relate" field="total_leads" class="inlineEdit footable-visible footable-last-column">{$data.cpa_percent}</td>
		<td align="left" valign="top" type="relate" field="total_leads" class="inlineEdit footable-visible footable-last-column">{$data.revenue}</td>
		<td align="left" valign="top" type="relate" field="total_leads" class="inlineEdit footable-visible footable-last-column">{$data.source_cpa_percent}</td>
		<td align="left" valign="top" type="relate" field="total_leads" class="inlineEdit footable-visible footable-last-column">{$data.course_cpa_percent}</td>
		<td align="left" valign="top" type="relate" field="total_leads" class="inlineEdit footable-visible footable-last-column">{$data.batch_status}</td>
	</tr>
	{/foreach}

</table>
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

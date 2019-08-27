<section class="moduleTitle"><h2><b>Leads Feedback Report</b></h2><br/><br/>
<form name="search_form" id="search_form" class="search_form" method="post" action="index.php?module=AOR_Reports&action=leadsfeedbackreport">
<input type="hidden" name="batch_created_date" id="batch_created_date" value="{$batch_created_date}">
<div id="te_budgeted_campaignbasic_searchSearchForm" style="" class="edit view search basic">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
		<tr>
			<td scope="row" nowrap="nowrap" width="1%">
				<label for="batch_basic">Batch</label>
			</td>
			<td nowrap="nowrap" width="10%">
				<select name="batch[]" id="batch" multiple="1" class="multiselbox"  size="6" style="width: 150px;">
					{foreach from = $batchList key=key item=batch}
						<option value="{$batch.id}" {if in_array($batch.id, $selected_batch) } selected="selected" {/if}>{$batch.name}</option>
					{/foreach}
				</select>
			</td>
      <td scope="row" nowrap="nowrap" width="1%">
				<label for="batch_basic">Vendor</label>
			</td>
			<td nowrap="nowrap" width="10%">
				<select name="vendor[]" id="vendor" multiple="1" class="multiselbox"  size="6" style="width: 150px;">
					{foreach from = $vendorList key=key item=vendor}
						<option value="{$vendor.name}" {if in_array($vendor.name, $selected_vendor) } selected="selected" {/if}>{$vendor.name}</option>
					{/foreach}
				</select>
			</td>

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



			<td nowrap="nowrap" width="10%">&nbsp;</td>
			<td class="helpIcon" width="*"><img alt="Help" border="0" id="filterHelp" src="themes/SuiteR/images/help-dashlet.png?v=mjry3sKU3KG11ojfGn-sdg"></td>
		</tr>
		<tr>
      <td scope="row" nowrap="nowrap" width="1%" class="sumbitButtons">
				<input tabindex="2" title="Search" onclick="SUGAR.savedViews.setChooser();" class="button" type="submit" name="button" value="Search" id="search_form_submit">&nbsp;
        <input tabindex="2" title="Clear" onclick="SUGAR.searchForm.clear_form(this.form); return false;" class="button" type="button" name="clear" id="search_form_clear" value="Clear">
	    </td>

			<td scope="row" nowrap="nowrap" width="1%" class="sumbitButtons">
				<input tabindex="2" title="Export" onclick="SUGAR.savedViews.setChooser();" class="button" type="submit" name="export" value="Export" id="export_form_submit">

			</td>
		</tr>
		</tbody>
	</table>
  {*Start Pagination*}
					<tr id="pagination" role="presentation">
						<td colspan="20">
							<table border="0" cellpadding="0" cellspacing="0" width="100%" class="paginationTable">
								<tbody><tr>
									<td nowrap="nowrap" class="paginationActionButtons">&nbsp;</td>

									<td nowrap="nowrap" align="right" class="paginationChangeButtons" width="1%">

										{if $left eq 1}
											<a href="index.php?module=AOR_Reports&action=leadsfeedbackreport"  name="listViewStartButton" title="Start" class="button" >
											<img src="themes/SuiteR/images/start_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Start">
											</a>

											<a href="index.php?module=AOR_Reports&action=leadsfeedbackreport&page={$page}"  class="button" title="Previous">
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
										<a href="index.php?module=AOR_Reports&action=leadsfeedbackreport&page={$pagenext}"  class="button" title="Next" disabled="disabled">
											<img src="themes/SuiteR/images/next_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Next">
										</a>
										<a href="index.php?module=AOR_Reports&action=leadsfeedbackreport&page={$last_page}"  class="button" title="End" disabled="disabled">
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
			<strong>Batch</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Duplicate</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Dead Number</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Not Eligible</strong>
		</th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Not Enquired</strong>
		</th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Rejected</strong>
		</th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Ringing Multiple Times</strong>
		</th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
      <strong>Wrong Number</strong>
    </th>
    <!-- New status-->
     <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
      <strong>No Answer</strong>
    </th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
      <strong>Re Enquiredr</strong>
    </th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong class="text-danger">Invalid Total</strong>
		</th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Call Back</strong>
		</th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Retired</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Fallout</strong>
		</th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Converted</strong>
		</th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Follow Up</strong>
		</th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>New Lead</strong>
		</th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
      <strong>Prospect</strong>
    </th>
     <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
      <strong>Dropout</strong>
    </th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong class="text-primary">Valid Total</strong>
		</th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong class="text-success">Grand Total</strong>
		</th>
	</tr>

	{foreach from = $councelorList key=key item=councelor}
		<tr height="20" class="oddListRowS1">
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.name}</td>
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.Duplicate}</td>
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.Dead_Number}</td>
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.Not_Eligible}</td>
      <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.Not_Enquired}</td>
      <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.Rejected}</td>
      <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.Ringing_Multiple_Times}</td>
      <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.Wrong_Number}</td>
      <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.No_Answer}</td><!-- New-->
      <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.Re_Enquired}</td>
      <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column text-danger">

        <strong class="text-danger">{$councelor.Invalid_Total}</strong>
      </td>
      <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.Call_Back}</td>
      <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.Retired}</td>
      <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.Fallout}</td>
      <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.Converted}</td>
      <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.Follow_Up}</td>
      <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.New_Lead}</td>
      <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.Prospect}</td>
      <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.Dropout}</td>
      <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column text-primary">

        <strong class="text-primary">{$councelor.Valid_Total}</strong>
      </td>
      <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">
        <strong class="text-success">{$councelor.Grand_Total}</strong>
      </td>
		</tr>
	{/foreach}
  <tr height="20" class="oddListRowS1">
    {php}
    $councelorArray = $this->get_template_vars('councelorList');
    {/php}
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
      <strong>Grand Total</strong>
    </th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
      <strong>
      {php}
      echo array_sum(array_column($councelorArray,'Duplicate'));
      {/php}
     </strong>
    </th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
      <strong>
      {php}
      echo array_sum(array_column($councelorArray,'Dead_Number'));
      {/php}
     </strong>
    </th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
      <strong>
      {php}
      echo array_sum(array_column($councelorArray,'Not_Eligible'));
      {/php}
     </strong>
    </th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
      <strong>
      {php}
      echo array_sum(array_column($councelorArray,'Not_Enquired'));
      {/php}
     </strong>
    </th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
      <strong>
      {php}
      echo array_sum(array_column($councelorArray,'Rejected'));
      {/php}
     </strong>
    </th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
      <strong>
      {php}
      echo array_sum(array_column($councelorArray,'Ringing_Multiple_Times'));
      {/php}
     </strong>
    </th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
      <strong>
      {php}
      echo array_sum(array_column($councelorArray,'Wrong_Number'));
      {/php}
     </strong>
    </th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
      <strong>
      {php}
      echo array_sum(array_column($councelorArray,'No_Answer'));
      {/php}
     </strong>
    </th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
      <strong>
      {php}
      echo array_sum(array_column($councelorArray,'Re_Enquired'));
      {/php}
     </strong>
    </th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
      <strong>
      {php}
      echo array_sum(array_column($councelorArray,'Invalid_Total'));
      {/php}
     </strong>
    </th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
      <strong>
      {php}
      echo array_sum(array_column($councelorArray,'Call_Back'));
      {/php}
     </strong>
    </th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
      <strong>
      {php}
      echo array_sum(array_column($councelorArray,'Retired'));
      {/php}
     </strong>
    </th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
      <strong>
      {php}
      echo array_sum(array_column($councelorArray,'Fallout'));
      {/php}
     </strong>
    </th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
      <strong>
      {php}
      echo array_sum(array_column($councelorArray,'Converted'));
      {/php}
     </strong>
    </th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
      <strong>
      {php}
      echo array_sum(array_column($councelorArray,'Follow_Up'));
      {/php}
     </strong>
    </th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
      <strong>
      {php}
      echo array_sum(array_column($councelorArray,'New_Lead'));
      {/php}
     </strong>
    </th>
    <!-- new-->
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
      <strong>
      {php}
      echo array_sum(array_column($councelorArray,'Prospect'));
      {/php}
     </strong>
    </th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
      <strong>
      {php}
      echo array_sum(array_column($councelorArray,'Dropout'));
      {/php}
     </strong>
    </th>

    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
      <strong>
      {php}
      echo array_sum(array_column($councelorArray,'Valid_Total'));
      {/php}
     </strong>
    </th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
      <strong>
      {php}
      echo array_sum(array_column($councelorArray,'Grand_Total'));
      {/php}
     </strong>
    </th>

  </tr>
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
$( document ).ready(function() {
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
{/literal}

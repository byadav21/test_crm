<section class="moduleTitle"> <h2>UTM Status Report</h2><br/><br/>
<form name="search_form" id="search_form" class="search_form" method="post" action="index.php?module=AOR_Reports&action=utmstatusreport">
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
  {*Start Pagination*}
					<tr id="pagination" role="presentation">
						<td colspan="20">
							<table border="0" cellpadding="0" cellspacing="0" width="100%" class="paginationTable">
								<tbody><tr>
									<td nowrap="nowrap" class="paginationActionButtons">&nbsp;</td>

									<td nowrap="nowrap" align="right" class="paginationChangeButtons" width="1%">

										{if $left eq 1}
											<a href="index.php?module=AOR_Reports&action=utmstatusreport"  name="listViewStartButton" title="Start" class="button" >
											<img src="themes/SuiteR/images/start_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Start">
											</a>

											<a href="index.php?module=AOR_Reports&action=utmstatusreport&page={$page}"  class="button" title="Previous">
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
										<a href="index.php?module=AOR_Reports&action=utmstatusreport&page={$pagenext}"  class="button" title="Next" disabled="disabled">
											<img src="themes/SuiteR/images/next_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Next">
										</a>
										<a href="index.php?module=AOR_Reports&action=utmstatusreport&page={$last_page}"  class="button" title="End" disabled="disabled">
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
			<strong>Source</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Term</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Medium</strong>
		</th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Campaign</strong>
		</th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Duplicate</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Dead Number</strong>
		</th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Dropout</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Fallout</strong>
		</th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>No Answer</strong>
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
			<strong>Retired</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Ringing Multiple</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Wrong Number</strong>
		</th>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Call Back</strong>
		</th>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Converted</strong>
		</th>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Follow Up</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>New Lead</strong>
		</th>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Prospect</strong>
		</th>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Re-Enquired</strong>
		</th>

	</tr>
	{foreach from = $councelorList key=key item=councelor}
    {assign var=campaign value="TE__TE"|explode:$key}
		<tr height="20" class="oddListRowS1">
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.name}</td>
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.batch}</td>
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.contract_type}</td>
      <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$campaign[1]}</td>
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">
        {if $councelor.Duplicate }
        {$councelor.Duplicate}
        {else}0{/if}
      </td>
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">
        {if $councelor.Dead_Number }
        {$councelor.Dead_Number}
        {else}0{/if}
      </td>
      <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">
        {if $councelor.Dropout }
        {$councelor.Dropout}
        {else}0{/if}
      </td>
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">
        {if $councelor.Fallout }
        {$councelor.Fallout}
        {else}0{/if}
      </td>
      <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">
        {if $councelor.No_Answer }
        {$councelor.No_Answer}
        {else}0{/if}
      </td>
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">
        {if $councelor.Not_Eligible }
        {$councelor.Not_Eligible}
        {else}0{/if}
      </td>
      <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">
        {if $councelor.Not_Enquired }
        {$councelor.Not_Enquired}
        {else}0{/if}
      </td>
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">
        {if $councelor.Rejected }
        {$councelor.Rejected}
        {else}0{/if}
      </td>
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">
        {if $councelor.Retired }
        {$councelor.Retired}
        {else}0{/if}
      </td>
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">
        {if $councelor.Ringing_Multiple_Times }
        {$councelor.Ringing_Multiple_Times}
        {else}0{/if}
      </td>
      <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">
        {if $councelor.Wrong_Number }
        {$councelor.Wrong_Number}
        {else}0{/if}
      </td>
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">
        {if $councelor.Call_Back }
        {$councelor.Call_Back}
        {else}0{/if}
      </td>
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">
        {if $councelor.Converted }
        {$councelor.Converted}
        {else}0{/if}
      </td>
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">
        {if $councelor.Follow_Up }
        {$councelor.Follow_Up}
        {else}0{/if}
      </td>
      <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">
        {if $councelor.New_Lead }
        {$councelor.New_Lead}
        {else}0{/if}
      </td>
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">
        {if $councelor.Prospect }
        {$councelor.Prospect}
        {else}0{/if}
      </td>
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">
        {if $councelor.Re_Enquired }
        {$councelor.Re_Enquired}
        {else}0{/if}
      </td>
		</tr>
	{/foreach}
</table>
<script>
{literal}
Calendar.setup ({
   inputField : "from_date",
   daFormat : "%d/%m/%Y %I:%M%P",
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
   daFormat : "%d/%m/%Y %I:%M%P",
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

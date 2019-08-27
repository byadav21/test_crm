<section class="moduleTitle"> <h2>UTM Status Report</h2><br/><br/>
<form name="search_form" id="search_form" class="search_form" method="post" action="index.php?module=AOR_Reports&action=utmstatusreport">
<input type="hidden" name="batch_created_date" id="batch_created_date" value="{$batch_created_date}">
<div id="te_budgeted_campaignbasic_searchSearchForm" style="" class="edit view search basic">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
		<tr>

			 <td scope="row" nowrap="nowrap" width="1%">
                            <label for="Batch Status">Batch Status:</label>
                        </td>
                        <td nowrap="nowrap" width="1%">
                            <select name="status" id="status">
                                <option value="All" {if $selected_status=="All"} selected="selected"{/if}>All</option>
                                <option value="Active" {if $selected_status=="Active"} selected="selected"{/if}>Active</option>
                                <option value="Inactive" {if $selected_status=="Inactive"} selected="selected"{/if}>Inactive</option>
                            </select>
                        </td>

			<td scope="row" nowrap="nowrap" width="1%">
				<label for="batch_basic">Course</label>
			</td>
			<td nowrap="nowrap" width="10%">
				<select name="course[]" id="course"  class="multiselbox" multiple style="width:180px !important; height: 70px !important;">
					<option  value="">Select Batch</option>
					{foreach from = $batchList key=key item=batch}
						<option value="{$batch.id}" data-all="1" {if $batch.batch_status == "enrollment_in_progress"} data-type="active" {/if} {if $batch.batch_status != "enrollment_in_progress"} data-type="inactive" {/if} {if $selected_batch eq $batch.id} selected="selected" {/if}>{$batch.name}</option>
					{/foreach}
				</select>
				<select name="coursefilter" id="coursefilter"  style="display:none;">
					<option  value="">Select Batch</option>
					{foreach from = $batchList key=key item=batch}
						<option value="{$batch.id}" data-all="1" {if $batch.batch_status == "enrollment_in_progress"} data-type="active" {/if} {if $batch.batch_status != "enrollment_in_progress"} data-type="inactive" {/if} {if in_array($batch.id, $selected_batch)} selected="selected" {/if}>{$batch.name}</option>
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
			<strong>Batch Code</strong>
		</th>
	{foreach from = $leadStatusList key=key item=status}
		 <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>{$status}</strong>
		</th>
	{/foreach}
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Total</strong>
		</th>
    

	</tr>
	{foreach from = $reportDataList key=key item=data}
	<tr height="20" class="oddListRowS1">
		<td align="left" valign="top" type="relate" field="vendor" class="inlineEdit footable-visible footable-last-column">{$data.utm_source_c}</td>
		<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$data.utm_term_c}</td>
		<td align="left" valign="top" type="relate" field="batch_code" class="inlineEdit footable-visible footable-last-column">{$data.utm_contract_c}</td>
		<td align="left" valign="top" type="relate" field="total_leads" class="inlineEdit footable-visible footable-last-column">{$data.utm_campaign}</td>
		<td align="left" valign="top" type="relate" field="total_leads" class="inlineEdit footable-visible footable-last-column">{$data.batch_code}</td>
		{foreach from = $leadStatusList key=key item=statusval}
		  <td align="left" valign="top" type="relate" field="total_leads" class="inlineEdit footable-visible footable-last-column">{$data.$statusval}</td>
		{/foreach}
    		<td align="left" valign="top" type="relate" field="total_leads" class="inlineEdit footable-visible footable-last-column">{$data.total}</td>
		
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
$(document).ready(function () {
	$("#status").change(function () {
	    var statusVal = $('#status').val();
	    if(statusVal=="Active"){
		$("#course").html(" ");
		$("#course").html($("#coursefilter").html());
		$("#course option[data-type!=active]").remove();
		$('select[multiple]').multiselect('reload');
	    }
	    else if(statusVal=="Inactive"){
		$("#course").html(" ");
		$("#course").html($("#coursefilter").html());
		$("#course option[data-type!=inactive]").remove();
		$('select[multiple]').multiselect('reload');
	    }
	    else{
		$("#course").html(" ");
		$("#course").html($("#coursefilter").html());
		$('select[multiple]').multiselect('reload');
	    }
	});
	$( "#status" ).trigger( "change" );
});

</script>
{/literal}

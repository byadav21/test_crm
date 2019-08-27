<section class="moduleTitle"> 
<div class="panel panel-default" style="margin-top: 5%;">
      <div class="panel-heading"><h1>Junk Lead Log Details</h1></div>
      <div class="panel-body">
		<form class="form-inline" method="post" action="index.php?module=Leads&action=junkleadlog">
		    <table width="100%" cellspacing="0" cellpadding="0" border="0">
			<tbody>
			<tr>
				
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
		  </form>
      </div>
</div>

<div id="te_budgeted_campaignbasic_searchSearchForm" style="" class="edit view search basic">
    <table cellpadding="0" cellspacing="0" width="100%" border="0" class="list view table footable-loaded footable default">
	<thead>
	{*Start Pagination*}
            <tr id="pagination" role="presentation">
                <td colspan="20">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="paginationTable">
                        <tbody><tr>
                                <td nowrap="nowrap" class="paginationActionButtons">
					<!--<a href="index.php?module=Leads&action=junkleadlog&export=true" class="btn btn-primary">Export Result</a>-->
				</td>

                                <td nowrap="nowrap" align="right" class="paginationChangeButtons" width="1%">

                                    {if $left eq 1}
                                        <a href="index.php?module=Leads&action=junkleadlog"  name="listViewStartButton" title="Start" class="button" >
                                            <img src="themes/SuiteR/images/start_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Start">
                                        </a>

                                        <a href="index.php?module=Leads&action=junkleadlog&page={$page}"  class="button" title="Previous">
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
                                        <a href="index.php?module=Leads&action=junkleadlog&page={$pagenext}"  class="button" title="Next" disabled="disabled">
                                            <img src="themes/SuiteR/images/next_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Next">
                                        </a>
                                        <a href="index.php?module=Leads&action=junkleadlog&page={$last_page}"  class="button" title="End" disabled="disabled">
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
	    </thead>
	<tr height="20">
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Lead ID</strong>
		</th>
		
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Full Name</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Email</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Mobile No</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Date Entered</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Batch Code</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>UTM Term</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Campaign ID</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>API ID</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Reason</strong>
		</th>
	</tr>
	{foreach from = $result_data key=key item=value}
            
             <tr height="20" class="oddListRowS1">
		 <td  align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$value.id}</td>
                 <td  align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$value.first_name} {$value.last_name}</td>
		 <td  align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$value.email_add_c}</td>
		 <td  align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$value.phone_mobile}</td>
                 <td  align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$value.date_entered}</td>
                 <td  align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$value.batch_code}</td>
		 <td  align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$value.utm_term_c}</td>
		 <td  align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$value.dristi_campagain_id}</td>
		 <td  align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$value.dristi_API_id}</td>
                 <td  align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$value.reason}</td>
             </tr>
           
        {/foreach}
		 </tbody>
	 </table>
  </div>
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

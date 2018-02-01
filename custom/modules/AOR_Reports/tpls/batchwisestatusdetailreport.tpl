<section class="moduleTitle"> <h2>Batch Wise Status Detail Report</h2><br/><br/>
    <form name="search_form" id="search_form" class="search_form" method="post" action="index.php?module=AOR_Reports&action=batchwisestatusdetailreport">
        <input type="hidden" name="batch_created_date" id="batch_created_date" value="{$batch_created_date}">
        <div id="te_budgeted_campaignbasic_searchSearchForm" style="" class="edit view search basic">
            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                <tbody>
					<tr>
                        <td scope="row" nowrap="nowrap" width="1%">
                            <label for="batch_basic">Program</label>
                        </td>
                        <td nowrap="nowrap" >
                            <select name="program[]" id="program"  class="program_advanced" multiple style="width:600px !important; height: 70px !important;">
                                {foreach from =$ProgrammeListData key=key item=program}

                                    <option value="{$program.id}"{if in_array($program.id, $selected_program)} selected="selected"{/if}>{$program.name}</option>
                                {/foreach}
                            </select>
                        </td>
                        
                    </tr>
                    <tr>
                        <td scope="row" nowrap="nowrap" width="1%">
                            <label for="batch_basic">Batch</label>
                        </td>
                        <td nowrap="nowrap" >
                            <select name="batch[]" id="batch"  class="batch_advanced" multiple style="width:600px !important; height: 70px !important;">
                                {foreach from =$BatchListData key=key item=program}

                                    <option value="{$program.id}"{if in_array($program.id, $selected_batch)} selected="selected"{/if}>{$program.name}</option>
                                {/foreach}
                            </select>
                        </td>
                        
                        <td scope="row" nowrap="nowrap" width="1%">
                            <label for="batch_basic">Batch Code</label>
                        </td>
                        <td nowrap="nowrap" >
                            <select name="batch_code[]" id="batch_code"  class="multiselbox_batch" multiple style="width:180px !important; height: 70px !important;">
                                {foreach from =$BatchListData key=key item=program}

                                    <option value="{$program.id}"{if in_array($program.id, $selected_batch)} selected="selected"{/if}>{$program.batch_code}</option>
                                {/foreach}
                            </select>
                        </td>
                    </tr>
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



                    <tr>
                        <td class="sumbitButtons" colspan="3">
                            <input tabindex="2" title="Search" onclick="SUGAR.savedViews.setChooser();" class="button" type="submit" name="button" value="Search" id="search_form_submit">&nbsp;
                            <input tabindex="2" title="Clear" onclick="SUGAR.searchForm.clear_form(this.form);
                                    return false;" class="button" type="button" name="clear" id="search_form_clear" value="Clear">
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
                                        <a href="index.php?module=AOR_Reports&action=batchwisestatusdetailreport"  name="listViewStartButton" title="Start" class="button" >
                                            <img src="themes/SuiteR/images/start_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Start">
                                        </a>

                                        <a href="index.php?module=AOR_Reports&action=batchwisestatusdetailreport&page={$page}"  class="button" title="Previous">
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
                                        <a href="index.php?module=AOR_Reports&action=batchwisestatusdetailreport&page={$pagenext}"  class="button" title="Next" disabled="disabled">
                                            <img src="themes/SuiteR/images/next_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Next">
                                        </a>
                                        <a href="index.php?module=AOR_Reports&action=batchwisestatusdetailreport&page={$last_page}"  class="button" title="End" disabled="disabled">
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
                    &nbsp;
                </th>
				<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                    &nbsp;
                </th>
                <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                    &nbsp;
                </th>
                <th scope="col" data-hide="phone" class="footable-visible footable-first-column" colspan="3"><strong>Alive</strong></th>
				<th scope="col" data-hide="phone" class="footable-visible footable-first-column" colspan="7"><strong>Dead</strong></th>
				<th scope="col" data-hide="phone" class="footable-visible footable-first-column"><strong>Converted</strong></th>
				<th scope="col" data-hide="phone" class="footable-visible footable-first-column" colspan="2"><strong>Warm</strong></th>
				<th scope="col" data-hide="phone" class="footable-visible footable-first-column"><strong>Recycle </strong></th>
				<th scope="col" data-hide="phone" class="footable-visible footable-first-column"><strong>Dropout</strong></th>
				<th scope="col" data-hide="phone" class="footable-visible footable-first-column"><strong>Duplicate</strong></th>
				<th scope="col" data-hide="phone" class="footable-visible footable-first-column"><strong>NA</strong></th>

            </tr>
            <tr height="20">
                <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                    <strong>Program Name</strong>
                </th>
				<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                    <strong>Batch Name</strong>
                </th>
                <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                    <strong>Batch Code</strong>
                </th>
                {foreach from = $StatusList key=key item=status}
				<th scope="col" data-hide="phone" class="footable-visible footable-first-column"><strong>{$status}</strong></th>
				{/foreach}
				
            </tr>
			{foreach from = $programList key=key item=program}
                <tr height="20" class="oddListRowS1">
                    <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.program_name}</td>
					<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.name}</td>
                    <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.batch_code}</td>
                    {foreach from = $StatusList key=key item=vendor}

                        <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column"> {if !empty($program.$key)} {$program.$key} {else} 0 {/if} </td>
                    {/foreach}

                </tr>
            {/foreach}
			
    </table>
    {literal}
        <script>
            Calendar.setup({
                inputField: "from_date",
                daFormat: "%d-%m-%Y %I:%M%P",
                button: "from_date_trigger",
                singleClick: true,
                dateStr: "",
                step: 1,
                weekNumbers: false,
            });
            Calendar.setup({
                inputField: "to_date",
                daFormat: "%d-%m-%Y %I:%M%P",
                button: "to_date_trigger",
                singleClick: true,
                dateStr: "",
                step: 1,
                weekNumbers: false,
            });

        </script>
    {/literal}

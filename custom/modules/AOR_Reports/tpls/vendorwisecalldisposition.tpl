<section class="moduleTitle"> <h2>Vendor wise Call Disposition Report</h2><br/><br/>
    <form name="search_form" id="search_form" class="search_form" method="post" action="index.php?module=AOR_Reports&action=vendorwisecalldisposition">
        <input type="hidden" name="batch_created_date" id="batch_created_date" value="{$batch_created_date}">
        <div id="te_budgeted_campaignbasic_searchSearchForm" style="" class="edit view search basic">
            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                <tbody>
                    <tr>
                        <td scope="row" nowrap="nowrap" width="1%">
                            <label for="batch_basic">Batch Code</label>
                        </td>
                        <td nowrap="nowrap" >
                            <select name="batch_code[]" id="batch_code"  class="multiselbox_batch" multiple style="width:180px !important; height: 70px !important;">
                                {foreach from =$BatchListData key=key item=program}

                                    <option value="{$program.id}"{if in_array($program.id, $selected_batch_code)} selected="selected"{/if}>{$program.batch_code}</option>
                                {/foreach}
                            </select>
                        </td>

                        <td scope="row" nowrap="nowrap" width="1%">
                            <label for="batch_basic">Vendor</label>
                        </td>
                        <td nowrap="nowrap" >
                            <select name="vendors[]" id="vendor"  class="multiselbox_batch" multiple style="width:180px !important; height: 70px !important;">
                                {foreach from =$VendorListData key=key item=program}

                                    <option value="{$program.name}"{if in_array($program.name, $selected_vendor)} selected="selected"{/if}>{$program.name}</option>
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
                        <td scope="row" nowrap="nowrap" width="1%">
                            <label for="batch_basic">Export with</label>
                        </td>
                        <td nowrap="nowrap" width="10%">

                             <select name="exportwith" id="exportwith" >
                                {foreach from =$exportwithArr key=key item=val}

                                    <option value="{$key}"{if ($key==$selected_exportwith) } selected="selected"{/if}>{$val}</option>
                                {/foreach}
                            </select>
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
            <div><span style="float:right; font-style: italic;">(* Only 31 Days of data can be downloaded.)</span></div>
        </div>
    </form>



    <div style="width:99%;overflow:hidden;">                  
        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="paginationTable">  
            <thead>
                {*Start Pagination*}
                <tr id="pagination" role="presentation">
                    <td colspan="20">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="paginationTable">
                            <tbody><tr>
                                    <td nowrap="nowrap" class="paginationActionButtons">&nbsp;</td>

                                    <td nowrap="nowrap" align="right" class="paginationChangeButtons" width="1%">

                                        {if $left eq 1}
                                            <a href="index.php?module=AOR_Reports&action=vendorwisecalldisposition"  name="listViewStartButton" title="Start" class="button" >
                                                <img src="themes/SuiteR/images/start_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Start">
                                            </a>

                                            <a href="index.php?module=AOR_Reports&action=vendorwisecalldisposition&page={$page}"  class="button" title="Previous">
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
                                            <a href="index.php?module=AOR_Reports&action=vendorwisecalldisposition&page={$pagenext}"  class="button" title="Next" disabled="disabled">
                                                <img src="themes/SuiteR/images/next_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Next">
                                            </a>
                                            <a href="index.php?module=AOR_Reports&action=vendorwisecalldisposition&page={$last_page}"  class="button" title="End" disabled="disabled">
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
            </thead></table>
    </div> 

    <div style="width:99%;overflow:auto;border:2px dashed #d0d0d0;" class="div-leads-list">                          
        <table cellpadding="0" cellspacing="0" width="{$tablewidth}" border="0" class="list view table footable-loaded footable default">
            <tr height="20">
                {foreach from = $StatusList key=key item=status}
                    <th scope="col" data-hide="phone" class="footable-visible footable-first-column"><strong>{$status}</strong></th>
                        {/foreach}

            </tr>
            {if empty($programList)}<tr class="oddListRowS1"><td align="left"  colspan="30">No Data Found.</td></tr>{/if}
            {foreach from = $programList key=key item=program}
                <tr height="20" class="oddListRowS1">
                    {foreach from = $StatusList key=statuskey item=vendor}
                        <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column"> {if !empty($program.$statuskey)} {$program.$statuskey} {else} 0 {/if} </td>
                    {/foreach}
                </tr>
            {/foreach}


        </table>
    </div>
    {literal}
        <script>
            Calendar.setup({
                inputField: "from_date",
                daFormat: "%Y-%m-%d %I:%M%P",
                button: "from_date_trigger",
                singleClick: true,
                dateStr: "",
                step: 1,
                weekNumbers: false,
            });
            Calendar.setup({
                inputField: "to_date",
                daFormat: "%Y-%m-%d %I:%M%P",
                button: "to_date_trigger",
                singleClick: true,
                dateStr: "",
                step: 1,
                weekNumbers: false,
            });
            $(document).ready(function () {
                $("#search_form").on('submit', (function (e) {

                    var from_date = $('#from_date').val();
                    var to_date = $('#to_date').val();

                    if (from_date == '' || from_date == null) {
                        $("#from_date").focus();
                        alert('Please select From-Date!');
                        return false;
                    }

                    if (to_date == '' || to_date == null) {
                        $("#to_date").focus();
                        alert('Please select To-Date!');
                        return false;
                    }


                }));

            });
        </script>
    {/literal}

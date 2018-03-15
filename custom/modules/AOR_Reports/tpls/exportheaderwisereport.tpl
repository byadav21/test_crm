<section class="moduleTitle"> <h2>Export Report By Headers</h2><br/><br/>
    <form name="search_form" id="search_form" class="search_form" method="post" action="index.php?module=AOR_Reports&action=exportheaderwisereport">
        <input type="hidden" name="batch_created_date" id="batch_created_date" value="{$batch_created_date}">
        <div id="te_budgeted_campaignbasic_searchSearchForm" style="" class="edit view search basic">
            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                <tbody>
                    
                     <tr>
                        <td scope="row" nowrap="nowrap" width="1%">
                            <label for="From Date">From Date:</label>
                        </td>
                        <td nowrap="nowrap" width="10%">
                            <input name="from_date" type="text"  value="{$selected_from_date}" id='from_date'/>
                            <img src="themes/SuiteP/images/jscalendar.gif?v=yt-yazfsU-Y9uR7ixqf7Lg" alt="Enter Date" style="position:relative; top:-1px" border="0" id="from_date_trigger">
                        </td>
                        <td scope="row" nowrap="nowrap" width="1%">
                            <label for="To Date">To Date:</label>
                        </td>
                        <td nowrap="nowrap" width="10%">
                            <input name="to_date" type="text"  value="{$selected_to_date}" id='to_date'/>
                            <img src="themes/SuiteP/images/jscalendar.gif?v=yt-yazfsU-Y9uR7ixqf7Lg" alt="Enter Date" style="position:relative; top:-1px" border="0" id="to_date_trigger">
                        </td>
                    </tr>
                     <tr>
                        <td scope="row" nowrap="nowrap" width="1%">
                            <label for="batch_basic">Batch Name:</label>
                        </td>
                        <td nowrap="nowrap" >
                            <select name="batch[]" id="batch"  class="multiselbox" multiple style="width:600px !important; height: 70px !important;">
                                {foreach from =$BatchListData key=key item=program}

                                    <option value="{$program.id}"{if in_array($program.id, $selected_batch)} selected="selected"{/if}>{$program.name}</option>
                                {/foreach}
                            </select>
                        </td>
                       <td scope="row" nowrap="nowrap" width="1%">
                            <label for="Batch Code">Batch Code:</label>
                        </td>
                        <td nowrap="nowrap" >
                            <select name="batch_code[]" id="batch_code"  class="multiselbox" multiple style="width:180px !important; height: 70px !important;">
                                {foreach from =$BatchListData key=key item=program}

                                    <option value="{$program.id}"{if in_array($program.id, $selected_batch_code)} selected="selected"{/if}>{$program.batch_code}</option>
                                {/foreach}
                            </select>
                        </td>
                    </tr>
                    
                    <tr>
                        <td scope="row" nowrap="nowrap" width="1%">
                            <label for="status">Status:</label>
                        </td>
                        <td nowrap="nowrap" >
                            <select name="status[]" class="multiselbox" multiple style="width:180px !important; height: 70px !important;" id="status" title="">

                                <option label="" value="" {if in_array("", $selected_status)} selected="selected"{/if}>Select</option>
                                        <option label="Alive"  {if in_array("Alive", $selected_status)} selected="selected"{/if}>Alive</option>
                                <option label="Converted" value="Converted" {if in_array("Converted", $selected_status)} selected="selected"{/if}>Converted</option>
                                        <option label="Dead" value="Dead" {if in_array("Dead", $selected_status)} selected="selected"{/if}>Dead</option>
                                <option label="Duplicate" value="Duplicate" {if in_array("Duplicate", $selected_status)} selected="selected"{/if}>Duplicate</option>
                                        <option label="Dropout" value="Dropout" {if in_array("Dropout", $selected_status)} selected="selected"{/if}>Dropout</option>
                                <option label="Warm" value="Warm" {if in_array("Warm", $selected_status)} selected="selected"{/if}>Warm</option>
                                        <option label="Recycle" value="Recycle" {if in_array("Recycle", $selected_status)} selected="selected"{/if}>Recycle</option>
                            </select>
                        </td>
                        
                        <td scope="row" nowrap="nowrap" width="1%">
                            <label for="Status Description">Status Details:</label>
                        </td>
                        <td nowrap="nowrap" >
                            <select name="status_description[]" class="multiselbox" multiple style="width:180px !important; height: 70px !important;" id="status_description">
                                <option value="" {if isset($selected_status_description) && $selected_status_description ==''} selected="selected" {/if}>Select</option>
                                {foreach from =$StatusDetails key=key item=val}

                                    <option value="{$key}"{if in_array($StatusDetails.$key, $selected_status_description)} selected="selected"{/if}>{$val}</option>
                                {/foreach}
                            </select>
                        </td>

                       {* <td scope="row" nowrap="nowrap" width="1%">
                            <label for="Source">Source:</label>
                        </td>
                        <td nowrap="nowrap" >
                            <select name="source[]" id="source"  class="multiselbox" multiple style="width:180px !important; height: 70px !important;">

                                {foreach from =$lead_source_type key=key item=type}

                                    <option value="{$key}" {if in_array($key, $selected_source)} selected="selected"{/if}>{$type}</option>
                                {/foreach}
                            </select>
                        </td>*}
                    </tr>

                    <tr>
                        <td scope="row" nowrap="nowrap" width="1%">
                            <label for="batch_basic">Headers:</label>
                        </td>

                        <td nowrap="nowrap" >
                            <select name="headers[]" id="headers"  class="multiselbox" multiple style="width:180px !important; height: 70px !important;">
                                {foreach from =$headers key=key item=value}

                                    <option value="{$key}"{if in_array($key, $selected_headers)} selected="selected"{/if}>{$value}</option>
                                {/foreach}
                            </select>
                        </td>

                         <td scope="row" nowrap="nowrap" width="1%">
                            <label for="batch_basic">Vendor:</label>
                        </td>
                        <td nowrap="nowrap" >
                            <select name="vendors[]" id="vendor"  class="multiselbox" multiple style="width:180px !important; height: 70px !important;">
                                {foreach from =$VendorListData key=key item=program}

                                    <option value="{$program.id}"{if in_array($program.id, $selected_vendor)} selected="selected"{/if}>{$program.name}</option>
                                {/foreach}
                            </select>
                            
                        </td>
                        
                    </tr>
                    
                   
                    
                    {*<tr>


                        <td scope="row" nowrap="nowrap" width="1%">
                            <label for="Mobile">Mobile:</label>
                        </td>
                        <td nowrap="nowrap" width="25%" class="__web-inspector-hide-shortcut__">
                            <input type="text" name="mobile" id="phone_mobile_advanced" size="30" maxlength="100" title="" tabindex="" class="phone" value="{$selected_mobile}">

                        </td>

                        <td scope="row" nowrap="nowrap" width="1%">
                            <label for="email">Email:</label>
                        </td>
                        <td nowrap="nowrap" width="25%">
                            <input type="text" name="email" id="email_advanced" size="30" value="{$selected_email}" title="" accesskey="9">
                        </td>

                    </tr>

                    <tr>
                        <td scope="row" nowrap="nowrap" width="1%">
                            <label for="status">Status:</label>
                        </td>
                        <td nowrap="nowrap" >
                            <select name="status" id="status" title="">

                                <option label="" value="" {if isset($selected_status) && $selected_status == ''} selected="selected {/if}>Select</option>
                                        <option label="Alive"  {if isset($selected_status) && $selected_status == 'Alive'} selected="selected {/if}>Alive</option>
                                <option label="Converted" value="Converted" {if isset($selected_status) && $selected_status == 'Converted'} selected="selected {/if}>Converted</option>
                                        <option label="Dead" value="Dead" {if isset($selected_status) && $selected_status == 'Dead'} selected="selected {/if}>Dead</option>
                                <option label="Duplicate" value="Duplicate" {if isset($selected_status) && $selected_status == 'Duplicate'} selected="selected {/if}>Duplicate</option>
                                        <option label="Dropout" value="Dropout" {if isset($selected_status) && $selected_status == 'Dropout'} selected="selected {/if}>Dropout</option>
                                <option label="Warm" value="Warm" {if isset($selected_status) && $selected_status == 'Warm'} selected="selected {/if}>Warm</option>
                                        <option label="Recycle" value="Recycle" {if isset($selected_status) && $selected_status == 'Recycle'} selected="selected {/if}>Recycle</option>
                            </select>
                        </td>

                        <td scope="row" nowrap="nowrap" width="1%">
                            <label for="Status Description">Status Description:</label>
                        </td>
                        <td nowrap="nowrap" >
                            <select name="status_description" id="status_description">
                                <option value="" {if isset($selected_status_description) && $selected_status_description ==''} selected="selected" {/if}>Select</option>
                                {foreach from =$StatusDetails key=key item=val}

                                    <option value="{$key}"{if isset($selected_status_description) && $selected_status_description == $key} selected="selected" {/if}>{$val}</option>
                                {/foreach}
                            </select>
                        </td>

                    </tr>

                    <tr>


                        <td scope="row" nowrap="nowrap" width="1%">
                            <label for="Source Type">Source Type:</label>
                        </td>
                        <td nowrap="nowrap" >
                            <select name="lead_source_types" id="lead_source_types" title="">
                                <option label="" value="" {if isset($selected_lead_source_types) && $selected_lead_source_types == ''} selected="selected" {/if}>Select</option>
                                <option label="Call Center" value="CC" {if isset($selected_lead_source_types) && $selected_lead_source_types == 'CC'} selected="selected" {/if}>Call Center</option>
                                <option label="Channel" value="OO" {if isset($selected_lead_source_types) && $selected_lead_source_types == 'OO'} selected="selected" {/if}>Channel</option>
                            </select>
                        </td>

                        <td scope="row" nowrap="nowrap" width="1%">
                            <label for="Source">Source:</label>
                        </td>
                        <td nowrap="nowrap" >
                            <select name="source[]" id="source"  class="multiselbox_batch" multiple style="width:180px !important; height: 70px !important;">

                                {foreach from =$lead_source_type key=key item=type}

                                    <option value="{$key}" {if in_array($key, $selected_source)} selected="selected"{/if}>{$type}</option>
                                {/foreach}
                            </select>
                        </td>

                    </tr>

                    <tr>
                        <td scope="row" nowrap="nowrap" width="1%">
                            <label for="Autoassign">Autoassign:</label>
                        </td>
                        <td nowrap="nowrap" >
                            <select name="autoassign" id="autoassign" title="">
                                <option label="" value="" {if isset($selected_autoassign) && $selected_autoassigns == ''} selected="selected" {/if}>Select</option>
                                <option label="Yes" value="Yes" {if isset($selected_autoassign) && $selected_autoassign == 'Yes'} selected="selected" {/if}>Yes</option>
                                <option label="No" value="No" {if isset($selected_autoassign) && $selected_autoassign == 'No'} selected="selected" {/if}>No</option>
                            </select>
                        </td>

                        <td scope="row" nowrap="nowrap" width="1%">
                            <label for="ameyo_status">Ameyo status:</label>
                        </td>
                        <td nowrap="nowrap" >
                            <select name="ameyo_status" id="ameyo_status" title="">
                                <option label="" value="" {if isset($selected_ameyo_status) && $selected_ameyo_status == ''} selected="selected" {/if}>Select</option>
                                <option label="Pushed" value="1" {if isset($selected_ameyo_status) && $selected_ameyo_status == 1} selected="selected" {/if}>Pushed</option>
                                <option label="Unpushed" value="0" {if isset($selected_ameyo_status) && $selected_ameyo_status == 0} selected="selected" {/if}>Unpushed</option>
                            </select>
                        </td>

                    </tr>

                    <tr>
                        <td scope="row" nowrap="nowrap" width="1%">
                            <label for="Campagain ID">Campagain ID:</label>
                        </td>
                        <td nowrap="nowrap" >
                            <select name="campaignIDs" id="campaignIDs" title="">
                                <option value="" {if isset($selected_campaignIDs) && $selected_campaignIDs ==''} selected="selected" {/if}>Select</option>
                                {foreach from =$campaignIDs key=key item=val}

                                    <option value="{$key}" {if isset($selected_campaignIDs) && $selected_campaignIDs == $key} selected="selected" {/if}>{$val}</option>
                                {/foreach}
                            </select>
                        </td>

                        <td scope="row" nowrap="nowrap" width="1%">
                            <label for="Lead ID">Lead ID:</label>
                        </td>
                        <td nowrap="nowrap" >
                            <select name="leadIDs" id="leadIDs" title="">
                                <option value="" {if isset($selected_leadIDs) && $selected_leadIDs ==''} selected="selected" {/if}>Select</option>
                                {foreach from =$leadIDs key=key item=val}

                                    <option value="{$key}"{if isset($selected_leadIDs) && $selected_leadIDs == $key} selected="selected" {/if}>{$val}</option>
                                {/foreach}
                            </select>
                        </td>
                    </tr>*}

                   

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
                                        <a href="index.php?module=AOR_Reports&action=exportheaderwisereport"  name="listViewStartButton" title="Start" class="button" >
                                            <img src="themes/SuiteR/images/start_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Start">
                                        </a>

                                        <a href="index.php?module=AOR_Reports&action=exportheaderwisereport&page={$page}"  class="button" title="Previous">
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
                                        <a href="index.php?module=AOR_Reports&action=exportheaderwisereport&page={$pagenext}"  class="button" title="Next" disabled="disabled">
                                            <img src="themes/SuiteR/images/next_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Next">
                                        </a>
                                        <a href="index.php?module=AOR_Reports&action=exportheaderwisereport&page={$last_page}"  class="button" title="End" disabled="disabled">
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

                {foreach from = $ExcelHeaders key=key item=column}
                    <th scope="col" data-hide="phone" class="footable-visible footable-first-column"><strong>{$column}</strong></th>
                        {/foreach}

            </tr>   
            
        {if isset($error) && !empty($error)}  <td align="center" class="inlineEdit footable-visible footable-last-column"><h1>{$error.error}</h1></td>{/if}
            {foreach from = $leadList key=key item=program}

                <tr height="20" class="oddListRowS1">
                    
                    {foreach from =$selected_headersKey key=key item=val}
                        <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.$val}</td>
                    {/foreach}
                </tr>
            {/foreach}


    </table>
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

        </script>




    {/literal}


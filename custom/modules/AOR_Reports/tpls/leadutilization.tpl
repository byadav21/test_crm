<section class="moduleTitle"> <h2>Lead Utilization</h2><br/><br/>
    <form name="search_form" id="search_form" class="search_form" method="post" action="index.php?module=AOR_Reports&action=leadutilization">
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
                            <label for="Batch Status">Batch Status:</label>
                        </td>
                        <td nowrap="nowrap" >
                            <select name="status[]" id="status"  class="multiselbox" multiple style="width:180px !important; height: 70px !important;">
                                <option value="All" {if in_array('All', $selected_status)} selected="selected"{/if}>All</option>
                                <option value="Active" {if in_array('Active', $selected_status)} selected="selected"{/if}>Active</option>
                                <option value="Inactive" {if in_array('Inactive', $selected_status)} selected="selected"{/if}>Inactive</option>
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
                            <label for="status">Manager:</label>
                        </td>
                        <td nowrap="nowrap" >
                            <select name="managers[]" id="managers"  class="multiselbox" multiple style="width:180px !important; height: 70px !important;">
                                {foreach from =$managerSList key=key item=managers}

                                    <option value="{$key}"{if in_array($key, $selected_managers)} selected="selected"{/if}>{$managers.name}</option>
                                {/foreach}
                            </select>
                        </td>

                        <td scope="row" nowrap="nowrap" width="1%">
                            <label for="Status Description">Agent:</label>
                        </td>
                        <td nowrap="nowrap" >
                            <select name="councellors[]" id="councellors"  class="multiselbox" multiple style="width:180px !important; height: 70px !important;">
                                {foreach from =$CouncellorsList key=key item=councellor}

                                    <option value="{$key}"{if in_array($key, $selected_councellors)} selected="selected"{/if}>{$councellor.name}</option>
                                {/foreach}
                            </select>
                        </td>

                    </tr>

                    <tr>
                        <td scope="row" nowrap="nowrap" width="1%">
                            <label for="Source">Source:</label>
                        </td>
                        <td nowrap="nowrap" >
                            <select name="source[]" id="source"  class="multiselbox" multiple style="width:180px !important; height: 70px !important;">

                                {foreach from =$lead_source_type key=key item=type}

                                    <option value="{$key}" {if in_array($key, $selected_source)} selected="selected"{/if}>{$type}</option>
                                {/foreach}
                            </select>
                        </td>
                        
                        <td scope="row" nowrap="nowrap" width="1%">
                            <label for="Lead Source Type">Lead Source Type:</label>
                        </td>
                        <td nowrap="nowrap" >
                            <select name="lead_source_types[]" id="lead_source_types"  class="multiselbox" multiple style="width:180px !important; height: 70px !important;">
                                 {foreach from =$lead_source_types key=key item=type} 
                                    <option value="{$key}" {if in_array($key, $selected_lead_source_types)} selected="selected"{/if}>{$type}</option>
                                {/foreach}
                            </select>
                        </td>

                    </tr>
                    
                    
                     
                        

                   




                    <tr>
                        <td class="sumbitButtons" colspan="3">
                            <input tabindex="2" title="Search" onclick="SUGAR.savedViews.setChooser();" class="button" type="submit" name="button" value="Search" id="search_form_submit">&nbsp;
                            <input tabindex="2" title="Clear" onclick="SUGAR.searchForm.clear_form(this.form);
                                    return false;" class="button" type="button" name="clear" id="search_form_clear" value="Clear">
                           {* <input tabindex="2" title="Export" onclick="SUGAR.savedViews.setChooser();" class="button" type="submit" name="export" value="Export" id="export_form_submit">*}
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
                                        <a href="index.php?module=AOR_Reports&action=leadutilization"  name="listViewStartButton" title="Start" class="button" >
                                            <img src="themes/SuiteR/images/start_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Start">
                                        </a>

                                        <a href="index.php?module=AOR_Reports&action=leadutilization&page={$page}"  class="button" title="Previous">
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
                                        <a href="index.php?module=AOR_Reports&action=leadutilization&page={$pagenext}"  class="button" title="Next" disabled="disabled">
                                            <img src="themes/SuiteR/images/next_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Next">
                                        </a>
                                        <a href="index.php?module=AOR_Reports&action=leadutilization&page={$last_page}"  class="button" title="End" disabled="disabled">
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
                    <strong>Batch Name</strong>
                </th>
                <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                    <strong>Batch Code</strong>
                </th>

                <th scope="col" data-hide="phone" class="footable-visible footable-first-column" colspan="2">
                    <strong>Fresh Lead</strong>
                </th>
                <th scope="col" data-hide="phone" class="footable-visible footable-first-column" colspan="2">
                    <strong>leads dialled outside TAT</strong>
                </th>
                <th scope="col" data-hide="phone" class="footable-visible footable-first-column" colspan="2">
                    <strong>Leads attempted 1-3</strong>
                </th>
                <th scope="col" data-hide="phone" class="footable-visible footable-first-column" colspan="2">
                    <strong>Leads attempted more than 3</strong>
                </th>
                <th scope="col" data-hide="phone" class="footable-visible footable-first-column" colspan="2">
                    <strong>Leads attempted more than 6</strong>
                </th>
                <th scope="col" data-hide="phone" class="footable-visible footable-first-column" colspan="2">
                    <strong>Total Lead</strong>
                </th>
            </tr>   

            {*{if isset($error) && !empty($error)}  
            <td align="center" class="inlineEdit footable-visible footable-last-column"><h1>{$error.error}</h1></td>
                {/if}*}
           
         {foreach from = $leadList key=key item=leads}
            <tr height="20" class="oddListRowS1">
                
                <td  align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$leads.batch_name}</td>
                <td  align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$leads.batch_code}</td>
                 <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column"></td>
                 <td  align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">
                      {if ($leads.fresh_leads!=0)} 
                     <a href="index.php?module=AOR_Reports&action=viewleadutilization&show=fresh_leads&batch={$leads.batch_code}&lcount={$leads.fresh_leads}&totallead={$leads.lead_count}&to_date={$selected_to_date}&from_date={$selected_from_date}" target="_blank">{$leads.fresh_leads}</a>
                      {else} 0 {/if}
                      </td>
                 <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column"></td>
                <td  align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">
                    {if ($leads.leads_dialled_outside_TAT!=0)} 
                    <a href="index.php?module=AOR_Reports&action=viewleadutilization&show=leads_dialled_outside_TAT&batch={$leads.batch_code}&lcount={$leads.fresh_leads}&totallead={$leads.lead_count}&to_date={$selected_to_date}&from_date={$selected_from_date}" target="_blank"" target="_blank"> {$leads.leads_dialled_outside_TAT}</a>
                    {else} 0 {/if}
                </td>
                 <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column"></td>
                <td  align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">
                    {if ($leads.leads_attempted_1_3!=0)} 
                    <a href="index.php?module=AOR_Reports&action=viewleadutilization&show=leads_attempted_1_3&batch={$leads.batch_code}&lcount={$leads.fresh_leads}&totallead={$leads.lead_count}&to_date={$selected_to_date}&from_date={$selected_from_date}" target="_blank"" target="_blank"> {$leads.leads_attempted_1_3}</a>
                     {else} 0 {/if}
                    </td>
                 <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column"></td>
                <td  align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column"> 
                     {if ($leads.leads_attempted_4_6!=0)} 
                    <a href="index.php?module=AOR_Reports&action=viewleadutilization&show=leads_attempted_4_6&batch={$leads.batch_code}&lcount={$leads.fresh_leads}&totallead={$leads.lead_count}&to_date={$selected_to_date}&from_date={$selected_from_date}" target="_blank"" target="_blank">{$leads.leads_attempted_4_6}</a>
                      {else} 0 {/if}
                     </td>
                 <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column"></td>
                <td  align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column"> 
                    {if ($leads.leads_attempted_more_than_6!=0)} 
                    <a href="index.php?module=AOR_Reports&action=viewleadutilization&show=leads_attempted_more_than_6&batch={$leads.batch_code}&lcount={$leads.fresh_leads}&totallead={$leads.lead_count}&to_date={$selected_to_date}&from_date={$selected_from_date}" target="_blank"" target="_blank">{$leads.leads_attempted_more_than_6}</a>
                     {else} 0 {/if}
                    </td>
                 <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column"></td>
                <td  align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">
                    {if ($leads.lead_count!=0)} 
                    <a href="index.php?module=AOR_Reports&action=viewleadutilization&show=lead_count&batch={$leads.batch_code}&lcount={$leads.fresh_leads}&totallead={$leads.lead_count}&to_date={$selected_to_date}&from_date={$selected_from_date}" target="_blank"" target="_blank"> {$leads.lead_count}</a>
                    {else} 0 {/if}
                    </td>
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
            function getAjax(target, arr) {
                $.ajax({
                    beforeSend: function (request)
                    {
                        //request.setRequestHeader("OAuth-Token", SUGAR.App.api.getOAuthToken());
                    },
                    url: "index.php?entryPoint=reportsajax",
                    data: {action: target, param: arr},
                    dataType: "html",
                    type: "POST",
                    async: true,
                    success: function (data) {
                        $('#' + target).html('');
                        $('#' + target).html(data);
                        $('select[multiple]').multiselect('reload');

                    }
                });
            }
            $(document).ready(function () {

                $("#status").change(function () {
                    var arg = $('#status').val();
                    getAjax('batch_code', arg);
                });
                $("#managers").change(function () {
                    var arg = $('#managers').val();
                    getAjax('councellors', arg);
                });
                //getStateByZone();
                
                  $("#search_form").on('submit', (function(e) {
                     
                      var from_date    = $('#from_date').val();
                      var to_date      = $('#to_date').val();
                      var batch_code   = $('#batch_code').val();
                      var status       = $('#status').val();
                      var month        = $('#month').val();
                      var year         = $('#year').val();
                      var users        = $('#users').val();
                      var managers     = $('#managers').val();
                      var councellors  = $('#councellors').val();
                      
                      
                      if(from_date=='' || from_date ==null){
                          $("#from_date").focus();
                           alert('Please select From-Date!'); return false;
                      }
                      
                      if(to_date=='' || to_date ==null){
                          $("#to_date").focus();
                           alert('Please select To-Date!'); return false;
                      }
                     
                     /*if(status=='' || status ==null){
                          $("#status").focus();
                           alert('Please select a Status!'); return false;
                      }*/
                     
                      if(batch_code=='' || batch_code ==null){
                          $("#batch_code").focus();
                           alert('Please select a Batch Code!'); return false;
                      }
                      
                      /*if(managers=='' || managers ==null){
                          $("#manager").focus();
                          alert('Please select a Manager!'); return false;
                      }
                      
                       if(councellors=='' || councellors ==null){
                          $("#councellors").focus();
                          alert('Please select a Councellor!'); return false;
                      }*/
                      
                      
                     
                    
                 }));
            });


        </script>




    {/literal}


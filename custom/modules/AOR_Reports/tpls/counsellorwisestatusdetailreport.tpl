<link href="custom/modules/AOR_Reports/include/css/common_style_aor_reports.css" rel="stylesheet" type="text/css"/>

<section class="moduleTitle"> <h2>Counsellor Wise Status Detail Report_Create Date</h2><br/><br/>
    <form name="search_form" id="search_form" class="search_form" method="post" action="index.php?module=AOR_Reports&action=counsellorwisestatusdetailreport">
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

                    {*<tr>
                        <td scope="row" nowrap="nowrap" width="1%">
                            <label for="status">Manager:</label>
                        </td>
                        <td nowrap="nowrap" >
                            <select name="managers[]" id="managers"  class="multiselbox" multiple style="width:180px !important; height: 70px !important;">
                                {foreach from =$managerSList key=key item=managers}

                                    <option value="{$key}">{$managers.name}</option>
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

                    </tr>*}
                    <tr>
                        {if $isAdmin == 1 || in_array($currentRoleName, $businessHeadArray)}
                        <td scope="row" nowrap="nowrap" width="1%">
                            <label for="status">CH List:</label>
                        </td>
                        <td nowrap="nowrap">
                            <select name="channelHeadRole[]" id="channelHeadRole"  class="multiselbox" multiple style="width:180px !important; height: 70px !important;">
                                {foreach from =$chUserIds key=key item=channelHeadRole}
                                    {*<option value="{$key}">{$channelHeadRole.name}</option>*}
                                    <option value="{$key}">{$channelHeadRole.name}</option>
                                {/foreach}
                            </select>
                        </td>
                        {/if}
                        {if $isAdmin == 1 || in_array($currentRoleName, $businessHeadArray) || in_array($currentRoleName, $channelHeadArray)}
                        <td scope="row" nowrap="nowrap" width="1%">
                            <label for="Status Description">MG List:</label>
                        </td>
                        <td nowrap="nowrap" >
                            <select name="managerRole[]" id="managerRole"  class="multiselbox" multiple style="width:180px !important; height: 70px !important;">
                                {foreach from =$mgUserIds key=key item=managerRole}
                                <option value="{$key}">{$managerRole.name}</option>
                                 {/foreach}
                            </select>
                        </td>
                        {/if}
                    </tr>
                    
                    <tr>
                    {if $isAdmin == 1 || in_array($currentRoleName, $businessHeadArray) || in_array($currentRoleName, $channelHeadArray) || in_array($currentRoleName, $managerArray)}
                        <td scope="row" nowrap="nowrap" width="1%">
                            <label for="status">TL List:</label>
                        </td>
                        <td nowrap="nowrap" >
                            <select name="teamLeadRole[]" id="teamLeadRole"  class="multiselbox" multiple style="width:180px !important; height: 70px !important;">
                                {foreach from =$tlUserIds key=key item=teamLeadRole}
                                    <option value="{$key}">{$teamLeadRole.name}</option>
                                {/foreach}
                            </select>
                        </td>
                        {/if}
                        {if $isAdmin == 1 || in_array($currentRoleName, $businessHeadArray) || in_array($currentRoleName, $channelHeadArray) || in_array($currentRoleName, $managerArray) || in_array($currentRoleName, $teamLeadArray)}
                        <td scope="row" nowrap="nowrap" width="1%">
                            <label for="Status Description">Agent List:</label>
                        </td>
                        <td>
                            <select name="agentRole[]" id="agentRole"  class="multiselbox" multiple style="width:180px !important; height: 70px !important;">
                                {foreach from =$agentUserIds key=key item=agentRole}
                                    <option value="{$key}">{$agentRole.name}</option>
                                {/foreach}
                            </select>
                        </td>
                        {/if}
                    </tr>
                    
                    
                    {if $current_user_is_admin==1 || $additionalUsrStatus==1}
                    <tr>
                        <td scope="row" nowrap="nowrap" width="1%">
                            <label for="Source">Source:</label>
                        </td>
                        <td nowrap="nowrap" >
                            <select name="source[]" id="source"  class="multiselbox" multiple style="width:180px !important; height: 70px !important;">

                                {foreach from =$lead_source_type key=key item=type}

                                    <option value="{$key}">{$type}</option>
                                {/foreach}
                            </select>
                        </td>

                        <td scope="row" nowrap="nowrap" width="1%">
                            <label for="Lead Source Type">Lead Source Type:</label>
                        </td>
                        <td nowrap="nowrap">
                            <select name="lead_source_types[]" id="lead_source_types"  class="multiselbox" multiple style="width:180px !important; height: 70px !important;">
                                {foreach from =$lead_source_types key=key item=type} 
                                    <option value="{$key}">{$type}</option>
                                {/foreach}
                            </select>
                        </td>

                    </tr>
                    {/if}

                    <tr>
                        <td class="sumbitButtons" colspan="3">
                            <input type="hidden" value="{$current_user_is_admin}" id="is_adminx"/>
                            <input tabindex="2" title="Search" onclick="SUGAR.savedViews.setChooser();" class="button" type="submit" name="button" value="Search" id="search_form_submit">&nbsp;
                            <input tabindex="2" title="Clear" onclick="SUGAR.searchForm.clear_form(this.form);
                                    return false;" class="button" type="button" name="clear" id="search_form_clear" value="Clear">
                            {if $current_user_is_admin==1 || $additionalUsrStatus==1}
                                <input tabindex="2" title="Export" onclick="SUGAR.savedViews.setChooser();" class="button" type="submit" name="export" value="Export" id="export_form_submit">
                            {/if}
                        </td>
                    </tr>


                </tbody>
            </table>

        </div>
    </form>
    <div style="width:99%;overflow:hidden;">                       
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
                                            <a href="index.php?module=AOR_Reports&action=counsellorwisestatusdetailreport"  name="listViewStartButton" title="Start" class="button" >
                                                <img src="themes/SuiteR/images/start_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Start">
                                            </a>

                                            <a href="index.php?module=AOR_Reports&action=counsellorwisestatusdetailreport&page={$page}"  class="button" title="Previous">
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
                                            <a href="index.php?module=AOR_Reports&action=counsellorwisestatusdetailreport&page={$pagenext}"  class="button" title="Next" disabled="disabled">
                                                <img src="themes/SuiteR/images/next_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Next">
                                            </a>
                                            <a href="index.php?module=AOR_Reports&action=counsellorwisestatusdetailreport&page={$last_page}"  class="button" title="End" disabled="disabled">
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
        <table cellpadding="0" cellspacing="0" width="{$tablewidth}" border="0" class="list view table footable-loaded footable default bordered-table">


            <tr height="20">
                <th scope="col" data-hide="phone" class="footable-visible footable-first-column table-heading" colspan="4"><strong>Details</strong></th>                
                <th scope="col" data-hide="phone" class="footable-visible footable-first-column table-heading" colspan="3" ><strong>Alive</strong></th>
                <th scope="col" data-hide="phone" class="footable-visible footable-first-column table-heading" colspan="4"><strong>Converted</strong></th>
                <th scope="col" data-hide="phone" class="footable-visible footable-first-column table-heading" colspan="2"><strong>Warm</strong></th>
                <th scope="col" data-hide="phone" class="footable-visible footable-first-column table-heading" colspan="11"><strong>Dead</strong></th>
                <th scope="col" data-hide="phone" class="footable-visible footable-first-column table-heading"><strong>Re-Assigned</strong></th>
                <th scope="col" data-hide="phone" class="footable-visible footable-first-column table-heading" colspan="2"><strong>System Disposition</strong></th>
                <th scope="col" data-hide="phone" class="footable-visible footable-first-column table-heading"><strong>Recycle </strong></th>
                
            </tr>
            <tr height="20">
                <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                    <strong>Counsellor Name</strong>
                </th>
                <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                    <strong>Reporting Manager</strong>
                </th>
                
                <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                    <strong>Batch Code</strong>
                </th>
                <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                    <strong>Total</strong>
                </th>
                {foreach from = $StatusList key=key item=status}
                    <th scope="col" data-hide="phone" class="footable-visible footable-first-column"><strong>{$status}</strong></th>
                        {/foreach}

            </tr>
            {if empty($programList)}<tr class="oddListRowS1"><td align="left"  colspan="30">No Data Found.</td></tr>{/if}
            {foreach from = $programList key=key item=program}
                <tr height="20" class="oddListRowS1">

                    <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.assigned_user}</td>
                    <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.reporting_user}</td>
                    
                    <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.batch_code}</td>
                    <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column"> 
                        {if !empty($program.total)} <a href="index.php?module=AOR_Reports&action=agetnleads&show=total&batch={$program.batch_id}&lcount={$program.total}&to_date={$selected_to_date}&from_date={$selected_from_date}&assigned_user={$program.assigned_user_id}&status_date={$date_entered}" target="_blank">{$program.total}</a> {else} 0 {/if}
                        <!--{if !empty($program.total)} {$program.total} {else} 0 {/if}-->
                    </td>
                    {foreach from = $StatusList key=statuskey item=vendor}

                        <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column" style="text-align:center !important;"> 
                            {if !empty($program.$statuskey)} <a href="index.php?module=AOR_Reports&action=agetnleads&show={$statuskey}&batch={$program.batch_id}&lcount={$program.$statuskey}&to_date={$selected_to_date}&from_date={$selected_from_date}&assigned_user={$program.assigned_user_id}&status_date={$date_entered}" target="_blank">{$program.$statuskey}</a> {else} 0 {/if} 
                            <!--{if !empty($program.$statuskey)} {$program.$statuskey} {else} 0 {/if}-->
                        </td>
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

            function getAjaxChannelHeadRole(managerRole,arg) {
                $.ajax({
                    beforeSend: function (request)
                    {
                        //request.setRequestHeader("OAuth-Token", SUGAR.App.api.getOAuthToken());
                    },
                    url: "index.php?entryPoint=reportsajax",
                    data: {action: 'managerRole',arg : arg},
                    dataType: "html",
                    type: "POST",
                    async: true,
                    success: function (data) {
                        var argData = JSON.parse(data);
                        $('#' + 'managerRole').html('');
                        $('#' + 'teamLeadRole').html('');
                        $('#' + 'agentRole').html('');
                        $('#' + 'managerRole').html(argData.mgOption);
                        $('#' + 'teamLeadRole').html(argData.tlOption);
                        $('#' + 'agentRole').html(argData.agentOption);
                        $('select[multiple]').multiselect('reload');

                    }
                });
            }
            
            function getAjaxManagerRole(teamLeadRole,arg,arg1) {
                $.ajax({
                    beforeSend: function (request)
                    {
                        //request.setRequestHeader("OAuth-Token", SUGAR.App.api.getOAuthToken());
                    },
                    url: "index.php?entryPoint=reportsajax",
                    data: {action: 'teamLeadRole',arg : arg,arg1 : arg1},
                    dataType: "html",
                    type: "POST",
                    async: true,
                    success: function (data) {
                        console.log("Testjs" + data);
                        var argData = JSON.parse(data);
                        $('#' + 'teamLeadRole').html('');
                        $('#' + 'agentRole').html('');
                        $('#' + 'teamLeadRole').html(argData.tlOption);
                        $('#' + 'agentRole').html(argData.agentOption);
                        $('select[multiple]').multiselect('reload');

                    }
                });
            }
            
            function getAjaxTeamLeadRole(agentRole,arg,arg1,arg2) {
                $.ajax({
                    beforeSend: function (request)
                    {
                        //request.setRequestHeader("OAuth-Token", SUGAR.App.api.getOAuthToken());
                    },
                    url: "index.php?entryPoint=reportsajax",
                    data: {action: 'agentRole',arg : arg,arg1 : arg1,arg2 : arg2},
                    dataType: "html",
                    type: "POST",
                    async: true,
                    success: function (data) {
                        console.log("Testjs" + data);
                        var argData = JSON.parse(data);
                        $('#' + 'agentRole').html('');
                        $('#' + 'agentRole').html(argData.agentOption);
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
                
                // This is the main js function
                $("#channelHeadRole").change(function () {
                    var arg = $('#channelHeadRole').val();
                    getAjaxChannelHeadRole('managerRole', arg);
                });
                
                $("#managerRole").change(function () {
                    var arg = $('#channelHeadRole').val();
                    var arg1 = $('#managerRole').val();
                    getAjaxManagerRole('teamLeadRole',arg,arg1);
                });
                
                $("#teamLeadRole").change(function () {
                    var arg = $('#channelHeadRole').val();
                    var arg1 = $('#managerRole').val();
                    var arg2 = $('#teamLeadRole').val();
                    getAjaxTeamLeadRole('agentRole', arg,arg1,arg2);
                });
                //getStateByZone();

                $("#search_form").on('submit', (function (e) {


                    var from_date = $('#from_date').val();
                    var to_date = $('#to_date').val();
                    var batch_code = $('#batch_code').val();
                    var status = $('#status').val();
                    var month = $('#month').val();
                    var year = $('#year').val();
                    var users = $('#users').val();
                    var managers = $('#managers').val();
                    var councellors = $('#councellors').val();

                    var is_admin = $('#is_adminx').val();
                       
            
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

                    /*if(status=='' || status ==null){
                     $("#status").focus();
                     alert('Please select a Status!'); return false;
                     }*/

                    if (batch_code == '' || batch_code == null) {
                        $("#batch_code").focus();
                        alert('Please select a Batch Code!');
                        return false;
                    }

                    /*if(is_admin!=1 && (managers=='' || managers ==null)){
                     $("#manager").focus();
                     alert('Please select a Manager!'); return false;
                     }
                     
                     if(is_admin!=1 && (councellors=='' || councellors ==null)){
                     $("#councellors").focus();
                     alert('Please select a Councellor!'); return false;
                     }*/




                }));
            });
     
        </script>
    {/literal}

<section class="moduleTitle"> <h2>Add Report Access</h2><br/><br/><br/><br/><br/><br/>
    <form name="search_form" id="search_form" class="search_form" method="post" action="index.php?module=AOR_Reports&action=addreportaccess">
        <input type="hidden" name="batch_created_date" id="batch_created_date" value="{$batch_created_date}">
        <div id="te_budgeted_campaignbasic_searchSearchForm" style="" class="edit view search basic">
            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                <tbody>

                    <tr>
                        <td scope="row" nowrap="nowrap" width="1%">
                            <label for="status">Users:</label>
                        </td>
                        <td nowrap="nowrap" >
                            <select name="users[]" id="users"  class="multiselbox" multiple style="width:180px !important; height: 70px !important;">
                                {foreach from =$CouncellorsList key=key item=councellor}

                                    <option value="{$key}">{$councellor.name}</option>
                                {/foreach}
                            </select>
                        </td>

                        <td scope="row" nowrap="nowrap" width="1%">
                            <label for="Batch Status">Report Name:</label>
                        </td>
                        <td nowrap="nowrap" >
                            <input type="textbox" value="" id="report_name" name="report_name" >
                        </td>

                    </tr>


                    <tr>

                        <td scope="row" nowrap="nowrap" width="1%">
                            <label for="Batch Status">URL:</label>
                        </td>
                        <td nowrap="nowrap" >
                            <input type="textbox" value="" id="report_url" name="report_url" >
                        </td>

                   

                    </tr>





                    <tr>
                        <td class="sumbitButtons" colspan="3">
                            <input tabindex="2" title="Search" onclick="SUGAR.savedViews.setChooser();" class="button" type="submit" name="button" value="Save" id="search_form_submit">&nbsp;
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
                                        <a href="index.php?module=AOR_Reports&action=addreportaccess"  name="listViewStartButton" title="Start" class="button" >
                                            <img src="themes/SuiteR/images/start_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Start">
                                        </a>

                                        <a href="index.php?module=AOR_Reports&action=addreportaccess&page={$page}"  class="button" title="Previous">
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
                                        <a href="index.php?module=AOR_Reports&action=addreportaccess&page={$pagenext}"  class="button" title="Next" disabled="disabled">
                                            <img src="themes/SuiteR/images/next_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Next">
                                        </a>
                                        <a href="index.php?module=AOR_Reports&action=addreportaccess&page={$last_page}"  class="button" title="End" disabled="disabled">
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
                    <strong>User Name</strong>
                </th>

                <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                    <strong>Module Name</strong>
                </th>

                <th scope="col" data-hide="phone" class="footable-visible footable-first-column" colspan="2">
                    <strong>Report Name</strong>
                </th>

                <th scope="col" data-hide="phone" class="footable-visible footable-first-column" colspan="2">
                    <strong>Action Name</strong>
                </th>

                <th scope="col" data-hide="phone" class="footable-visible footable-first-column" colspan="1">
                    <strong>Action</strong>
                </th>
            </tr>   

            {*{if isset($error) && !empty($error)}  
            <td align="center" class="inlineEdit footable-visible footable-last-column"><h1>{$error.error}</h1></td>
            {/if}*}

            {foreach from = $leadList key=key item=leads}
                <tr height="20" class="oddListRowS1" id="Myrow_{$key}">

                    <td  align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$leads.assigned_user_email}</td>

                    <td  align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$leads.module_name}</td>
                    <td  align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column"></td>
                    <td  align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$leads.report_name}</td>

                    <td  align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$leads.report_action}</td>
                    <td  align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column"></td>

                    <td  align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column"><a href="javascript:void(0)" onclick='deleteItem("{$leads.id}", "Myrow_{$key}")'>Delete</a></td>

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
            function deleteItem(RecordID, RowID)
            {
                if (confirm("Are you sure you want to delete?")) {

                    $.ajax({
                        beforeSend: function (request)
                        {
                            //request.setRequestHeader("OAuth-Token", SUGAR.App.api.getOAuthToken());
                        },
                        url: "index.php?entryPoint=reportaccessajax",
                        data: {action: 'DeleteRrepotAccessRepo', RecordID: RecordID, RowID: RowID},
                        dataType: "html",
                        type: "POST",
                        async: true,
                        success: function (data) {
                            $('#' + data).html('');
                        }
                    });

                }
                return false;
            }

            $(document).ready(function () {

                $("#search_form").on('submit', (function (e) {

                    var users = $('#users').val();
                    var report_name = $('#report_name').val();
                    var report_url = $('#report_url').val();
                    

                    if (users == '' || users == null) {
                        $("#users").focus();
                        alert('Please select a user!');
                        return false;
                    } else if (report_name == '') {
                        $("#report_name").focus();
                        alert('Please select a report_name!');
                        return false;
                    } else if (report_url == '') {
                        $("#report_url").focus();
                        
                        alert('Please fill the report_url!');
                        return false;
                    }

                }));



            });


        </script>




    {/literal}


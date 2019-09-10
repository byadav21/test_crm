<section class="moduleTitle"> <h2>View Leads</h2><br/><br/>
    {if $current_user_is_admin==1 || $additionalUsrStatus==1}
        <form name="search_form" id="search_form" class="search_form" method="post" action="">
            <div id="te_budgeted_campaignbasic_searchSearchForm" style="" class="edit view search basic">
                <table width="100%" cellspacing="0" cellpadding="0" border="0">
                    <tbody>
                        <tr>
                            <td class="sumbitButtons" colspan="3">
                                <input tabindex="2" title="Export" onclick="SUGAR.savedViews.setChooser();" class="button" type="submit" name="export" value="Export" id="export_form_submit">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </form>
    {/if}                  
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
                                            <a href="index.php?module=AOR_Reports&action=agetnleads"  name="listViewStartButton" title="Start" class="button" >
                                                <img src="themes/SuiteR/images/start_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Start">
                                            </a>

                                            <a href="index.php?module=AOR_Reports&action=agetnleads&show=total&batch={$batch_id}&lcount={$lcount}&to_date={$to_date}&from_date={$from_date}&assigned_user={$assigned_user}&page={$page}"  class="button" title="Previous">
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
                                            <a href="index.php?module=AOR_Reports&action=agetnleads&show=total&batch={$batch_id}&lcount={$lcount}&to_date={$to_date}&from_date={$from_date}&assigned_user={$assigned_user}&page={$pagenext}"  class="button" title="Next" disabled="disabled">
                                                <img src="themes/SuiteR/images/next_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Next">
                                            </a>
                                            <a href="index.php?module=AOR_Reports&action=agetnleads&show=total&batch={$batch_id}&lcount={$lcount}&to_date={$to_date}&from_date={$from_date}&assigned_user={$assigned_user}&page={$last_page}"  class="button" title="End" disabled="disabled">
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
        </table>
    </div>
    <div style="width:99%;overflow:auto;border:2px dashed #d0d0d0;" class="div-leads-list">                          
        <table cellpadding="0" cellspacing="0" width="{$tablewidth}" border="0" class="list view table footable-loaded footable default">

            <tr height="20">
                {foreach from = $ExcelHeaders key=key item=column}
                    <th scope="col" data-hide="phone" class="footable-visible footable-first-column"><strong>{$column}</strong></th>
                 {/foreach}
            </tr>  

            {foreach from = $leadList key=key item=program}
                <tr height="20" class="oddListRowS1">
                    {foreach from =$program key=key item=val}
                        <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$val}</td>
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
            });


        </script>




    {/literal}


<section class="moduleTitle"> 
    <form name="search_form" id="search_form" class="search_form" method="post" action="index.php?module=AOR_Reports&action=srmstudentlist">
        <input type="hidden" name="batch_created_date" id="batch_created_date" value="{$batch_created_date}">
        <div id="te_budgeted_campaignbasic_searchSearchForm" style="" class="edit view search basic">
            <h2>Search Student Report:</h2><br><br><br>
            <div class = "block-wrapper marginTop15">
                <div class = "block">
                    <label>Select Institute : </label>
                    <select name="institute_dropdown" id="institute_dropdown"  class="" style="">
                        <option value="">-Select-</option>
                        {foreach from =$getInstituteDropData key=key item=program}
                            <option value="{$program.id}" {if $program.id==$selected_institute_dropdown} selected="selected"{/if}>{$program.name}</option>
                        {/foreach}
                    </select>

                </div>
                <div class = "block">
                    <label>Select Program : </label>
                    <select name="program_dropdown" id="program_dropdown"  class=""  style="">
                        <option value="">-Select-</option>

                    </select>
                </div>
                <div class = "block">
                    <label>Select Batch : </label>
                    <select name="batch_dropdown" id="batch_dropdown"  class=""  style="">
                        <option value="">-Select-</option>
                    </select>
                </div>


            </div>


            <div class = "block-wrapper marginTop15">
                <div class = "block">
                    <label>Student Status : </label>
                    <select name="student_status_dropdown" id="student_status_dropdown"  class="" style="">
                        <option value="">-Select-</option>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                        <option value="Dropout">Dropout</option>
                        <option value="Inactive_transfer">Inactive transfer</option>
                        <option value="BT_Parking">BT Parking</option>
                    </select>

                </div>
                <div class = "block">
                    <label>Dropout Type : </label>
                    <select name="dropout_type_dropdown" id="dropout_type_dropdown"  class="" style="">
                        <label>Dropout Type: </label>
                        <option value="">-Select-</option>
                        <option value="pre_dropout">Pre Dropout</option>
                        <option value="post_dropout">Post Dropout</option>
                    </select>
                </div>
            </div>

            <div class = "block-wrapper marginTop15">
                <div class = "block">
                    <label>Name : </label>
                    <input type="text" value="" id="student_name" name="student_name" >

                </div>
                <div class = "block">
                    <label>Email: </label>
                    <input type="text" value="" id="student_email" name="student_email" >
                </div>
                <div class = "block">
                    <label>Mobile : </label>
                    <input type="text" value="" id="student_mobile" name="student_mobile" >
                </div>


            </div>
            <div class = "action-block">
                <input tabindex="2" title="Search" onclick="SUGAR.savedViews.setChooser();" class="button" type="submit" name="button" value="Search" id="search_form_submit">
                <input tabindex="2" title="Clear" onclick="SUGAR.searchForm.clear_form(this.form);
                        return false;" class="button" type="button" name="clear" id="search_form_clear" value="Clear">
                <input tabindex="2" title="Export" onclick="SUGAR.savedViews.setChooser();" class="button" type="submit" name="export" value="Export" id="export_form_submit">
            </div>

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
                                            <a href="index.php?module=AOR_Reports&action=srmstudentlist"  name="listViewStartButton" title="Start" class="button" >
                                                <img src="themes/SuiteR/images/start_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Start">
                                            </a>

                                            <a href="index.php?module=AOR_Reports&action=srmstudentlist&page={$page}"  class="button" title="Previous">
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
                                            <a href="index.php?module=AOR_Reports&action=srmstudentlist&page={$pagenext}"  class="button" title="Next" disabled="disabled">
                                                <img src="themes/SuiteR/images/next_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Next">
                                            </a>
                                            <a href="index.php?module=AOR_Reports&action=srmstudentlist&page={$last_page}"  class="button" title="End" disabled="disabled">
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
            {if empty($leadList)}<tr class="oddListRowS1"><td align="left"  colspan="30">No Data Found.</td></tr>{/if}
            {foreach from = $leadList key=key item=program}
                <tr height="20" class="oddListRowS1">
                    {foreach from = $StatusList key=statuskey item=vendor}
                        <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column"> {if !empty($program.$statuskey)} {$program.$statuskey} {else} NA {/if} </td>
                    {/foreach}
                </tr>
            {/foreach}


        </table>
    </div>
    {literal}
        <style>
            .modal-dialog{width:700px;}
            select{width:100%!important}
            textarea{width:100%!important; resize:none; height:90px;border-radius: 5px;}
            .marginTopBottom15{margin:15px 0;}
            .marginTop15{margin:15px 0 0;}
            .block-wrapper{display:flex; width:100%; padding:0 9px}
            .block{display:flex; flex-direction: column; margin-left: 15px; width:100%;}
            .block:first-child{margin-left:0px}
            .block-wrapper label{margin:0 15px 5px 0; display: flex; align-items: center;}
            .block div{display:flex; margin-bottom: 10px; align-items: flex-start;}
            .block div label{display:flex; margin-right:10px;}
            .block-wrapper input[type="radio"]{margin:0 5px 0 0;}
            .modal-title{margin-bottom:10px;}
            .borderWidthPadding{border:1px solid #ddd; padding:5px;}
            .action-block{display: flex; align-items: flex-end; justify-content: flex-end; margin:20px 0; padding: 0 9px;}
        </style>
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


                $("#institute_dropdown").change(function () {
                    var InstID = $('#institute_dropdown').val();
                    getAjax('program_dropdown', InstID);
                });

                $("#program_dropdown").change(function () {
                    var proID = $('#program_dropdown').val();
                    getAjax('batch_dropdown', proID);
                });

                $("#search_form").on('submit', function (e) {

                    var institute_dropdown = $('#institute_dropdown').val();
                    var program_dropdown = $('#program_dropdown').val();
                    var batch_dropdown = $('#batch_dropdown').val();


                    /*if (institute_dropdown == '') {

                        alert("Please select an Institute.");
                        return false;
                    } else if (program_dropdown == '') {
                        alert("Please select a Program.");
                        return false;
                    } else if (batch_dropdown == '') {
                        alert("Please select a Batch.");
                        return false;
                    }*/

                });

            });


            function getAjax(target, id) {
                $.ajax({
                    beforeSend: function (request)
                    {
                        //request.setRequestHeader("OAuth-Token", SUGAR.App.api.getOAuthToken());
                    },
                    url: "index.php?entryPoint=srmajax",
                    data: {action: target, ID: id},
                    dataType: "html",
                    type: "POST",
                    async: true,
                    success: function (data) {
                        //alert(data)
                        $('#' + target).html('');
                        $('#' + target).html(data);

                    }
                });
            }


        </script>
    {/literal}

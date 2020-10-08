<section class="moduleTitle"> 

    <form name="search_form" id="search_form" class="search_form" method="post" action="index.php?module=AOR_Reports&action=prospectdashboard">
        <input type="hidden" name="batch_created_date" id="batch_created_date" value="{$batch_created_date}">

        <div id="te_budgeted_campaignbasic_searchSearchForm" style="" class="edit view search basic">
            <h2>Prospect dashboard:</h2> &nbsp;&nbsp;<a href="index.php?module=AOR_Reports&action=prospectdashboard2" class="button">BLOCK 2</a><br><br><br>
            <div class = "block-wrapper marginTop15">
                <div class = "block">
                    <label>Date: </label>
                    <input name="from_date" type="text"  value="{$selected_from_date}" id='from_date'/>
                    <img src="themes/SuiteP/images/jscalendar.gif?v=yt-yazfsU-Y9uR7ixqf7Lg" alt="Enter Date" style="" border="0" id="from_date_trigger">

                </div>
                {*<div class = "block">
                    <label>Manager : </label>
                    <select name="managers[]" id="managers"  class="multiselbox" multiple style="width:180px !important; height: 70px !important;">
                        {foreach from =$managerSList key=key item=managers}

                            <option value="{$key}"{if in_array($key, $selected_managers)} selected="selected"{/if}>{$managers.name}</option>
                        {/foreach}
                    </select>
                </div>
                <div class = "block">
                    <label>Agent : </label>
                    <select name="councellors[]" id="councellors"  class="multiselbox" multiple style="width:180px !important; height: 70px !important;">
                        {foreach from =$CouncellorsList key=key item=councellor}

                            <option value="{$key}"{if in_array($key, $selected_councellors)} selected="selected"{/if}>{$councellor.name}</option>
                        {/foreach}
                    </select>
                </div>*}
                
                
                {if $isAdmin == 1 || in_array($currentRoleName, $businessHeadArray)}
                            <div class = "block">
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
                        </div>
                        {/if}
                        {if $isAdmin == 1 || in_array($currentRoleName, $businessHeadArray) || in_array($currentRoleName, $channelHeadArray)}
                        <div class = "block">
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
                        </div>
                        {/if}
                    
                    
                    
                    {if $isAdmin == 1 || in_array($currentRoleName, $businessHeadArray) || in_array($currentRoleName, $channelHeadArray) || in_array($currentRoleName, $managerArray)}
                        <div class = "block">
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
                        </div>
                        {/if}
                        
                        {if $isAdmin == 1 || in_array($currentRoleName, $businessHeadArray) || in_array($currentRoleName, $channelHeadArray) || in_array($currentRoleName, $managerArray) || in_array($currentRoleName, $agentArray)}
                        <div class = "block">
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
                   </div>

            </div>
            <div class = "action-block">
                <input tabindex="2" title="Search" onclick="SUGAR.savedViews.setChooser();" class="button" type="submit" name="button" value="Search" id="search_form_submit">


                <input tabindex="2" title="Clear" onclick="SUGAR.searchForm.clear_form(this.form);
                        return false;" class="button" type="button" name="clear" id="search_form_clear" value="Clear">



            </div>

        </div>
    </form>





    <div class="lead-report-table">             

        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="paginationTable">  
            <thead>
                {*Start Pagination*}
                <tr id="pagination" role="presentation">
                    <td colspan="20">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="paginationTable">
                            <tbody>
                                <tr>
                                    <td nowrap="nowrap" class="paginationActionButtons">&nbsp;</td>

                                    <td nowrap="nowrap" align="right" class="paginationChangeButtons" width="1%">

                                        {if $left eq 1}
                                            <a href="index.php?module=AOR_Reports&action=prospectdashboard"  name="listViewStartButton" title="Start" class="button" >
                                                <img src="themes/SuiteR/images/start_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Start">
                                            </a>

                                            <a href="index.php?module=AOR_Reports&action=prospectdashboard&page={$page}"  class="button" title="Previous">
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
                                            <a href="index.php?module=AOR_Reports&action=prospectdashboard&page={$pagenext}"  class="button" title="Next" disabled="disabled">
                                                <img src="themes/SuiteR/images/next_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Next">
                                            </a>
                                            <a href="index.php?module=AOR_Reports&action=prospectdashboard&page={$last_page}"  class="button" title="End" disabled="disabled">
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


                <tr>
                    <th class="column1" valign="middle">Counsellor Email</th>
                    <th class="column1" valign="middle">Counsellor Name</th>
                    <th class="column2">
                        <table cellpadding="0" cellspacing="0" border="0" class="table1">
                            <tr>
                                <th colspan="2">Month to date</th>
                            </tr>
                            <tr>

                                <th>
                                    <table cellpadding="0" cellspacing="0" border="0" class="table2">	

                                        <tr>
                                            <th>Revenue</th>
                                            <th>Number of<br> 
                                                admissions</th>
                                        </tr>
                                    </table>	
                                </th>

                            </tr>
                        </table>
                    </th>

                    <th class="column2">
                        <table cellpadding="0" cellspacing="0" border="0" class="table1">
                            <tr>
                                <th colspan="2">{$selected_from_date}</th>
                            </tr>
                            <tr>

                                <th>
                                    <table cellpadding="0" cellspacing="0" border="0" class="table2">	
                                        <tr>
                                            <th>Revenue</th>
                                            <th>Number of<br> 
                                                admissions</th>
                                        </tr>
                                    </table>	
                                </th>

                            </tr>
                        </table>
                    </th>
                </tr>  
            </thead>




            {if empty($theFInalArray)}
                <tr><td colspan="8">Data Not Found.</td></tr>
            {/if}
            {foreach from = $theFInalArray key=key item=value}

                <tr>
                    <td class="column1" valign="middle" style="width:170px; word-break: break-word;">{$key}</td>
                    <td class="column1" valign="middle" style="width:170px; word-break: break-word;">{$value.Agent_Name}</td>
                    <td class="column2">
                        <table cellpadding="0" cellspacing="0" border="0" class="table1">
                            <tr>


                                <td>
                                    <table cellpadding="0" cellspacing="0" border="0" class="table2">	
                                        <tr>
                                            <td style="width:54px;">



                                                {if $value.monthly_revenue == 'true'}
                                                    <i class="fa fa-check" aria-hidden="true" style="font-size:28px;color:green;cursor: pointer;" onclick="getTooltip('monthly_revenue_{$value.Agent_ID}', '{$value.monthly_revenue_tooltip}')"></i>
                                                {else}
                                                    <i class="fa fa-times" aria-hidden="true" style="font-size:28px;color:red;cursor: pointer;" onclick="getTooltip('monthly_revenue_{$value.Agent_ID}', '{$value.monthly_revenue_tooltip}')"></i>
                                                {/if}

                                            </td>
                                            <td style="width:56px;">

                                                {if $value.monthly_admission == 'true'}
                                                    <i class="fa fa-check" aria-hidden="true" style="font-size:28px;color:green;cursor: pointer;" onclick="getTooltip('monthly_admission_{$value.Agent_ID}', '{$value.monthly_admission_tooltip}')"></i>
                                                {else}
                                                    <i class="fa fa-times" aria-hidden="true" style="font-size:28px;color:red;cursor: pointer;" onclick="getTooltip('monthly_admission_{$value.Agent_ID}', '{$value.monthly_admission_tooltip}')"></i>
                                                {/if}

                                            </td>
                                        </tr>
                                    </table>	
                                </td>

                            </tr>
                        </table>
                    </td>

                    <td class="column2">
                        <table cellpadding="0" cellspacing="0" border="0" class="table1">
                            <tr>


                                <td>
                                    <table cellpadding="0" cellspacing="0" border="0" class="table2">	
                                        <tr>



                                            <td style="width:54px;">



                                                {if $value.daywise_revenue == 'true'}
                                                    <i class="fa fa-check" aria-hidden="true" style="font-size:28px;color:green;cursor: pointer;" onclick="getTooltip('daywise_revenue_{$value.Agent_ID}', '{$value.daywise_revenue_tooltip}')"></i>
                                                {else}
                                                    <i class="fa fa-times" aria-hidden="true" style="font-size:28px;color:red;cursor: pointer;" onclick="getTooltip('daywise_revenue_{$value.Agent_ID}', '{$value.daywise_revenue_tooltip}')"></i>
                                                {/if}


                                            </td>
                                            <td style="width:56px;">

                                                {if $value.daywise_admission == 'true'}
                                                    <i class="fa fa-check" aria-hidden="true" style="font-size:28px;color:green;cursor: pointer;" onclick="getTooltip('daywise_admission_{$value.Agent_ID}', '{$value.daywise_admission_tooltip}')"></i>
                                                {else}
                                                    <i class="fa fa-times" aria-hidden="true" style="font-size:28px;color:red;cursor: pointer;" onclick="getTooltip('daywise_admission_{$value.Agent_ID}', '{$value.daywise_admission_tooltip}')"></i>
                                                {/if}



                                            </td>
                                        </tr>
                                    </table>	
                                </td>

                            </tr>
                        </table>
                    </td>
                </tr>



            {/foreach}






        </table>

        <!-- Modal HTML -->
        <div id="tooltipModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">×</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">
                            Target Status
                        </h4>
                    </div>
                    <div class="modal-body">
                        <span id="messagex"></span>

                    </div>                
                </div>
            </div>
        </div>

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

            function getTooltip(id, desc) {
                //alert(id);
                $("#messagex").html(desc);
                $('#tooltipModal').modal('show', {
                    backdrop: 'static',
                    keyboard: false,
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


                $("#search_form").on('submit', (function (e) {


                    var batch_code = $('#batch_code').val();
                    var status = $('#status').val();
                    var month = $('#month').val();
                    var year = $('#year').val();
                    var users = $('#users').val();
                    var managers = $('#managers').val();
                    var councellors = $('#agentRole').val();


                    if (from_date == '' || from_date == null) {
                     $("#from_date").focus();
                     alert('Please select a Date!');
                     return false;
                     }
                    /*if(managers=='' || managers ==null){
                     $("#users").focus();
                     alert('Please select a Manager!'); return false;
                     }*/
                     /*if(councellors=='' || councellors ==null){
                     $("#users").focus();
                     alert('Please select a councellor!'); return false;
                     }*/

                    /*if (month == '' || month == null) {
                     $("#month").focus();
                     alert('Please select a month!');
                     return false;
                     }
                     
                     if (year == '' || year == null) {
                     $("#year").focus();
                     alert('Please select a year!');
                     return false;
                     }
                     
                     
                     
                     if((managers=='' || managers ==null) && (councellors=='' || councellors ==null)){
                     $("#users").focus();
                     alert('Please select a user!'); return false;
                     }*/



                }));
            });
            
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
                        console.log("Okkk"+ data)
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


        </script>

        <style>
            
            .lead-report-table{display: flex; flex-direction: column; width: 100%; overflow-x: auto;}
            .lead-report-table table{width: 100%;  border-style: hidden; height: 100%; border:0px solid #000;  border-collapse: collapse; border-spacing: 0;}
            .lead-report-table .table1 tr:first-child th{height:30px;}
            .lead-report-table .table2 tr:last-child th{height:30px;}
            .lead-report-table .table1 tr:first-child td{height:30px;}
            .lead-report-table .table2 tr:last-child td{height:30px;}
            .lead-report-table .total-value{width:100px;}
            .lead-report-table table {border:0px solid #000; font-weight: normal;}
            .lead-report-table th{color:#000; border: 1px solid #000; font-weight: normal;}
            .lead-report-table td{color:#808080; border: 1px solid #000; font-weight: normal; text-align: center;}

            .lead-report-table .table2{border:0px none;}
            .lead-report-table .table1 th{border-left:0px none; border-top:0px none;}
            .lead-report-table .table1 th:last-child{border-right: 0px solid transparent;}
            .lead-report-table .table1 tr:last-child th{border-bottom:0px none;}
            .lead-report-table .table1 tr:last-child th .table2 tr:first-child th:first-child{border-bottom:1px solid #000;}
            .lead-report-table .table2 tr:last-child th:first-child{border-right:1px solid #000;}
            .lead-report-table .table2 th{border-left:0px none; border-right:0px none; border-top:0px none;}
            .lead-report-table .table2  tr:last-child th{border-left:0px none; border-bottom:0px none; border-right:0px none; border-top:0px none;}

            .lead-report-table .table1 td{border-left:0px none; border-bottom:0px none; text-align: center; border-top:0px none;}
            .lead-report-table .table1 td:last-child{border-right: 0px;}
            .lead-report-table .table2 td{border-left:0px none; border-right:0px none; border-top:0px none;}
            .lead-report-table .table2 tr:last-child td{border-left:0px none; border-bottom:0px none; border-right:0px none; border-top:0px none;}
            .lead-report-table .table2 tr:last-child td:last-child{border-left:1px solid #000;}	
            .lead-report-table td.paginationChangeButtons,
            .lead-report-table td.paginationActionButtons {
                background: #3c8dbc;
            }
            .lead-report-table th {
                background: #2a3f54;
                color: #fff !important;
                font-weight: 600 !important;
                border-color: #f7f7f7 !important;
            }
            .lead-report-table .table1 tr:last-child th .table2 tr:first-child th:first-child{
                border-bottom: 1px solid #fff;
                width: 50%;
            }
            .lead-report-table .table2 tr:last-child td{
                width: 50% !important;
            }
            #pagination .button {
                padding: 4px 8px;
                background: #2a3f54;
            }
            .lead-report-table td {
                color: #2a3f54;
                border: 1px solid #2a3f54;
                font-weight: normal;
                text-align: center;
            }
            .lead-report-table #pagination .pageNumbers{
                color: #fff;
            }


            .tooltip {
                position: relative;
                display: inline-block;
                border-bottom: 1px dotted black;
            }

            .tooltip .tooltiptext {
                visibility: hidden;
                width: 120px;
                background-color: black;
                color: #fff;
                text-align: center;
                border-radius: 6px;
                padding: 5px 0;

                /* Position the tooltip */
                position: absolute;
                z-index: 1;
                bottom: 100%;
                left: 50%;
                margin-left: -60px;
            }

            .tooltip:hover .tooltiptext {
                visibility: visible;
            }
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

.block{
    position: relative;
}
input#from_date {
    width: 100% !important;
}
img#from_date_trigger {
    position: absolute;
    top: 28px;
    right: 15px;
    width: 20px;
}
.ms-options-wrap {
    width: auto;
    max-width: 300px;

}
.ms-options-wrap > .ms-options{
    flex-direction: column;
        width: 90%;
}

        </style>


    {/literal}


<section class="moduleTitle"> <h2>Agent dashboard Report</h2><br/><br/><br/><br/><br/>

    <form name="search_form" id="search_form" class="search_form" method="post" action="index.php?module=AOR_Reports&action=agentdashboardreport">
        <input type="hidden" name="batch_created_date" id="batch_created_date" value="{$batch_created_date}">
        <div id="te_budgeted_campaignbasic_searchSearchForm" style="" class="edit view search basic">
            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                <tbody>

                    <tr>
                        <td scope="row" nowrap="nowrap" width="1%">
                            <label for="From Date">Month:</label>
                        </td>
                        <td nowrap="nowrap" >
                            <select name="month" id="month"  >
                                {foreach from =$month key=key item=value}
                                    <option value="{$key}" {if ($key==$selected_month)} selected="selected"{/if}>{$value}</option>
                                {/foreach}
                            </select>
                        </td>
                        <td scope="row" nowrap="nowrap" width="1%">
                            <label for="To Date">Year:</label>
                        </td>
                        <td nowrap="nowrap" >
                            <select name="years" id="year"  >
                                {foreach from =$years key=key item=value}
                                    <option value="{$key}" {if ($key==$selected_years)} selected="selected"{/if}>{$value}</option>
                                {/foreach}
                            </select>
                        </td>
                    </tr>
                  <!-- {*  <tr>

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

                    </tr>*} -->
                    
                    <!-- {* if $userSlug!='CCC'}
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
                {/if *} -->

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

<!-- ===========New Filter=========== -->



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
                                            <a href="index.php?module=AOR_Reports&action=agentdashboardreport"  name="listViewStartButton" title="Start" class="button" >
                                                <img src="themes/SuiteR/images/start_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Start">
                                            </a>

                                            <a href="index.php?module=AOR_Reports&action=agentdashboardreport&page={$page}"  class="button" title="Previous">
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
                                            <a href="index.php?module=AOR_Reports&action=agentdashboardreport&page={$pagenext}"  class="button" title="Next" disabled="disabled">
                                                <img src="themes/SuiteR/images/next_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Next">
                                            </a>
                                            <a href="index.php?module=AOR_Reports&action=agentdashboardreport&page={$last_page}"  class="button" title="End" disabled="disabled">
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
							<th colspan="5">Month to date</th>
						</tr>
						<tr>
							<th class="total-value">Total connected</th>
							<th>
								<table cellpadding="0" cellspacing="0" border="0" class="table2">	
									<tr>
										<th colspan="2">Pitched</th>
									</tr>
									<tr>
										<th>Target</th>
										<th>Actual</th>
									</tr>
								</table>	
							</th>
							<th>
								<table cellpadding="0" cellspacing="0" border="0" class="table2">	
									<tr>
										<th colspan="2">Prospects</th>
									</tr>
									<tr>
										<th>Target</th>
										<th>Actual</th>
									</tr>
								</table>	
							</th>
							<th>
								<table cellpadding="0" cellspacing="0" border="0" class="table2">	
									<tr>
										<th colspan="2">Converts</th>
									</tr>
									<tr>
										<th>Target</th>
										<th>Actual</th>
									</tr>
								</table>	
							</th>
                                                        <th>
								<table cellpadding="0" cellspacing="0" border="0" class="table2">	
									<tr>
										<th colspan="2">Follow Up</th>
									</tr>
									<tr>
										<th>Target</th>
										<th>Actual</th>
									</tr>
								</table>	
							</th>
						</tr>
					</table>
				</th>
				<th class="column3">
					<table cellpadding="0" cellspacing="0" border="0" class="table1">
						<tr>
							<th colspan="4">Yesterday</th>
						</tr>
						<tr>
							<th>Pitched</th>
							<th>Prospects</th>
							<th>Converts</th>
                                                        <th>Follow Up</th>
						</tr>
					</table>
				</th>
				<th class="column4">
					<table cellpadding="0" cellspacing="0" border="0" class="table1">
						<tr>
							<th colspan="4">Today</th>
						</tr>
						<tr>
							<th>Pitched</th>
							<th>Prospects</th>
							<th>Converts</th>
                                                        <th>Follow Up</th>
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
							<td class="total-value">{$value.total_connected_calls}</td>
							<td>
								<table cellpadding="0" cellspacing="0" border="0" class="table2">	
									<tr>
										<td style="width:54px;">{$value.target_pitched}</td>
										<td style="width:56px;">{$value.actual_pitched}</td>
									</tr>
								</table>	
							</td>
							<td>
								<table cellpadding="0" cellspacing="0" border="0" class="table2">	
									<tr>
										<td style="width:54px;">{$value.target_prospect}</td>
										<td style="width:56px;">{$value.actual_prospect}</td>
									</tr>
								</table>	
							</td>
							<td>
								<table cellpadding="0" cellspacing="0" border="0" class="table2">	
									<tr>
										<td style="width:54px;">{$value.target_converts}</td>
										<td style="width:56px;">{$value.actual_converts}</td>
									</tr>
								</table>	
							</td>
                                                        <td>
								<table cellpadding="0" cellspacing="0" border="0" class="table2">	
									<tr>
										<td style="width:54px;">{$value.target_follow_up}</td>
										<td style="width:56px;">{$value.actual_follow_up}</td>
									</tr>
								</table>	
							</td>
						</tr>
					</table>
				</td>
				<td class="column3">
					<table cellpadding="0" cellspacing="0" border="0" border="0" class="table1">
						<tr>
							<td style="width:54px">{$value.yesterday_pitched}</td>
							<td style="width:72px">{$value.yesterday_prospect}</td>
							<td style="width:67px">{$value.yesterday_converts}</td>
                                                        <td style="width:67px">{$value.yesterday_follow_up}</td>
						</tr>
					</table>
				</td>
				<td class="column4">
					<table cellpadding="0" cellspacing="0" border="0" border="0" class="table1">
						<tr>
							<td style="width:54px">{$value.today_pitched}</td>
							<td style="width:72px">{$value.today_prospect}</td>
							<td style="width:67px">{$value.today_converts}</td>
                                                        <td style="width:67px">{$value.today_follow_up}</td>
						</tr>
					</table>
				</td>
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
            // =======New filter===========
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
            // =======New filter===========


            $(document).ready(function () {

                $("#status").change(function () {
                    var arg = $('#status').val();
                    getAjax('batch_code', arg);
                });
                $("#managers").change(function () {
                    var arg = $('#managers').val();
                    getAjax('councellors', arg);
                });
                // =======New filter===========
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
                // =======New filter===========
                
                $("#search_form").on('submit', (function (e) {

                    var batch_code = $('#batch_code').val();
                    var status = $('#status').val();
                    var month = $('#month').val();
                    var year = $('#year').val();
                    var users = $('#users').val();
                    var managers = $('#managers').val();
                    var councellors = $('#councellors').val();

                    var is_admin = $('#is_adminx').val();

                    if (month == '' || month == null) {
                        $("#month").focus();
                        alert('Please select a month!');
                        return false;
                    }

                    if (year == '' || year == null) {
                        $("#year").focus();
                        alert('Please select a year!');
                        return false;
                    }

                }));
            });

        </script>

        <style>
       .paginationTable{min-width:1400px;}     
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

        </style>


    {/literal}


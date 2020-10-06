<section class="moduleTitle"> 

    <form name="search_form" id="search_form" class="search_form" method="post" action="index.php?module=AOR_Reports&action=prospectdashboard2">
        <input type="hidden" name="batch_created_date" id="batch_created_date" value="{$batch_created_date}">

        <div id="te_budgeted_campaignbasic_searchSearchForm" style="" class="edit view search basic">
            <h2>Prospect dashboard:</h2> &nbsp;&nbsp;<a href="index.php?module=AOR_Reports&action=prospectdashboard" class="button">BLOCK 1</a><br><br><br>
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
                                    <option value="{$key}"{if in_array($key, $selected_channelHeadRole)} selected="selected"{/if}>{$channelHeadRole.name}</option>
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
                                <option value="{$key}"{if in_array($key, $selected_managerRole)} selected="selected"{/if}>{$managerRole.name}</option>
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
                                    <option value="{$key}"{if in_array($key, $selected_teamLeadRole)} selected="selected"{/if}>{$teamLeadRole.name}</option>
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
                                    <option value="{$key}"{if in_array($key, $selected_agentRole)} selected="selected"{/if}>{$agentRole.name}</option>
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
                                            <a href="index.php?module=AOR_Reports&action=prospectdashboard2"  name="listViewStartButton" title="Start" class="button" >
                                                <img src="themes/SuiteR/images/start_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Start">
                                            </a>

                                            <a href="index.php?module=AOR_Reports&action=prospectdashboard2&page={$page}"  class="button" title="Previous">
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
                                            <a href="index.php?module=AOR_Reports&action=prospectdashboard2&page={$pagenext}"  class="button" title="Next" disabled="disabled">
                                                <img src="themes/SuiteR/images/next_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Next">
                                            </a>
                                            <a href="index.php?module=AOR_Reports&action=prospectdashboard2&page={$last_page}"  class="button" title="End" disabled="disabled">
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
                    <th class="column1" valign="middle">Counsellor Name  </th>
                    <th class="column2">
                        <table cellpadding="0" cellspacing="0" border="0" class="table1">
                            <tr>
                                <th colspan="3">Prospects</th>
                            </tr>
                            <tr>

                                <th>
                                    <table cellpadding="2" cellspacing="0" border="0" class="">	

                                        <tr>
                                            <th>PTP</th>
                                            <th>Month</th>
                                            <th>Date</th>
                                        </tr>
                                    </table>	
                                </th>

                            </tr>
                        </table>
                    </th>
                   {* <th class="column2">
                        <table cellpadding="0" cellspacing="0" border="0" class="table1">
                            <tr>
                                <th colspan="2">Prospects</th>
                            </tr>
                            <tr>

                                <th>
                                    <table cellpadding="0" cellspacing="0" border="0" class="table2">	

                                        <tr>
                                            <th>Month</th>
                                            <th>Date</th>
                                        </tr>
                                    </table>	
                                </th>

                            </tr>
                        </table>
                    </th>*}
                    <th class="column2">
                        <table cellpadding="0" cellspacing="0" border="0" class="table1">
                            <tr>
                                <th colspan="2">Number of connected Calls</th>
                            </tr>
                            <tr>

                                <th>
                                    <table cellpadding="0" cellspacing="0" border="0" class="table2">	

                                        <tr>
                                            <th>Month</th>
                                            <th>Date</th>
                                        </tr>
                                    </table>	
                                </th>

                            </tr>
                        </table>
                    </th>

                    <th class="column2">
                        <table cellpadding="0" cellspacing="0" border="0" class="table1">
                            <tr>
                                <th colspan="2">Talk Time</th>
                            </tr>
                            <tr>

                                <th>
                                    <table cellpadding="0" cellspacing="0" border="0" class="table2">	

                                        <tr>
                                            <th>Month</th>
                                            <th>Date</th>
                                        </tr>
                                    </table>	
                                </th>

                            </tr>
                        </table>
                    </th>
                    <th class="column2">
                        <table cellpadding="0" cellspacing="0" border="0" class="table1">
                            <tr>
                                <th colspan="2">Conversion</th>
                            </tr>
                            <tr>

                                <th>
                                    <table cellpadding="0" cellspacing="0" border="0" class="table2">	

                                        <tr>
                                            <th>Month</th>
                                            <th>Week</th>
                                        </tr>
                                    </table>	
                                </th>

                            </tr>
                        </table>
                    </th>
                    <th class="column1" valign="middle">Call Quality Score</th>
                    <th class="column1" valign="middle">Action Item</th>
                </tr>  
            </thead>




            {if empty($theFInalArray)}
                <tr><td colspan="9">Data Not Found.</td></tr>
            {/if}
            {foreach from = $theFInalArray key=key item=value}

                <tr>
                    <td class="column1" valign="middle" style="width:170px; word-break: break-word;">{$key}</td>
                    <td class="column1" valign="middle" style="width:170px; word-break: break-word;">{$value.Agent_Name}</td>
                    <td class="column1" valign="middle" style="width:170px; word-break: break-word;">
                    {if $value.total_day_prospect == 0}
                        
                        {$value.total_day_prospect}
                        {else}
                        <a href="index.php?module=AOR_Reports&action=agetnleads&date_of_prospect={$selected_from_date}&assigned_user={$value.Agent_ID}&status_description=Prospect" target="_blank"> {$value.total_day_prospect}</a>
                        {/if}
                         &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                        {if $value.monthly_prospect == 'true'}
                            <i class="fa fa-check" aria-hidden="true" style="font-size:15px;color:green;cursor: pointer;" onclick="getTooltip('monthly_prospect_{$value.Agent_ID}', '{$value.monthly_prospect_tooltip}')"></i>
                        {else}
                            <i class="fa fa-times" aria-hidden="true" style="font-size:15px;color:red;cursor: pointer;" onclick="getTooltip('monthly_prospect_{$value.Agent_ID}', '{$value.monthly_prospect_tooltip}')"></i>
                        {/if}
                        &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                        {if $value.daywise_prospect == 'true'}
                            <i class="fa fa-check" aria-hidden="true" style="font-size:15px;color:green;cursor: pointer;" onclick="getTooltip('daywise_prospect_{$value.Agent_ID}', '{$value.daywise_prospect_tooltip}')"></i>
                        {else}
                            <i class="fa fa-times" aria-hidden="true" style="font-size:15px;color:red;cursor: pointer;" onclick="getTooltip('daywise_prospect_{$value.Agent_ID}', '{$value.daywise_prospect_tooltip}')"></i>
                        {/if}
                    </td>
                    {* <td class="column1" valign="middle" style="width:170px; word-break: break-word;">
                         
                         {$value.total_month_prospect}
                            &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                         {$value.total_day_prospect}
                    </td>*}
                    <td class="column1" valign="middle" style="width:170px; word-break: break-word;">
                        {if $value.monthly_totalcalls == 'true'}
                            <i class="fa fa-check" aria-hidden="true" style="font-size:15px;color:green;cursor: pointer;" onclick="getTooltip('monthly_totalcalls_{$value.Agent_ID}', '{$value.monthly_totalcalls_tooltip}')"></i>
                        {else}
                            <i class="fa fa-times" aria-hidden="true" style="font-size:15px;color:red;cursor: pointer;" onclick="getTooltip('monthly_totalcalls_{$value.Agent_ID}', '{$value.monthly_totalcalls_tooltip}')"></i>
                        {/if}
                        &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                        {if $value.daywise_totalcalls == 'true'}
                            <i class="fa fa-check" aria-hidden="true" style="font-size:15px;color:green;cursor: pointer;" onclick="getTooltip('daywise_totalcalls_{$value.Agent_ID}', '{$value.daywise_totalcalls_tooltip}')"></i>
                        {else}
                            <i class="fa fa-times" aria-hidden="true" style="font-size:15px;color:red;cursor: pointer;" onclick="getTooltip('daywise_totalcalls_{$value.Agent_ID}', '{$value.daywise_totalcalls_tooltip}')"></i>
                        {/if}
                    </td>
                    <td class="column1" valign="middle" style="width:170px; word-break: break-word;">
                        {if $value.monthly_talktime == 'true'}
                            <i class="fa fa-check" aria-hidden="true" style="font-size:15px;color:green;cursor: pointer;" onclick="getTooltip('monthly_talktime_{$value.Agent_ID}', '{$value.monthly_talktime_tooltip}')"></i>
                        {else}
                            <i class="fa fa-times" aria-hidden="true" style="font-size:15px;color:red;cursor: pointer;" onclick="getTooltip('monthly_talktime_{$value.Agent_ID}', '{$value.monthly_talktime_tooltip}')"></i>
                        {/if}
                        &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                        {if $value.daywise_talktime == 'true'}
                            <i class="fa fa-check" aria-hidden="true" style="font-size:15px;color:green;cursor: pointer;" onclick="getTooltip('daywise_talktime_{$value.Agent_ID}', '{$value.daywise_talktime_tooltip}')"></i>
                        {else}
                            <i class="fa fa-times" aria-hidden="true" style="font-size:15px;color:red;cursor: pointer;" onclick="getTooltip('daywise_talktime_{$value.Agent_ID}', '{$value.daywise_talktime_tooltip}')"></i>
                        {/if}
                    </td>
                    <td class="column1" valign="middle" style="width:170px; word-break: break-word;">
                        {if $value.monthly_conversion == 'true'}
                            <i class="fa fa-check" aria-hidden="true" style="font-size:15px;color:green;cursor: pointer;" onclick="getTooltip('monthly_conversion_{$value.Agent_ID}', '{$value.monthly_conversion_tooltip}')"></i>
                        {else}
                            <i class="fa fa-times" aria-hidden="true" style="font-size:15px;color:red;cursor: pointer;" onclick="getTooltip('monthly_conversion_{$value.Agent_ID}', '{$value.monthly_conversion_tooltip}')"></i>
                        {/if}
                        &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                        {if $value.daywise_conversion == 'true'}
                            <i class="fa fa-check" aria-hidden="true" style="font-size:15px;color:green;cursor: pointer;" onclick="getTooltip('daywise_conversion_{$value.Agent_ID}', '{$value.daywise_conversion_tooltip}')"></i>
                        {else}
                            <i class="fa fa-times" aria-hidden="true" style="font-size:15px;color:red;cursor: pointer;" onclick="getTooltip('daywise_conversion_{$value.Agent_ID}', '{$value.daywise_conversion_tooltip}')"></i>
                        {/if}
                    </td>
                    <td class="column1" valign="middle" style="width:170px; word-break: break-word;">
                        <i class="fa fa-eye" aria-hidden="true" style="font-size:12px;color:green;cursor: pointer;" onclick="getTooltip('daywise_quality_score_{$value.Agent_ID}', '{$value.quality_score_tooltip}')"></i>
                    </td>
                    <td class="column1" valign="middle" style="width:170px; word-break: break-word;">

                        

                        <i class="fa fa-edit" aria-hidden="true" style="font-size:15px;color:red;cursor: pointer;" onclick="getCommentBox('{$value.Agent_ID}','{$key}', '{$current_user_id}','{$value.usercomments}')"></i>

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
        
        
            <!-- Modal HTML -->
            <div id="commentBox" class="modal fade">
            <div class="modal-dialog" style="overflow:visible">
                <form method="post"  id="proCommentBox"  enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">×</span>
                                <span class="sr-only">Close</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel">
                                Add Comments
                            </h4>
                        </div>
                        <div class="modal-body">
                            <div class="col-sm-12 marginTopBottom15">
                                <textarea name="bt_srm_comments" id="bt_srm_comments">
                                </textarea>
                            </div>
                            <input type="hidden" id="hidden_com_by" value=""/>
                            <input type="hidden" id="hidden_user_id" value=""/>
                            <input type="hidden" id="hidden_user_email" value=""/>
                            </br> 
                            <br/>
                            <div class = "block-wrapper">
                                <div class="col-sm-12 text-center" style="margin-top: 25px;">
                                    <button type="submit" name="submit" class="button">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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
            
            
            function getCommentBox(user_id,user_email, commented_by,comments){
               
               $("#hidden_com_by").val(commented_by);
               $("#hidden_user_id").val(user_id);
               $("#hidden_user_email").val(user_email);
               $("#bt_srm_comments").val(comments);
               $('#commentBox').modal('show', {
                    backdrop: 'static',
                    keyboard: false,
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
                
                
                $("#proCommentBox").on('submit', function(e){
                 
                
                    var pro_comments = $('#bt_srm_comments').val();
                    var selecteddate = $('#from_date').val();
                    var hidden_com_by = $('#hidden_com_by').val();
                    var hidden_user_id = $('#hidden_user_id').val();
                    var hidden_user_email = $('#hidden_user_email').val();
                    
                    if(bt_srm_comments==''){
                        alert("Please input your comment."); return false;
                    } 

                        $.ajax({
                            beforeSend: function (request)
                            {

                                SUGAR.ajaxUI.showLoadingPanel();
                            },
                            url: "index.php?entryPoint=reportsajax",
                            data: {action: 'proComentBox',msg:pro_comments,selecteddate:selecteddate,hidden_com_by:hidden_com_by,hidden_user_id:hidden_user_id,hidden_user_email:hidden_user_email},
                            dataType: 'json',
                            type: "POST",
                            async: true,
                            success: function (data) {
                                if (data.status == 'success') {
                                    
                                    SUGAR.ajaxUI.hideLoadingPanel();
                                    $(".close").click();
                                    location.reload();
                                } else if (data.status == 'error')
                                {   
                                    alert("Something went wrong!");
                                    $(".close").click();
                                    location.reload();
                                    
                                }

                            }
                        });
                    return false;

                    
              });

                $("#search_form").on('submit', (function (e) {


                    var batch_code = $('#batch_code').val();
                    var status = $('#status').val();
                    var from_date = $('#from_date').val();
                    var year = $('#year').val();
                    var users = $('#users').val();
                    var managers = $('#managers').val();
                    var councellors = $('#agentRole').val();




                    /*
                     
                     if (year == '' || year == null) {
                     $("#year").focus();
                     alert('Please select a year!');
                     return false;
                     }
                     
                     
                     
                     */
                    if (from_date == '' || from_date == null) {
                     $("#from_date").focus();
                     alert('Please select a Date!');
                     return false;
                     }
                    /*if(managers=='' || managers ==null){
                     $("#users").focus();
                     alert('Please select a Manager!'); return false;
                     }*/
                     if(councellors=='' || councellors ==null){
                     $("#users").focus();
                     alert('Please select a councellor!'); return false;
                     }


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


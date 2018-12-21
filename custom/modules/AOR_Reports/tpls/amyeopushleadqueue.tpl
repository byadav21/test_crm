<h2>Dashboard</h2><br/><br/> 
<div class="dashboard-block">
    <h3 class="heading-title"><span>Queue List</span></h3>
    <ul class="admission-done">

        <li class="dashboard-dispatch-yy">
            <div>vvv</div>
            <div id="enrolled">sss</div>
        </li>

    </ul>
</div>
<div class="dashboard-block">
    <h3 class="heading-title"><span>JUNK LEADS</span></h3>
    <ul class="admission-done">

        <li class="dashboard-dispatch-xx">
            <div>ssss</div>
            <div id="enrolled">sss</div>
        </li>

    </ul>
</div> 


<h2>Ameyo push Lead List</h2><br/><br/>
<form name="search_form" id="search_form" class="search_form" method="post" action="index.php?module=AOR_Reports&action=amyeopushleadqueue">
    <input type="hidden" name="batch_created_date" id="batch_created_date" value="{$batch_created_date}">
    <div id="te_budgeted_campaignbasic_searchSearchForm" style="" class="edit view search basic">
        <table width="100%" cellspacing="0" cellpadding="0" border="0">
            <tbody>
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




<div style="width:99%;overflow:hidden;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="paginationTable">
        <tbody><tr>
                <td nowrap="nowrap" class="paginationActionButtons">&nbsp;</td>

                <td nowrap="nowrap" align="right" class="paginationChangeButtons" width="1%">

                    {if $left eq 1}
                        <a href="index.php?module=AOR_Reports&action=amyeopushleadqueue"  name="listViewStartButton" title="Start" class="button" >
                            <img src="themes/SuiteR/images/start_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Start">
                        </a>

                        <a href="index.php?module=AOR_Reports&action=amyeopushleadqueue&page={$pageprevious}"  class="button" title="Previous">
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
                        <a href="index.php?module=AOR_Reports&action=amyeopushleadqueue&page={$pagenext}"  class="button" title="Next" disabled="disabled">
                            <img src="themes/SuiteR/images/next_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Next">
                        </a>
                        <a href="index.php?module=AOR_Reports&action=amyeopushleadqueue&page={$last_page}"  class="button" title="End" disabled="disabled">
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
</div>
<div style="width:99%;overflow:auto;border:2px dashed #d0d0d0;" class="div-leads-list">

    <table cellpadding="0" cellspacing="0" width="{$tablewidth}" border="0" class="list view table footable-loaded footable default">
        <thead>

            <tr height="20">

                {foreach from = $headers key=key item=column}
                    <th scope="col" data-hide="phone" class="footable-visible footable-first-column"><strong>{$column}</strong></th>
                {/foreach}

            </tr>
        </thead>
       

        {if isset($error) && !empty($error)}  <td align="center" class="inlineEdit footable-visible footable-last-column"><h1>{$error.error}</h1></td>{/if}
        
        {foreach from = $leadList key=key item=program}
            <tr height="20" class="oddListRowS1">
                <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.id}</td>
                <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.first_name}</td>
                <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.last_name}</td>
                <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.phone_mobile}</td>
                <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.phone_home}</td>
                <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.phone_work}</td>
                <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.phone_other}</td>
                <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.email_address}</td>
                <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.dristi_campagain_id}</td>
                <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.dristi_api_id}</td>
                <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.batch_code}</td>
                <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.d_campaign_id}</td>
                <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.d_lead_id}</td>


            </tr>
        {/foreach}


    </table>
</div>
{literal}
    <style>
        .dashboard-block{display: flex; flex-direction: column;   width: 100%; margin-bottom: 50px;}
        .dashboard-block:last-child{ margin-bottom:0; }
        .heading-title{display: flex; width: 100%; margin-bottom: 35px;}
        .heading-title span{ font-size: 14px; color: #303188; text-transform: uppercase; font-weight: normal; border-bottom:2px solid #303188; padding:0 50px 20px 0;}
        .dashboard-block ul.admission-done li.first{background-image:url(../images/dashboard-id-card-icon.png); background-repeat: no-repeat; background-position: right 10px bottom 10px;}
        .dashboard-bl
    </style>
{/literal}


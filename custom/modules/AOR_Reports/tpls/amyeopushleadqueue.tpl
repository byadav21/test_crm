<h2>Dashboard</h2><br/><br/> 


    <div class="dashboard-top-wrapper">
            <div class="dashboard-block">
            <form name="search_form" id="search_form" class="search_form" method="post" action="index.php?module=AOR_Reports&action=amyeopushleadqueue">
                
                    <h3 class="heading-title"><span>Queue List</span></h3>
                    <div class="count">{$QueueCount}</div>
                    <div class="actions">
                        <button type="submit" name="export_queue_list" value="export_queue_list" id="export_queue_list">
                            <i style="font-size:24px" class="fa" >&#xf1c3;</i>
                        </button>
                        
                    </div>
                    
                    
            </form>
            </div>
       
         <div class="dashboard-block">
            <form name="search_form" id="search_form" class="search_form" method="post" action="index.php?module=AOR_Reports&action=amyeopushleadqueue">
           
                <h3 class="heading-title"><span>JUNK LEADS</span></h3>
                <div class="count">{$junkCount}</div>
                <div class="actions">
                    <button type="submit" name="export_junk_leads" value="export_junk_leads" id="export_junk_leads">
                        <i style="font-size:24px" class="fa">&#xf1c3;</i>
                    </button>
                </div>
            
            </form>
            </div>
        

        


        


        
            <div class="dashboard-block">
                <h3 class="heading-title"><span>Upload to New Leads</span></h3>
                <div class="upload-block">
                <ul>
                    <li>Dead to New</li> 
                    <li>New to New</li> 
                    <li>Auto Retired Leads to New</li>
                </ul>
                <form name="search_update" id="search_upload"  method="post" action="index.php?module=AOR_Reports&action=amyeopushleadqueue" enctype="multipart/form-data">
                    <label for="batch_basic">Select Upload .CSV File</label>
                    <input type="file" value="" name="file" required accept=".csv"><br>
                    <div>
                    <a href="custom\modules\AOR_Reports\demo/amyeopushleadqueue.csv">Download Template</a>
                    <input tabindex="2"  onclick="SUGAR.savedViews.setChooser();" class="button" type="submit" name="update_leadset" value="Upload" id="update_leadset">
                    </div>
                    </form> 
                </div>
            </div>
        
        
         
            <div class="dashboard-block">
                <h3 class="heading-title"><span>Push Leads</span></h3>
                <form name="search_update" id="search_upload"  method="post" action="index.php?module=AOR_Reports&action=amyeopushleadqueue" enctype="multipart/form-data">
                    <div class="actions"><a href="index.php?entryPoint=pushLeads">
                            <span class="glyphicon glyphicon-open"></span>
                    </a>
                    </div>
                </form>   
            </div>
        
        
        
    </div>



<br><br>


<h3 ><span>Ameyo push Lead List</span></h3>

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
        .dashboard-top-wrapper{display:flex; width:100%}
        .dashboard-top-wrapper form{display:flex; width:100%; flex-direction: column;     height: 100%;}
        .dashboard-block{display: flex; flex-direction: column; margin-left: 10px; padding:10px; width: 100%; border:1px solid #e7e7e7; border-radius:5px; }
        .dashboard-block:first-child{margin-left:0;}
        .heading-title{display: flex; width: 100%; margin-bottom:15px; align-items: center; justify-content: center}
        .heading-title span{ font-size: 14px; color: #303188; text-transform: uppercase; font-weight: normal;}
        .dashboard-block .count{font-size:20px; display: flex; align-items: center; justify-content: center}
        .dashboard-block .actions{margin-top:auto; display: flex; width:100%; justify-content:flex-end;}
         .dashboard-block .actions button{margin:0;}
         .upload-block{display: flex; flex-direction: column; justify-content:space-between; width:100%;}
         .upload-block ul{margin:0 0 10px; padding:0; display:flex; width:100%; flex-direction: column; }
         .upload-block ul li{margin:0; padding:0; list-style-type: none; display:flex; width:100%;}
         .upload-block form{display: flex; flex-direction: column; width: auto;}
         .upload-block form input{width: 100%;}
         .upload-block form div{display: flex; align-items:center; width: 100%; justify-content: space-between;}
         .upload-block form div .button{width:auto;}
    </style>
{/literal}


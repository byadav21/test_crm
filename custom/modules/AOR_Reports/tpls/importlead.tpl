<section class="moduleTitle"> <h1>Data Import Leads</h1><br/><br/>
<form name="search_form" id="search_form" class="search_form" method="post" action="index.php?module=AOR_Reports&action=importlead" enctype="multipart/form-data">
<div id="te_budgeted_campaignbasic_searchSearchForm" style="" class="edit view search basic">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tbody>
            <tr>      
                <td scope="row" nowrap="nowrap" width="1%">		
                    <label for="batch_basic">Select Upload .CSV File</label>
                </td>
                <td nowrap="nowrap" width="10%">
                <td width="30%">
                    <input type="file" value="" name="files" required accept=".csv"><br>
            <!-- <input type="hidden" value="{$doclist.name}" name="docname[]"> -->
                </td>
                </td>
                <td nowrap="nowrap" width="10%">
                    Sample CSV
                    <a href="custom\modules\AOR_Reports/Importdataleadscsv.csv">Download Template</a>
                </td>
            </tr>
            <tr>
                <td colspan="8">&nbsp;</td></tr>
        <td  colspan="8">
            <input tabindex="2" title="Search" onclick="SUGAR.savedViews.setChooser();" class="button" type="submit" name="button" value="Upload" id="search_form_submit">&nbsp;
            </tr>
            </tbody>
    </table>
  </div>
</form>	
<script>
{literal}
Calendar.setup ({
   inputField : "search_date",
   daFormat : "%m/%d/%Y %I:%M%P",
   button : "search_date_trigger",
   singleClick : true,
   dateStr : "",
   step : 1,
   weekNumbers:false,
});
</script>
{/literal}



<section class="moduleTitle"> <h1>Mark Wrong Number</h1><br/><br/>
<form name="search_form" id="search_form" class="search_form" method="post" action="index.php?module=AOR_Reports&action=uploadmarkwrongnumber" enctype="multipart/form-data">
<div id="te_budgeted_campaignbasic_searchSearchForm" style="" class="edit view search basic">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tbody>
            <tr>
                <td scope="row" nowrap="nowrap" width="1%">   
                    <label for="batch_basic">Select Upload .CSV File</label>
                </td>
                <td nowrap="nowrap" width="10%">
                <td width="30%">
                    <input type="file" value="" name="file" required accept=".csv">
                </td>  
                </td>
                <td nowrap="nowrap" width="10%">
                    Sample CSV
                    <a href="custom\modules\AOR_Reports/upload_mark_wrong_number.csv">Download Template</a>
                </td>
            </tr>
            <tr>
                <td colspan="8">&nbsp;</td></tr>
        <td  colspan="8">
            <input tabindex="2" title="Search" onclick="SUGAR.savedViews.setChooser();" class="button" type="submit" name="Import" value="Import" id="search_form_submit">&nbsp;
            </tr>
            </tbody>
    </table>
  </div>
</form> 
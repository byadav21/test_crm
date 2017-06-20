<section class="moduleTitle"> <h2>Batch Wise Referals</h2><br/><br/>
     {sugar_getscript file="custom/modules/AOR_Reports/include/js/jquery_dataTable.js"}
<form name="search_form" id="search_form" class="search_form" method="post" action="index.php?module=AOR_Reports&action=batchwisereferals">
<input type="hidden" name="batch_created_date" id="batch_created_date" value="{$batch_created_date}">
<div id="te_budgeted_campaignbasic_searchSearchForm" style="" class="edit view search basic">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
		<tr>
			<td scope="row" nowrap="nowrap" width="1%">
				<label for="batch_basic">Batch</label>
			</td>
			<td nowrap="nowrap" width="10%">
				<select name="batch[]" class="multiselbox" id="batch" multiple>
					<option  value=""></option>
					{foreach from = $batchList key=key item=batch}
						<option value="{$batch.id}" {if in_array($batch.id,$selected_batch) } selected="selected" {/if}>{$batch.name}</option>
					{/foreach}
				</select>
				</td>

			<td class="sumbitButtons">
				<input tabindex="2" title="Search" onclick="SUGAR.savedViews.setChooser();" class="button" type="submit" name="button" value="Search" id="search_form_submit">&nbsp;
				<input tabindex="2" title="Clear" onclick="SUGAR.searchForm.clear_form(this.form); return false;" class="button" type="button" name="clear" id="search_form_clear" value="Clear">
	        </td>
			<td nowrap="nowrap" width="10%">&nbsp;</td>
			<td class="helpIcon" width="*"><img alt="Help" border="0" id="filterHelp" src="themes/SuiteR/images/help-dashlet.png?v=mjry3sKU3KG11ojfGn-sdg"></td>
		</tr>
		<tr>
			<td scope="row" nowrap="nowrap" width="1%">
				<input tabindex="2" title="Export" onclick="SUGAR.savedViews.setChooser();" class="button" type="submit" name="export" value="Export" id="export_form_submit">

			</td>
		</tr>
		</tbody>
	</table>
</div>
</form>
  



<table cellpadding="0"  id="BatchWiseTableId" cellspacing="0" style="width:99%" border="0" class="table-bordered table-striped fx-layout display nowrap dataTable dtr-inline list view table footable-loaded footable default">
	<thead>
	<tr height="20">

		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Batch</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Total Lead</strong>
		</th>
 
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Converted</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Referals</strong>
		</th>
                
                <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>R.C</strong>
		</th>
                <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Referals %</strong>
		</th>
                <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>R.GSV</strong>
		</th>
                
                
                
                
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>GSV</strong>
		</th>


	</tr>
        </thead>
        <tbody>
	{foreach from = $councelorList key=key item=councelor}
		<tr height="20" class="oddListRowS1">
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.name}</td>
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.TotalLead}</td>
			 
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.converted}</td>
			
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.referalls}</td>
                        
                        <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.rc}</td>
                        <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.rpercentage}</td>
                        <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.Referals_GSV}</td>
                        
                        
                        <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.fees_inr}</td>
		</tr>
	{/foreach}
        </tbody>
</table>

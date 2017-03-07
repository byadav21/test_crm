<section class="moduleTitle"> <h2>Student Study Kit Report</h2><br/><br/>
<form name="search_form" id="search_form" class="search_form" method="post" action="index.php?module=AOR_Reports&action=studentstudykit">
<input type="hidden" name="batch_created_date" id="batch_created_date" value="{$batch_created_date}">
<div id="te_budgeted_campaignbasic_searchSearchForm" style="" class="edit view search basic">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
		<tr>      
			<td scope="row" nowrap="nowrap" width="1%">		
				<label for="batch_basic">Batch</label>
			</td>	
			<td nowrap="nowrap" width="10%">			
				<select name="batch[]" id="batch" multiple>
					<option  value=""></option>
					{foreach from = $batchList key=key item=batch}
						<option value="{$batch.id}" {if $selected_batch eq $batch.id} selected="selected" {/if}>{$batch.name}</option>
					{/foreach}							
				</select>
				</td>
				<td scope="row" nowrap="nowrap" width="1%">		
					<label for="batch_basic">Status</label>
				</td>
				<td nowrap="nowrap" width="10%">	
				<select name="result" id="result" >
						<option  value="">Select Status</option>
						<option value="1" >Sent</option>
						<option value="2" >Not-Sent</option>
											
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
<table cellpadding="0" cellspacing="0" width="100%" border="0" class="list view table footable-loaded footable default">
	<thead>    	
	<tr height="20">
		
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
			<strong>Student</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
			<strong>Batch</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
			<strong>Email</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
			<strong>Phone</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
			<strong>Address</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
			<strong>Address Confirmed</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
			<strong>Status</strong>
		</th>
		
	</tr>
	{foreach from = $councelorList key=key item=councelor}
		<tr height="20" class="oddListRowS1">
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.student}</td>
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.batch}</td> 
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.email}</td> 
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.mobile}</td> 
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.address}</td> 
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.address_confirmed}</td> 
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.kit_status}</td> 
			 			   
			 			   
		</tr>				
	{/foreach}
</table>


<section class="moduleTitle"> <h2>Status Report</h2><br/><br/>
<form name="search_form" id="search_form" class="search_form" method="post" action="index.php?module=AOR_Reports&action=statusreport">
<input type="hidden" name="batch_created_date" id="batch_created_date" value="{$batch_created_date}">
<div id="te_budgeted_campaignbasic_searchSearchForm" style="" class="edit view search basic">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
		<tr>
			<td scope="row" nowrap="nowrap" width="1%">
				<label for="batch_basic">Batches</label>
			</td>
			<td nowrap="nowrap" width="10%">
				<select name="batch[]" id="batch"  class="multiselbox" multiple>
					{foreach from = $batchList key=key item=batch}
						<option value="{$batch.id}" {if in_array($batch.id,$selected_batch) } selected="selected" {/if}>{$batch.name}</option>
					{/foreach}
				</select>
			</td>

      <td scope="row" nowrap="nowrap" width="1%">
				<label for="batch_basic">Counsellors</label>
			</td>
			<td nowrap="nowrap" width="10%">
				<select name="counsellor[]" id="counsellor"  class="multiselbox" multiple>
				{foreach from = $councelorArr key=key item=councelor}

						<option value="{$key}" {if in_array($key,$selected_counsellor) } selected="selected" {/if}>{$councelor}</option>
					{/foreach}
				</select>
			</td>

			<td scope="row" nowrap="nowrap" width="1%">
				<label for="batch_basic">From Date</label>
			</td>
			<td nowrap="nowrap" width="10%">
				<input name="from_date" type="text"  value="{$selected_from_date}" id='from_date'/>
				<img src="themes/SuiteP/images/jscalendar.gif?v=yt-yazfsU-Y9uR7ixqf7Lg" alt="Enter Date" style="position:relative; top:-1px" border="0" id="from_date_trigger">
			</td>
			<td scope="row" nowrap="nowrap" width="1%">
				<label for="batch_basic">To Date</label>
			</td>
			<td nowrap="nowrap" width="10%">
				<input name="to_date" type="text"  value="{$selected_to_date}" id='to_date'/>
				<img src="themes/SuiteP/images/jscalendar.gif?v=yt-yazfsU-Y9uR7ixqf7Lg" alt="Enter Date" style="position:relative; top:-1px" border="0" id="to_date_trigger">
			</td>




		</tr>
    {if $is_admin==1 }
    <tr>
      <td scope="row" nowrap="nowrap" width="1%">
				<label for="batch_basic">Vendor</label>
			</td>
			<td nowrap="nowrap" width="10%">
				<select name="vendors" id="vendors">
					<option  value="">--Select Vendor--</option>
				{foreach from = $vendorList key=key item=vendors}

						<option value="{$vendors.id}" {if $vendors.id==$selected_vendor } selected="selected" {/if}>{$vendors.name}</option>
					{/foreach}
				</select>
			</td>

      <td scope="row" nowrap="nowrap" width="1%">
				<label for="batch_basic">Mediums</label>
			</td>
			<td nowrap="nowrap" width="10%">
				<select name="medium_val[]" multiple id="medium_val">
				      {foreach from = $contractList key=key item=contracts}
              {capture assign=cv}{$contracts.vendorid}_TE_{$contracts.contract_type}{/capture}
						<option value="{$cv}" data-vendor='{$contracts.vendorid}' {if in_array($cv,$selected_medium_val) } selected="selected" {/if} >{$contracts.vendor} - {$contracts.contract_type}</option>
					{/foreach}
        </select>
			</td>
    </tr>
    {/if}
		<tr>
      <td scope="row" nowrap="nowrap" width="1%" colspan='3'>
				<input tabindex="2" title="Search" onclick="SUGAR.savedViews.setChooser();" class="button" type="submit" name="button" value="Search" id="search_form_submit">
        <input tabindex="2" title="Clear" onclick="SUGAR.searchForm.clear_form(this.form); return false;" class="button" type="button" name="clear" id="search_form_clear" value="Clear">
        <input tabindex="2" title="Export" onclick="SUGAR.savedViews.setChooser();" class="button" type="submit" name="export" value="Export" id="export_form_submit">

	    </td>

		</tr>
		</tbody>
	</table>
  {*Start Pagination*}
					<tr id="pagination" role="presentation">
						<td colspan="20">
							<table border="0" cellpadding="0" cellspacing="0" width="100%" class="paginationTable">
								<tbody><tr>
									<td nowrap="nowrap" class="paginationActionButtons">&nbsp;</td>

									<td nowrap="nowrap" align="right" class="paginationChangeButtons" width="1%">

										{if $left eq 1}
											<a href="index.php?module=AOR_Reports&action=statusreport"  name="listViewStartButton" title="Start" class="button" >
											<img src="themes/SuiteR/images/start_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Start">
											</a>

											<a href="index.php?module=AOR_Reports&action=statusreport&page={$page}"  class="button" title="Previous">
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
										<a href="index.php?module=AOR_Reports&action=statusreport&page={$pagenext}"  class="button" title="Next" disabled="disabled">
											<img src="themes/SuiteR/images/next_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Next">
										</a>
										<a href="index.php?module=AOR_Reports&action=statusreport&page={$last_page}"  class="button" title="End" disabled="disabled">
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
</div>
</form>
<table cellpadding="0" cellspacing="0" width="100%" border="0" class="list view table footable-loaded footable default">
	<thead>
	<tr height="20">
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Counsellors</strong>
		</th>
    {if $is_admin==1 }
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Vendor</strong>
		</th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Medium</strong>
		</th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Batch</strong>
		</th>
    {/if}
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Alive</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Warm</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Dead</strong>
		</th>
		<!--<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Converted</strong>
		</th>-->
	</tr>
	{foreach from = $councelorList key=key item=councelor}
		<tr height="20" class="oddListRowS1">
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.name}</td>
      {if $is_admin==1 }
      <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.vendor}</td>
      <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.contract}</td>
      <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.batch}</td>
      {/if}
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.Alive}</td>
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.Warm}</td>
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.Dead}</td>
			<!--<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.Converted}</td>-->
		</tr>
	{/foreach}
</table>
<script>
{literal}
Calendar.setup ({
   inputField : "from_date",
   daFormat : "%d-%m-%Y %I:%M%P",
   button : "from_date_trigger",
   singleClick : true,
   dateStr : "",
   step : 1,
   weekNumbers:false,
});
</script>
{/literal}
<script>
{literal}
Calendar.setup ({
   inputField : "to_date",
   daFormat : "%d-%m-%Y %I:%M%P",
   button : "to_date_trigger",
   singleClick : true,
   dateStr : "",
   step : 1,
   weekNumbers:false,
});

$(document).ready(function() {
       $('#medium_val').multiselect();
   });
</script>
<script>
/*$(function(){
	$("#vendors").change(function(){
		$("#medium_val").html('');
		if($(this).val()!=''){
			$.ajax({url: "index.php?entryPoint=budgtedvsactual&vendors="+$(this).val()+"", success: function(result){
				var result = JSON.parse(result);
				if(result.status=='ok'){
				var medium='';
				 for(var i=0;i<result.res.length;i++){
						var id = result.res[i].id;
						var name = result.res[i].name;
						medium+='<option value="'+id+'">'+name+'</option>'
				 }
				 $("#medium_val").html(medium);
				}
			}});
		}
	});
});*/

</script>
{/literal}

<section class="moduleTitle"> <h2>Conversion Report</h2><br/><br/>
<form name="search_form" id="search_form" class="search_form" method="post" action="index.php?module=AOR_Reports&action=conversionreport">
<input type="hidden" name="batch_created_date" id="batch_created_date" value="{$batch_created_date}">
<div id="te_budgeted_campaignbasic_searchSearchForm" style="" class="edit view search basic">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
		<tr>
			<td scope="row" nowrap="nowrap" width="1%">
				<label for="batch_basic">Status</label>
			</td>
			<td nowrap="nowrap" width="10%">
				<select name="status" id="status">
					{if $selected_status eq 'Live'}
						<option value="Live" selected>Live</option>
					{else}
						<option value="Live">Live</option>
					{/if}
					{if $selected_status eq 'Closed'}
						<option value="Closed" selected>Closed</option>
					{else}
						<option value="Closed">Closed</option>
					{/if}
				</select>
			</td>
			<td scope="row" nowrap="nowrap" width="1%">
				<label for="batch_basic">Batch</label>
			</td>
			<td nowrap="nowrap" width="10%">
				<select name="batch[]" id="batch"  class="multiselbox_batch" multiple style="width:235px !important;">
					{foreach from = $batchList key=key item=batch}
						<option value="{$batch.id}"{if in_array($batch.id, $selected_batch)} selected="selected"{/if} data-status="{$batch.status_filter}">{$batch.name}</option>
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
      <tr>
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
        {if $is_admin==1 }
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
        {/if}
      <tr>
        <td class="sumbitButtons" colspan="3">
  				<input tabindex="2" title="Search" onclick="SUGAR.savedViews.setChooser();" class="button" type="submit" name="button" value="Search" id="search_form_submit">&nbsp;
  				<input tabindex="2" title="Clear" onclick="SUGAR.searchForm.clear_form(this.form); return false;" class="button" type="button" name="clear" id="search_form_clear" value="Clear">
          <input tabindex="2" title="Export" onclick="SUGAR.savedViews.setChooser();" class="button" type="submit" name="export" value="Export" id="export_form_submit">
  	    </td>
      </tr>


		</tbody>
	</table>
</div>
</form>
<table cellpadding="0" cellspacing="0" width="100%" border="0" class="list view table footable-loaded footable default">
	<thead>
		{*Start Pagination*}
					<tr id="pagination" role="presentation">
						<td colspan="20">
							<table border="0" cellpadding="0" cellspacing="0" width="100%" class="paginationTable">
								<tbody><tr>
									<td nowrap="nowrap" class="paginationActionButtons">&nbsp;</td>

									<td nowrap="nowrap" align="right" class="paginationChangeButtons" width="1%">

										{if $left eq 1}
											<a href="index.php?module=AOR_Reports&action=conversionreport"  name="listViewStartButton" title="Start" class="button" >
											<img src="themes/SuiteR/images/start_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Start">
											</a>

											<a href="index.php?module=AOR_Reports&action=conversionreport&page={$page}"  class="button" title="Previous">
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
										<a href="index.php?module=AOR_Reports&action=conversionreport&page={$pagenext}"  class="button" title="Next" disabled="disabled">
											<img src="themes/SuiteR/images/next_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Next">
										</a>
										<a href="index.php?module=AOR_Reports&action=conversionreport&page={$last_page}"  class="button" title="End" disabled="disabled">
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
	<tr height="20">
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Counsellors</strong>
		</th>
		{foreach from = $programList key=key item=program}
			<th scope="col" data-hide="phone" class="footable-visible footable-first-column" colspan="2">
				<strong>{$program}</strong>
			</th>
		{/foreach}
	</tr>
  <tr height="20">
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>&nbsp;</strong>
		</th>
		{foreach from = $programList key=key item=program}
			<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
				<strong>Total</strong>
			</th>
      <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
				<strong>Converted</strong>
			</th>
		{/foreach}
	</tr>
	{foreach from = $councelorList key=key item=councelor}
		<tr height="20" class="oddListRowS1">
		   <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.name}</td>
		   {foreach from = $programList key=key item=program}

  				<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$councelor.$key.total}</td>

          <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column"> {$councelor.$key.converted}</td>
		   {/foreach}
		</tr>
	{/foreach}
</table>
{literal}
<script>
  Calendar.setup ({
     inputField : "from_date",
     daFormat : "%d-%m-%Y %I:%M%P",
     button : "from_date_trigger",
     singleClick : true,
     dateStr : "",
     step : 1,
     weekNumbers:false,
  });
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
  //$('.multiselbox_batch').multiselect();
});
$(document).ready(function() {
  $('#medium_val').multiselect();
});
$(function(){
  var status = $('#status').val();
  $("#batch option[data-status!='" + status +"']").hide();
  $("#status").change(function(){
    var changedStatus = $(this).val();
    $("#batch option[data-status!='" + changedStatus +"']").hide();
    $("#batch option[data-status='" + changedStatus +"']").show();
  });
});
/*$(function(){
	$("#status").change(function(){
		if($(this).val()!=''){
			SUGAR.ajaxUI.showLoadingPanel();
			$.ajax({url: "index.php?entryPoint=getbatchbyleadstatus&status="+$(this).val()+"", success: function(result){
				var result = JSON.parse(result);
				SUGAR.ajaxUI.hideLoadingPanel();
				if(result.status=='ok'){
				var utm='';
				 for(var i=0;i<result.res.length;i++){
						var id = result.res[i].id;
						var name = result.res[i].name;
						utm+='<option value="'+id+'">'+name+'</option>'
				 }
				 $("#batch").html(utm);
				 //$("#batch").multiselect('destroy');
         //$('.multiselbox_batch').multiselect();
				}
			}});
		}
	});
});*/
</script>
{/literal}

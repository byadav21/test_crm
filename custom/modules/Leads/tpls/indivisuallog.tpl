<section class="moduleTitle"> <h1>Individual Log Details</h1><br/><br/>

<form name="search_form" id="search_form" class="search_form" method="post" action="index.php?module=Leads&action=indivisuallog" enctype="multipart/form-data">
<div id="te_budgeted_campaignbasic_searchSearchForm" style="" class="edit view search basic">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
			<tr>      
				<td scope="row" nowrap="nowrap" width="1%">		
					<label for="batch_basic">Individual Logs</label>
				</td>
				<td nowrap="nowrap" width="10%">
								<td width="30%">
										<!--  <input type="file" value="" name="fileToUpload" required accept=".csv"><br> -->
										<!-- <input type="hidden" value="{$doclist.name}" name="docname[]"> -->
								</td>
				</td>
				<td nowrap="nowrap" width="10%">
				</td>
			</tr>
		<tr>
				<td colspan="8">&nbsp;</td></tr>
				<td  colspan="8">
			<!--<input tabindex="2" title="Search" onclick="SUGAR.savedViews.setChooser();" class="button" type="submit" name="button" value="Upload" id="search_form_submit">&nbsp; -->
			</tr>
			<table cellpadding="0" cellspacing="0" width="100%" border="0" class="list view table footable-loaded footable default">
	<thead>
	<tr height="20">
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Name</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Batch</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Batch Code</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Status</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Status Description</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Entered Date</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Counselor</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Individual Id</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Individual Id Status</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Individual Id Batch Status</strong>
		</th>
	</tr>
	{foreach from = $result_data key=key item=value}
            
             <tr height="20" class="oddListRowS1">

                 <td  align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$value.first_name}</td>
                 <td  align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$value.batch_name}</td>
                 <td  align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$value.batch_code}</td>
		 <td  align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$value.status}</td>
		 <td  align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$value.status_description}</td>
                 <td  align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$value.date_entered}</td>
                 <td  align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$value.user_fname}</td>
                 <td  align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$value.individual_id_c}</td>                 
                 <td  align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$value.individual_idstatus_c}</td>
                 <td  align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$value.individual_idbatchstatus_c}</td>


             </tr>
           
        {/foreach}
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


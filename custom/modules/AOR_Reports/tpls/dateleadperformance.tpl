<section class="moduleTitle"> <h2><b>Till Date Lead Performance </b></h2><br/><br/>
<form name="search_form" id="search_form" class="search_form" method="post" action="index.php?module=AOR_Reports&action=dateleadperformance">
<input type="hidden" name="batch_created_date" id="batch_created_date" value="{$batch_created_date}">
<div id="te_budgeted_campaignbasic_searchSearchForm" style="" class="edit view search basic">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
		<tr>
			<td scope="row" nowrap="nowrap" width="1%">
				<label for="batch_basic">Batch</label>
			</td>
			<td nowrap="nowrap" width="10%">
				<select name="batch[]" id="batch"  class="multiselbox" multiple>
					<option  value=""></option>
					{foreach from = $batchList key=key item=batch}
						<option value="{$batch.id}" {if in_array($batch.id, $selected_batch) } selected="selected" {/if}>{$batch.name}</option>
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
  {*Start Pagination*}
					<tr id="pagination" role="presentation">
						<td colspan="20">
							<table border="0" cellpadding="0" cellspacing="0" width="100%" class="paginationTable">
								<tbody><tr>
									<td nowrap="nowrap" class="paginationActionButtons">&nbsp;</td>

									<td nowrap="nowrap" align="right" class="paginationChangeButtons" width="1%">

										{if $left eq 1}
											<a href="index.php?module=AOR_Reports&action=dateleadperformance"  name="listViewStartButton" title="Start" class="button" >
											<img src="themes/SuiteR/images/start_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Start">
											</a>

											<a href="index.php?module=AOR_Reports&action=dateleadperformance&page={$page}"  class="button" title="Previous">
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
										<a href="index.php?module=AOR_Reports&action=dateleadperformance&page={$pagenext}"  class="button" title="Next" disabled="disabled">
											<img src="themes/SuiteR/images/next_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Next">
										</a>
										<a href="index.php?module=AOR_Reports&action=dateleadperformance&page={$last_page}"  class="button" title="End" disabled="disabled">
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
			<strong>Course/Program Name</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Media</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Duplicate</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Dead Number</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Fallout</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Not Eligible</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Not Enquired</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Rejected</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Retired</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Ringing Multiple</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Wrong Number</strong>
		</th>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Call Back</strong>
		</th>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Converted</strong>
		</th>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Follow Up</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>New Lead</strong>
		</th>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Prospect</strong>
		</th>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Re-Enquired</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>No-Answer</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong>Dropout</strong>
		</th>
		</th>
		<!--<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
			<strong><font color="#B22222">Grand Total</font></strong>
		</th>-->

	</tr>
  {php}
  $councelorArray = $this->get_template_vars('councelorList');
  if($councelorArray){
  foreach($councelorArray as $key=>$val){
    $rowspan = count($val);
    $i=0;
    foreach($val as  $keyvendor=>$value){
      $i++;
  {/php}
      <tr height='20' class='oddListRowS1'>
        {php}
        if($i==1){
        {/php}
        <td align="left" rowspan="{php}echo $rowspan;{/php}" style="vertical-align:middle;" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{php}echo $key{/php}</td>
        {php}
        }
        $Duplicate[]=$value['Duplicate'];
        $Dead_Number[]=$value['Dead_Number'];
        $Fallout[]=$value['Fallout'];
        $Not_Eligible[]=$value['Not_Eligible'];
        $Not_Enquired[]=$value['Not_Enquired'];
        $Rejected[]=$value['Rejected'];
        $Retired[]=$value['Retired'];
        $Ringing_Multiple_Times[]=$value['Ringing_Multiple_Times'];
        $Wrong_Number[]=$value['Wrong_Number'];
        $Call_Back[]=$value['Call_Back'];
        $Converted[]=$value['Converted'];
        $Follow_Up[]=$value['Follow_Up'];
        $New_Lead[]=$value['New_Lead'];
        $Prospect[]=$value['Prospect'];
        $Re_Enquired[]=$value['Re_Enquired'];
        $No_Answer[]=$value['No_Answer'];
        $Dropout[]=$value['Dropout'];


        {/php}
        <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{php}echo $keyvendor{/php}</td>
        <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{php}echo $value['Duplicate']{/php}</td>
        <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{php}echo $value['Dead_Number']{/php}</td>
        <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{php}echo $value['Fallout']{/php}</td>
        <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{php}echo $value['Not_Eligible']{/php}</td>
        <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{php}echo $value['Not_Enquired']{/php}</td>
        <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{php}echo $value['Rejected']{/php}</td>
        <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{php}echo $value['Retired']{/php}</td>
        <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{php}echo $value['Ringing_Multiple_Times']{/php}</td>
        <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{php}echo $value['Wrong_Number']{/php}</td>
        <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{php}echo $value['Call_Back']{/php}</td>
        <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{php}echo $value['Converted']{/php}</td>
        <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{php}echo $value['Follow_Up']{/php}</td>
        <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{php}echo $value['New_Lead']{/php}</td>
        <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{php}echo $value['Prospect']{/php}</td>
        <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{php}echo $value['Re_Enquired']{/php}</td>
        <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{php}echo $value['No_Answer']{/php}</td>
        <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{php}echo $value['Dropout']{/php}</td>
        <!--<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">
          <strong><font color="#B22222">000</strong></font>
        </td>-->
      </tr>
  {php}
    }
  }
  {/php}
  <tr height="20" class="oddListRowS1">
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
      <strong><font color="#B22222">Grand Total</font></strong>
    </th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
      <strong>
      {php}
      echo '';
      {/php}
     </strong>
    </th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
      <strong><font color="#B22222">
      {php}
      echo array_sum($Duplicate);
      {/php}
     </font></strong>
    </th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
      <strong><font color="#B22222">
      {php}
      echo array_sum($Dead_Number);
      {/php}
     </font></strong>
    </th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
      <strong><font color="#B22222">
      {php}
      echo array_sum($Fallout);
      {/php}
     </font></strong>
    </th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
      <strong><font color="#B22222">
      {php}
      echo array_sum($Not_Eligible);
      {/php}
     </font></strong>
    </th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
      <strong><font color="#B22222">
      {php}
      echo array_sum($Not_Enquired);
      {/php}
     </font></strong>
    </th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
      <strong><font color="#B22222">
      {php}
      echo array_sum($Rejected);
      {/php}
     </font></strong>
    </th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
      <strong><font color="#B22222">
      {php}
      echo array_sum($Retired);
      {/php}
     </font></strong>
    </th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
  <strong><font color="#B22222">
      {php}
      echo array_sum($Ringing_Multiple_Times);
      {/php}
    </font></strong>
    </th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
      <strong><font color="#B22222">
      {php}
      echo array_sum($Wrong_Number);
      {/php}
     </font></strong>
    </th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
      <strong><font color="#B22222">
      {php}
      echo array_sum($Call_Back);
      {/php}
     </font></strong>
    </th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
      <strong><font color="#B22222">
      {php}
      echo array_sum($Converted);
      {/php}
     </font></strong>
    </th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
      <strong><font color="#B22222">
      {php}
      echo array_sum($Follow_Up);
      {/php}
     </font></strong>
    </th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
      <strong><font color="#B22222">
      {php}
      echo array_sum($New_Lead);
      {/php}
     </font></strong>
    </th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
      <strong><font color="#B22222">
      {php}
      echo array_sum($Prospect);
      {/php}
     </font></strong>
    </th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
      <strong><font color="#B22222">
      {php}
      echo array_sum($Re_Enquired);
      {/php}
     </font></strong>
    </th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
      <strong><font color="#B22222">
      {php}
      echo array_sum($No_Answer);
      {/php}
     </font></strong>
    </th>
    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
      <strong><font color="#B22222">
      {php}
      echo array_sum($Dropout);
      {/php}
     </font></strong>
    </th>
    <!--<th scope="col" data-hide="phone" class="footable-visible footable-first-column">
      <strong><font color="#006400">
      0
     </font></strong>
   </th>-->
  </tr>
  {php}
  }
  {/php}


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
</script>
{/literal}

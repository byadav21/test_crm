
<div class="panel panel-default">
	<div class="panel-heading ">		
			<div class="col-xs-10 col-sm-11 col-md-11" style="padding-left:5px;">
				Installments
			</div>	
	</div>
	
</div>

<div class="edit view edit508  expanded" id="detailpanel_2">

	<table cellspacing="1" cellpadding="10" border="1" width="100%" class="yui3-skin-sam edit view panelContainer" id="Payment">
		<tr>
			<td style="padding-top:10px;">No. Of Installments</td><td style="padding-top:10px;"><input name="installment" id="installment" type="text"  value="{$no_of_installments}" size="17%"/></td>
			<td style="padding-top:10px;">Initial Payments Date</td><td style="padding-top:10px;"><input name="initial_payment_date" type="text"  value="{$initial_payment_date}" id='initial_payment_date' />			
			<img src="themes/SuiteP/images/jscalendar.gif?v=yt-yazfsU-Y9uR7ixqf7Lg" alt="Enter Date" style="position:relative; top:6px" border="0" id="initial_payment_date_trigger">
			</td>
			<td style="padding-top:10px;">&nbsp;</td>
		</tr>
		<tr>
			<td style="padding-top:10px;">Initial Payment In INR</td><td style="padding-top:10px;"><input name="initial_payment_inr" id="initial_payment_inr" type="text"  value="{$initial_payment_inr}" size="17%"/></td>			
			<td style="padding-top:10px;">Initial Payments In USD</td><td style="padding-top:10px;"><input name="initial_payment_usd" type="text"  value="{$initial_payment_usd}" id='initial_payment_usd' />
			</td>
			<td style="padding-top:10px;">&nbsp;</td>
		</tr>
		{if $installments|@count > 0}
			{assign var="count" value=1}
			{foreach from=$installments key=index item=installment}
				<tr id="row{$count}">
					<td style="padding-top:10px;">Payment {$count} In INR</td><td style="padding-top:10px;"><input name="payment_inr_{$count}" id="payment_inr_{$count}" type="text"  value="{$installment.payment_inr}" size="17%"/>
					</td>
					<td style="padding-top:10px;">Payment {$count} In USD</td>
					<td style="padding-top:10px;"><input name="payment_usd_{$count}" id="payment_usd_{$count}" type="text"  value="{$installment.payment_usd}" size="17%"/>
					
					<td style="padding-top:10px;">Due Date</td><td style="padding-top:10px;"><input name="due_date_{$count}" type="text"  value="{$installment.due_date}" id='due_date_{$count}' />
					<img src="themes/SuiteP/images/jscalendar.gif?v=yt-yazfsU-Y9uR7ixqf7Lg" alt="Enter Date" style="position:relative; top:6px" border="0" id="due_date_trigger_{$count}">
					</td>
				</tr>
				{assign var='count' value=$count+1}
			{/foreach}
		{else}
			<tr id="row1" style="display:none" >
				<td style="padding-top:10px;">Payment 1 In INR</td><td style="padding-top:10px;"><input name="payment_inr_1" id="payment_inr_1" type="text"  value="" size="17%"/></td>
				<td style="padding-top:10px;">Payment 1 IN USD</td><td style="padding-top:10px;"><input name="payment_usd_1" id="payment_usd_1" type="text"  value="" size="17%"/></td>
				<td style="padding-top:10px;">Due Date</td><td style="padding-top:10px;"><input name="due_date_1" type="text"  value="" id='due_date_1' />
				<img src="themes/SuiteP/images/jscalendar.gif?v=yt-yazfsU-Y9uR7ixqf7Lg" alt="Enter Date" style="position:relative; top:6px" border="0" id="due_date_trigger_1">
				</td>
			</tr>
			<tr id="row2" style="display:none">
				<td style="padding-top:10px;">Payment 2 In INR</td><td style="padding-top:10px;"><input name="payment_inr_2" id="payment_inr_2" type="text"  value="" size="17%"/></td>
				<td style="padding-top:10px;">Payment 2 In USD</td><td style="padding-top:10px;"><input name="payment_usd_2" id="payment_usd_2" type="text"  value="" size="17%"/></td>
				<td style="padding-top:10px;">Due Date</td><td style="padding-top:10px;"><input name="due_date_2" type="text"  value="" id='due_date_2' />
				<img src="themes/SuiteP/images/jscalendar.gif?v=yt-yazfsU-Y9uR7ixqf7Lg" alt="Enter Date" style="position:relative; top:6px" border="0" id="due_date_trigger_2">
				</td>
			</tr>
			<tr id="row3" style="display:none">
				<td style="padding-top:10px;">Payment 3 In INR</td><td style="padding-top:10px;"><input name="payment_inr_3" id="payment_inr_3" type="text"  value="" size="17%"/></td>
				<td style="padding-top:10px;">Payment 3 In USD</td><td style="padding-top:10px;"><input name="payment_usd_3" id="payment_usd_3" type="text"  value="" size="17%"/></td>
				
				<td style="padding-top:10px;">Due Date</td><td style="padding-top:10px;"><input name="due_date_3" type="text"  value="" id='due_date_3' />
				<img src="themes/SuiteP/images/jscalendar.gif?v=yt-yazfsU-Y9uR7ixqf7Lg" alt="Enter Date" style="position:relative; top:6px" border="0" id="due_date_trigger_3">
				</td>
			</tr>
			<tr id="row4" style="display:none">
				<td style="padding-top:10px;">Payment 4 In INR</td><td style="padding-top:10px;"><input name="payment_inr_4" id="payment_inr_4" type="text"  value="" size="17%"/></td>
				<td style="padding-top:10px;">Payment 4 In USD</td><td style="padding-top:10px;"><input name="payment_usd_4" id="payment_usd_4" type="text"  value="" size="17%"/></td>
				
				<td style="padding-top:10px;">Due Date</td><td style="padding-top:10px;"><input name="due_date_4" type="text"  value="" id='due_date_4' />
				<img src="themes/SuiteP/images/jscalendar.gif?v=yt-yazfsU-Y9uR7ixqf7Lg" alt="Enter Date" style="position:relative; top:6px" border="0" id="due_date_trigger_4">
				</td>
			</tr>
			<tr id="row5" style="display:none">
				<td style="padding-top:10px;">Payment 5 In INR</td><td style="padding-top:10px;"><input name="payment_inr_5" id="payment_inr_5" type="text"  value="" size="17%"/></td>
				<td style="padding-top:10px;">Payment 5 In USD</td><td style="padding-top:10px;"><input name="payment_usd_5" id="payment_usd_5" type="text"  value="" size="17%"/></td>
				
				<td style="padding-top:10px;">Due Date</td><td style="padding-top:10px;"><input name="due_date_5" type="text"  value="" id='due_date_5' />
				<img src="themes/SuiteP/images/jscalendar.gif?v=yt-yazfsU-Y9uR7ixqf7Lg" alt="Enter Date" style="position:relative; top:6px" border="0" id="due_date_trigger_5">
				</td>
			</tr>
			<tr id="row6" style="display:none">
				<td style="padding-top:10px;">Payment 6 In INR</td><td style="padding-top:10px;"><input name="payment_inr_6" id="payment_inr_6" type="text"  value="" size="17%"/></td>
				<td style="padding-top:10px;">Payment 6 In USD</td><td style="padding-top:10px;"><input name="payment_usd_6" id="payment_usd_6" type="text"  value="" size="17%"/></td>
				
				<td style="padding-top:10px;">Due Date</td><td style="padding-top:10px;"><input name="due_date_6" type="text"  value="" id='due_date_6' />
				<img src="themes/SuiteP/images/jscalendar.gif?v=yt-yazfsU-Y9uR7ixqf7Lg" alt="Enter Date" style="position:relative; top:6px" border="0" id="due_date_trigger_6">
				</td>
			</tr>
			<tr id="row7" style="display:none">
				<td style="padding-top:10px;">Payment 7 In INR</td><td style="padding-top:10px;"><input name="payment_inr_7" id="payment_inr_7" type="text"  value="" size="17%"/></td>
				<td style="padding-top:10px;">Payment 7 In USD</td><td style="padding-top:10px;"><input name="payment_usd_7" id="payment_usd_7" type="text"  value="" size="17%"/></td>
				
				<td style="padding-top:10px;">Due Date</td><td style="padding-top:10px;"><input name="due_date_7" type="text"  value="" id='due_date_7' />
				<img src="themes/SuiteP/images/jscalendar.gif?v=yt-yazfsU-Y9uR7ixqf7Lg" alt="Enter Date" style="position:relative; top:6px" border="0" id="due_date_trigger_7">
				</td>
			</tr>
			<tr id="row8" style="display:none">
				<td style="padding-top:10px;">Payment 8 In INR</td><td style="padding-top:10px;"><input name="payment_inr_8" id="payment_inr_8" type="text"  value="" size="17%"/></td>
				<td style="padding-top:10px;">Payment 8 In USD</td><td style="padding-top:10px;"><input name="payment_usd_8" id="payment_usd_8" type="text"  value="" size="17%"/></td>
				
				<td style="padding-top:10px;">Due Date</td><td style="padding-top:10px;"><input name="due_date_8" type="text"  value="" id='due_date_8' />
				<img src="themes/SuiteP/images/jscalendar.gif?v=yt-yazfsU-Y9uR7ixqf7Lg" alt="Enter Date" style="position:relative; top:6px" border="0" id="due_date_trigger_8">
				</td>
			</tr>
			<tr id="row9" style="display:none">
				<td style="padding-top:10px;">Payment 9 In INR</td><td style="padding-top:10px;"><input name="payment_inr_9" id="payment_inr_9" type="text"  value="" size="17%"/></td>
				<td style="padding-top:10px;">Payment 9 In USD</td><td style="padding-top:10px;"><input name="payment_usd_9" id="payment_usd_9" type="text"  value="" size="17%"/></td>
				
				<td style="padding-top:10px;">Due Date</td><td style="padding-top:10px;"><input name="due_date_9" type="text"  value="" id='due_date_9' />
				<img src="themes/SuiteP/images/jscalendar.gif?v=yt-yazfsU-Y9uR7ixqf7Lg" alt="Enter Date" style="position:relative; top:6px" border="0" id="due_date_trigger_9">
				</td>
			</tr>
			<tr id="row10" style="display:none">
				<td style="padding-top:10px;">Payment 10 In INR</td><td style="padding-top:10px;"><input name="payment_inr_10" id="payment_inr_10" type="text"  value="" size="17%"/></td>
				<td style="padding-top:10px;">Payment 10 In USD</td><td style="padding-top:10px;"><input name="payment_usd_10" id="payment_usd_10" type="text"  value="" size="17%"/></td>
				
				<td style="padding-top:10px;">Due Date</td><td style="padding-top:10px;"><input name="due_date_10" type="text"  value="" id='due_date_10' />
				<img src="themes/SuiteP/images/jscalendar.gif?v=yt-yazfsU-Y9uR7ixqf7Lg" alt="Enter Date" style="position:relative; top:6px" border="0" id="due_date_trigger_10">
				</td>
			</tr>
			
		{/if}
		
		

	</table>		
	<div id="addedRows"></div>
</div>

{{include file='include/EditView/footer.tpl'}}

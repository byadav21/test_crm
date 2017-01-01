
<div class="panel panel-default">
	<div class="panel-heading ">		
			<div class="col-xs-10 col-sm-11 col-md-11" style="padding-left:5px;">
				<strong>Mailer Details</strong>
			</div>	
	</div>	
</div>

{literal}
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#total_mailers').blur(function (){
		 var total_mailers = $("#total_mailers").val();
		hideRows();
		addMoreRows(total_mailers);
	});
	
	function hideRows() {
		for(rowCount=1;rowCount<=10;rowCount++){
			document.getElementById("row"+rowCount).style.display="none";
		}		
	}
	function addMoreRows(rows) {
		for(rowCount=1;rowCount<=rows;rowCount++){
			document.getElementById("row"+rowCount).style.display="";
		}		
	}
	
});
</script>
{/literal}

	<table cellspacing="1" cellpadding="10" border="0" width="100%" class="yui3-skin-sam edit view panelContainer" id="Payment">
	
		{*<tr>
			<td style="padding-top:10px;" colspan="4">Number of Mailers&nbsp;<input name="total_mailers" id="total_mailers" type="text"  value="" size="17%" /></td>

		</tr>*}
		{if $drip_campain_list|@count > 0}
			{assign var="count" value=1}
			{foreach from=$drip_campain_list key=index item=campain_list}
				<tr id="row{$count}">
					<td style="padding-top:10px;">Day</td>
					<td style="padding-top:10px;">
						<input type="text" name="day_{$count}" value="{$campain_list.mailer_day}">
					</td>
					<td style="padding-top:10px;">Template</td>
					<td>
					<select name="template_{$count}">
						<option value="">Select Template</option>
						{foreach from=$templateList key=index item=template}
							{if $campain_list.template_id eq $template.id}
								<option value="{$template.id}" selected>{$template.name}</option>
							{else}
								<option value="{$template.id}">{$template.name}</option>
							{/if}
						{/foreach}
					</select>
					</td>		
				</tr>
				{assign var='count' value=$count+1}
			{/foreach}
		{else}
			<tr id="row1" style="display:none" >
				<td>Day</td>
				<td><input name="day_1" id="day_1" type="text"  value="" size="17%"/></td>
				<td >Template</td>
				<td style="padding-top:-10px;">
					<select name="template_1">
						<option value="">Select Template</option>
						{foreach from=$templateList key=index item=template}
							<option value="{$template.id}">{$template.name}</option>
						{/foreach}
					</select>				
				</td>				
			</tr>
			<tr id="row2" style="display:none">
				<td>Day</td>
				<td><input name="day_2" id="day_2" type="text"  value="" size="17%"/></td>
				<td>Template</td>
				<td>
					<select name="template_2">
						<option value="">Select Template</option>
						{foreach from=$templateList key=index item=template}
							<option value="{$template.id}">{$template.name}</option>
						{/foreach}
					</select>				
				</td>	
			</tr>
			<tr id="row3" style="display:none">
				<td style="padding-top:10px;">Day</td>
				<td style="padding-top:10px;"><input name="day_3" id="day_3" type="text"  value="" size="17%"/></td>
				<td style="padding-top:10px;">Template</td>
				<td style="padding-top:10px;">
					<select name="template_3">
						<option value="">Select Template</option>
						{foreach from=$templateList key=index item=template}
							<option value="{$template.id}">{$template.name}</option>
						{/foreach}
					</select>				
				</td>	
			</tr>
			<tr id="row4" style="display:none">
				<td style="padding-top:10px;">Day</td>
				<td style="padding-top:10px;"><input name="day_4" id="day_4" type="text"  value="" size="17%"/></td>
				<td style="padding-top:10px;">Template</td>
				<td style="padding-top:10px;">
					<select name="template_4">
						<option value="">Select Template</option>
						{foreach from=$templateList key=index item=template}
							<option value="{$template.id}">{$template.name}</option>
						{/foreach}
					</select>				
				</td>	
			</tr>
			<tr id="row5" style="display:none">
				<td style="padding-top:10px;">Day</td>
				<td style="padding-top:10px;"><input name="day_5" id="day_5" type="text"  value="" size="17%"/></td>
				<td style="padding-top:10px;">Template</td>
				<td style="padding-top:10px;">
					<select name="template_5">
						<option value="">Select Template</option>
						{foreach from=$templateList key=index item=template}
							<option value="{$template.id}">{$template.name}</option>
						{/foreach}
					</select>				
				</td>	
			</tr>
			<tr id="row6" style="display:none">
				<td style="padding-top:10px;">Day</td>
				<td style="padding-top:10px;"><input name="day_6" id="day_6" type="text"  value="" size="17%"/></td>
				<td style="padding-top:10px;">Template</td>
				<td style="padding-top:10px;">
					<select name="template_6">
						<option value="">Select Template</option>
						{foreach from=$templateList key=index item=template}
							<option value="{$template.id}">{$template.name}</option>
						{/foreach}
					</select>				
				</td>	
			</tr>
			<tr id="row7" style="display:none">
				<td style="padding-top:10px;">Day</td>
				<td style="padding-top:10px;"><input name="day_7" id="day_7" type="text"  value="" size="17%"/></td>
				<td style="padding-top:10px;">Template</td>
				<td style="padding-top:10px;">
					<select name="template_7">
						<option value="">Select Template</option>
						{foreach from=$templateList key=index item=template}
							<option value="{$template.id}">{$template.name}</option>
						{/foreach}
					</select>				
				</td>	
			</tr>
			<tr id="row8" style="display:none">
				<td style="padding-top:10px;">Day</td>
				<td style="padding-top:10px;"><input name="day_8" id="day_8" type="text"  value="" size="17%"/></td>
				<td style="padding-top:10px;">Template</td>
				<td style="padding-top:10px;">
					<select name="template_8">
						<option value="">Select Template</option>
						{foreach from=$templateList key=index item=template}
							<option value="{$template.id}">{$template.name}</option>
						{/foreach}
					</select>				
				</td>	
			</tr>
			<tr id="row9" style="display:none">
				<td style="padding-top:10px;">Day</td>
				<td style="padding-top:10px;"><input name="day_9" id="day_9" type="text"  value="" size="17%"/></td>
				<td style="padding-top:10px;">Template</td>
				<td style="padding-top:10px;">
					<select name="template_9">
						<option value="">Select Template</option>
						{foreach from=$templateList key=index item=template}
							<option value="{$template.id}">{$template.name}</option>
						{/foreach}
					</select>				
				</td>	
			</tr>
			<tr id="row10" style="display:none">
				<td style="padding-top:10px;">Day</td>
				<td style="padding-top:10px;"><input name="day_10" id="day_10" type="text"  value="" size="17%"/></td>
				<td style="padding-top:10px;">Template</td>
				<td style="padding-top:10px;">
					<select name="template_10">
						<option value="">Select Template</option>
						{foreach from=$templateList key=index item=template}
							<option value="{$template.id}">{$template.name}</option>
						{/foreach}
					</select>				
				</td>	
			</tr>			
		{/if}
	</table>		
	<div id="addedRows"></div>


{{include file='include/EditView/footer.tpl'}}

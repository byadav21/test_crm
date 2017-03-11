<table cellpadding="0" cellspacing="0" width="100%" border="0" class="list view table footable-loaded footable default">
	<thead>    	
	<tr height="20">
		{foreach from = $reportHeader key=key item=value}
			<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
				<strong>{$value}</strong>
			</th>
		{/foreach}		
	</tr>
	{foreach from = $feeList key=key item=data}
		<tr height="20" class="oddListRowS1">
			{foreach from = $reportHeader key=key item=value}
				<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{if $data.$value neq ""} {$data.$value} {else}NA{/if}</td>
			{/foreach}
		</tr>				
	{/foreach}
</table>
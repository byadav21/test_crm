<section class="moduleTitle"> <h2>Security Groups</h2><br/><br/>

<table cellpadding="0" cellspacing="0" width="100%" border="0" class="list view table footable-loaded footable default">
	<thead>    	
	<tr height="20">
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">	
			<strong>Name</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">	
			<strong>Assigned To</strong>
		</th>
		
	</tr>
	{foreach from = $groupDataList key=key item=data}
	<tr height="20" class="oddListRowS1">
		<td align="left" valign="top" type="relate" field="vendor" class="inlineEdit footable-visible footable-last-column"><a href="index.php?module=te_lead_assignment_rule&action=updategroup&record={$data.id}">{$data.name}</a></td>
		<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column"><a href="">{$data.first_name}&nbsp;{$data.last_name}</a></td>	
		
	</tr>				
	{/foreach}
</table>

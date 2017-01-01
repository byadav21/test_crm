<section class="moduleTitle"> <h2>{$groupName}</h2><br/><br/>

<table cellpadding="0" cellspacing="0" width="100%" border="0" class="list view table footable-loaded footable default">
	<thead>    	
	<tr height="15" class="oddListRowS1">
		<td align="left" valign="middle" class="inlineEdit footable-visible footable-last-column">	
			Users List
		</td>
		<td align="left" valign="top" type="relate" field="vendor" class="inlineEdit footable-visible footable-last-column">
		<select name="ad_user"  id="ad_user">
					<option  value="">Select User</option>
					{foreach from = $usersListOptions key=key item=vendor}
						<option value="{$key}">{$vendor}</option>
					{/foreach}			
		</select>
		</td>
		<td align="left" valign="top" type="relate" field="vendor" class="inlineEdit footable-visible footable-last-column"><button onclick="add_user_in_group('{$groupid}')">Add User</button></td>
	</tr>	
</table>

<br>
<h1>Existing Users List</h1>
<table cellpadding="0" cellspacing="0" width="100%" border="0" class="list view table footable-loaded footable default">
	<thead>    	
	<tr height="20">
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">	
			<strong>SN</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">	
			<strong>Name</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">	
			<strong>User Name</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">	
			<strong>Status</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">	
			<strong>&nbsp</strong>
		</th>
	</tr>
	{assign var=flag value=1}
	{foreach from = $userDataList key=key item=data}
	<tr height="20" class="oddListRowS1">
		<td align="left" valign="top" type="relate" field="vendor" class="inlineEdit footable-visible footable-last-column">{$flag}</td>
		<td align="left" valign="top" type="relate" field="vendor" class="inlineEdit footable-visible footable-last-column"><a href="">{$data.first_name}&nbsp;{$data.last_name}</a></td>
		<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$data.user_name}</td>	
		<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$data.status}</td>	
		<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column"><a onclick="removeUser('{$groupid}','{$data.id}')">Remove</a></td>	
		
	</tr>	
	{assign var=flag value=$flag+1}			
	{/foreach}
</table>




<script>
{literal}
function add_user_in_group(group_id){

	if(confirm('Are you sure to add the selected user in this group')){
		var e = document.getElementById("ad_user");
		var user_id = e.options[e.selectedIndex].value;
		
		window.open('index.php?module=te_lead_assignment_rule&action=updategroup&record='+group_id+'&adrecord='+user_id,"_self");
	}
	else{
		return false;
	}
}

function removeUser(group_id,user_id){
		if(confirm('Are you sure to remove the user from this group')){
			window.open('index.php?module=te_lead_assignment_rule&action=updategroup&record='+group_id+'&removerecord='+user_id,"_self");
		}
		else{
			return false;
		}
	
}
</script>
{/literal}

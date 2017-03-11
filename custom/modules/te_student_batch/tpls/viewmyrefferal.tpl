{literal}
<script>
function pleaseWait()
{

	if(check_form('referralform')){
				SUGAR.ajaxUI.showLoadingPanel();
				return true;
			}
}

</script>
{/literal}

<form name='referralform' action='' method='POST'>
<table cellpadding='0' cellspacing='0' width='100%' border='0' align='left' >
	<tr>
		<!--<td width="15%" align="left" style="color:black;"><strong>Program:</strong></td>
		<td width="35%" align="left">
		<select name="program" id="program" >
			<option value=""></option>
			{foreach from=$program key=keys item=options}
				{if $keys== $selectedProgram}
					<option value="{$keys}" selected='selected'>{$options}</option>
				{else}
					<option value="{$keys}">{$options}</option>
				{/if}
			{/foreach}
		</select>
	</td>-->
		<td width="15%" align="left"  style="color:black;"><strong>Batch: </strong></td>
		<td width="35%" align="left">
			<select name="batch" id="batch">
				<option value=""></option>
				{foreach from=$batch key=keys item=options}
					{if $keys== $selectedBatch}
						<option value="{$keys}" selected='selected'>{$options}</option>
					{else}
						<option value="{$keys}">{$options}</option>
					{/if}
				{/foreach}
			</select>
		</td>
		<td width="15%" align="left"  style="color:black;"><strong>Status:</strong></td>
	 <td width="35%" align="left">
		 <select name="status" id="status" >
			 <option value=""></option>
			 {foreach from =$statusList key=keys item=options}
				 {if $keys== $selectedStatus}
					 <option value="{$keys}" selected='selected'>{$options}</option>
				 {else}
					 <option value="{$keys}">{$options}</option>
				 {/if}
			 {/foreach}
		 </select>
		</td>
		</tr>
		<tr>

	    <td width="15%" align="left"  style="color:black;"><strong>SRM:</strong></td>
		<td width="35%" align="left">
			<select name="srm" id="srm">
				<option value=""></option>
				{foreach from =$srm key=keys item=options}
					{if $keys== $selectedSRM}
						<option value="{$keys}" selected='selected'>{$options}</option>
					{else}
						<option value="{$keys}">{$options}</option>
					{/if}
				{/foreach}
			</select>
	   </td>
   </tr>
   <tr><td>&nbsp;</td><td>&nbsp;</td>
	</tr>
	<tr><td>&nbsp;</td>
		<td colspan="3">
			<input type='submit' name='searchreferral' id = 'searchreferral' value='Search' class="button primary" onclick='pleaseWait()' >
			<input type='button' name='Clear' value='Clear' id='clear' onclick="SUGAR.searchForm.clear_form(this.form); return false;">
		</td>
	 </tr>
</table>
</form>

<tr><td></td>
<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
</td></tr>
<table cellpadding='0' cellspacing='0' width='100%' border='0'  align='center'>

</table>

<div class='wrapper' style="margin-top:10px;width:1251px;height:355px;overflow-x:hidden;overflow-y:hidden">
	<table cellpadding='0' cellspacing='0' width='100%' border='0' align='left' class ='list view table'>
	<tr>
		<td style="color:black;"><b>Name</b></td>
		<td style="color:black;"><b>Email</b></td>
		<td style="color:black;"><b>Phone</b></td>
		<td style="color:black;"><b>Institute</b></td>
		<td style="color:black;"><b>Batch</b></td>
		<td style="color:black;"><b>Program</b></td>
		<td style="color:black;"><b>Status</b></td>
		<td style="color:black;"><b>Counselor</b></td>
		<td  style="color:black;"><b>Date of Referral Creation</b></td>
		<td colspan ="2" style="color:black;"><b>Referred by</b></td>

		<td style="color:black;"><b>SRM</b></td>
	</tr>
	{foreach from =$referrals key=keys item=options}
		<tr>

				<td><a href="index.php?module=Leads&action=detailview&record={$options.lid}">{$options.name}</a></td>
				<td>{$options.email_address}</td>
				<td>{$options.phone_mobile}</td>
				<td>{$options.insti_name}</td>
				<td>{$options.batch_name}</td>
				<td>{$options.prog_name}</td>
				<td>{$options.status}</td>
				<td>{$options.counselor}</td>
				<td>{$options.date_of_referral}</td>

				<td>{$options.parent_type}</td>
				{if $options.parent_type =='Users' }
					<td><a href="index.php?module=User&action=detailview&record={$options.parent_id}">{$options.rcounselor}</a></td>
				{/if}
				{if $options.parent_type =='Leads' }
					<td><a href="index.php?module=Leads&action=detailview&record={$options.parent_id}">{$options.rname}</a></td>
				{/if}

				<td>{$options.srm}</td>

		<tr>
	{/foreach}

	</table>
</div>

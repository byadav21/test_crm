
<div style='width: 500px'>
<form name='configure_{$id}' action="index.php" method="post" onSubmit='return SUGAR.dashlets.postForm("configure_{$id}", SUGAR.mySugar.uncoverPage);'>
<input type='hidden' name='id' value='{$id}'>
<input type='hidden' name='module' value='Home'>
<input type='hidden' name='action' value='ConfigureDashlet'>
<input type='hidden' name='to_pdf' value='true'>
<input type='hidden' name='configure' value='true'>
<table width="400" cellpadding="0" cellspacing="0" border="0" class="edit view" align="center">
<tr>
    <td valign='top' nowrap scope='row'>{$titleLbl}</td>
    <td valign='top'>
    	<input class="text" name="title" size='20' value='{$title}'>
    </td>
</tr>
{if $isRefreshable}
<tr>
    <td scope='row'>
        {$autoRefresh}
    </td>
    <td>
        <select name='autoRefresh'>
            {html_options options=$autoRefreshOptions selected=$autoRefreshSelect}
        </select>
    </td>
</tr>
{/if}
<tr>
    <td valign='top' nowrap scope='row'>Top Leads Source</td>
    <td valign='top'>
		<select name='top_camp'>
			{if $top_batchs==10}
				<option value="10" selected>Top 10</option>
			{else}
				<option value="10">Top 10</option>
			{/if}
			{if $top_batchs==20}
				<option value="20" selected>Top 20</option>
			{else}
				<option value="20">Top 20</option>
			{/if}
			{if $top_batchs==30}
				<option value="30" selected>Top 30</option>
			{else}
				<option value="30">Top 30</option>
			{/if}
			{if $top_batchs==50}
				<option value="50" selected>Top 50</option>
			{else}
				<option value="50">Top 50</option>
			{/if}			
        </select>
    
    </td>
</tr>
<tr>
    <td valign='top' nowrap scope='row'>{$heightLbl}</td>
    <td valign='top'>
    	<input class="text" name="height" size='3' value='{$height}'>
    </td>
</tr>
<tr>
    <td align="right" colspan="2">
        <input type='submit' class='button' value='{$saveLbl}'>
   	</td>
</tr>
</table>
</form>

</div>
   

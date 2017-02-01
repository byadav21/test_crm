
{if strval($fields.assigned_flag.value) == "1" || strval($fields.assigned_flag.value) == "yes" || strval($fields.assigned_flag.value) == "on"} 
{assign var="checked" value='checked="checked"'}
{else}
{assign var="checked" value=""}
{/if}
<input type="hidden" name="{$fields.assigned_flag.name}" value="0"> 
<input type="checkbox" id="{$fields.assigned_flag.name}" 
name="{$fields.assigned_flag.name}" 
value="1" title='' tabindex="1" {$checked} >
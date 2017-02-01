
{if strval($fields.deleted.value) == "1" || strval($fields.deleted.value) == "yes" || strval($fields.deleted.value) == "on"} 
{assign var="checked" value='checked="checked"'}
{else}
{assign var="checked" value=""}
{/if}
<input type="hidden" name="{$fields.deleted.name}" value="0"> 
<input type="checkbox" id="{$fields.deleted.name}" 
name="{$fields.deleted.name}" 
value="1" title='' tabindex="1" {$checked} >
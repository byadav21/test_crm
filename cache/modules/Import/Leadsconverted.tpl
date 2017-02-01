
{if strval($fields.converted.value) == "1" || strval($fields.converted.value) == "yes" || strval($fields.converted.value) == "on"} 
{assign var="checked" value='checked="checked"'}
{else}
{assign var="checked" value=""}
{/if}
<input type="hidden" name="{$fields.converted.name}" value="0"> 
<input type="checkbox" id="{$fields.converted.name}" 
name="{$fields.converted.name}" 
value="1" title='' tabindex="1" {$checked} >
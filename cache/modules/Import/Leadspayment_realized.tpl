
{if strval($fields.payment_realized.value) == "1" || strval($fields.payment_realized.value) == "yes" || strval($fields.payment_realized.value) == "on"} 
{assign var="checked" value='checked="checked"'}
{else}
{assign var="checked" value=""}
{/if}
<input type="hidden" name="{$fields.payment_realized.name}" value="0"> 
<input type="checkbox" id="{$fields.payment_realized.name}" 
name="{$fields.payment_realized.name}" 
value="1" title='' tabindex="1" {$checked} >
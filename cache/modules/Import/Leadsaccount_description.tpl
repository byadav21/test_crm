
{if empty($fields.account_description.value)}
{assign var="value" value=$fields.account_description.default_value }
{else}
{assign var="value" value=$fields.account_description.value }
{/if}  




<textarea  id='{$fields.account_description.name}' name='{$fields.account_description.name}'
rows="4" 
cols="60" 
title='' tabindex="1" 
 >{$value}</textarea>



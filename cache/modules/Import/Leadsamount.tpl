
{if strlen($fields.amount.value) <= 0}
{assign var="value" value=$fields.amount.default_value }
{else}
{assign var="value" value=$fields.amount.value }
{/if}  
<input type='text' name='{$fields.amount.name}'
id='{$fields.amount.name}'
size='30'
maxlength='18'value='{sugar_number_format var=$value precision=2 }'
title=''
tabindex='1'
 
>
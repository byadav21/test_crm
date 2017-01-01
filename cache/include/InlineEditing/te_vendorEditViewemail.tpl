
{if strlen($fields.email.value) <= 0}
{assign var="value" value=$fields.email.default_value }
{else}
{assign var="value" value=$fields.email.value }
{/if}  
<input type='text' name='{$fields.email.name}' 
    id='{$fields.email.name}' size='30' 
    maxlength='100' 
    value='{$value}' title=''  tabindex='1'      >
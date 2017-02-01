
{if strlen($fields.utm.value) <= 0}
{assign var="value" value=$fields.utm.default_value }
{else}
{assign var="value" value=$fields.utm.value }
{/if}  
<input type='text' name='{$fields.utm.name}' 
    id='{$fields.utm.name}' size='30' 
    maxlength='50' 
    value='{$value}' title=''  tabindex='1'      >
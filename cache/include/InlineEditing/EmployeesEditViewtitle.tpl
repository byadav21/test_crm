
{if strlen($fields.title.value) <= 0}
{assign var="value" value=$fields.title.default_value }
{else}
{assign var="value" value=$fields.title.value }
{/if}  
<input type='text' name='{$fields.title.name}' 
    id='{$fields.title.name}' size='30' 
    maxlength='50' 
    value='{$value}' title=''  tabindex='1'      >

{if strlen($fields.first_name.value) <= 0}
{assign var="value" value=$fields.first_name.default_value }
{else}
{assign var="value" value=$fields.first_name.value }
{/if}  
<input type='text' name='{$fields.first_name.name}' 
    id='{$fields.first_name.name}' size='30' 
    maxlength='100' 
    value='{$value}' title=''  tabindex='1'      >
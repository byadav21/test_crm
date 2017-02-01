
{if strlen($fields.department.value) <= 0}
{assign var="value" value=$fields.department.default_value }
{else}
{assign var="value" value=$fields.department.value }
{/if}  
<input type='text' name='{$fields.department.name}' 
    id='{$fields.department.name}' size='30' 
    maxlength='100' 
    value='{$value}' title=''  tabindex='1'      >
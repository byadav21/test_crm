
{if strlen($fields.created_by.value) <= 0}
{assign var="value" value=$fields.created_by.default_value }
{else}
{assign var="value" value=$fields.created_by.value }
{/if}  
<input type='text' name='{$fields.created_by.name}' 
    id='{$fields.created_by.name}' size='30' 
     
    value='{$value}' title=''  tabindex='1'      >
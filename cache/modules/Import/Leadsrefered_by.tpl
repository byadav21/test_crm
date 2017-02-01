
{if strlen($fields.refered_by.value) <= 0}
{assign var="value" value=$fields.refered_by.default_value }
{else}
{assign var="value" value=$fields.refered_by.value }
{/if}  
<input type='text' name='{$fields.refered_by.name}' 
    id='{$fields.refered_by.name}' size='30' 
    maxlength='100' 
    value='{$value}' title=''  tabindex='1'      >
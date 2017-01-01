
{if strlen($fields.clp.value) <= 0}
{assign var="value" value=$fields.clp.default_value }
{else}
{assign var="value" value=$fields.clp.value }
{/if}  
<input type='text' name='{$fields.clp.name}' 
    id='{$fields.clp.name}' size='30' 
    maxlength='10' 
    value='{$value}' title=''  tabindex='1'      >
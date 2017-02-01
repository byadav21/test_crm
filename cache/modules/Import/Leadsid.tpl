
{if strlen($fields.id.value) <= 0}
{assign var="value" value=$fields.id.default_value }
{else}
{assign var="value" value=$fields.id.value }
{/if}  
<input type='text' name='{$fields.id.name}' 
    id='{$fields.id.name}' size='30' 
     
    value='{$value}' title=''  tabindex='1'      >
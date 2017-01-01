
{if strlen($fields.email1.value) <= 0}
{assign var="value" value=$fields.email1.default_value }
{else}
{assign var="value" value=$fields.email1.value }
{/if}  
<input type='text' name='{$fields.email1.name}' 
    id='{$fields.email1.name}' size='30' 
     
    value='{$value}' title=''  tabindex='1'      >
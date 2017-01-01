
{if strlen($fields.company_c.value) <= 0}
{assign var="value" value=$fields.company_c.default_value }
{else}
{assign var="value" value=$fields.company_c.value }
{/if}  
<input type='text' name='{$fields.company_c.name}' 
    id='{$fields.company_c.name}' size='30' 
    maxlength='255' 
    value='{$value}' title=''  tabindex='1'      >
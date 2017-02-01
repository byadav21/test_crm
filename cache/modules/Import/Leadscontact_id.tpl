
{if strlen($fields.contact_id.value) <= 0}
{assign var="value" value=$fields.contact_id.default_value }
{else}
{assign var="value" value=$fields.contact_id.value }
{/if}  
<input type='text' name='{$fields.contact_id.name}' 
    id='{$fields.contact_id.name}' size='30' 
     
    value='{$value}' title=''  tabindex='1'      >
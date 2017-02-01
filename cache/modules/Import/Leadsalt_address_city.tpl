
{if strlen($fields.alt_address_city.value) <= 0}
{assign var="value" value=$fields.alt_address_city.default_value }
{else}
{assign var="value" value=$fields.alt_address_city.value }
{/if}  
<input type='text' name='{$fields.alt_address_city.name}' 
    id='{$fields.alt_address_city.name}' size='30' 
    maxlength='100' 
    value='{$value}' title=''  tabindex='1'      >
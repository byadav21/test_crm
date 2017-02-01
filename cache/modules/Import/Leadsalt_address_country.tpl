
{if strlen($fields.alt_address_country.value) <= 0}
{assign var="value" value=$fields.alt_address_country.default_value }
{else}
{assign var="value" value=$fields.alt_address_country.value }
{/if}  
<input type='text' name='{$fields.alt_address_country.name}' 
    id='{$fields.alt_address_country.name}' size='30' 
     
    value='{$value}' title=''  tabindex='1'      >

{if strlen($fields.primary_address_country.value) <= 0}
{assign var="value" value=$fields.primary_address_country.default_value }
{else}
{assign var="value" value=$fields.primary_address_country.value }
{/if}  
<input type='text' name='{$fields.primary_address_country.name}' 
    id='{$fields.primary_address_country.name}' size='30' 
     
    value='{$value}' title=''  tabindex='1'      >
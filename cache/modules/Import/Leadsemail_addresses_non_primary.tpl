
{if strlen($fields.email_addresses_non_primary.value) <= 0}
{assign var="value" value=$fields.email_addresses_non_primary.default_value }
{else}
{assign var="value" value=$fields.email_addresses_non_primary.value }
{/if}  
<input type='text' name='{$fields.email_addresses_non_primary.name}' 
    id='{$fields.email_addresses_non_primary.name}' size='30' 
     
    value='{$value}' title=''  tabindex='1'      >
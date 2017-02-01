
{if strlen($fields.alt_address_state.value) <= 0}
{assign var="value" value=$fields.alt_address_state.default_value }
{else}
{assign var="value" value=$fields.alt_address_state.value }
{/if}  
<input type='text' name='{$fields.alt_address_state.name}' 
    id='{$fields.alt_address_state.name}' size='30' 
    maxlength='100' 
    value='{$value}' title=''  tabindex='1'      >
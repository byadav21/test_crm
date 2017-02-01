
{if strlen($fields.reference_number.value) <= 0}
{assign var="value" value=$fields.reference_number.default_value }
{else}
{assign var="value" value=$fields.reference_number.value }
{/if}  
<input type='text' name='{$fields.reference_number.name}' 
    id='{$fields.reference_number.name}' size='30' 
    maxlength='100' 
    value='{$value}' title=''  tabindex='1'      >
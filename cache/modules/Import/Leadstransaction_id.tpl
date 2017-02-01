
{if strlen($fields.transaction_id.value) <= 0}
{assign var="value" value=$fields.transaction_id.default_value }
{else}
{assign var="value" value=$fields.transaction_id.value }
{/if}  
<input type='text' name='{$fields.transaction_id.name}' 
    id='{$fields.transaction_id.name}' size='30' 
    maxlength='100' 
    value='{$value}' title=''  tabindex='1'      >
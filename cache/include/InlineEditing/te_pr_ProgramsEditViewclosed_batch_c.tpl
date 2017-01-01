
{if strlen($fields.closed_batch_c.value) <= 0}
{assign var="value" value=$fields.closed_batch_c.default_value }
{else}
{assign var="value" value=$fields.closed_batch_c.value }
{/if}  
<input type='text' name='{$fields.closed_batch_c.name}' 
    id='{$fields.closed_batch_c.name}' size='30' 
    maxlength='255' 
    value='{$value}' title='closed_batch Status'  tabindex='1'      >
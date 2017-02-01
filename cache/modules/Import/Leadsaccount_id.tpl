
{if strlen($fields.account_id.value) <= 0}
{assign var="value" value=$fields.account_id.default_value }
{else}
{assign var="value" value=$fields.account_id.value }
{/if}  
<input type='text' name='{$fields.account_id.name}' 
    id='{$fields.account_id.name}' size='30' 
     
    value='{$value}' title=''  tabindex='1'      >
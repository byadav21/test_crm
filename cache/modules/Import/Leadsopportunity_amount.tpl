
{if strlen($fields.opportunity_amount.value) <= 0}
{assign var="value" value=$fields.opportunity_amount.default_value }
{else}
{assign var="value" value=$fields.opportunity_amount.value }
{/if}  
<input type='text' name='{$fields.opportunity_amount.name}' 
    id='{$fields.opportunity_amount.name}' size='30' 
    maxlength='50' 
    value='{$value}' title=''  tabindex='1'      >
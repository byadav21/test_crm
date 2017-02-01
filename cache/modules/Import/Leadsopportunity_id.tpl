
{if strlen($fields.opportunity_id.value) <= 0}
{assign var="value" value=$fields.opportunity_id.default_value }
{else}
{assign var="value" value=$fields.opportunity_id.value }
{/if}  
<input type='text' name='{$fields.opportunity_id.name}' 
    id='{$fields.opportunity_id.name}' size='30' 
     
    value='{$value}' title=''  tabindex='1'      >
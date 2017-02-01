
{if strlen($fields.opportunity_name.value) <= 0}
{assign var="value" value=$fields.opportunity_name.default_value }
{else}
{assign var="value" value=$fields.opportunity_name.value }
{/if}  
<input type='text' name='{$fields.opportunity_name.name}' 
    id='{$fields.opportunity_name.name}' size='30' 
    maxlength='255' 
    value='{$value}' title=''  tabindex='1'      >
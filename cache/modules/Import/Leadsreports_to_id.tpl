
{if strlen($fields.reports_to_id.value) <= 0}
{assign var="value" value=$fields.reports_to_id.default_value }
{else}
{assign var="value" value=$fields.reports_to_id.value }
{/if}  
<input type='text' name='{$fields.reports_to_id.name}' 
    id='{$fields.reports_to_id.name}' size='30' 
     
    value='{$value}' title=''  tabindex='1'      >
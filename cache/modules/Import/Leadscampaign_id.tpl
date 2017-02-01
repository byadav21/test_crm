
{if strlen($fields.campaign_id.value) <= 0}
{assign var="value" value=$fields.campaign_id.default_value }
{else}
{assign var="value" value=$fields.campaign_id.value }
{/if}  
<input type='text' name='{$fields.campaign_id.name}' 
    id='{$fields.campaign_id.name}' size='30' 
     
    value='{$value}' title=''  tabindex='1'      >
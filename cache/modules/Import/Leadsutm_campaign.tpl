
{if strlen($fields.utm_campaign.value) <= 0}
{assign var="value" value=$fields.utm_campaign.default_value }
{else}
{assign var="value" value=$fields.utm_campaign.value }
{/if}  
<input type='text' name='{$fields.utm_campaign.name}' 
    id='{$fields.utm_campaign.name}' size='30' 
    maxlength='50' 
    value='{$value}' title=''  tabindex='1'      >
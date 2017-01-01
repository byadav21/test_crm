
{if strlen($fields.utm_url.value) <= 0}
{assign var="value" value=$fields.utm_url.default_value }
{else}
{assign var="value" value=$fields.utm_url.value }
{/if}  
<input type='text' name='{$fields.utm_url.name}' 
    id='{$fields.utm_url.name}' size='30' 
     
    value='{$value}' title=''  tabindex='1'      >
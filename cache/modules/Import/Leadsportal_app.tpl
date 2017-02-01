
{if strlen($fields.portal_app.value) <= 0}
{assign var="value" value=$fields.portal_app.default_value }
{else}
{assign var="value" value=$fields.portal_app.value }
{/if}  
<input type='text' name='{$fields.portal_app.name}' 
    id='{$fields.portal_app.name}' size='30' 
    maxlength='255' 
    value='{$value}' title=''  tabindex='1'      >

{if strlen($fields.city_c.value) <= 0}
{assign var="value" value=$fields.city_c.default_value }
{else}
{assign var="value" value=$fields.city_c.value }
{/if}  
<input type='text' name='{$fields.city_c.name}' 
    id='{$fields.city_c.name}' size='30' 
    maxlength='255' 
    value='{$value}' title=''  tabindex='1'      >

{if strlen($fields.user_name.value) <= 0}
{assign var="value" value=$fields.user_name.default_value }
{else}
{assign var="value" value=$fields.user_name.value }
{/if}  
<input type='text' name='{$fields.user_name.name}' 
    id='{$fields.user_name.name}' size='30' 
    maxlength='60' 
    value='{$value}' title=''  tabindex='1'      >
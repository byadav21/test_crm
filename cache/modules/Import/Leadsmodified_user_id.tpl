
{if strlen($fields.modified_user_id.value) <= 0}
{assign var="value" value=$fields.modified_user_id.default_value }
{else}
{assign var="value" value=$fields.modified_user_id.value }
{/if}  
<input type='text' name='{$fields.modified_user_id.name}' 
    id='{$fields.modified_user_id.name}' size='30' 
     
    value='{$value}' title=''  tabindex='1'      >
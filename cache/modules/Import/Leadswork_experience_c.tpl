
{if strlen($fields.work_experience_c.value) <= 0}
{assign var="value" value=$fields.work_experience_c.default_value }
{else}
{assign var="value" value=$fields.work_experience_c.value }
{/if}  
<input type='text' name='{$fields.work_experience_c.name}' 
    id='{$fields.work_experience_c.name}' size='30' 
    maxlength='255' 
    value='{$value}' title=''  tabindex='1'      >

{if strlen($fields.education_c.value) <= 0}
{assign var="value" value=$fields.education_c.default_value }
{else}
{assign var="value" value=$fields.education_c.value }
{/if}  
<input type='text' name='{$fields.education_c.name}' 
    id='{$fields.education_c.name}' size='30' 
    maxlength='255' 
    value='{$value}' title=''  tabindex='1'      >
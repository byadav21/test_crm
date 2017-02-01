
{if strlen($fields.age_c.value) <= 0}
{assign var="value" value=$fields.age_c.default_value }
{else}
{assign var="value" value=$fields.age_c.value }
{/if}  
<input type='text' name='{$fields.age_c.name}' 
id='{$fields.age_c.name}' size='30' maxlength='20' value='{sugar_number_format precision=0 var=$value}' title='' tabindex='1'    >
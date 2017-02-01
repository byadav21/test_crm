
{if strval($fields.previous_courses_from_te_c.value) == "1" || strval($fields.previous_courses_from_te_c.value) == "yes" || strval($fields.previous_courses_from_te_c.value) == "on"} 
{assign var="checked" value='checked="checked"'}
{else}
{assign var="checked" value=""}
{/if}
<input type="hidden" name="{$fields.previous_courses_from_te_c.name}" value="0"> 
<input type="checkbox" id="{$fields.previous_courses_from_te_c.name}" 
name="{$fields.previous_courses_from_te_c.name}" 
value="1" title='' tabindex="1" {$checked} >
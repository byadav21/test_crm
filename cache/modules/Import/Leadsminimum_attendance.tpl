
{if strlen($fields.minimum_attendance.value) <= 0}
{assign var="value" value=$fields.minimum_attendance.default_value }
{else}
{assign var="value" value=$fields.minimum_attendance.value }
{/if}  
<input type='text' name='{$fields.minimum_attendance.name}' 
id='{$fields.minimum_attendance.name}' size='30' maxlength='11' value='{sugar_number_format precision=0 var=$value}' title='' tabindex='1'    >
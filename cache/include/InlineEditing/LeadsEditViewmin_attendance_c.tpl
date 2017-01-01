
{if strlen($fields.min_attendance_c.value) <= 0}
{assign var="value" value=$fields.min_attendance_c.default_value }
{else}
{assign var="value" value=$fields.min_attendance_c.value }
{/if}  
<input type='text' name='{$fields.min_attendance_c.name}' 
    id='{$fields.min_attendance_c.name}' size='30' 
    maxlength='255' 
    value='{$value}' title=''  tabindex='1'      >
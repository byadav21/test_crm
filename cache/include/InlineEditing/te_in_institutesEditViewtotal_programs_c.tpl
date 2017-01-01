
{if strlen($fields.total_programs_c.value) <= 0}
{assign var="value" value=$fields.total_programs_c.default_value }
{else}
{assign var="value" value=$fields.total_programs_c.value }
{/if}  
<input type='text' name='{$fields.total_programs_c.name}' 
    id='{$fields.total_programs_c.name}' size='30' 
    maxlength='255' 
    value='{$value}' title=''  tabindex='1'      >

{if strlen($fields.program.value) <= 0}
{assign var="value" value=$fields.program.default_value }
{else}
{assign var="value" value=$fields.program.value }
{/if}  
<input type='text' name='{$fields.program.name}' 
    id='{$fields.program.name}' size='30' 
     
    value='{$value}' title=''  tabindex='1'      >
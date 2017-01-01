
{if strlen($fields.programs.value) <= 0}
{assign var="value" value=$fields.programs.default_value }
{else}
{assign var="value" value=$fields.programs.value }
{/if}  
<input type='text' name='{$fields.programs.name}' 
    id='{$fields.programs.name}' size='30' 
     
    value='{$value}' title=''  tabindex='1'      >

{if strlen($fields.assistant.value) <= 0}
{assign var="value" value=$fields.assistant.default_value }
{else}
{assign var="value" value=$fields.assistant.value }
{/if}  
<input type='text' name='{$fields.assistant.name}' 
    id='{$fields.assistant.name}' size='30' 
    maxlength='75' 
    value='{$value}' title=''  tabindex='1'      >
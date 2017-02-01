
{if strlen($fields.channel.value) <= 0}
{assign var="value" value=$fields.channel.default_value }
{else}
{assign var="value" value=$fields.channel.value }
{/if}  
<input type='text' name='{$fields.channel.name}' 
    id='{$fields.channel.name}' size='30' 
    maxlength='50' 
    value='{$value}' title=''  tabindex='1'      >

{if strlen($fields.neoxstatus.value) <= 0}
{assign var="value" value=$fields.neoxstatus.default_value }
{else}
{assign var="value" value=$fields.neoxstatus.value }
{/if}  
<input type='text' name='{$fields.neoxstatus.name}' 
    id='{$fields.neoxstatus.name}' size='30' 
     
    value='{$value}' title=''  tabindex='1'      >

{if strlen($fields.feepaid.value) <= 0}
{assign var="value" value=$fields.feepaid.default_value }
{else}
{assign var="value" value=$fields.feepaid.value }
{/if}  
<input type='text' name='{$fields.feepaid.name}' 
    id='{$fields.feepaid.name}' size='30' 
     
    value='{$value}' title=''  tabindex='1'      >
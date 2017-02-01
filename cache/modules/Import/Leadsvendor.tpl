
{if strlen($fields.vendor.value) <= 0}
{assign var="value" value=$fields.vendor.default_value }
{else}
{assign var="value" value=$fields.vendor.value }
{/if}  
<input type='text' name='{$fields.vendor.name}' 
    id='{$fields.vendor.name}' size='30' 
    maxlength='50' 
    value='{$value}' title=''  tabindex='1'      >

{if strlen($fields.batch_status_class_c.value) <= 0}
{assign var="value" value=$fields.batch_status_class_c.default_value }
{else}
{assign var="value" value=$fields.batch_status_class_c.value }
{/if}  
<input type='text' name='{$fields.batch_status_class_c.name}' 
    id='{$fields.batch_status_class_c.name}' size='30' 
    maxlength='255' 
    value='{$value}' title=''  tabindex='1'      >
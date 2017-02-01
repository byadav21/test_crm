
{if strlen($fields.functional_area_c.value) <= 0}
{assign var="value" value=$fields.functional_area_c.default_value }
{else}
{assign var="value" value=$fields.functional_area_c.value }
{/if}  
<input type='text' name='{$fields.functional_area_c.name}' 
    id='{$fields.functional_area_c.name}' size='30' 
    maxlength='255' 
    value='{$value}' title=''  tabindex='1'      >

{if strlen($fields.fee_inr.value) <= 0}
{assign var="value" value=$fields.fee_inr.default_value }
{else}
{assign var="value" value=$fields.fee_inr.value }
{/if}  
<input type='text' name='{$fields.fee_inr.name}' 
id='{$fields.fee_inr.name}' size='30' maxlength='11' value='{sugar_number_format precision=0 var=$value}' title='' tabindex='1'    >
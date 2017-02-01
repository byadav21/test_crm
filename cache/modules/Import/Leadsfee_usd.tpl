
{if strlen($fields.fee_usd.value) <= 0}
{assign var="value" value=$fields.fee_usd.default_value }
{else}
{assign var="value" value=$fields.fee_usd.value }
{/if}  
<input type='text' name='{$fields.fee_usd.name}' 
id='{$fields.fee_usd.name}' size='30' maxlength='11' value='{sugar_number_format precision=0 var=$value}' title='' tabindex='1'    >
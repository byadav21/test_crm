
<input type="text" name="{$fields.vendor.name}" class="sqsEnabled" tabindex="1" id="{$fields.vendor.name}" size="" value="{$fields.vendor.value}" title='' autocomplete="off"  	 >
<input type="hidden" name="{$fields.vendor.id_name}" 
	id="{$fields.vendor.id_name}" 
	value="{$fields.te_vendor_id_c.value}">
<span class="id-ff multiple">
<button type="button" name="btn_{$fields.vendor.name}" id="btn_{$fields.vendor.name}" tabindex="1" title="{sugar_translate label="LBL_SELECT_BUTTON_TITLE"}" class="button firstChild" value="{sugar_translate label="LBL_SELECT_BUTTON_LABEL"}"
onclick='open_popup(
    "{$fields.vendor.module}", 
	600, 
	400, 
	"", 
	true, 
	false, 
	{literal}{"call_back_function":"set_return","form_name":"EditView","field_to_name_array":{"id":{/literal}"{$fields.vendor.id_name}"{literal},"name":{/literal}"{$fields.vendor.name}"{literal}}}{/literal}, 
	"single", 
	true
);' ><img src="{sugar_getimagepath file="id-ff-select.png"}"></button><button type="button" name="btn_clr_{$fields.vendor.name}" id="btn_clr_{$fields.vendor.name}" tabindex="1" title="{sugar_translate label="LBL_ACCESSKEY_CLEAR_RELATE_TITLE"}"  class="button lastChild"
onclick="SUGAR.clearRelateField(this.form, '{$fields.vendor.name}', '{$fields.vendor.id_name}');"  value="{sugar_translate label="LBL_ACCESSKEY_CLEAR_RELATE_LABEL"}" ><img src="{sugar_getimagepath file="id-ff-clear.png"}"></button>
</span>
<script type="text/javascript">
SUGAR.util.doWhen(
		"typeof(sqs_objects) != 'undefined' && typeof(sqs_objects['{$form_name}_{$fields.vendor.name}']) != 'undefined'",
		enableQS
);
</script>
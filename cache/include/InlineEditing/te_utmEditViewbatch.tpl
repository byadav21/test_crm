
<input type="text" name="{$fields.batch.name}" class="sqsEnabled" tabindex="1" id="{$fields.batch.name}" size="" value="{$fields.batch.value}" title='' autocomplete="off"  	 >
<input type="hidden" name="{$fields.batch.id_name}" 
	id="{$fields.batch.id_name}" 
	value="{$fields.te_ba_batch_id_c.value}">
<span class="id-ff multiple">
<button type="button" name="btn_{$fields.batch.name}" id="btn_{$fields.batch.name}" tabindex="1" title="{sugar_translate label="LBL_SELECT_BUTTON_TITLE"}" class="button firstChild" value="{sugar_translate label="LBL_SELECT_BUTTON_LABEL"}"
onclick='open_popup(
    "{$fields.batch.module}", 
	600, 
	400, 
	"", 
	true, 
	false, 
	{literal}{"call_back_function":"set_return","form_name":"EditView","field_to_name_array":{"id":{/literal}"{$fields.batch.id_name}"{literal},"batch_code":{/literal}"{$fields.batch.name}"{literal}}}{/literal}, 
	"single", 
	true
);' ><img src="{sugar_getimagepath file="id-ff-select.png"}"></button><button type="button" name="btn_clr_{$fields.batch.name}" id="btn_clr_{$fields.batch.name}" tabindex="1" title="{sugar_translate label="LBL_ACCESSKEY_CLEAR_RELATE_TITLE"}"  class="button lastChild"
onclick="SUGAR.clearRelateField(this.form, '{$fields.batch.name}', '{$fields.batch.id_name}');"  value="{sugar_translate label="LBL_ACCESSKEY_CLEAR_RELATE_LABEL"}" ><img src="{sugar_getimagepath file="id-ff-clear.png"}"></button>
</span>
<script type="text/javascript">
SUGAR.util.doWhen(
		"typeof(sqs_objects) != 'undefined' && typeof(sqs_objects['{$form_name}_{$fields.batch.name}']) != 'undefined'",
		enableQS
);
</script>
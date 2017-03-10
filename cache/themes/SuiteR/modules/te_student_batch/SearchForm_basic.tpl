
<input type='hidden' id="orderByInput" name='orderBy' value=''/>
<input type='hidden' id="sortOrder" name='sortOrder' value=''/>
{if !isset($templateMeta.maxColumnsBasic)}
	{assign var="basicMaxColumns" value=$templateMeta.maxColumns}
{else}
    {assign var="basicMaxColumns" value=$templateMeta.maxColumnsBasic}
{/if}
<script>
{literal}
	$(function() {
	var $dialog = $('<div></div>')
		.html(SUGAR.language.get('app_strings', 'LBL_SEARCH_HELP_TEXT'))
		.dialog({
			autoOpen: false,
			title: SUGAR.language.get('app_strings', 'LBL_HELP'),
			width: 700
		});
		
		$('#filterHelp').click(function() {
		$dialog.dialog('open');
		// prevent the default action, e.g., following a link
	});
	
	});
{/literal}
</script>

<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
      
      
	{counter assign=index}
	{math equation="left % right"
   		  left=$index
          right=$basicMaxColumns
          assign=modVal
    }
	{if ($index % $basicMaxColumns == 1 && $index != 1)}
		</tr><tr>
	{/if}
	
	<td scope="row" nowrap="nowrap" width='1%' >
		
		<label for='te_student_te_student_batch_1_name_basic' >{sugar_translate label='LBL_TE_STUDENT_TE_STUDENT_BATCH_1_FROM_TE_STUDENT_TITLE' module='te_student_batch'}</label>
    	</td>

	
	<td  nowrap="nowrap" width='1%'>
			
<input type="text" name="{$fields.te_student_te_student_batch_1_name_basic.name}"  class="sqsEnabled"   id="{$fields.te_student_te_student_batch_1_name_basic.name}" size="" value="{$fields.te_student_te_student_batch_1_name_basic.value}" title='' autocomplete="off"  >
<input type="hidden"  id="{$fields.te_student_te_student_batch_1te_student_ida_basic.name}" value="{$fields.te_student_te_student_batch_1te_student_ida_basic.value}">
<span class="id-ff multiple">
<button type="button" name="btn_{$fields.te_student_te_student_batch_1_name_basic.name}"   title="{$APP.LBL_SELECT_BUTTON_TITLE}" class="button firstChild" value="{$APP.LBL_SELECT_BUTTON_LABEL}" onclick='open_popup("{$fields.te_student_te_student_batch_1_name_basic.module}", 600, 400, "", true, false, {literal}{"call_back_function":"set_return","form_name":"search_form","field_to_name_array":{"id":"te_student_te_student_batch_1te_student_ida_basic","name":"te_student_te_student_batch_1_name_basic"}}{/literal}, "single", true);'>{sugar_getimage alt=$app_strings.LBL_ID_FF_SELECT name="id-ff-select" ext=".png" other_attributes=''}</button><button type="button" name="btn_clr_{$fields.te_student_te_student_batch_1_name_basic.name}"   title="{$APP.LBL_CLEAR_BUTTON_TITLE}" class="button lastChild" onclick="this.form.{$fields.te_student_te_student_batch_1_name_basic.name}.value = ''; this.form.{$fields.te_student_te_student_batch_1te_student_ida_basic.name}.value = '';" value="{$APP.LBL_CLEAR_BUTTON_LABEL}">{sugar_getimage name="id-ff-clear" alt=$app_strings.LBL_ID_FF_CLEAR ext=".png" other_attributes=''}</button>
</span>

   	   	</td>
    
      
	{counter assign=index}
	{math equation="left % right"
   		  left=$index
          right=$basicMaxColumns
          assign=modVal
    }
	{if ($index % $basicMaxColumns == 1 && $index != 1)}
		</tr><tr>
	{/if}
	
	<td scope="row" nowrap="nowrap" width='1%' >
		
		<label for='email_basic' >{sugar_translate label='Email' module='te_student_batch'}</label>
    	</td>

	
	<td  nowrap="nowrap" width='1%'>
			
{if strlen($fields.email_basic.value) <= 0}
{assign var="value" value=$fields.email_basic.default_value }
{else}
{assign var="value" value=$fields.email_basic.value }
{/if}  
<input type='text' name='{$fields.email_basic.name}' 
    id='{$fields.email_basic.name}' size='30' 
     
    value='{$value}' title=''      >
   	   	</td>
    
      
	{counter assign=index}
	{math equation="left % right"
   		  left=$index
          right=$basicMaxColumns
          assign=modVal
    }
	{if ($index % $basicMaxColumns == 1 && $index != 1)}
		</tr><tr>
	{/if}
	
	<td scope="row" nowrap="nowrap" width='1%' >
		
		<label for='institute_basic' >{sugar_translate label='LBL_INSTITUTE' module='te_student_batch'}</label>
    	</td>

	
	<td  nowrap="nowrap" width='1%'>
			
<input type="text" name="{$fields.institute_basic.name}"  class="sqsEnabled"   id="{$fields.institute_basic.name}" size="" value="{$fields.institute_basic.value}" title='' autocomplete="off"  >
<input type="hidden"  id="{$fields.te_in_institutes_id_c_basic.name}" value="{$fields.te_in_institutes_id_c_basic.value}">
<span class="id-ff multiple">
<button type="button" name="btn_{$fields.institute_basic.name}"   title="{$APP.LBL_SELECT_BUTTON_TITLE}" class="button firstChild" value="{$APP.LBL_SELECT_BUTTON_LABEL}" onclick='open_popup("{$fields.institute_basic.module}", 600, 400, "", true, false, {literal}{"call_back_function":"set_return","form_name":"search_form","field_to_name_array":{"id":"te_in_institutes_id_c_basic","name":"institute_basic"}}{/literal}, "single", true);'>{sugar_getimage alt=$app_strings.LBL_ID_FF_SELECT name="id-ff-select" ext=".png" other_attributes=''}</button><button type="button" name="btn_clr_{$fields.institute_basic.name}"   title="{$APP.LBL_CLEAR_BUTTON_TITLE}" class="button lastChild" onclick="this.form.{$fields.institute_basic.name}.value = ''; this.form.{$fields.te_in_institutes_id_c_basic.name}.value = '';" value="{$APP.LBL_CLEAR_BUTTON_LABEL}">{sugar_getimage name="id-ff-clear" alt=$app_strings.LBL_ID_FF_CLEAR ext=".png" other_attributes=''}</button>
</span>

   	   	</td>
    
      
	{counter assign=index}
	{math equation="left % right"
   		  left=$index
          right=$basicMaxColumns
          assign=modVal
    }
	{if ($index % $basicMaxColumns == 1 && $index != 1)}
		</tr><tr>
	{/if}
	
	<td scope="row" nowrap="nowrap" width='1%' >
		
		<label for='program_basic' >{sugar_translate label='LBL_PROGRAM' module='te_student_batch'}</label>
    	</td>

	
	<td  nowrap="nowrap" width='1%'>
			
<input type="text" name="{$fields.program_basic.name}"  class="sqsEnabled"   id="{$fields.program_basic.name}" size="" value="{$fields.program_basic.value}" title='' autocomplete="off"  >
<input type="hidden"  id="{$fields.te_pr_programs_id_c_basic.name}" value="{$fields.te_pr_programs_id_c_basic.value}">
<span class="id-ff multiple">
<button type="button" name="btn_{$fields.program_basic.name}"   title="{$APP.LBL_SELECT_BUTTON_TITLE}" class="button firstChild" value="{$APP.LBL_SELECT_BUTTON_LABEL}" onclick='open_popup("{$fields.program_basic.module}", 600, 400, "", true, false, {literal}{"call_back_function":"set_return","form_name":"search_form","field_to_name_array":{"id":"te_pr_programs_id_c_basic","name":"program_basic"}}{/literal}, "single", true);'>{sugar_getimage alt=$app_strings.LBL_ID_FF_SELECT name="id-ff-select" ext=".png" other_attributes=''}</button><button type="button" name="btn_clr_{$fields.program_basic.name}"   title="{$APP.LBL_CLEAR_BUTTON_TITLE}" class="button lastChild" onclick="this.form.{$fields.program_basic.name}.value = ''; this.form.{$fields.te_pr_programs_id_c_basic.name}.value = '';" value="{$APP.LBL_CLEAR_BUTTON_LABEL}">{sugar_getimage name="id-ff-clear" alt=$app_strings.LBL_ID_FF_CLEAR ext=".png" other_attributes=''}</button>
</span>

   	   	</td>
    
      
	{counter assign=index}
	{math equation="left % right"
   		  left=$index
          right=$basicMaxColumns
          assign=modVal
    }
	{if ($index % $basicMaxColumns == 1 && $index != 1)}
		</tr><tr>
	{/if}
	
	<td scope="row" nowrap="nowrap" width='1%' >
		
		<label for='batch_basic' >{sugar_translate label='LBL_BATCH' module='te_student_batch'}</label>
    	</td>

	
	<td  nowrap="nowrap" width='1%'>
			
<input type="text" name="{$fields.batch_basic.name}"  class="sqsEnabled"   id="{$fields.batch_basic.name}" size="" value="{$fields.batch_basic.value}" title='' autocomplete="off"  >
<input type="hidden"  id="{$fields.te_ba_batch_id_c_basic.name}" value="{$fields.te_ba_batch_id_c_basic.value}">
<span class="id-ff multiple">
<button type="button" name="btn_{$fields.batch_basic.name}"   title="{$APP.LBL_SELECT_BUTTON_TITLE}" class="button firstChild" value="{$APP.LBL_SELECT_BUTTON_LABEL}" onclick='open_popup("{$fields.batch_basic.module}", 600, 400, "", true, false, {literal}{"call_back_function":"set_return","form_name":"search_form","field_to_name_array":{"id":"te_ba_batch_id_c_basic","name":"batch_basic"}}{/literal}, "single", true);'>{sugar_getimage alt=$app_strings.LBL_ID_FF_SELECT name="id-ff-select" ext=".png" other_attributes=''}</button><button type="button" name="btn_clr_{$fields.batch_basic.name}"   title="{$APP.LBL_CLEAR_BUTTON_TITLE}" class="button lastChild" onclick="this.form.{$fields.batch_basic.name}.value = ''; this.form.{$fields.te_ba_batch_id_c_basic.name}.value = '';" value="{$APP.LBL_CLEAR_BUTTON_LABEL}">{sugar_getimage name="id-ff-clear" alt=$app_strings.LBL_ID_FF_CLEAR ext=".png" other_attributes=''}</button>
</span>

   	   	</td>
    
      
	{counter assign=index}
	{math equation="left % right"
   		  left=$index
          right=$basicMaxColumns
          assign=modVal
    }
	{if ($index % $basicMaxColumns == 1 && $index != 1)}
		</tr><tr>
	{/if}
	
	<td scope="row" nowrap="nowrap" width='1%' >
		
		<label for='status_basic' >{sugar_translate label='LBL_STATUS' module='te_student_batch'}</label>
    	</td>

	
	<td  nowrap="nowrap" width='1%'>
			
{html_options id='status_basic' name='status_basic[]' options=$fields.status_basic.options size="6" style="width: 150px" multiple="1" selected=$fields.status_basic.value}
   	   	</td>
    {if $formData|@count >= $basicMaxColumns+1}
    </tr>
    <tr>
	<td colspan="{$searchTableColumnCount}">
    {else}
	<td class="sumbitButtons">
    {/if}
        <input tabindex="2" title="{$APP.LBL_SEARCH_BUTTON_TITLE}" onclick="SUGAR.savedViews.setChooser();" class="button" type="submit" name="button" value="{$APP.LBL_SEARCH_BUTTON_LABEL}" id="search_form_submit"/>&nbsp;
	    <input tabindex='2' title='{$APP.LBL_CLEAR_BUTTON_TITLE}' onclick='SUGAR.searchForm.clear_form(this.form); return false;' class='button' type='button' name='clear' id='search_form_clear' value='{$APP.LBL_CLEAR_BUTTON_LABEL}'/>
        {if $HAS_ADVANCED_SEARCH}
	    &nbsp;&nbsp;<a id="advanced_search_link" href="javascript:void(0);" accesskey="{$APP.LBL_ADV_SEARCH_LNK_KEY}" >{$APP.LNK_ADVANCED_SEARCH}</a>
	    {/if}
    </td>
	<td class="helpIcon" width="*"><img alt="Help" border='0' id="filterHelp" src='{sugar_getimagepath file="help-dashlet.gif"}'></td>
	</tr>
</table>
<script>
	{literal}
	$(document).ready(function () {
		$( '#advanced_search_link' ).one( "click", function() {
			//alert( "This will be displayed only once." );
			SUGAR.searchForm.searchFormSelect('{/literal}{$module}{literal}|advanced_search','{/literal}{$module}{literal}|basic_search');
		});
	});
	{/literal}
</script>{literal}<script language="javascript">if(typeof sqs_objects == 'undefined'){var sqs_objects = new Array;}sqs_objects['search_form_modified_by_name_basic']={"form":"search_form","method":"get_user_array","field_list":["user_name","id"],"populate_list":["modified_by_name_basic","modified_user_id_basic"],"required_list":["modified_user_id"],"conditions":[{"name":"user_name","op":"like_custom","end":"%","value":""}],"limit":"30","no_match_text":"No Match"};sqs_objects['search_form_created_by_name_basic']={"form":"search_form","method":"get_user_array","field_list":["user_name","id"],"populate_list":["created_by_name_basic","created_by_basic"],"required_list":["created_by"],"conditions":[{"name":"user_name","op":"like_custom","end":"%","value":""}],"limit":"30","no_match_text":"No Match"};sqs_objects['search_form_assigned_user_name_basic']={"form":"search_form","method":"get_user_array","field_list":["user_name","id"],"populate_list":["assigned_user_name_basic","assigned_user_id_basic"],"required_list":["assigned_user_id"],"conditions":[{"name":"user_name","op":"like_custom","end":"%","value":""}],"limit":"30","no_match_text":"No Match"};sqs_objects['search_form_program_basic']={"form":"search_form","method":"query","modules":["te_pr_Programs"],"group":"or","field_list":["name","id"],"populate_list":["program_basic","te_pr_programs_id_c_basic"],"required_list":["parent_id"],"conditions":[{"name":"name","op":"like_custom","end":"%","value":""}],"order":"name","limit":"30","no_match_text":"No Match"};sqs_objects['search_form_institute_basic']={"form":"search_form","method":"query","modules":["te_in_institutes"],"group":"or","field_list":["name","id"],"populate_list":["institute_basic","te_in_institutes_id_c_basic"],"required_list":["parent_id"],"conditions":[{"name":"name","op":"like_custom","end":"%","value":""}],"order":"name","limit":"30","no_match_text":"No Match"};sqs_objects['search_form_batch_basic']={"form":"search_form","method":"query","modules":["te_ba_Batch"],"group":"or","field_list":["name","id"],"populate_list":["batch_basic","te_ba_batch_id_c_basic"],"required_list":["parent_id"],"conditions":[{"name":"name","op":"like_custom","end":"%","value":""}],"order":"name","limit":"30","no_match_text":"No Match"};sqs_objects['search_form_lead_basic']={"form":"search_form","method":"query","modules":["Leads"],"group":"or","field_list":["name","id"],"populate_list":["lead_basic","leads_id_basic"],"required_list":["parent_id"],"conditions":[{"name":"name","op":"like_custom","end":"%","value":""}],"order":"name","limit":"30","no_match_text":"No Match"};sqs_objects['search_form_approved_by_name_basic']={"form":"search_form","method":"get_user_array","field_list":["user_name","id"],"populate_list":["approved_by_name_basic","approved_by_basic"],"required_list":["approved_by"],"conditions":[{"name":"user_name","op":"like_custom","end":"%","value":""}],"limit":"30","no_match_text":"No Match"};sqs_objects['search_form_source_basic']={"form":"search_form","method":"query","modules":["te_vendor"],"group":"or","field_list":["name","id"],"populate_list":["source_basic","te_vendor_id_c_basic"],"required_list":["parent_id"],"conditions":[{"name":"name","op":"like_custom","end":"%","value":""}],"order":"name","limit":"30","no_match_text":"No Match"};sqs_objects['search_form_te_student_te_student_batch_1_name_basic']={"form":"search_form","method":"query","modules":["te_student"],"group":"or","field_list":["name","id"],"populate_list":["te_student_te_student_batch_1_name_basic","te_student_te_student_batch_1te_student_ida_basic"],"required_list":["parent_id"],"conditions":[{"name":"name","op":"like_custom","end":"%","value":""}],"order":"name","limit":"30","no_match_text":"No Match"};</script>{/literal}
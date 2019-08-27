{*
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 ********************************************************************************/

*}





<link rel="stylesheet" href="custom/themes/SuiteR/css/uploader/fine-uploader-new.min.css" type="text/css" media="all"/>
<link rel="stylesheet" href="custom/themes/SuiteR/css/uploader/fine-uploader-gallery.min.css" type="text/css" media="all"/>
{sugar_getscript file="custom/themes/SuiteR/css/uploader/all.fine-uploader.min.js"}
{literal}

<style>
.amtvald,#amount,#refrenceid{    background-color: #f1f1f1!important;pointer-events:none;}
.boxchoose{    padding: 50px 12px;
    background: #ffffff;
    border: 1px solid #3C8DBC;
    border-radius: 15px;
    color: #3C8DBC;
    font-size: 19px;cursor:pointer}
.boxchoose:hover{background:#f1f1f1; border:1px solid silver}    

  .maincontainer input[type=text],.maincontainer select{width:100%!important} .minbtn,.minbtntx,.errdiv,#documents,#documents_label{display:none;cursor:pointer} .errdiv{color:red} .deldocs{cursor:pointer} .dompar{margin-bottom: 5px; display: block; overflow: hidden;clear:both}  #amount{pointer-events:none;opacity:0.8} .action_buttons{display: inline-block;}.uploadedimg{padding: 5px 0;border-bottom: 1px dotted #000000; margin-bottom: 0px;    display: block;    overflow: hidden;}</style>


</style>
 
    <script type="text/template" id="qq-template-gallery">
        <div class="qq-uploader-selector qq-uploader qq-gallery" qq-drop-area-text="Drop files here">
            <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
                <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
            </div>
            <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
                <span class="qq-upload-drop-area-text-selector"></span>
            </div>
            <div class="qq-upload-button-selector qq-upload-button">
                <div>Upload a file</div>
            </div>
            <span class="qq-drop-processing-selector qq-drop-processing">
                <span>Processing dropped files...</span>
                <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
            </span>
            <ul class="qq-upload-list-selector qq-upload-list" role="region" aria-live="polite" aria-relevant="additions removals">
                <li>
                    <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
                    <div class="qq-progress-bar-container-selector qq-progress-bar-container">
                        <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
                    </div>
                    <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
                    <div class="qq-thumbnail-wrapper">
                        <img class="qq-thumbnail-selector" qq-max-size="120" qq-server-scale>
                    </div>
                    <button type="button" class="qq-upload-cancel-selector qq-upload-cancel">X</button>
                    <button type="button" class="qq-upload-retry-selector qq-upload-retry">
                        <span class="qq-btn qq-retry-icon" aria-label="Retry"></span>
                        Retry
                    </button>

                    <div class="qq-file-info">
                        <div class="qq-file-name">
                            <span class="qq-upload-file-selector qq-upload-file"></span>
                            <span class="qq-edit-filename-icon-selector qq-edit-filename-icon" aria-label="Edit filename"></span>
                        </div>
                        <input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
                        <span class="qq-upload-size-selector qq-upload-size"></span>
                        <button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">
                            <span class="qq-btn qq-delete-icon" aria-label="Delete"></span>
                        </button>
                        <button type="button" class="qq-btn qq-upload-pause-selector qq-upload-pause">
                            <span class="qq-btn qq-pause-icon" aria-label="Pause"></span>
                        </button>
                        <button type="button" class="qq-btn qq-upload-continue-selector qq-upload-continue">
                            <span class="qq-btn qq-continue-icon" aria-label="Continue"></span>
                        </button>
                    </div>
                </li>
            </ul>

            <dialog class="qq-alert-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">Close</button>
                </div>
            </dialog>

            <dialog class="qq-confirm-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">No</button>
                    <button type="button" class="qq-ok-button-selector">Yes</button>
                </div>
            </dialog>

            <dialog class="qq-prompt-dialog-selector">
                <div class="qq-dialog-message-selector"></div>
                <input type="text">
                <div class="qq-dialog-buttons">
                    <button type="button" class="qq-cancel-button-selector">Cancel</button>
                    <button type="button" class="qq-ok-button-selector">Ok</button>
                </div>
            </dialog>
        </div>
    </script>
    

{/literal}





{{include file=$headerTpl}}
{sugar_include include=$includes}

<span id='tabcounterJS'><script>SUGAR.TabFields=new Array();//this will be used to track tabindexes for references</script></span>

<div id="{{$form_name}}_tabs" class="moduleTitle">
 

    {{if $useTabs}}
    {* Generate the Tab headers *}
    {{counter name="tabCount" start=-1 print=false assign="tabCount"}}
    <ul class="yui-nav">
    {{foreach name=section from=$sectionPanels key=label item=panel}}
        {{counter name="tabCount" print=false}}
        {{capture name=label_upper assign=label_upper}}{{$label|upper}}{{/capture}}
        {{if (isset($tabDefs[$label_upper].newTab) && $tabDefs[$label_upper].newTab == true)}}
        <li class="selected"><a id="tab{{$tabCount}}" href="javascript:void({{$tabCount}})"><em>{sugar_translate label='{{$label}}' module='{{$module}}'}</em></a></li>
        {{/if}}
    {{/foreach}}
    </ul>
    {{/if}}
    <div {{if $useTabs}}class="yui-content"{{/if}}>

{{assign var='tabIndexVal' value=0}}
{{* Loop through all top level panels first *}}
{{counter name="panelCount" start=-1 print=false assign="panelCount"}}
{{counter name="tabCount" start=-1 print=false assign="tabCount"}}
{{foreach name=section from=$sectionPanels key=label item=panel}}
{{counter name="panelCount" print=false}}
{{capture name=label_upper assign=label_upper}}{{$label|upper}}{{/capture}}
  {{if (isset($tabDefs[$label_upper].newTab) && $tabDefs[$label_upper].newTab == true)}}
    {{counter name="tabCount" print=false}}
    {{if $tabCount != 0}}</div>{{/if}}
    <div id='tabcontent{{$tabCount}}'>
  {{/if}}

{{* Print out the table data *}}
{{if $label == 'DEFAULT'}}
  <div id="detailpanel_{{$smarty.foreach.section.iteration}}" >
{{else}}
  <div id="detailpanel_{{$smarty.foreach.section.iteration}}" class="{$def.templateMeta.panelClass|default:'edit view edit508'}">
{{/if}}

{counter name="panelFieldCount" start=0 print=false assign="panelFieldCount"}
{{* Check to see if the panel variable is an array, if not, we'll attempt an include with type param php *}}
{{* See function.sugar_include.php *}}
{{if !is_array($panel)}}
    {sugar_include type='php' file='{{$panel}}'}
{{else}}

{{* Only show header if it is not default or an int value *}}
{{if !empty($label) && !is_int($label) && $label != 'DEFAULT' && $showSectionPanelsTitles && (!isset($tabDefs[$label_upper].newTab) || (isset($tabDefs[$label_upper].newTab) && $tabDefs[$label_upper].newTab == false)) && $view != "QuickCreate"}}
<h4>&nbsp;&nbsp;
  <a href="javascript:void(0)" class="collapseLink" onclick="collapsePanel({{$smarty.foreach.section.iteration}});">
  <img border="0" id="detailpanel_{{$smarty.foreach.section.iteration}}_img_hide" src="{sugar_getimagepath file="basic_search.gif"}"></a>
  <a href="javascript:void(0)" class="expandLink" onclick="expandPanel({{$smarty.foreach.section.iteration}});">
  <img border="0" id="detailpanel_{{$smarty.foreach.section.iteration}}_img_show" src="{sugar_getimagepath file="advanced_search.gif"}"></a>
  {sugar_translate label='{{$label}}' module='{{$module}}'}
  {{if ( isset($tabDefs[$label_upper].panelDefault) && $tabDefs[$label_upper].panelDefault == "collapsed" && isset($tabDefs[$label_upper].newTab) && $tabDefs[$label_upper].newTab == false) }}
    {{assign var='panelState' value=$tabDefs[$label_upper].panelDefault}}
  {{else}}
    {{assign var='panelState' value="expanded"}}
  {{/if}}
  {{if isset($panelState) && $panelState == 'collapsed'}}
    <script>
      document.getElementById('detailpanel_{{$smarty.foreach.section.iteration}}').className += ' collapsed';
    </script>
    {{else}}
    <script>
      document.getElementById('detailpanel_{{$smarty.foreach.section.iteration}}').className += ' expanded';
    </script>
  {{/if}}
</h4>
 {{/if}}
<table width="100%" border="0" cellspacing="1" cellpadding="0" {{if $label == 'DEFAULT'}} id='Default_{$module}_Subpanel' {{else}} id='{{$label}}' {{/if}} class="yui3-skin-sam edit view panelContainer">


{{assign var='rowCount' value=0}}
{{assign var='ACCKEY' value=''}}
{{foreach name=rowIteration from=$panel key=row item=rowData}}
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{capture name="tr" assign="tableRow"}
<tr>

	{{math assign="rowCount" equation="$rowCount + 1"}}
	
	{{assign var='columnsInRow' value=$rowData|@count}}
	{{assign var='columnsUsed' value=0}}

    {{* Loop through each column and display *}}
    {{counter name="colCount" start=0 print=false assign="colCount"}}

	{{foreach name=colIteration from=$rowData key=col item=colData}}

	{{counter name="colCount" print=false}}

	{{if count($rowData) == $colCount}}
		{{assign var="colCount" value=0}}
	{{/if}}

    {{if !empty($colData.field.hideIf)}}
    	{if !({{$colData.field.hideIf}}) }
    {{/if}}

		{{if empty($def.templateMeta.labelsOnTop) && empty($colData.field.hideLabel)}}
		<td valign="top" id='{{$colData.field.name}}_label' width='{{$def.templateMeta.widths[$smarty.foreach.colIteration.index].label}}%' scope="col">
			{{if isset($colData.field.customLabel)}}
			   <label for="{{$fields[$colData.field.name].name}}">{{$colData.field.customLabel}}</label>
			{{elseif isset($colData.field.label)}}
			   {capture name="label" assign="label"}{sugar_translate label='{{$colData.field.label}}' module='{{$module}}'}{/capture}
			   {$label|strip_semicolon}:
			{{elseif isset($fields[$colData.field.name])}}
			   {capture name="label" assign="label"}{sugar_translate label='{{$fields[$colData.field.name].vname}}' module='{{$module}}'}{/capture}
			   {$label|strip_semicolon}:
			{{else}}
			    &nbsp;
			{{/if}}
			{{* Show the required symbol if field is required, but override not set.  Or show if override is set *}}
				{{if ($fields[$colData.field.name].required && (!isset($colData.field.displayParams.required) || $colData.field.displayParams.required)) ||
				     (isset($colData.field.displayParams.required) && $colData.field.displayParams.required)}}
			    <span class="required">{{$APP.LBL_REQUIRED_SYMBOL}}</span>
			{{/if}}
            {{if isset($colData.field.popupHelp) || isset($fields[$colData.field.name]) && isset($fields[$colData.field.name].popupHelp) }}
              {{if isset($colData.field.popupHelp) }}
                {capture name="popupText" assign="popupText"}{sugar_translate label="{{$colData.field.popupHelp}}" module='{{$module}}'}{/capture}
              {{elseif isset($fields[$colData.field.name].popupHelp)}}
                {capture name="popupText" assign="popupText"}{sugar_translate label="{{$fields[$colData.field.name].popupHelp}}" module='{{$module}}'}{/capture}
              {{/if}}
              {sugar_help text=$popupText WIDTH=-1}
            {{/if}}

		</td>
		{{/if}}
		{counter name="fieldsUsed"}
		{{math assign="tabIndexVal" equation="$tabIndexVal + 1"}}
		{{if $tabIndexVal==1}} {{assign var='ACCKEY' value=$APP.LBL_FIRST_INPUT_EDIT_VIEW_KEY}}{{else}}{{assign var='ACCKEY' value=''}}{{/if}}
		{{if !empty($colData.field.tabindex)  && $colData.field.tabindex !=0}}
		    {{assign var='tabindex' value=$colData.field.tabindex}}
            {{** instead of tracking tabindex values for all fields, just track for email as email does not get created directly from
                a tpl that has access to smarty values.  Email gets created through addEmailAddress() function in SugarEmailAddress.js
                which will use the value in tabFields array
             **}}
            {{if $colData.field.name == 'email1'}}<script>SUGAR.TabFields['{{$colData.field.name}}'] = '{{$tabindex}}';</script>{{/if}}
		{{else}}
		    {** if not explicitly assigned, we will default to 0 for 508 compliance reasons, instead of the calculated tabIndexVal value **}
		    {{assign var='tabindex' value=0}}
		{{/if}}
		<td valign="top" width='{{$def.templateMeta.widths[$smarty.foreach.colIteration.index].field}}%' {{if $colData.colspan}}colspan='{{$colData.colspan}}'{{/if}}>
			{{if !empty($def.templateMeta.labelsOnTop)}}
				{{if isset($colData.field.label)}}
				    {{if !empty($colData.field.label)}}
			   		    <label for="{{$fields[$colData.field.name].name}}">{sugar_translate label='{{$colData.field.label}}' module='{{$module}}'}:</label>
				    {{/if}}
				{{elseif isset($fields[$colData.field.name])}}
			  		<label for="{{$fields[$colData.field.name].name}}">{sugar_translate label='{{$fields[$colData.field.name].vname}}' module='{{$module}}'}:</label>
				{{/if}}

				{{* Show the required symbol if field is required, but override not set.  Or show if override is set *}}
				{{if ($fields[$colData.field.name].required && (!isset($colData.field.displayParams.required) || $colData.field.displayParams.required)) ||
				     (isset($colData.field.displayParams.required) && $colData.field.displayParams.required)}}
				    <span class="required" title="{{$APP.LBL_REQUIRED_TITLE}}">{{$APP.LBL_REQUIRED_SYMBOL}}</span>
				{{/if}}
				{{if !isset($colData.field.label) || !empty($colData.field.label)}}
				<br>
				{{/if}}
			{{/if}}

		{{$colData.field.prefix}}


			{{if $fields[$colData.field.name] && !empty($colData.field.fields) }}
			    {{foreach from=$colData.field.fields item=subField}}
			        {{if $fields[$subField.name]}}
			        	{counter name="panelFieldCount"}
			            {{sugar_field parentFieldArray='fields'  accesskey=$ACCKEY tabindex=$tabindex vardef=$fields[$subField.name] displayType='EditView' displayParams=$subField.displayParams formName=$form_name module=$module}}&nbsp;
			        {{/if}}
			    {{/foreach}}
			{{elseif !empty($colData.field.customCode) && empty($colData.field.customCodeRenderField)}}
				{counter name="panelFieldCount"}
				{{sugar_evalcolumn var=$colData.field.customCode colData=$colData  accesskey=$ACCKEY tabindex=$tabindex}}
			{{elseif $fields[$colData.field.name]}}
				{counter name="panelFieldCount"}
			    {{$colData.displayParams}}
				{{sugar_field parentFieldArray='fields'  accesskey=$ACCKEY tabindex=$tabindex vardef=$fields[$colData.field.name] displayType='EditView' displayParams=$colData.field.displayParams typeOverride=$colData.field.type formName=$form_name module=$module}}
			{{/if}}
	{{if !empty($colData.field.customCode) && !empty($colData.field.customCodeRenderField)}}
	    {counter name="panelFieldCount"}
	    {{sugar_evalcolumn var=$colData.field.customCode colData=$colData tabindex=$tabindex}}
    {{/if}}
    {{if !empty($colData.field.hideIf)}}
		{else}
		<td></td><td></td>
		{/if}
    {{/if}}

	{{/foreach}}
</tr>
{/capture}
{if $fieldsUsed > 0 }
{$tableRow}
{/if}
{{/foreach}}
</table>
<hr>
<input type="hidden" value="{$prtype}" name="type" id="type" />
<h2>Expense Details</h2>
<div class="clear"></div>
<div class="row" class="maincontroe">
				
				<div class="maincontainer col-sm-9">
					<div class="row items">
						
							<div class="col-sm-2">
								Product Detail
							</div>
                                            
                                            
							<div class="col-sm-2">
								Expense Detail
							</div>
							<div class="col-sm-2">
								Unit
							</div>
							<div class="col-sm-2">
								Rate
							</div>
							<div class="col-sm-2">
								Amount in <i class="fa fa-inr" aria-hidden="true"></i>
							</div>
							
						{if count($items) > 0}	
							{foreach   from=$items key=id item=rowDatas}
							
								<div class="dompar">	
								<div class="col-sm-2">
									<input type="hidden" value="{$rowDatas.id}" name="savedid[]" >
									<input type="text" value="{$rowDatas.name}" class="itemtxt" name="items[]" >
									<div class="errdiv itemtxterr ">Please enter Item name</div>
								</div>
                                                                <div class="col-sm-2">
								 
                                                                      <input type="text" class="itemtxtd" value="{$rowDatas.description}"  name="itemsd[]" >     
                                                            
                                                                </div>        
								<div class="col-sm-2">
									 <input type="text" value="{$rowDatas.unit|string_format:"%.2f"}"  class="amtu" name="unit[]" >
									 <div class="errdiv amtuerr ">Please enter valid unit</div>
								</div>
								<div class="col-sm-2">
									 <input type="text" value="{$rowDatas.rate|string_format:"%.2f"}"  class="amtr" name="rate[]" >
									 <div class="errdiv amtrerr ">Please enter valid rate</div>
								</div>
								<div class="col-sm-2">
									 <input style=" background-color: #f1f1f1!important;" disabled type="text" value="{$rowDatas.amt|string_format:"%.2f"}"  class="amtvald" name="amounts[]" >
									 <div class="errdiv amtvalderr ">Please enter valid amount</div>
								</div>
								
								<div class="col-sm-2">
									<i style="font-size: 30px;display:none" class="fa fa-plus-circle addbtn" aria-hidden="true"></i>
									<i style="font-size: 30px;display:block" class="fa fa-minus-circle minbtn" aria-hidden="true"></i>
								</div>
							 </div>
							
							{/foreach}
						
						{/if}
							
						 <div class="dompar">	
							<div class="col-sm-2">
								<input type="hidden"  name="savedid[]" >
								<!--<input type="text" class="itemtxt" name="items[]" >-->
                                                                <select  class="itemtxt" name="items[]">{$expProDrop}</select>
								<div class="errdiv itemtxterr ">Please enter Item name</div>
							</div>
                                                        <div class="col-sm-2">
								 
                                                            <input type="text" class="itemtxtd" name="itemsd[]" >     
                                                            
							</div>        
							<div class="col-sm-2">
								 <input type="text" class="amtu" name="unit[]" >
								 <div class="errdiv amtuerr ">Please enter valid unit</div>
							</div>
							<div class="col-sm-2">
								 <input type="text" class="amtr" name="rate[]" >
								 <div class="errdiv amtrerr ">Please enter valid rate</div>
							</div>
							<div class="col-sm-2">
								 <input  style=" background-color: #f1f1f1!important;" disabled type="text" class="amtvald" name="amounts[]" >
								 <div class="errdiv amtvalderr ">Please enter valid amount</div>
							</div>
							
							<div class="col-sm-2">
								<i style="font-size: 30px;" class="fa fa-plus-circle addbtn" aria-hidden="true"></i>
								<i style="font-size: 30px;" class="fa fa-minus-circle minbtn" aria-hidden="true"></i>
							</div>
						</div>	
					</div>
				</div>
							
				<div class="maincontainer col-sm-3">
				
					<div class=" itemstx">
							<div class="col-sm-5">
								Tax Detail
							</div>
							<div class="col-sm-5">
								Amount in <i class="fa fa-inr" aria-hidden="true"></i>
							</div>
						 
						{if count($taxesarr) > 0}	
							{foreach   from=$taxesarr key=id item=rowDatas}
							
								<div class="dompar">	
								<div class="col-sm-5">
									<input type="hidden" value="{$rowDatas.id}" name="savedtaxid[]" >
									<select class="itemtxttx" name="taxesp[]">
										{foreach  from=$taxes key=keys item=val}
											<option {if $rowDatas.name==$keys } selected  {/if}value="{$keys}">{$val}</option>	 
										{/foreach}
									</select>
									<div class="errdiv itemtxterrtx ">Please select Tax</div>
								</div>
								<div class="col-sm-5">
									 <input type="text" value="{$rowDatas.amt|string_format:"%.2f"}"  class="amtvaldtx" name="tax[]" >
									 <div class="errdiv amtvalderrtx ">Please enter valid amount</div>
								</div>
								
								<div class="col-sm-2">
									<i style="font-size: 30px;display:none" class="fa fa-plus-circle addbtntx" aria-hidden="true"></i>
									<i style="font-size: 30px;display:block" class="fa fa-minus-circle minbtntx" aria-hidden="true"></i>
								</div>
							 </div>
							
							{/foreach}
						
						{/if}	
							
						<div class="dompar">		
							<div class="col-sm-5">
							<input type="hidden"  name="savedtaxid[]" >
								<select class="itemtxttx" name="taxesp[]">
									{foreach  from=$taxes key=keys item=val}
										<option value="{$keys}">{$val}</option>	 
									{/foreach}
								</select>	
								<div class="errdiv itemtxterrtx ">Please select Tax</div>					 
								
							</div>
							<div class="col-sm-5">
								 <input type="text" class="amtvaldtx" name="tax[]" >
								 <div class="errdiv amtvalderrtx ">Please enter valid amount</div>
							</div>
							<div class="col-sm-2">
								<i style="font-size: 30px;" class="fa fa-plus-circle addbtntx" aria-hidden="true"></i>
								<i style="font-size: 30px;" class="fa fa-minus-circle minbtntx" aria-hidden="true"></i>
							</div>
					  </div>
					</div>
				</div>
				
			</div>
			
<hr>
<h2> Documents</h2>		
<div style="clear:both"></div>	
{if count($docuarray)>0}	
	<div style="clear:both" class="apendnewdocs col-xs-4">

	{foreach from=$docuarray key=id item=val}
	  <div class="uploadedimg">
	  <div class="col-sm-2"> <i data-id="{$id}" style="font-size: 15px;display:inline" class="fa fa-minus-circle deldocs" aria-hidden="true"></i> </div>
	  <div class="col-sm-10"><a tarhet="new" href="index.php?module=te_ExpensePO&action=download&id={$id}&records={$beanid}&type=attch"> <img src="custom/themes/SuiteR/css/uploader/not_available-generic.png" style="width:25px;height:25px"> {$val->nameOrg} </a></div>
	  </div>
	{/foreach}

	</div>	
{/if}	

<div id="fine-uploader-gallery"></div>
 
{{if !empty($label) && !is_int($label) && $label != 'DEFAULT' && $showSectionPanelsTitles && (!isset($tabDefs[$label_upper].newTab) || (isset($tabDefs[$label_upper].newTab) && $tabDefs[$label_upper].newTab == false)) && $view != "QuickCreate"}}
<script type="text/javascript">SUGAR.util.doWhen("typeof initPanel == 'function'", function() {ldelim} initPanel({{$smarty.foreach.section.iteration}}, '{{$panelState}}'); {rdelim}); </script>
{{/if}}

{{/if}}

</div>
{if $panelFieldCount == 0}

<script>document.getElementById("{{$label}}").style.display='none';</script>
{/if}
{{/foreach}}
</div></div>



<script language="javascript">
    var _form_id = '{$form_id}';
    {literal}
    SUGAR.util.doWhen(function(){
        _form_id = (_form_id == '') ? 'EditView' : _form_id;
        return document.getElementById(_form_id) != null;
    }, SUGAR.themes.actionMenu);
    {/literal}
</script>
{assign var='place' value="_FOOTER"} <!-- to be used for id for buttons with custom code in def files-->
{{if empty($form.button_location) || $form.button_location == 'bottom'}}
<div class="buttons">
{{if !empty($form) && !empty($form.buttons)}}
   {{foreach from=$form.buttons key=val item=button}}
      {{sugar_button module="$module" id="$button" form_id="$form_id" view="$view" appendTo="footer_buttons" location="FOOTER"}}
   {{/foreach}}
{{else}}


<input title="Save" accesskey="a" class="button primary save_btn"   type="submit" name="button" value="Save" id="SAVE_FOOTER">


{{sugar_button module="$module" id="CANCEL" view="$view" form_id="$form_id" location="FOOTER" appendTo="footer_buttons"}}
{{/if}}
{{if empty($form.hideAudit) || !$form.hideAudit}}
{{sugar_button module="$module" id="Audit" view="$view" form_id="$form_id" appendTo="footer_buttons"}}
{{/if}}
{{sugar_action_menu buttons=$footer_buttons class="fancymenu" flat=true}}
</div>
{{/if}}
</form>
{{if $externalJSFile}}
{sugar_include include=$externalJSFile}
{{/if}}

{$set_focus_block}

{{if isset($scriptBlocks)}}
<!-- Begin Meta-Data Javascript -->
{{$scriptBlocks}}
<!-- End Meta-Data Javascript -->
{{/if}}
<script>SUGAR.util.doWhen("document.getElementById('EditView') != null",
        function(){ldelim}SUGAR.util.buildAccessKeyLabels();{rdelim});
</script>




 


{{if $useTabs}}
{sugar_getscript file="cache/include/javascript/sugar_grp_yui_widgets.js"}
<script type="text/javascript">
var {{$form_name}}_tabs = new YAHOO.widget.TabView("{{$form_name}}_tabs");
{{$form_name}}_tabs.selectTab(0);
</script>
{{/if}}
<script type="text/javascript">
YAHOO.util.Event.onContentReady("{{$form_name}}",
    function () {ldelim} initEditView(document.forms.{{$form_name}}) {rdelim});
//window.setTimeout(, 100);
{{if $module == "Users"}}
window.onbeforeunload = function () {ldelim} return disableOnUnloadEditView(); {rdelim};
{{else}}
window.onbeforeunload = function () {ldelim} return onUnloadEditView(); {rdelim};
{{/if}}
// bug 55468 -- IE is too aggressive with onUnload event
if ($.browser.msie) {ldelim}
$(document).ready(function() {ldelim}
    $(".collapseLink,.expandLink").click(function (e) {ldelim} e.preventDefault(); {rdelim});
  {rdelim});
{rdelim}
</script>
{literal}
<script>
{{if !$beanid}}

		$.post( "index.php?module=te_ExpensePO&action=genrateRefID&to_pdf=1", { })
		  .done(function( dataobj ) {
			 $("#refrenceid").val(dataobj);
		 });

{{/if}}

function calculateRow(unit,rate,amtvald){
	var amount=parseFloat($.trim(unit)) * parseFloat($.trim(rate));
	if(isNaN(amount)) amount=0;
	amtvald.val(amount.toFixed(2));
	calculate();
}
function calculate(){


	 var amount=0;
		
	 $( ".amtvald" ).each(function() {
				if($.trim($(this).val())!=''){				
					var regex  = /(?=.)^\$?(([1-9][0-9]{0,2}(,[0-9]{3})*)|[0-9]+)?(\.[0-9]{1,2})?$/;
					if(regex.test($.trim($(this).val()))){
						amount +=parseFloat($.trim($(this).val()));
					}
					
				}
		});
		
		$( ".amtvaldtx" ).each(function() {
				if($.trim($(this).val())!=''){				
					var regex  = /(?=.)^\$?(([1-9][0-9]{0,2}(,[0-9]{3})*)|[0-9]+)?(\.[0-9]{1,2})?$/;
					if(regex.test($.trim($(this).val()))){
						amount +=parseFloat($.trim($(this).val()));
					}
					
				}
		});
		
		$('#amount').val(amount.toFixed(2));


}

var objImg={{ $document|html_entity_decode}};
var restrictedUploader = new qq.FineUploader({
            element: document.getElementById("fine-uploader-gallery"),
            template: 'qq-template-gallery',           
            request: {
                 endpoint: 'index.php?module=te_ExpensePO&action=uploads&to_pdf=1',                 
            },
            thumbnails: {
                placeholders: {
                    waitingPath: 'custom/themes/SuiteR/css/uploader/waiting-generic.png',
                    notAvailablePath: 'custom/themes/SuiteR/css/uploader/not_available-generic.png'
                }
            },           
            validation: {                
                itemLimit: 10,
                sizeLimit: 1024*1024*20 // 50 kB = 50 * 1024 bytes
            },
            callbacks: {
				onComplete: function(id, fileName, responseJSON) {
					 
					if(objImg.length==0){
						 objImg[0]={name :responseJSON.filename, nameOrg:responseJSON.orgfilename};						 
					}else{
						objImg[objImg.length]={name :responseJSON.filename, nameOrg:responseJSON.orgfilename};						 
					}
					
					$('#documents').html(JSON.stringify(objImg));
					
				}	
			}	
        });


$('body').on('click','.minbtn',function(){
	
    if($('.itemtxt').length==1){
		$('.items').append('<div class="dompar">' + $(this).parent().parent().html() + '</div>');
    }
	$(this).parent().parent().remove();
	calculate();
	
});


$('body').on('click','.addbtn',function(){
	$('.errdiv').hide();
	 
	if($.trim($(this).parent().parent().find('.itemtxt').val())==''){
		 
		$(this).parent().parent().find('.itemtxterr').show();
		
	}
	if($.trim($(this).parent().parent().find('.amtu').val())==''){
		$(this).parent().parent().find('.amtuerr').show();
		return false;
	}
	if($.trim($(this).parent().parent().find('.amtr').val())==''){
		$(this).parent().parent().find('.amtrerr').show();
		return false;
	}
	if($.trim($(this).parent().parent().find('.amtvald').val())==''){
		$(this).parent().parent().find('.amtvalderr').show();
		return false;
	}

	var regex  = /(?=.)^\$?(([1-9][0-9]{0,2}(,[0-9]{3})*)|[0-9]+)?(\.[0-9]{1,2})?$/;
	if(!regex.test($.trim($(this).parent().parent().find('.amtu').val()))){
		$(this).parent().parent().find('.amtuerr').show();
		return false;
	}
	if(!regex.test($.trim($(this).parent().parent().find('.amtr').val()))){
		$(this).parent().parent().find('.amtrerr').show();
		return false;
	}
	calculateRow($.trim($(this).parent().parent().find('.amtu').val()),$.trim($(this).parent().parent().find('.amtr').val()),$(this).parent().parent().find('.amtvald'));

	$('.items').append('<div class="dompar">' + $(this).parent().parent().html() + '</div>');
	
	$(this).next().show();
	$(this).hide();

})
$('body').on('click','.deldocs',function(){
		var id=$(this).attr('data-id');
		 
		delete objImg[id];
		$(this).parent().parent().remove();
		$('#documents').html(JSON.stringify(objImg));
		 

})
$('body').on('click','.minbtntx',function(){
	
    if($('.itemtxttx').length==1){
		$('.itemstx').append('<div class="dompar">' + $(this).parent().parent().html() + '</div>');
    }
	$(this).parent().parent().remove();
	calculate();
});

$('body').on('click','.addbtntx',function(){
	$('.errdiv').hide();
	if($.trim($(this).parent().parent().find('.itemtxttx').val())==''){
		 
		$(this).parent().parent().find('.itemtxterrtx').show();
		
	}
	if($.trim($(this).parent().parent().find('.amtvaldtx').val())==''){
		$(this).parent().parent().find('.amtvalderrtx').show();
		return false;
	}

	var regex  = /(?=.)^\$?(([1-9][0-9]{0,2}(,[0-9]{3})*)|[0-9]+)?(\.[0-9]{1,2})?$/;
	if(!regex.test($.trim($(this).parent().parent().find('.amtvaldtx').val()))){
		$(this).parent().parent().find('.amtvalderrtx').show();
		return false;
	}

	$('.itemstx').append('<div class="dompar">' + $(this).parent().parent().html() + '</div>');
	
	$(this).next().show();
	$(this).hide();

})

$('.amtvald,.amtvaldtx,.amtu,.amtr').bind('copy paste cut',function(e) {
	e. preventDefault(); //disable cut,copy,paste.
 
});

$('body').on('keyup','.amtvald,.amtvaldtx',function(e) {
     calculate();
});

$('body').on('keyup','.amtu',function(e) {
    $('.errdiv').hide();
	var regex  = /(?=.)^\$?(([1-9][0-9]{0,2}(,[0-9]{3})*)|[0-9]+)?(\.[0-9]{1,2})?$/;
	if(!regex.test($.trim($(this).val()))){
		$(this).parent().parent().find('.amtuerr').show(); return false;
	}
    if($.trim($(this).val())!='' && $.trim($(this).parent().parent().find('.amtr').val())!=''){
		calculateRow($.trim($(this).val()),$.trim($(this).parent().parent().find('.amtr').val()),$(this).parent().parent().find('.amtvald'));
     
     }
});

$('body').on('keyup','.amtr',function(e) {
    $('.errdiv').hide();
	var regex  = /(?=.)^\$?(([1-9][0-9]{0,2}(,[0-9]{3})*)|[0-9]+)?(\.[0-9]{1,2})?$/;
	if(!regex.test($.trim($(this).val()))){
		$(this).parent().parent().find('.amtrerr').show(); return false;
	}
    if($.trim($(this).val())!='' && $.trim($(this).parent().parent().find('.amtu').val())!=''){
		calculateRow($.trim($(this).parent().parent().find('.amtu').val()),$.trim($(this).val()),$(this).parent().parent().find('.amtvald'));
     
     }
});

$('.save_btn').on('click',function(){
		$('.errdiv').hide();
		var iserr=0;
		var amount=0;
		var item=0;
		
		if($('#type').val()=='PR' && $.trim($('#inv_num').val())==''){
		  alert('Please enter invoice number');
		  return false;
		}
		
		$( ".itemtxt" ).each(function() {
				if($.trim($(this).val())!=''){				
					
					item++;
				}
		});
		$( ".amtu" ).each(function() {
				if($.trim($(this).val())!=''){				
					var regex  = /(?=.)^\$?(([1-9][0-9]{0,2}(,[0-9]{3})*)|[0-9]+)?(\.[0-9]{1,2})?$/;
					if(!regex.test($.trim($(this).val()))){
						$(this).next().show();
						iserr=1;
					}
					if($.trim($(this).parent().prev().find('.itemtxt').val())==''){
						$(this).parent().prev().find('.itemtxt').next().show();
						iserr=1;
					}
					if($.trim($(this).parent().parent().find('.amtr').val())==''){
						$(this).parent().parent().find('.amtr').next().show();
						iserr=1;
					}
					
					if(!regex.test($.trim($(this).parent().parent().find('.amtr').val()))){
						$(this).parent().parent().find('.amtr').next().show();
						iserr=1;
					}
					calculateRow($.trim($(this).val()),$.trim($(this).parent().parent().find('.amtr').val()),$(this).parent().parent().find('.amtvald'))	;				
					 
				}
		});
		if(iserr==1) return false;
		$( ".amtvald" ).each(function() {
				if($.trim($(this).val())!=''){				
					var regex  = /(?=.)^\$?(([1-9][0-9]{0,2}(,[0-9]{3})*)|[0-9]+)?(\.[0-9]{1,2})?$/;
					if(!regex.test($.trim($(this).val()))){
						$(this).next().show();
						iserr=1;
					}					
					amount +=parseFloat($.trim($(this).val()));
				}
		});
		if(iserr==1) return false;
			
		
		if(amount==0 || item==0){
			alert('Please enter item detail');
			return false;
		}
		
		$( ".amtvaldtx" ).each(function() {
				if($.trim($(this).val())!=''){				
					var regex  = /(?=.)^\$?(([1-9][0-9]{0,2}(,[0-9]{3})*)|[0-9]+)?(\.[0-9]{1,2})?$/;
					if(!regex.test($.trim($(this).val()))){
						$(this).next().show();
						iserr=1;
					}
					amount +=parseFloat($.trim($(this).val()));
					
				}
		});
		if(iserr==1) return false;
		$('#amount').val(amount.toFixed(2));
		
		var _form = document.getElementById('EditView'); _form.action.value='Save'; if(check_form('EditView'))SUGAR.ajaxUI.submitForm(_form);return false;
})

</script>
{/literal}




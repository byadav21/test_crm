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

<script>
{literal}
    function showPredictive(){
		toastr.options = {
			  "closeButton": true,
			  "positionClass": "toast-top-center",
			}        
        toastr.clear();
		var notify = toastr.info("You are in Predictive Mode!");
    }
     
    
	$(document).ready(function(){
	    $("ul.clickMenu").each(function(index, node){
	  		$(node).sugarActionMenu();
	  	});
	  	$('.prevdel').prev().hide();
	  	//$('.prevdel').prev().remove();

        $('.selectActionsDisabled').children().each(function(index) {
            $(this).attr('onclick','').unbind('click');
        });

        var selectedTopValue = $("#selectCountTop").attr("value");
        if(typeof(selectedTopValue) != "undefined" && selectedTopValue != "0"){
        	sugarListView.prototype.toggleSelected();
        }
       });
       function resumeTheNeoxCall(){
		if(confirm('Are you sure to resume the call')){
			SUGAR.ajaxUI.showLoadingPanel();
			var callback = {
				success:function(b){
					SUGAR.ajaxUI.hideLoadingPanel();
					//var parsedJSON = JSON.parse(b.responseText);
					//~ alert(parsedJSON[0]);
					//~ alert(parsedJSON[1]);
					
					if(b.responseText=="200"){	
						//alert(b.responseText)
							document.getElementById('show_pause').innerHTML='';
							document.getElementById('show_pause').innerHTML='<button type="button" onclick="pauseTheNeoxCall()">Pause</button>';
					}
					else{
							SUGAR.ajaxUI.hideLoadingPanel();
							alert('Error!!')
					}
				}
			}
			var connectionObject = YAHOO.util.Connect.asyncRequest('GET', 'index.php?entryPoint=resumeTheNeoxCall', callback);
		 }
		}
       
       function pauseTheNeoxCall(){
		if(confirm('Are you sure to pause the Call Process')){
			SUGAR.ajaxUI.showLoadingPanel();
			var callback = {
				success:function(b){
					SUGAR.ajaxUI.hideLoadingPanel();
					//var parsedJSON = JSON.parse(b.responseText);
					//~ alert(parsedJSON[0]);
					//~ alert(parsedJSON[1]);
					if(b.responseText=="200"){	
						//alert(b.responseText)
							document.getElementById('show_pause').innerHTML='';
							document.getElementById('show_pause').innerHTML='<button type="button" onclick="resumeTheNeoxCall()">Resume</button>';
			}
					else{
							SUGAR.ajaxUI.hideLoadingPanel();
						alert('Error!!')
					}
				}
			}
			var connectionObject = YAHOO.util.Connect.asyncRequest('GET', 'index.php?entryPoint=pauseTheNeoxCall', callback);
		 }
       }
       
       function manualDialing(){
		if(confirm('Are you sure to shift on Manual dialing')){
			SUGAR.ajaxUI.showLoadingPanel();
			var callback = {
				success:function(b){
					SUGAR.ajaxUI.hideLoadingPanel();
					//var parsedJSON = JSON.parse(b.responseText);
					//~ alert(parsedJSON[0]);
					//~ alert(parsedJSON[1]);
					if(b.responseText=="200"){	
						//alert(b.responseText)
							document.getElementById('shift_call').innerHTML='';
							document.getElementById('shift_call').innerHTML='<button type="button" onclick="predictiveDialing()">Predictive Dialing</button>';
							window.location.href='index.php?module=Leads&action=index';
					}
					else{
							SUGAR.ajaxUI.hideLoadingPanel();
						alert('Error!!')
					}
				}
			}
			var connectionObject = YAHOO.util.Connect.asyncRequest('GET', 'index.php?entryPoint=manualDialing', callback);
		 }
       }
       
       
       function predictiveDialing(){
		if(confirm('Are you sure to shift on Predictive dialing')){
			SUGAR.ajaxUI.showLoadingPanel();
			var callback = {
				success:function(b){
					SUGAR.ajaxUI.hideLoadingPanel();
					//var parsedJSON = JSON.parse(b.responseText);
					//~ alert(parsedJSON[0]);
					//~ alert(parsedJSON[1]);
					if(b.responseText=="200"){	
						//alert(b.responseText)
							document.getElementById('shift_call').innerHTML='';
							document.getElementById('shift_call').innerHTML='<button type="button" onclick="manualDialing()">Manual Dialing</button>';
							window.location.href='index.php?module=Leads&action=index';
					}
					else{
							SUGAR.ajaxUI.hideLoadingPanel();
						alert('Error!!')
					}
				}
			}
			var connectionObject = YAHOO.util.Connect.asyncRequest('GET', 'index.php?entryPoint=predictiveDialing', callback);
		 }
       }
     
       
{/literal}
</script>
{literal}

  <style>
    .maintbl {margin: 0px;
    border: 1px solid #f1f1f1;
    overflow: hidden;
    display: block;}
    #pagination{margin:40px 0}
    .mainrow{
    
        margin: 30px 12px;
		border-bottom: 1px dotted silver;
		padding-bottom: 28px;
    }
    .mainrow p{margin: 9px 0;}
    .mainrow .name{    font-size: 15px;}
    
    .toast-top-center{top:50%!important}
    #pagination .sugar_action_button input{display:inline}
    #pagination #selectedRecordsTop input{border:0!important; box-shadow: 0 0 0 0!important;}
    .pageheadr{    overflow: visible;
    display: block;
    margin-top: 0px;
    border: 1px solid #f1f1f1;
    border-bottom: 0px;
    padding: 3px 0;
    height: 37px;
    background: #EEEEEE !important;
    }
    
    .paginationActionButtons .show{display:inline-block!important}
	#selectedRecordsTop{display:none!important}
  </style>
{/literal}
{assign var="currentModule" value = $pageData.bean.moduleDir}
{assign var="singularModule" value = $moduleListSingular.$currentModule}
{assign var="moduleName" value = $moduleList.$currentModule}
{assign var="hideTable" value=false}

{if count($data) == 0}
	
			{if $LOGGED_IN =='Success'}
			
			{if $LOGGED_IN_RESUME=='Resume'}
				<span id='show_pause'><button type="button" onclick="pauseTheNeoxCall()">Pause</button></span><span>&nbsp;&nbsp;</span>
			{/if}
			{if $LOGGED_IN_PAUSE=='Pause'}
				<span id='show_pause'><button type="button" onclick="resumeTheNeoxCall()">Resume</button></span><span>&nbsp;&nbsp;</span>
			{/if}
			
			
			{if $LOGGED_IN_MANUAL=='Manual'}
				<span id='shift_call'><button type="button" onclick="predictiveDialing()">Predictive Dialing</button></span>
			{/if}
			{if $LOGGED_IN_PREDICTIVE=='Predictive'}
				<span id='shift_call'><button type="button" onclick="manualDialing()">Manual Dialing</button></span>
			{/if}
			
		{/if}	
	{assign var="hideTable" value=true}
	<div class="list view listViewEmpty">
		{if $displayEmptyDataMesssages}
        {if strlen($query) == 0}
                {capture assign="createLink"}<a href="?module={$pageData.bean.moduleDir}&action=EditView&return_module={$pageData.bean.moduleDir}&return_action=DetailView">{$APP.LBL_CREATE_BUTTON_LABEL}</a>{/capture}
                {capture assign="importLink"}<a href="?module=Import&action=Step1&import_module={$pageData.bean.moduleDir}&return_module={$pageData.bean.moduleDir}&return_action=index">{$APP.LBL_IMPORT}</a>{/capture}
                {capture assign="helpLink"}<a target="_blank" href='?module=Administration&action=SupportPortal&view=documentation&version={$sugar_info.sugar_version}&edition={$sugar_info.sugar_flavor}&lang=&help_module={$currentModule}&help_action=&key='>{$APP.LBL_CLICK_HERE}</a>{/capture}
                <p class="msg">
                    {$APP.MSG_EMPTY_LIST_VIEW_NO_RESULTS|replace:"<item2>":$createLink|replace:"<item3>":$importLink}
                </p>
        {elseif $query == "-advanced_search"}
            <p class="msg">
                {$APP.MSG_LIST_VIEW_NO_RESULTS_BASIC}
            </p>
        {else}
            <p class="msg">
                {capture assign="quotedQuery"}"{$query}"{/capture}
                {$APP.MSG_LIST_VIEW_NO_RESULTS|replace:"<item1>":$quotedQuery}
            </p>
            <p class = "submsg">
                <a href="?module={$pageData.bean.moduleDir}&action=EditView&return_module={$pageData.bean.moduleDir}&return_action=DetailView">
                    {$APP.MSG_LIST_VIEW_NO_RESULTS_SUBMSG|replace:"<item1>":$quotedQuery|replace:"<item2>":$singularModule}
                </a>

            </p>
        {/if}
    {else}
        <p class="msg">
            {$APP.LBL_NO_DATA}
        </p>
	{/if}
	</div>
{/if}
{$multiSelectData}
{if $hideTable == false}


	{assign var="link_select_id" value="selectLinkTop"}
	{assign var="link_action_id" value="actionLinkTop"}
	{assign var="actionsLink" value=$actionsLinkTop}
	{assign var="selectLink" value=$selectLinkTop}
	{assign var="action_menu_location" value="top"}
	{assign var="alt_start" value=$navStrings.start}
	{assign var="alt_next" value=$navStrings.next}
	{assign var="alt_prev" value=$navStrings.previous}
	{assign var="alt_end" value=$navStrings.end}
	<div  id='pagination'  role='presentation'">
		{include file='custom/modules/Leads/tpls/ListViewPagination.tpl'}
		<div class="col-sm-12 maintbl" style="margin-top:0px">
	 
		  {foreach name=rowIteration from=$data key=id item=rowData}
			<div class="row mainrow">
				  <div class="row col-sm-1" style="margin-top: 50px;">
					 {if !$is_admin && is_admin_for_user && $rowData.IS_ADMIN==1}
							<!--<input type='checkbox' disabled="disabled" class='checkbox' value='{$rowData.ID}'>-->
					 {else}
							<input title="{sugar_translate label='LBL_SELECT_THIS_ROW_TITLE'}" onclick='sListView.check_item(this, document.MassUpdate)' type='checkbox' class='checkbox' name='mass[]' value='{$rowData.ID}'>
					 {/if}
				  </div>
				  <div class="row col-sm-4">

						<b class="name"><a title='{$editLinkString}' id="view-{$rowData.ID}"
							   href="index.php?module=Leads&offset={$offset}&stamp={$pageData.stamp}&return_module={$linkModule}&action=DetailView&record={$rowData.ID}"
									>{$rowData.NAME}</a></b>
					
						
							{if !empty($rowData.PHONE_MOBILE)} 
								<p> <i class="fa fa-phone" aria-hidden="true"></i>  {$rowData.PHONE_MOBILE}  
								 
							{/if}
						<p>Counsellor : {$rowData.ASSIGNED_USER_NAME}</p>
				  </div>
				  <div class="col-sm-4">
				  
							 <p>{$rowData.PROGRAM} - {$rowData.INSTITUTE}</p>
							 <P><label>BATCH</label> : 
							 {if !empty($rowData.BATCH)} 
								{$rowData.BATCH}
							 {else}
								 <span style="color:red"> -NA- <span>
							 {/if}
							 </P>
				  
				  </div>
				  <div class="col-sm-3 text-right">
				  
				  {if !empty($quickViewLinks)}
					{capture assign=linkModule}{if $params.dynamic_module}{$rowData[$params.dynamic_module]}{else}{$pageData.bean.moduleDir}{/if}{/capture}
					{capture assign=action}{if $act}{$act}{else}EditView{/if}{/capture}
					<p>
						{if $pageData.rowAccess[$id].edit}
							<a title='{$editLinkString}' id="edit-{$rowData.ID}"
							   href="index.php?module={$linkModule}&offset={$offset}&stamp={$pageData.stamp}&return_module={$linkModule}&action={$action}&record={$rowData.ID}"
									>
								Edit <i class="fa fa-pencil-square" aria-hidden="true"></i></a>
						{/if}
						&nbsp;&nbsp;&nbsp;
						<a title='{$editLinkString}' id="view-{$rowData.ID}"
							   href="index.php?module={$linkModule}&offset={$offset}&stamp={$pageData.stamp}&return_module={$linkModule}&action=DetailView&record={$rowData.ID}"
									>
								View <i class="fa fa-plus-square-o" aria-hidden="true"></i></a>
						
					</p>

				 {/if}
				  
			
					<p><i class="fa fa-calendar" aria-hidden="true"></i> {$rowData.DATE_MODIFIED}</p>
						<label>Status</label>: 
						{if $rowData.STATUS eq 'Dead' or $rowData.STATUS eq 'Duplicate' }
								<p style="color:red;font-weight:bold;display:inline"><i class="fa fa-times" aria-hidden="true"></i> {$rowData.STATUS_DESCRIPTION}</p> 
						 {elseif $rowData.STATUS eq 'Warm'}
								<p style="color:orange;font-weight:bold;display:inline"><i class="fa fa-certificate" aria-hidden="true"></i> {$rowData.STATUS_DESCRIPTION}</p> 
						  {elseif $rowData.STATUS eq 'Converted'}
								<p style="color:limegreen;font-weight:bold;display:inline"><i class="fa fa-check-square-o" aria-hidden="true"></i> {$rowData.STATUS_DESCRIPTION}</p>
						  {elseif $rowData.STATUS eq 'Alive'}
								<p style="color:#187816;font-weight:bold;display:inline"><i class="fa fa-bookmark" aria-hidden="true"></i> {$rowData.STATUS_DESCRIPTION}</p>
						   {/if}
					<p>
                                             {if $rowData.STATUS_DESCRIPTION=='Call Back'}
                                                 Dated : {$rowData.DATE_OF_CALLBACK}

                                             {elseif $rowData.STATUS_DESCRIPTION=='Follow Up' }  
                                                 Dated : {$rowData.DATE_OF_FOLLOWUP}
                                             {elseif $rowData.STATUS_DESCRIPTION=='Prospect'}
                                                Dated : {$rowData.DATE_OF_PROSPECT}
                                              {/if} 

                                         </p>	
						
						 
				  </div>
			</div>
		   {/foreach} 
		
		 
		 
		</div>
		
		{assign var="link_select_id" value="selectLinkBottom"}
		{assign var="link_action_id" value="actionLinkBottom"}
		{assign var="selectLink" value=$selectLinkBottom}
		{assign var="actionsLink" value=$actionsLinkBottom}
		{assign var="action_menu_location" value="bottom"}
		{include file='custom/modules/Leads/tpls/ListViewPagination.tpl'}
	</div> <!--end of mail -->

{/if}


{if $contextMenus}
<script type="text/javascript">
{$contextMenuScript}
{literal}


$( document ).ready(function() {
					 if($( ".multiselbox").find("option").eq(0).val()==0) $( ".multiselbox").find("option").eq(0).remove();
				 
					 $(".multiselbox").multiselect({
						 texts:{selectAll: "Select All"}
					}); 
				});


 
function lvg_nav(m,id,act,offset,t){
    if(t.href.search(/#/) < 0){return;}
    else{
        if(act=='pte'){
            act='ProjectTemplatesEditView';
        }
        else if(act=='d'){
            act='DetailView';
        }else if( act =='ReportsWizard'){
            act = 'ReportsWizard';
        }else{
            act='EditView';
        }
    {/literal}
        url = 'index.php?module='+m+'&offset=' + offset + '&stamp={$pageData.stamp}&return_module='+m+'&action='+act+'&record='+id;
        t.href=url;
    {literal}
    }
}{/literal}
{literal}
    function lvg_dtails(id){{/literal}
        return SUGAR.util.getAdditionalDetails( '{$pageData.bean.moduleDir|default:$params.module}',id, 'adspan_'+id);{literal}}{/literal}
</script>
<script type="text/javascript" src="include/InlineEditing/inlineEditing.js"></script>
{/if}

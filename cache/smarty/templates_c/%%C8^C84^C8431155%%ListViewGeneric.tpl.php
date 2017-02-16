<?php /* Smarty version 2.6.29, created on 2017-02-16 09:53:16
         compiled from custom/modules/Leads/tpls/ListViewGeneric.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sugar_getjspath', 'custom/modules/Leads/tpls/ListViewGeneric.tpl', 46, false),array('function', 'counter', 'custom/modules/Leads/tpls/ListViewGeneric.tpl', 245, false),array('function', 'sugar_translate', 'custom/modules/Leads/tpls/ListViewGeneric.tpl', 263, false),array('function', 'sugar_getimage', 'custom/modules/Leads/tpls/ListViewGeneric.tpl', 269, false),array('function', 'sugar_ajax_url', 'custom/modules/Leads/tpls/ListViewGeneric.tpl', 338, false),array('function', 'sugar_evalcolumn_old', 'custom/modules/Leads/tpls/ListViewGeneric.tpl', 342, false),array('function', 'sugar_field', 'custom/modules/Leads/tpls/ListViewGeneric.tpl', 344, false),array('modifier', 'replace', 'custom/modules/Leads/tpls/ListViewGeneric.tpl', 201, false),array('modifier', 'default', 'custom/modules/Leads/tpls/ListViewGeneric.tpl', 252, false),array('modifier', 'lower', 'custom/modules/Leads/tpls/ListViewGeneric.tpl', 255, false),array('modifier', 'upper', 'custom/modules/Leads/tpls/ListViewGeneric.tpl', 258, false),)), $this); ?>

<script type='text/javascript' src='<?php echo smarty_function_sugar_getjspath(array('file' => 'include/javascript/popup_helper.js'), $this);?>
'></script>


<script>
<?php echo '
	$(document).ready(function(){
	    $("ul.clickMenu").each(function(index, node){
	  		$(node).sugarActionMenu();
	  	});

        $(\'.selectActionsDisabled\').children().each(function(index) {
            $(this).attr(\'onclick\',\'\').unbind(\'click\');
        });

        var selectedTopValue = $("#selectCountTop").attr("value");
        if(typeof(selectedTopValue) != "undefined" && selectedTopValue != "0"){
        	sugarListView.prototype.toggleSelected();
        }
       });
       function resumeTheNeoxCall(){
		if(confirm(\'Are you sure to resume the call\')){
			SUGAR.ajaxUI.showLoadingPanel();
			var callback = {
				success:function(b){
					SUGAR.ajaxUI.hideLoadingPanel();
					//var parsedJSON = JSON.parse(b.responseText);
					//~ alert(parsedJSON[0]);
					//~ alert(parsedJSON[1]);
					
					if(b.responseText=="200"){	
						//alert(b.responseText)
							document.getElementById(\'show_pause\').innerHTML=\'\';
							document.getElementById(\'show_pause\').innerHTML=\'<button type="button" onclick="pauseTheNeoxCall()">Pause</button>\';
					}
					else{
							SUGAR.ajaxUI.hideLoadingPanel();
							alert(\'Error!!\')
					}
				}
			}
			var connectionObject = YAHOO.util.Connect.asyncRequest(\'GET\', \'index.php?entryPoint=resumeTheNeoxCall\', callback);
		 }
		}
       
       function pauseTheNeoxCall(){
		if(confirm(\'Are you sure to pause the Call Process\')){
			SUGAR.ajaxUI.showLoadingPanel();
			var callback = {
				success:function(b){
					SUGAR.ajaxUI.hideLoadingPanel();
					//var parsedJSON = JSON.parse(b.responseText);
					//~ alert(parsedJSON[0]);
					//~ alert(parsedJSON[1]);
					if(b.responseText=="200"){	
						//alert(b.responseText)
							document.getElementById(\'show_pause\').innerHTML=\'\';
							document.getElementById(\'show_pause\').innerHTML=\'<button type="button" onclick="resumeTheNeoxCall()">Resume</button>\';
			}
					else{
							SUGAR.ajaxUI.hideLoadingPanel();
						alert(\'Error!!\')
					}
				}
			}
			var connectionObject = YAHOO.util.Connect.asyncRequest(\'GET\', \'index.php?entryPoint=pauseTheNeoxCall\', callback);
		 }
       }
       
       function manualDialing(){
		if(confirm(\'Are you sure to shift on Manual dialing\')){
			SUGAR.ajaxUI.showLoadingPanel();
			var callback = {
				success:function(b){
					SUGAR.ajaxUI.hideLoadingPanel();
					//var parsedJSON = JSON.parse(b.responseText);
					//~ alert(parsedJSON[0]);
					//~ alert(parsedJSON[1]);
					if(b.responseText=="200"){	
						//alert(b.responseText)
							document.getElementById(\'shift_call\').innerHTML=\'\';
							document.getElementById(\'shift_call\').innerHTML=\'<button type="button" onclick="predictiveDialing()">Predictive Dialing</button>\';
							window.location.href=\'index.php?module=Leads&action=index\';
					}
					else{
							SUGAR.ajaxUI.hideLoadingPanel();
						alert(\'Error!!\')
					}
				}
			}
			var connectionObject = YAHOO.util.Connect.asyncRequest(\'GET\', \'index.php?entryPoint=manualDialing\', callback);
		 }
       }
       
       
       function predictiveDialing(){
		if(confirm(\'Are you sure to shift on Predictive dialing\')){
			SUGAR.ajaxUI.showLoadingPanel();
			var callback = {
				success:function(b){
					SUGAR.ajaxUI.hideLoadingPanel();
					//var parsedJSON = JSON.parse(b.responseText);
					//~ alert(parsedJSON[0]);
					//~ alert(parsedJSON[1]);
					if(b.responseText=="200"){	
						//alert(b.responseText)
							document.getElementById(\'shift_call\').innerHTML=\'\';
							document.getElementById(\'shift_call\').innerHTML=\'<button type="button" onclick="manualDialing()">Manual Dialing</button>\';
							window.location.href=\'index.php?module=Leads&action=index\';
					}
					else{
							SUGAR.ajaxUI.hideLoadingPanel();
						alert(\'Error!!\')
					}
				}
			}
			var connectionObject = YAHOO.util.Connect.asyncRequest(\'GET\', \'index.php?entryPoint=predictiveDialing\', callback);
		 }
       }
       
       
'; ?>

</script>
<?php $this->assign('currentModule', $this->_tpl_vars['pageData']['bean']['moduleDir']); ?>
<?php $this->assign('singularModule', $this->_tpl_vars['moduleListSingular'][$this->_tpl_vars['currentModule']]); ?>
<?php $this->assign('moduleName', $this->_tpl_vars['moduleList'][$this->_tpl_vars['currentModule']]); ?>
<?php $this->assign('hideTable', false); ?>

<?php if (count ( $this->_tpl_vars['data'] ) == 0): ?>
	
			<?php if ($this->_tpl_vars['LOGGED_IN'] == 'Success'): ?>
			
			<?php if ($this->_tpl_vars['LOGGED_IN_RESUME'] == 'Resume'): ?>
				<span id='show_pause'><button type="button" onclick="pauseTheNeoxCall()">Pause</button></span><span>&nbsp;&nbsp;</span>
			<?php endif; ?>
			<?php if ($this->_tpl_vars['LOGGED_IN_PAUSE'] == 'Pause'): ?>
				<span id='show_pause'><button type="button" onclick="resumeTheNeoxCall()">Resume</button></span><span>&nbsp;&nbsp;</span>
			<?php endif; ?>
			
			
			<?php if ($this->_tpl_vars['LOGGED_IN_MANUAL'] == 'Manual'): ?>
				<span id='shift_call'><button type="button" onclick="predictiveDialing()">Predictive Dialing</button></span>
			<?php endif; ?>
			<?php if ($this->_tpl_vars['LOGGED_IN_PREDICTIVE'] == 'Predictive'): ?>
				<span id='shift_call'><button type="button" onclick="manualDialing()">Manual Dialing</button></span>
			<?php endif; ?>
			
		<?php endif; ?>	
	<?php $this->assign('hideTable', true); ?>
	<div class="list view listViewEmpty">
		<?php if ($this->_tpl_vars['displayEmptyDataMesssages']): ?>
        <?php if (strlen ( $this->_tpl_vars['query'] ) == 0): ?>
                <?php ob_start(); ?><a href="?module=<?php echo $this->_tpl_vars['pageData']['bean']['moduleDir']; ?>
&action=EditView&return_module=<?php echo $this->_tpl_vars['pageData']['bean']['moduleDir']; ?>
&return_action=DetailView"><?php echo $this->_tpl_vars['APP']['LBL_CREATE_BUTTON_LABEL']; ?>
</a><?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('createLink', ob_get_contents());ob_end_clean(); ?>
                <?php ob_start(); ?><a href="?module=Import&action=Step1&import_module=<?php echo $this->_tpl_vars['pageData']['bean']['moduleDir']; ?>
&return_module=<?php echo $this->_tpl_vars['pageData']['bean']['moduleDir']; ?>
&return_action=index"><?php echo $this->_tpl_vars['APP']['LBL_IMPORT']; ?>
</a><?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('importLink', ob_get_contents());ob_end_clean(); ?>
                <?php ob_start(); ?><a target="_blank" href='?module=Administration&action=SupportPortal&view=documentation&version=<?php echo $this->_tpl_vars['sugar_info']['sugar_version']; ?>
&edition=<?php echo $this->_tpl_vars['sugar_info']['sugar_flavor']; ?>
&lang=&help_module=<?php echo $this->_tpl_vars['currentModule']; ?>
&help_action=&key='><?php echo $this->_tpl_vars['APP']['LBL_CLICK_HERE']; ?>
</a><?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('helpLink', ob_get_contents());ob_end_clean(); ?>
                <p class="msg">
                    <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['APP']['MSG_EMPTY_LIST_VIEW_NO_RESULTS'])) ? $this->_run_mod_handler('replace', true, $_tmp, "<item2>", $this->_tpl_vars['createLink']) : smarty_modifier_replace($_tmp, "<item2>", $this->_tpl_vars['createLink'])))) ? $this->_run_mod_handler('replace', true, $_tmp, "<item3>", $this->_tpl_vars['importLink']) : smarty_modifier_replace($_tmp, "<item3>", $this->_tpl_vars['importLink'])); ?>

                </p>
        <?php elseif ($this->_tpl_vars['query'] == "-advanced_search"): ?>
            <p class="msg">
                <?php echo $this->_tpl_vars['APP']['MSG_LIST_VIEW_NO_RESULTS_BASIC']; ?>

            </p>
        <?php else: ?>
            <p class="msg">
                <?php ob_start(); ?>"<?php echo $this->_tpl_vars['query']; ?>
"<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('quotedQuery', ob_get_contents());ob_end_clean(); ?>
                <?php echo ((is_array($_tmp=$this->_tpl_vars['APP']['MSG_LIST_VIEW_NO_RESULTS'])) ? $this->_run_mod_handler('replace', true, $_tmp, "<item1>", $this->_tpl_vars['quotedQuery']) : smarty_modifier_replace($_tmp, "<item1>", $this->_tpl_vars['quotedQuery'])); ?>

            </p>
            <p class = "submsg">
                <a href="?module=<?php echo $this->_tpl_vars['pageData']['bean']['moduleDir']; ?>
&action=EditView&return_module=<?php echo $this->_tpl_vars['pageData']['bean']['moduleDir']; ?>
&return_action=DetailView">
                    <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['APP']['MSG_LIST_VIEW_NO_RESULTS_SUBMSG'])) ? $this->_run_mod_handler('replace', true, $_tmp, "<item1>", $this->_tpl_vars['quotedQuery']) : smarty_modifier_replace($_tmp, "<item1>", $this->_tpl_vars['quotedQuery'])))) ? $this->_run_mod_handler('replace', true, $_tmp, "<item2>", $this->_tpl_vars['singularModule']) : smarty_modifier_replace($_tmp, "<item2>", $this->_tpl_vars['singularModule'])); ?>

                </a>

            </p>
        <?php endif; ?>
    <?php else: ?>
        <p class="msg">
            <?php echo $this->_tpl_vars['APP']['LBL_NO_DATA']; ?>

        </p>
	<?php endif; ?>
	</div>
<?php endif; ?>
<?php echo $this->_tpl_vars['multiSelectData']; ?>

<?php if ($this->_tpl_vars['hideTable'] == false): ?>
	<table cellpadding='0' cellspacing='0' width='100%' border='0' class='list view table'>
	<thead>
	<?php $this->assign('link_select_id', 'selectLinkTop'); ?>
    <?php $this->assign('link_action_id', 'actionLinkTop'); ?>
    <?php $this->assign('actionsLink', $this->_tpl_vars['actionsLinkTop']); ?>
    <?php $this->assign('selectLink', $this->_tpl_vars['selectLinkTop']); ?>
    <?php $this->assign('action_menu_location', 'top'); ?>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'custom/modules/Leads/tpls/ListViewPagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<tr height='20'>
			<?php if ($this->_tpl_vars['prerow']): ?>
				<td width='1%' class="td_alt">
					&nbsp;
				</td>
			<?php endif; ?>
			<?php if (! empty ( $this->_tpl_vars['quickViewLinks'] )): ?>
			<td class='td_alt' width='1%' style="padding: 0px;">&nbsp;</td>
			<?php endif; ?>
			<?php echo smarty_function_counter(array('start' => 0,'name' => 'colCounter','print' => false,'assign' => 'colCounter'), $this);?>

            <?php $this->assign('datahide', 'phone'); ?>
			<?php $_from = $this->_tpl_vars['displayColumns']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['colHeader'] => $this->_tpl_vars['params']):
?>
                <?php if ($this->_tpl_vars['colCounter'] == '3'): ?><?php $this->assign('datahide', "phone,phonelandscape"); ?><?php endif; ?>
                <?php if ($this->_tpl_vars['colCounter'] == '5'): ?><?php $this->assign('datahide', "phone,phonelandscape,tablet"); ?><?php endif; ?>
                <?php if ($this->_tpl_vars['colHeader'] == 'NAME' || $this->_tpl_vars['params']['bold']): ?><th scope='col' data-toggle="true">
				<?php else: ?><th scope='col' data-hide="<?php echo $this->_tpl_vars['datahide']; ?>
"><?php endif; ?>
					<div style='white-space: normal;'width='100%' align='<?php echo ((is_array($_tmp=@$this->_tpl_vars['params']['align'])) ? $this->_run_mod_handler('default', true, $_tmp, 'left') : smarty_modifier_default($_tmp, 'left')); ?>
'>
	                <?php if (((is_array($_tmp=@$this->_tpl_vars['params']['sortable'])) ? $this->_run_mod_handler('default', true, $_tmp, true) : smarty_modifier_default($_tmp, true))): ?>
	                    <?php if ($this->_tpl_vars['params']['url_sort']): ?>
	                        <a href='<?php echo $this->_tpl_vars['pageData']['urls']['orderBy']; ?>
<?php echo ((is_array($_tmp=((is_array($_tmp=@$this->_tpl_vars['params']['orderBy'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['colHeader']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['colHeader'])))) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)); ?>
' class='listViewThLinkS1'>
	                    <?php else: ?>
	                        <?php if (((is_array($_tmp=((is_array($_tmp=@$this->_tpl_vars['params']['orderBy'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['colHeader']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['colHeader'])))) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)) == $this->_tpl_vars['pageData']['ordering']['orderBy']): ?>
	                            <a href='javascript:sListView.order_checks("<?php echo ((is_array($_tmp=@$this->_tpl_vars['pageData']['ordering']['sortOrder'])) ? $this->_run_mod_handler('default', true, $_tmp, 'ASCerror') : smarty_modifier_default($_tmp, 'ASCerror')); ?>
", "<?php echo ((is_array($_tmp=((is_array($_tmp=@$this->_tpl_vars['params']['orderBy'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['colHeader']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['colHeader'])))) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)); ?>
" , "<?php echo $this->_tpl_vars['pageData']['bean']['moduleDir']; ?>
<?php echo '2_'; ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['pageData']['bean']['objectName'])) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp)); ?>
<?php echo '_ORDER_BY'; ?>
")' class='listViewThLinkS1'>
	                        <?php else: ?>
	                            <a href='javascript:sListView.order_checks("ASC", "<?php echo ((is_array($_tmp=((is_array($_tmp=@$this->_tpl_vars['params']['orderBy'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['colHeader']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['colHeader'])))) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)); ?>
" , "<?php echo $this->_tpl_vars['pageData']['bean']['moduleDir']; ?>
<?php echo '2_'; ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['pageData']['bean']['objectName'])) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp)); ?>
<?php echo '_ORDER_BY'; ?>
")' class='listViewThLinkS1'>
	                        <?php endif; ?>
	                    <?php endif; ?>
	                    <?php echo smarty_function_sugar_translate(array('label' => $this->_tpl_vars['params']['label'],'module' => $this->_tpl_vars['pageData']['bean']['moduleDir']), $this);?>

						&nbsp;&nbsp;
						<?php if (((is_array($_tmp=((is_array($_tmp=@$this->_tpl_vars['params']['orderBy'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['colHeader']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['colHeader'])))) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)) == $this->_tpl_vars['pageData']['ordering']['orderBy']): ?>
							<?php if ($this->_tpl_vars['pageData']['ordering']['sortOrder'] == 'ASC'): ?>
								<?php ob_start(); ?>arrow_down.<?php echo $this->_tpl_vars['arrowExt']; ?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('imageName', ob_get_contents());ob_end_clean(); ?>
	                            <?php ob_start(); ?><?php echo smarty_function_sugar_translate(array('label' => 'LBL_ALT_SORT_DESC'), $this);?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('alt_sort', ob_get_contents());ob_end_clean(); ?>
								<?php echo smarty_function_sugar_getimage(array('name' => $this->_tpl_vars['imageName'],'attr' => 'align="absmiddle" border="0" ','alt' => ($this->_tpl_vars['alt_sort'])), $this);?>

							<?php else: ?>
								<?php ob_start(); ?>arrow_up.<?php echo $this->_tpl_vars['arrowExt']; ?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('imageName', ob_get_contents());ob_end_clean(); ?>
	                            <?php ob_start(); ?><?php echo smarty_function_sugar_translate(array('label' => 'LBL_ALT_SORT_ASC'), $this);?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('alt_sort', ob_get_contents());ob_end_clean(); ?>
								<?php echo smarty_function_sugar_getimage(array('name' => $this->_tpl_vars['imageName'],'attr' => 'align="absmiddle" border="0" ','alt' => ($this->_tpl_vars['alt_sort'])), $this);?>

							<?php endif; ?>
						<?php else: ?>
							<?php ob_start(); ?>arrow.<?php echo $this->_tpl_vars['arrowExt']; ?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('imageName', ob_get_contents());ob_end_clean(); ?>
	                        <?php ob_start(); ?><?php echo smarty_function_sugar_translate(array('label' => 'LBL_ALT_SORT'), $this);?>
<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('alt_sort', ob_get_contents());ob_end_clean(); ?>
							<?php echo smarty_function_sugar_getimage(array('name' => $this->_tpl_vars['imageName'],'attr' => 'align="absmiddle" border="0" ','alt' => ($this->_tpl_vars['alt_sort'])), $this);?>

						<?php endif; ?>
	                    </a>
					<?php else: ?>
	                    <?php if (! isset ( $this->_tpl_vars['params']['noHeader'] ) || $this->_tpl_vars['params']['noHeader'] == false): ?>
						  <?php echo smarty_function_sugar_translate(array('label' => $this->_tpl_vars['params']['label'],'module' => $this->_tpl_vars['pageData']['bean']['moduleDir']), $this);?>

	                    <?php endif; ?>
					<?php endif; ?>
					</div>
				</th>
				<?php echo smarty_function_counter(array('name' => 'colCounter'), $this);?>

			<?php endforeach; endif; unset($_from); ?>

		</tr>
	</thead>
		<?php echo smarty_function_counter(array('start' => $this->_tpl_vars['pageData']['offsets']['current'],'print' => false,'assign' => 'offset','name' => 'offset'), $this);?>

		<?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['rowIteration'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['rowIteration']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['id'] => $this->_tpl_vars['rowData']):
        $this->_foreach['rowIteration']['iteration']++;
?>
		    <?php echo smarty_function_counter(array('name' => 'offset','print' => false), $this);?>

	        <?php $this->assign('scope_row', true); ?>

			<?php if ((1 & $this->_foreach['rowIteration']['iteration'])): ?>
				<?php $this->assign('_rowColor', $this->_tpl_vars['rowColor'][0]); ?>
			<?php else: ?>
				<?php $this->assign('_rowColor', $this->_tpl_vars['rowColor'][1]); ?>
			<?php endif; ?>
			<tr height='20' class='<?php echo $this->_tpl_vars['_rowColor']; ?>
S1'>
				<?php if ($this->_tpl_vars['prerow']): ?>
				<td width='1%' class='nowrap'>
				 <?php if (! $this->_tpl_vars['is_admin'] && is_admin_for_user && $this->_tpl_vars['rowData']['IS_ADMIN'] == 1): ?>
						<input type='checkbox' disabled="disabled" class='checkbox' value='<?php echo $this->_tpl_vars['rowData']['ID']; ?>
'>
				 <?php else: ?>
	                    <input title="<?php echo smarty_function_sugar_translate(array('label' => 'LBL_SELECT_THIS_ROW_TITLE'), $this);?>
" onclick='sListView.check_item(this, document.MassUpdate)' type='checkbox' class='checkbox' name='mass[]' value='<?php echo $this->_tpl_vars['rowData']['ID']; ?>
'>
				 <?php endif; ?>
				</td>
				<?php endif; ?>
				<?php if (! empty ( $this->_tpl_vars['quickViewLinks'] )): ?>
	            <?php ob_start(); ?><?php if ($this->_tpl_vars['params']['dynamic_module']): ?><?php echo $this->_tpl_vars['rowData'][$this->_tpl_vars['params']['dynamic_module']]; ?>
<?php else: ?><?php echo $this->_tpl_vars['pageData']['bean']['moduleDir']; ?>
<?php endif; ?><?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('linkModule', ob_get_contents());ob_end_clean(); ?>
	            <?php ob_start(); ?><?php if ($this->_tpl_vars['act']): ?><?php echo $this->_tpl_vars['act']; ?>
<?php else: ?>EditView<?php endif; ?><?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('action', ob_get_contents());ob_end_clean(); ?>
				<td width='2%' nowrap>
                    <?php if ($this->_tpl_vars['pageData']['rowAccess'][$this->_tpl_vars['id']]['edit']): ?>
                        <a title='<?php echo $this->_tpl_vars['editLinkString']; ?>
' id="edit-<?php echo $this->_tpl_vars['rowData']['ID']; ?>
"
                           href="index.php?module=<?php echo $this->_tpl_vars['linkModule']; ?>
&offset=<?php echo $this->_tpl_vars['offset']; ?>
&stamp=<?php echo $this->_tpl_vars['pageData']['stamp']; ?>
&return_module=<?php echo $this->_tpl_vars['linkModule']; ?>
&action=<?php echo $this->_tpl_vars['action']; ?>
&record=<?php echo $this->_tpl_vars['rowData']['ID']; ?>
"
                                >
                            <?php ob_start(); ?><?php echo smarty_function_sugar_translate(array('label' => 'LNK_EDIT'), $this);?>
<?php $this->_smarty_vars['capture']['tmp1'] = ob_get_contents();  $this->assign('alt_edit', ob_get_contents());ob_end_clean(); ?>
                            <?php echo smarty_function_sugar_getimage(array('name' => "edit_inline.gif",'attr' => 'border="0" ','alt' => ($this->_tpl_vars['alt_edit'])), $this);?>
</a>
                    <?php endif; ?>
	            </td>

				<?php endif; ?>
				<?php echo smarty_function_counter(array('start' => 0,'name' => 'colCounter','print' => false,'assign' => 'colCounter'), $this);?>

				<?php $_from = $this->_tpl_vars['displayColumns']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['col'] => $this->_tpl_vars['params']):
?>
                    <?php echo $this->_tpl_vars['displayColumns'][$this->_sections['type']['index']]; ?>

				    <?php echo '<td '; ?><?php if ($this->_tpl_vars['scope_row']): ?><?php echo ' scope=\'row\' '; ?><?php endif; ?><?php echo ' align=\''; ?><?php echo ((is_array($_tmp=@$this->_tpl_vars['params']['align'])) ? $this->_run_mod_handler('default', true, $_tmp, 'left') : smarty_modifier_default($_tmp, 'left')); ?><?php echo '\' valign="top" type="'; ?><?php echo $this->_tpl_vars['displayColumns'][$this->_tpl_vars['col']]['type']; ?><?php echo '" field="'; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['col'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)); ?><?php echo '" class="'; ?><?php if ($this->_tpl_vars['inline_edit'] && ( $this->_tpl_vars['displayColumns'][$this->_tpl_vars['col']]['inline_edit'] == 1 || ! isset ( $this->_tpl_vars['displayColumns'][$this->_tpl_vars['col']]['inline_edit'] ) )): ?><?php echo 'inlineEdit'; ?><?php endif; ?><?php echo ''; ?><?php if (( $this->_tpl_vars['params']['type'] == 'teamset' )): ?><?php echo 'nowrap'; ?><?php endif; ?><?php echo ''; ?><?php if (preg_match ( '/PHONE/' , $this->_tpl_vars['col'] )): ?><?php echo ' phone'; ?><?php endif; ?><?php echo '">'; ?><?php if ($this->_tpl_vars['col'] == 'NAME' || $this->_tpl_vars['params']['bold']): ?><?php echo '<b>'; ?><?php endif; ?><?php echo ''; ?><?php if ($this->_tpl_vars['params']['link'] && ! $this->_tpl_vars['params']['customCode']): ?><?php echo ''; ?><?php ob_start(); ?><?php echo ''; ?><?php if ($this->_tpl_vars['params']['dynamic_module']): ?><?php echo ''; ?><?php echo $this->_tpl_vars['rowData'][$this->_tpl_vars['params']['dynamic_module']]; ?><?php echo ''; ?><?php else: ?><?php echo ''; ?><?php echo ((is_array($_tmp=@$this->_tpl_vars['params']['module'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['pageData']['bean']['moduleDir']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['pageData']['bean']['moduleDir'])); ?><?php echo ''; ?><?php endif; ?><?php echo ''; ?><?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('linkModule', ob_get_contents());ob_end_clean(); ?><?php echo ''; ?><?php ob_start(); ?><?php echo ''; ?><?php if ($this->_tpl_vars['act']): ?><?php echo ''; ?><?php echo $this->_tpl_vars['act']; ?><?php echo ''; ?><?php else: ?><?php echo 'DetailView'; ?><?php endif; ?><?php echo ''; ?><?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('action', ob_get_contents());ob_end_clean(); ?><?php echo ''; ?><?php ob_start(); ?><?php echo ''; ?><?php echo ((is_array($_tmp=@$this->_tpl_vars['rowData'][$this->_tpl_vars['params']['id']])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['rowData']['ID']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['rowData']['ID'])); ?><?php echo ''; ?><?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('record', ob_get_contents());ob_end_clean(); ?><?php echo ''; ?><?php ob_start(); ?><?php echo 'index.php?module='; ?><?php echo $this->_tpl_vars['linkModule']; ?><?php echo '&offset='; ?><?php echo $this->_tpl_vars['offset']; ?><?php echo '&stamp='; ?><?php echo $this->_tpl_vars['pageData']['stamp']; ?><?php echo '&return_module='; ?><?php echo $this->_tpl_vars['linkModule']; ?><?php echo '&action='; ?><?php echo $this->_tpl_vars['action']; ?><?php echo '&record='; ?><?php echo $this->_tpl_vars['record']; ?><?php echo ''; ?><?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('url', ob_get_contents());ob_end_clean(); ?><?php echo '<'; ?><?php echo ((is_array($_tmp=@$this->_tpl_vars['pageData']['tag'][$this->_tpl_vars['id']][$this->_tpl_vars['params']['ACLTag']])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['pageData']['tag'][$this->_tpl_vars['id']]['MAIN']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['pageData']['tag'][$this->_tpl_vars['id']]['MAIN'])); ?><?php echo ' href="'; ?><?php echo smarty_function_sugar_ajax_url(array('url' => $this->_tpl_vars['url']), $this);?><?php echo '">'; ?><?php endif; ?><?php echo ''; ?><?php if ($this->_tpl_vars['params']['customCode']): ?><?php echo ''; ?><?php echo smarty_function_sugar_evalcolumn_old(array('var' => $this->_tpl_vars['params']['customCode'],'rowData' => $this->_tpl_vars['rowData']), $this);?><?php echo ''; ?><?php else: ?><?php echo ''; ?><?php echo smarty_function_sugar_field(array('parentFieldArray' => $this->_tpl_vars['rowData'],'vardef' => $this->_tpl_vars['params'],'displayType' => 'ListView','field' => $this->_tpl_vars['col']), $this);?><?php echo ''; ?><?php endif; ?><?php echo ''; ?><?php if (empty ( $this->_tpl_vars['rowData'][$this->_tpl_vars['col']] ) && empty ( $this->_tpl_vars['params']['customCode'] )): ?><?php echo '&nbsp;'; ?><?php endif; ?><?php echo ''; ?><?php if ($this->_tpl_vars['params']['link'] && ! $this->_tpl_vars['params']['customCode']): ?><?php echo '</'; ?><?php echo ((is_array($_tmp=@$this->_tpl_vars['pageData']['tag'][$this->_tpl_vars['id']][$this->_tpl_vars['params']['ACLTag']])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['pageData']['tag'][$this->_tpl_vars['id']]['MAIN']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['pageData']['tag'][$this->_tpl_vars['id']]['MAIN'])); ?><?php echo '>'; ?><?php endif; ?><?php echo ''; ?><?php if ($this->_tpl_vars['inline_edit'] && ( $this->_tpl_vars['displayColumns'][$this->_tpl_vars['col']]['inline_edit'] == 1 || ! isset ( $this->_tpl_vars['displayColumns'][$this->_tpl_vars['col']]['inline_edit'] ) )): ?><?php echo '<div class="inlineEditIcon">'; ?><?php echo smarty_function_sugar_getimage(array('name' => "inline_edit_icon.svg",'attr' => 'border="0" ','alt' => ($this->_tpl_vars['alt_edit'])), $this);?><?php echo '</div>'; ?><?php endif; ?><?php echo '</td>'; ?>

	                <?php $this->assign('scope_row', false); ?>
					<?php echo smarty_function_counter(array('name' => 'colCounter'), $this);?>


				<?php endforeach; endif; unset($_from); ?>
				<td align='right' style="display:none;"><?php echo $this->_tpl_vars['pageData']['additionalDetails'][$this->_tpl_vars['id']]; ?>
</td>
		    	</tr>
		<?php endforeach; else: ?>
		<tr height='20' class='<?php echo $this->_tpl_vars['rowColor'][0]; ?>
S1'>
		    <td colspan="<?php echo $this->_tpl_vars['colCount']; ?>
">
		        <em><?php echo $this->_tpl_vars['APP']['LBL_NO_DATA']; ?>
</em>
		    </td>
		</tr>
		<?php endif; unset($_from); ?>
    <?php $this->assign('link_select_id', 'selectLinkBottom'); ?>
    <?php $this->assign('link_action_id', 'actionLinkBottom'); ?>
    <?php $this->assign('selectLink', $this->_tpl_vars['selectLinkBottom']); ?>
    <?php $this->assign('actionsLink', $this->_tpl_vars['actionsLinkBottom']); ?>
    <?php $this->assign('action_menu_location', 'bottom'); ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'include/ListView/ListViewPagination.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	</table>
<?php endif; ?>
<?php if ($this->_tpl_vars['contextMenus']): ?>
<script type="text/javascript">
<?php echo $this->_tpl_vars['contextMenuScript']; ?>

<?php echo '
function lvg_nav(m,id,act,offset,t){
    if(t.href.search(/#/) < 0){return;}
    else{
        if(act==\'pte\'){
            act=\'ProjectTemplatesEditView\';
        }
        else if(act==\'d\'){
            act=\'DetailView\';
        }else if( act ==\'ReportsWizard\'){
            act = \'ReportsWizard\';
        }else{
            act=\'EditView\';
        }
    '; ?>

        url = 'index.php?module='+m+'&offset=' + offset + '&stamp=<?php echo $this->_tpl_vars['pageData']['stamp']; ?>
&return_module='+m+'&action='+act+'&record='+id;
        t.href=url;
    <?php echo '
    }
}'; ?>

<?php echo '
    function lvg_dtails(id){'; ?>

        return SUGAR.util.getAdditionalDetails( '<?php echo ((is_array($_tmp=@$this->_tpl_vars['pageData']['bean']['moduleDir'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['params']['module']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['params']['module'])); ?>
',id, 'adspan_'+id);<?php echo '}'; ?>

</script>
<script type="text/javascript" src="include/InlineEditing/inlineEditing.js"></script>
<?php endif; ?>
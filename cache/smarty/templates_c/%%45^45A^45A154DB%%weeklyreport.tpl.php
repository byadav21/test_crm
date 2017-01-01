<?php /* Smarty version 2.6.29, created on 2016-12-29 00:12:52
         compiled from custom/modules/AOR_Reports/tpls/weeklyreport.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', 'custom/modules/AOR_Reports/tpls/weeklyreport.tpl', 86, false),)), $this); ?>
<?php echo '
<script>
$(function(){
	$("#batch_val").change(function(){
		$("#vendor_val").html(\'\');
		if($(this).val()!=\'\'){
			$.ajax({url: "index.php?entryPoint=getutm&batch_val="+$(this).val()+"", success: function(result){
				var result = JSON.parse(result);
				if(result.status==\'ok\'){
				var utm=\'\';
				 for(var i=0;i<result.res.length;i++){
						var id = result.res[i].id;
						var name = result.res[i].name;
						utm+=\'<option value="\'+id+\'">\'+name+\'</option>\'
				 }
				 $("#vendor_val").html(utm);
				 $("#batch_created_date").val(result.date_entered);
				}
			}});
		}
	});
});
</script>
'; ?>

<section class="moduleTitle"> <h2>Weekly Report Report</h2><br/><br/>
<form name="search_form" id="search_form" class="search_form" method="post" action="index.php?module=AOR_Reports&action=weeklyreport">
<input type="hidden" name="batch_created_date" id="batch_created_date" value="<?php echo $this->_tpl_vars['batch_created_date']; ?>
">
<div id="te_budgeted_campaignbasic_searchSearchForm" style="" class="edit view search basic">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
		<tr>      
			<td scope="row" nowrap="nowrap" width="1%">		
				<label for="batch_basic">Batch</label>
			</td>	
			<td nowrap="nowrap" width="10%">			
				<select name="batch_val" id="batch_val">
					<option  value="">Select Batch</option>
					<?php $_from = $this->_tpl_vars['batchList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['batch']):
?>
						<option value="<?php echo $this->_tpl_vars['batch']['id']; ?>
" <?php if ($this->_tpl_vars['selected_batch'] == $this->_tpl_vars['batch']['id']): ?> selected="selected" <?php endif; ?>><?php echo $this->_tpl_vars['batch']['name']; ?>
</option>
					<?php endforeach; endif; unset($_from); ?>							
				</select>
			</td>
			<td scope="row" nowrap="nowrap" width="1%">
				<label for="week_basic">Vendor</label>
			</td>	
			<td nowrap="nowrap" width="1%">  
				<select name="vendor_val[]"  multiple id="vendor_val">
					<?php $_from = $this->_tpl_vars['vendorList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['vendor']):
?>
						<option value="<?php echo $this->_tpl_vars['vendor']['id']; ?>
"<?php if (in_array ( $this->_tpl_vars['vendor']['id'] , $this->_tpl_vars['selected_vendor'] )): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['vendor']['name']; ?>
</option>						
					<?php endforeach; endif; unset($_from); ?>			
				</select>
			</td>

			<td class="sumbitButtons">
				<input tabindex="2" title="Search" onclick="SUGAR.savedViews.setChooser();" class="button" type="submit" name="button" value="Search" id="search_form_submit">&nbsp;
				<input tabindex="2" title="Clear" onclick="SUGAR.searchForm.clear_form(this.form); return false;" class="button" type="button" name="clear" id="search_form_clear" value="Clear">
	        </td>
			<td class="helpIcon" width="*"><img alt="Help" border="0" id="filterHelp" src="themes/SuiteR/images/help-dashlet.png?v=mjry3sKU3KG11ojfGn-sdg"></td>
		</tr>
		<tr>
			<td scope="row" nowrap="nowrap" width="1%">
				<input tabindex="2" title="Export" onclick="SUGAR.savedViews.setChooser();" class="button" type="submit" name="export" value="Export" id="export_form_submit">
				<input tabindex="2" title="Send Email" onclick="SUGAR.savedViews.setChooser();" class="button" type="submit" name="sendemail" value="Send Email" id="sendemail_form_submit">
			</td>
		</tr>
		</tbody>
	</table>
</div>
</form>
<table cellpadding="0" cellspacing="0" width="100%" border="0" class="list view table footable-loaded footable default">
	<thead>    	
	<tr height="20">
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">	
			<strong>Week</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
			<strong>CPL</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
			<strong>CPA</strong>
		</th>
	</tr>
	<?php $_from = $this->_tpl_vars['reportData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['data']):
?>
		<tr height="20" class="oddListRowS1">
		   <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column"><?php echo $this->_tpl_vars['key']; ?>
</td>
		   <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column"><?php echo ((is_array($_tmp=$this->_tpl_vars['data']['cpl'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ".", ",") : number_format($_tmp, 2, ".", ",")); ?>
</td> 
		   <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column"><?php echo ((is_array($_tmp=$this->_tpl_vars['data']['cpa'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ".", ",") : number_format($_tmp, 2, ".", ",")); ?>
</td>					
		</tr>				
	<?php endforeach; endif; unset($_from); ?>
</table>
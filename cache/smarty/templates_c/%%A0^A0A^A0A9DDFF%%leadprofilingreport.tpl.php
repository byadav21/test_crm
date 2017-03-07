<?php /* Smarty version 2.6.29, created on 2017-03-07 05:52:01
         compiled from custom/modules/AOR_Reports/tpls/leadprofilingreport.tpl */ ?>
<section class="moduleTitle"> <h2>Lead Profiling Report</h2><br/><br/>
<form name="search_form" id="search_form" class="search_form" method="post" action="index.php?module=AOR_Reports&action=leadprofilingreport">
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
				<select name="batch[]" id="batch" multiple>
					<option  value=""></option>
					<?php $_from = $this->_tpl_vars['batchList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['batch']):
?>
						<option value="<?php echo $this->_tpl_vars['batch']['id']; ?>
" <?php if ($this->_tpl_vars['selected_batch'] == $this->_tpl_vars['batch']['id']): ?> selected="selected" <?php endif; ?>><?php echo $this->_tpl_vars['batch']['name']; ?>
</option>
					<?php endforeach; endif; unset($_from); ?>							
				</select>
				</td>
				
			<td class="sumbitButtons">
				<input tabindex="2" title="Search" onclick="SUGAR.savedViews.setChooser();" class="button" type="submit" name="button" value="Search" id="search_form_submit">&nbsp;
				<input tabindex="2" title="Clear" onclick="SUGAR.searchForm.clear_form(this.form); return false;" class="button" type="button" name="clear" id="search_form_clear" value="Clear">
	        </td>
			<td nowrap="nowrap" width="10%">&nbsp;</td>
			<td class="helpIcon" width="*"><img alt="Help" border="0" id="filterHelp" src="themes/SuiteR/images/help-dashlet.png?v=mjry3sKU3KG11ojfGn-sdg"></td>
		</tr>
		<tr>
			<td scope="row" nowrap="nowrap" width="1%">
				<input tabindex="2" title="Export" onclick="SUGAR.savedViews.setChooser();" class="button" type="submit" name="export" value="Export" id="export_form_submit">
		
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
			<strong>Student</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
			<strong>Batch</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
			<strong>Gender</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
			<strong>Email</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
			<strong>Phone</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
			<strong>Experience</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
			<strong>Education</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
			<strong>City</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
			<strong>State</strong>
		</th>
		
	</tr>
	<?php $_from = $this->_tpl_vars['councelorList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['councelor']):
?>
		<tr height="20" class="oddListRowS1">
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column"><?php echo $this->_tpl_vars['councelor']['student']; ?>
</td>
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column"><?php echo $this->_tpl_vars['councelor']['batch']; ?>
</td> 
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column"><?php echo $this->_tpl_vars['councelor']['gender']; ?>
</td>
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column"><?php echo $this->_tpl_vars['councelor']['email']; ?>
</td> 
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column"><?php echo $this->_tpl_vars['councelor']['mobile']; ?>
</td> 
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column"><?php echo $this->_tpl_vars['councelor']['work_experience_c']; ?>
</td>
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column"><?php echo $this->_tpl_vars['councelor']['education_c']; ?>
</td>
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column"><?php echo $this->_tpl_vars['councelor']['primary_address_city']; ?>
</td>
			<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column"><?php echo $this->_tpl_vars['councelor']['primary_address_state']; ?>
</td> 		   
		</tr>				
	<?php endforeach; endif; unset($_from); ?>
</table>

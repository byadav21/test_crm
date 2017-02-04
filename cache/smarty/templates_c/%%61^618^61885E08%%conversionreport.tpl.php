<?php /* Smarty version 2.6.29, created on 2017-02-03 05:06:53
         compiled from custom/modules/AOR_Reports/tpls/conversionreport.tpl */ ?>
<?php echo '
<script>
$(function(){
	$("#status").change(function(){		
		if($(this).val()!=\'\'){
			$.ajax({url: "index.php?entryPoint=getbatchbyleadstatus&status="+$(this).val()+"", success: function(result){
				var result = JSON.parse(result);
				if(result.status==\'ok\'){				
				var utm=\'\';
				 for(var i=0;i<result.res.length;i++){
						var id = result.res[i].id;
						var name = result.res[i].name;
						utm+=\'<option value="\'+id+\'">\'+name+\'</option>\'
				 }
				 $("#batch").html(utm);				
				}
			}});
		}
	});
});
</script>
'; ?>

<section class="moduleTitle"> <h2>Conversion Report</h2><br/><br/>
<form name="search_form" id="search_form" class="search_form" method="post" action="index.php?module=AOR_Reports&action=conversionreport">
<input type="hidden" name="batch_created_date" id="batch_created_date" value="<?php echo $this->_tpl_vars['batch_created_date']; ?>
">
<div id="te_budgeted_campaignbasic_searchSearchForm" style="" class="edit view search basic">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
		<tr>      
			<td scope="row" nowrap="nowrap" width="1%">		
				<label for="batch_basic">Status</label>
			</td>
			<td nowrap="nowrap" width="10%">			
				<select name="status" id="status">
					<?php if ($this->_tpl_vars['selected_status'] == 'Live'): ?>
						<option value="Live" selected>Live</option>
					<?php else: ?>
						<option value="Live">Live</option>
					<?php endif; ?>
					<?php if ($this->_tpl_vars['selected_status'] == 'Closed'): ?>
						<option value="Closed" selected>Closed</option>
					<?php else: ?>
						<option value="Closed">Closed</option>
					<?php endif; ?>
				</select>
			</td>	
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
"<?php if (in_array ( $this->_tpl_vars['batch']['id'] , $this->_tpl_vars['selected_batch'] )): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['batch']['name']; ?>
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
			<strong>Counsellors</strong>
		</th>
		<?php $_from = $this->_tpl_vars['programList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['program']):
?>
			<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
				<strong><?php echo $this->_tpl_vars['program']; ?>
</strong>
			</th>
		<?php endforeach; endif; unset($_from); ?>		
	</tr>
	<?php $_from = $this->_tpl_vars['councelorList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['councelor']):
?>
		<tr height="20" class="oddListRowS1">
		   <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column"><?php echo $this->_tpl_vars['councelor']['name']; ?>
</td>
		   <?php $_from = $this->_tpl_vars['programList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['program']):
?>
				<td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column"><?php echo $this->_tpl_vars['councelor'][$this->_tpl_vars['key']]; ?>
</td> 
		   <?php endforeach; endif; unset($_from); ?>		  				
		</tr>				
	<?php endforeach; endif; unset($_from); ?>
</table>
<?php /* Smarty version 2.6.29, created on 2017-02-03 05:06:47
         compiled from custom/modules/AOR_Reports/tpls/pipelinereport.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', 'custom/modules/AOR_Reports/tpls/pipelinereport.tpl', 56, false),)), $this); ?>
<section class="moduleTitle"> <h2>Pipeline Report</h2><br/><br/>
<form name="search_form" id="search_form" class="search_form" method="post" action="index.php?module=AOR_Reports&action=pipelinereport">
<input type="hidden" name="batch_created_date" id="batch_created_date" value="<?php echo $this->_tpl_vars['batch_created_date']; ?>
">
<div id="te_budgeted_campaignbasic_searchSearchForm" style="" class="edit view search basic">
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
		<tbody>
		<tr>      
			<td scope="row" nowrap="nowrap" width="1%">		
				<label for="batch_basic">From Date</label>
			</td>
			<td nowrap="nowrap" width="10%">			
				<input name="from_date" type="text"  value="<?php echo $this->_tpl_vars['selected_from_date']; ?>
" id='from_date'/>
				<img src="themes/SuiteP/images/jscalendar.gif?v=yt-yazfsU-Y9uR7ixqf7Lg" alt="Enter Date" style="position:relative; top:-1px" border="0" id="from_date_trigger">
			</td>	
			<td scope="row" nowrap="nowrap" width="1%">		
				<label for="batch_basic">To Date</label>
			</td>
			<td nowrap="nowrap" width="10%">			
				<input name="to_date" type="text"  value="<?php echo $this->_tpl_vars['selected_to_date']; ?>
" id='to_date'/>
				<img src="themes/SuiteP/images/jscalendar.gif?v=yt-yazfsU-Y9uR7ixqf7Lg" alt="Enter Date" style="position:relative; top:-1px" border="0" id="to_date_trigger">
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
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
			<strong>Warm</strong>
		</th>
		<th scope="col" data-hide="phone" class="footable-visible footable-first-column">					
			<strong>GSV</strong>
		</th>
	</tr>
	<?php $_from = $this->_tpl_vars['councelorList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['councelor']):
?>
		<tr height="20" class="oddListRowS1">
		   <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column"><?php echo $this->_tpl_vars['councelor']['name']; ?>
</td>
		   <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column"><?php echo $this->_tpl_vars['councelor']['warm']; ?>
</td> 
		   <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column"><?php echo ((is_array($_tmp=$this->_tpl_vars['councelor']['gsv'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ".", ",") : number_format($_tmp, 2, ".", ",")); ?>
</td>					
		</tr>				
	<?php endforeach; endif; unset($_from); ?>
</table>
<script>
<?php echo '
Calendar.setup ({
   inputField : "from_date",
   daFormat : "%d/%m/%Y %I:%M%P",
   button : "from_date_trigger",
   singleClick : true,
   dateStr : "",
   step : 1,
   weekNumbers:false,
});
</script>
'; ?>

<script>
<?php echo '
Calendar.setup ({
   inputField : "to_date",
   daFormat : "%d/%m/%Y %I:%M%P",
   button : "to_date_trigger",
   singleClick : true,
   dateStr : "",
   step : 1,
   weekNumbers:false,
});
</script>
'; ?>
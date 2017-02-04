<?php /* Smarty version 2.6.29, created on 2017-02-03 04:18:34
         compiled from custom/modules/Leads/Dashlets/StagewiseDashlet/StagewiseDashletOptions.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'custom/modules/Leads/Dashlets/StagewiseDashlet/StagewiseDashletOptions.tpl', 23, false),)), $this); ?>

<div style='width: 500px'>
<form name='configure_<?php echo $this->_tpl_vars['id']; ?>
' action="index.php" method="post" onSubmit='return SUGAR.dashlets.postForm("configure_<?php echo $this->_tpl_vars['id']; ?>
", SUGAR.mySugar.uncoverPage);'>
<input type='hidden' name='id' value='<?php echo $this->_tpl_vars['id']; ?>
'>
<input type='hidden' name='module' value='Home'>
<input type='hidden' name='action' value='ConfigureDashlet'>
<input type='hidden' name='to_pdf' value='true'>
<input type='hidden' name='configure' value='true'>
<table width="400" cellpadding="0" cellspacing="0" border="0" class="edit view" align="center">
<tr>
    <td valign='top' nowrap scope='row'><?php echo $this->_tpl_vars['titleLbl']; ?>
</td>
    <td valign='top'>
    	<input class="text" name="title" size='20' value='<?php echo $this->_tpl_vars['title']; ?>
'>
    </td>
</tr>
<?php if ($this->_tpl_vars['isRefreshable']): ?>
<tr>
    <td scope='row'>
        <?php echo $this->_tpl_vars['autoRefresh']; ?>

    </td>
    <td>
        <select name='autoRefresh'>
            <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['autoRefreshOptions'],'selected' => $this->_tpl_vars['autoRefreshSelect']), $this);?>

        </select>
    </td>
</tr>
<?php endif; ?>
<tr>
    <td valign='top' nowrap scope='row'>Top Batch</td>
    <td valign='top'>
		<select name='top_batch'>
			<?php if ($this->_tpl_vars['top_batch'] == 10): ?>
				<option value="10" selected>Top 10</option>
			<?php else: ?>
				<option value="10">Top 10</option>
			<?php endif; ?>
			<?php if ($this->_tpl_vars['top_batch'] == 20): ?>
				<option value="20" selected>Top 20</option>
			<?php else: ?>
				<option value="20">Top 20</option>
			<?php endif; ?>
			<?php if ($this->_tpl_vars['top_batch'] == 30): ?>
				<option value="30" selected>Top 30</option>
			<?php else: ?>
				<option value="30">Top 30</option>
			<?php endif; ?>
			<?php if ($this->_tpl_vars['top_batch'] == 50): ?>
				<option value="50" selected>Top 50</option>
			<?php else: ?>
				<option value="50">Top 50</option>
			<?php endif; ?>			
        </select>
    
    </td>
</tr>
<tr>
    <td valign='top' nowrap scope='row'><?php echo $this->_tpl_vars['heightLbl']; ?>
</td>
    <td valign='top'>
    	<input class="text" name="height" size='3' value='<?php echo $this->_tpl_vars['height']; ?>
'>
    </td>
</tr>
<tr>
    <td align="right" colspan="2">
        <input type='submit' class='button' value='<?php echo $this->_tpl_vars['saveLbl']; ?>
'>
   	</td>
</tr>
</table>
</form>

</div>
   
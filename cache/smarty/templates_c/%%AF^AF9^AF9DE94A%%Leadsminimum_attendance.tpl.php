<?php /* Smarty version 2.6.29, created on 2017-02-01 07:21:14
         compiled from cache/modules/Import/Leadsminimum_attendance.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sugar_number_format', 'cache/modules/Import/Leadsminimum_attendance.tpl', 8, false),)), $this); ?>

<?php if (strlen ( $this->_tpl_vars['fields']['minimum_attendance']['value'] ) <= 0): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['minimum_attendance']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['minimum_attendance']['value']); ?>
<?php endif; ?>  
<input type='text' name='<?php echo $this->_tpl_vars['fields']['minimum_attendance']['name']; ?>
' 
id='<?php echo $this->_tpl_vars['fields']['minimum_attendance']['name']; ?>
' size='30' maxlength='11' value='<?php echo smarty_function_sugar_number_format(array('precision' => 0,'var' => $this->_tpl_vars['value']), $this);?>
' title='' tabindex='1'    >
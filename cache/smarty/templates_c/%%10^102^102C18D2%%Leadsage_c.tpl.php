<?php /* Smarty version 2.6.29, created on 2017-02-01 07:21:15
         compiled from cache/modules/Import/Leadsage_c.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sugar_number_format', 'cache/modules/Import/Leadsage_c.tpl', 8, false),)), $this); ?>

<?php if (strlen ( $this->_tpl_vars['fields']['age_c']['value'] ) <= 0): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['age_c']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['age_c']['value']); ?>
<?php endif; ?>  
<input type='text' name='<?php echo $this->_tpl_vars['fields']['age_c']['name']; ?>
' 
id='<?php echo $this->_tpl_vars['fields']['age_c']['name']; ?>
' size='30' maxlength='20' value='<?php echo smarty_function_sugar_number_format(array('precision' => 0,'var' => $this->_tpl_vars['value']), $this);?>
' title='' tabindex='1'    >
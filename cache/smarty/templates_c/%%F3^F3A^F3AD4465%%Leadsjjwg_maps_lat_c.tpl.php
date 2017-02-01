<?php /* Smarty version 2.6.29, created on 2017-02-01 07:21:15
         compiled from cache/modules/Import/Leadsjjwg_maps_lat_c.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sugar_number_format', 'cache/modules/Import/Leadsjjwg_maps_lat_c.tpl', 10, false),)), $this); ?>

<?php if (strlen ( $this->_tpl_vars['fields']['jjwg_maps_lat_c']['value'] ) <= 0): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['jjwg_maps_lat_c']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['jjwg_maps_lat_c']['value']); ?>
<?php endif; ?>  
<input type='text' name='<?php echo $this->_tpl_vars['fields']['jjwg_maps_lat_c']['name']; ?>
'
id='<?php echo $this->_tpl_vars['fields']['jjwg_maps_lat_c']['name']; ?>
'
size='30'
maxlength='10'value='<?php echo smarty_function_sugar_number_format(array('var' => $this->_tpl_vars['value'],'precision' => 8), $this);?>
'
title='Latitude'
tabindex='1'
 
>
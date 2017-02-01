<?php /* Smarty version 2.6.29, created on 2017-02-01 07:21:16
         compiled from cache/modules/Import/Leadscity_c.tpl */ ?>

<?php if (strlen ( $this->_tpl_vars['fields']['city_c']['value'] ) <= 0): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['city_c']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['city_c']['value']); ?>
<?php endif; ?>  
<input type='text' name='<?php echo $this->_tpl_vars['fields']['city_c']['name']; ?>
' 
    id='<?php echo $this->_tpl_vars['fields']['city_c']['name']; ?>
' size='30' 
    maxlength='255' 
    value='<?php echo $this->_tpl_vars['value']; ?>
' title=''  tabindex='1'      >
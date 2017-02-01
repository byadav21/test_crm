<?php /* Smarty version 2.6.29, created on 2017-02-01 07:21:11
         compiled from cache/modules/Import/Leadsdescription.tpl */ ?>

<?php if (empty ( $this->_tpl_vars['fields']['description']['value'] )): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['description']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['description']['value']); ?>
<?php endif; ?>  




<textarea  id='<?php echo $this->_tpl_vars['fields']['description']['name']; ?>
' name='<?php echo $this->_tpl_vars['fields']['description']['name']; ?>
'
rows="6" 
cols="80" 
title='' tabindex="1" 
 ><?php echo $this->_tpl_vars['value']; ?>
</textarea>


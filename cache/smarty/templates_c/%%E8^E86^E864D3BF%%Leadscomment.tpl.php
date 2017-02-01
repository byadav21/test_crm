<?php /* Smarty version 2.6.29, created on 2017-02-01 07:21:14
         compiled from cache/modules/Import/Leadscomment.tpl */ ?>

<?php if (empty ( $this->_tpl_vars['fields']['comment']['value'] )): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['comment']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['comment']['value']); ?>
<?php endif; ?>  




<textarea  id='<?php echo $this->_tpl_vars['fields']['comment']['name']; ?>
' name='<?php echo $this->_tpl_vars['fields']['comment']['name']; ?>
'
rows="6" 
cols="103" 
title='' tabindex="1" 
 ><?php echo $this->_tpl_vars['value']; ?>
</textarea>


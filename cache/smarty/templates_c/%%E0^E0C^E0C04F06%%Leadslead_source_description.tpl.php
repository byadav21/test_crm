<?php /* Smarty version 2.6.29, created on 2017-02-01 07:21:11
         compiled from cache/modules/Import/Leadslead_source_description.tpl */ ?>

<?php if (empty ( $this->_tpl_vars['fields']['lead_source_description']['value'] )): ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['lead_source_description']['default_value']); ?>
<?php else: ?>
<?php $this->assign('value', $this->_tpl_vars['fields']['lead_source_description']['value']); ?>
<?php endif; ?>  




<textarea  id='<?php echo $this->_tpl_vars['fields']['lead_source_description']['name']; ?>
' name='<?php echo $this->_tpl_vars['fields']['lead_source_description']['name']; ?>
'
rows="2" 
cols="20" 
title='' tabindex="1" 
 ><?php echo $this->_tpl_vars['value']; ?>
</textarea>


<?php /* Smarty version 2.6.29, created on 2017-02-01 07:21:15
         compiled from cache/modules/Import/Leadsprevious_courses_from_te_c.tpl */ ?>

<?php if (strval ( $this->_tpl_vars['fields']['previous_courses_from_te_c']['value'] ) == '1' || strval ( $this->_tpl_vars['fields']['previous_courses_from_te_c']['value'] ) == 'yes' || strval ( $this->_tpl_vars['fields']['previous_courses_from_te_c']['value'] ) == 'on'): ?> 
<?php $this->assign('checked', 'checked="checked"'); ?>
<?php else: ?>
<?php $this->assign('checked', ""); ?>
<?php endif; ?>
<input type="hidden" name="<?php echo $this->_tpl_vars['fields']['previous_courses_from_te_c']['name']; ?>
" value="0"> 
<input type="checkbox" id="<?php echo $this->_tpl_vars['fields']['previous_courses_from_te_c']['name']; ?>
" 
name="<?php echo $this->_tpl_vars['fields']['previous_courses_from_te_c']['name']; ?>
" 
value="1" title='' tabindex="1" <?php echo $this->_tpl_vars['checked']; ?>
 >
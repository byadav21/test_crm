<?php /* Smarty version 2.6.29, created on 2017-02-01 07:21:13
         compiled from cache/modules/Import/Leadspayment_realized_check.tpl */ ?>

<?php if (strval ( $this->_tpl_vars['fields']['payment_realized_check']['value'] ) == '1' || strval ( $this->_tpl_vars['fields']['payment_realized_check']['value'] ) == 'yes' || strval ( $this->_tpl_vars['fields']['payment_realized_check']['value'] ) == 'on'): ?> 
<?php $this->assign('checked', 'checked="checked"'); ?>
<?php else: ?>
<?php $this->assign('checked', ""); ?>
<?php endif; ?>
<input type="hidden" name="<?php echo $this->_tpl_vars['fields']['payment_realized_check']['name']; ?>
" value="0"> 
<input type="checkbox" id="<?php echo $this->_tpl_vars['fields']['payment_realized_check']['name']; ?>
" 
name="<?php echo $this->_tpl_vars['fields']['payment_realized_check']['name']; ?>
" 
value="1" title='' tabindex="1" <?php echo $this->_tpl_vars['checked']; ?>
 >
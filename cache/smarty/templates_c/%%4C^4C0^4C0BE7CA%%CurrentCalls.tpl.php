<?php /* Smarty version 2.6.29, created on 2017-02-03 05:07:13
         compiled from custom/modules/te_disposition/tpls/CurrentCalls.tpl */ ?>


<?php $this->assign('alt_start', $this->_tpl_vars['navStrings']['start']); ?>
<?php $this->assign('alt_next', $this->_tpl_vars['navStrings']['next']); ?>
<?php $this->assign('alt_prev', $this->_tpl_vars['navStrings']['previous']); ?>
<?php $this->assign('alt_end', $this->_tpl_vars['navStrings']['end']); ?>
<span id="cc"><b>Running Calls</b></span>
	<tr id='pacurrent_calls'  role='presentation'>
		<td colspan='<?php if ($this->_tpl_vars['prerow']): ?><?php echo $this->_tpl_vars['colCount']+1; ?>
<?php else: ?><?php echo $this->_tpl_vars['colCount']; ?>
<?php endif; ?>'>
			<span id="running_call_container">
			No Runnung Calls
			</span>
		</td>
	</tr>
	<tr>&nbsp;</tr>
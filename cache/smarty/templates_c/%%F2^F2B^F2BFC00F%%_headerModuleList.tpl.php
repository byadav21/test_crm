<?php /* Smarty version 2.6.29, created on 2017-03-22 15:24:02
         compiled from custom/themes/SuiteR/tpls/_headerModuleList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sugar_link', 'custom/themes/SuiteR/tpls/_headerModuleList.tpl', 77, false),)), $this); ?>
<style><?php echo ' #srmchildmenu{display:block!important}'; ?>
</style>
<div class="col-md-3 left_col">
  <div class="left_col scroll-view">
	<div class="navbar nav_title" style="border: 0;">
	  <a href="index.php" class="site_title"><i class="fa fa-paw"></i> <span><img src="themes/default/images/logo.png"></span></a>
	</div>
	<div class="clearfix"></div>
	
	<!-- sidebar menu -->
	<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
	  <div class="menu_section">
 
				 <?php $this->assign('showsrm', '0'); ?>
                <ul class="nav side-menu">
                
                    <?php $_from = $this->_tpl_vars['groupTabs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['groupList'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['groupList']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['group'] => $this->_tpl_vars['modules']):
        $this->_foreach['groupList']['iteration']++;
?>
                     
                        <?php ob_start(); ?>parentTab=<?php echo $this->_tpl_vars['group']; ?>
<?php $this->_smarty_vars['capture']['extraparams'] = ob_get_contents();  $this->assign('extraparams', ob_get_contents());ob_end_clean(); ?>
                        <?php if ($this->_tpl_vars['group'] == 'All'): ?>
                              <?php continue; ?>
                           <?php endif; ?> 
                        <li >
                             
                            <a href="#"><i class="fa fa-home"></i><?php echo $this->_tpl_vars['group']; ?>
<span class="fa fa-chevron-down"></span></a>
                            <?php if ($this->_tpl_vars['group'] != 'SRM'): ?>
                         
                            <ul  class="nav child_menu" >
                            
                                <?php $_from = $this->_tpl_vars['modules']['modules']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['modulekey'] => $this->_tpl_vars['module']):
?>
                                
									 <?php if ($this->_tpl_vars['modulekey'] == 'te_transfer_batch' || $this->_tpl_vars['modulekey'] == 'te_student_batch' || $this->_tpl_vars['modulekey'] == 'te_student'): ?>
										 <?php $this->assign('showsrm', '1'); ?>
									 <?php endif; ?>
                                
                                    <?php if ($this->_tpl_vars['modulekey'] == 'te_transfer_batch' || $this->_tpl_vars['modulekey'] == 'te_student_batch' || $this->_tpl_vars['modulekey'] == 'te_student' || $this->_tpl_vars['modulekey'] == 'Home'): ?>										
										<?php continue; ?>
									<?php endif; ?> 
                                    <li>
                                        <?php ob_start(); ?>moduleTab_<?php echo ($this->_foreach['moduleList']['iteration']-1); ?>
_<?php echo $this->_tpl_vars['module']; ?>
<?php $this->_smarty_vars['capture']['moduleTabId'] = ob_get_contents();  $this->assign('moduleTabId', ob_get_contents());ob_end_clean(); ?>
                                        <?php echo smarty_function_sugar_link(array('id' => $this->_tpl_vars['moduleTabId'],'module' => $this->_tpl_vars['modulekey'],'data' => $this->_tpl_vars['module'],'extraparams' => $this->_tpl_vars['extraparams']), $this);?>

                                    
                                        <?php if ($this->_tpl_vars['modulekey'] == $this->_tpl_vars['MODULE_TAB']): ?>
											<?php if (count ( $this->_tpl_vars['shortcutTopMenu'][$this->_tpl_vars['modulekey']] ) > 0): ?>
										        <ul id="showactive" class="nav child_menu" style="display:block!important">
												<?php $_from = $this->_tpl_vars['shortcutTopMenu'][$this->_tpl_vars['modulekey']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
													<?php if ($this->_tpl_vars['item']['URL'] == "-"): ?>
														<li><a></a><span>&nbsp;</span></li>
													<?php else: ?>
														<li><a href="<?php echo $this->_tpl_vars['item']['URL']; ?>
"><?php echo $this->_tpl_vars['item']['LABEL']; ?>
</a></li>
													<?php endif; ?>
												<?php endforeach; endif; unset($_from); ?>
												
												</ul>
												<script> $('#showactive').parent().css('display','block'); $('#showactive').parent().parent().css('display','block') ; $('#showactive').parent().parent().parent().addClass('active') ;</script>

											<?php endif; ?>
                                        
                                        <?php endif; ?> 
                                        
                                    </li>
                                <?php endforeach; endif; unset($_from); ?>

                                
                            </ul>
                           
                              
                            
                            
                             <?php else: ?>
									
									
									
									 <ul  class="nav child_menu" >
									    <li> <a href="index.php?module=te_student_batch&action=revenue">Student</a>
									    <ul id="srmchildmenu" class="nav child_menu" >
											<li> <a href="index.php?module=te_student_batch&action=revenue">Summary</a> </li>
											<li> <a href="index.php?action=index&module=te_student_batch">List Student</a> </li>
											<li> <a href="index.php?module=te_student_batch&action=EditView&return_module=te_student_batch&return_action=DetailView">Create Student</a> </li>
											<li><a href="index.php?module=te_transfer_batch">Transfer Request</a> </li>
											<li><a href="index.php?module=te_student_batch&action=dropoutrequest">Dropout Request</a> </li>										
											<li> <a href="index.php?module=Leads&action=EditView&addreferral=true">Add Referrals</a> </li>
											<li> <a href="index.php?module=te_student_batch&action=viewmyrefferal">View My Referrals</a> </li>
											<li> <a href="index.php?module=te_student_batch&action=search_leads">CRM Lead Search</a> </li>
										</ul>
										</li>
									 
									   <?php $_from = $this->_tpl_vars['modules']['modules']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['modulekey'] => $this->_tpl_vars['module']):
?>
									       <?php if ($this->_tpl_vars['modulekey'] == 'te_transfer_batch' || $this->_tpl_vars['modulekey'] == 'te_student_batch' || $this->_tpl_vars['modulekey'] == 'te_student'): ?>
												<?php $this->assign('showsrm', '1'); ?>
											<?php endif; ?>
									     <?php if ($this->_tpl_vars['modulekey'] == 'te_transfer_batch' || $this->_tpl_vars['modulekey'] == 'te_student_batch' || $this->_tpl_vars['modulekey'] == 'te_student' || $this->_tpl_vars['modulekey'] == 'Home'): ?>										
											<?php continue; ?>
										<?php endif; ?>
									    <li>
                                        <?php ob_start(); ?>moduleTab_<?php echo ($this->_foreach['moduleList']['iteration']-1); ?>
_<?php echo $this->_tpl_vars['module']; ?>
<?php $this->_smarty_vars['capture']['moduleTabId'] = ob_get_contents();  $this->assign('moduleTabId', ob_get_contents());ob_end_clean(); ?>
                                        <?php echo smarty_function_sugar_link(array('id' => $this->_tpl_vars['moduleTabId'],'module' => $this->_tpl_vars['modulekey'],'data' => $this->_tpl_vars['module'],'extraparams' => $this->_tpl_vars['extraparams']), $this);?>

                                        <?php if ($this->_tpl_vars['modulekey'] == $this->_tpl_vars['MODULE_TAB']): ?>
											<?php if (count ( $this->_tpl_vars['shortcutTopMenu'][$this->_tpl_vars['modulekey']] ) > 0): ?>
										        <ul id="showactive" class="nav child_menu" style="display:block!important">
												<?php $_from = $this->_tpl_vars['shortcutTopMenu'][$this->_tpl_vars['modulekey']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
													<?php if ($this->_tpl_vars['item']['URL'] == "-"): ?>
														<li><a></a><span>&nbsp;</span></li>
													<?php else: ?>
														<li><a href="<?php echo $this->_tpl_vars['item']['URL']; ?>
"><?php echo $this->_tpl_vars['item']['LABEL']; ?>
</a></li>
													<?php endif; ?>
												<?php endforeach; endif; unset($_from); ?>
												
												</ul>
												<script> $('#showactive').parent().css('display','block'); $('#showactive').parent().parent().css('display','block') ; $('#showactive').parent().parent().parent().addClass('active') ;</script>

											<?php endif; ?>
                                        
                                        <?php endif; ?> 
                                        
                                       </li>
                                       <?php endforeach; endif; unset($_from); ?>
									  </ul>
									 
									 
                             
                             
                             
                             <?php endif; ?> 
                        </li>
                    <?php endforeach; endif; unset($_from); ?>
                </ul>
                
                  <?php if (( $this->_tpl_vars['MODULE_TAB'] == 'te_transfer_batch' || $this->_tpl_vars['MODULE_TAB'] == 'te_student_batch' || $this->_tpl_vars['MODULE_TAB'] == 'te_student' )): ?>
                                <script>
                                 $('#srmchildmenu').parent().parent().css('display','block') ; 
                                  $('#srmchildmenu').css('display','block') ;  
                                </script>
                                <?php endif; ?>
	</div> 

	<!-- /sidebar menu -->
	 
	  </div><!-- sidebar-->
	  
	  
</div> <!-- /left end -->
</div> <!-- /left end -->
        
<!-- top navigation -->
<div class="top_nav">
  <div class="nav_menu">
	<nav>
	  <div class="nav toggle">
		<a id="menu_toggle"><i class="fa fa-bars"></i></a>
	  </div>

	  <ul class="nav navbar-nav navbar-right">
		<li class="">
		  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
			<img src="themes/default/images/img.png" alt=""><?php echo $this->_tpl_vars['CURRENT_USER']; ?>

			<span class=" fa fa-angle-down"></span>
		  </a>
		  <ul class="dropdown-menu dropdown-usermenu pull-right">
		  
			   <?php $_from = $this->_tpl_vars['GCLS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['gcl'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['gcl']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['gcl_key'] => $this->_tpl_vars['GCL']):
        $this->_foreach['gcl']['iteration']++;
?>
				  <li><a id="<?php echo $this->_tpl_vars['gcl_key']; ?>
_link" href="<?php echo $this->_tpl_vars['GCL']['URL']; ?>
"<?php if (! empty ( $this->_tpl_vars['GCL']['ONCLICK'] )): ?> onclick="<?php echo $this->_tpl_vars['GCL']['ONCLICK']; ?>
"<?php endif; ?>><?php echo $this->_tpl_vars['GCL']['LABEL']; ?>
</a></li>
			   <?php endforeach; endif; unset($_from); ?>
			   <li ><a  href='<?php echo $this->_tpl_vars['LOGOUT_LINK']; ?>
'><?php echo $this->_tpl_vars['LOGOUT_LABEL']; ?>
</a></li>
		  
		  </ul>
		</li>

		<li id="desktop_notifications" role="presentation" class="dropdown">
		  <a href="javascript:;" class="dropdown-toggle info-number alertsButton" style="background: transparent;"  data-toggle="dropdown" aria-expanded="false">
			<i class="fa fa-envelope-o"></i>
			<span class="badge bg-green alert_count">0</span>
		  </a>
		   <div id="alerts" class="dropdown-menu" role="menu"><?php echo $this->_tpl_vars['APP']['LBL_EMAIL_ERROR_VIEW_RAW_SOURCE']; ?>
</div>
		  
		</li>
	  </ul>
	</nav>
  </div>
  

  
  
</div>
<!-- /top navigation -->

   	
  <div class="tile_count">
                <?php echo $this->_tpl_vars['statusWiseCount']; ?>

                <?php echo $this->_tpl_vars['convWiseCount']; ?>

  </div>
 
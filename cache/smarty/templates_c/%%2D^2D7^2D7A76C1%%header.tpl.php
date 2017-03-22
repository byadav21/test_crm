<?php /* Smarty version 2.6.29, created on 2017-03-22 15:24:52
         compiled from themes/SuiteR/tpls/header.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "themes/SuiteR/tpls/_head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<body class="nav-md" ng-app="talentedge" onMouseOut="closeMenus();">

 <div class="container body ">
      <div class="main_container">
		
<?php echo $this->_tpl_vars['DCSCRIPT']; ?>

<?php if ($this->_tpl_vars['AUTHENTICATED']): ?>
     <div id="ajaxHeader">
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "custom/themes/SuiteR/tpls/_headerModuleList.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    </div>
<?php endif; ?>
<?php echo '
    <iframe id=\'ajaxUI-history-iframe\' src=\'index.php?entryPoint=getImage&imageName=blank.png\' title=\'empty\' style=\'display:none\'></iframe>
    <input id=\'ajaxUI-history-field\' type=\'hidden\'>
    <script type=\'text/javascript\'>
        if (SUGAR.ajaxUI && !SUGAR.ajaxUI.hist_loaded) {
            YAHOO.util.History.register(\'ajaxUILoc\', "", SUGAR.ajaxUI.go);
            '; ?>
<?php if ($_REQUEST['module'] != 'ModuleBuilder'): ?>            YAHOO.util.History.initialize("ajaxUI-history-field", "ajaxUI-history-iframe");
            <?php endif; ?><?php echo '
        }
    </script>
'; ?>

<!-- Start of page content -->
<?php if ($this->_tpl_vars['AUTHENTICATED']): ?>

	<div id="bootstrap-container" class="right_col" role="main" style="min-height: 3814px;">
          <div  id="content" class="">
			<div id="pagecontent" class="<?php echo $this->_tpl_vars['csshack']; ?>
">

<?php endif; ?>
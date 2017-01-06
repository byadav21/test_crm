<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

$entry_point_registry['clickToCall'] = array('file' => 'custom/modules/Leads/clickToCall.php', 'auth' => true);
$entry_point_registry['saveDisposition'] = array('file' => 'custom/modules/Leads/saveDisposition.php', 'auth' => true);
$entry_point_registry['callHangup'] = array('file' => 'custom/modules/Leads/callHangup.php', 'auth' => true);
$entry_point_registry['callHold'] = array('file' => 'custom/modules/Leads/callHold.php', 'auth' => true);
$entry_point_registry['openCallPopup'] = array('file' => 'custom/modules/Leads/openCallPopup.php', 'auth' => true);
$entry_point_registry['pauseTheNeoxCall'] = array('file' => 'custom/modules/Leads/pauseTheNeoxCall.php', 'auth' => true);
$entry_point_registry['resumeTheNeoxCall'] = array('file' => 'custom/modules/Leads/resumeTheNeoxCall.php', 'auth' => true);
$entry_point_registry['manualDialing'] = array('file' => 'custom/modules/Leads/manualDialing.php', 'auth' => true);
$entry_point_registry['predictiveDialing'] = array('file' => 'custom/modules/Leads/predictiveDialing.php', 'auth' => true);

?>

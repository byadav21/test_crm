<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('modules/AOS_Contracts/views/view.detail.php');

class CustomAOS_ContractsViewDetail extends AOS_ContractsViewDetail
{
    function CustomAOS_ContractsViewDetail()
    {
		parent::AOS_ContractsViewDetail();
    }
	public function _displaySubPanels()
	{
		
		if (isset($this->bean) && !empty($this->bean->id) && (file_exists('modules/' . $this->module . '/metadata/subpaneldefs.php') || file_exists('custom/modules/' . $this->module . '/metadata/subpaneldefs.php') || file_exists('custom/modules/' . $this->module . '/Ext/Layoutdefs/layoutdefs.ext.php'))) {
			
			$GLOBALS['focus'] = $this->bean;
			require_once ('include/SubPanel/SubPanelTiles.php');
			$subpanel = new SubPanelTiles($this->bean, $this->module);
			unset($subpanel->subpanel_definitions->layout_defs['subpanel_setup']['aos_quotes_aos_contracts']);
			echo $subpanel->display();
		}
	}	
}

?>
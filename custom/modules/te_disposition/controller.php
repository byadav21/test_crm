<?php
require_once('include/MVC/View/SugarView.php');
require_once('include/MVC/Controller/SugarController.php');
ini_set('display_errors',"off");
class te_dispositionController extends SugarController
{
	
	function action_listview()
	{
	    require_once('custom/modules/te_disposition/showLeadDetail.php');
	    $this->view_object_map['bean'] = $this->bean;
	    $this->view = 'list';
	    $GLOBALS['view'] = $this->view;
	    $this->bean = new te_dispositionListView();
	}
}

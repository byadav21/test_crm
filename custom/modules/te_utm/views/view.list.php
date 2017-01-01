<?php
require_once('include/MVC/View/views/view.list.php');
class te_UTMViewList extends ViewList
{
    /**
     * @see ViewList::preDisplay()
     */
    public function preDisplay(){
        parent::preDisplay();
    }
	function listViewProcess(){
		global $current_user,$db;
		$this->processSearchForm();
		$this->lv->searchColumns = $this->searchForm->searchColumns;
		if(!$this->headers)
			return;
		if(empty($_REQUEST['search_form_only']) || $_REQUEST['search_form_only'] == false){
			//$this->params['orderBy']='LEAD_NUMBER_C';
			$this->params['orderBy']='date_entered';
			$this->params['overrideOrder']='1';
			$this->params['sortOrder']='DESC';
			$tplFile = 'custom/modules/te_utm/tpls/ListViewGeneric.tpl';
			//$tplFile = 'include/ListView/ListViewGeneric.tpl';
			$this->lv->setup($this->seed, $tplFile, $this->where, $this->params);			
			echo $this->lv->display();
		}	
 	}

}

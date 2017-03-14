<?php

require_once('include/MVC/View/views/view.list.php');
class te_student_batchViewList extends ViewList
{
    /**
     * @see ViewList::preDisplay()
     */
    public function preDisplay(){
		echo '<script type="text/javascript" src="custom/modules/te_student_batch/student_batch.js"></script>';
        parent::preDisplay();
    }
	function listViewProcess(){
		global $current_user,$db;
		$this->processSearchForm();
		/* if($current_user->designation=="BUH"){
			if($this->where!="")
				$this->where .= " AND te_student_batch.dropout_status ='Pending'";
			else
				$this->where .= " te_student_batch.dropout_status ='Pending'";
		} */

		#echo $this->where;die;
		$this->lv->searchColumns = $this->searchForm->searchColumns;
		if(!$this->headers)
			return;
		if(empty($_REQUEST['search_form_only']) || $_REQUEST['search_form_only'] == false){

			$this->params['orderBy']='LEAD_NUMBER_C';
			$this->params['overrideOrder']='1';
			$this->params['sortOrder']='DESC';

			$tplFile = 'include/ListView/ListViewGeneric.tpl';
			$this->lv->setup($this->seed, $tplFile, $this->where, $this->params);
			echo $this->lv->display();
		}
 	}
}

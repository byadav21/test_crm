<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once 'include/MVC/View/views/view.detail.php';
class te_in_institutesViewDetail extends ViewDetail
{
	public function display()
    { 
		global $db;
			$row1 =$db->query("SELECT COUNT(p.id) AS Total FROM te_in_institutes_te_pr_programs_1_c t LEFT JOIN te_pr_programs p ON t.te_in_institutes_te_pr_programs_1te_pr_programs_idb =p.id WHERE p.deleted=0 AND t.deleted=0 AND t.te_in_institutes_te_pr_programs_1te_in_institutes_ida='".$this->bean->id."'");
						$res1 =$db->fetchByAssoc($row1);				
						if(!empty($res1['Total'])){
			   
						unset($this->dv->defs['templateMeta']['form']['buttons'][0]);
						unset($this->dv->defs['templateMeta']['form']['buttons'][2]);
								}
		parent::display();
	}
} 

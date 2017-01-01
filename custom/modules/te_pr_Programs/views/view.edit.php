<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
class te_pr_ProgramsViewEdit extends ViewEdit
{
	public function display(){		
		if(isset($_REQUEST['full_form'])){
			$instituteObj = new te_in_institutes();
 			$institute=$instituteObj->retrieve($_REQUEST['relate_id']);
			$this->bean->te_in_institutes_te_pr_programs_1_name = $institute->name;
			$this->bean->te_in_institutes_te_pr_programs_1te_in_institutes_ida = $institute->id;
		}		
		parent::display();
		
	}  
	 
}

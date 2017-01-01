<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once 'include/MVC/View/views/view.detail.php';
class te_pr_ProgramsViewDetail extends ViewDetail
{
		public function preDisplay()
		{
			parent::preDisplay();
		}
			public function display()
		{ 
			global $db;		
					//echo $pt="SELECT COUNT(te_pr_programs_te_ba_batch_1te_ba_batch_idb) AS Totalbatch from te_pr_programs_te_ba_batch_1_c where deleted=0 AND te_pr_programs_te_ba_batch_1te_pr_programs_ida='".$this->bean->id."'";                                                  
					$row1 =$db->query("SELECT COUNT(te_pr_programs_te_ba_batch_1te_ba_batch_idb) AS Totalbatch from te_pr_programs_te_ba_batch_1_c where deleted=0 AND te_pr_programs_te_ba_batch_1te_pr_programs_ida='".$this->bean->id."'");                                                  
					$res1 =$db->fetchByAssoc($row1);
						//echo $res1['Totalbatch'];
										
					   if(!empty($res1['Totalbatch']))
						 {
							unset($this->dv->defs['templateMeta']['form']['buttons'][0]);
							unset($this->dv->defs['templateMeta']['form']['buttons'][2]);
						 }
						parent::display();
		}
} 
?>

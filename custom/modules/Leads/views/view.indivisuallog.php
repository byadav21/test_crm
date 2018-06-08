<?php
if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');
class LeadsViewIndivisuallog extends SugarView {
			public function __construct() {
					parent::SugarView();
				}
				
				public function display(){
					global $db ,$current_user;
					$logID=$current_user->id;  
		
					if(isset($_GET['ivd'])){
						
						echo $_GET['ivd'];
						}



					$sugarSmarty = new Sugar_Smarty();
					$sugarSmarty->assign("List",$List);
					$sugarSmarty->display('custom/modules/Leads/tpls/indivisuallog.tpl');
			}
		}
?>

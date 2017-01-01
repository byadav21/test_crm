
<?php
if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');

class UserHook {
    function changeUserName(&$bean, $event, $arguments){
	   $bean->email1 = $bean->user_name;
	}
}

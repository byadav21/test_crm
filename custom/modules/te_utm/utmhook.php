
<?php
if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');

class MakeUtmLive {
    function updateLiveOn(&$bean, $event, $arguments){
	   $bean->live_on= date("Y-m-d");
	}
}

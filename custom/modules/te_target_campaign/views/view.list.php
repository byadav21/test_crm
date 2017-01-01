<?php

require_once('include/MVC/View/views/view.list.php');
class te_target_campaignViewList extends ViewList
{
    /**
     * @see ViewList::preDisplay()
     */
    public function preDisplay(){
		echo '<script type="text/javascript" src="custom/modules/te_target_campaign/target_campaign_list.js"></script>';
        parent::preDisplay();
    }
}

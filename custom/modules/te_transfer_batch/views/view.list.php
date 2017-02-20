<?php
require_once('include/MVC/View/views/view.list.php');
class te_transfer_batchViewList extends ViewList
{
    public function preDisplay(){
		echo '<script type="text/javascript" src="custom/modules/te_transfer_batch/transfer_batch.js"></script>';
        parent::preDisplay();
    }
}

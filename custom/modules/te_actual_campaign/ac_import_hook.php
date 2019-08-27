<?php

///include a javascript file

class ImportClass
{

    public function importFunc(&$bean, $event, $arguments)
    {

        global $db;
        if (isset($_REQUEST['import_module']) && $_REQUEST['module'] == "Import")
        {


            //$bean->te_ba_batch_id_c = $bean->te_ba_batch_id_c;
            //$bean->vendor_id        = $bean->te_vendor_id_c;
            $findidSql = "SELECT id FROM te_ba_batch WHERE batch_code='" . $bean->batch . "' AND deleted=0";
	    $batchObj = $db->Query($findidSql);
	    $batchObjData    = $db->fetchByAssoc($batchObj);
            //print_r($batchObjData); echo 'cont= '.$db->getRowCount($batchObjData);
            if ($batchObjData['id']!=''){
                
            $batchSql               = "update te_actual_campaign set te_ba_batch_id_c='".$batchObjData['id']."',vendor_id='$bean->te_vendor_id_c',name='$bean->vendor_c' WHERE id='$bean->id'";
            $batchObj               = $db->query($batchSql);
            }else
            {
            //echo json_encode(array('status'=>'error','msg'=>'Wrong Batch Code {'.$bean->batch.'}!')); exit(); 
            }
        }
    }

}

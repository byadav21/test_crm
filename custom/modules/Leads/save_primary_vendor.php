<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class saveVendorClass
{

  function save_primary_vendor(&$bean, $event, $argument){

    $beanId = $bean->id;
    $phone_mobile = $bean->phone_mobile;
    $email_add_c = $bean->email_add_c;
    $batchId = $bean->te_ba_batch_id_c;
    $batchBean = BeanFactory::getBean('te_ba_Batch', $batchId);
    $batchCode = $batchBean->batch_code;


    $vendor_query = "SELECT
    leads.id,
    leads.vendor,
    leads.phone_mobile,
    leads_cstm.email_add_c,
    leads.status,
    leads.status_description,
    te_ba_batch.batch_code

    FROM leads
    LEFT JOIN users ON leads.assigned_user_id =users.id
    INNER JOIN leads_cstm ON leads.id= leads_cstm.id_c
    INNER JOIN te_ba_batch ON leads_cstm.te_ba_batch_id_c= te_ba_batch.id
    where leads.deleted=0  and te_ba_batch.deleted=0
    AND te_ba_batch.batch_code='".$batchCode."'
    AND ( leads.phone_mobile = '".$phone_mobile."'
    OR leads_cstm.email_add_c='".$email_add_c."' )
    order by leads.date_entered ASC limit 1";
    // echo $vendor_query;
    $vendor_rel = $GLOBALS['db']->query($vendor_query);
    // print_r($vendor_rel);
    // $vendor_res  = $GLOBALS['db']->fetchByAssoc($vendor_rel);
    // print_r($vendor_res);die();
    if ($GLOBALS['db']->getRowCount($vendor_rel) > 0)
    {
        $vendor_res  = $GLOBALS['db']->fetchByAssoc($vendor_rel);
         // print_r($vendor_res);die();
        $primary_vendor = $vendor_res['vendor'];
        // $primary_vendor
        // $leadBean = BeanFactory::getBean('Lead', $beanId);
        // print_r($leadBean); die();
        // $bean->primary_vendor = $primary_vendor;
        // echo $bean->primary_vendor;
        // $bean->save();
        // if($save_var){ echo 'test'; print_r($save_var); die(); }
        $s = "UPDATE leads SET primary_vendor='".$primary_vendor."' WHERE id='" . $bean->id . "'";
        $GLOBALS['db']->query($s);
    }
    if(!empty($bean->batch) && !empty($bean->id)){
	$this->find_batch_by_batchCode($bean->batch,$bean->id);
    }
  }
  function find_batch_by_batchCode($batch_code=NULL,$lead_id=NULL){
	$batch_query = "SELECT id from te_ba_batch WHERE batch_code='".$batch_code."'";
	$batch_res = $GLOBALS['db']->query($batch_query);
	if ($GLOBALS['db']->getRowCount($batch_res) > 0){
		$batch  = $GLOBALS['db']->fetchByAssoc($batch_res);
		$s = "UPDATE leads_cstm SET te_ba_batch_id_c='".$batch['id']."' WHERE id_c='" . $lead_id . "'";
		//echo $s;exit();
        	$GLOBALS['db']->query($s);
	}
  }
}

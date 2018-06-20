<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class individualIdClass
{

  function add_individual_id($bean, $event, $argument)
  {
    $lead_email = $bean->email_add_c;
    $lead_id = $bean->id;
    $same_batch = 'Same Course Return';
    $diff_batch = 'Different Course Return';
    $fresh_status = 'Fresh';
    $repeated_status = 'Repeated';

    if(!empty($lead_email)){
      $sqlRel = "SELECT l.id,lc.te_ba_batch_id_c,l.date_entered,lc.email_add_c,lc.individual_id_c FROM leads l INNER JOIN leads_cstm lc ON l.id=lc.id_c AND l.deleted=0 WHERE l.id!='" . $lead_id . "' AND lc.email_add_c='" . $lead_email . "' ORDER BY l.date_entered ASC LIMIT 0,1 ";
      $rel    = $GLOBALS['db']->query($sqlRel);
      $ind_id = '';
      if ($GLOBALS['db']->getRowCount($rel) > 0)
      {
          $res_sql    = $GLOBALS['db']->fetchByAssoc($rel);
          if(!empty($res_sql['individual_id_c'])){
            $ind_id = $res_sql['individual_id_c'];  
          }
          else{
            $ind_id = time();
            $enq_batch = "Fresh";
            $s = "UPDATE leads_cstm SET individual_id_c='".$ind_id."',individual_idbatchstatus_c='".$enq_batch."',individual_idstatus_c='".$fresh_status."' WHERE id_c='" . $res_sql['id'] . "'";
            $GLOBALS['db']->query($s);
          }
          

          if($res_sql['te_ba_batch_id_c']!=$bean->te_ba_batch_id_c){
            $enq_batch = $diff_batch;
          }
          else{
            $enq_batch = $same_batch;
          }

          $s = "UPDATE leads_cstm SET individual_id_c='".$ind_id."',individual_idbatchstatus_c='".$enq_batch."',individual_idstatus_c='".$repeated_status."' WHERE id_c='" . $bean->id . "'";
          $GLOBALS['db']->query($s);
      }
      else
      {
          $enq_batch = "Fresh";

          $ind_id = base64_encode($bean->id);
          $s = "UPDATE leads_cstm SET individual_id_c='".$ind_id."',individual_idbatchstatus_c='".$enq_batch."',individual_idstatus_c='".$fresh_status."' WHERE id_c='" . $bean->id . "'";
          $GLOBALS['db']->query($s);
      }
    }
  }

}

<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class individualIdClass
{

  function add_individual_id($bean, $event, $argument)
  {
    $lead_email = $bean->email_add_c;
    $lead_id = $bean->id;
    $same_batch = 'Enquired for same batch';
    $diff_batch = 'Enquired for different batch';
    $fresh_status = 'Fresh';
    $repeated_status = 'Repeated';

    if(!empty($lead_email)){
      $sqlRel = "SELECT l.id,lc.te_ba_batch_id_c,l.date_entered,lc.email_add_c FROM leads l INNER JOIN leads_cstm lc ON l.id=lc.id_c AND l.delete=0 WHERE l.id!='" . $lead_id . "' AND lc.email_add_c!='" . $lead_email . "' ORDER BY l.date_entered ASC LIMIT 0,1 ";
      $rel    = $GLOBALS['db']->query($sqlRel);
      $ind_id = '';
      if ($GLOBALS['db']->getRowCount($rel) > 0)
      {
          $res_sql    = $GLOBALS['db']->fetchByAssoc($rel);
          $ind_id = base64_encode($res_sql['id']);

          if($res_sql['te_ba_batch_id_c']!=$bean->te_ba_batch_id_c){
            $enq_batch = $diff_batch;
          }
          else{
            $enq_batch = $same_batch;
          }

          $s = "UPDATE leads_cstm SET individual_id_c='".$ind_id."',individual_idbatch_c='".$enq_batch."',individual_idtype_c='".$repeated_status."' WHERE id_c='" . $bean->id . "'";
          $GLOBALS['db']->query($s);
      }
      else
      {
          $enq_batch = "Fresh";

          $ind_id = base64_encode($bean->id);
          $s = "UPDATE leads_cstm SET individual_id_c='".$ind_id."',individual_idbatch_c='".$enq_batch."',individual_idtype_c='".$fresh_status."' WHERE id_c='" . $bean->id . "'";
          $GLOBALS['db']->query($s);
      }
    }
  }

}

<?php
  /**
   * Created by PhpStorm.
   * User: sadaka
   * Date: 06/09/18
   * Time: 4:15 PM
   */

  class leadsUtility{
    var $selected_batch_ids        =array();
    var $selected_councellors       =array();
    var $selected_lead_source_types =array();
    var $attempts                   =array();
    var $fromDate                   ='';
    var $toDate                     ='';
    var $turnAroundTime = 1440;
    private  $sqlPart = '';

    function __construct($selected_batch_ids=array(),$selected_councellors=array(),$selected_lead_source_types=array(), $fromDate='', $toDate=''){
      $this->selected_batch_ids = $selected_batch_ids;
      $this->selected_councellors = $selected_councellors;
      $this->selected_lead_source_types = $selected_lead_source_types;

      if (!empty($this->selected_councellors)) {
        $this ->sqlPart .= " AND  assigned_user_id IN ('" . implode("','", $this->selected_councellors) . "')";
      }

      if (!empty($this->selected_lead_source_types)) {
        $this ->sqlPart .= " AND  lead_source_types IN ('" . implode("','", $this->selected_lead_source_types) . "')";
      }

      if(!empty($this->selected_batch_ids)){
        $this ->sqlPart .= " AND batch_id IN ('" . implode("','", $this->selected_batch_ids) . "')";
      }

      $this->fromDate = $fromDate;
      $this->toDate = $toDate;
    }

    public function setTurnArountTime($tat=1440){
      $this->turnAroundTime = $tat;
    }


    public function getAttempts($isReturnLeads=false, $show='fresh_leads'){

//      global $db;
      $objBenchmarking = new benchmarking();
      $objBenchmarking->start('Attempts');
   /*
      $and = '';
      if (!empty($this->selected_councellors)) {

        $and .= " AND  assigned_user_id IN ('" . implode("','", $this->selected_councellors) . "')";
      }
      if (!empty($this->selected_lead_source_types)) {
        $and .= " AND  lead_source_types IN ('" . implode("','", $this->selected_lead_source_types) . "')";
      }
      if(!empty($this->selected_batch_code)){
        $and .= " AND batch_id IN ('" . implode("','", $this->selected_batch_code) . "')";
      }

      $leadSql = "SELECT 
                  batch_code,
                  batch_id,
			            id as lead_id,
                  date_entered,
 		              attempts as attempts_c,
			            disposition_date as dispo_date,
				          disposition_status as status,
				          disposition_status_detail as status_detail,
				          status_description
                FROM (select batch_code,
                  batch_id,
			            id,
                  date_entered,
 		              attempts,
			            disposition_date,
				          disposition_status,
				          disposition_status_detail, status_description, deleted from report_leads
                
                group by id 
                ) as tmp
                
                WHERE 
                  date_entered >= '" . $fromDate . " 00:00:00'
                  AND date_entered <= '" . $toDate . " 23:59:59'                  
                  AND deleted=0 
 
                  $and
                order by batch_code, dispo_date ";

      $leadSql = "
        SELECT
          batch_code,
          batch_id,
          id                        AS lead_id,
          date_entered,
          attempts                  AS attempts_c,
          disposition_date          AS dispo_date,
          disposition_status        AS status,
          disposition_status_detail AS status_detail,
          status_description,
          assigned_user_id,
          disposition_attempt_count,
          TIMESTAMPDIFF(minute, date_entered, disposition_date) as diff,
          deleted
        FROM report_leads leads1 inner join (
            select min(disposition_date) as dispo_date, id as lid, status_description as sd, disposition_status_detail AS sd1 from report_leads
            WHERE 
              date_entered >= '" . $fromDate . " 00:00:00'
              AND date_entered <= '" . $toDate . " 23:59:59' and
              deleted = 0 
              #and disposition_attempt_count != ''
              #and attempts != ''
              $and
            group by lid
          ) leads2
          on leads1.id = leads2.lid and (leads1.disposition_date = leads2.dispo_date or (isnull(leads1.disposition_date) and isnull(leads2.dispo_date)))
          
      ";
      #WHERE TIMESTAMPDIFF(minute, leads1.date_entered, leads1.disposition_date) > 1440 and leads1.attempts != ''
//    echo $leadSql;
      $this->getLeads1to3($fromDate, $toDate);
      $leadObj = $db->query($leadSql);

      $attemplist = $tt = array();

      $status_description = array('New Lead' => 1,'Follow Up' => 1,'Prospect' => 1);
      $freshLeads = array();
      while ($row = $db->fetchByAssoc($leadObj)) {
        $mintsdiff = round(abs((strtotime($row['date_entered']) - strtotime($row['dispo_date']))) / 60);


        if ($row['attempts_c'] == '' && isset($status_description[$row['status_description']])) {

          if($isReturnLeads && $show == 'fresh_leads'){
            $freshLeads[$row['lead_id']] = 1;

          }else{
            if(!isset($freshLeads[$row['batch_id']])) $freshLeads[$row['batch_id']] = 0;
            $freshLeads[$row['batch_id']] = $freshLeads[$row['batch_id']] + 1;
          }
          continue;
        }
        if ($row['attempts_c'] >= 1 && $row['attempts_c'] <= 3 && $row['assigned_user_id'] != '') {
          if($isReturnLeads && $show == 'leads_attempted_1_3'){
            $attemplist[$row['lead_id']] = 1;
          }else{

            if(!isset($attemplist[$row['batch_id']]['leads_attempted_1_3'])) $attemplist[$row['batch_id']]['leads_attempted_1_3'] = 0;
            $attemplist[$row['batch_id']]['leads_attempted_1_3'] = $attemplist[$row['batch_id']]['leads_attempted_1_3'] + 1;
          }

        }
        else if ($row['attempts_c'] >= 4 && $row['attempts_c'] <= 6  && $row['assigned_user_id'] != '') {
          if($isReturnLeads && $show == 'leads_attempted_4_6'){
            $attemplist[$row['lead_id']] = 1;
          }else {
            $tt[$row['batch_id']][] = $row;
            if (!isset($attemplist[$row['batch_id']]['leads_attempted_4_6'])) $attemplist[$row['batch_id']]['leads_attempted_4_6'] = 0;
            $attemplist[$row['batch_id']]['leads_attempted_4_6'] = $attemplist[$row['batch_id']]['leads_attempted_4_6'] + 1;
          }
        }
        else if ($row['attempts_c'] > 6) {
          if($isReturnLeads && $show == 'leads_attempted_more_than_6'  && $row['assigned_user_id'] != ''){
            $attemplist[$row['lead_id']] = 1;
          }else {
            if (!isset($attemplist[$row['batch_id']]['leads_attempted_more_than_6'])) $attemplist[$row['batch_id']]['leads_attempted_more_than_6'] = 0;
            $attemplist[$row['batch_id']]['leads_attempted_more_than_6'] = $attemplist[$row['batch_id']]['leads_attempted_more_than_6'] + 1;
          }
        }

        if ($mintsdiff > 1440 && $row['attempts_c'] != '') {
          if($isReturnLeads && $show == 'leads_dialled_outside_TAT'){
            $attemplist[$row['lead_id']] = 1;
          }else {
            if (!isset($attemplist[$row['batch_id']]['leads_dialled_outside_TAT'])) $attemplist[$row['batch_id']]['leads_dialled_outside_TAT'] = 0;
            $attemplist[$row['batch_id']]['leads_dialled_outside_TAT'] = $attemplist[$row['batch_id']]['leads_dialled_outside_TAT'] + 1;
          }
        }
      }
*/


      $attemptList = array();
      $fromDate = $this->fromDate;
      $toDate = $this->toDate;
      if($isReturnLeads){
        if($show == 'fresh_leads') $attemptList = $this->getFreshLeads($fromDate, $toDate, $isReturnLeads);
        if($show == 'leads_attempted_1_3') $attemptList = $this->getLeads1to3($fromDate, $toDate, $isReturnLeads);
        if($show == 'leads_attempted_4_6') $attemptList = $this->getLeads4to6($fromDate, $toDate, $isReturnLeads);
        if($show == 'leads_attempted_more_than_6') $attemptList = $this->getLeads6to($fromDate, $toDate, $isReturnLeads);
        if($show == 'leads_dialled_outside_TAT') $attemptList = $this->getTATLeads($fromDate, $toDate, $isReturnLeads);
      }else{
        $leadsFresh = $this->getFreshLeads($fromDate, $toDate, $isReturnLeads);
        $leadsTAT = $this->getTATLeads($fromDate, $toDate, $isReturnLeads);
        $leads1to3 = $this->getLeads1to3($fromDate, $toDate, $isReturnLeads);
        $leads4to6 = $this->getLeads4to6($fromDate, $toDate, $isReturnLeads);
        $leads6to = $this->getLeads6to($fromDate, $toDate, $isReturnLeads);
        foreach($this->selected_batch_ids as $batch_id){
          $attemptList[$batch_id]['leads_dialled_outside_TAT'] = isset($leadsTAT[$batch_id])?$leadsTAT[$batch_id]:0;
          $attemptList[$batch_id]['leads_attempted_1_3'] = isset($leads1to3[$batch_id])?$leads1to3[$batch_id]:0;
          $attemptList[$batch_id]['leads_attempted_4_6'] = isset($leads4to6[$batch_id])?$leads4to6[$batch_id]:0;
          $attemptList[$batch_id]['leads_attempted_more_than_6'] = isset($leads6to[$batch_id])?$leads6to[$batch_id]:0;
        }
      }

//      $objBenchmarking->end('Attempts');
      return array('attempts' => $attemptList, 'freshLeads' => $leadsFresh);
    }

    public function getTATLeads($fromDate, $toDate, $returnLeads = false){
      global  $db;

      $sqlCount = ' count(id) as leads_count ';
      if($returnLeads){
        $sqlCount = ' id ';
      }
      $sql = "
            SELECT
              batch_id,
              $sqlCount
            FROM report_leads leads1 INNER JOIN (
              SELECT
                 min(disposition_date)     AS dispo_date,
                 id                        AS lid,
                 status_description        AS sd,
                 disposition_status_detail AS sd1
               FROM report_leads
               WHERE
                 date_entered between '$fromDate 00:00:00' AND '$toDate 23:59:59'
                 AND deleted = 0 
                 AND disposition_attempt_count != '' 
                 and TIMESTAMPDIFF(MINUTE, date_entered, disposition_date) > {$this->turnAroundTime}
                 {$this->sqlPart}
               GROUP BY lid) leads2 
               ON leads1.id = leads2.lid AND
                                       (leads1.disposition_date = leads2.dispo_date OR
                                        (isnull(leads1.disposition_date) AND
                                         isnull(leads2.dispo_date)))
               where attempts != ''                                                                      
      ";
      if(!$returnLeads)
        $sql .= " GROUP by batch_code  ";
//      echo $sql;

      $objBenchmarking = new benchmarking();
      $objBenchmarking -> start('TAT');
      $objSql = $db->query($sql);
      $return = array();
      while ($row = $db->fetchByAssoc($objSql)) {
        if($returnLeads){
          $return[$row['id']] = 1;
        }else{
          $return[$row['batch_id']] = $row['leads_count'];
        }
      }
      $objBenchmarking->end('TAT');
      return $return;
    }

    public function getFreshLeads($fromDate, $toDate, $returnLeads = false){
      global  $db;

      $sqlCount = ' count(id) as leads_count ';
      if($returnLeads){
        $sqlCount = ' id ';
      }

      $sql = "
        SELECT 
          $sqlCount, 
          batch_code, 
          batch_id
        FROM (SELECT id, batch_code, batch_id
              FROM report_leads
              WHERE 
              attempts = ''
              AND status_description IN ('New Lead', 'Follow Up', 'Prospect')
              and deleted = 0
              and date_entered between '$fromDate 00:00:00' AND '$toDate 23:59:59'
              {$this->sqlPart}
              GROUP BY id
      ) AS tmp 
      ";
      if(!$returnLeads)
        $sql .= " GROUP by batch_code  ";

//      echo $sql;

      $objBenchmarking = new benchmarking();
      $objBenchmarking -> start('fresh');
      $objSql = $db->query($sql);
      $return = array();
      while ($row = $db->fetchByAssoc($objSql)) {
        if($returnLeads){
          $return[$row['id']] = 1;
        }else{
          $return[$row['batch_id']] = $row['leads_count'];
        }
      }
      $objBenchmarking->end('fresh');
      return $return;
    }

    public function getLeads1to3($fromDate, $toDate, $returnLeads = false){
      global  $db;
      if(!empty($this->attempts)){
        $attempts = $this->attempts;
      }else{
        $attempts = $this->calculateAttempts($fromDate,$toDate,$returnLeads);
      }
      return $attempts['1to3'];
      /*
      $sqlCount = ' count(id) as leads_count ';
      if($returnLeads){
        $sqlCount = ' id ';
      }

      $sql = "
        SELECT 
          $sqlCount, 
          batch_code, 
          batch_id
        FROM (SELECT id, batch_code, batch_id
              FROM report_leads
              WHERE 
              deleted = 0
              and attempts != ''
              and date_entered between '$fromDate 00:00:00' AND '$toDate 23:59:59'
              and attempts between 1 and 3
              and assigned_user_id != ''
              {$this->sqlPart}
              GROUP BY id
      ) AS tmp 
      ";
      if(!$returnLeads)
        $sql .= " GROUP by batch_code  ";

      $objBenchmarking = new benchmarking();
      $objBenchmarking -> start('1to3');
//      echo $sql;

      $objSql = $db->query($sql);
      $return = array();
      while ($row = $db->fetchByAssoc($objSql)) {
        if($returnLeads){
          $return[$row['id']] = 1;
        }else{
          $return[$row['batch_id']] = $row['leads_count'];
        }
      }*/
      $objBenchmarking->end('1to3');
      return $return;
    }

    public function getLeads4to6($fromDate, $toDate, $returnLeads = false){
      global  $db;

      if(!empty($this->attempts)){
        $attempts = $this->attempts;
      }else{
        $attempts = $this->calculateAttempts($fromDate,$toDate,$returnLeads);
      }
      return $attempts['4to6'];

      /*$sqlCount = ' count(id) as leads_count ';
      if($returnLeads){
        $sqlCount = ' id ';
      }

      $sql = "
        SELECT 
          $sqlCount, 
          batch_code, 
          batch_id
        FROM (SELECT id, batch_code, batch_id
              FROM report_leads
              WHERE 
              deleted = 0
              and attempts != ''
              and date_entered between '$fromDate 00:00:00' AND '$toDate 23:59:59'
              and attempts between 4 and 6
              and assigned_user_id != ''
              {$this->sqlPart}
              GROUP BY id
      ) AS tmp 
      ";
      if(!$returnLeads)
        $sql .= " GROUP by batch_code  ";

//      echo $sql;
      $objBenchmarking = new benchmarking();
      $objBenchmarking -> start('4to6');
      $objSql = $db->query($sql);
      $return = array();
      while ($row = $db->fetchByAssoc($objSql)) {
        if($returnLeads){
          $return[$row['id']] = 1;
        }else{
          $return[$row['batch_id']] = $row['leads_count'];
        }
      }
      $objBenchmarking->end('4to6');
      return $return;*/
    }

    public function getLeads6to($fromDate, $toDate, $returnLeads = false){
      global  $db;
      if(!empty($this->attempts)){
        $attempts = $this->attempts;
      }else{
        $attempts = $this->calculateAttempts($fromDate,$toDate,$returnLeads);
      }
      return $attempts['6to'];
      /*
      $sqlCount = ' count(id) as leads_count ';
      if($returnLeads){
        $sqlCount = ' id ';
      }

      $sql = "
        SELECT 
          $sqlCount, 
          batch_code, 
          batch_id
        FROM (SELECT id, batch_code, batch_id
              FROM report_leads
              WHERE 
              deleted = 0
              and attempts != ''
              and date_entered between '$fromDate 00:00:00' AND '$toDate 23:59:59'
              and attempts >6
              and assigned_user_id != ''
              {$this->sqlPart}
              GROUP BY id
      ) AS tmp 
      ";
      if(!$returnLeads)
        $sql .= " GROUP by batch_code  ";

//      echo $sql;
      $objBenchmarking = new benchmarking();
      $objBenchmarking -> start('6to');
      $objSql = $db->query($sql);
      $return = array();
      while ($row = $db->fetchByAssoc($objSql)) {
        if($returnLeads){
          $return[$row['id']] = 1;
        }else{
          $return[$row['batch_id']] = $row['leads_count'];
        }
      }
      $objBenchmarking->end('6to');
      return $return;*/
    }

    public function updateLeads($leadId){
      global $db;
      $sql = "delete from report_leads where id = '$leadId'";

      $leadObj = $db->query($sql);

      $sqlUpdate = "
        insert into report_leads
        select
            leads.id as id,
            leads.invoice_number,
            leads.assigned_user_id,
            leads.date_entered,
            leads.lead_source,
            leads.lead_source_description,
            leads.lead_source_types,
            leads.deleted,
            leads.status,
            leads.status_description,
            leads.date_modified,
            leads.converted_date,
            leads.date_of_followup,
            leads.date_of_prospect,
            leads_cstm.attempts_c,
            leads.autoassign,
            leads.vendor,
            leads.dristi_campagain_id,
            leads.dristi_API_id,
            leads.neoxstatus,
            users.first_name AS user_first_name,
            users.last_name  AS user_last_name,
            dis.status as disposition_status,
            dis.status_detail as disposition_status_detail,
            dis.date_entered as disposition_date,
            leads_cstm.attempts_c as attempts,
            dis.attempt_count as disposition_attempt_count,
            leads_cstm.temp_lead_date_c,
            te_ba_batch.batch_code AS batch_code,
            te_ba_batch.id AS batch_id,
            te_ba_batch.name AS batch_name,
            te_ba_batch.batch_status   AS batch_status,
            leads.utm_contract_c,
            leads.utm_source_c,
            leads.utm_term_c,
            leads.utm_campaign,
            CONCAT(
                if(te_ba_batch.id IS NULL, 'NA', te_ba_batch.id), '_UR_',
                if(utm_source_c IS NULL, 'NA', utm_source_c), '_UR_',
                if(utm_contract_c IS NULL, 'NA', utm_contract_c), '_UR_',
                if(utm_term_c IS NULL, 'NA', utm_term_c), '_UR_',
                if(utm_campaign IS NULL, 'NA', utm_campaign)
            ) AS utm_key
        
          FROM leads
            LEFT JOIN users ON leads.assigned_user_id = users.id and users.deleted = 0
            left JOIN leads_cstm ON leads.id = leads_cstm.id_c
            left JOIN te_ba_batch ON leads_cstm.te_ba_batch_id_c = te_ba_batch.id and te_ba_batch.deleted=0
            left join te_disposition_leads_c disrel on disrel.te_disposition_leadsleads_ida=leads.id and disrel.deleted=0
            left join te_disposition dis on disrel.te_disposition_leadste_disposition_idb=dis.id and dis.deleted=0
          where leads.id='$leadId'"; 
      $leadObj = $db->query($sqlUpdate);
    }

    private function calculateAttempts($fromDate, $toDate, $returnLeads=false){
      global  $db;
      $sqlCount = ' count(id) as leads_count ';
      if($returnLeads){
        $sqlCount = ' id ';
      }

      $sql = "
        SELECT 
          $sqlCount, 
          batch_code, 
          batch_id,
          attempts
        FROM (SELECT id, batch_code, batch_id, attempts
              FROM report_leads
              WHERE 
              deleted = 0
              and attempts != ''
              and date_entered between '$fromDate 00:00:00' AND '$toDate 23:59:59'
              and assigned_user_id != ''
              {$this->sqlPart}
              GROUP BY id
      ) AS tmp 
      ";
      if(!$returnLeads)
        $sql .= " GROUP by batch_code, attempts  ";

//      echo $sql;
      $objBenchmarking = new benchmarking();
      $objBenchmarking -> start('global');
      $objSql = $db->query($sql);
      $return = array();
      while ($row = $db->fetchByAssoc($objSql)) {
        if($this->between($row['attempts'], 1,3)) {
          if ($returnLeads) {
            $return['1to3'][$row['id']] = 1;
          } else {
            if (!isset($return['1to3'][$row['batch_id']])) $return['1to3'][$row['batch_id']]=0;
            $return['1to3'][$row['batch_id']] += $row['leads_count'];
          }
        }elseif($this->between($row['attempts'], 4,6)) {
          if ($returnLeads) {
            $return['4to6'][$row['id']] = 1;
          } else {
            if(!isset($return['4to6'][$row['batch_id']])) $return['4to6'][$row['batch_id']] = 0;
            $return['4to6'][$row['batch_id']] += $row['leads_count'];
          }
        }if($this->between($row['attempts'], 6)) {
          if ($returnLeads) {
            $return['6to'][$row['id']] = 1;
          } else {
            if(!isset($return['6to'][$row['batch_id']])) $return['6to'][$row['batch_id']] = 0;
            $return['6to'][$row['batch_id']] += $row['leads_count'];
          }
        }
      }
      $objBenchmarking->end('global');
      $this->attempts = $return;
      return $return;
    }

    private function between($num,$from,$to=null){
      return is_null($to)?$num > $from:$num >= $from && $num <=$to;
    }

  }

  class benchmarking {
    var $memoryStart = array();
    var $timeStart = array();
    public function start($tag='resources'){
      $this -> memoryStart[$tag] = memory_get_peak_usage();
      $this -> timeStart[$tag] = microtime(true); // Start the timer
    }

    public function end($tag='resources'){
      if(!isset($this->memoryStart[$tag])) return "";
      $end_time = microtime(true);  // Stop the timer
      $end_mem = memory_get_peak_usage();

      $total_time = round($end_time - $this->timeStart[$tag], 2);
      $total_mem = $end_mem - $this->memoryStart[$tag];
      $total_mem = round($total_mem/1024/1024, 2);
      unset($this->timeStart[$tag]);
      unset($this->memoryStart[$tag]);
      echo "<br/>Resources consumed in $tag : $total_time sec,  $total_mem MB\n";
      return;
    }
  }



  /*


    function getFresh2($selected_batch_code,$selected_councellors,$selected_lead_source_types)
  {
    global $db;
    $leadList = array();
    $base_mem = memory_get_peak_usage();
    $start_time = microtime(true); // Start the timer

    $and='';
    if(!empty($selected_councellors)){
      $and .= " AND  assigned_user_id IN ('" . implode("','", $selected_councellors) . "')";
    }

    if (!empty($selected_lead_source_types)){
      $and .= " AND  lead_source_types IN ('" . implode("','", $selected_lead_source_types) . "')";
    }

    $leadSql = "SELECT
                  COUNT(id) AS fresh_lead_count,
                  batch_id
                FROM
                  (select batch_id, batch_code, id from report_leads
                    WHERE
                      date_entered >= '" . $fromDate . " 00:00:00'
                      AND date_entered <= '" . $toDate . " 23:59:59'
                      and status_description in ('New Lead','Follow Up','Prospect')
                      and deleted=0
                      and attempts=''
                      $and
                    group by id)
                  as tmp
                GROUP  by  batch_code";

    $leadObj = $db->query($leadSql) or die(mysqli_error());

    while ($row = $db->fetchByAssoc($leadObj))
    {
      $leadList[$row['batch_id']] = $row['fresh_lead_count'];
    }

    $end_time = microtime(true);  // Stop the timer
    $extra_mem = memory_get_peak_usage();

// figure out the totals
    $total_time = $end_time - $start_time;
    $total_mem = $extra_mem - $base_mem;

    echo "<br/>Total Mem Above Basline in Fresh Count: $total_time sec,  $total_mem bytes\n";

    return $leadList;
  }


  function getAttempts2($selected_batch_code,$selected_councellors,$selected_lead_source_types)
  {

    global $db;
    //$leadList   = array();
    $attemplist = array();

    $base_mem = memory_get_peak_usage();
    $start_time = microtime(true); // Start the timer


    $and = '';
    if (!empty($selected_councellors)) {

      $and .= " AND  assigned_user_id IN ('" . implode("','", $selected_councellors) . "')";
    }
    if (!empty($selected_lead_source_types)) {
      $and .= " AND  lead_source_types IN ('" . implode("','", $selected_lead_source_types) . "')";
    }


    $leadSql = "SELECT
                  batch_code,
                  batch_id,
			            id as lead_id,
                  date_entered,
 		              attempts as attempts_c,
			            disposition_date as dispo_date,
				          disposition_status as status,
				          disposition_status_detail as status_detail,
				          status_description
                FROM report_leads
                WHERE
                  date_entered >= '" . $fromDate . " 00:00:00'
                  AND date_entered <= '" . $toDate . " 23:59:59'
                  AND deleted=0

                  $and
                group by id
                order by batch_code, dispo_date ";


//    echo $leadSql;
    $leadObj = $db->query($leadSql);

    $attemplist = array();

    $status_description = array('New Lead' => 1,'Follow Up' => 1,'Prospect' => 1);
    while ($row = $db->fetchByAssoc($leadObj)) {
        $mintsdiff = round(abs((strtotime($row['date_entered']) - strtotime($row['dispo_date']))) / 60);

        if ($row['attempts_c'] == '' && isset($status_description[$row['status_description']])) {
            if(!isset($attemplist['fresh_leads'][$row['batch_id']])) $attemplist['fresh_leads'][$row['batch_id']] = 0;
          $attemplist['fresh_leads'][$row['batch_id']] = $attemplist['fresh_leads'][$row['batch_id']] + 1;
        }
        if ($row['attempts_c'] >= 1 && $row['attempts_c'] <= 3) {
          if(!isset($attemplist[$row['batch_id']]['leads_attempted_1_3'])) $attemplist[$row['batch_id']]['leads_attempted_1_3'] = 0;
          $attemplist[$row['batch_id']]['leads_attempted_1_3'] = $attemplist[$row['batch_id']]['leads_attempted_1_3'] + 1;
        }
        else if ($row['attempts_c'] >= 4 && $row['attempts_c'] <= 6) {
          if(!isset($attemplist[$row['batch_id']]['leads_attempted_4_6'])) $attemplist[$row['batch_id']]['leads_attempted_4_6'] = 0;
          $attemplist[$row['batch_id']]['leads_attempted_4_6'] = $attemplist[$row['batch_id']]['leads_attempted_4_6'] + 1;
        }
        else if ($row['attempts_c'] > 6) {
          if(!isset($attemplist[$row['batch_id']]['leads_attempted_more_than_6'])) $attemplist[$row['batch_id']]['leads_attempted_more_than_6'] = 0;
          $attemplist[$row['batch_id']]['leads_attempted_more_than_6'] = $attemplist[$row['batch_id']]['leads_attempted_more_than_6'] + 1;
        }

        if ($mintsdiff > 1440 && $row['attempts_c'] != '') {
          if(!isset($attemplist[$row['batch_id']]['leads_dialled_outside_TAT'])) $attemplist[$row['batch_id']]['leads_dialled_outside_TAT'] = 0;
          $attemplist[$row['batch_id']]['leads_dialled_outside_TAT'] = $attemplist[$row['batch_id']]['leads_dialled_outside_TAT'] +1;
        }
    }

    $end_time = microtime(true);  // Stop the timer
    $extra_mem = memory_get_peak_usage();

// figure out the totals
    $total_time = $end_time - $start_time;
    $total_mem = $extra_mem - $base_mem;

    echo "<br/>Total Mem Above Basline: $total_time sec,  $total_mem bytes\n";

//    echo '<pre>';
//    print_r($attemplist);

    return $attemplist;
  }


   * */

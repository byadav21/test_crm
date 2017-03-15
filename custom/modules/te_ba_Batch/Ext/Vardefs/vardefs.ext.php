<?php 
 //WARNING: The contents of this file are auto-generated


 // created: 2016-10-28 00:43:07
$dictionary['te_ba_Batch']['fields']['name']['inline_edit']=true;
$dictionary['te_ba_Batch']['fields']['name']['duplicate_merge']='disabled';
$dictionary['te_ba_Batch']['fields']['name']['duplicate_merge_dom_value']='0';
$dictionary['te_ba_Batch']['fields']['name']['merge_filter']='disabled';
$dictionary['te_ba_Batch']['fields']['name']['unified_search']=false;

 

// created: 2016-09-05 07:25:52
$dictionary["te_ba_Batch"]["fields"]["te_pr_programs_te_ba_batch_1"] = array (
  'name' => 'te_pr_programs_te_ba_batch_1',
  'type' => 'link',
  'required' => true,
  'relationship' => 'te_pr_programs_te_ba_batch_1',
  'source' => 'non-db',
  'module' => 'te_pr_Programs',
  'bean_name' => 'te_pr_Programs',
  'vname' => 'LBL_TE_PR_PROGRAMS_TE_BA_BATCH_1_FROM_TE_PR_PROGRAMS_TITLE',
  'id_name' => 'te_pr_programs_te_ba_batch_1te_pr_programs_ida',
);
$dictionary["te_ba_Batch"]["fields"]["te_pr_programs_te_ba_batch_1_name"] = array (
  'name' => 'te_pr_programs_te_ba_batch_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_TE_PR_PROGRAMS_TE_BA_BATCH_1_FROM_TE_PR_PROGRAMS_TITLE',
  'save' => true,
  'required' => true,
  'id_name' => 'te_pr_programs_te_ba_batch_1te_pr_programs_ida',
  'link' => 'te_pr_programs_te_ba_batch_1',
  'table' => 'te_pr_programs',
  'module' => 'te_pr_Programs',
  'rname' => 'name',
);
$dictionary["te_ba_Batch"]["fields"]["te_pr_programs_te_ba_batch_1te_pr_programs_ida"] = array (
  'name' => 'te_pr_programs_te_ba_batch_1te_pr_programs_ida',
  'type' => 'link',
  'relationship' => 'te_pr_programs_te_ba_batch_1',
  'source' => 'non-db',
   'required' => true,
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_TE_PR_PROGRAMS_TE_BA_BATCH_1_FROM_TE_BA_BATCH_TITLE',
);


 // created: 2016-10-05 08:01:34
$dictionary['te_ba_Batch']['fields']['enrolled_students_c']['inline_edit']='1';
$dictionary['te_ba_Batch']['fields']['enrolled_students_c']['labelValue']='Enrolled Students';

 

 // created: 2016-09-09 01:39:04
$dictionary['te_ba_Batch']['fields']['class_schedule_c']['inline_edit']='1';
$dictionary['te_ba_Batch']['fields']['class_schedule_c']['labelValue']='class schedule';

 

 // created: 2016-10-28 01:32:11
$dictionary['te_ba_Batch']['fields']['description']['inline_edit']=true;
$dictionary['te_ba_Batch']['fields']['description']['comments']='Full text of the note';
$dictionary['te_ba_Batch']['fields']['description']['merge_filter']='disabled';
$dictionary['te_ba_Batch']['fields']['description']['cols']='103';

 

// created: 2016-09-14 20:35:29
$dictionary["te_ba_Batch"]["fields"]["te_ba_batch_te_installments_1"] = array (
  'name' => 'te_ba_batch_te_installments_1',
  'type' => 'link',
  'relationship' => 'te_ba_batch_te_installments_1',
  'source' => 'non-db',
  'module' => 'te_installments',
  'bean_name' => 'te_installments',
  'side' => 'right',
  'vname' => 'LBL_TE_BA_BATCH_TE_INSTALLMENTS_1_FROM_TE_INSTALLMENTS_TITLE',
);


 // created: 2016-10-28 00:59:47
$dictionary['te_ba_Batch']['fields']['minimum_batch_size_c']['inline_edit']='1';
$dictionary['te_ba_Batch']['fields']['minimum_batch_size_c']['labelValue']='Minimum Batch Size';

 

// created: 2016-09-05 07:18:48
$dictionary["te_ba_Batch"]["fields"]["te_in_institutes_te_ba_batch_1"] = array (
  'name' => 'te_in_institutes_te_ba_batch_1',
  'type' => 'link',
   'required'=>true,
  'relationship' => 'te_in_institutes_te_ba_batch_1',
  'source' => 'non-db',
  'module' => 'te_in_institutes',
  'bean_name' => 'te_in_institutes',
  'vname' => 'LBL_TE_IN_INSTITUTES_TE_BA_BATCH_1_FROM_TE_IN_INSTITUTES_TITLE',
  'id_name' => 'te_in_institutes_te_ba_batch_1te_in_institutes_ida',
);
$dictionary["te_ba_Batch"]["fields"]["te_in_institutes_te_ba_batch_1_name"] = array (
  'name' => 'te_in_institutes_te_ba_batch_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_TE_IN_INSTITUTES_TE_BA_BATCH_1_FROM_TE_IN_INSTITUTES_TITLE',
  'save' => true,
  'required'=>true,
  'id_name' => 'te_in_institutes_te_ba_batch_1te_in_institutes_ida',
  'link' => 'te_in_institutes_te_ba_batch_1',
  'table' => 'te_in_institutes',
  'module' => 'te_in_institutes',
  'rname' => 'name',
);
$dictionary["te_ba_Batch"]["fields"]["te_in_institutes_te_ba_batch_1te_in_institutes_ida"] = array (
  'name' => 'te_in_institutes_te_ba_batch_1te_in_institutes_ida',
  'type' => 'link',
  'relationship' => 'te_in_institutes_te_ba_batch_1',
  'source' => 'non-db',
  'reportable' => false,
  'required'=>true,
  'side' => 'right',
  'vname' => 'LBL_TE_IN_INSTITUTES_TE_BA_BATCH_1_FROM_TE_BA_BATCH_TITLE',
);



$dictionary['te_ba_Batch']['fields']['batch_start_date1']['name']='batch_start_date1';
$dictionary['te_ba_Batch']['fields']['batch_start_date1']['vname']='LBL_BATCH_START_DATE';
$dictionary['te_ba_Batch']['fields']['batch_start_date1']['type']='date';
$dictionary['te_ba_Batch']['fields']['batch_start_date1']['enable_range_search']=true;
$dictionary['te_ba_Batch']['fields']['batch_start_date1']['options']='date_range_search_dom';



 


 // created: 2016-10-06 05:58:28
$dictionary['te_ba_Batch']['fields']['duration']['max']=1000;

 

 // created: 2016-10-06 04:03:42
$dictionary['te_ba_Batch']['fields']['minimum_attendance_criteria']['comments']='Attendance is in %';

$dictionary['te_ba_Batch']['fields']['minimum_attendance_criteria']['precision']='2';
$dictionary['te_ba_Batch']['fields']['fees_inr']['precision']='2';
$dictionary['te_ba_Batch']['fields']['fees_in_usd']['precision']='2';

 

?>
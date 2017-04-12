<?php 
 //WARNING: The contents of this file are auto-generated


 // created: 2016-10-28 02:18:15
$dictionary['te_pr_Programs']['fields']['mobile_number_c']['inline_edit']='1';
$dictionary['te_pr_Programs']['fields']['mobile_number_c']['labelValue']='Mobile Number';

 

// created: 2016-09-05 07:08:40
$dictionary["te_pr_Programs"]["fields"]["te_in_institutes_te_pr_programs_1"] = array (
  'name' => 'te_in_institutes_te_pr_programs_1',
  'type' => 'link',
  'required'=>true,
  'relationship' => 'te_in_institutes_te_pr_programs_1',
  'source' => 'non-db',
  'module' => 'te_in_institutes',
  'bean_name' => 'te_in_institutes',
  'vname' => 'LBL_TE_IN_INSTITUTES_TE_PR_PROGRAMS_1_FROM_TE_IN_INSTITUTES_TITLE',
  'id_name' => 'te_in_institutes_te_pr_programs_1te_in_institutes_ida',
);
$dictionary["te_pr_Programs"]["fields"]["te_in_institutes_te_pr_programs_1_name"] = array (
  'name' => 'te_in_institutes_te_pr_programs_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'required'=>true,
  'vname' => 'LBL_TE_IN_INSTITUTES_TE_PR_PROGRAMS_1_FROM_TE_IN_INSTITUTES_TITLE',
  'save' => true,
  'id_name' => 'te_in_institutes_te_pr_programs_1te_in_institutes_ida',
  'link' => 'te_in_institutes_te_pr_programs_1',
  'table' => 'te_in_institutes',
  'module' => 'te_in_institutes',
  'rname' => 'name',
);
$dictionary["te_pr_Programs"]["fields"]["te_in_institutes_te_pr_programs_1te_in_institutes_ida"] = array (
  'name' => 'te_in_institutes_te_pr_programs_1te_in_institutes_ida',
  'type' => 'link',
  'relationship' => 'te_in_institutes_te_pr_programs_1',
  'source' => 'non-db',
  'required'=>true,
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_TE_IN_INSTITUTES_TE_PR_PROGRAMS_1_FROM_TE_PR_PROGRAMS_TITLE',
);


 // created: 2016-10-28 00:36:36
$dictionary['te_pr_Programs']['fields']['name']['inline_edit']=true;
$dictionary['te_pr_Programs']['fields']['name']['duplicate_merge']='disabled';
$dictionary['te_pr_Programs']['fields']['name']['duplicate_merge_dom_value']='0';
$dictionary['te_pr_Programs']['fields']['name']['merge_filter']='disabled';
$dictionary['te_pr_Programs']['fields']['name']['unified_search']=false;

 

 // created: 2016-10-06 07:46:17
$dictionary['te_pr_Programs']['fields']['contact_number_c']['inline_edit']='1';
$dictionary['te_pr_Programs']['fields']['contact_number_c']['labelValue']='Contact Number';

 

// created: 2016-09-05 07:25:52
$dictionary["te_pr_Programs"]["fields"]["te_pr_programs_te_ba_batch_1"] = array (
  'name' => 'te_pr_programs_te_ba_batch_1',
  'type' => 'link',
  'relationship' => 'te_pr_programs_te_ba_batch_1',
  'source' => 'non-db',
  'module' => 'te_ba_Batch',
  'bean_name' => 'te_ba_Batch',
  'side' => 'right',
  'vname' => 'LBL_TE_PR_PROGRAMS_TE_BA_BATCH_1_FROM_TE_BA_BATCH_TITLE',
);


 // created: 2016-10-28 02:33:27
$dictionary['te_pr_Programs']['fields']['description']['inline_edit']=true;
$dictionary['te_pr_Programs']['fields']['description']['comments']='Full text of the note';
$dictionary['te_pr_Programs']['fields']['description']['merge_filter']='disabled';
$dictionary['te_pr_Programs']['fields']['description']['cols']='29';

 

 // created: 2016-10-05 09:06:08
$dictionary['te_pr_Programs']['fields']['classes_in_progress_c']['inline_edit']='1';
$dictionary['te_pr_Programs']['fields']['classes_in_progress_c']['labelValue']='Classes in Progress';

 

 // created: 2016-10-05 09:01:58
$dictionary['te_pr_Programs']['fields']['enrollment_in_progress_c']['inline_edit']='1';
$dictionary['te_pr_Programs']['fields']['enrollment_in_progress_c']['labelValue']='Enrollment in Progress';

 

 // created: 2016-10-05 09:01:17
$dictionary['te_pr_Programs']['fields']['closed_batch_c']['inline_edit']='1';
$dictionary['te_pr_Programs']['fields']['closed_batch_c']['labelValue']='Closed Batch';

 

 // created: 2016-10-05 09:03:36
$dictionary['te_pr_Programs']['fields']['total_p_c']['inline_edit']='1';
$dictionary['te_pr_Programs']['fields']['total_p_c']['labelValue']='Total';

 

// created: 2016-10-19 03:58:18
$dictionary["te_pr_Programs"]["fields"]["te_program_category_te_pr_programs"] = array (
  'name' => 'te_program_category_te_pr_programs',
  'type' => 'link',
  'relationship' => 'te_program_category_te_pr_programs',
  'source' => 'non-db',
  'module' => 'te_Program_category',
  'bean_name' => 'te_Program_category',
  'vname' => 'LBL_TE_PROGRAM_CATEGORY_TE_PR_PROGRAMS_FROM_TE_PROGRAM_CATEGORY_TITLE',
);


 // created: 2016-10-06 07:47:17
$dictionary['te_pr_Programs']['fields']['email_address_c']['inline_edit']='1';
$dictionary['te_pr_Programs']['fields']['email_address_c']['labelValue']='Email Address';

 

 // created: 2016-10-06 07:45:15
$dictionary['te_pr_Programs']['fields']['director_name_c']['inline_edit']='1';
$dictionary['te_pr_Programs']['fields']['director_name_c']['labelValue']='Director Name';

 
?>
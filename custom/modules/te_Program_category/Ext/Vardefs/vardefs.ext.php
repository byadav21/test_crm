<?php 
 //WARNING: The contents of this file are auto-generated


 // created: 2016-11-03 23:28:35
$dictionary['te_Program_category']['fields']['name']['inline_edit']=true;
$dictionary['te_Program_category']['fields']['name']['duplicate_merge']='disabled';
$dictionary['te_Program_category']['fields']['name']['duplicate_merge_dom_value']='0';
$dictionary['te_Program_category']['fields']['name']['merge_filter']='disabled';
$dictionary['te_Program_category']['fields']['name']['unified_search']=false;

 

$dictionary['te_Program_category']['fields']['istitutes_list'] = array (
	'name' => 'institutes_list',
    'vname' => 'Institutes',
    'type' => 'varchar',
    'source' => 'non-db',
    'duplicate_merge' => 'disabled',
    'required' => false,
    'studio' => 'visible',
);



$dictionary['te_Program_category']['fields']['programs'] = array (
	'name' => 'programs',
    'vname' => 'Programs',
    'type' => 'textfield',
    'source' => 'non-db',
    'duplicate_merge' => 'disabled',
    'required' => false,
    'studio' => 'visible',
);



// created: 2016-10-19 03:58:18
$dictionary["te_Program_category"]["fields"]["te_program_category_te_pr_programs"] = array (
  'name' => 'te_program_category_te_pr_programs',
  'type' => 'link',
  'relationship' => 'te_program_category_te_pr_programs',
  'source' => 'non-db',
  'module' => 'te_pr_Programs',
  'bean_name' => 'te_pr_Programs',
  'vname' => 'LBL_TE_PROGRAM_CATEGORY_TE_PR_PROGRAMS_FROM_TE_PR_PROGRAMS_TITLE',
);

?>
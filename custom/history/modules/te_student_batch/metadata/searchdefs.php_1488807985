<?php
$module_name = 'te_student_batch';
$searchdefs [$module_name] = 
array (
  'layout' => 
  array (
    'basic_search' => 
    array (
      'te_student_te_student_batch_1_name' => 
      array (
        'type' => 'relate',
        'link' => true,
        'label' => 'LBL_TE_STUDENT_TE_STUDENT_BATCH_1_FROM_TE_STUDENT_TITLE',
        'id' => 'TE_STUDENT_TE_STUDENT_BATCH_1TE_STUDENT_IDA',
        'width' => '10%',
        'default' => true,
        'name' => 'te_student_te_student_batch_1_name',
      ),
      'name' => 
      array (
        'name' => 'name',
        'default' => true,
        'width' => '10%',
      ),
      'institute' => 
      array (
        'type' => 'relate',
        'studio' => 'visible',
        'label' => 'LBL_INSTITUTE',
        'id' => 'TE_IN_INSTITUTES_ID_C',
        'link' => true,
        'width' => '10%',
        'default' => true,
        'name' => 'institute',
      ),
      'status' => 
      array (
        'type' => 'enum',
        'studio' => 'visible',
        'label' => 'LBL_STATUS',
        'width' => '10%',
        'default' => true,
        'name' => 'status',
      ),
      'program' => 
      array (
        'type' => 'relate',
        'studio' => 'visible',
        'label' => 'LBL_PROGRAM',
        'id' => 'TE_PR_PROGRAMS_ID_C',
        'link' => true,
        'width' => '10%',
        'default' => true,
        'name' => 'program',
      ),
      'email' => 
      array (
        'type' => 'varchar',
        'studio' => 'visible',
        'label' => 'Email',
        'width' => '10%',
        'default' => true,
        'name' => 'email',
      ),
      'current_user_only' => 
      array (
        'name' => 'current_user_only',
        'label' => 'LBL_CURRENT_USER_FILTER',
        'type' => 'bool',
        'default' => true,
        'width' => '10%',
      ),
    ),
    'advanced_search' => 
    array (
      0 => 'name',
      1 => 
      array (
        'name' => 'assigned_user_id',
        'label' => 'LBL_ASSIGNED_TO',
        'type' => 'enum',
        'function' => 
        array (
          'name' => 'get_user_array',
          'params' => 
          array (
            0 => false,
          ),
        ),
      ),
    ),
  ),
  'templateMeta' => 
  array (
    'maxColumns' => '3',
    'maxColumnsBasic' => '4',
    'widths' => 
    array (
      'label' => '10',
      'field' => '30',
    ),
  ),
);
?>

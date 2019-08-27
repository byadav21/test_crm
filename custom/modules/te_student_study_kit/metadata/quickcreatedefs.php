<?php
$module_name = 'te_student_study_kit';
$viewdefs [$module_name] = 
array (
  'QuickCreate' => 
  array (
    'templateMeta' => 
    array (
      'maxColumns' => '2',
      'widths' => 
      array (
        0 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
        1 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
      ),
      'useTabs' => false,
      'tabDefs' => 
      array (
        'DEFAULT' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
      ),
    ),
    'panels' => 
    array (
      'default' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'batch_id',
            'studio' => 'visible',
            'label' => 'LBL_BATCH_ID',
          ),
          1 => 
          array (
            'name' => 'study_kit_address',
            'label' => 'LBL_STUDY_KIT_ADDRESS',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'number_of_kits',
            'label' => 'LBL_NUMBER_OF_KITS',
          ),
          1 => 
          array (
            'name' => 'study_kit_address_country',
            'label' => 'LBL_STUDY_KIT_ADDRESS_COUNTRY',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'status',
            'studio' => 'visible',
            'label' => 'LBL_STATUS',
          ),
          1 => 
          array (
            'name' => 'study_kit_address_state',
            'label' => 'LBL_STUDY_KIT_ADDRESS_STATE',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'address_confirmed',
            'studio' => 'visible',
            'label' => 'LBL_ADDRESS_CONFIRMED',
          ),
          1 => 
          array (
            'name' => 'study_kit_address_city',
            'label' => 'LBL_STUDY_KIT_ADDRESS_CITY',
          ),
        ),
        4 => 
        array (
          0 => '',
          1 => 
          array (
            'name' => 'study_kit_address_postalcode',
            'label' => 'LBL_STUDY_KIT_ADDRESS_POSTALCODE',
          ),
        ),
      ),
    ),
  ),
);
?>

<?php
$module_name = 'te_student_batch';
$viewdefs [$module_name] = 
array (
  'EditView' => 
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
      'includes' => 
      array (
        0 => 
        array (
          'file' => 'custom/modules/te_student_batch/student_batch.js',
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
        'LBL_EDITVIEW_PANEL1' => 
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
            'name' => 'batch',
            'studio' => 'visible',
            'label' => 'LBL_BATCH',
            'displayParams' => 
            array (
              'hide_Buttons' => true,
            ),
          ),
          1 => 
          array (
            'name' => 'batch_code',
            'label' => 'LBL_BATCH_CODE',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'te_student_te_student_batch_1_name',
            'displayParams' => 
            array (
              'hide_Buttons' => true,
            ),
          ),
          1 => 
          array (
            'name' => 'institute',
            'studio' => 'visible',
            'label' => 'LBL_INSTITUTE',
            'displayParams' => 
            array (
              'hide_Buttons' => true,
            ),
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'program',
            'studio' => 'visible',
            'label' => 'LBL_PROGRAM',
            'displayParams' => 
            array (
              'hide_Buttons' => true,
            ),
          ),
          1 => 
          array (
            'name' => 'source',
            'studio' => 'visible',
            'label' => 'LBL_SOURCE',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'fee_inr',
            'label' => 'LBL_FEE_INR',
          ),
          1 => 
          array (
            'name' => 'fee_usd',
            'label' => 'LBL_FEE_USD',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'status',
            'studio' => 'visible',
            'label' => 'LBL_STATUS',
          ),
          1 => 'description',
        ),
      ),
      'lbl_editview_panel1' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'dropout_type',
            'studio' => 'visible',
            'label' => 'LBL_DROPOUT_TYPE',
          ),
          1 => 
          array (
            'name' => 'qualify_for_refund',
            'studio' => 'visible',
            'label' => 'LBL_QUALIFY_FOR_REFUND',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'refund_request_date',
            'label' => 'LBL_REFUND_REQUEST_DATE',
          ),
          1 => 
          array (
            'name' => 'refund_amount',
            'label' => 'LBL_REFUND_AMOUNT',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'refund_date',
            'label' => 'LBL_REFUND_DATE',
          ),
          1 => '',
        ),
      ),
    ),
  ),
);
?>

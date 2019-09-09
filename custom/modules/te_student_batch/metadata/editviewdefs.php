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
        'LBL_EDITVIEW_PANEL2' => 
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
            'name' => 'result',
            'studio' => 'visible',
            'label' => 'LBL_RESULT',
          ),
          1 => '',
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'eligible_for_certificate',
            'studio' => 'visible',
            'label' => 'LBL_ELIGIBLE_FOR_CERTIFICATE',
          ),
          1 => 
          array (
            'name' => 'assessment_mode',
            'studio' => 'visible',
            'label' => 'LBL_ASSESSMENT_MODE',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'actual_attendance',
            'label' => 'LBL_ACTUAL_ATTENDANCE',
          ),
          1 => 
          array (
            'name' => 'feedback_given',
            'studio' => 'visible',
            'label' => 'LBL_FEEDBACH_GIVEN',
          ),
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'Assessment_center_lcocation_preference',
            'label' => 'LBL_ASSESSMENT_CENTER_LOCATION_PREFERENCE',
          ),
          1 => 
          array (
            'name' => 'total_session_required',
            'label' => 'LBL_TOTAL_SESSION_REQUIRED',
          ),
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'channel',
            'label' => 'LBL_CHANNEL',
          ),
          1 => 
          array (
            'name' => 'completion_certificate_address',
            'comment' => 'Full text of the note',
            'label' => 'LBL_COMPLETION_CERTIFICATE_ADDRESS',
          ),
        ),
        9 => 
        array (
          0 => 
          array (
            'name' => 'assigned_user_name',
            'label' => 'LBL_ASSIGNED_TO',
          ),
          1 => 
          array (
            'name' => 'certificate_sent',
            'studio' => 'visible',
            'label' => 'LBL_CERTIFICATE_SENT',
          ),
        ),
        10 => 
        array (
          0 => '',
          1 => '',
        ),
        11 => 
        array (
          0 => 
          array (
            'name' => 'kit_status',
            'studio' => 'visible',
            'label' => 'Kit Status',
          ),
          1 => 
          array (
            'name' => 'study_kit_address',
            'studio' => 'visible',
            'label' => 'Study Kit Address',
          ),
        ),
        12 => 
        array (
          0 => 
          array (
            'name' => 'address_confirmed',
            'studio' => 'visible',
            'label' => 'Address Confiremed',
          ),
          1 => 
          array (
            'name' => 'study_kit_address_country',
            'studio' => 'visible',
            'label' => 'Study Kit Address Country',
          ),
        ),
        13 => 
        array (
          0 => 
          array (
            'name' => 'bt_fee_waiver',
            'studio' => 'visible',
            'label' => 'bt_fee_waiver',
          ),
          1 => 
          array (
            'name' => 'study_kit_address_state',
            'studio' => 'visible',
            'label' => 'Study Kit Address State',
          ),
        ),
        14 => 
        array (
          0 => '',
          1 => 
          array (
            'name' => 'study_kit_address_city',
            'studio' => 'visible',
            'label' => 'Study Kit Address City',
          ),
        ),
        15 => 
        array (
          0 => '',
          1 => 
          array (
            'name' => 'study_kit_address_postalcode',
            'studio' => 'visible',
            'label' => 'Study Kit Address Postalcode',
          ),
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
          1 => 
          array (
            'name' => 'dropout_status',
            'studio' => 'visible',
            'label' => 'LBL_DROPOUT_STATUS',
          ),
        ),
      ),
      'lbl_editview_panel2' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'status',
            'studio' => 'visible',
            'label' => 'LBL_STATUS',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'status_discription',
            'studio' => 'visible',
            'label' => 'Status Discription',
          ),
          1 => '',
        ),
        2 => 
        array (
          0 => 'description',
        ),
      ),
    ),
  ),
);
?>

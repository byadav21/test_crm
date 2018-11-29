<?php
$module_name = 'te_ba_Batch';
$viewdefs [$module_name] = 
array (
  'EditView' => 
  array (
    'templateMeta' => 
    array (
      'maxColumns' => '2',
      'form' => 
      array (
        'footerTpl' => 'custom/modules/te_ba_Batch/tpls/EditViewFooter.tpl',
      ),
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
      'syncDetailEditViews' => true,
    ),
    'panels' => 
    array (
      'default' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'te_in_institutes_te_ba_batch_1_name',
          ),
          1 => 
          array (
            'name' => 'te_pr_programs_te_ba_batch_1_name',
          ),
        ),
        1 => 
        array (
          0 => 'name',
          1 => 
          array (
            'name' => 'batch_code',
            'label' => 'LBL_BATCH_CODE',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'short_name',
            'label' => 'Short Name',
          ),
          1 => 
          array (
            'name' => 'batch_completion_date_2',
            'label' => 'LBL_BATCH_COMPLETION_DATE_2',
            'comment' => '',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'batch_start_date',
            'label' => 'LBL_BATCH_START_DATE',
          ),
          1 => 
          array (
            'name' => 'batch_status',
            'studio' => 'visible',
            'label' => 'LBL_BATCH_STATUS',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'fees_inr',
            'label' => 'LBL_FEES_INR',
          ),
          1 => 
          array (
            'name' => 'batch_size',
            'label' => 'LBL_BATCH_SIZE',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'duration',
            'label' => 'LBL_DURATION',
          ),
          1 => 
          array (
            'name' => 'minimum_attendance_criteria',
            'label' => 'LBL_MINIMUM_ATTENDANCE_CRITERIA',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'total_sessions_planned',
            'label' => 'LBL_TOTAL_SESSIONS_PLANNED',
          ),
          1 => 
          array (
            'name' => 'registration_closing_date',
            'label' => 'LBL_REGISTRATION_CLOSING_DATE',
          ),
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'fees_in_usd',
            'label' => 'LBL_FEES_IN_USD',
          ),
          1 => 
          array (
            'name' => 'd_campaign_id',
            'label' => 'Campagain ID',
          ),
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'description',
            'displayParams' => 
            array (
              'cols' => 32,
              'rows' => 3,
            ),
          ),
          1 => 
          array (
            'name' => 'd_lead_id',
            'label' => 'Lead ID',
          ),
        ),
        9 => 
        array (
          0 => 
          array (
            'name' => 'discount_in_inr',
            'studio' => 'visible',
            'label' => 'Discount In INR',
          ),
          1 => 
          array (
            'name' => 'discount_in_usd',
            'studio' => 'visible',
            'label' => 'Discount In USD',
          ),
        ),
      ),
    ),
  ),
);
?>

<?php
$module_name = 'te_utm';
$viewdefs [$module_name] = 
array (
  'DetailView' => 
  array (
    'templateMeta' => 
    array (
      'form' => 
      array (
        'buttons' => 
        array (
          0 => 'EDIT',
          1 => 'DUPLICATE',
          2 => 'DELETE',
          3 => 'FIND_DUPLICATES',
          4 => 
          array (
            'customCode' => '<input  class="button" type="button" name="expire_button"  value="Mark as Expired" onclick="return makeExpire(this.form);">',
          ),
        ),
      ),
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
          0 => 'name',
          1 => 
          array (
            'name' => 'te_vendor_te_utm_1_name',
            'label' => 'UTM Source',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'contract',
            'studio' => 'visible',
            'label' => 'LBL_CONTRACT',
          ),
          1 => 
          array (
            'name' => 'utm_campaign',
            'label' => 'LBL_UTM_CAMPAIGN',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'batch',
            'studio' => 'visible',
            'label' => 'LBL_BATCH',
          ),
          1 => 
          array (
            'name' => 'utm_status',
            'studio' => 'visible',
            'label' => 'LBL_UTM_STATUS',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'description',
            'label' => 'Notes',
          ),
          1 => 
          array (
            'name' => 'date_entered',
            'label' => 'Created On',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'live_on',
            'label' => 'Live On',
          ),
          1 => 
          array (
            'name' => 'utm_url',
            'label' => 'URL',
          ),
        ),
      ),
    ),
  ),
);
?>

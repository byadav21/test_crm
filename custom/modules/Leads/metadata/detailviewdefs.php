<?php
$viewdefs ['Leads'] = 
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
          4 => 'FIND_DUPLICATES',
          5 => 
          array (
            'customCode' => '<input title="{$APP.LBL_MANAGE_SUBSCRIPTIONS}" class="button" onclick="this.form.return_module.value=\'Leads\'; this.form.return_action.value=\'DetailView\';this.form.return_id.value=\'{$fields.id.value}\'; this.form.action.value=\'Subscriptions\'; this.form.module.value=\'Campaigns\'; this.form.module_tab.value=\'Leads\';" type="submit" name="Manage Subscriptions" value="{$APP.LBL_MANAGE_SUBSCRIPTIONS}">',
            'sugar_html' => 
            array (
              'type' => 'submit',
              'value' => '{$APP.LBL_MANAGE_SUBSCRIPTIONS}',
              'htmlOptions' => 
              array (
                'title' => '{$APP.LBL_MANAGE_SUBSCRIPTIONS}',
                'class' => 'button',
                'id' => 'manage_subscriptions_button',
                'onclick' => 'this.form.return_module.value=\'Leads\'; this.form.return_action.value=\'DetailView\';this.form.return_id.value=\'{$fields.id.value}\'; this.form.action.value=\'Subscriptions\'; this.form.module.value=\'Campaigns\'; this.form.module_tab.value=\'Leads\';',
                'name' => '{$APP.LBL_MANAGE_SUBSCRIPTIONS}',
              ),
            ),
          ),
          6 => 
          array (
            'customCode' => '<input title="Generate Invoice" accessKey="" type="button" class="button" onClick="generateInvoice({$fields.id.value})" name="g_invoice" value="Generate Invoice">',
            'sugar_html' => 
            array (
              'type' => 'button',
              'value' => 'Generate Invoice',
              'htmlOptions' => 
              array (
                'title' => 'Generate Invoice',
                'accessKey' => '',
                'class' => 'button',
                'onClick' => 'generateInvoice(\'{$fields.id.value}\')',
                'name' => 'g_invoice',
                'id' => 'g_invoice_button',
              ),
              'template' => '{if $bean->aclAccess("edit") && !$DISABLE_CONVERT_ACTION}[CONTENT]{/if}',
            ),
          ),
          'AOS_GENLET' => 
          array (
            'customCode' => '<input type="button" class="button" onClick="showPopup();" value="{$APP.LBL_GENERATE_LETTER}">',
          ),
        ),
        'headerTpl' => 'modules/Leads/tpls/DetailViewHeader.tpl',
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
      'includes' => 
      array (
        0 => 
        array (
          'file' => 'modules/Leads/Lead.js',
        ),
      ),
      'useTabs' => true,
      'tabDefs' => 
      array (
        'LBL_CONTACT_INFORMATION' => 
        array (
          'newTab' => true,
          'panelDefault' => 'expanded',
        ),
      ),
      'syncDetailEditViews' => true,
    ),
    'panels' => 
    array (
      'LBL_CONTACT_INFORMATION' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'first_name',
            'comment' => 'First name of the contact',
            'label' => 'LBL_FIRST_NAME',
          ),
          1 => 
          array (
            'name' => 'last_name',
            'comment' => 'Last name of the contact',
            'label' => 'LBL_LAST_NAME',
          ),
        ),
        1 => 
        array (
          0 => 'email1',
          1 => 'phone_mobile',
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'min_attendance_c',
            'label' => 'LBL_MIN_ATTENDANCE',
          ),
          1 => 
          array (
            'name' => 'phone_other',
            'comment' => 'Other phone number for the contact',
            'label' => 'LBL_MOBILE_TWO',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'batch_c',
            'studio' => 'visible',
            'label' => 'LBL_BATCH',
          ),
          1 => 
          array (
            'name' => 'assigned_user_name',
            'label' => 'LBL_ASSIGNED_TO',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'comment',
            'comment' => 'Full text of the note',
            'studio' => 'visible',
            'label' => 'COMMENT',
          ),
          1 => 
          array (
            'name' => 'attempts_c',
            'label' => 'LBL_ATTEMPTS',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'program',
            'label' => 'LBL_PROGRAM',
          ),
          1 => 
          array (
            'name' => 'institute',
            'label' => 'LBL_INSTITUTE',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'primary_address_city',
            'comment' => 'City for primary address',
            'label' => 'LBL_CITY',
          ),
          1 => 
          array (
            'name' => 'primary_address_state',
            'comment' => 'State for primary address',
            'label' => 'LBL_STATE',
          ),
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'primary_address_country',
            'comment' => 'Country for primary address',
            'label' => 'LBL_COUNTRY',
          ),
          1 => 
          array (
            'name' => 'birthdate',
            'comment' => 'The birthdate of the contact',
            'label' => 'LBL_BIRTHDATE',
          ),
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'gender',
            'label' => 'Gender',
          ),
          1 => 
          array (
            'name' => 'lead_source_types',
            'label' => 'Lead Source Type',
          ),
        ),
        9 => 
        array (
          0 => 'lead_source',
          1 => 
          array (
            'name' => 'parent_name',
            'studio' => 'visible',
            'label' => 'LBL_FLEX_RELATE',
          ),
        ),
        10 => 
        array (
          0 => 
          array (
            'name' => 'company_c',
            'label' => 'LBL_COMPANY',
          ),
          1 => 
          array (
            'name' => 'functional_area_c',
            'label' => 'LBL_FUNCTIONAL_AREA',
          ),
        ),
        11 => 
        array (
          0 => 
          array (
            'name' => 'work_experience_c',
            'label' => 'LBL_WORK_EXPERIENCE',
          ),
          1 => 
          array (
            'name' => 'education_c',
            'label' => 'LBL_EDUCATION',
          ),
        ),
        12 => 
        array (
          0 => 
          array (
            'name' => 'parrent_leads',
            'studio' => 'visible',
            'label' => 'Parrent Lead',
          ),
          1 => '',
        ),
      ),
    ),
  ),
);
?>

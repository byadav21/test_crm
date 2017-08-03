<?php
$viewdefs ['Leads'] = 
array (
  'EditView' => 
  array (
    'templateMeta' => 
    array (
      'form' => 
      array (
        'hidden' => 
        array (
          0 => '<input type="hidden" name="prospect_id" value="{if isset($smarty.request.prospect_id)}{$smarty.request.prospect_id}{else}{$bean->prospect_id}{/if}">',
          1 => '<input type="hidden" name="account_id" value="{if isset($smarty.request.account_id)}{$smarty.request.account_id}{else}{$bean->account_id}{/if}">',
          2 => '<input type="hidden" name="contact_id" value="{if isset($smarty.request.contact_id)}{$smarty.request.contact_id}{else}{$bean->contact_id}{/if}">',
          3 => '<input type="hidden" name="opportunity_id" value="{if isset($smarty.request.opportunity_id)}{$smarty.request.opportunity_id}{else}{$bean->opportunity_id}{/if}">',
        ),
        'buttons' => 
        array (
          0 => 'SAVE',
          1 => 'CANCEL',
        ),
        'headerTpl' => 'custom/modules/Leads/tpls/header.tpl',
      ),
      'maxColumns' => '2',
      'widths' => 
      array (
        0 => 
        array (
          'label' => '12',
          'field' => '28',
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
          'file' => 'custom/modules/Leads/include/js/popup.js',
        ),
      ),
      'javascript' => '<script type="text/javascript" language="Javascript">function copyAddressRight(form)  {ldelim} form.alt_address_street.value = form.primary_address_street.value;form.alt_address_city.value = form.primary_address_city.value;form.alt_address_state.value = form.primary_address_state.value;form.alt_address_postalcode.value = form.primary_address_postalcode.value;form.alt_address_country.value = form.primary_address_country.value;return true; {rdelim} function copyAddressLeft(form)  {ldelim} form.primary_address_street.value =form.alt_address_street.value;form.primary_address_city.value = form.alt_address_city.value;form.primary_address_state.value = form.alt_address_state.value;form.primary_address_postalcode.value =form.alt_address_postalcode.value;form.primary_address_country.value = form.alt_address_country.value;return true; {rdelim} </script>',
      'useTabs' => true,
      'tabDefs' => 
      array (
        'LBL_CONTACT_INFORMATION' => 
        array (
          'newTab' => true,
          'panelDefault' => 'expanded',
        ),
        'LBL_EDITVIEW_PANEL1' => 
        array (
          'newTab' => true,
          'panelDefault' => 'expanded',
        ),
      ),
      'syncDetailEditViews' => false,
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
            'customCode' => '<input name="first_name"  id="first_name" size="25" maxlength="25" type="text" value="{$fields.first_name.value}">',
          ),
          1 => 'last_name',
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'gender',
            'label' => 'Gender',
          ),
          1 => 
          array (
            'name' => 'birthdate',
            'comment' => 'The birthdate of the contact',
            'label' => 'LBL_BIRTHDATE',
          ),
        ),
        2 => 
        array (
          0 => 'email1',
        ),
        3 => 
        array (
          0 => 'phone_mobile',
          1 => 
          array (
            'name' => 'phone_other',
            'comment' => 'Other phone number for the contact',
            'label' => 'LBL_MOBILE_TWO',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'education_c',
            'label' => 'LBL_EDUCATION',
          ),
          1 => 
          array (
            'name' => 'work_experience_c',
            'label' => 'LBL_WORK_EXPERIENCE',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'functional_area_c',
            'label' => 'LBL_FUNCTIONAL_AREA',
          ),
          1 => 
          array (
            'name' => 'company_c',
            'label' => 'LBL_COMPANY',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'country_log',
            'comment' => 'Status of the country',
            'label' => 'LBL_COUNTRY_LOG',
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
            'name' => 'primary_address_city',
            'comment' => 'City for primary address',
            'label' => 'LBL_CITY',
          ),
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'batch_c',
            'studio' => 'visible',
            'label' => 'LBL_BATCH',
          ),
          1 => 
          array (
            'name' => 'discount',
            'studio' => 'visible',
            'label' => 'Discount',
          ),
        ),
        9 => 
        array (
          0 => '',
          1 => '',
        ),
        10 => 
        array (
          0 => 
          array (
            'name' => 'comment',
            'comment' => 'Full text of the note',
            'studio' => 'visible',
            'label' => 'COMMENT',
          ),
        ),
        11 => 
        array (
          0 => 
          array (
            'name' => 'lead_source_types',
            'label' => 'Lead Source Type',
          ),
          1 => 'lead_source',
        ),
        12 => 
        array (
          0 => 
          array (
            'name' => 'parent_name',
            'studio' => 'visible',
            'label' => 'LBL_FLEX_RELATE',
          ),
        ),
        13 => 
        array (
          0 => 'status',
          1 => 
          array (
            'name' => 'status_description',
          ),
        ),
        14 => 
        array (
          0 => 
          array (
            'name' => 'note',
            'label' => 'LBL_NOTE',
          ),
          1 => 
          array (
            'name' => 'assigned_user_name',
            'label' => 'LBL_ASSIGNED_TO',
          ),
        ),
        15 => 
        array (
          0 => 
          array (
            'name' => 'date_of_followup',
            'label' => 'LBL_DATEOFFOLLOWUP',
          ),
          1 => 
          array (
            'name' => 'date_of_callback',
            'label' => 'LBL_DATEOFCALLBACK',
          ),
        ),
        16 => 
        array (
          0 => 
          array (
            'name' => 'date_of_prospect',
            'label' => 'LBL_DATEOFPROSPECT',
          ),
          1 => '',
        ),
      ),
      'lbl_editview_panel1' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'payment_type',
            'label' => 'LBL_PAYMENTTYPE',
          ),
          1 => 
          array (
            'name' => 'payment_source',
            'label' => 'LBL_PAYMENTTYPESOURCE',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'amount',
            'label' => 'LBL_AMOUNT',
          ),
          1 => 
          array (
            'name' => 'payment_realized',
            'label' => 'LBL_PAYMENTREREALIZED',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'date_of_payment',
            'label' => 'LBL_DATEOFPAYMENT',
          ),
          1 => 
          array (
            'name' => 'reference_number',
            'label' => 'LBL_REFERENCENUMBER',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'transaction_id',
            'label' => 'LBL_TRANSACTIONID',
          ),
        ),
      ),
    ),
  ),
);
?>

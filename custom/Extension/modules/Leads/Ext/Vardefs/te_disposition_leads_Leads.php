<?php
// created: 2016-11-07 22:45:22
$dictionary["Lead"]["fields"]["te_disposition_leads"] = array (
  'name' => 'te_disposition_leads',
  'type' => 'link',
  'relationship' => 'te_disposition_leads',
  'source' => 'non-db',
  'module' => 'te_disposition',
  'bean_name' => false,
  'side' => 'right',
  'vname' => 'LBL_TE_DISPOSITION_LEADS_FROM_TE_DISPOSITION_TITLE',
);
$dictionary["Lead"]["fields"]["country_log"] = 
            array(
                'name' => 'country_log',
                'vname' => 'LBL_COUNTRY_LOG',
                'type' => 'enum',
                'len' => '100',
                'options' => 'country_log',
                'audited' => true,
                'comment' => 'Status of the country',
                'merge_filter' => 'enabled',
            );


$dictionary["Lead"]["fields"]["dispositionName"] = 
            array(
                'name' => 'dispositionName',
                'vname' => 'LBL_DISPOSITION_NAME',
                 'type' => 'varchar',
                'len' => '255',
		'size' => '20',
                'module' => 'Leads',
                'required' => false,
                'reportable' => true,
                'audited' => false,
                'importable' => 'true',
                'duplicate_merge' => false,
            );

$dictionary["Lead"]["fields"]["callType"] = 
            array(
                'name' => 'callType',
                'label' => 'Call Type',
                'vname' => 'LBL_CALL_TYPE',
                'type' => 'varchar',
                'module' => 'Leads',
                'len' => '255',
		'size' => '20',
                'required' => false,
                'reportable' => true,
                'audited' => false,
                'importable' => 'true',
                'duplicate_merge' => false,
            );

          
    $dictionary['Lead']['fields']['expectationsprogram'] = array (
        'name' => 'expectationsprogram',
        'vname' => 'LBL_EXPECTATIONSPROGRAM',
        'label' => 'Expectations Program',
        'type' => 'text',
        'comment' => 'Expectations From The Program',
        'rows' => 6,
        'cols' => '103',
        'inline_edit' => true,
        'comments' => 'Expectations From The Program',
        'merge_filter' => 'disabled',
        'required' => false,
        'studio' => 'visible',
        'source'          => 'custom_fields',
        );

    $dictionary['Lead']['fields']['facebook_c'] = array (
        'name' => 'facebook_c',
        'vname' => 'LBL_FACEBOOK',
        'label' => 'Facebook',
        'type' => 'varchar',
        'comment' => 'Facebook',
        'len' => '255',
		'size' => '20',
        'inline_edit' => true,
        'comments' => 'Facebook',
        'merge_filter' => 'disabled',
        'required' => false,
        'studio' => 'visible',
        'source' => 'custom_fields',
    );

    $dictionary['Lead']['fields']['instagram_c'] = array (
        'name' => 'instagram_c',
        'vname' => 'LBL_INSTAGRAM',
        'label' => 'Instagram',
        'type' => 'varchar',
        'comment' => 'Instagram',
        'len' => '255',
		'size' => '20',
        'inline_edit' => true,
        'comments' => 'Instagram',
        'merge_filter' => 'disabled',
        'required' => false,
        'studio' => 'visible',
        'source' => 'custom_fields',
    );

    $dictionary['Lead']['fields']['linkedin_c'] = array (
        'name' => 'linkedin_c',
        'vname' => 'LBL_LINKEDIN',
        'label' => 'Linkedin',
        'type' => 'varchar',
        'comment' => 'Linkedin',
        'len' => '255',
		'size' => '20',
        'inline_edit' => true,
        'comments' => 'Linkedin',
        'merge_filter' => 'disabled',
        'required' => false,
        'studio' => 'visible',
        'source' => 'custom_fields',
    );


    $dictionary['Lead']['fields']['twitter_c'] = array (
        'name' => 'twitter_c',
        'vname' => 'LBL_TWITTER',
        'label' => 'Twitter',
        'type' => 'varchar',
        'comment' => 'twitter',
        'len' => '255',
		'size' => '20',
        'inline_edit' => true,
        'comments' => 'twitter',
        'merge_filter' => 'disabled',
        'required' => false,
        'studio' => 'visible',
        'source' => 'custom_fields',
        );

    $dictionary['Lead']['fields']['job_title'] = array (
        'name' => 'job_title',
        'vname' => 'LBL_JOB_TITLE',
        'label' => 'Job Title',
        'type' => 'varchar',
        'comment' => 'Job Title',
        'len' => '255',
		'size' => '20',
        'inline_edit' => true,
        'comments' => 'Job Title',
        'merge_filter' => 'disabled',
        'required' => false,
        'studio' => 'visible',
        'source' => 'custom_fields',
        );


    




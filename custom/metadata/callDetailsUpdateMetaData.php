<?php
// created: 2013-09-10 17:42:22

$dictionary['neox_call_details_update'] = array(
    'table' => 'neox_call_details_update',
    'fields' => array(
        'id' => array(
            'name' => 'id',
            'vname' => 'LBL_ID',
            'type' => 'int',
			'len' => 20,
           'auto_increment' => true,
            
        ),
	   'list_id' => 
		array (
		  'name' => 'list_id',
		  'type' => 'varchar',
		  'len' => 36,
		),
        'campaign_id' => 
		array (
		  'name' => 'campaign_id',
		  'type' => 'varchar',
		  'len' => 36,
		),
        'group_id' => 
		array (
		  'name' => 'group_id',
		  'type' => 'varchar',
		  'len' => 36,
		),
		'call_date' => 
		array (
		  'name' => 'call_date',
		  'type' => 'datetime',
		  'len' => 36,
		),
		'customer_time' => 
		array (
		  'name' => 'customer_time',
		  'type' => 'varchar',
		  'len' => 36,
		),
		'status' => 
		array (
		  'name' => 'status',
		  'type' => 'varchar',
		  'len' => 36,
		),
		'phone_number' => 
		array (
		  'name' => 'phone_number',
		  'type' => 'varchar',
		  'len' => 36,
		),
		'user' => 
		array (
		  'name' => 'user',
		  'type' => 'varchar',
		  'len' => 36,
		),
		'unique_id' => 
		array (
		  'name' => 'unique_id',
		  'type' => 'varchar',
		  'len' => 36,
		),
		'extension' => 
		array (
		  'name' => 'extension',
		  'type' => 'varchar',
		  'len' => 36,
		),
		'term_reason' => 
		array (
		  'name' => 'term_reason',
		  'type' => 'varchar',
		  'len' => 255,
		),
		'talk_duration' => 
		array (
		  'name' => 'talk_duration',
		  'type' => 'varchar',
		  'len' => 36,
		),
		'recording_file' => 
		array (
		  'name' => 'recording_file',
		  'type' => 'varchar',
		  'len' => 255,
		),
    ) ,
    'indices' => array(
        array(
            'name' => 'list_id_link_pk',
            'type' => 'primary',
            'fields' => array(
                'id'
            )
        ) ,
        array(
            'name' => 'idx_list_id',
            'type' => 'index',
            'fields' => array(
                'list_id'
            )
        )
    ) ,
);

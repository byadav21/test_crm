<?php 
 $GLOBALS["dictionary"]["AOW_WorkFlow"]=array (
  'table' => 'aow_workflow',
  'audited' => true,
  'duplicate_merge' => true,
  'fields' => 
  array (
    'id' => 
    array (
      'name' => 'id',
      'vname' => 'LBL_ID',
      'type' => 'id',
      'required' => true,
      'reportable' => true,
      'comment' => 'Unique identifier',
      'inline_edit' => false,
    ),
    'name' => 
    array (
      'name' => 'name',
      'vname' => 'LBL_NAME',
      'type' => 'name',
      'link' => true,
      'dbType' => 'varchar',
      'len' => 255,
      'unified_search' => true,
      'full_text_search' => 
      array (
        'boost' => 3,
      ),
      'required' => true,
      'importable' => 'required',
      'duplicate_merge' => 'enabled',
      'merge_filter' => 'selected',
    ),
    'date_entered' => 
    array (
      'name' => 'date_entered',
      'vname' => 'LBL_DATE_ENTERED',
      'type' => 'datetime',
      'group' => 'created_by_name',
      'comment' => 'Date record created',
      'enable_range_search' => true,
      'options' => 'date_range_search_dom',
      'inline_edit' => false,
    ),
    'date_modified' => 
    array (
      'name' => 'date_modified',
      'vname' => 'LBL_DATE_MODIFIED',
      'type' => 'datetime',
      'group' => 'modified_by_name',
      'comment' => 'Date record last modified',
      'enable_range_search' => true,
      'options' => 'date_range_search_dom',
      'inline_edit' => false,
    ),
    'modified_user_id' => 
    array (
      'name' => 'modified_user_id',
      'rname' => 'user_name',
      'id_name' => 'modified_user_id',
      'vname' => 'LBL_MODIFIED',
      'type' => 'assigned_user_name',
      'table' => 'users',
      'isnull' => 'false',
      'group' => 'modified_by_name',
      'dbType' => 'id',
      'reportable' => true,
      'comment' => 'User who last modified record',
      'massupdate' => false,
      'inline_edit' => false,
    ),
    'modified_by_name' => 
    array (
      'name' => 'modified_by_name',
      'vname' => 'LBL_MODIFIED_NAME',
      'type' => 'relate',
      'reportable' => false,
      'source' => 'non-db',
      'rname' => 'user_name',
      'table' => 'users',
      'id_name' => 'modified_user_id',
      'module' => 'Users',
      'link' => 'modified_user_link',
      'duplicate_merge' => 'disabled',
      'massupdate' => false,
      'inline_edit' => false,
    ),
    'created_by' => 
    array (
      'name' => 'created_by',
      'rname' => 'user_name',
      'id_name' => 'modified_user_id',
      'vname' => 'LBL_CREATED',
      'type' => 'assigned_user_name',
      'table' => 'users',
      'isnull' => 'false',
      'dbType' => 'id',
      'group' => 'created_by_name',
      'comment' => 'User who created record',
      'massupdate' => false,
      'inline_edit' => false,
    ),
    'created_by_name' => 
    array (
      'name' => 'created_by_name',
      'vname' => 'LBL_CREATED',
      'type' => 'relate',
      'reportable' => false,
      'link' => 'created_by_link',
      'rname' => 'user_name',
      'source' => 'non-db',
      'table' => 'users',
      'id_name' => 'created_by',
      'module' => 'Users',
      'duplicate_merge' => 'disabled',
      'importable' => 'false',
      'massupdate' => false,
      'inline_edit' => false,
    ),
    'description' => 
    array (
      'name' => 'description',
      'vname' => 'LBL_DESCRIPTION',
      'type' => 'text',
      'comment' => 'Full text of the note',
      'rows' => 6,
      'cols' => 80,
    ),
    'deleted' => 
    array (
      'name' => 'deleted',
      'vname' => 'LBL_DELETED',
      'type' => 'bool',
      'default' => '0',
      'reportable' => false,
      'comment' => 'Record deletion indicator',
    ),
    'created_by_link' => 
    array (
      'name' => 'created_by_link',
      'type' => 'link',
      'relationship' => 'aow_workflow_created_by',
      'vname' => 'LBL_CREATED_USER',
      'link_type' => 'one',
      'module' => 'Users',
      'bean_name' => 'User',
      'source' => 'non-db',
    ),
    'modified_user_link' => 
    array (
      'name' => 'modified_user_link',
      'type' => 'link',
      'relationship' => 'aow_workflow_modified_user',
      'vname' => 'LBL_MODIFIED_USER',
      'link_type' => 'one',
      'module' => 'Users',
      'bean_name' => 'User',
      'source' => 'non-db',
    ),
    'assigned_user_id' => 
    array (
      'name' => 'assigned_user_id',
      'rname' => 'user_name',
      'id_name' => 'assigned_user_id',
      'vname' => 'LBL_ASSIGNED_TO_ID',
      'group' => 'assigned_user_name',
      'type' => 'relate',
      'table' => 'users',
      'module' => 'Users',
      'reportable' => true,
      'isnull' => 'false',
      'dbType' => 'id',
      'audited' => true,
      'comment' => 'User ID assigned to record',
      'duplicate_merge' => 'disabled',
    ),
    'assigned_user_name' => 
    array (
      'name' => 'assigned_user_name',
      'link' => 'assigned_user_link',
      'vname' => 'LBL_ASSIGNED_TO_NAME',
      'rname' => 'user_name',
      'type' => 'relate',
      'reportable' => false,
      'source' => 'non-db',
      'table' => 'users',
      'id_name' => 'assigned_user_id',
      'module' => 'Users',
      'duplicate_merge' => 'disabled',
    ),
    'assigned_user_link' => 
    array (
      'name' => 'assigned_user_link',
      'type' => 'link',
      'relationship' => 'aow_workflow_assigned_user',
      'vname' => 'LBL_ASSIGNED_TO_USER',
      'link_type' => 'one',
      'module' => 'Users',
      'bean_name' => 'User',
      'source' => 'non-db',
      'duplicate_merge' => 'enabled',
      'rname' => 'user_name',
      'id_name' => 'assigned_user_id',
      'table' => 'users',
    ),
    'SecurityGroups' => 
    array (
      'name' => 'SecurityGroups',
      'type' => 'link',
      'relationship' => 'securitygroups_aow_workflow',
      'module' => 'SecurityGroups',
      'bean_name' => 'SecurityGroup',
      'source' => 'non-db',
      'vname' => 'LBL_SECURITYGROUPS',
    ),
    'flow_module' => 
    array (
      'required' => true,
      'name' => 'flow_module',
      'vname' => 'LBL_FLOW_MODULE',
      'type' => 'enum',
      'massupdate' => 0,
      'default' => '',
      'comments' => '',
      'help' => '',
      'importable' => 'true',
      'duplicate_merge' => 'disabled',
      'duplicate_merge_dom_value' => '0',
      'audited' => false,
      'reportable' => true,
      'unified_search' => false,
      'merge_filter' => 'disabled',
      'len' => 100,
      'size' => '20',
      'options' => 'aow_moduleList',
      'studio' => 'visible',
      'dependency' => false,
    ),
    'flow_run_on' => 
    array (
      'required' => true,
      'name' => 'flow_run_on',
      'vname' => 'LBL_RUN_ON',
      'type' => 'enum',
      'massupdate' => 0,
      'default' => '0',
      'comments' => '',
      'help' => '',
      'importable' => 'true',
      'duplicate_merge' => 'disabled',
      'duplicate_merge_dom_value' => '0',
      'audited' => false,
      'reportable' => true,
      'unified_search' => false,
      'merge_filter' => 'disabled',
      'len' => 100,
      'size' => '20',
      'options' => 'aow_run_on_list',
      'studio' => 'visible',
      'dependency' => false,
    ),
    'status' => 
    array (
      'required' => false,
      'name' => 'status',
      'vname' => 'LBL_STATUS',
      'type' => 'enum',
      'massupdate' => 1,
      'default' => 'Active',
      'comments' => '',
      'help' => '',
      'importable' => 'true',
      'duplicate_merge' => 'disabled',
      'duplicate_merge_dom_value' => '0',
      'audited' => false,
      'reportable' => true,
      'unified_search' => false,
      'merge_filter' => 'disabled',
      'len' => 100,
      'size' => '20',
      'options' => 'aow_status_list',
      'studio' => 'visible',
      'dependency' => false,
    ),
    'run_when' => 
    array (
      'required' => false,
      'name' => 'run_when',
      'vname' => 'LBL_RUN_WHEN',
      'type' => 'enum',
      'massupdate' => 0,
      'default' => 'Always',
      'comments' => '',
      'help' => '',
      'importable' => 'true',
      'duplicate_merge' => 'disabled',
      'duplicate_merge_dom_value' => '0',
      'audited' => false,
      'reportable' => true,
      'unified_search' => false,
      'merge_filter' => 'disabled',
      'len' => 100,
      'size' => '20',
      'options' => 'aow_run_when_list',
      'studio' => 'visible',
      'dependency' => false,
    ),
    'multiple_runs' => 
    array (
      'name' => 'multiple_runs',
      'vname' => 'LBL_MULTIPLE_RUNS',
      'type' => 'bool',
      'default' => '0',
      'reportable' => false,
    ),
    'condition_lines' => 
    array (
      'required' => false,
      'name' => 'condition_lines',
      'vname' => 'LBL_CONDITION_LINES',
      'type' => 'function',
      'source' => 'non-db',
      'massupdate' => 0,
      'importable' => 'false',
      'duplicate_merge' => 'disabled',
      'duplicate_merge_dom_value' => 0,
      'audited' => false,
      'reportable' => false,
      'function' => 
      array (
        'name' => 'display_condition_lines',
        'returns' => 'html',
        'include' => 'modules/AOW_Conditions/conditionLines.php',
      ),
    ),
    'action_lines' => 
    array (
      'required' => false,
      'name' => 'action_lines',
      'vname' => 'LBL_ACTION_LINES',
      'type' => 'function',
      'source' => 'non-db',
      'massupdate' => 0,
      'importable' => 'false',
      'duplicate_merge' => 'disabled',
      'duplicate_merge_dom_value' => 0,
      'audited' => false,
      'reportable' => false,
      'function' => 
      array (
        'name' => 'display_action_lines',
        'returns' => 'html',
        'include' => 'modules/AOW_Actions/actionLines.php',
      ),
    ),
    'aow_conditions' => 
    array (
      'name' => 'aow_conditions',
      'type' => 'link',
      'relationship' => 'aow_workflow_aow_conditions',
      'module' => 'AOW_Conditions',
      'bean_name' => 'AOW_Condition',
      'source' => 'non-db',
    ),
    'aow_actions' => 
    array (
      'name' => 'aow_actions',
      'type' => 'link',
      'relationship' => 'aow_workflow_aow_actions',
      'module' => 'AOW_Actions',
      'bean_name' => 'AOW_Action',
      'source' => 'non-db',
    ),
    'aow_processed' => 
    array (
      'name' => 'aow_processed',
      'type' => 'link',
      'relationship' => 'aow_workflow_aow_processed',
      'module' => 'AOW_Processed',
      'bean_name' => 'AOW_Processed',
      'source' => 'non-db',
    ),
  ),
  'relationships' => 
  array (
    'aow_workflow_modified_user' => 
    array (
      'lhs_module' => 'Users',
      'lhs_table' => 'users',
      'lhs_key' => 'id',
      'rhs_module' => 'AOW_WorkFlow',
      'rhs_table' => 'aow_workflow',
      'rhs_key' => 'modified_user_id',
      'relationship_type' => 'one-to-many',
    ),
    'aow_workflow_created_by' => 
    array (
      'lhs_module' => 'Users',
      'lhs_table' => 'users',
      'lhs_key' => 'id',
      'rhs_module' => 'AOW_WorkFlow',
      'rhs_table' => 'aow_workflow',
      'rhs_key' => 'created_by',
      'relationship_type' => 'one-to-many',
    ),
    'aow_workflow_assigned_user' => 
    array (
      'lhs_module' => 'Users',
      'lhs_table' => 'users',
      'lhs_key' => 'id',
      'rhs_module' => 'AOW_WorkFlow',
      'rhs_table' => 'aow_workflow',
      'rhs_key' => 'assigned_user_id',
      'relationship_type' => 'one-to-many',
    ),
    'securitygroups_aow_workflow' => 
    array (
      'lhs_module' => 'SecurityGroups',
      'lhs_table' => 'securitygroups',
      'lhs_key' => 'id',
      'rhs_module' => 'AOW_WorkFlow',
      'rhs_table' => 'aow_workflow',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'securitygroups_records',
      'join_key_lhs' => 'securitygroup_id',
      'join_key_rhs' => 'record_id',
      'relationship_role_column' => 'module',
      'relationship_role_column_value' => 'AOW_WorkFlow',
    ),
    'aow_workflow_aow_conditions' => 
    array (
      'lhs_module' => 'AOW_WorkFlow',
      'lhs_table' => 'aow_workflow',
      'lhs_key' => 'id',
      'rhs_module' => 'AOW_Conditions',
      'rhs_table' => 'aow_conditions',
      'rhs_key' => 'aow_workflow_id',
      'relationship_type' => 'one-to-many',
    ),
    'aow_workflow_aow_actions' => 
    array (
      'lhs_module' => 'AOW_WorkFlow',
      'lhs_table' => 'aow_workflow',
      'lhs_key' => 'id',
      'rhs_module' => 'AOW_Actions',
      'rhs_table' => 'aow_actions',
      'rhs_key' => 'aow_workflow_id',
      'relationship_type' => 'one-to-many',
    ),
    'aow_workflow_aow_processed' => 
    array (
      'lhs_module' => 'AOW_WorkFlow',
      'lhs_table' => 'aow_workflow',
      'lhs_key' => 'id',
      'rhs_module' => 'AOW_Processed',
      'rhs_table' => 'aow_processed',
      'rhs_key' => 'aow_workflow_id',
      'relationship_type' => 'one-to-many',
    ),
  ),
  'indices' => 
  array (
    'id' => 
    array (
      'name' => 'aow_workflowpk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    0 => 
    array (
      'name' => 'aow_workflow_index_status',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'status',
      ),
    ),
  ),
  'optimistic_locking' => true,
  'unified_search' => true,
  'templates' => 
  array (
    'security_groups' => 'security_groups',
    'assignable' => 'assignable',
    'basic' => 'basic',
  ),
  'custom_fields' => false,
);
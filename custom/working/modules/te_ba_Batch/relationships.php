<?php
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 ********************************************************************************/

$relationships = array (
  'te_ba_batch_modified_user' => 
  array (
    'id' => '3cea8063-cdc9-d2e3-4bd6-57d9fa3b76f8',
    'relationship_name' => 'te_ba_batch_modified_user',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'te_ba_Batch',
    'rhs_table' => 'te_ba_batch',
    'rhs_key' => 'modified_user_id',
    'join_table' => NULL,
    'join_key_lhs' => NULL,
    'join_key_rhs' => NULL,
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => NULL,
    'relationship_role_column_value' => NULL,
    'reverse' => '0',
    'deleted' => '0',
    'readonly' => true,
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => true,
  ),
  'te_ba_batch_created_by' => 
  array (
    'id' => '3d118a7c-2136-c487-d867-57d9fa377a36',
    'relationship_name' => 'te_ba_batch_created_by',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'te_ba_Batch',
    'rhs_table' => 'te_ba_batch',
    'rhs_key' => 'created_by',
    'join_table' => NULL,
    'join_key_lhs' => NULL,
    'join_key_rhs' => NULL,
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => NULL,
    'relationship_role_column_value' => NULL,
    'reverse' => '0',
    'deleted' => '0',
    'readonly' => true,
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => true,
  ),
  'te_ba_batch_assigned_user' => 
  array (
    'id' => '3d353af4-584a-a2f2-544b-57d9fa62430a',
    'relationship_name' => 'te_ba_batch_assigned_user',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'te_ba_Batch',
    'rhs_table' => 'te_ba_batch',
    'rhs_key' => 'assigned_user_id',
    'join_table' => NULL,
    'join_key_lhs' => NULL,
    'join_key_rhs' => NULL,
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => NULL,
    'relationship_role_column_value' => NULL,
    'reverse' => '0',
    'deleted' => '0',
    'readonly' => true,
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => true,
  ),
  'securitygroups_te_ba_batch' => 
  array (
    'id' => '3d58e569-0183-2661-4536-57d9fa3850a7',
    'relationship_name' => 'securitygroups_te_ba_batch',
    'lhs_module' => 'SecurityGroups',
    'lhs_table' => 'securitygroups',
    'lhs_key' => 'id',
    'rhs_module' => 'te_ba_Batch',
    'rhs_table' => 'te_ba_batch',
    'rhs_key' => 'id',
    'join_table' => 'securitygroups_records',
    'join_key_lhs' => 'securitygroup_id',
    'join_key_rhs' => 'record_id',
    'relationship_type' => 'many-to-many',
    'relationship_role_column' => 'module',
    'relationship_role_column_value' => 'te_ba_Batch',
    'reverse' => '0',
    'deleted' => '0',
    'readonly' => true,
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => true,
  ),
  'te_in_institutes_te_ba_batch_1' => 
  array (
    'id' => '5cf1b252-c974-096b-fa1a-57d9fa2f8e93',
    'relationship_name' => 'te_in_institutes_te_ba_batch_1',
    'lhs_module' => 'te_in_institutes',
    'lhs_table' => 'te_in_institutes',
    'lhs_key' => 'id',
    'rhs_module' => 'te_ba_Batch',
    'rhs_table' => 'te_ba_batch',
    'rhs_key' => 'id',
    'join_table' => 'te_in_institutes_te_ba_batch_1_c',
    'join_key_lhs' => 'te_in_institutes_te_ba_batch_1te_in_institutes_ida',
    'join_key_rhs' => 'te_in_institutes_te_ba_batch_1te_ba_batch_idb',
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => NULL,
    'relationship_role_column_value' => NULL,
    'reverse' => '0',
    'deleted' => '0',
    'readonly' => true,
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'from_studio' => true,
    'is_custom' => true,
    'relationship_only' => false,
    'for_activities' => false,
  ),
  'te_pr_programs_te_ba_batch_1' => 
  array (
    'id' => '5dc396d1-4cf5-1f67-205e-57d9facbef50',
    'relationship_name' => 'te_pr_programs_te_ba_batch_1',
    'lhs_module' => 'te_pr_Programs',
    'lhs_table' => 'te_pr_programs',
    'lhs_key' => 'id',
    'rhs_module' => 'te_ba_Batch',
    'rhs_table' => 'te_ba_batch',
    'rhs_key' => 'id',
    'join_table' => 'te_pr_programs_te_ba_batch_1_c',
    'join_key_lhs' => 'te_pr_programs_te_ba_batch_1te_pr_programs_ida',
    'join_key_rhs' => 'te_pr_programs_te_ba_batch_1te_ba_batch_idb',
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => NULL,
    'relationship_role_column_value' => NULL,
    'reverse' => '0',
    'deleted' => '0',
    'readonly' => true,
    'rhs_subpanel' => 'default',
    'lhs_subpanel' => NULL,
    'from_studio' => true,
    'is_custom' => true,
    'relationship_only' => false,
    'for_activities' => false,
  ),
  'te_ba_batch_te_installments_1' => 
  array (
    'rhs_label' => 'Installments',
    'lhs_label' => 'Batch',
    'rhs_subpanel' => 'default',
    'lhs_module' => 'te_ba_Batch',
    'rhs_module' => 'te_installments',
    'relationship_type' => 'one-to-many',
    'readonly' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => true,
    'relationship_name' => 'te_ba_batch_te_installments_1',
  ),
);
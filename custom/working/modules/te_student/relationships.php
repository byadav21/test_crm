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
  'te_student_modified_user' => 
  array (
    'id' => 'f16e706c-a87d-a9c3-8692-58cbc6a266a3',
    'relationship_name' => 'te_student_modified_user',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'te_student',
    'rhs_table' => 'te_student',
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
  'te_student_created_by' => 
  array (
    'id' => 'f18a7579-e2e9-aae7-bb57-58cbc635d7e4',
    'relationship_name' => 'te_student_created_by',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'te_student',
    'rhs_table' => 'te_student',
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
  'te_student_assigned_user' => 
  array (
    'id' => 'f1a4140f-a981-0846-1f3b-58cbc61b889c',
    'relationship_name' => 'te_student_assigned_user',
    'lhs_module' => 'Users',
    'lhs_table' => 'users',
    'lhs_key' => 'id',
    'rhs_module' => 'te_student',
    'rhs_table' => 'te_student',
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
  'securitygroups_te_student' => 
  array (
    'id' => 'f1c82efc-616c-f105-3fa0-58cbc6e4047c',
    'relationship_name' => 'securitygroups_te_student',
    'lhs_module' => 'SecurityGroups',
    'lhs_table' => 'securitygroups',
    'lhs_key' => 'id',
    'rhs_module' => 'te_student',
    'rhs_table' => 'te_student',
    'rhs_key' => 'id',
    'join_table' => 'securitygroups_records',
    'join_key_lhs' => 'securitygroup_id',
    'join_key_rhs' => 'record_id',
    'relationship_type' => 'many-to-many',
    'relationship_role_column' => 'module',
    'relationship_role_column_value' => 'te_student',
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
  'te_student_te_student_study_kit_1' => 
  array (
    'id' => '334cc767-2efd-c74c-a37c-58cbc6cb26e9',
    'relationship_name' => 'te_student_te_student_study_kit_1',
    'lhs_module' => 'te_student',
    'lhs_table' => 'te_student',
    'lhs_key' => 'id',
    'rhs_module' => 'te_student_study_kit',
    'rhs_table' => 'te_student_study_kit',
    'rhs_key' => 'id',
    'join_table' => 'te_student_te_student_study_kit_1_c',
    'join_key_lhs' => 'te_student_te_student_study_kit_1te_student_ida',
    'join_key_rhs' => 'te_student_te_student_study_kit_1te_student_study_kit_idb',
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => NULL,
    'relationship_role_column_value' => NULL,
    'reverse' => '0',
    'deleted' => '0',
    'readonly' => true,
    'rhs_subpanel' => NULL,
    'lhs_subpanel' => NULL,
    'from_studio' => true,
    'is_custom' => true,
    'relationship_only' => false,
    'for_activities' => false,
  ),
  'te_student_te_student_payment_1' => 
  array (
    'id' => '33bf6cc7-c57a-1800-534b-58cbc6db8af4',
    'relationship_name' => 'te_student_te_student_payment_1',
    'lhs_module' => 'te_student',
    'lhs_table' => 'te_student',
    'lhs_key' => 'id',
    'rhs_module' => 'te_student_payment',
    'rhs_table' => 'te_student_payment',
    'rhs_key' => 'id',
    'join_table' => 'te_student_te_student_payment_1_c',
    'join_key_lhs' => 'te_student_te_student_payment_1te_student_ida',
    'join_key_rhs' => 'te_student_te_student_payment_1te_student_payment_idb',
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
  'te_student_te_student_batch_1' => 
  array (
    'id' => '3411a03f-33f4-ab7a-732c-58cbc6f85505',
    'relationship_name' => 'te_student_te_student_batch_1',
    'lhs_module' => 'te_student',
    'lhs_table' => 'te_student',
    'lhs_key' => 'id',
    'rhs_module' => 'te_student_batch',
    'rhs_table' => 'te_student_batch',
    'rhs_key' => 'id',
    'join_table' => 'te_student_te_student_batch_1_c',
    'join_key_lhs' => 'te_student_te_student_batch_1te_student_ida',
    'join_key_rhs' => 'te_student_te_student_batch_1te_student_batch_idb',
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
  'te_student_te_student_disposition_1' => 
  array (
    'rhs_label' => 'Student Notes',
    'lhs_label' => 'Student',
    'rhs_subpanel' => 'default',
    'lhs_module' => 'te_student',
    'rhs_module' => 'te_student_disposition',
    'relationship_type' => 'one-to-many',
    'readonly' => true,
    'deleted' => false,
    'relationship_only' => false,
    'for_activities' => false,
    'is_custom' => false,
    'from_studio' => true,
    'relationship_name' => 'te_student_te_student_disposition_1',
  ),
);
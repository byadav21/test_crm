<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

global $app_strings;
$dashletMeta['TargetVsActualBatchSizeDashlet'] = array('module'	=> 'te_vendor',
										  'title'       => 'Target VS Actual Enrollments for live batches', 
                                          'description' => 'Lead details associated with respected batch',
                                          'icon'        => 'icon_te_ba_Batch_32.gif',
                                          'category'    => 'Module Views');

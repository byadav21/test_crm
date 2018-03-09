<?php
if (!defined('sugarEntry') || !sugarEntry)die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');
class AOR_ReportsViewImportlead extends SugarView {
			public function __construct() {
					parent::SugarView();
				}
				/* To Display The Examschedules */
				public function getBatch(){
					global $db ,$current_user;
					$batchSql="SELECT b.id,b.batch_code from te_ba_batch AS b WHERE b.deleted=0 ";
					$batchObj     = $db->query($batchSql);
					$batchOptions = array();
					while ($row= $db->fetchByAssoc($batchObj))
					{
						$batchOptions[$row['batch_code']] = $row['id'];
					}
					return $batchOptions;
				}
				public function display(){
					//error_reporting(E_ALL);
					//ini_set('display_errors', 1);
					global $db ,$current_user;
					$logID=$current_user->id;  
					#Get Exam drop down option
					$selected_exams = '';
					$reportDataList=array();
					$search_date="";
					$index=0;
					$batchArr = $this->getBatch();
					if(isset($_POST['button']) && $_POST['button']=="Upload"){
								$errors= array();
								$fileCount = count($_FILES['files']['tmp_name']);
								//echo "<pre>";print_r($_FILES);exit();
								if($_FILES['files']['name']){
									$desired_dir="upload/lead_import_data/";
									$target_file = $desired_dir .  date('d_m_Y_H_i_s').ID.$logID . '_'. basename($_FILES["files"]["name"]);
										$file_tmp =$_FILES['files']['tmp_name'];
										if(is_dir($desired_dir)==false){
											 mkdir("$desired_dir", 0700);// Create directory if it does not exist
										}
										else{
											move_uploaded_file($file_tmp,$target_file);
											// comment
											$file = fopen($target_file,"r");
											$row = [];
											while (($data = fgetcsv($file, 1000, ","))!== FALSE) {
												if(!empty($data[0])){
													$row[] = $data;
												}	
											}
											$col = $row[0];
											$firstArr = [];
											$arr = [];
											$leads_cstm = [];
											//echo "<pre>";print_r($col);exit();
											if(count($row)>0){
												foreach($row as $rowval){
													foreach($col as $colkey=>$colval){
														if(!empty($rowval[$colkey])){
															
															if($colval!='batch_id'){
																$firstArr[$colkey]=$colval." = '".$rowval[$colkey]."'";
															}
															else{
																$batch = $rowval[$colkey];
																$id = $rowval[0];
															}
														}	
													}
													$arr[]=$firstArr;
													//Put if and check id and batch both
													$leads_cstm[]=array("id_c='".$id."'","te_ba_batch_id_c='".$batch."'");
													$firstArr = [];
													//$batch = '';
													//$id = '';
												}
												unset($arr[0]);
												unset($leads_cstm[0]);
												//echo '<pre>';
												//echo "<pre>";print_r($arr);print_r($leads_cstm);exit();
												foreach($arr as $bel=>$bkey){
												$mainlead=$imploded=implode(',',$bkey); 
												$sql="UPDATE leads SET $mainlead where $bkey[0];";
												#$GLOBALS['db']->query($sql);
												$leadtable = $db->query($sql);
												}
												if($leadtable){
												foreach($leads_cstm as $lcstm){
														$leadscstmimplod=$imploded=implode(',',$lcstm); 
														$sqllstm="UPDATE leads_cstm SET $leadscstmimplod where $lcstm[0];";
														#$GLOBALS['db']->query($sqllstm);
														$leadObjcstm = $db->query($sqllstm);
													}
												}
												
												#fclose($file);
												//exit();
												fclose($file);
											}
											if($leadObjcstm){
													echo '<script> alert("You have Successfully Updated CSV Data Thanks !");callPage(); function callPage(){ window.location.href="index.php?module=AOR_Reports&action=importlead"} </script>';
												exit();

													
												}
											else{
												echo "Error No Record found, for upload";exit();
											}							
										}	
										#echo "hello";
									}
								}
								$sugarSmarty = new Sugar_Smarty();
								$sugarSmarty->assign("examList",$examList);
								$sugarSmarty->assign("docsnum",$docsnum);
								$sugarSmarty->assign("documentifo",$documentifo);
								$sugarSmarty->display('custom/modules/AOR_Reports/tpls/importlead.tpl');
			}
		}
?>

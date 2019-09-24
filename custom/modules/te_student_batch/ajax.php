<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
error_reporting(E_ALL);
ini_set('display_errors', 'On');
global $app_list_strings, $current_user, $sugar_config, $db;

function getInstitutes()
{
    global $db;
    $batchSql     = "select id,name from te_in_institutes where deleted=0 order by name";
    $batchObj     = $db->query($batchSql);
    $batchOptions = array();
    while ($row          = $db->fetchByAssoc($batchObj))
    {
        $batchOptions[] = $row;
    }
    return $batchOptions;
}

function getBatch()
{
    global $db;
    $batchSql     = "SELECT b.id,b.name,b.batch_code,b.d_campaign_id,b.d_lead_id,b.batch_status,b.fees_inr,p.name AS program_name FROM te_ba_batch AS b INNER JOIN te_pr_programs_te_ba_batch_1_c AS pbr ON pbr.te_pr_programs_te_ba_batch_1te_ba_batch_idb=b.id INNER JOIN te_pr_programs AS p ON p.id=pbr.te_pr_programs_te_ba_batch_1te_pr_programs_ida WHERE  b.deleted=0 ORDER BY b.name";
    $batchObj     = $db->query($batchSql);
    $batchOptions = array();
    while ($row          = $db->fetchByAssoc($batchObj))
    {
        $batchOptions[$row['id']] = $row;
    }
    return $batchOptions;
}

function getProBatchName($action, $id)
{
    global $db;
    if (empty($id))
    {
        return array();
    }
    $where = "";
    if ($action == 'program_dropdown')
    {
        $where .= " and i.id='$id' order by p.name ";
    }
    if ($action == 'batch_dropdown')
    {
        $where .= " and p.id='$id' order by b.date_entered,b.batch_code";
    }
    $Sqlquery     = "SELECT 
                   b.batch_code,
                   b.name AS batchname,
                   b.id AS batchid,
                   p.name AS programname,
                   p.id AS programid
                   
            FROM `te_in_institutes` AS i
            INNER JOIN te_in_institutes_te_ba_batch_1_c AS ib ON ib.te_in_institutes_te_ba_batch_1te_in_institutes_ida=i.id
            INNER JOIN te_ba_batch AS b ON b.id=ib.te_in_institutes_te_ba_batch_1te_ba_batch_idb
            INNER JOIN te_pr_programs_te_ba_batch_1_c AS pb ON pb.te_pr_programs_te_ba_batch_1te_ba_batch_idb=b.id
            INNER JOIN te_pr_programs AS p ON p.id=pb.te_pr_programs_te_ba_batch_1te_pr_programs_ida
            WHERE i.deleted=0
              AND ib.deleted=0
              AND pb.deleted=0 $where";
    $batchObj     = $db->query($Sqlquery);
    $batchOptions = array();
    while ($row          = $db->fetchByAssoc($batchObj))
    {
        if ($action == 'program_dropdown')
        {
            $batchOptions[$row['programid']] = $row['programname'];
        }
        if ($action == 'batch_dropdown')
        {
            $batchOptions[$row['batchid']] = $row['batchname'] . ' (' . $row['batch_code'] . ')';
        }
    }
    //print_r($batchOptions);
    return $batchOptions;
}

if (isset($_POST['action']) && $_POST['action'] == 'showTransferPopup')
{
    //echo 'sss'; die;
    global $db;
    $option        = '';
    //RecordID: RecordID, RowID:RowID
    $getInstitutes = getInstitutes();
    $student_id    = $_POST['student_id'];
    
    function getInstProBatName($id)
    {
        global $db;

        $sql = " SELECT i.`name` AS insname,
                       i.id AS insid,
                       i.web_institute_id,
                       b.batch_code,
                       b.name AS batchname,
                       b.id AS batchid,
                       p.name AS programname,
                       p.id AS programid

                FROM `te_in_institutes` AS i
                INNER JOIN te_in_institutes_te_ba_batch_1_c AS ib ON ib.te_in_institutes_te_ba_batch_1te_in_institutes_ida=i.id
                INNER JOIN te_ba_batch AS b ON b.id=ib.te_in_institutes_te_ba_batch_1te_ba_batch_idb
                INNER JOIN te_pr_programs_te_ba_batch_1_c AS pb ON pb.te_pr_programs_te_ba_batch_1te_ba_batch_idb=b.id
                INNER JOIN te_pr_programs AS p ON p.id=pb.te_pr_programs_te_ba_batch_1te_pr_programs_ida
                WHERE i.deleted=0
                  AND ib.deleted=0
                  AND pb.deleted=0 and b.id='$id'";

        $itemDetal = $db->query($sql);
        return $db->fetchByAssoc($itemDetal);
    }

    function getStudentBatch($id)
    {
        global $db;

        $sql       = "SELECT  sb.te_pr_programs_id_c,
                        sb.id,
                        sb.te_ba_batch_id_c AS batch_id,
                        sb.name batch_name,
                        sb.batch_start_date,
                        te_student.id AS sid,
                        te_student.name,
                        te_student.email,
                        te_student.mobile,
                        te_student.status
                 FROM te_student_batch sb
                 INNER JOIN te_student_te_student_batch_1_c stb ON sb.id=stb.te_student_te_student_batch_1te_student_batch_idb
                 INNER JOIN te_student ON stb.te_student_te_student_batch_1te_student_ida=te_student.id
                 WHERE sb.deleted=0
                   AND sb.id='$id'";
        $itemDetal = $db->query($sql);
        return $db->fetchByAssoc($itemDetal);
    }

    $studentData = array();
    if ($student_id !== '')
    {
        $studentData = getStudentBatch($student_id);
        $oldRecords  = getInstProBatName($studentData['batch_id']);
    }
    ?>
<style>
    .modal-dialog{width:700px;}
    select{width:100%!important}
    textarea{width:100%!important; resize:none; height:90px;border-radius: 5px;}
    .marginTopBottom15{margin:15px 0;}
     .marginTop15{margin:15px 0 0;}
    .block-wrapper{display:flex; width:100%; padding:0 9px}
    .block{display:flex; flex-direction: column; margin-left: 15px; width:100%;}
    .block:first-child{margin-left:0px}
    .block-wrapper label{margin:0 15px 5px 0; display: flex; align-items: center;}
    .block div{display:flex; margin-bottom: 10px; align-items: flex-start;}
    .block div label{display:flex; margin-right:10px;}
    .block-wrapper input[type="radio"]{margin:0 5px 0 0;}
    .modal-title{margin-bottom:10px;}
    .borderWidthPadding{border:1px solid #ddd; padding:5px;}
</style>

    <div class="modal-dialog" style="overflow:visible">
        <form method="post"  id="formTrasferForm"  enctype="multipart/form-data">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Batch Transfer
                </h4>
            </div>
            <div class="modal-body">
                    <h5 class="modal-title">Student Details</h5>
                     <div class="block-wrapper borderWidthPadding">
                        <div class="block">
                            <div><label>Name : </label><?= $studentData['name'] ?></div>
                            <div><label>Email : </label> <?= $studentData['email'] ?></div>
                        </div>
                        <div class="block">
                            <div><label>Mobile : </label> <?= $studentData['mobile'] ?></div>
                            <div><label>Status : </label> <?= $studentData['status'] ?></div>
                        </div>
                    </div>
                
                 <h5 class="modal-title marginTop15">Current Course Details<h5/>
                <div class="block-wrapper borderWidthPadding">
                    
                    <div class="block">
                        <div><label>Institute Name : </label> <?= $oldRecords['insname'] ?></div>
                         <div><label>Programe Name : </label> <?= $oldRecords['programname'] ?></div>
                    </div>
                    <div class="block">
                         <div><label>Batch Name : </label> <?= $oldRecords['batchname'] ?></div>
                         <div><label>Batch Code : </label> <?= $oldRecords['batch_code'] ?></div>
                    </div>
                </div>
               
               <div class = "block-wrapper marginTop15">
                   <div class = "block">
                        <label>Select New Institute : </label>
                        <select name="institute_dropdown" id="institute_dropdown"  class="" style="">
                            <option value="">-Select-</option>
                            <?php
                            foreach ($getInstitutes as $key => $val)
                            {
                                $id   = $val['id'];
                                $name = $val['name'];
                                echo "<option value='$id'>$name</option>";
                            }
                            ?>
                        </select>

                    </div>
                    <div class = "block">
                        <label>Select New Program : </label>
                        <select name="program_dropdown" id="program_dropdown"  class=""  style="">
                            <option value="">-Select-</option>

                        </select>
                    </div>
                    <div class = "block">
                        <label>Select New Batch : </label>
                        <select name="batch_dropdown" id="batch_dropdown"  class=""  style="">
                            <option value="">-Select-</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 marginTopBottom15">
                    <textarea name="bt_srm_comments" id="bt_srm_comments">
                    </textarea>
                </div>   
                <div class="block-wrapper">
                        <label>Status</label>
                        <label><input type="radio" name="bt_fee_waiver" value="1" checked>Waiver</label>
                        <label><input type="radio" name="bt_fee_waiver" value="2">To be Adjusted</label>
                        <label><input type="radio" name="bt_fee_waiver" value="3">To be Paid</label>
                </div>
                     </br>     
                <div class="block-wrapper">
                        <label>Pre Dropped</label>
                        <input type="checkbox" name="bt_pre_dropped" value="1">
                </div>
                <br/>
                <div class = "block-wrapper">
                <input type="file" name="bt_attached_file" id="bt_attached_file" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf">
                <span>(Accepted format: xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf)</span>
                </div>
                
                

                <input type="hidden" name="te_student_batch_id" value="<?=$studentData['id'];?>">
                <input type="hidden" name="student_id" value="<?=$studentData['sid'];?>">
                <input type="hidden" name="old_batch_id" value="<?=$studentData['batch_id'];?>">
             
            
                
                
                <div class="col-sm-12 text-center" style="margin-top: 25px;">

                    <button type="submit" name="submit" class="button">TRANSFER</button>

                </div>

            </div>
        </div>
        </form>
    </div>
    <script>
        $(document).ready(function () {
            $(".multiselbox").each(function () {
                if ($(this).find("option").eq(0).val() == '') {
                    $(this).find("option").eq(0).remove();
                }
            })
            $(".multiselbox").multiselect({
                includeSelectAllOption: true
            });

            $("#institute_dropdown").change(function () {
                var InstID = $('#institute_dropdown').val();
                getAjax('program_dropdown', InstID);
            });

            $("#program_dropdown").change(function () {
                var proID = $('#program_dropdown').val();
                getAjax('batch_dropdown', proID);
            });
            
            
        });
            
             $("#formTrasferForm").on('submit', function(e){
                 
                    
                    var institute_dropdown = $('#institute_dropdown').val();
                    var program_dropdown = $('#program_dropdown').val();
                    var batch_dropdown = $('#batch_dropdown').val();
                    var bt_srm_comments = $('#bt_srm_comments').val();
                    var bt_attached_file = $('#bt_attached_file').val();
                    
                    if(institute_dropdown==''){
                        
                        alert("Please select a Institute."); return false;
                    }
                    else if(program_dropdown==''){
                        alert("Please select a Program."); return false;
                    }
                    else if(batch_dropdown==''){
                        alert("Please select a Batch."); return false;
                    } 
                    else if(bt_srm_comments==''){
                        alert("Please input your comment."); return false;
                    } 
                    //                    else if(bt_attached_file==''){
                    //                        alert("Please select a file."); return false;
                    //                    } 
                    
                    //var form = $("#formTrasferForm").get(0); 
                    var form = $('form').get(0); 
                     console.log(form);
                    var fd = new FormData(form);
                    //formData.append('file', $('input[type=file]')[0].files[0]);
                    //alert(new_batch_id);  return false;
                    
                    e.preventDefault();
                     $.ajax({
                        beforeSend: function (request)
                        {
                            SUGAR.ajaxUI.showLoadingPanel();
                        },
                        url: "index.php?module=te_student&action=transferbatchrequest&to_pdf=1",
                        type: "POST",
                        data:  new FormData(this),
                        contentType: false,
                        cache: false,
                        processData:false,
                        success: function (data) {
                            //alert(data.status);
                            var result = JSON.parse(data);	
                        if(result.status=='queued')
                            {           
                                    alert("The BT Request sent successuflly!");
                                    window.location.href="index.php?module=te_student_batch&action=index&parentTab=SRM";
                            }
                            else
                            {       console.log(result);
                                    alert(result.message);
                                    //toastr["error"]("something gone wrong. Please try again!");
                                    //$('.modal-body').css('pointer-events','all');
                                    //$('.modal-body').css('opacity','1');
                                    SUGAR.ajaxUI.hideLoadingPanel();
                                    return false;s
                            }
                        SUGAR.ajaxUI.hideLoadingPanel();
                        return false;
                        }
                    });
                    return false;
                    
              });
              
            
 
    </script>
    <?php
}

if (isset($_POST['action']) && $_POST['action'] == 'program_dropdown')
{
    $instID         = $_POST['ID'];
    $getProgramList = getProBatchName('program_dropdown', $instID);

    $option = "";
    $option .= "<option value=''>Select</option>";
    foreach ($getProgramList as $key => $val)
    {

        $option .= "<option value='$key'>$val</option>";
    }
    echo $option;
}

if (isset($_POST['action']) && $_POST['action'] == 'batch_dropdown')
{
    $proID      = $_POST['ID'];
    $getBatches = getProBatchName('batch_dropdown', $proID);

    $option = "";
    $option .= "<option value=''>Select</option>";
    foreach ($getBatches as $key => $val)
    {

        $option .= "<option value='$key'>$val</option>";
    }
    echo $option;
}
?>

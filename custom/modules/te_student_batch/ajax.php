<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
ini_set('display_errors', '1');

error_reporting(E_ALL);
global $app_list_strings, $current_user, $sugar_config, $db;

function getBatch()
{
    global $db;
    $batchSql     = "SELECT id,
                                name,
                                batch_code,
                                d_campaign_id,
                                d_lead_id
                         FROM te_ba_batch
                         WHERE batch_status='enrollment_in_progress'
                           AND deleted=0
                         ORDER BY name";
    $batchObj     = $db->query($batchSql);
    $batchOptions = array();
    while ($row          = $db->fetchByAssoc($batchObj))
    {
        $batchOptions[] = $row;
    }
    return $batchOptions;
}

if (isset($_POST['action']) && $_POST['action'] == 'showTransferPopup')
{

    global $db;
    $option        = '';
    //RecordID: RecordID, RowID:RowID
    $BatchListData = getBatch();
    $student_id    = $_POST['student_id'];

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
    }
    ?>

    <div class="modal-dialog" style="overflow:visible">
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
                <div class="col-sm-12">
                    <div class="col-sm-6">
                        <label>Name : </label> <?= $studentData['name'] ?>
                        <p>&nbsp;</p>
                        <label>Email : </label> <?= $studentData['email'] ?>
                    </div>
                    <div class="col-sm-6">
                        <label>Status : </label> <?= $studentData['status'] ?>
                        <p>&nbsp;</p>
                        <label>Batch : </label> <?= $studentData['batch_name'] ?>
                    </div>
                </div>
                <hr>
              
                <div class="col-sm-12">
                    <div class="col-sm-3">
                        <label>Select Institute : </label>
                        <select name="institute_dropdown" id="institute_dropdown"  class="" style="">
                            <option value="">--Select Institute--</option>
                            <option value=""> ddd</option>
                            <option value=""> XX</option>
                            <option value=""> YY</option>
                            <option value=""> ZZ</option>
                            <option value=""> CC</option>
                        </select>

                    </div>
                    <div class="col-sm-3"  >
                        <label>Select Program : </label>
                        <select name="program_dropdown" id="program_dropdown"  class=""  style="">
                            <option value="">--Select Program--</option>
                            <option value=""> ddd</option>
                            <option value=""> XX</option>
                            <option value=""> YY</option>
                            <option value=""> ZZ</option>
                            <option value=""> CC</option>

                        </select>
                    </div>
                    <div class="col-sm-3"  >
                        <label>Select Batch : </label>
                        <select name="batch_dropdown" id="batch_dropdown"  class=""  style="">
                            <option value="">--Select Batch--</option>
                            <option value=""> ddd</option>
                            <option value=""> XX</option>
                            <option value=""> YY</option>
                            <option value=""> ZZ</option>
                            <option value=""> CC</option>
                        </select>
                    </div>
                </div>
                <textarea rows="4" cols="50">
                           
                </textarea>

                <form action="/action_page.php">
                    <input type="file" name="pic" accept="image/*">
                    <input type="submit">
                </form>

                <div class="col-sm-12 text-center" style="margin-top: 25px;">

                    <button type="button" class="button" ng-click="doTransfer()">TRANSFER</button>

                </div>

            </div>
        </div>
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
        });
    </script>
    <?php
}
?>

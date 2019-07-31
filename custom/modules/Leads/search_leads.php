<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
error_reporting(E_ALL);
ini_set('display_errors', 1);
//include_once('modules/ACLRoles/ACLRole.php');
require_once('modules/ACLRoles/ACLRole.php');
global $db;
global $current_user;
$Us       = $current_user->id;
$acl_obj  = new ACLRole();
$misData  = $acl_obj->getUserSlug($current_user->id);
$whereSRM = '';
if ($misData['slug'] == 'SRM' || $misData['slug'] == 'SRE')
{
    $whereSRM   = 1;
    $displaySRM = true;
}

function createLog($action, $filename, $field = '', $dataArray = array())
{
    $file = fopen(str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']) . "upload/apilog/$filename", "a");
    fwrite($file, date('Y-m-d H:i:s') . "\n");
    fwrite($file, $action . "\n");
    fwrite($file, $field . "\n");
    fwrite($file, print_r($dataArray, TRUE) . "\n");
    fclose($file);
}
?>
<html>
    <title>CRM Lead Search</title>
    <head>
        <style>
            table {
                font-family: arial, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }
            td, th {
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }
            input[type=text], select {
                WIDTH: 132PX !IMPORTANT;
            }
            tr:nth-child(even) {
                background-color: #dddddd;
            }
            .switch {
                position: relative;
                display: inline-block;
                width: 48px;
                height: 20px;
                margin-bottom:0;
                margin-right: 10px;
            }

            .switch input { 
                opacity: 0;
                width: 0;
                height: 0;
            }

            .slider {
                position: absolute;
                cursor: pointer;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: #ccc;
                -webkit-transition: .4s;
                transition: .4s;
            }

            .slider:before {
                position: absolute;
                content: "";
                height: 15px;
                width: 15px;
                left: 4px;
                bottom: 3px;
                background-color: white;
                -webkit-transition: .4s;
                transition: .4s;
            }

            input:checked + .slider {
                background-color: #2196F3;
            }

            input:focus + .slider {
                box-shadow: 0 0 1px #2196F3;
            }

            input:checked + .slider:before {
                -webkit-transform: translateX(26px);
                -ms-transform: translateX(26px);
                transform: translateX(26px);
            }

            /* Rounded sliders */
            .slider.round {
                border-radius: 34px;
            }

            .slider.round:before {
                border-radius: 50%;
            }

            .block{display:flex; align-items: center; margin:20px 0}
            .block label + span{font-size: 14px; color:#4d4d4d; font-weight: bold;}
        </style>

    </head>
    <body>
        <h2>Search Leads</h2>
        <div class="block">
            <label class="switch"><input type="checkbox" id="openInstallmentForm"  onclick="openInstallmentForm()" >
                <span class="slider round"></span>
            </label>
            <span>Installment Follow-Up</span>
        </div>

        <div id="installment_followup">
            <section class="moduleTitle">
                <fieldset>
                    <form action="" method="post" id="follow_up_leads">

                        <table width="100%">
                            <tr>
                                <td><b>Email Name</b></td> 
                                <td><input type="text" name="followup_email" id="followup_email" class="inputy" /></td>
                                <td><b>Mobile Number</b></td> 
                                <td><input type="text" name="followup_mobile_number" id="followup_mobile_number" class="inputy" /></td> 
                                <td><input type="Submit" name="Search_Converted_LeadX" value="Search Lead"></td> 
                                </td></tr></br></br>
                        </table>       
                    </form>

                </fieldset>
            </section>
        </div>

        <div id="default_search">
            <section class="moduleTitle">
                <fieldset>
                    <form action="" method="post" id="default_lead_trans">

                        <table width="100%">
                            <tr>
                                <!---update code 5-dec-16 Manish Kumar-->
                                <td><b>First Name</b></td> 
                                <td><input type="text" name="first_name" id="first_name" class="inputx"/></td>
                                <td><b>Last Name</b></td> 
                                <td><input type="text" name="last_name" id="last_name" class="inputx"/></td>
                                <td><b>Email Name</b></td> 
                                <td><input type="text" name="email" id="email_id" class="inputx"/></td>
                                <td><b>Mobile Number</b></td> 
                                <td><input type="text" name="mobile_number" id="mobile_numbery" class="inputx"/></td> 
<!--                                <td><b>Lead ID</b></td> 
                                <td><input type="text" name="lead_id" id="lead_id" class="inputx"/></td> -->
                                <td><input type="Submit" name="Search_default_value" value="Search Lead"></td> 

                                </td></tr></br></br>
                        </table>       
                    </form>

                </fieldset>
            </section>
        </div>
        <br/>
        
    <div id="showFollowupList"></div>
    <div id="showDefaultList"></div>
</body>

<script>
    var Usrx = "<?= $Us; ?>";
    $(document).ready(function () {

        $("#installment_followup").hide();

        
        $("#default_lead_trans").on('submit', (function (e) {

            //class="inputy"
            event.preventDefault();
            var hasInput = false;
            $('.inputx').each(function () {
                if ($(this).val() !== "") {
                    hasInput = true;
                }
            });

            if (!hasInput) {
                alert("Need input!");
                return false;
            }

            $.ajax({
                beforeSend: function (request)
                {
                    SUGAR.ajaxUI.showLoadingPanel();
                },
                url: "index.php?entryPoint=accessleadajax",
                data: {action: 'seachLeadByDefaultSearch', first_name: $("#first_name").val(), last_name: $("#last_name").val(),email_id: $("#email_id").val(),mobile_number: $("#mobile_numbery").val()},
                dataType: "html",
                type: "POST",
                async: true,
                success: function (data) {


                    $("#showDefaultList").html(data);
                    SUGAR.ajaxUI.hideLoadingPanel();

                }
            });




            return false;
        }));
        
        $("#follow_up_leads").on('submit', (function (e) {

            //class="inputy"
            event.preventDefault();
            var hasInput = false;
            $('.inputy').each(function () {
                if ($(this).val() !== "") {
                    hasInput = true;
                }
            });

            if (!hasInput) {
                alert("Need input!");
                return false;
            }

            $.ajax({
                beforeSend: function (request)
                {
                    SUGAR.ajaxUI.showLoadingPanel();
                },
                url: "index.php?entryPoint=accessleadajax",
                data: {action: 'seachLeadByMobileFollowup', Email: $("#followup_email").val(), Mobile: $("#followup_mobile_number").val()},
                dataType: "html",
                type: "POST",
                async: true,
                success: function (data) {


                    $("#showFollowupList").html(data);
                    SUGAR.ajaxUI.hideLoadingPanel();

                }
            });




            return false;
        }));
    });

    function openInstallmentForm() {

        if ($("#openInstallmentForm").is(':checked') == true) {
            $("#default_search").hide();
            $("#default_table_result").hide();
            $("#installment_followup").show();
            $("#showFollowupList").show();
             $("#showDefaultList").hide();
            



        } else if ($("#openInstallmentForm").is(':checked') == false) {
            $("#default_search").show();
            $("#showDefaultList").show();
            $("#installment_followup").hide();
            $("#showFollowupList").hide();
            $("#default_table_result").show();


        }
    }

    function clickToCall(phone, lead_id) {
        if (confirm('Are you sure to make a call')) {
            SUGAR.ajaxUI.showLoadingPanel();
            var callback = {
                success: function (b) {
                    SUGAR.ajaxUI.hideLoadingPanel();
                    if (b.responseText)
                        swal(b.responseText);
                }
            }
            var connectionObject = YAHOO.util.Connect.asyncRequest('GET', 'index.php?entryPoint=clickToCall&lead=' + lead_id + '&number=' + phone + '&installment_followup_user=' + Usrx + '&installment_status=1', callback);
        }
    }

</script>

</html>
<?php ?>


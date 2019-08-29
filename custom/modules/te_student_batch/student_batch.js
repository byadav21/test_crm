$(document).ready(function () {
    /*$(window).load(function() {
     $('.id-ff').html('');
     $('.utils').html('');
     if($("#status").val() != "Dropout" ){
     document.getElementById("detailpanel_2").style.display ='none';
     }else{
     document.getElementById("detailpanel_2").style.display ='inline';
     }
     });
     $("#status").change(function() {
     if(this.value === "Dropout" ){
     document.getElementById("detailpanel_2").style.display ='inline';
     }else{
     document.getElementById("detailpanel_2").style.display ='none';
     }
     })*/
    $(".actionmenulinks a").eq(4).attr('target', '_blank');
    var new_conversion = $("input[name='new_conversion']").val();
    var is_new_dropout_basic = $("input[name='is_new_dropout_basic']").val(); //
    var callcenter_dropout = $("input[name='new_dropout']").val();


    if (callcenter_dropout == 1) {
        callcenterDropout();
    }

    if (new_conversion == 1) {
        newConversion();
    }

    if (is_new_dropout_basic == 1) {
        approvedDropout();
    }

    $("#total_payment").closest('tr').hide();
    $("#initial_payment_inr").closest('tr').hide();
    //$("#bt_fee_waiver").closest('tr').hide();
    var total_payment = $("#total_payment").text();
    var pending_payment = $("#initial_payment_inr").text();
    var feetype = $("#bt_fee_waiver").val();
    var msg='';
    //alert(feetype);
    if(feetype=='3'){
        msg='+ 5900 (Batch transfer fee)';
    }
    $("#list_subpanel_te_student_batch_te_student_payment_plan_1>table>tbody").last('tr').after("<tr><th colspan='8' style='border: 1px solid #ddd;font-weight: bold;font-size: 1.5em;text-align: right;'>Pending Amount(Excluding Tax): "+pending_payment+msg+" Total Payment: " + total_payment + "</th></tr>");
});


function newConversion() {

    $.ajax({
        async: false,
        type: "GET",
        data: {
            action2: 'updateLeads'
        },
        dataType: "json",
        url: 'index.php?action=seen&type=new_conversion&module=te_student_batch&is_new_basic=1&to_pdf=1',
        error: function (responseData) {
        },
        success: function (responseData)
        {

            if (responseData.status == 1) {

            }

        }
    });

}



function callcenterDropout() {

    $.ajax({
        async: false,
        type: "GET",
        data: {
            action2: 'updateDropout'
        },
        dataType: "json",
        url: 'index.php?action=seen&type=new_call_dropout&module=te_student_batch&is_new_dropout_basic=1&to_pdf=1',
        error: function (responseData) {
        },
        success: function (responseData)
        {
            alert(responseData);
            return false;
            if (responseData.status == 1) {

            }

        }
    });

}
// transfer function is on transfer batch

function approvedDropout() {

    $.ajax({
        async: false,
        type: "GET",
        data: {
            action2: 'updateDropout'
        },
        dataType: "json",
        url: 'index.php?action=seen&type=approved_dropout&module=te_student_batch&is_new_dropout_basic=1&to_pdf=1',
        error: function (responseData) {
        },
        success: function (responseData)
        {

            if (responseData.status == 1) {

            }

        }
    });

}

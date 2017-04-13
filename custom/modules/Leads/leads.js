/*Author: Pawan*/
$(document).ready(function () {
    $(".actionmenulinks a").eq(4).attr('target', '_blank');
    var is_new_dropout = $("input[name='is_new_dropout_basic']").val();
    if (is_new_dropout == 1) {
        updateNewDropout();
    }

});

function updateNewDropout() {

    $.ajax({
        async: false,
        type: "GET",
        data: {
            action2: 'updateDropout'
        },
        dataType: "json",
        url: 'index.php?action=seen&type=new_call_dropout&module=te_student_batch&is_new_dropout_basic=1',
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

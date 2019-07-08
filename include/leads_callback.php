<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
if (isset($_REQUEST['redirect']) && !empty($_REQUEST['redirect']) && isset($_REQUEST['id']) && !empty($_REQUEST['id']) && isset($_REQUEST['lead_id']) && !empty($_REQUEST['lead_id']))
{
    global $db;
    $id           = $_REQUEST['id'];
    $lead_id      = $_REQUEST['lead_id'];
    $call_backSql = "UPDATE callback_log SET is_seen=1 WHERE id=$id";
    $call_backObj = $db->query($call_backSql);
    header("Location: index.php?module=Leads&action=DetailView&record=$lead_id");
    die();
}

function callbackdata()
{
    global $db, $current_user;
    $call_backSql     = "SELECT c.id,
                                    c.lead_id,
                                    c.status_description,
                                    c.callback_date_time,
                                    l.first_name,
                                    l.phone_mobile,
                                    te_ba_batch.batch_code
                                    
                             FROM callback_log AS c
                             INNER JOIN leads AS l ON l.id=c.lead_id
                             INNER JOIN leads_cstm ON l.id= leads_cstm.id_c
                             INNER JOIN te_ba_batch ON leads_cstm.te_ba_batch_id_c= te_ba_batch.id
                             WHERE c.is_seen=0
                               AND te_ba_batch.deleted=0
                               AND c.deleted=0
                               AND DATE(c.callback_date_time)<='" . date('Y-m-d') . "'
                               AND c.assigned_user_id='" . $current_user->id . "'
                             LIMIT 0,
                                   30";
    $call_backObj     = $db->query($call_backSql);
    $call_backOptions = array();
    while ($row              = $db->fetchByAssoc($call_backObj))
    {
        $call_backOptions[] = $row;
    }
    return $call_backOptions;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>

    <body>
        <div class="container">

            <div class="panel panel-primary callback-listing">
                <div class="panel-heading">Callback Reminder</div>
                <ol>
                <?php
                $datax = callbackdata();

                //print_r($datax); 
                $i=1;
                foreach ($datax as $val)
                {
                    ?>
                <li class="" id="<?= 'call_'.$val['lead_id'].'_'.$i ?>">
                    <div>
                        <a href="index.php?action=DetailView&module=Leads&record=<?=$val['lead_id'];?>"><strong><?php echo $val['first_name']; ?></strong></a> 
                        <span> Pawan Pawan Pawan Pawan Pawan Pawan(<?= $val['batch_code'] ?>)</span>
                        <?php echo $val['callback_date_time']; ?>
                    </div>    
                    <div>
                        <img src="custom/themes/default/images/phone.png" href="" onclick="clickToCall(<?= $val['phone_mobile'] ?>, '<?= $val['lead_id'] ?>')" alt="Smiley face" height="20" width="20">
                        <a href="javascript:void(0)" onclick="dissmisscallback('<?= 'call_'.$val['lead_id'].'_'.$i ?>','<?=$val['lead_id']?>','<?=$val['callback_date_time']?>')" title="Dismiss"><i class="fa fa-times-circle"></i></a>
                    </div>
                </li>

               
                   

                <?php
                $i++;
                
                }
                ?>
                </ol>          
            </div>
        </div>
        <style>
            .callback-listing{display:flex; flex-direction: column; width:100%;}
            .callback-listing ol{display:flex; flex-direction: column; width:100%; margin:0; padding:0;}
            .callback-listing ol li{display:flex; justify-content: space-between; width:100%; border-bottom:1px solid #ddd; margin:0px 0 0px; padding:10px;}
            .callback-listing ol li:hover{background-color: #f7f4f4;}
            .callback-listing ol li div:first-child{display:flex; flex-direction:column}
            .callback-listing ol li div:first-child span{color:#999;margin-bottom: 5px;}
            .callback-listing ol li div:first-child a{text-decoration: underline; margin-bottom: 5px; font-size: 12px;}
            .callback-listing ol li div:first-child a:hover{text-decoration: none; font-size: 12px;}
            .callback-listing ol li div:last-child{display:flex;}
            .callback-listing ol li div:last-child img{display:flex; margin-right: 10px;}
            .callback-listing ol li div:last-child a{text-decoration: underline; font-size: 12px;}
            .callback-listing ol li div:last-child a:hover{text-decoration: none; font-size: 12px;}
            .scrll {float:left;
                    width:1000px;
                    overflow-y: auto;
                    height: 100px;}
        </style>

        <script>
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
                    var connectionObject = YAHOO.util.Connect.asyncRequest('GET', 'index.php?entryPoint=clickToCall&lead=' + lead_id + '&number=' + phone, callback);
                }
            }
            
            function dissmisscallback(dismissID,leadID,CallTime){
                //alert(CallTime);
                
                if (confirm("Are you sure you want to delete?")) {
                    
                    $.ajax({
                    beforeSend: function (request)
                    {
                        //request.setRequestHeader("OAuth-Token", SUGAR.App.api.getOAuthToken());
                    },
                    url: "index.php?entryPoint=reportsajax",
                    data: {action: 'dissmisscallback', leadID: leadID, CallTime:CallTime,dismissID:dismissID},
                    dataType: "html",
                    type: "POST",
                    async: true,
                    success: function (data) {
                        $('#'+dismissID).html('');
                        }
                    });
                
                }
                return false;
                
                //$('#'+dismissID).html('');
            }
        </script>
    </body>
</html>

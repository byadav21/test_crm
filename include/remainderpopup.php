<?php
/* * *******************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2016 Salesagility Ltd.
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
 * ****************************************************************************** */

class remainderpopup
{

    function __get_userPopup()
    {
        global $db, $current_user;
        $todayFrom        = date('Y-m-d 00:00:00');
        $todayTo          = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' + 15 minute'));
        $call_backSql     = "SELECT c.id,
                                    c.lead_id,
                                    c.callback_date_time,
                                    l.first_name
                             FROM callback_log AS c
                             INNER JOIN leads AS l ON l.id=c.lead_id
                             WHERE c.is_seen=0
                               AND c.deleted=0
                               AND date(c.callback_date_time) ='" . date('Y-m-d') . "'
                               AND c.assigned_user_id='" . $current_user->id . "'
                               order by c.callback_date_time limit 50";
        $call_backObj     = $db->query($call_backSql);
        $call_backOptions = array();
        while ($row              = $db->fetchByAssoc($call_backObj))
        {
            $call_backOptions[] = $row;
        }
        return $call_backOptions;
    }

    function __get_user_callback()
    {
        global $db, $current_user;
        date_default_timezone_set('Asia/Calcutta');
        $todayFrom        = date('Y-m-d 00:00:00');
        $todayTo          = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' + 15 minute'));
        //echo $todayFrom." - ".$todayTo;exit();
        $call_backSql     = "SELECT c.id,
                                   c.lead_id,
                                   c.status_description,
                                   date(c.callback_date_time)callback_date,
                                   c.callback_date_time,
                                   c.id callbackID,
                                   l.first_name,
                                   l.last_name,
                                   l.phone_mobile,
                                   b.name AS batch
                            FROM callback_log AS c
                            INNER JOIN leads AS l ON l.id=c.lead_id
                            INNER JOIN leads_cstm AS lc ON l.id = lc.id_c
                            LEFT JOIN te_ba_batch AS b ON b.id = lc.te_ba_batch_id_c
                            WHERE c.is_seen=0
                              AND c.deleted=0
                              AND date(c.callback_date_time) <='" . date('Y-m-d') . "'
                              AND c.assigned_user_id='" . $current_user->id . "'
                            ORDER BY c.callback_date_time limit 50";
        //echo $call_backSql;exit();
        $call_backObj     = $db->query($call_backSql);
        $call_backOptions = array();
        while ($row              = $db->fetchByAssoc($call_backObj))
        {
            if ($row['callback_date'] == date('Y-m-d'))
            {
                $call_backOptions['today'][] = $row;
            }
            else if ($todayTo > $row['callback_date_time'])
            {
                $call_backOptions['overdue'][] = $row;
            }
        }
        return $call_backOptions;
    }
    
    function cleanString($string) {
       // $string = str_replace(' ', ' ', $string); // Replaces all spaces with hyphens.

        return preg_replace('/[^a-zA-Z0-9_ -]/s','',$string);
     }

    function load_js($event, $arguments)
    {
        global $db, $current_user;
	if($current_user->is_admin == 1){
            //echo 'You no need it!';
            return;
        };
        $datax         = $this->__get_userPopup();
        $data          = $this->__get_user_callback();
        $overdue_count = (isset($data['overdue'])) ? count($data['overdue']) : 0;
        $today_count   = (isset($data['today'])) ? count($data['today']) : 0;
        $overdue_arr   = (isset($data['overdue'])) ? $data['overdue'] : [];
        $today_arr     = (isset($data['today'])) ? $data['today'] : [];
        $overdue       = "<div class='list-content'>No Result Found!</div>";
        $today         = "<div class='list-content'>No Result Found!</div>";
        if ($overdue_count > 0)
        {
            $overdue = "";
            $i       = 1;
            foreach ($overdue_arr as $val)
            {
                $leadIDx    = 'overdue_' . $val['lead_id'] . '_' . $i;
                $lead_id    = $val['lead_id'];
                $callBack   = $val['callback_date_time'];
                $callbackID = $val['callbackID'];
                $onClick    = "onclick=dissmisscallback('$callbackID')";
                $nameFN     = $val['first_name'].' '.$val['last_name'];
                $nameFN     = $this->cleanString($nameFN);
                $Batchname  = $this->cleanString($val['batch']);

                $overdue .= "<div id='$callbackID'><div class='list-content'><div><p><a href='index.php?action=DetailView&module=Leads&record=$lead_id' target='_blank'>".$nameFN. "</a></p>";
                $overdue .= "<p>" . $Batchname . "</p>";
                $overdue .= "<p>" . $callBack . "</p></div>";
                $overdue .= "<div><p class='dismiss_p'><a href='javascript:void(0)' $onClick title='Dismiss'><i class='fa fa-times-circle'></i></a></p></div></div></div>";

                $i++;
            }
        }
        if ($today_count > 0)
        {
            $today = "";
            $i     = 1;
            foreach ($today_arr as $val)
            {
                $leadIDx    = 'overdue_' . $val['lead_id'] . '_' . $i;
                $lead_id    = $val['lead_id'];
                $callBack   = $val['callback_date_time'];
                $callbackID = $val['callbackID'];
                $onClick    = "onclick=dissmisscallback('$callbackID')";
                $nameFN     = $val['first_name'].' '.$val['last_name'];
                $nameFN     = $this->cleanString($nameFN);
                $Batchname     = $this->cleanString($val['batch']);

                $today .= "<div id='$callbackID'> <div class='list-content'><div><p><a href='index.php?action=DetailView&module=Leads&record=$lead_id' target='_blank'>".$nameFN."</a></p>";
                $today .= "<p>" . $Batchname . "</p>";
                $today .= "<p>" . $val['callback_date_time'] . "</p>";
                $today .= "<p class='dismiss_p'><a href='javascript:void(0)' $onClick title='Dismiss'><i class='fa fa-times-circle'></i></a></p></div></div></div>";
                $i++;
            }
        }


        $json_data = json_encode($datax);
        $popup_url = $GLOBALS['sugar_config']['site_url'] . "/index.php?entryPoint=leads_callback";
        ?>
        <script type="text/javascript">
            var userID = "<?=$current_user->id;?>";
            var t1 =<?php echo $json_data ?>;
            var popup_url = "<?php echo $popup_url ?>";

            var todayCount = "<?php echo $today_count ?>";
            var OverdueCount = "<?php echo $overdue_count ?>";
            var Overdue = "<?php echo $overdue ?>";
            var today = "<?php echo $today ?>";
            $(function () {
                var total = parseInt(todayCount) + parseInt(OverdueCount);
                $(".notifications_alert_count").text(total);
                $("#today_tab").text('Today (' + todayCount + ')');
                $("#overdue_tab").text('Overdue (' + OverdueCount + ')');
                $("#todayMenu").html(today);
                $("#prvMenu").html(Overdue);
            });

            if (t1.length > 0) {
                t1 = JSON.stringify(t1);
                localStorage.setItem("call_back", t1);
            } else {
                localStorage.setItem("call_back", '');
            }

            $(function () {
                $(".info-number").click(function () {
                    $("#notifications_alerts").toggle();
                });

            });

            function dissmisscallback(callbackID) {
                //alert(CallTime);

                //if (confirm("Are you sure you want to delete?")) {

                    $.ajax({
                        beforeSend: function (request)
                        {
                            //request.setRequestHeader("OAuth-Token", SUGAR.App.api.getOAuthToken());
                        },
                        url: "index.php?entryPoint=reportsajax",
                        data: {action: 'dissmissremainderPop', callbackID: callbackID,userID:userID},
                        dataType: "html",
                        type: "POST",
                        async: true,
                        success: function (data) {
                            //alert(data);
                            callobj = JSON.parse(data);
                            
                            $(".notifications_alert_count").text(callobj.total);
                            $("#today_tab").text('Today (' + callobj.today + ')');
                            $("#overdue_tab").text('Overdue (' + callobj.overdue + ')');
                            $('#' + callbackID).html('');
                        }
                    });

                //}
                return false;

                //$('#'+dismissID).html('');
            }

        //var d1 = new Date("2018-09-03 17:45:00");
        //var d2 = new Date();
        //alert(d1);
        //alert(d2);
        //if(diff_minutes(d2,d1)>=-15){alert('Hi'+diff_minutes(d2,d1));}
            function diff_minutes(dt2, dt1)
            {

                return Math.round((dt2.getTime() - dt1.getTime()) / 60000);

            }
            /*setInterval(function() {
             alert(localStorage.getItem("call_back"));
             }, 10 * 1000);*/

            function fn60sec() {
                var callback_data = JSON.parse(localStorage.getItem("call_back"));
                var lead_url = '';


                for (var i = 0; i < callback_data.length; i++) {
                    var d2 = new Date();
                    var d1 = new Date(callback_data[i].callback_date_time);
                    if (diff_minutes(d2, d1) >= -60) {
        //		lead_url ="&lead_id="+callback_data[i].lead_id;
        //		lead_url +="&id="+callback_data[i].id;
        //		lead_url +="&first_name="+callback_data[i].first_name;
        //		lead_url +="&callback_date_time="+callback_data[i].callback_date_time;
        //		lead_url +="&status_description="+callback_data[i].status_description;
        //		
                        window.open(popup_url, "popupWindow", "width=600,height=600,scrollbars=yes");
                        //console.log(popup_url);
                        break;
                    }
                }

            }
        //fn60sec();
            setInterval(fn60sec, 600 * 1000);
        </script>
        <?php
        /* echo '<script type="text/javascript">
          $(window).on("load",function(){
          window.open("http://google.com", "popupWindow", "width=600,height=600,scrollbars=yes");
          });
          </script>'; */
    }

}
?>

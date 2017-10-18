<?php
ini_set('display_errors', 'off');
require_once ('include/MVC/View/views/view.edit.php');

class LeadsViewEdit extends ViewEdit
{

    public function preDisplay()
    {
        $metadataFile = $this->getMetaDataFile();
        $this->ev     = $this->getEditView();
        $this->ev->ss = & $this->ss;
        $this->ev->setup($this->module, $this->bean, $metadataFile, 'custom/modules/Leads/tpls/EditView.tpl');
    }

    function display()
    {
        //print_r($_REQUEST);
        global $current_user, $app_strings;
        $disableBatch = false;
        if (!is_admin($current_user) && !empty($this->bean->id))
        {

            //check users
            self::$reporters[] = $this->bean->assigned_user_id;
            self::getUsers($this->bean->assigned_user_id);
            if (!in_array($current_user->id, self::$reporters))
            {
                echo 'You have not access to view this record';
                exit();
            }
            require_once('modules/ACLRoles/ACLRole.php');
            $acl_obj      = new ACLRole();
            $misData      = $acl_obj->getUserSlug($current_user->id);
            if ($misData['slug'] == 'CCC' || $misData['slug'] == 'CCTL')
                $disableBatch = true;
            if ($disableBatch)
            {
                ?>        
                <style>
                    #btn_batch_c,#btn_clr_batch_c{display:none;pointer-events: none;}
                    #batch_c{pointer-events: none;}
                </style>
                <script>
                    $('#btn_batch_c,#btn_clr_batch_c').remove();
                </script> <?php
            }
        }
        ?>	
        <script>
            YAHOO.util.Event.addListener(window, "load", function () {
                document.getElementById('btn_batch_c').onclick = function () {
                    var popup_request_data = {
                        'call_back_function': 'set_rfq_return',
                        'form_name': 'EditView',
                        'field_to_name_array': {
                            'id': 'id',
                            'name': 'name',
                        },
                    };
                    open_popup('te_ba_Batch', 600, 400, '&batch_status_advanced[0]=Planned&batch_status_advanced[1]=enrollment_in_progress', true, false, popup_request_data);
                }
            });
            function set_rfq_return(popup_reply_data) {
                var name_to_value_array = popup_reply_data.name_to_value_array;
                var id = name_to_value_array['id'];
                var name = name_to_value_array['name'];
                document.getElementById('batch_c').value = name;
                document.getElementById('te_ba_batch_id_c').value = id;
            }
        </script>
        <?php
        $countries_list = '';
        foreach ($GLOBALS['app_list_strings']['countries_list'] as $key => $val)
        {
            $countries_list .= '<option value="' . $key . '"';
            if ($this->bean->country_log == $key)
                $countries_list .= ' selected ';
            $countries_list .= ' >' . $val . '</option>';
        }
        //echo $this->bean->primary_address_state;
        $state_list = '';
        foreach ($GLOBALS['app_list_strings']['indian_states'] as $key => $val)
        {
            $state_list .= '<option value="' . $key . '"';
            if ($this->bean->primary_address_state == $key)
                $state_list .= ' selected ';
            $state_list .= ' >' . $val . '</option>';
        }
        
        //added hidden box for lead check
        echo "<input type='hidden' id='CheckEditView' value='".$_REQUEST['record']."'>"; 
        
        //print_r($GLOBALS['app_list_strings']['indian_states']); die;

        $this->ss->assign('countries_list', $countries_list);
        $this->ss->assign('state_list', $state_list);
        $this->ss->assign('disableBatch', $disableBatch);
        $this->ss->assign('disableDisposition', '0');
        $this->ss->assign('recID', $this->bean->id);
        if (isset($_SESSION['currentCall']) && !empty($_SESSION['currentCall']))
        {
            $this->ss->assign('disableDisposition', '1');
        }

        if (isset($_REQUEST['from_pusher']))
        {
            $this->ss->assign('from_pusher', '1');
            $this->ss->assign('disposition_id', $_REQUEST['disposition_id']);
            ?>
            <script>
                $(document).ready(function () { /* code here */
                    document.getElementById("SAVE_FOOTER").style.display = 'none';

                });
            </script>

            <?php
        }
        else
        {
            $this->ss->assign('from_pusher', '0');
        }
        ?>
        <style>.dcQuickEdit{display:none!important}</style>
        <script>


            $(document).ready(function () {
                $("#primary_address_country_label").text('');
                $("#primary_address_state").replaceWith('<select id="primary_address_state" name="primary_address_state" class="ProductDetailsQuantityTextBox"><?php
                                    $state_list='<option value="0">Select State</option>';
                                    foreach ($GLOBALS['app_list_strings']['indian_states'] as $key => $val)
                                    {   
                                        
                                        $state_list .= '<option value="' . $key . '"';
                                        if ($this->bean->primary_address_state == $key)
                                            $state_list .= ' selected ';
                                          $state_list .= ' >' . $val . '</option>';
                                    }
                                    echo $state_list;
                                    ?></select>');
                $('#primary_address_country').hide();
                
                $('#country_log').change(function () {
                    if ($('#country_log').val() == 'Other') {
                        $('#primary_address_country').show();

                        $('#primary_address_state').replaceWith($('<input/>', {'type': 'text', 'size': '30', 'maxlength': '225', 'id': 'primary_address_state'}));
                        $("#primary_address_country_label").text('Country:');

                    } else if ($('#country_log').val() == 'India') {
                        $('#primary_address_country').hide();
                        $("#primary_address_state")
                                .replaceWith('<select id="primary_address_state" name="primary_address_state" class="ProductDetailsQuantityTextBox"><?php
                                    $state_list='<option value="0">Select State</option>';
                                    foreach ($GLOBALS['app_list_strings']['indian_states'] as $key => $val)
                                    {
                                        $state_list .= '<option value="' . $key . '"';
                                        if ($this->bean->primary_address_state == $key)
                                            $state_list .= ' selected ';
                                         $state_list .=  ' >' . $val . '</option>';
                                    }
                                    echo $state_list;
                                    ?></select>');

                        $("#primary_address_country_label").text('');

                    }
                    
                     
                    
                });
                
              


                //Lead Referral hide /show
                //~ if(document.getElementById('lead_source').value!='Referrals' && document.getElementById('leads_leads_1leads_ida').value==''){
                //~
                //~ document.getElementById("leads_leads_1_name").style.display ='none';
                //~ document.getElementById("btn_clr_leads_leads_1_name").style.display ='none';
                //~ document.getElementById("btn_leads_leads_1_name").style.display ='none';
                //~ document.getElementById("leads_leads_1_name_label").innerHTML='';
                //~
                //~ }
                //~ if(document.getElementById('leads_leads_1leads_ida').value!=''){
                //~ document.getElementById('lead_source').value='Referrals'
                //~ }
                //~ var refere = document.getElementById("leads_leads_1leads_ida").value;
                //~ $("#lead_source").change(function() {
                //~ var ls = $(this) ;
                //~ if(ls.val() === "Referrals" ) {
                //~ document.getElementById("leads_leads_1_name").style.display ='inline';
                //~ document.getElementById("btn_leads_leads_1_name").style.display ='inline';
                //~ document.getElementById("btn_clr_leads_leads_1_name").style.display ='inline';
                //~ document.getElementById("leads_leads_1_name_label").innerHTML = 'Referral Lead:';
                //~ document.getElementById("leads_leads_1leads_ida").value = refere;
                //~ }
                //~ else{
                //~ document.getElementById("leads_leads_1leads_ida").value ='';
                //~ document.getElementById("leads_leads_1_name").value ='';
                //~ document.getElementById("leads_leads_1_name").style.display ='none';
                //~ document.getElementById("btn_clr_leads_leads_1_name").style.display ='none';
                //~ document.getElementById("btn_leads_leads_1_name").style.display ='none';
                //~ document.getElementById("leads_leads_1_name_label").innerHTML='';
        //~
                //~ }
                //~ })
                //~
                $("td#date_of_prospect_label").next().prop('colspan', '0');
                if (document.getElementById('lead_source').value != 'Referrals' && document.getElementById('parent_id').value == '') {

                    document.getElementById("parent_type").style.display = 'none';
                    document.getElementById("parent_name").style.display = 'none';
                    document.getElementById("btn_parent_name").style.display = 'none';
                    document.getElementById("btn_clr_parent_name").style.display = 'none';
                    document.getElementById("parent_name_label").innerHTML = '';

                }
                if (document.getElementById('parent_id').value != '') {
                    document.getElementById('lead_source').value = 'Referrals'
                }
                var refere = document.getElementById("parent_id").value;
                $("#lead_source").change(function () {
                    var ls = $(this);
                    if (ls.val() === "Referrals") {
                        document.getElementById("parent_type").style.display = 'inline';
                        document.getElementById("parent_name").style.display = 'inline';
                        document.getElementById("btn_parent_name").style.display = 'inline';
                        document.getElementById("btn_clr_parent_name").style.display = 'inline';
                        document.getElementById("parent_name_label").innerHTML = 'Referral:';
                        document.getElementById("parent_id").value = refere;
                    } else {
                        document.getElementById("parent_id").value = '';
                        document.getElementById("parent_name").value = '';
                        document.getElementById("parent_type").style.display = 'none';
                        document.getElementById("parent_name").style.display = 'none';
                        document.getElementById("btn_parent_name").style.display = 'none';
                        document.getElementById("btn_clr_parent_name").style.display = 'none';
                        document.getElementById("parent_name_label").innerHTML = '';
                    }
                })


                // Status detail dependant drop down
                if (document.getElementById('status_description').value != "Converted") {
                    document.getElementById("detailpanel_2").style.display = 'none';
                }
                var option = document.getElementById("status").options;
                var status_detail = document.getElementById('status_description').value;

                if (document.getElementById('status').value == "Alive") {
                    $("#status_description option").remove();
                    $("#status_description").append('<option></option>');

                    /*if (status_detail == 'Call Back') {
                        $("#status_description").append('<option value="Call Back" selected="selected" >Call Back</option>');
                    } else {
                        $("#status_description").append('<option value="Call Back" >Call Back</option>');
                    }*/
                    if (status_detail == 'Follow Up') {
                        $("#status_description").append('<option value="Follow Up" selected="selected">Follow Up</option>');
                    } else {
                        $("#status_description").append('<option value="Follow Up" >Follow Up</option>');
                    }

                    if (status_detail == 'New Lead') {
                        $("#status_description").append('<option  value="New Lead" selected="selected" >New Lead</option>');
                    } else {
                        $("#status_description").append('<option  value="New Lead" >New Lead</option>');
                    }
                }
                if (document.getElementById('status').value == "Dead") {
                    //~ alert(status_detail)
                    $("#status_description option").remove();
                    $("#status_description").append('<option></option>');
                    if (status_detail == 'Dead Number') {
                        $("#status_description").append('<option  selected="selected" >Dead Number</option>');
                    } else {
                        $("#status_description").append('<option>Dead Number</option>');
                    }
                    if (status_detail == 'Wrong Number') {
                        $("#status_description").append('<option  selected="selected" >Wrong Number</option>');
                    } else {
                        $("#status_description").append('<option >Wrong Number</option>');
                    }
                    if (status_detail == 'Ringing Multiple Times') {
                        $("#status_description").append('<option  selected="selected" >Ringing Multiple Times</option>');
                    } else {
                        $("#status_description").append('<option>Ringing Multiple Times</option>');
                    }
                    if (status_detail == 'Not Enquired') {
                        $("#status_description").append('<option  selected="selected" >Not Enquired</option>');
                    } else {
                        $("#status_description").append('<option>Not Enquired</option>');
                    }
                    if (status_detail == 'Not Eligible') {
                        $("#status_description").append('<option  selected="selected" >Not Eligible</option>');
                    } else {
                        $("#status_description").append('<option>Not Eligible</option>');
                    }
                    /*if (status_detail == 'Rejected') {
                        $("#status_description").append('<option  selected="selected" >Rejected</option>');
                    } else {
                        $("#status_description").append('<option>Rejected</option>');
                    }*/
                    if (status_detail == 'Fallout') {
                        $("#status_description").append('<option  selected="selected" >Fallout</option>');
                    } else {
                        $("#status_description").append('<option >Fallout</option>');
                    }
                    /*if (status_detail == 'Retired') {
                        $("#status_description").append('<option  selected="selected" >Retired</option>');
                    } else {
                        $("#status_description").append('<option>Retired</option>');
                    }*/
                }
                if (document.getElementById('status').value == "Converted") {
                    $("#status_description option").remove();
                    $("#status_description").append('<option></option>');
                    if (status_detail == 'Converted') {
                        $("#status_description").append('<option  selected="selected">Converted</option>');
                    } else {
                        $("#status_description").append('<option>Converted</option>');
                    }
                }

                if (document.getElementById('status').value == "Recycle") {
                    $("#status_description option").remove();
                    $("#status_description").append('<option></option>');
                    if (status_detail == 'Duplicate') {
                        $("#status_description").append('<option  selected="selected">Recycle</option>');
                    } else {
                        $("#status_description").append('<option>Recycle</option>');
                    }
                }

                if (document.getElementById('status').value == "Duplicate") {
                    $("#status_description option").remove();
                    $("#status_description").append('<option></option>');
                    if (status_detail == 'Duplicate') {
                        $("#status_description").append('<option  selected="selected">Duplicate</option>');
                    } else {
                        $("#status_description").append('<option>Duplicate</option>');
                    }
                }


                if (document.getElementById('status').value == "Warm") {
                    $("#status_description option").remove();
                    $("#status_description").append('<option></option>');
                    if (status_detail == 'Re-Enquired') {
                        $("#status_description").append('<option  selected="selected">Re-Enquired</option>');
                    } else {
                        $("#status_description").append('<option>Re-Enquired</option>');
                    }
                    if (status_detail == 'Prospect') {
                        $("#status_description").append('<option  selected="selected">Prospect</option>');
                    } else {
                        $("#status_description").append('<option>Prospect</option>');
                    }
                }


                $("#status").change(function () {

                    var el = $(this);
        //~ alert(el.val())
                    if (el.val() === "Alive") {
                        $("#status_description option").remove();
                        $("#status_description").append('<option></option>');
                        //$("#status_description").append('<option>Call Back</option>');
                        $("#status_description").append('<option>Follow Up</option>');
                        $("#status_description").append('<option>New Lead</option>');
                    } else if (el.val() === "Dead") {
                        $("#status_description option").remove();
                        $("#status_description").append('<option></option>');
                        $("#status_description").append('<option>Dead Number</option>');
                        $("#status_description").append('<option>Wrong Number</option>');
                        $("#status_description").append('<option>Ringing Multiple Times</option>');
                        $("#status_description").append('<option>Not Enquired</option>');
                        $("#status_description").append('<option>Not Eligible</option>');
                        //$("#status_description").append('<option>Rejected</option>');
                        $("#status_description").append('<option>Fallout</option>');
                        //$("#status_description").append('<option>Retired</option>');
                    } else if (el.val() === "Recycle") {
                        $("#status_description option").remove();
                        $("#status_description").append('<option></option>');
                        $("#status_description").append('<option>Recycle</option>');
                    } else if (el.val() === "Converted") {
                        $("#status_description option").remove();
                        $("#status_description").append('<option></option>');
                        $("#status_description").append('<option>Converted</option>');
                    } else if (el.val() === "Duplicate") {
                        $("#status_description option").remove();
                        $("#status_description").append('<option></option>');
                        $("#status_description").append('<option>Duplicate</option>');
                    } else if (el.val() === "Warm") {
                        $("#status_description option").remove();
                        $("#status_description").append('<option></option>');
                        $("#status_description").append('<option>Re-Enquired</option>');
                        $("#status_description").append('<option>Prospect</option>');
                    } else if (el.val() === "Dropout") {
                        $("#status_description option").remove();
                        $("#status_description").append('<option></option>');
                        $("#status_description").append('<option>Dropout</option>');
                    }
                });


        //  Payment panel hide show
                if ($("#status_description").val() === "Converted") {

                    document.getElementById("detailpanel_2").style.display = 'inline';
                    triggerPaymentType();

                }
                $("#payment_source option").remove();
                $("#status_description").change(function () {
                    var sl = $(this);
                    if (sl.val() === "Converted") {
                        document.getElementById("detailpanel_2").style.display = 'inline';
                        //~ document.getElementById("transaction_id_label").style.display ='none';
                        //~ document.getElementById("transaction_id").style.display ='none';
                        //~ document.getElementById("reference_number_label").style.display ='none';
                        //~ document.getElementById("reference_number").style.display ='none';
                        triggerPaymentType();
                    } else {
                        document.getElementById("detailpanel_2").style.display = 'none';
                    }
                })

                // Date fields show n hide based on status details

                document.getElementById("date_of_callback_date").style.display = 'none';
                document.getElementById("date_of_callback_time_section").style.display = 'none';
                //~ document.getElementById("date_of_callback_minutes").style.display ='none';
                document.getElementById("date_of_callback_trigger").style.display = 'none';
                document.getElementById("date_of_callback_label").innerHTML = '';

                document.getElementById("date_of_followup_date").style.display = 'none';
                document.getElementById("date_of_followup_time_section").style.display = 'none';
                //~ document.getElementById("date_of_followup_minutes").style.display ='none';
                document.getElementById("date_of_followup_trigger").style.display = 'none';
                document.getElementById("date_of_followup_label").innerHTML = '';



                document.getElementById("date_of_prospect_date").style.display = 'none';
                document.getElementById("date_of_prospect_time_section").style.display = 'none';
                //~ document.getElementById("date_of_prospect_minutes").style.display ='none';
                document.getElementById("date_of_prospect_trigger").style.display = 'none';
                document.getElementById("date_of_prospect_label").innerHTML = '';


                $("#status_description").change(function () {
                    if (document.getElementById('status_description').value == 'Call Back') {
                        document.getElementById("date_of_callback_date").style.display = 'inline';
                        document.getElementById("date_of_callback_time_section").style.display = 'inline';
                        //~ document.getElementById("date_of_callback_minutes").style.display ='inline';
                        document.getElementById("date_of_callback_trigger").style.display = 'inline';
                        document.getElementById("date_of_callback_label").innerHTML = 'Call back Date:';
                        $("#date_of_followup_label").hide();
                        $("#date_of_followup_label").next().hide();
                    } else {
                        document.getElementById("date_of_callback_date").style.display = 'none';
                        document.getElementById("date_of_callback_time_section").style.display = 'none';
                        //~ document.getElementById("date_of_callback_hours").style.display ='none';
                        document.getElementById("date_of_callback_trigger").style.display = 'none';
                        document.getElementById("date_of_callback_label").innerHTML = '';
                        $("#date_of_followup_label").show();
                        $("#date_of_followup_label").next().show();
                    }


                    if (document.getElementById('status_description').value == 'Follow Up') {
                        document.getElementById("date_of_followup_date").style.display = 'inline';
                        document.getElementById("date_of_followup_time_section").style.display = 'inline';
                        //~ document.getElementById("date_of_followup_minutes").style.display ='inline';
                        document.getElementById("date_of_followup_trigger").style.display = 'inline';
                        document.getElementById("date_of_followup_label").innerHTML = 'Followup Date:';
                    } else {

                        document.getElementById("date_of_followup_date").style.display = 'none';
                        document.getElementById("date_of_followup_time_section").style.display = 'none';
                        //~ document.getElementById("date_of_followup_minutes").style.display ='none';
                        document.getElementById("date_of_followup_trigger").style.display = 'none';
                        document.getElementById("date_of_followup_label").innerHTML = '';



                    }

                    if (document.getElementById('status_description').value == 'Prospect') {
                        document.getElementById("date_of_prospect_date").style.display = 'inline';
                        document.getElementById("date_of_prospect_time_section").style.display = 'inline';
                        //~ document.getElementById("date_of_prospect_minutes").style.display ='inline';
                        document.getElementById("date_of_prospect_trigger").style.display = 'inline';
                        document.getElementById("date_of_prospect_label").innerHTML = 'Prospect Date:';
                    } else {

                        document.getElementById("date_of_prospect_date").style.display = 'none';
                        document.getElementById("date_of_prospect_time_section").style.display = 'none';
                        //~ document.getElementById("date_of_prospect_minutes").style.display ='none';
                        document.getElementById("date_of_prospect_trigger").style.display = 'none';
                        document.getElementById("date_of_prospect_label").innerHTML = '';


                    }

                })

            });
            function triggerPaymentType() {
                $("#payment_type").change(function () {

                    var py = $(this);
                    if (py.val() == 'Online') {
                        $("#payment_source option").remove();
                        $("#payment_source").append('<option></option>');
                        $("#payment_source").append('<option>PayU</option>');
                        $("#payment_source").append('<option>ATOM</option>');
                        $("#payment_source").append('<option>Paytm</option>');
                        document.getElementById("transaction_id_label").style.display = 'inline';
                        document.getElementById("transaction_id").style.display = 'inline';
                        document.getElementById("reference_number_label").style.display = 'none';
                        document.getElementById("reference_number").style.display = 'none';
                    } else if (py.val() == 'Offline') {
                        $("#payment_source option").remove();
                        $("#payment_source").append('<option></option>');
                        $("#payment_source").append('<option>NEFT</option>');
                        $("#payment_source").append('<option>Cheque</option>');
                        $("#payment_source").append('<option>Institute</option>');
                        $("#payment_source").append('<option>IMPS</option>');
                        $("#payment_source").append('<option>TPT</option>');
                        $("#payment_source").append('<option>FT</option>');
                        $("#payment_source").append('<option>Cash</option>');
                        $("#payment_source").append('<option>DD</option>');
                        $("#payment_source").append('<option>Inst.DD</option>');
                        $("#payment_source").append('<option>C.Disc</option>');
                        $("#payment_source").append('<option>E.Disc</option>');
                        $("#payment_source").append('<option>TDS</option>');
                        $("#payment_source").append('<option>Others</option>');
                        document.getElementById("transaction_id_label").style.display = 'none';
                        document.getElementById("transaction_id").style.display = 'none';
                        document.getElementById("reference_number_label").style.display = 'inline';
                        document.getElementById("reference_number").style.display = 'inline';
                    } else {
                        $("#payment_source option").remove();
                    }
                })
            }


        </script>
        <?php
        /* Manish @28MArch */

        if (isset($_REQUEST['full_form']))
        {

            $instituteObj                   = new Lead();
            $institute                      = $instituteObj->retrieve($_REQUEST['relate_id']);
            $this->bean->lead_source        = 'Referrals';
            $this->bean->parent_type        = 'Leads';
            $this->bean->parent_id          = $institute->id;
            $this->bean->parent_name        = $institute->first_name;
            $this->bean->assigned_user_name = '';
            $this->bean->assigned_user_id   = '';
            ?>


        <?php
        }


        if (isset($_REQUEST['addreferral']) && $_REQUEST['addreferral'] == 'true')
        {
            $this->bean->lead_source = 'Referrals';

            $this->bean->parent_type        = 'Users';
            $this->bean->parent_id          = $GLOBALS['current_user']->id;
            $this->bean->parent_name        = $GLOBALS['current_user']->user_name;
            $this->bean->assigned_user_name = '';
            $this->bean->assigned_user_id   = '';
            ?>
            <script>

                var _form = document.getElementById('EditView');
                _form.action.value = 'Save';
                if (check_form('EditView'))
                    SUGAR.ajaxUI.submitForm(_form);
                return false;

            </script>
        <?php
        }


        parent::display();
        global $db;
        $checkRoleSql = "SELECT * FROM `acl_roles_users` WHERE user_id='" . $GLOBALS['current_user']->id . "' AND (`role_id`='30957fe0-3494-e372-656d-58a9a6296516' OR `role_id`='270ce9dd-7f7d-a7bf-f758-582aeb4f2a45')";
        $checkRoleObj = $db->query($checkRoleSql);
        $row          = $db->fetchByAssoc($checkRoleObj);
        if ($row)
        {
            echo "<script>
			$('#assigned_user_name').prop('readonly',true);
			$('#btn_assigned_user_name').hide();
			$('#btn_clr_assigned_user_name').hide();
			</script>";
        }
        ?>


        <?php
    }

    /**
     * Displays the header on section of the page; basically everything before the content
     */
    public function displayHeader($retModTabs = false)
    {

        //~ parent::displayHeader();
        if (isset($_REQUEST['addreferral']) && $_REQUEST['addreferral'] == 'true')
        {
            $_SESSION['referral'] = 1;
        }
        global $theme;
        global $max_tabs;
        global $app_strings;
        global $current_user;
        global $sugar_config;
        global $app_list_strings;
        global $mod_strings;
        global $current_language;

        $GLOBALS['app']->headerDisplayed = true;

        $themeObject = SugarThemeRegistry::current();
        $theme       = $themeObject->__toString();

        $ss = new Sugar_Smarty();
        $ss->assign("APP", $app_strings);
        $ss->assign("THEME", $theme);
        $ss->assign("THEME_CONFIG", $themeObject->getConfig());
        $ss->assign("THEME_IE6COMPAT", $themeObject->ie6compat ? 'true' : 'false');
        $ss->assign("MODULE_NAME", $this->module);
        $ss->assign("langHeader", get_language_header());

        // set ab testing if exists
        $testing = (isset($_REQUEST["testing"]) ? $_REQUEST['testing'] : "a");
        $ss->assign("ABTESTING", $testing);

        // get browser title
        $ss->assign("SYSTEM_NAME", $this->getBrowserTitle());

        // get css
        $css = $themeObject->getCSS();
        if ($this->_getOption('view_print'))
        {
            $css .= '<link rel="stylesheet" type="text/css" href="' . $themeObject->getCSSURL('print.css') . '" media="all" />';
        }
        $ss->assign("SUGAR_CSS", $css);

        // get javascript
        ob_start();
        $this->renderJavascript();

        $ss->assign("SUGAR_JS", ob_get_contents() . $themeObject->getJS());
        ob_end_clean();

        // get favicon
        if (isset($GLOBALS['sugar_config']['default_module_favicon']))
            $module_favicon = $GLOBALS['sugar_config']['default_module_favicon'];
        else
            $module_favicon = false;

        $favicon = $this->getFavicon();
        $ss->assign('FAVICON_URL', $favicon['url']);

        // build the shortcut menu
        $shortcut_menu       = array();
        foreach ($this->getMenu() as $key => $menu_item)
            $shortcut_menu[$key] = array(
                "URL"         => $menu_item[0],
                "LABEL"       => $menu_item[1],
                "MODULE_NAME" => $menu_item[2],
                "IMAGE"       => $themeObject
                        ->getImage($menu_item[2], "border='0' align='absmiddle'", null, null, '.gif', $menu_item[1]),
            );
        $ss->assign("SHORTCUT_MENU", $shortcut_menu);

        // handle rtl text direction
        if (isset($_REQUEST['RTL']) && $_REQUEST['RTL'] == 'RTL')
        {
            $_SESSION['RTL'] = true;
        }
        if (isset($_REQUEST['LTR']) && $_REQUEST['LTR'] == 'LTR')
        {
            unset($_SESSION['RTL']);
        }
        if (isset($_SESSION['RTL']) && $_SESSION['RTL'])
        {
            $ss->assign("DIR", 'dir="RTL"');
        }

        // handle resizing of the company logo correctly on the fly
        $companyLogoURL     = $themeObject->getImageURL('company_logo.png');
        $companyLogoURL_arr = explode('?', $companyLogoURL);
        $companyLogoURL     = $companyLogoURL_arr[0];

        $company_logo_attributes = sugar_cache_retrieve('company_logo_attributes');
        if (!empty($company_logo_attributes))
        {
            $ss->assign("COMPANY_LOGO_MD5", $company_logo_attributes[0]);
            $ss->assign("COMPANY_LOGO_WIDTH", $company_logo_attributes[1]);
            $ss->assign("COMPANY_LOGO_HEIGHT", $company_logo_attributes[2]);
        }
        else
        {
            // Always need to md5 the file
            $ss->assign("COMPANY_LOGO_MD5", md5_file($companyLogoURL));

            list($width, $height) = getimagesize($companyLogoURL);
            if ($width > 212 || $height > 40)
            {
                $resizePctWidth  = ($width - 212) / 212;
                $resizePctHeight = ($height - 40) / 40;
                if ($resizePctWidth > $resizePctHeight)
                    $resizeAmount    = $width / 212;
                else
                    $resizeAmount    = $height / 40;
                $ss->assign("COMPANY_LOGO_WIDTH", round($width * (1 / $resizeAmount)));
                $ss->assign("COMPANY_LOGO_HEIGHT", round($height * (1 / $resizeAmount)));
            }
            else
            {
                $ss->assign("COMPANY_LOGO_WIDTH", $width);
                $ss->assign("COMPANY_LOGO_HEIGHT", $height);
            }

            // Let's cache the results
            sugar_cache_put('company_logo_attributes', array(
                $ss->get_template_vars("COMPANY_LOGO_MD5"),
                $ss->get_template_vars("COMPANY_LOGO_WIDTH"),
                $ss->get_template_vars("COMPANY_LOGO_HEIGHT")
                    )
            );
        }
        $ss->assign("COMPANY_LOGO_URL", getJSPath($companyLogoURL) . "&logo_md5=" . $ss->get_template_vars("COMPANY_LOGO_MD5"));

        // get the global links
        $gcls                 = array();
        $global_control_links = array();
        require("include/globalControlLinks.php");

        foreach ($global_control_links as $key => $value)
        {
            if ($key == 'users')
            {   //represents logout link.
                $ss->assign("LOGOUT_LINK", $value['linkinfo'][key($value['linkinfo'])]);
                $ss->assign("LOGOUT_LABEL", key($value['linkinfo'])); //key value for first element.
                continue;
            }

            foreach ($value as $linkattribute => $attributevalue)
            {
                // get the main link info
                if ($linkattribute == 'linkinfo')
                {
                    $gcls[$key] = array(
                        "LABEL"   => key($attributevalue),
                        "URL"     => current($attributevalue),
                        "SUBMENU" => array(),
                    );
                    if (substr($gcls[$key]["URL"], 0, 11) == "javascript:")
                    {
                        $gcls[$key]["ONCLICK"] = substr($gcls[$key]["URL"], 11);
                        $gcls[$key]["URL"]     = "javascript:void(0)";
                    }
                }
                // and now the sublinks
                if ($linkattribute == 'submenu' && is_array($attributevalue))
                {
                    foreach ($attributevalue as $submenulinkkey => $submenulinkinfo)
                        $gcls[$key]['SUBMENU'][$submenulinkkey] = array(
                            "LABEL" => key($submenulinkinfo),
                            "URL"   => current($submenulinkinfo),
                        );
                    if (substr($gcls[$key]['SUBMENU'][$submenulinkkey]["URL"], 0, 11) == "javascript:")
                    {
                        $gcls[$key]['SUBMENU'][$submenulinkkey]["ONCLICK"] = substr($gcls[$key]['SUBMENU'][$submenulinkkey]["URL"], 11);
                        $gcls[$key]['SUBMENU'][$submenulinkkey]["URL"]     = "javascript:void(0)";
                    }
                }
            }
        }
        $ss->assign("GCLS", $gcls);

        $ss->assign("SEARCH", isset($_REQUEST['query_string']) ? $_REQUEST['query_string'] : '');

        if ($this->action == "EditView" || $this->action == "Login")
            $ss->assign("ONLOAD", 'onload="set_focus()"');

        $ss->assign("AUTHENTICATED", isset($_SESSION["authenticated_user_id"]));

        // get other things needed for page style popup
        if (isset($_SESSION["authenticated_user_id"]))
        {
            // get the current user name and id
            $ss->assign("CURRENT_USER", $current_user->full_name == '' || !showFullName() ? $current_user->user_name : $current_user->full_name );
            $ss->assign("CURRENT_USER_ID", $current_user->id);

            // get the last viewed records
            require_once("modules/Favorites/Favorites.php");
            $favorites        = new Favorites();
            $favorite_records = $favorites->getCurrentUserSidebarFavorites();
            $ss->assign("favoriteRecords", $favorite_records);

            /*$tracker = new Tracker();
            $history = $tracker->get_recently_viewed($current_user->id);
            $ss->assign("recentRecords", $this->processRecentRecords($history));*/
        }

        $bakModStrings = $mod_strings;
        if (isset($_SESSION["authenticated_user_id"]))
        {
            // get the module list
            $moduleTopMenu = array();

            $max_tabs = $current_user->getPreference('max_tabs');
            // Attempt to correct if max tabs count is extremely high.
            if (!isset($max_tabs) || $max_tabs <= 0 || $max_tabs > 10)
            {
                $max_tabs = $GLOBALS['sugar_config']['default_max_tabs'];
                $current_user->setPreference('max_tabs', $max_tabs, 0, 'global');
            }

            $moduleTab = $this->_getModuleTab();
            $ss->assign('MODULE_TAB', $moduleTab);


            // See if they are using grouped tabs or not (removed in 6.0, returned in 6.1)
            $user_navigation_paradigm = $current_user->getPreference('navigation_paradigm');
            if (!isset($user_navigation_paradigm))
            {
                $user_navigation_paradigm = $GLOBALS['sugar_config']['default_navigation_paradigm'];
            }


            // Get the full module list for later use
            foreach (query_module_access_list($current_user) as $module)
            {
                // Bug 25948 - Check for the module being in the moduleList
                if (isset($app_list_strings['moduleList'][$module]))
                {
                    $fullModuleList[$module] = $app_list_strings['moduleList'][$module];
                }
            }


            if (!should_hide_iframes())
            {
                $iFrame = new iFrame();
                $frames = $iFrame->lookup_frames('tab');
                foreach ($frames as $key => $values)
                {
                    $fullModuleList[$key] = $values;
                }
            }
            elseif (isset($fullModuleList['iFrames']))
            {
                unset($fullModuleList['iFrames']);
            }

            if ($user_navigation_paradigm == 'gm' && isset($themeObject->group_tabs) && $themeObject->group_tabs)
            {
                // We are using grouped tabs
                require_once('include/GroupedTabs/GroupedTabStructure.php');
                $groupedTabsClass = new GroupedTabStructure();
                $modules          = query_module_access_list($current_user);

                //handle with submoremodules
                $max_tabs = $current_user->getPreference('max_tabs');
                // If the max_tabs isn't set incorrectly, set it within the range, to the default max sub tabs size
                if (!isset($max_tabs) || $max_tabs <= 0 || $max_tabs > 10)
                {
                    // We have a default value. Use it
                    if (isset($GLOBALS['sugar_config']['default_max_tabs']))
                    {
                        $max_tabs = $GLOBALS['sugar_config']['default_max_tabs'];
                    }
                    else
                    {
                        $max_tabs = 8;
                    }
                }

                $subMoreModules                                         = false;
                $groupTabs                                              = $groupedTabsClass->get_tab_structure(get_val_array($modules));
                // We need to put this here, so the "All" group is valid for the user's preference.
                $groupTabs[$app_strings['LBL_TABGROUP_ALL']]['modules'] = $fullModuleList;


                // Setup the default group tab.
                $allGroup        = $app_strings['LBL_TABGROUP_ALL'];
                $ss->assign('currentGroupTab', $allGroup);
                $currentGroupTab = $allGroup;
                $usersGroup      = $current_user->getPreference('theme_current_group');
                // Figure out which tab they currently have selected (stored as a user preference)
                if (!empty($usersGroup) && isset($groupTabs[$usersGroup]))
                {
                    $currentGroupTab = $usersGroup;
                }
                else
                {
                    $current_user->setPreference('theme_current_group', $currentGroupTab);
                }

                $ss->assign('currentGroupTab', $currentGroupTab);
                $usingGroupTabs = true;
            }
            else
            {
                // Setup the default group tab.
                $ss->assign('currentGroupTab', $app_strings['LBL_TABGROUP_ALL']);

                $usingGroupTabs                                         = false;
                $groupTabs[$app_strings['LBL_TABGROUP_ALL']]['modules'] = $fullModuleList;
            }


            $topTabList = array();

            // Now time to go through each of the tab sets and fix them up.
            foreach ($groupTabs as $tabIdx => $tabData)
            {
                $topTabs = $tabData['modules'];
                if (!is_array($topTabs))
                {
                    $topTabs = array();
                }
                $extraTabs = array();

                // Split it in to the tabs that go across the top, and the ones that are on the extra menu.
                if (count($topTabs) > $max_tabs)
                {
                    $extraTabs = array_splice($topTabs, $max_tabs);
                }
                // Make sure the current module is accessable through one of the top tabs
                if (!isset($topTabs[$moduleTab]))
                {
                    // Nope, we need to add it.
                    // First, take it out of the extra menu, if it's there
                    if (isset($extraTabs[$moduleTab]))
                    {
                        unset($extraTabs[$moduleTab]);
                    }
                    if (count($topTabs) >= $max_tabs - 1)
                    {
                        // We already have the maximum number of tabs, so we need to shuffle the last one
                        // from the top to the first one of the extras
                        $lastElem  = array_splice($topTabs, $max_tabs - 1);
                        $extraTabs = $lastElem + $extraTabs;
                    }
                    if (!empty($moduleTab))
                    {
                        $topTabs[$moduleTab] = $app_list_strings['moduleList'][$moduleTab];
                    }
                }


                /*
                  // This was removed, but I like the idea, so I left the code in here in case we decide to turn it back on
                  // If we are using group tabs, add all the "hidden" tabs to the end of the extra menu
                  if ( $usingGroupTabs ) {
                  foreach($fullModuleList as $moduleKey => $module ) {
                  if ( !isset($topTabs[$moduleKey]) && !isset($extraTabs[$moduleKey]) ) {
                  $extraTabs[$moduleKey] = $module;
                  }
                  }
                  }
                 */

                // Get a unique list of the top tabs so we can build the popup menus for them
                foreach ($topTabs as $moduleKey => $module)
                {
                    $topTabList[$moduleKey] = $module;
                }

                //$groupTabs[$tabIdx]['modules'] = $topTabs;
                //$groupTabs[$tabIdx]['extra'] = $extraTabs;
            }
        }

        if (isset($topTabList) && is_array($topTabList))
        {
            // Adding shortcuts array to menu array for displaying shortcuts associated with each module
            $shortcutTopMenu = array();
            if (!isset($_SESSION['referral']))
            {
                foreach ($topTabList as $module_key => $label)
                {
                    global $mod_strings;
                    $mod_strings = return_module_language($current_language, $module_key);
                    foreach ($this->getMenu($module_key) as $key => $menu_item)
                    {
                        $shortcutTopMenu[$module_key][$key] = array(
                            "URL"         => $menu_item[0],
                            "LABEL"       => $menu_item[1],
                            "MODULE_NAME" => $menu_item[2],
                            "IMAGE"       => $themeObject
                                    ->getImage($menu_item[2], "border='0' align='absmiddle'", null, null, '.gif', $menu_item[1]),
                            "ID"          => $menu_item[2] . "_link",
                        );
                    }
                }
            }
            else
            {

                /* $shortcutTopMenu['Leads'][0] = array(
                  "URL"         => 'index.php?module=te_student_batch&action=revenue',
                  "LABEL"       => 'Summary',
                  "MODULE_NAME" => '',
                  "IMAGE"       => $themeObject
                  ->getImage('',"border='0' align='absmiddle'",null,null,'.gif','View Student Batch'),
                  "ID"          => 'view'."_link",
                  );
                  $shortcutTopMenu['Leads'][1] = array(
                  "URL"         => 'index.php?module=te_student_batch&action=dropoutrequest',
                  "LABEL"       => 'Dropout Request',
                  "MODULE_NAME" => '',
                  "IMAGE"       => $themeObject
                  ->getImage('',"border='0' align='absmiddle'",null,null,'.gif','Dropout Request'),
                  "ID"          => 'view'."_link",
                  );
                  $shortcutTopMenu['Leads'][2] = array(
                  "URL"         => 'index.php?module=te_student&action=batchtransfer',
                  "LABEL"       => 'Batch Transfer',
                  "MODULE_NAME" => '',
                  "IMAGE"       => $themeObject
                  ->getImage('',"border='0' align='absmiddle'",null,null,'.gif','Batch Transfer'),
                  "ID"          => 'view'."_link",
                  );
                  $shortcutTopMenu['Leads'][3] = array(
                  "URL"         => 'index.php?module=te_student_batch&action=viewmyrefferal&parent_id='.$current_user->id,
                  "LABEL"       => 'View My Referrals',
                  "MODULE_NAME" => '',
                  "IMAGE"       => $themeObject
                  ->getImage('',"border='0' align='absmiddle'",null,null,'.gif','View My Referrals'),
                  "ID"          => 'view'."_link",
                  );
                  $shortcutTopMenu['Leads'][4] = array(
                  "URL"         => 'index.php?module=te_student_batch&action=search_leads',
                  "LABEL"       => 'CRM Leads Search',
                  "MODULE_NAME" => '',
                  "IMAGE"       => $themeObject
                  ->getImage('',"border='0' align='absmiddle'",null,null,'.gif','CRM Leads Search'),
                  "ID"          => 'view'."_link",
                  ); */
            }

            if (!empty($sugar_config['lock_homepage']) && $sugar_config['lock_homepage'] == true)
                $ss->assign('lock_homepage', true);
            $ss->assign("groupTabs", $groupTabs);
            $ss->assign("shortcutTopMenu", $shortcutTopMenu);
            $ss->assign('USE_GROUP_TABS', $usingGroupTabs);

            // This is here for backwards compatibility, someday, somewhere, it will be able to be removed
            $ss->assign("moduleTopMenu", $groupTabs[$app_strings['LBL_TABGROUP_ALL']]['modules']);
            $ss->assign("moduleExtraMenu", $groupTabs[$app_strings['LBL_TABGROUP_ALL']]['extra']);

// Show the custom panel in the left panel
            if (!isset($_SESSION['referral']))
            {
                require_once('custom/modules/Leads/customfunctionforcrm.php');
                global $current_user;
                $currentUserId    = $current_user->id;
                $reportingUserIds = array();
                $reportUserObj1   = new customfunctionforcrm();
                $statusWiseCount  = $reportUserObj1->statusWiseCounts();

                $ss->assign("statusWiseCount", $statusWiseCount);
            }
        }


        //~ echo $test;die;
        if (isset($extraTabs) && is_array($extraTabs))
        {
            // Adding shortcuts array to extra menu array for displaying shortcuts associated with each module
            $shortcutExtraMenu = array();
            foreach ($extraTabs as $module_key => $label)
            {
                global $mod_strings;
                $mod_strings = return_module_language($current_language, $module_key);
                foreach ($this->getMenu($module_key) as $key => $menu_item)
                {
                    $shortcutExtraMenu[$module_key][$key] = array(
                        "URL"         => $menu_item[0],
                        "LABEL"       => $menu_item[1],
                        "MODULE_NAME" => $menu_item[2],
                        "IMAGE"       => $themeObject
                                ->getImage($menu_item[2], "border='0' align='absmiddle'", null, null, '.gif', $menu_item[1]),
                        "ID"          => $menu_item[2] . "_link",
                    );
                }
            }
            $ss->assign("shortcutExtraMenu", $shortcutExtraMenu);
        }

        if (!empty($current_user))
        {
            $ss->assign("max_tabs", $current_user->getPreference("max_tabs"));
        }


        $imageURL    = SugarThemeRegistry::current()->getImageURL("dashboard.png");
        $homeImage   = "<img src='$imageURL'>";
        $ss->assign("homeImage", $homeImage);
        global $mod_strings;
        $mod_strings = $bakModStrings;
        $headerTpl   = $themeObject->getTemplate('header.tpl');
        if (inDeveloperMode())
            $ss->clear_compiled_tpl($headerTpl);
        //~ echo $themeObject->getTemplate('_headerModuleList.tpl');die;
        if ($retModTabs)
        {
            return $ss->fetch($themeObject->getTemplate('_headerModuleList.tpl'));
        }
        else
        {
            $ss->display($headerTpl);

            $this->includeClassicFile('modules/Administration/DisplayWarnings.php');

            $errorMessages = SugarApplication::getErrorMessages();
            if (!empty($errorMessages))
            {
                foreach ($errorMessages as $error_message)
                {
                    echo('<p class="error">' . $error_message . '</p>');
                }
            }
        }
    }

    public static $reporters = array();

    public static function getUsers($userID)
    {
        global $db;

        $sql = "select reports_to_id from users where id='" . $userID . "' and deleted=0";
        $res = $db->query($sql);

        if ($db->getRowCount($res) > 0)
        {
            $records = $db->fetchByAssoc($res);
            if ($records['reports_to_id'])
            {
                self::$reporters[] = $records['reports_to_id'];
                self::getUsers($records['reports_to_id']);
            }
        }
    }

}
?>

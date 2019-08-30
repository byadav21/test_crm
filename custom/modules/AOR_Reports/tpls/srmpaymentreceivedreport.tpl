<section class="moduleTitle"> 
    <form name="search_form" id="search_form" class="search_form" method="post" action="index.php?module=AOR_Reports&action=srmpaymentreceivedreport">
        <input type="hidden" name="batch_created_date" id="batch_created_date" value="{$batch_created_date}">

        <div id="te_budgeted_campaignbasic_searchSearchForm" style="" class="edit view search basic">
            <h2>Payment Received Report:</h2><br><br><br>
            <div class = "block-wrapper marginTop15">
                <div class = "block">
                    <label>Select Institute : </label>
                    <select name="institute_dropdown" id="institute_dropdown"  class="" style="">
                        <option value="">-Select-</option>
                        {foreach from =$getInstituteDropData key=key item=program}
                            <option value="{$program.id}" {if $program.id==$selected_institute_dropdown} selected="selected"{/if}>{$program.name}</option>
                        {/foreach}
                    </select>

                </div>
                <div class = "block">
                    <label>Select Program : </label>
                    <select name="program_dropdown" id="program_dropdown"  class=""  style="">
                        <option value="">-Select-</option>

                    </select>
                </div>
                <div class = "block">
                    <label>Select Batch : </label>
                    <select name="batch_dropdown" id="batch_dropdown"  class=""  style="">
                        <option value="">-Select-</option>
                    </select>
                </div>
                

            </div>
                    <div class = "action-block">
                        <input tabindex="2" title="Search" onclick="SUGAR.savedViews.setChooser();" class="button" type="submit" name="button" value="Search" id="search_form_submit">
               
                
                        <input tabindex="2" title="Clear" onclick="SUGAR.searchForm.clear_form(this.form);
                            return false;" class="button" type="button" name="clear" id="search_form_clear" value="Clear">
                
                
                        <input tabindex="2" title="Export" onclick="SUGAR.savedViews.setChooser();" class="button" type="submit" name="export" value="Export" id="export_form_submit">
                    </div>

        </div>
    </form>


    <div style="width:99%;overflow:hidden;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="paginationTable">
            <tbody><tr>
                    <td nowrap="nowrap" class="paginationActionButtons">&nbsp;</td>

                    <td nowrap="nowrap" align="right" class="paginationChangeButtons" width="1%">

                        {if $left eq 1}
                            <a href="index.php?module=AOR_Reports&action=srmpaymentreceivedreport"  name="listViewStartButton" title="Start" class="button" >
                                <img src="themes/SuiteR/images/start_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Start">
                            </a>

                            <a href="index.php?module=AOR_Reports&action=srmpaymentreceivedreport&page={$page}"  class="button" title="Previous">
                                <img src="themes/SuiteR/images/previous_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Previous">
                            </a>
                        {else}
                            <button type="button" id="listViewStartButton_top" name="listViewStartButton" title="Start" class="button" disabled="disabled">
                                <img src="themes/SuiteR/images/start_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Start">
                            </button>

                            <button type="button" id="listViewPrevButton_top" name="listViewPrevButton" class="button" title="Previous" disabled="disabled">
                                <img src="themes/SuiteR/images/previous_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Previous">
                            </button>
                        {/if}

                    </td>
                    <td nowrap="nowrap" width="1%" class="paginationActionButtons">
                        <div class="pageNumbers">{$current_records}</div>
                    </td>
                    <td nowrap="nowrap" align="right" class="paginationActionButtons" width="1%">
                        {if $right eq 1}
                            <a href="index.php?module=AOR_Reports&action=srmpaymentreceivedreport&page={$pagenext}"  class="button" title="Next" disabled="disabled">
                                <img src="themes/SuiteR/images/next_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Next">
                            </a>
                            <a href="index.php?module=AOR_Reports&action=srmpaymentreceivedreport&page={$last_page}"  class="button" title="End" disabled="disabled">
                                <img src="themes/SuiteR/images/end_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" alt="End">
                            </a>
                        {else}
                            <button type="button" id="listViewNextButton_top" name="listViewNextButton" class="button" title="Next" disabled="disabled">
                                <img src="themes/SuiteR/images/next_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Next">
                            </button>
                            <button type="button" id="listViewEndButton_top" name="listViewEndButton" title="End" class="button" disabled="disabled">
                                <img src="themes/SuiteR/images/end_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" alt="End">
                            </button>
                        {/if}


                    </td>
                    <td nowrap="nowrap" width="4px" class="paginationActionButtons"></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div style="width:99%;overflow:auto;border:2px dashed #d0d0d0;" class="div-leads-list">
        <table cellpadding="0" cellspacing="0" width="100%" border="0" class="list view table footable-loaded footable default"  style="overflow-x:auto;">
            <thead>

                {*End Pagination*}

                <tr height="20">
                    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                        <strong>Sr. No.</strong>
                    </th>
                    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                        <strong>Batch Code</strong>
                    </th>


                    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                        <strong>Course Name</strong>
                    </th>
                    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                        <strong>Vendor/Lead Source Name</strong>
                    </th>

                    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                        <strong>Institute Name</strong>
                    </th>

                    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                        <strong>Registration Date</strong>
                    </th>



                    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                        <strong>Student Name</strong>
                    </th>
                    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                        <strong>Email ID</strong>
                    </th> 

                    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                        <strong>Phone Number</strong>
                    </th> 

                    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                        <strong>Lead ID</strong>
                    </th>



                    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                        <strong>Counselor Name</strong>
                    </th>

                    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                        <strong>Invoice Number</strong>
                    </th>

                    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                        <strong>Course Fee</strong>
                    </th>
                    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                        <strong>GST</strong>
                    </th>

                    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                        <strong>Total Amount</strong>
                    </th>
                    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                        <strong>Outstanding Balance</strong>
                    </th>


                    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                        <strong>Order Number</strong>
                    </th>
                    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                        <strong>Instalment 1/Payment 1</strong>
                    </th>

                    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                        <strong>Payment Source</strong>
                    </th>

                    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                        <strong>Month</strong>
                    </th>
                    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                        <strong>Date of Payment</strong>
                    </th>

                    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                        <strong>Due Date</strong>
                    </th>



                    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                        <strong>Order Number</strong>
                    </th>
                    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                        <strong>Instalment 2/Payment 2</strong>
                    </th>

                    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                        <strong>Payment Source</strong>
                    </th>

                    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                        <strong>Month</strong>
                    </th>
                    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                        <strong>Date of Payment</strong>
                    </th>

                    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                        <strong>Due Date</strong>
                    </th>


                    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                        <strong>Order Number</strong>
                    </th>
                    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                        <strong>Instalment 3/Payment 3</strong>
                    </th>

                    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                        <strong>Payment Source</strong>
                    </th>

                    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                        <strong>Month</strong>
                    </th>
                    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                        <strong>Date of Payment</strong>
                    </th>

                    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                        <strong>Due Date</strong>
                    </th>


                    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                        <strong>Order Number</strong>
                    </th>
                    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                        <strong>Instalment 4/Payment 4</strong>
                    </th>

                    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                        <strong>Payment Source</strong>
                    </th>

                    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                        <strong>Month</strong>
                    </th>
                    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                        <strong>Date of Payment</strong>
                    </th>

                    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                        <strong>Due Date</strong>
                    </th>


                    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                        <strong>Order Number</strong>
                    </th>
                    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                        <strong>Instalment 5/Payment 5</strong>
                    </th>

                    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                        <strong>Payment Source</strong>
                    </th>

                    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                        <strong>Month</strong>
                    </th>
                    <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                        <strong>Date of Payment</strong>
                    </th>

                    <th data-hide="phone" class="footable-visible footable-first-column">
                        <strong>Due Date</strong>
                    </th>







                </tr>

                {if empty($paymentList)}<tr class="oddListRowS1"><td align="left"  colspan="30">Please select a Batch Code.</td></tr>{/if}
                {foreach from = $paymentList key=keyx item=program}


                    {assign var='toBePay' value=0}
                    {assign var='toBePay' value=$program.total_amount-$program.amt_tobe_pay}

                    <tr height="20" class="oddListRowS1">
                        <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.srno}</td>
                        <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.batch_code}</td>

                        <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.batch_name}</td>
                        <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.Vendor}</td>
                        <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.institute}</td>
                        <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.converted_date}</td>
                        <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.student_name}</td>

                        <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.email_add}</td>
                        <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.phone_mobile}</td>

                        <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.lead_id}</td>
                        <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.counselor_name}</td>
                        <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.invoice_number}</td>

                        <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.fee_inr}</td>
                        <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.gst}</td>
                        <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.total_amount}</td>
                        <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.amt_tobe_pay}</td>

                        {foreach from = $program.installment key=key item=value}
                            {foreach from = $value key=key item=value}

                                <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column"> {$value}</td>

                            {/foreach}

                            {*{$value |  print_r}*}

                        {/foreach}

                    </tr>
                {/foreach}


        </table>
    </div>  
    {literal}
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
            .action-block{display: flex; align-items: flex-end; justify-content: flex-end; margin:20px 0; padding: 0 9px;}
        </style>
        <script>
            Calendar.setup({
                inputField: "from_date",
                daFormat: "%Y-%m-%d %I:%M%P",
                button: "from_date_trigger",
                singleClick: true,
                dateStr: "",
                step: 1,
                weekNumbers: false,
            });
            Calendar.setup({
                inputField: "to_date",
                daFormat: "%Y-%m-%d %I:%M%P",
                button: "to_date_trigger",
                singleClick: true,
                dateStr: "",
                step: 1,
                weekNumbers: false,
            });


            function getAjax(target, id) {
                $.ajax({
                    beforeSend: function (request)
                    {
                        //request.setRequestHeader("OAuth-Token", SUGAR.App.api.getOAuthToken());
                    },
                    url: "index.php?entryPoint=srmajax",
                    data: {action: target, ID: id},
                    dataType: "html",
                    type: "POST",
                    async: true,
                    success: function (data) {
                        //alert(data)
                        $('#' + target).html('');
                        $('#' + target).html(data);

                    }
                });
            }

            $(document).ready(function () {

                $("#institute_dropdown").change(function () {
                    var InstID = $('#institute_dropdown').val();
                    getAjax('program_dropdown', InstID);
                });

                $("#program_dropdown").change(function () {
                    var proID = $('#program_dropdown').val();
                    getAjax('batch_dropdown', proID);
                });

                $("#search_form").on('submit', function (e) {

                    var institute_dropdown = $('#institute_dropdown').val();
                    var program_dropdown = $('#program_dropdown').val();
                    var batch_dropdown = $('#batch_dropdown').val();


                    if (institute_dropdown == '') {

                        alert("Please select a Institute.");
                        return false;
                    } else if (program_dropdown == '') {
                        alert("Please select a Program.");
                        return false;
                    } else if (batch_dropdown == '') {
                        alert("Please select a Batch.");
                        return false;
                    }

                });
            });
        </script>
    {/literal}
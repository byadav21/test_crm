<section class="moduleTitle"> <h2>Payment Summarised Report</h2><br/><br/>
    <form name="search_form" id="search_form" class="search_form" method="post" action="index.php?module=AOR_Reports&action=summarised">
        <input type="hidden" name="batch_created_date" id="batch_created_date" value="{$batch_created_date}">
        <div id="te_budgeted_campaignbasic_searchSearchForm" style="" class="edit view search basic">
            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                <tbody>

                    <tr>
                        <td scope="row" nowrap="nowrap" width="1%">
                            <label for="From Date">From Date:</label>
                        </td>
                        <td nowrap="nowrap" width="10%">
                            <input name="from_date" type="text"  value="{$selected_from_date}" id='from_date'/>
                            <img src="themes/SuiteP/images/jscalendar.gif?v=yt-yazfsU-Y9uR7ixqf7Lg" alt="Enter Date" style="position:relative; top:-1px" border="0" id="from_date_trigger">
                        </td>
                        <td scope="row" nowrap="nowrap" width="1%">
                            <label for="To Date">To Date:</label>
                        </td>
                        <td nowrap="nowrap" width="10%">
                            <input name="to_date" type="text"  value="{$selected_to_date}" id='to_date'/>
                            <img src="themes/SuiteP/images/jscalendar.gif?v=yt-yazfsU-Y9uR7ixqf7Lg" alt="Enter Date" style="position:relative; top:-1px" border="0" id="to_date_trigger">
                        </td>
                    </tr>
                   
                    
                    <tr>
                        <td scope="row" nowrap="nowrap" width="1%">
                            <label for="From Date">Payment Source:</label>
                        </td>
                        <td nowrap="nowrap" >
                            <select name="payment_source[]" id="payment_source"  class="multiselbox" multiple style="width:180px !important; height: 70px !important;">
                                {foreach from =$PaymentSourceData key=key item=value}
                                    <option value="{$value.payment_source}" {if in_array($value.payment_source, $selected_payment_source)} selected="selected"{/if}>{$value.payment_source}</option>
                                {/foreach}
                            </select>
                        </td>
                        
                        <td scope="row" nowrap="nowrap" width="1%">
                            <label for="To Date">Lead Source Name:</label>
                        </td>
                        <td nowrap="nowrap" >
                            <select name="vendor_data[]" id="vendor_data" class="multiselbox" multiple style="width:180px !important; height: 70px !important;">
                                {foreach from =$VendorData key=key item=value}
                                    <option value="{$value.name}" {if in_array($value.name,$selected_vendor_data)} selected="selected"{/if}>{$value.name}</option>
                                {/foreach}
                            </select>
                        </td>
                    </tr>
                    
                    <tr>
                            
                        <td scope="row" nowrap="nowrap" width="1%">
                            <label for="Batch Status">Batch Status:</label>
                        </td>
                        <td nowrap="nowrap" >
                            <select name="status[]" id="status"  class="multiselbox" multiple style="width:180px !important; height: 70px !important;">
                                <option value="All" {if in_array('All', $selected_status)} selected="selected"{/if}>All</option>
                                <option value="Active" {if in_array('Active', $selected_status)} selected="selected"{/if}>Active</option>
                                <option value="Inactive" {if in_array('Inactive', $selected_status)} selected="selected"{/if}>Inactive</option>
                            </select>
                        </td>

                        <td scope="row" nowrap="nowrap" width="1%">
                            <label for="Batch Code">Batch Code:</label>
                        </td>
                        <td nowrap="nowrap" >
                            <select name="batch_code[]" id="batch_code"  class="multiselbox" multiple style="width:180px !important; height: 70px !important;">
                                {foreach from =$BatchListData key=key item=program}

                                    <option value="{$program.id}"{if in_array($program.id, $selected_batch_code)} selected="selected"{/if}>{$program.batch_code}</option>
                                {/foreach}
                            </select>
                        </td>

                    </tr>
                      <tr>
                        <td scope="row" nowrap="nowrap" width="1%">
                            <label for="Month">Month:</label>
                        </td>
                        <td nowrap="nowrap" >
                            <select name="month[]" id="month"  class="multiselbox" multiple style="width:180px !important; height: 70px !important;">
                                {foreach from =$month key=key item=value}
                                    <option value="{$key}" {if in_array($key, $selected_month)} selected="selected"{/if}>{$value}</option>
                                {/foreach}
                            </select>
                        </td>
                        
                    </tr>
                 

                    <tr>
                        <td class="sumbitButtons" colspan="3">
                            <input tabindex="2" title="Search" onclick="SUGAR.savedViews.setChooser();" class="button" type="submit" name="button" value="Search" id="search_form_submit">&nbsp;
                            <input tabindex="2" title="Clear" onclick="SUGAR.searchForm.clear_form(this.form);
                                    return false;" class="button" type="button" name="clear" id="search_form_clear" value="Clear">
                           <input tabindex="2" title="Export" onclick="SUGAR.savedViews.setChooser();" class="button" type="submit" name="export" value="Export" id="export_form_submit">
                        </td>
                    </tr>


                </tbody>
            </table>
        </div>
    </form>
    <table cellpadding="0" cellspacing="0" width="100%" border="0" class="list view table footable-loaded footable default">
        <thead>
            {*Start Pagination*}
            <tr id="pagination" role="presentation">
                <td colspan="20">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="paginationTable">
                        <tbody><tr>
                                <td nowrap="nowrap" class="paginationActionButtons">&nbsp;</td>

                                <td nowrap="nowrap" align="right" class="paginationChangeButtons" width="1%">

                                    {if $left eq 1}
                                        <a href="index.php?module=AOR_Reports&action=summarised"  name="listViewStartButton" title="Start" class="button" >
                                            <img src="themes/SuiteR/images/start_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Start">
                                        </a>

                                        <a href="index.php?module=AOR_Reports&action=summarised&page={$page}"  class="button" title="Previous">
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
                                        <a href="index.php?module=AOR_Reports&action=summarised&page={$pagenext}"  class="button" title="Next" disabled="disabled">
                                            <img src="themes/SuiteR/images/next_off.gif?v=S2eFayn4JyvAICLoJ82pZw" align="absmiddle" border="0" alt="Next">
                                        </a>
                                        <a href="index.php?module=AOR_Reports&action=summarised&page={$last_page}"  class="button" title="End" disabled="disabled">
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
                </td>
            </tr>
            {*End Pagination*}
            <tr height="20">
                <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                    &nbsp;
                </th>
                <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                    &nbsp;
                </th>
                <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                    &nbsp;
                </th>
                <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                    &nbsp;
                </th>
                {*<th scope="col" data-hide="phone" class="footable-visible footable-first-column" colspan="3"><strong>Alive</strong></th>
                <th scope="col" data-hide="phone" class="footable-visible footable-first-column" colspan="7"><strong>Dead</strong></th>
                <th scope="col" data-hide="phone" class="footable-visible footable-first-column"><strong>Converted</strong></th>
                <th scope="col" data-hide="phone" class="footable-visible footable-first-column" colspan="2"><strong>Warm</strong></th>
                <th scope="col" data-hide="phone" class="footable-visible footable-first-column"><strong>Recycle </strong></th>
                <th scope="col" data-hide="phone" class="footable-visible footable-first-column"><strong>Dropout</strong></th>
                <th scope="col" data-hide="phone" class="footable-visible footable-first-column"><strong>Duplicate</strong></th>
                <th scope="col" data-hide="phone" class="footable-visible footable-first-column"><strong>NA</strong></th>*}

            </tr>
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
                    <strong>Lead ID</strong>
                </th>
                <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                    <strong>Counselor Name</strong>
                </th>
                <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                    <strong>Invoice Number</strong>
                </th>
                <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                    <strong>Month of Registration</strong>
                </th>
                 <th scope="col" data-hide="phone" class="footable-visible footable-first-column">
                    <strong>State of Student</strong>
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
                    <strong>Payment Source</strong>
                </th>


            </tr>
            
            {if empty($paymentList)}<tr class="oddListRowS1"><td align="left"  colspan="10"><strong>No Data Found!</strong></td></tr>{/if}
            {foreach from = $paymentList key=keyx item=program}
            
                <tr height="20" class="oddListRowS1">
                    <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.srno}</td>
                    <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.batch_code}</td>
          
                    <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.batch_name}</td>
                    <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.Vendor}</td>
                      <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.institute}</td>
                    <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.converted_date}</td>
                    <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.student_name}</td>
                      <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.lead_id}</td>
                    <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.counselor_name}</td>
                    <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.invoice_number}</td>
                    
                    <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.registration_month}</td>
                    <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.student_state}</td>
                    
                    <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.fee_inr}</td>
                    <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.gst}</td>
                    <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.total_amount}</td>
                    <td align="left" valign="top" type="relate" field="batch" class="inlineEdit footable-visible footable-last-column">{$program.payment_source}</td>


                </tr>
            {/foreach}


    </table>
  {literal}
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
                function getAjax(target, arr) {
                $.ajax({
                    beforeSend: function (request)
                    {
                        //request.setRequestHeader("OAuth-Token", SUGAR.App.api.getOAuthToken());
                    },
                    url: "index.php?entryPoint=reportsajax",
                    data: {action: target, param: arr},
                    dataType: "html",
                    type: "POST",
                    async: true,
                    success: function (data) {
                        $('#' + target).html('');
                        $('#' + target).html(data);
                        $('select[multiple]').multiselect('reload');

                    }
                });
            }
            $(document).ready(function () {

                $("#status").change(function () {
                    var arg = $('#status').val();
                    getAjax('batch_code', arg);
                });
               
                //getStateByZone();
                
            
            });


        </script>




    {/literal}
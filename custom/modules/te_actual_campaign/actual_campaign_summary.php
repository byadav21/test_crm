<?php

/* This is Custom file  For Budgeted vs Compaign 
 * Display menu from Action at Module actual_campaign_summary
 *  Created date -21st April @Pawan
 * */
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
ini_set('display_errors', '1');
error_reporting(E_ALL);
global $app_list_strings, $current_user, $sugar_config, $db;
?>


<style>	 
    .revenue h1{      font-size: 20px;
                      margin: 18px 0;
                      font-weight: bold;}
    .revenue{    line-height: 36px;}
    .revenue .innerdiv .div{    border: 1px solid silver;
                                border-right: 0px;
                                border-bottom: 0px;    word-wrap: break-word;
                                height: auto;
                                overflow: hidden;}
    .innerdiv div.divlast{border-right: 1px solid silver!important;}		
    .divlastbot{border-bottom: 1px solid silver;}
    .headrtbl{    background: #F6F6F6;}	
    .bordertopright{border-top: 0px!important;border-right: 0px!important;}	
    .bordertopleft{border-top: 0px!important;border-left: 0px!important;}
    label{display:block}
    .button{    padding: 0px 17px!important;}	
    #loadingPages{vertical-align: middle;
                  position: absolute;
                  top: 51%;
                  right: 38%;    
                  background: #f1f1f1;
                  padding: 12px;}
    .disablediv{display: block;
                height: auto;
                opacity: 0.7;
                pointer-events: none;}
    .revenue input[type=text], .revenue select {width:100%!important}
    .revmulti .ms-options-wrap ,.revmulti .ms-options-wrap > .ms-options{width:100%}
    .revmulti .ms-options-wrap > .ms-options > ul input[type="checkbox"] {top: 15px;}
</style>

<div class="container revenue" ng-controller="revenueSummary">
    <h1>Actual Campaign</h1>
    <form name="search_form" id="search_form" class="search_form" method="post" action="">

        <div id="te_budgeted_campaignbasic_searchSearchForm" style="" class="edit view search basic">
            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                <tbody>

                    <tr>
                        <td scope="row" nowrap="nowrap" width="1%">
                            <label for="From Date">From Date:</label>
                        </td>
                        <td nowrap="nowrap" width="10%">
                            <input name="from_date" type="text"  value="" id='from_date'/>
                            <img src="themes/SuiteP/images/jscalendar.gif?v=yt-yazfsU-Y9uR7ixqf7Lg" alt="Enter Date" style="position:relative; top:-1px" border="0" id="from_date_trigger">
                        </td>
                        <td scope="row" nowrap="nowrap" width="1%">
                            <label for="To Date">To Date:</label>
                        </td>
                        <td nowrap="nowrap" width="10%">
                            <input name="to_date" type="text"  value="" id='to_date'/>
                            <img src="themes/SuiteP/images/jscalendar.gif?v=yt-yazfsU-Y9uR7ixqf7Lg" alt="Enter Date" style="position:relative; top:-1px" border="0" id="to_date_trigger">
                        </td>
                    </tr>


                    <tr>
                        <td scope="row" nowrap="nowrap" width="1%">
                            <label for="Batch Status">Batch Status:</label>
                        </td>
                        <td nowrap="nowrap" >
                            <select name="status[]" id="status"  class="multiselbox" multiple style="width:180px !important; height: 70px !important;">
                                <option value="All">All</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </td>

                        <td scope="row" nowrap="nowrap" width="1%">
                            <label for="Batch Code">Batch Code:</label>
                        </td>
                        <td nowrap="nowrap" >
                            <select name="batch_code[]" id="batch_code"  class="multiselbox" multiple style="width:180px !important; height: 70px !important;">

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
    <!--    <form name="search_form" id="search_form" class="search_form" method="post" action="">
            
            
            
            <tr>
                <td  colspan="8">
                    <input tabindex="2" title="Export" onclick="SUGAR.savedViews.setChooser();" class="button" type="submit" name="export" value="Export" id="export_form_submit">
                </td>
            </tr>
        </form>-->
    <div class=" text-right ">
        <span class="utils">
            <a id="create_image" href="?action=ajaxui#ajaxUILoc=index.php?Fmodule=te_actual_campaign&action=EditView&return_module=te_actual_campaign&return_action=actual_campaign_summary" class="utilsLink">
                <img src="themes/default/images/create-record.gif?v=G9oBIubjfusviQdLpVzJkw" alt="Create"></a>
            <a id="create_link" href="index.php?module=te_actual_campaign&action=EditView&return_module=te_actual_campaign&return_action=actual_campaign_summary" class="utilsLink">
                Create
            </a>
        </span>
    </div>
    <div class="row">

        <div class="maincont">
            <div class="col-xs-12 innerdiv" ng-if="results.length == 0"  >
                <div class="col-sm-12 text-center div"><strong style="font-size:18px;">No data found</strong></div>
            </div>


            <div class="col-xs-12 innerdiv">
                <div class="col-xs-6 div text-center headrtbl">Batch Code</div>
                <div class="col-xs-3 div text-center headrtbl">Vendor</div>
                <!--<div class="col-xs-2 div text-center headrtbl">Rate</div>-->
                <div class="col-xs-3 div text-center headrtbl">Cost</div>

            </div>


            <div class="col-xs-12 innerdiv" ng-if="results.length > 0" ng-repeat="(key,obj) in results">
                <div class="col-xs-6 text-left div"><a ng-href='index.php?searchFormTab=basic_search&module=te_actual_campaign&action=index&query=true&batch_basic=<% obj.name %>'  ><% obj.batch_code %></a></div>
                <div class="col-xs-3 text-center div"><% obj.vendor_name %></div>	
               <!--<div class="col-xs-2 text-center div"><% obj.rate  | number : 0 %></div>-->
                <div class="col-xs-3 text-center div"><% obj.total_cost  | number : 0 %></div>	
            </div>
            <div ng-show="isload == 1" class="col-xs-12 text-center"><button ng-click="loadMore()" class="loadmore button">Load More</button></div>
        </div>
    </div>
    <div id="loadingPages" align="center" style="vertical-align:middle;opacity:0"><img src="themes/default/images/img_loading.gif?v=pjh5Q-Y5ZM5LOLJN0GRbHQ" align="absmiddle"> <b>Loading results, please wait...</b></div>
    <script type='text/javascript' src='custom/modules/te_actual_campaign/js/listbudgetSummary.js'></script>


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
                    $("#search_form").on('submit', (function(e) {

                                var from_date = $('#from_date').val();
                                var to_date = $('#to_date').val();
                                var batch_code = $('#batch_code').val();
                                var status = $('#status').val();
                    }));
                });
    </script>

    <?php

    if (isset($_REQUEST['export']))
    {


        //ini_set('display_errors', '1');
        //error_reporting(E_ALL);

        $sql = "SELECT bb.batch_code,bb.name,
                    v.name as vendor_name,
                    tac.total_cost AS total_cost
             FROM te_actual_campaign tac
             INNER JOIN `te_ba_batch` bb ON tac.te_ba_batch_id_c=bb.id
             left join te_vendor v on tac.vendor_id=v.id
             WHERE bb.deleted=0
               AND tac.deleted=0
             order BY bb.id ";

        $itemDetal = $db->query($sql) or die('Error:');

        $rowData = [];
        $current = '';
        while ($row     = $db->fetchByAssoc($itemDetal))
        {

            $addrows = $row;

            $addrows['batch_code']  = strtoupper($row['batch_code']);
            $addrows['total_cost']  = strtoupper($row['total_cost']);
            $addrows['vendor_name'] = ($row['vendor_name']) ? strtoupper($row['vendor_name']) : 'N/A';
            $rowData[]              = $addrows;
        }



        __export_data($rowData);
    }

    function __export_data($row_data = array())
    {
        //echo '<pre>'; print_r($row_data); die;
        $data     = "Batch Code, vendor, Cost\n";
        $file     = "actual_report_campaign";
        $filename = $file . "_" . date("Y-m-d");
        foreach ($row_data as $key => $councelor)
        {

            $data .= "\"" . $councelor['batch_code'] . "\",\"" . $councelor['vendor_name'] . "\",\"" . $councelor['total_cost'] . "\"\n";
        }
        ob_end_clean();
        header("Content-type: application/csv");
        header('Content-disposition: attachment;filename=" ' . $filename . '.csv";');
        echo $data;
        exit;
    }
    ?>





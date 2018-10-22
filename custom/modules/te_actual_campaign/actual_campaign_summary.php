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
        <tr>
            <td  colspan="8">
                <input tabindex="2" title="Export" onclick="SUGAR.savedViews.setChooser();" class="button" type="submit" name="export" value="Export" id="export_form_submit">
            </td>
        </tr>
    </form>
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
            $addrows['total_cost']        = strtoupper($row['total_cost']);
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

            $data .= "\"" . $councelor['batch_code'] . "\",\"" . $councelor['vendor_name'] . "\",\"" . $councelor['total_cost']. "\"\n";
        }
        ob_end_clean();
        header("Content-type: application/csv");
        header('Content-disposition: attachment;filename=" ' . $filename . '.csv";');
        echo $data;
        exit;
    }
    ?>





<h2>Inbound Abandon Call Process | Draft</h2><br/><br/> 

<div class="dashboard-top-wrapper">

    <div class="dashboard-block">
        <h3 class="heading-title"><span>Upload File</span></h3>
        <div class="upload-block">

            <form name="search_update" id="search_upload"  method="post" action="index.php?module=AOR_Reports&action=inboundcallprocess" enctype="multipart/form-data">
                <label for="batch_basic">Select Upload .CSV File</label>
                <input type="file" value="" name="file" required accept=".csv"><br>
                <div>
                    Exclude email notificaton:  <input type="checkbox" name="exclude_email" value="1" Checked>
                    Exclude to create new lead: <input type="checkbox" name="exclude_newlead" value="1" Checked>
                </div>

                <div>
                    <a href="custom\modules\AOR_Reports\demo/inboundcallprocess.csv">(Sample Template)</a>
                    <input tabindex="2"  onclick="SUGAR.savedViews.setChooser();" class="button" type="submit" name="update_leadset" value="Upload" id="update_leadset">
                </div>
            </form> 


        </div>
    </div>
</div>

<br><br>
<h3 ><span>Upload CSV file to get The Report</span></h3>

<div class="dashboard-top-wrapper" id="dashboard-top-wrapperXX">
    <div class="dashboard-block">
        <h3 class="heading-title"><span>Numbers Found in CRM</span></h3>
        <div class="count">{$dataFoundinCRMTPLCount}</div>
        <div class="button-actions">
            <form name="search_dataFoundinCRMTPL" id="dataFoundinCRMTPL"  method="post" action="" enctype="multipart/form-data">
                <button type="submit" name="export_data_all_data_found" value="export_data_all_data_found" id="export_data_all_data_found">
                    <i style="font-size:24px" class="fa" >&#xf1c3;</i>
                </button>
            </form>
        </div>
    </div>

    <div class="dashboard-block">
        <h3 class="heading-title"><span>Organic Leads- No. Not Found</span></h3>
        <div class="count">{$organicleadsXCount}</div>
        <div class="button-actions">
            <form name="organicleads" id="organicleads"  method="post"  action=""  enctype="multipart/form-data">
                <button type="submit" name="organicleads" value="organicleads" id="organicleads">
                    <i style="font-size:24px" class="fa" >&#xf1c3;</i>
                </button>
            </form>
        </div>

    </div>

    
</div>


{literal}
    <style>
        .dashboard-top-wrapper{display:flex; width:100%}
        .dashboard-top-wrapper form{display:flex; width:100%; flex-direction: column;     height: 100%;}
        .dashboard-block{display: flex; flex-direction: column; margin-left: 10px; padding:10px; width: 100%; border:1px solid #e7e7e7; border-radius:5px; }
        .dashboard-block:first-child{margin-left:0;}
        .heading-title{display: flex; width: 100%; margin-bottom:15px; align-items: center; justify-content: center}
        .heading-title span{ font-size: 14px; color: #303188; text-transform: uppercase; font-weight: normal;}
        .dashboard-block .count{font-size:20px; display: flex; align-items: center; justify-content: center}
        .dashboard-block .button-actions{display: flex; width:100%; justify-content:center;}
        .dashboard-block .button-actions form{height:auto; align-items: center;}
        .dashboard-block .button-actions button{margin:0;}
        .dashboard-block .button-actions a span{margin:0 5px 0 0;}
        .dashboard-block .actions{margin-top:auto; display: flex; width:100%; align-items: center; justify-content:flex-end;}
        .dashboard-block .actions button{margin:0 0px 0 5px;}
        .dashboard-block .actions form{height:auto; align-items: center; width:auto;}
        .upload-block{display: flex; flex-direction: column; justify-content:space-between; width:100%;}
        .upload-block ul{margin:0 0 10px; padding:0; display:flex; width:100%; flex-direction: column; }
        .upload-block ul li{margin:0; padding:0; list-style-type: none; display:flex; width:100%;}
        .upload-block form{display: flex; flex-direction: column; width: auto;}
        .upload-block form input{width: 100%;}
        .upload-block form div{display: flex; align-items:center; width: 100%; justify-content: space-between;}
        .upload-block form div .button{width:auto;}
    </style>

    <script>

        $( document ).ready(function() {
               //$("#dashboard-top-wrapperXX").hide();
            });
        $("#search_upload").submit(function (e) {
            SUGAR.ajaxUI.showLoadingPanel();
            //return 
        });

    </script>
{/literal}


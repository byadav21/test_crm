<?php

// Date: Created on : 27th FEB 2018

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');
require_once('custom/modules/Leads/eloqua/lib/eloquaRequest.php');

//error_reporting(-1);
//ini_set('display_errors', 'On');
class AOR_ReportsVieweloquacontacts extends SugarView
{

    var $report_to_id;
    var $counsellors_arr;

    public function __construct()
    {
        parent::SugarView();
    }

    public function display()
    {

        global $sugar_config, $app_list_strings, $current_user, $db;

        $where   = "";
        $wherecl = "";





       /*
       if (isset($_POST['button']) || isset($_POST['export']))
        {
            $_SESSION['cccon_SearchIt'] = $_REQUEST['SearchIt'];
        }

        $search = '';
        $slug   = '?page=1&count=200';
        if (isset($_REQUEST['page']) && ($_REQUEST['page'] != 0 || $_REQUEST['page'] != ''))
        {
            //$_REQUEST['page']=100;
            $slug = '?page=' . $_REQUEST['page'] . '&count=200';
        }

        if (isset($_SESSION['cccon_SearchIt']) && $_SESSION['cccon_SearchIt'] != '')
        {
            $slug = '?search=*@test&page=' . $_REQUEST['page'] . '&count=200';
        }
        */
        
        //Ex: $list = $client->get('/data/contacts?search=*@test.com&count=1&page=1&depth=complete');  
        
        //echo $_SESSION['cccon_SearchIt'];

        $client = new EloquaRequest('https://secure.p07.eloqua.com/API/REST/1.0');



        $leadListData = array();
        $response     = $client->get('data/contacts' . $slug, $contact);
        //$array = (array) $response;
        $leadListData = $array['elements'];

        foreach ($response->elements as $key => $val)
        {
            //echo 'xxx'.$val->id;
            $leadList[$val->id]['id']           = $val->id;
            $leadList[$val->id]['name']         = $val->name;
            $leadList[$val->id]['emailAddress'] = $val->emailAddress;
        }




        //echo '<pre>'; print_r($leadList); die;
        #PS @Pawan
        $total = count($leadList); #total records

        $last_page = ceil($total / $per_page);

        if (isset($_REQUEST['page']) && $_REQUEST['page'] > 0)
        {
            $start    = $per_page * ($_REQUEST['page'] - 1);
            $page     = ($_REQUEST['page'] - 1);
            $pagenext = ($_REQUEST['page'] + 1);
        }
        else
        {

            $pagenext++;
        }
        if (($start + $per_page) < $total)
        {
            $right = 1;
        }
        else
        {
            $right = 0;
        }
        if (isset($_REQUEST['page']) && $_REQUEST['page'] == 1)
        {
            $left = 0;
        }
        elseif (isset($_REQUEST['page']))
        {

            $left = 1;
        }

        $leadList = array_slice($leadList, $start, $per_page);
        if ($total > $per_page)
        {
            $current = "(" . ($start + 1) . "-" . ($start + $per_page) . " of " . $total . ")";
        }
        else
        {
            $current = "(" . ($start + 1) . "-" . count($leadList) . " of " . $total . ")";
        }
        #pE

        $sugarSmarty = new Sugar_Smarty();

        $sugarSmarty->assign("error", $error);
        $sugarSmarty->assign("leadListx", $leadList);




        $sugarSmarty->assign("SearchIt", $_SESSION['cccon_SearchIt']);
        $sugarSmarty->assign("current_records", $current);
        $sugarSmarty->assign("page", $page);
        $sugarSmarty->assign("pagenext", $pagenext);
        $sugarSmarty->assign("right", $right);
        $sugarSmarty->assign("left", $left);
        $sugarSmarty->assign("last_page", $last_page);
        $sugarSmarty->display('custom/modules/AOR_Reports/tpls/eloquacontacts.tpl');
        
         ?>
        
        <script>
        
                $('#batchwisereferalsX').DataTable();
//                $('#BatchWiseTableId').dataTable({
//                    "aoColumnDefs": [{'bSortable': false, 'aTargets': [1]}],
//                    "order": [[0, "desc"]],
//                    'iDisplayLength': 10,
//                    language: {
//                        search: "_INPUT_",
//                        searchPlaceholder: "Search Here..."
//                    }
//                });
               
     
        </script>
        <link type="text/css" href="custom/modules/AOR_Reports/include/css/jquery_dataTable.css" rel="stylesheet" />
        <?php
        
    }
    
    

}
?>


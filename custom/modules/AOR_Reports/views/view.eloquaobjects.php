<?php

// Date: Created on : 27th FEB 2018

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
require_once('custom/include/Email/sendmail.php');
require_once('custom/modules/Leads/eloqua/lib/eloquaRequest.php');

//error_reporting(-1);
//ini_set('display_errors', 'On');
class AOR_ReportsVieweloquaobjects extends SugarView
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
        $response     = $client->get('/data/customObject/7', $contact);
        //$array = (array) $response;
        //$leadListData = $array['elements'];

        foreach ($response->elements as $key => $val)
        {  

            foreach ($val->fieldValues as $keyx => $valxx)
            {
                $leadList[$val->id]['fieldValues'][] = $valxx->value;
            }
        }




        echo '<pre>'; print_r($leadList); die;
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
        $sugarSmarty->display('custom/modules/AOR_Reports/tpls/eloquaobjects.tpl');
        
         ?>
        
        <script>
                $('#batchwisereferalsX').DataTable();
     
        </script>
        <link type="text/css" href="custom/modules/AOR_Reports/include/css/jquery_dataTable.css" rel="stylesheet" />
        <?php
        
    }
    
    

}
?>


<?php

require_once('include/MVC/View/views/view.list.php');
require_once('custom/modules/te_student/te_student_override.php');
require_once('modules/te_pr_Programs/te_pr_Programs.php');
require_once ('modules/ACLRoles/ACLRole.php');

class te_student_batchViewList extends ViewList
{

    /**
     * @see ViewList::preDisplay()
     */
    public function preDisplay()
    {
        echo '<script type="text/javascript" src="custom/modules/te_student_batch/student_batch.js"></script>';
        parent::preDisplay();
    }

    function listViewProcess()
    {
        global $current_user, $db;
        $this->report_to_id[] = $current_user->id;
        $reporting_UserIds    = $this->reportingUser($current_user->id);
        $uid                  = $this->report_to_id;
        $user_ids             = "'" . implode("','", $uid) . "'";
        $this->processSearchForm();
        #fetch managers id
        $managersSql          = "SELECT GROUP_CONCAT(`user_id`)user_id FROM `acl_roles_users` WHERE `role_id`='86800aa5-c8c2-5868-a690-58a88d188265' AND deleted=0";
        $managersObj          = $db->query($managersSql);
        $manager_res          = $db->fetchByAssoc($managersObj);
        $managers             = explode(',', $manager_res['user_id']);

        if ($managers)
        {
            if ($current_user->is_admin == 1)
            {
                array_push($managers, $current_user->id);
            }
        }
        else
        {
            if ($current_user->is_admin == 1)
            {
                $managers[0] = $current_user->id;
            }
        }
        if (isset($_REQUEST['batch']) && !empty($_REQUEST['batch']) && !empty($this->where))
        {
            $this->where .= " AND te_student_batch.te_ba_batch_id_c IN('" . $_REQUEST['batch'] . "')";
        }
        elseif (isset($_REQUEST['batch']) && !empty($_REQUEST['batch']) && empty($this->where))
        {
            $this->where = " te_student_batch.te_ba_batch_id_c IN('" . $_REQUEST['batch'] . "')";
        }


        $add         = '';
        $dropout     = '';
        $new_dropout = '';
        if (isset($_GET['new_conversion']) && $_GET['new_conversion'] == 1)
        {
            $add = " (is_new = 1) AND  te_student_batch.status='Active' ";
            echo "<input type='hidden' name='new_conversion' value='1'>";
        }

        if (isset($_GET['dropout_count']) && $_GET['dropout_count'] == 1)
        {

            $dropout = " AND te_student_batch.is_new_dropout='1' AND te_student_batch.deleted=0 ";
        }

        if (isset($_GET['new_dropout']) && $_GET['new_dropout'] == 1)
        {

            echo "<input type='hidden' name='new_dropout' value='1'>";
        }

        if (isset($_GET['type']) && $_GET['type'] == 'new_dropout')
        {
            //echo 'testing====  ';
            //$new_dropout = " AND te_student_batch.is_new_dropout='1' AND te_student_batch.deleted=0 ";
            //$this->join .= " te_student_batch INNER JOIN leads l ON te_student_batch.leads_id=l.id and  l.is_new_dropout='1'  AND l.deleted=0";
            //$this->params['custom_where'] = ' AND opportunities.sales_stage <> "Closed Lost" ';
        }



        if (!in_array($current_user->id, $managers))
        {
            if ($this->where != "")
            {
                $this->where .= " AND te_student_batch.assigned_user_id IN($user_ids) $add $dropout $new_dropout";
            }
            else
            {
                $this->where .= " te_student_batch.assigned_user_id IN($user_ids) $add $dropout $new_dropout";
            }
        }
        if ($current_user->is_admin == 1 && $_GET['new_conversion'] == 1)
        {

            $this->where .= "   $add ";
        }

        if ($current_user->is_admin == 1 && $_GET['dropout_count'] == 1)
        {

            $this->where .= "   $dropout ";
        }

        //echo $this->where;
        //echo 'sssssssssss'.$add;
        /* if($current_user->designation=="BUH"){
          if($this->where!="")
          $this->where .= " AND te_student_batch.dropout_status ='Pending'";
          else
          $this->where .= " te_student_batch.dropout_status ='Pending'";
          } */



        //echo $this->where;
        $this->lv->searchColumns = $this->searchForm->searchColumns;
        if (!$this->headers)
            return;
        if (empty($_REQUEST['search_form_only']) || $_REQUEST['search_form_only'] == false)
        {

            $this->params['orderBy']       = 'date_entered';
            $this->params['overrideOrder'] = '1';
            $this->params['sortOrder']     = 'DESC';

            $tplFile = 'custom/modules/te_student_batch/tpls/listing.tpl';
            $this->lv->setup($this->seed, $tplFile, $this->where, $this->params);
            echo $this->lv->display();
        }
    }

    function reportingUser($currentUserId)
    {
        $userObj                             = new User();
        $userObj->disable_row_level_security = true;
        $userList                            = $userObj->get_full_list("", "users.reports_to_id='" . $currentUserId . "'");
        if (!empty($userList))
        {
            foreach ($userList as $record)
            {
                if (!empty($record->reports_to_id) && !empty($record->id))
                {
                    $this->report_to_id[] = $record->id;
                    $this->reportingUser($record->id);
                }
            }
        }
    }

    public function displayHeader()
    {

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

            $tracker = new Tracker();
            $history = $tracker->get_recently_viewed($current_user->id);
            $ss->assign("recentRecords", $this->processRecentRecords($history));
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
                // $groupTabs[$tabIdx]['extra'] = $extraTabs;
            }
        }

        if (isset($topTabList) && is_array($topTabList))
        {
            // Adding shortcuts array to menu array for displaying shortcuts associated with each module
            $shortcutTopMenu = array();
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
            if (!empty($sugar_config['lock_homepage']) && $sugar_config['lock_homepage'] == true)
                $ss->assign('lock_homepage', true);
            $ss->assign("groupTabs", $groupTabs);
            $ss->assign("shortcutTopMenu", $shortcutTopMenu);
            $ss->assign('USE_GROUP_TABS', $usingGroupTabs);

            // This is here for backwards compatibility, someday, somewhere, it will be able to be removed
            $ss->assign("moduleTopMenu", $groupTabs[$app_strings['LBL_TABGROUP_ALL']]['modules']);
            $ss->assign("moduleExtraMenu", $groupTabs[$app_strings['LBL_TABGROUP_ALL']]['extra']);

// Show the custom panel in the left panel


            global $current_user;
            $currentUserId = $current_user->id;
            $obj           = new te_student_override();

            $currentUserId                     = $current_user->id;
            $reportingUserIds                  = array();
            $obj->reportingUser($currentUserId);
            $obj->report_to_id[$currentUserId] = $current_user->name;
            $reportingUserIds                  = $obj->report_to_id;
            $user_ids                          = implode("', '", array_keys($reportingUserIds));
            if ($current_user->isAdmin())
                $user_ids                          = '';
            $newconv                           = $obj->newConversion($user_ids);
            $dropconv                          = $obj->newDropOut($user_ids);
            $dropconCall                       = $obj->newDropOutCallcenter($user_ids);
            $myRefrals                         = $obj->getMyreferals($current_user->id);
            $approved                          = $obj->approvedTransfer($user_ids);
            $dropped                           = $obj->droppedTransfer($user_ids);
            $newreg                            = '<div class="col-sm-2 text-center tile_stats_counts">
						<div class="count"><a href="' . (intval($newconv['newconv']) == 0 ? '#' : 'index.php?action=index&type=new_conversion&module=te_student_batch&new_conversion=1') . '">' . intval($newconv['newconv']) . '</a></div>
						<span class="count_top">New Conversion</span>
					</div>';
            $newreg                            .= '<div class="col-sm-2 text-center tile_stats_counts">
						<div class="count"><a href="index.php?module=te_student_batch&action=dropoutrequest&type=dropout&dropout_count=1">' . intval($dropconv['newconv']) . '</a></div>
						<span class="count_top"> Drop Out</span>
					</div>';
            $newreg                            .= '<div class="col-sm-2 text-center tile_stats_counts">
						<div class="count"><a href="' . (intval($dropconCall['newconv']) == 0 ? '#' : 'index.php?searchFormTab=basic_search&module=te_student_batch&action=index&query=true&is_new_dropout_basic=1&type=new_dropout') . '">' . intval($dropconCall['newconv']) . '</a></div>
						<span class="count_top"> Call Center Drop Out</span>
					</div>';
            $newreg                            .= '<div class="col-sm-2 text-center tile_stats_counts">
						<div class="count"><a href="index.php?action=seen&type=refral&module=te_student_batch">' . intval($myRefrals['newconv']) . '</a></div>
						<span class="count_top"> My Referrals</span>
					</div>';
            $newreg                            .= '<div class="col-sm-2 text-center tile_stats_counts">
						<div class="count"><a href="' . (intval($approved['newconv']) == 0 ? '#' : 'index.php?module=te_transfer_batch&is_new_approved_basic=1') . '">' . intval($approved['newconv']) . '</a></div>
						<span class="count_top"> Approved Transfer</span>
					</div>';
            $newreg                            .= '<div class="col-sm-2 text-center tile_stats_counts">
						<div class="count"><a href="' . (intval($dropped['newconv']) == 0 ? '#' : 'index.php?module=te_student_batch&action=dropoutrequest&is_new_dropout_basic=1') . '">' . intval($dropped['newconv']) . '</a></div>
						<span class="count_top"> Approved Dropout</span>
					</div>';
            $ss->assign("statusWiseCount", $newreg);
            // index.php?module=te_student_batch&action=dropoutrequest&type=dropout
            //$ss->assign("csshack",'leadpage');
            //$ss->assign("csshack",'leadpage');
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

}

//tpl fun
function getisSent($id)
{
    global $current_user;
    $obj = new te_student_override();
    //get Student ID
   // $sid = $obj->getStudentID($id);

    $data = $obj->getApproval($id);
    echo (!$data || $data['status']!='Pending') ? '<a href="javascript:void(0)" class=" " ng-click="openTransfer(\'' . $id . '\')">Transfer Batch</a>' : 'Pending';
}

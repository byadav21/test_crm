<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('include/MVC/View/views/view.detail.php');
require_once('include/utils.php');
require_once('include/DetailView/DetailView2.php');
class LeadsViewDetail extends ViewDetail {



	protected function _displaySubPanels()
    {


    }

    public function preDisplay()
    {
 	    $metadataFile = $this->getMetaDataFile();
 	    $this->dv = new DetailView2();
 	    $this->dv->ss =&  $this->ss;
 	    $this->dv->setup($this->module, $this->bean, $metadataFile, get_custom_file_if_exists('custom/modules/Leads/tpls/DetailView/DetailView.tpl'));
    }



 	/**
     * Displays the header on section of the page; basically everything before the content
     */
    public function displayHeader($retModTabs=false)
    {

		 //~ parent::displayHeader();
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
        $theme = $themeObject->__toString();

        $ss = new Sugar_Smarty();
        $ss->assign("APP", $app_strings);
        $ss->assign("THEME", $theme);
        $ss->assign("THEME_CONFIG", $themeObject->getConfig());
        $ss->assign("THEME_IE6COMPAT", $themeObject->ie6compat ? 'true':'false');
        $ss->assign("MODULE_NAME", $this->module);
        $ss->assign("langHeader", get_language_header());

        // set ab testing if exists
        $testing = (isset($_REQUEST["testing"]) ? $_REQUEST['testing'] : "a");
        $ss->assign("ABTESTING", $testing);

        // get browser title
        $ss->assign("SYSTEM_NAME", $this->getBrowserTitle());

        // get css
        $css = $themeObject->getCSS();
        if ($this->_getOption('view_print')) {
            $css .= '<link rel="stylesheet" type="text/css" href="'.$themeObject->getCSSURL('print.css').'" media="all" />';
        }
        $ss->assign("SUGAR_CSS",$css);

        // get javascript
        ob_start();
        $this->renderJavascript();

        $ss->assign("SUGAR_JS",ob_get_contents().$themeObject->getJS());
        ob_end_clean();

        // get favicon
        if(isset($GLOBALS['sugar_config']['default_module_favicon']))
            $module_favicon = $GLOBALS['sugar_config']['default_module_favicon'];
        else
            $module_favicon = false;

        $favicon = $this->getFavicon();
        $ss->assign('FAVICON_URL', $favicon['url']);

        // build the shortcut menu
        $shortcut_menu = array();
        foreach ( $this->getMenu() as $key => $menu_item )
            $shortcut_menu[$key] = array(
                "URL"         => $menu_item[0],
                "LABEL"       => $menu_item[1],
                "MODULE_NAME" => $menu_item[2],
                "IMAGE"       => $themeObject
                    ->getImage($menu_item[2],"border='0' align='absmiddle'",null,null,'.gif',$menu_item[1]),
                );
        $ss->assign("SHORTCUT_MENU",$shortcut_menu);

        // handle rtl text direction
        if(isset($_REQUEST['RTL']) && $_REQUEST['RTL'] == 'RTL'){
            $_SESSION['RTL'] = true;
        }
        if(isset($_REQUEST['LTR']) && $_REQUEST['LTR'] == 'LTR'){
            unset($_SESSION['RTL']);
        }
        if(isset($_SESSION['RTL']) && $_SESSION['RTL']){
            $ss->assign("DIR", 'dir="RTL"');
        }

        // handle resizing of the company logo correctly on the fly
        $companyLogoURL = $themeObject->getImageURL('company_logo.png');
        $companyLogoURL_arr = explode('?', $companyLogoURL);
        $companyLogoURL = $companyLogoURL_arr[0];

        $company_logo_attributes = sugar_cache_retrieve('company_logo_attributes');
        if(!empty($company_logo_attributes)) {
            $ss->assign("COMPANY_LOGO_MD5", $company_logo_attributes[0]);
            $ss->assign("COMPANY_LOGO_WIDTH", $company_logo_attributes[1]);
            $ss->assign("COMPANY_LOGO_HEIGHT", $company_logo_attributes[2]);
        }
        else {
            // Always need to md5 the file
            $ss->assign("COMPANY_LOGO_MD5", md5_file($companyLogoURL));

            list($width,$height) = getimagesize($companyLogoURL);
            if ( $width > 212 || $height > 40 ) {
                $resizePctWidth  = ($width - 212)/212;
                $resizePctHeight = ($height - 40)/40;
                if ( $resizePctWidth > $resizePctHeight )
                    $resizeAmount = $width / 212;
                else
                    $resizeAmount = $height / 40;
                $ss->assign("COMPANY_LOGO_WIDTH", round($width * (1/$resizeAmount)));
                $ss->assign("COMPANY_LOGO_HEIGHT", round($height * (1/$resizeAmount)));
            }
            else {
                $ss->assign("COMPANY_LOGO_WIDTH", $width);
                $ss->assign("COMPANY_LOGO_HEIGHT", $height);
            }

            // Let's cache the results
            sugar_cache_put('company_logo_attributes',
                            array(
                                $ss->get_template_vars("COMPANY_LOGO_MD5"),
                                $ss->get_template_vars("COMPANY_LOGO_WIDTH"),
                                $ss->get_template_vars("COMPANY_LOGO_HEIGHT")
                                )
            );
        }
        $ss->assign("COMPANY_LOGO_URL",getJSPath($companyLogoURL)."&logo_md5=".$ss->get_template_vars("COMPANY_LOGO_MD5"));

        // get the global links
        $gcls = array();
        $global_control_links = array();
        require("include/globalControlLinks.php");

        foreach($global_control_links as $key => $value) {
            if ($key == 'users')  {   //represents logout link.
                $ss->assign("LOGOUT_LINK", $value['linkinfo'][key($value['linkinfo'])]);
                $ss->assign("LOGOUT_LABEL", key($value['linkinfo']));//key value for first element.
                continue;
            }

            foreach ($value as $linkattribute => $attributevalue) {
                // get the main link info
                if ( $linkattribute == 'linkinfo' ) {
                    $gcls[$key] = array(
                        "LABEL" => key($attributevalue),
                        "URL"   => current($attributevalue),
                        "SUBMENU" => array(),
                        );
                   if(substr($gcls[$key]["URL"], 0, 11) == "javascript:") {
                       $gcls[$key]["ONCLICK"] = substr($gcls[$key]["URL"],11);
                       $gcls[$key]["URL"] = "javascript:void(0)";
                   }
                }
                // and now the sublinks
                if ( $linkattribute == 'submenu' && is_array($attributevalue) ) {
                    foreach ($attributevalue as $submenulinkkey => $submenulinkinfo)
                        $gcls[$key]['SUBMENU'][$submenulinkkey] = array(
                            "LABEL" => key($submenulinkinfo),
                            "URL"   => current($submenulinkinfo),
                        );
                       if(substr($gcls[$key]['SUBMENU'][$submenulinkkey]["URL"], 0, 11) == "javascript:") {
                           $gcls[$key]['SUBMENU'][$submenulinkkey]["ONCLICK"] = substr($gcls[$key]['SUBMENU'][$submenulinkkey]["URL"],11);
                           $gcls[$key]['SUBMENU'][$submenulinkkey]["URL"] = "javascript:void(0)";
                       }
                }
            }
        }
        $ss->assign("GCLS",$gcls);

        $ss->assign("SEARCH", isset($_REQUEST['query_string']) ? $_REQUEST['query_string'] : '');

        if ($this->action == "EditView" || $this->action == "Login")
            $ss->assign("ONLOAD", 'onload="set_focus()"');

        $ss->assign("AUTHENTICATED",isset($_SESSION["authenticated_user_id"]));

        // get other things needed for page style popup
        if (isset($_SESSION["authenticated_user_id"])) {
            // get the current user name and id
            $ss->assign("CURRENT_USER", $current_user->full_name == '' || !showFullName()
                ? $current_user->user_name : $current_user->full_name );
            $ss->assign("CURRENT_USER_ID", $current_user->id);

            // get the last viewed records
            require_once("modules/Favorites/Favorites.php");
            $favorites = new Favorites();
            $favorite_records = $favorites->getCurrentUserSidebarFavorites();
            $ss->assign("favoriteRecords",$favorite_records);

            /*$tracker = new Tracker();
            $history = $tracker->get_recently_viewed($current_user->id);
            $ss->assign("recentRecords",$this->processRecentRecords($history));*/
        }

        $bakModStrings = $mod_strings;
        if (isset($_SESSION["authenticated_user_id"]) ) {
            // get the module list
            $moduleTopMenu = array();

            $max_tabs = $current_user->getPreference('max_tabs');
            // Attempt to correct if max tabs count is extremely high.
            if ( !isset($max_tabs) || $max_tabs <= 0 || $max_tabs > 10 ) {
                $max_tabs = $GLOBALS['sugar_config']['default_max_tabs'];
                $current_user->setPreference('max_tabs', $max_tabs, 0, 'global');
            }

            $moduleTab = $this->_getModuleTab();
            $ss->assign('MODULE_TAB',$moduleTab);


            // See if they are using grouped tabs or not (removed in 6.0, returned in 6.1)
            $user_navigation_paradigm = $current_user->getPreference('navigation_paradigm');
            if ( !isset($user_navigation_paradigm) ) {
                $user_navigation_paradigm = $GLOBALS['sugar_config']['default_navigation_paradigm'];
            }


            // Get the full module list for later use
            foreach ( query_module_access_list($current_user) as $module ) {
                // Bug 25948 - Check for the module being in the moduleList
                if ( isset($app_list_strings['moduleList'][$module]) ) {
                    $fullModuleList[$module] = $app_list_strings['moduleList'][$module];
                }
            }


            if(!should_hide_iframes()) {
                $iFrame = new iFrame();
                $frames = $iFrame->lookup_frames('tab');
                foreach($frames as $key => $values){
                        $fullModuleList[$key] = $values;
                }
            }
            elseif (isset($fullModuleList['iFrames'])) {
                unset($fullModuleList['iFrames']);
            }

            if ( $user_navigation_paradigm == 'gm' && isset($themeObject->group_tabs) && $themeObject->group_tabs) {
                // We are using grouped tabs
                require_once('include/GroupedTabs/GroupedTabStructure.php');
                $groupedTabsClass = new GroupedTabStructure();
                $modules = query_module_access_list($current_user);

                //handle with submoremodules
                $max_tabs = $current_user->getPreference('max_tabs');
                // If the max_tabs isn't set incorrectly, set it within the range, to the default max sub tabs size
                if ( !isset($max_tabs) || $max_tabs <= 0 || $max_tabs > 10){
                    // We have a default value. Use it
                    if(isset($GLOBALS['sugar_config']['default_max_tabs'])){
                        $max_tabs = $GLOBALS['sugar_config']['default_max_tabs'];
                    }
                    else{
                        $max_tabs = 8;
                    }
                }

                $subMoreModules = false;
                $groupTabs = $groupedTabsClass->get_tab_structure(get_val_array($modules));
                // We need to put this here, so the "All" group is valid for the user's preference.
                $groupTabs[$app_strings['LBL_TABGROUP_ALL']]['modules'] = $fullModuleList;


                // Setup the default group tab.
                $allGroup = $app_strings['LBL_TABGROUP_ALL'];
                $ss->assign('currentGroupTab',$allGroup);
                $currentGroupTab = $allGroup;
                $usersGroup = $current_user->getPreference('theme_current_group');
                // Figure out which tab they currently have selected (stored as a user preference)
                if ( !empty($usersGroup) && isset($groupTabs[$usersGroup]) ) {
                    $currentGroupTab = $usersGroup;
                } else {
                    $current_user->setPreference('theme_current_group',$currentGroupTab);
                }

                $ss->assign('currentGroupTab',$currentGroupTab);
                $usingGroupTabs = true;

            } else {
                // Setup the default group tab.
                $ss->assign('currentGroupTab',$app_strings['LBL_TABGROUP_ALL']);

                $usingGroupTabs = false;
                $groupTabs[$app_strings['LBL_TABGROUP_ALL']]['modules'] = $fullModuleList;

            }


            $topTabList = array();

            // Now time to go through each of the tab sets and fix them up.
            foreach ( $groupTabs as $tabIdx => $tabData ) {
                $topTabs = $tabData['modules'];
                if ( ! is_array($topTabs) ) {
                    $topTabs = array();
                }
                $extraTabs = array();

                // Split it in to the tabs that go across the top, and the ones that are on the extra menu.
                if ( count($topTabs) > $max_tabs ) {
                    $extraTabs = array_splice($topTabs,$max_tabs);
                }
                // Make sure the current module is accessable through one of the top tabs
                if ( !isset($topTabs[$moduleTab]) ) {
                    // Nope, we need to add it.
                    // First, take it out of the extra menu, if it's there
                    if ( isset($extraTabs[$moduleTab]) ) {
                        unset($extraTabs[$moduleTab]);
                    }
                    if ( count($topTabs) >= $max_tabs - 1 ) {
                        // We already have the maximum number of tabs, so we need to shuffle the last one
                        // from the top to the first one of the extras
                        $lastElem = array_splice($topTabs,$max_tabs-1);
                        $extraTabs = $lastElem + $extraTabs;
                    }
                    if ( !empty($moduleTab) ) {
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
                foreach ( $topTabs as $moduleKey => $module ) {
                    $topTabList[$moduleKey] = $module;
                }

                //$groupTabs[$tabIdx]['modules'] = $topTabs;
                //$groupTabs[$tabIdx]['extra'] = $extraTabs;
            }
        }

        if ( isset($topTabList) && is_array($topTabList) ) {
            // Adding shortcuts array to menu array for displaying shortcuts associated with each module
            $shortcutTopMenu = array();
						if(!isset($_SESSION['referral'])){
							foreach($topTabList as $module_key => $label) {
	                global $mod_strings;
	                $mod_strings = return_module_language($current_language, $module_key);
	                foreach ( $this->getMenu($module_key) as $key => $menu_item ) {
	                    $shortcutTopMenu[$module_key][$key] = array(
	                        "URL"         => $menu_item[0],
	                        "LABEL"       => $menu_item[1],
	                        "MODULE_NAME" => $menu_item[2],
	                        "IMAGE"       => $themeObject
	                        ->getImage($menu_item[2],"border='0' align='absmiddle'",null,null,'.gif',$menu_item[1]),
	                        "ID"          => $menu_item[2]."_link",
	                        );
	                }
	            }
						}
						else{
	                    /*$shortcutTopMenu['Leads'][0] = array(
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
											);*/
						}
            if(!empty($sugar_config['lock_homepage']) && $sugar_config['lock_homepage'] == true) $ss->assign('lock_homepage', true);
            $ss->assign("groupTabs",$groupTabs);
            $ss->assign("shortcutTopMenu",$shortcutTopMenu);
            $ss->assign('USE_GROUP_TABS',$usingGroupTabs);

            // This is here for backwards compatibility, someday, somewhere, it will be able to be removed
            $ss->assign("moduleTopMenu",$groupTabs[$app_strings['LBL_TABGROUP_ALL']]['modules']);
            $ss->assign("moduleExtraMenu",$groupTabs[$app_strings['LBL_TABGROUP_ALL']]['extra']);


// Show the custom panel in the left panel

if(!isset($_SESSION['referral'])){
	require_once('custom/modules/Leads/customfunctionforcrm.php');
	global $current_user;
	$currentUserId = $current_user->id;
	$reportingUserIds = array();
	$reportUserObj1 = new customfunctionforcrm();
	$statusWiseCount = $reportUserObj1->statusWiseCounts();


	$ss->assign("statusWiseCount",$statusWiseCount);
}
			$ss->assign("csshack",'leadpage');






        }


		//~ echo $test;die;
        if ( isset($extraTabs) && is_array($extraTabs) ) {
            // Adding shortcuts array to extra menu array for displaying shortcuts associated with each module
            $shortcutExtraMenu = array();
            foreach($extraTabs as $module_key => $label) {
                global $mod_strings;
                $mod_strings = return_module_language($current_language, $module_key);
                foreach ( $this->getMenu($module_key) as $key => $menu_item ) {
                    $shortcutExtraMenu[$module_key][$key] = array(
                        "URL"         => $menu_item[0],
                        "LABEL"       => $menu_item[1],
                        "MODULE_NAME" => $menu_item[2],
                        "IMAGE"       => $themeObject
                        ->getImage($menu_item[2],"border='0' align='absmiddle'",null,null,'.gif',$menu_item[1]),
                        "ID"          => $menu_item[2]."_link",
                        );
                }
            }
            $ss->assign("shortcutExtraMenu",$shortcutExtraMenu);
        }

       if(!empty($current_user)){
       	$ss->assign("max_tabs", $current_user->getPreference("max_tabs"));
       }


        $imageURL = SugarThemeRegistry::current()->getImageURL("dashboard.png");
        $homeImage = "<img src='$imageURL'>";
		$ss->assign("homeImage",$homeImage);
        global $mod_strings;
        $mod_strings = $bakModStrings;
        $headerTpl = $themeObject->getTemplate('header.tpl');
        if (inDeveloperMode() )
            $ss->clear_compiled_tpl($headerTpl);
	//~ echo $themeObject->getTemplate('_headerModuleList.tpl');die;
        if ($retModTabs)
        {
            return $ss->fetch($themeObject->getTemplate('_headerModuleList.tpl'));
        } else {
            $ss->display($headerTpl);

            $this->includeClassicFile('modules/Administration/DisplayWarnings.php');

            $errorMessages = SugarApplication::getErrorMessages();
            if ( !empty($errorMessages)) {
                foreach ( $errorMessages as $error_message ) {
                    echo('<p class="error">' . $error_message.'</p>');
                }
            }
        }

    }

	public function display(){		
		
		global $current_user;
		if(!is_admin($current_user)){
			 
			//check users
			self::$reporters[]=$this->bean->assigned_user_id;
			self::getUsers($this->bean->assigned_user_id);			 
			if(!in_array($current_user->id,self::$reporters)){
				echo 'You have not access to view this record'; exit();
			}
			

		}


		require_once ('include/SubPanel/SubPanelTiles.php');
			$subpanel = new SubPanelTiles($this->bean, $this->module);
			 // $ss->assign("customtabs", $subpanel->displayinPanel());
			  //$ss->assign("mycustomtabs", 'Pankaj');
		 $returnedTabs=$subpanel->displayinPanel();

		 $this->dv->ss->assign('subpanel_tabs', $returnedTabs['tab']);
		 $this->dv->ss->assign('subpanel_tabs_properties', $returnedTabs['properties']);


		require_once('custom/modules/Leads/customfunctionforcrm.php');
		$reportingUserIds = array();
		$currentUserId = $current_user->id;
		$reportUserObj = new customfunctionforcrm();
		$reportUserObj->reportingUser($currentUserId);
		$reportUserObj->report_to_id[$currentUserId] = $current_user->name;
		$reportingUserIds = $reportUserObj->report_to_id;

		if (!array_key_exists($this->bean->assigned_user_id,$reportingUserIds)){
				echo "<span> You don't have access to view this record</span>";
					//~ die;
		}
		if(!empty($this->bean->phone_mobile)){
			$this->bean->phone_mobile .=  '  <img src="custom/themes/default/images/phone.png" href="" onclick="clickToCall('.$this->bean->phone_mobile.',\''.$this->bean->id.'\')" alt="Smiley face" height="20" width="20">';
		}
		if(!empty($this->bean->phone_other)){
			$this->bean->phone_other .=  '  <img src="custom/themes/default/images/phone.png" href="" onclick="clickToCall('.$this->bean->phone_mobile.',\''.$this->bean->id.'\')" alt="Smiley face" height="20" width="20">';
		}

		if(!empty($this->bean->te_ba_batch_id_c)){

// Get Institute details based on the Batch
			$sql_pro = "SELECT te_pr_programs_te_ba_batch_1te_pr_programs_ida,name FROM te_pr_programs p INNER JOIN te_pr_programs_te_ba_batch_1_c  pb ON p.id = pb.te_pr_programs_te_ba_batch_1te_pr_programs_ida WHERE te_pr_programs_te_ba_batch_1te_ba_batch_idb = '".$this->bean->te_ba_batch_id_c."' AND pb.deleted = 0 AND p.deleted=0";
			$res_pro = $GLOBALS['db']->query($sql_pro);
			$pro = $GLOBALS['db']->fetchByAssoc($res_pro);
			$pid = $pro['te_pr_programs_te_ba_batch_1te_pr_programs_ida'];
			$this->bean->program = "<a href='index.php?action=DetailView&module=te_pr_Programs&record={$pid}'>".$pro['name']."</a>";

// Get Institute details based on the Batch

			$sql_ins = "SELECT te_in_institutes_te_ba_batch_1te_in_institutes_ida,name FROM te_in_institutes i INNER JOIN  te_in_institutes_te_ba_batch_1_c ib ON i.id = ib.te_in_institutes_te_ba_batch_1te_in_institutes_ida WHERE te_in_institutes_te_ba_batch_1te_ba_batch_idb = '".$this->bean->te_ba_batch_id_c."' AND ib.deleted = 0 AND i.deleted=0";
			$res_ins = $GLOBALS['db']->query($sql_ins);
			$ins = $GLOBALS['db']->fetchByAssoc($res_ins);
			$iid = $ins['te_in_institutes_te_ba_batch_1te_in_institutes_ida'];
			$this->bean->institute = "<a href='index.php?action=DetailView&module=te_in_institutes&record={$iid}'>".$ins['name']."</a>";

			$sql_ins = "SELECT id,te_ba_batch.name FROM te_ba_batch  WHERE id = '".$this->bean->te_ba_batch_id_c . "'";
			$res_ins = $GLOBALS['db']->query($sql_ins);
			$ins = $GLOBALS['db']->fetchByAssoc($res_ins);
			$iid = $ins['id'];
			$this->bean->batches = "<a href='index.php?action=DetailView&module=te_ba_Batch&record={$iid}'>".$ins['name']."</a>";



		}

		$overview=array();
		$overview['name']=$this->bean->name;
		$overview['email']=$this->bean->email1;
		$overview['mobile']=$this->bean->phone_mobile;
		$overview['batch']=$this->bean->batches;
		$overview['note']=$this->bean->note;
		$overview['institute'] = $this->bean->institute;
		$overview['programe'] = $this->bean->program;
		$overview['status'] = $this->bean->status;
		$overview['statusDetail'] = $this->bean->status_description;
		$overview['dated'] = $this->bean->date_entered;//DATE_ENTERED;
		//print_r($overview);die;
		$this->dv->ss->assign('overview',$overview);
		?>

<script>


    $(document).ready(function () {
			var table 	 	= document.getElementById('detailpanel_1').getElementsByTagName('TBODY')[0].rows;
			var rowCount 	= table.length;
			var mcount		= rowCount;
			var TScount		= rowCount;
			//~ alert(rowCount)
			if(document.getElementById('lead_source').value!='Referrals'){
				rowCount	 	= rowCount-3;
				var y		 	= table[rowCount].cells
				y[2].innerHTML	='';
			}
		    $("#status").change(function() {
				alert(1)
			});
   });
	 <?php if(isset($_SESSION['referral'])){//unset($_SESSION['referral']);?>
	 	 $(function(){
			$(".sugar_action_button").hide();
			$("#create_link").hide();
		 });

	 <?php }?>

  function generateInvoice(lead_id){
	  //~ alert(lead_id)
	  //~ window.location.href='index.php?entryPoint=generateInvoice&LeadID='+lead_id;
	  window.open('index.php?entryPoint=generateInvoice&LeadID='+lead_id, '_blank');
	}
  function clickToCall(phone,lead_id){

		//~ alert(phone)
		if(confirm('Are you sure to make a call')){
			SUGAR.ajaxUI.showLoadingPanel();
			var callback = {
				success:function(b){
					SUGAR.ajaxUI.hideLoadingPanel();
					if(b.responseText) swal(b.responseText);
				}

			}

			var connectionObject = YAHOO.util.Connect.asyncRequest('GET', 'index.php?entryPoint=clickToCall&lead='+ lead_id +'&number='+phone, callback);
		 }
	}

	function updateleadseenunseen(lid){

		var lead_id = $("#seenbtn").data('lid');
		SUGAR.ajaxUI.showLoadingPanel();
		$.ajax({url: "index.php?entryPoint=seen_unseen&lead_id="+lead_id, success: function(result){
			SUGAR.ajaxUI.hideLoadingPanel();
			if(result==1){
				$("#seenbtn").text("Unseen");
				return true;
			}else{
				alert("Unable to mark Seen!");
				return false;
			}

		}});

	}
	$(document).ready(function() {
		//function to hide edit button on lead details page
		if($("#seenbtn").attr('data-seen')=='1') {
		  $(document).ajaxComplete(function() {
 		   //$("#delete_button").hide();
		   //$("#edit_button_old").hide();
		   //$("#edit_button").hide();
		   $(".clickMenu").hide();
		  });
		}
	});




     </script>


<?php

		parent::display();
		//~ require_once('custom/modules/Leads/include/ShowCallPopup.html');
	}
	
	public static $reporters=array();
	public static function getUsers($userID){
	 global $db;
	 
		 $sql="select reports_to_id from users where id='" . $userID. "' and deleted=0";
		 $res=$db->query($sql);	
		 
		 if($db->getRowCount($res) > 0){
			 $records=$db->fetchByAssoc($res);
			 if($records['reports_to_id']){	
				 self::$reporters[]=$records['reports_to_id'];
				 self::getUsers($records['reports_to_id']);
			 }
		 }	 
		
		
	}

}
?>

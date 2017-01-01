<?php
/* * *******************************************************************************
 * This file is part of KReporter. KReporter is an enhancement developed
 * by Christian Knoll. All rights are (c) 2012 by Christian Knoll
 *
 * This Version of the KReporter is licensed software and may only be used in
 * alignment with the License Agreement received with this Software.
 * This Software is copyrighted and may not be further distributed without
 * witten consent of Christian Knoll
 *
 * You can contact us at info@kreporter.org
 * ****************************************************************************** */
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

$mod_strings = array(
    'LBL_SAVE_BUTTON_LABEL' => 'Save',
    'LBL_CANCEL_BUTTON_LABEL' => 'Cancel',
    'LBL_REPORT_NAME_LABEL' => 'Name',
    'LBL_LOADMASK' => '... loading data ...',
    'LBL_ASSIGNED_USER_LABEL' => 'User',
    'LBL_ASSIGNED_TEAM_LABEL' => 'Team',
    'LBL_KORGOBJECTS_LABEL' => 'Territory',
    'LBL_REPORT_OPTIONS' => 'Options',
    'LBL_DEFAULT_NAME' => 'new Report',
    'LBL_SEARCHING' => 'searching ...',
    'LBL_LONGTEXT_LABEL' => 'Description',
    'LBL_DEFAULT_NAME' => 'New Report',
    'LBL_CHART_NODATA' => 'no DATA from K Reporter to display available',
    'LBL_REPORT_RELOAD' => 'Apply Filters',
    'LBL_LIST_LISTTYPE' => 'List Type',
    'LBL_LIST_CHART_LAYOUT' => 'Chart Layout',
    'LBL_LIST_DATEENTERED' => 'Date created',
    'LBL_LIST_DATEMODIFIED' => 'Date changed',
    'LBL_SEARCHING' => 'Searching...',
    'LBL_AUTH_CHECK' => 'Authorization Check',
    'LBL_AUTH_FULL' => 'On all Nodes',
    'LBL_AUTH_TOP' => 'Top Node only',
    'LBL_AUTH_NONE' => 'Disabled',
    'LBL_SHOW_DELETED' => 'Show deleted',
    'LBL_FOLDED_PANELS' => 'Collapsible Panels',
    'LBL_DYNOPTIONS' => 'Dynamic Options',
    'LBL_RESULTS' => 'Results collapsed',
    'LBL_PANEL_OPEN' => 'open',
    'LBL_PANEL_COLLAPSED' => 'collapsed',
    'LBL_OPTIONS_MENUITEMS' => 'Toolbar Items',
    'LBL_ADVANCEDOPTIONS_MENUITEMS' => 'Advanced Options',
    'LBL_AOP_EXPORTTOPLANNING' => 'Export to Planning Nodes',
    'LBL_TOOLBARITEMS_FS' => 'Toolbar Items',
    'LBL_TOOLBARITEMS_SHOW' => 'Show',
    'LBL_SHOW_EXPORT' => 'Export',
    'LBL_SHOW_SNAPSHOTS' => 'Snapshots',
    'LBL_SHOW_TOOLS' => 'Tools',
    'LBL_DATA_UPDATE' => 'Data update',
    'LBL_UPDATE_ON_REQUEST' => 'on User Request',
    'LBL_MODULE_NAME' => 'K Reports',
    'LBL_REPORT_STATUS' => 'Report Status',
    'LBL_MODULE_TITLE' => 'K Reports',
    'LBL_SEARCH_FORM_TITLE' => 'Report Search',
    'LBL_LIST_FORM_TITLE' => 'Report List',
    'LBL_NEW_FORM_TITLE' => 'Create K Report',
    'LBL_LIST_CLOSE' => 'Close',
    'LBL_LIST_SUBJECT' => 'Title',
    'LBL_DESCRIPTION' => 'Description:',
    'LNK_NEW_REPORT' => 'Create new Report',
    'LNK_REPORT_LIST' => 'List Reports',
    'LBL_UNIONTREE' => 'union Modules',
    'LBL_UNIONLISTFIELDS' => 'Union List Fields',
    'LBL_UNIONFIELDDISPLAYPATH' => 'Union Path',
    'LBL_UNIONFIELDNAME' => 'Union Field name',
    'LBL_SELECT_MODULE' => 'Select a module',
    'LBL_SELECT_TAB' => 'Select a Tab',
    'LBL_ENTER_SEARCH_TERM' => 'Enter search term',
    'LBL_LIST_MODULE' => 'Module',
    'LBL_LIST_ASSIGNED_USER_NAME' => 'Assigned User',
    'LBL_DEFINITIONS' => 'Report Definition',
    'LBL_MODULES' => 'Modules',
    'LBL_LISTFIELDS' => 'manipulate',
    'LBL_PRESENTATION' => 'present',
    'LBL_CHARTDEFINITION' => 'Chart Details',
    'LBL_TARGETLIST_NAME' => 'Target List Name',
    'LBL_TARGETLIST_PROMPT' => 'Name of the new Targetlist',
    'LBL_DUPLICATE_NAME' => 'New Report Name',
    'LBL_DUPLICATE_PROMPT' => 'Enter the name for the new report',
    'LBL_DYNAMIC_OPTIONS' => 'Search/Filter Criteria',
    // Grid headers
    'LBL_FIELDNAME' => 'Fieldname',
    'LBL_NAME' => 'Name',
    'LBL_OPERATOR' => 'Operator',
    'LBL_VALUE_FROM' => 'Equals/From',
    'LBL_VALUE_TO' => 'To',
    'LBL_JOIN_TYPE' => 'Required',
    'LBL_TYPE' => 'Type',
    'LBL_WIDTH' => 'Width',
    'LBL_SORTPRIORITY' => 'Sortseq.',
    'LBL_SORTSEQUENCE' => 'Sort',
    'LBL_EXPORTPDF' => 'show in PDF',
    'LBL_DISPLAY' => 'Display',
    'LBL_OVERRIDETYPE' => 'override Type',
    'LBL_LINK' => 'Link',
    'LBL_WIDGET' => 'Widget',
    'LBL_FIXEDVALUE' => 'Fixed Value',
    'LBL_ASSIGNTOVALUE' => 'Store',
    'LBL_FORMULAVALUE' => 'Formula',
    'LBL_FORMULASEQUENCE' => 'Seq.',
    'LBL_PATH' => 'Path',
    'LBL_FULLPATH' => 'technical Path',
    'LBL_SEQUENCE' => 'Seq.',
    'LBL_GROUPBY' => 'Group by',
    'LBL_SQLFUNCTION' => 'Function',
    'LBL_CUSTOMSQLFUNCTION' => 'CustomFunction',
    'LBL_VALUETYPE' => 'Value Type',
    'LBL_DISPLAYFUNCTION' => 'Disp. Funct.',
    'LBL_USEREDITABLE' => 'Allow Edit',
    'LBL_DASHLETEDITABLE' => 'Dashlet Option',
    'LBL_QUERYCONTEXT' => 'Context',
    'LBL_QUERYREFERENCE' => 'Reference',
    'LBL_UEOPTION_YES' => 'yes',
    'LBL_UEOPTION_NO' => 'no',
    'LBL_UEOPTION_YFO' => 'value only',
    'LBL_UEOPTION_YO1' => 'on/(off)',
    'LBL_UEOPTION_YO2' => '(on)/off',
    'LBL_DEOPTION_YES' => 'yes',
    'LBL_DEOPTION_NO' => 'no',
    'LBL_ONOFF_YO1' => 'yes',
    'LBL_ONOFF_YO2' => 'no',
    'LBL_ONOFF_COLUMN' => 'y/n',
    // Title and Headers for Multiselect Popup
    'LBL_MUTLISELECT_POPUP_TITLE' => 'Select Values',
    'LBL_MULTISELECT_VALUE_HEADER' => 'ID',
    'LBL_MULTISELECT_TEXT_HEADER' => 'Value',
    'LBL_MUTLISELECT_CLOSE_BUTTON' => 'Update',
    'LBL_MUTLISELECT_CANCEL_BUTTON' => 'Cancel',
    // Title and Headers for Datetimepicker Popup
    'LBL_DATETIMEPICKER_POPUP_TITLE' => 'Select Date/Time',
    'LBL_DATETIMEPICKER_CLOSE_BUTTON' => 'Update',
    'LBL_DATETIMEPICKER_CANCEL_BUTTON' => 'Cancel',
    'LBL_DATETIMEPICKER_DATE' => 'Date',
    // for the Snapshot Comaprison
    'LBL_SNAPSHOTCOMPARISON_POPUP_TITLE' => 'Chart by Chart',
    'LBL_SNAPSHOTTRENDANALYSIS_POPUP_TITLE' => 'Trend Analysis',
    'LBL_SNAPSHOTCOMPARISON_SNAPHOT_HEADER' => 'Snapshot',
    'LBL_SNAPSHOTCOMPARISON_DESCRIPTION_HEADER' => 'Description',
    'LBL_SNAPSHOTCOMPARISON_SELECT_CHART' => 'Select Chart:',
    'LBL_SNAPSHOTCOMPARISON_SELECT_LEFT' => 'Select left source:',
    'LBL_SNAPSHOTCOMPARISON_SELECT_RIGHT' => 'Select right source:',
    'LBL_SNAPSHOTCOMPARISON_DATASERIES' => 'Data',
    'LBL_SNAPSHOTCOMPARISON_DATADIMENSION' => 'Dimension',
    'LBL_SNAPSHOTCOMPARISON_CHARTTYPE' => 'Charttype',
    'LBL_BASIC_TRENDLINE_BUTTON_LABEL' => 'Trend Analysis',
    'LBL_SNAPSHOTCOMPARISON_CHARTTYPE_MSLINE' => 'Line',
    'LBL_SNAPSHOTCOMPARISON_CHARTTYPE_STACKEDAREA2D' => 'Area',
    'LBL_SNAPSHOTCOMPARISON_CHARTTYPE_MSBAR2D' => 'Bars 2D',
    'LBL_SNAPSHOTCOMPARISON_CHARTTYPE_MSBAR3D' => 'Bars 3D',
    'LBL_SNAPSHOTCOMPARISON_CHARTTYPE_MSCOLUMN2D' => 'Column 2D',
    'LBL_SNAPSHOTCOMPARISON_CHARTTYPE_MSCOLUMN3D' => 'Column 3D',
    'LBL_SNAPSHOTCOMPARISON_LOADINGCHARTMSG' => 'loading Chart',
    // Operator Names
    'LBL_OP_IGNORE' => 'ignore',
    'LBL_OP_EQUALS' => '=',
    'LBL_OP_AUTOCOMPLETE' => 'autocomplete name',
    'LBL_OP_SOUNDSLIKE' => 'sounds like',
    'LBL_OP_NOTEQUAL' => '≠',
    'LBL_OP_STARTS' => 'starts with',
    'LBL_OP_CONTAINS' => 'contains',
    'LBL_OP_NOTSTARTS' => 'does not start with',
    'LBL_OP_NOTCONTAINS' => 'does not contain',
    'LBL_OP_BETWEEN' => 'is between',
    'LBL_OP_ISEMPTY' => 'is empty',
    'LBL_OP_ISEMPTYORNULL' => 'is empty or NULL',
    'LBL_OP_ISNULL' => 'is NULL',
    'LBL_OP_ISNOTEMPTY' => 'is not empty',
    'LBL_OP_FIRSTDAYOFMONTH' => 'first Day of current Month',
    'LBL_OP_FIRSTDAYNEXTMONTH' => 'first Day of next Month',
    'LBL_OP_NTHDAYOFMONTH' => 'nth day of current month',
    'LBL_OP_THISMONTH' => 'current month',
    'LBL_OP_NOTTHISMONTH' => 'not current month',
    'LBL_OP_THISWEEK' => 'current week',
    'LBL_OP_NEXT3MONTH' => 'within the next 3 month',
    'LBL_OP_NEXT3MONTHDAILY' => 'within the next 3 month Daily', 
    'LBL_OP_NEXT6MONTH' => 'within the next 6 month', 
    'LBL_OP_NEXT6MONTHDAILY' => 'within the next 6 month Daily', 
    'LBL_OP_LAST3MONTHDAILY' => 'within the last 3 month Daily', 
    'LBL_OP_LAST6MONTH' => 'within the last 6 month', 
    'LBL_OP_LAST6MONTHDAILY' => 'within the last 6 month daily',
    'LBL_OP_LASTNFMONTH' => 'within the last n full month',
    'LBL_OP_TODAY' => 'today',
    'LBL_OP_PAST' => 'in the past',
    'LBL_OP_FUTURE' => 'in the future',
    'LBL_OP_LASTNDAYS' => 'in the last n days (count)',
    'LBL_OP_LASTNFDAYS' => 'in the last full n days (count)',
    'LBL_OP_LASTNDDAYS' => 'in the last n days (Date)',
    'LBL_OP_LASTNWEEKS' => 'in the last n weeks',
    'LBL_OP_NOTLASTNWEEKS' => 'not in the last n weeks',
    'LBL_OP_LASTNFWEEKS' => 'in the last full n weeks',
    'LBL_OP_NEXTNDAYS' => 'in the next n days (count)',
    'LBL_OP_NEXTNDDAYS' => 'in the next n days (Date)',
    'LBL_OP_NEXTNWEEKS' => 'in the next n weeks',
    'LBL_OP_NOTNEXTNWEEKS' => 'not in the next n weeks',
    'LBL_OP_BETWNDAYS' => 'between n days (count)',
    'LBL_OP_BETWNDDAYS' => 'between n days (Date)',
    'LBL_OP_BEFORE' => 'before',
    'LBL_OP_AFTER' => 'after',
    'LBL_OP_LASTMONTH' => 'last month',
    'LBL_OP_LAST3MONTH' => 'within the last 3 month',
    'LBL_OP_THISYEAR' => 'this year',
    'LBL_OP_LASTYEAR' => 'last year',
    'LBL_OP_TYYTD' => 'YTD',
    'LBL_OP_LYYTD' => 'last Year YTD',
    'LBL_OP_GREATER' => '>',
    'LBL_OP_LESS' => '<',
    'LBL_OP_GREATEREQUAL' => '>=',
    'LBL_OP_LESSEQUAL' => '<=',
    'LBL_OP_ONEOF' => 'is one of',
    'LBL_OP_ONEOFNOT' => 'is not one of',
    'LBL_OP_ONEOFNOTORNULL' => 'is not one of or NULL',
    'LBL_OP_PARENT_ASSIGN' => 'assign from Parent',
    'LBL_OP_FUNCTION' => 'function',
    'LBL_OP_REFERENCE' => 'reference',
    'LBL_BOOL_0' => 'false',
    'LBL_BOOL_1' => 'true',
    // for the List view Menu
    'LBL_LISTVIEW_OPTIONS' => 'List Options',
    // List Limits
    'LBL_LI_TOP10' => 'top 10',
    'LBL_LI_TOP20' => 'top 20',
    'LBL_LI_TOP50' => 'top 50',
    'LBL_LI_TOP250' => 'top 250',
    'LBL_LI_BOTTOM50' => 'bottom 50',
    'LBL_LI_BOTTOM10' => 'bottom 10',
    'LBL_LI_NOLIMIT' => 'no limit',

    // buttons
    'LBL_CHANGE_GROUP_NAME' => 'Change Name of Group',
    'LBL_CHANGE_GROUP_NAME_PROMPT' => 'Name :',
    'LBL_ADD_GROUP_NAME' => 'Create new Group',

    'LBL_SELECTION_CLAUSE' => 'Select Clause: ',
    'LBL_SELECTION_LIMIT' => 'Limit List to:',
    'LBL_RECORDS' => 'Records', 
    'LBL_PERCENTAGE' => '%',
    'LBL_EDIT_BUTTON_LABEL' => 'Edit',
    'LBL_DELETE_BUTTON_LABEL' => 'Delete',
    'LBL_ADD_BUTTON_LABEL' => 'Add',
    'LBL_ADDEMTPY_BUTTON_LABEL' => 'Add fixed',
    'LBL_DOWN_BUTTON_LABEL' => '',
    'LBL_UP_BUTTON_LABEL' => '',
    'LBL_SNAPSHOT_BUTTON_LABEL' => 'Take Snapshot',
    'LBL_CURRENT_SNAPSHOT' => 'actual',
    'LBL_SNAPSHOTMENU_BUTTON_LABEL' => 'Snapshots',
    'LBL_TOOLSMENU_BUTTON_LABEL' => 'Tools',
    'LBL_EXPORTMENU_BUTTON_LABEL' => 'Export',
    'LBL_COMPARE_SNAPSHOTS_BUTTON_LABEL' => 'Chart by Chart Comparison',
    'LBL_EXPORT_TO_EXCEL_BUTTON_LABEL' => 'EXCEL',
    'LBL_EXPORT_TO_KLM_BUTTON_LABEL' => 'Google Earth KML',
    'LBL_EXPORT_TO_PDF_BUTTON_LABEL' => 'PDF',
    'LBL_EXPORT_TO_PDFWCHART_BUTTON_LABEL' => 'PDF w. Chart',
    'LBL_EXPORT_TO_TARGETLIST_BUTTON_LABEL' => 'Targetlist',
    'LBL_SQL_BUTTON_LABEL' => 'SQL',
    'LBL_DUPLICATE_REPORT_BUTTON_LABEL' => 'Duplicate',
    'LBL_LISTTYPE' => 'List Type',
    'LBL_CHART_LAYOUTS' => 'Layout',
    'LBL_CHART_TYPE' => 'Type',
    'LBL_CHART_DIMENSION' => 'Dimension',
    'LBL_CHART_INDEX_LABEL' => 'Chart Index',
    'LBL_CHART_INDEX_EMPTY_TEXT' => 'Select a Chart ID',
    'LBL_CHART_LABEL' => 'Chart',
    'LBL_CHART_HEIGHT_LABEL' => 'Chart Height',
     
    // Dropdown Values
    'LBL_DD_1' => 'yes',
    'LBL_DD_0' => 'no',

    // DropDownValues
    'LBL_DD_SEQ_YES' => 'Yes',
    'LBL_DD_SEQ_NO' => 'No',
    'LBL_DD_SEQ_PRIMARY' => '1',
    'LBL_DD_SEQ_2' => '2',
    'LBL_DD_SEQ_3' => '3',
    'LBL_DD_SEQ_4' => '4',
    'LBL_DD_SEQ_5' => '5',
    // Panel Titles
    'LBL_WHERRE_CLAUSE_TITLE' => 'select',
    //Confirm Dialog
    'LBL_DIALOG_CONFIRM' => 'Confirm',
    'LBL_DIALOG_DELETE_YN' => 'are you sure you want to delete this Report?',

    // for the views options
    'LBL_RESET_BUTTON' => 'Reset',
    'LBL_TREESTRCUTUREGRID_TITLE' => 'Tree Hierarchy',
    'LBL_REPOSITORYGRID_TITLE' => 'available Fields',
    'LBL_CANCEL_BUTTON' => 'Cancel',
    'LBL_CLOSE_BUTTON' => 'Close',
    'LBL_LISTTYPEPROPERTIES' => 'Properties',
    'LBL_XAXIS_TITLE' => 'X-Axis Fields',
    'LBL_YAXIS_TITLE' => 'Y-Axis Fields',
    'LBL_VALUES_TITLE' => 'Value Fields',
    'LBL_SUMMARIZATION_TITLE' => 'Sumamrization Fields',
    'LBL_FUNCTION' => 'Function',
    'LBL_FUNCTION_SUM' => 'Sum',
    'LBL_FUNCTION_CUMSUM' => 'Sum cumulated',
    'LBL_FUNCTION_COUNT' => 'Count',
    'LBL_FUNCTION_COUNT_DISTINCT' => 'Count Distinct',
    'LBL_FUNCTION_AVG' => 'Average',
    'LBL_FUNCTION_MIN' => 'Minimum',
    'LBL_FUNCTION_MAX' => 'Maximum',
    'LBL_FUNCTION_GROUP_CONCAT' => 'Group Concat',
    //2013-03-01 Sort function for Group Concat
    'LBL_FUNCTION_GROUP_CONASC' => 'Group Concat (asc)',
    'LBL_FUNCTION_GROUP_CONDSC' => 'Group Concat (desc)',
    // Value Types
    'LBL_VALUETYPE_TOFSUM' => 'display Sum',
    'LBL_VALUETYPE_POFSUM' => '% of Sum',
    'LBL_VALUETYPE_POFCOUNT' => '% of Count',
    'LBL_VALUETYPE_POFAVG' => '% of Average',
    'LBL_VALUETYPE_DOFSUM' => 'Δ to Sum',
    'LBL_VALUETYPE_DOFCOUNT' => 'Δ to Count',
    'LBL_VALUETYPE_DOFAVG' => 'Δ to Average',
    'LBL_VALUETYPE_C' => 'Cumulated',
    // panel title
    'LBL_STANDARDGRIDPANELTITLE' => 'Report Result',
    'LBL_STANDRDGRIDPANEL_FOOTERWCOUNT' => 'Displaying Records {0} - {1} of {2}',
    'LBL_STANDRDGRIDPANEL_FOOTERWOCOUNT' => 'Displaying Records {0} - {1}',
    'LBL_STANDARDGRIDPROPERTIES_COUNT' => 'process Count',
    'LBL_STANDARDGRIDPROPERTIES_SYNCHRONOUSCOUNT' => 'syncronous',
    'LBL_STANDARDGRIDPROPERTIES_ASYNCHRONOUSCOUNT' => 'asyncronous',
    'LBL_STANDARDGRIDPROPERTIES_NOCOUNT' => 'no count',
    'LBL_STANDARDGRIDENTRIES_COUNT' => 'records per page',
    // General Labels
    'LBL_YES' => 'yes',
    'LBL_NO' => 'no',
    'LBL_HID' => 'hidden',
    'LBL_SORT_ASC' => 'asc.',
    'LBL_SORT_DESC' => 'desc.',
    'LBL_SORT_SORTABLE' => 'sortable',
    'LBL_JT_OPTIONAL' => 'optional',
    'LBL_JT_REQUIRED' => 'required',
    //Trendlines
    'LBL_TRENDLINE_STARTVALUE' => 'StartValue',
    'LBL_TRENDLINE_ENDVALUE' => 'EndValue',
    'LBL_ADD_TRENDLINE' => 'add Trendline',
    'LBL_DELETE_TRENDLINE' => 'delete Trendline',
    'LBL_TRENDLINE_MIN' => 'Minimum',
    'LBL_TRENDLINE_MAX' => 'Maximum',
    'LBL_TRENDLINE_AVG' => 'Average',
    'LBL_TRENDLINE_AMM' => 'Area Min/Max',
    'LBL_TRENDLINE_LRG' => 'linear Regression',
    'LBL_TRENDLINE_CST' => 'Custom',
    'LBL_STANDARDTYPE' => 'Type',
    'LBL_TRENDLINE_STYLE' => 'Style',
    'LBL_TRENDLINE_VAL' => 'Value',
    'LBL_TRENDLINE_TXT' => 'Name',
    'LBL_TRENDLINE_NOT' => '-',
    'LBL_TRENDLINE_DISPLAY' => 'Info',
    // for report publishing
    'LBL_PUBLISH_OPTION' => 'publish Report',
    'LBL_PUBLISHPOPUP_TITLE' => 'Publish Report Options',
    'LBL_PUBLISHPOPUP_SUBPANEL' => 'Subpanel',
    'LBL_PUBLISHPOPUP_DASHLET' => 'Dashlet',
    'LBL_PUBLISHPOPUP_GRID' => 'publish Grid',
    'LBL_PUBLISHPOPUP_CHART' => 'publish Chart',
    'LBL_PUBLISHPOPUP_SUBPANELORDER' => 'Subpanel Order',
    'LBL_PUBLISHPOPUP_CLOSE' => 'Close',
    'LBL_PUBLISHPOPUP_MENU' => 'publish as Menu item',
    // for Export to Planning
    'LBL_EXPORTTOPLANINGPOPUP_TITLE' => 'Export to Planning Nodes Settings',
    // for the pdf
    'LBL_PDF_DATE_LEADIN' => ' created on ',
    'LBL_PDF_DATE_LEADOUT' => '',
    'LBL_PDF_PAGE_LEADIN' => 'Page ',
    'LBL_PDF_PAGE_SEPARATOR' => ' of ',
    // for the targetlist Export
    'LBL_TARGETLISTEXPORTPOPUP_TITLE' => 'Export to Targetlist',
    'LBL_TARGETLISTPOUPFIELDSET_LABEL' => 'Export Options',
    'LBL_TGLLISTPOPUP_CLOSE' => 'Close',
    'LBL_TGLLISTPOPUP_EXEC' => 'Run',
    'LBL_TARGETLISTPOUP_OPTIONS' => 'Action',
    'LBL_TGLEXP_NEW' => 'create new',
    'LBL_TGLEXP_UPD' => 'update existing',
    'LBL_TARGETLISTPOUPNEWFIELDSET_LABEL' => 'New Targetlist',
    'LBL_TARGETLISTPERFSETTINGS_LABEL' => 'Performance Settings',
    'LBL_TARGETLISTPERFCHECKBOX_LABEL' => 'create direct',
    'LBL_TARGETLISTPOUP_NEWNAME' => 'Targetlist Name',
    'LBL_TARGETLISTPOUPCHANGEFIELDSET_LABEL' => 'Update Targetlist',
    'LBL_TARGETLISTPOUP_LISTS' => 'Target Lists',
    'LBL_TARGETLISTPOUP_ACTIONS' => 'Action',
    'LBL_TGLACT_REP' => 'update',
    'LBL_TGLACT_ADD' => 'add',
    'LBL_TGLACT_SUB' => 'subtract',
    'LBL_TARGETLISTPOUP_CAMPAIGNS' => 'add to campaign',
    'LBL_LAST_DAY_OF_MONTH' => 'last day of month',
    'LBL_EXPORT_TO_PLANNER_BUTTON_LABEL' => 'Export to KPlanner',
    'LBL_PLANNEREXPORTPOPUP_TITLE' => 'Export to KPlanner',
    'LBL_EXPORTPOPUP_CLOSE' => 'Cancel',
    'LBL_EXPORTPOPUP_EXEC' => 'Export to KPlanner',
    'LBL_PLANNEREXPORTPOPUP_SCOPESETS' => 'Scope Set',
    'LBL_PLANNINCHARACTERISTICSGRID_TITLE' => 'Planning Characteristics',
    'LBL_CHARFIELDVALUE' => 'Characteristic Value',
    'LBL_CHARFIELDNAME' => 'Characteristic Name',
    'LBL_CHARFIXEDVALUE' => 'Fixed Value',
    'LBL_PLANNEREXPORTPOPUP_NODENAME' => 'Nodename',
    
    // for the Viualization
    'LBL_VISUALIZATION' => 'visualize',
    'LBL_VISUALIZATIONPLUGIN' => 'type',
    'LBL_VISUALIZATIONTOOLBAR_LAYOUT' => 'Layout',
    'LBL_VISUALIZATION_HEIGHT' => 'height (px)',
    'LBL_GOOGLECHARTS' => 'Google Charts', 
    'LBL_CHARTFS_DATA' => 'Chart Data',
    'LBL_CHARTFS_SERIES' => 'Dataseries', 
    'LBL_CHARTFS_VALUES' => 'Values', 
    'LBL_DIMENSIONS' => 'Dimensions',
    'LBL_DIMENSION_111' => 'one dimensional (series)',
    'LBL_DIMENSION_10N' => 'one dimensional (values)',
    'LBL_DIMENSION_220' => 'two dimensional (no values)',
    'LBL_DIMENSION_221' => 'two dimensional (series)',
    'LBL_DIMENSION_21N' => 'two dimensional (values)',
    'LBL_DIMENSION_331' => 'three dimensional (series)',
    'LBL_DIMENSION_32N' => 'three dimensional (values)',
    'LBL_CHARTTYPE_DIMENSION1' => 'Dimension 1',
    'LBL_CHARTTYPE_DIMENSION2' => 'Dimension 2',
    'LBL_CHARTTYPE_DIMENSION3' => 'Dimension 3',
    'LBL_CHARTTYPE_MULTIPLIER' => 'Multiplier',
    'LBL_CHARTTYPE_COLORS' => 'Colors',
    'LBL_CHARTTYPE_DATASERIES' => 'Dataseries',
    'LBL_CHARTTYPES' => 'Type',
    'LBL_CHARTTYPE_AREA' => 'Area Chart', 
    'LBL_CHARTTYPE_STEPPEDAREA' => 'Stepped Area Chart', 
    'LBL_CHARTTYPE_BAR' => 'Bar Chart',
    'LBL_CHARTTYPE_BUBBLE' => 'Bubble Chart',
    'LBL_CHARTTYPE_COLUMN' => 'Column Chart',
    'LBL_CHARTTYPE_GAUGE' => 'Gauges',
    'LBL_CHARTTYPE_PIE' => 'Pie Chart', 
    'LBL_CHARTTYPE_LINE' => 'Line Chart', 
    'LBL_CHARTTYPE_SCATTER' => 'Scatter Chart', 
    'LBL_CHARTTYPE_COMBO' => 'Combo Chart',
    'LBL_CHARTTYPE_CANDLESTICK' => 'Candlestick', 
    'LBL_CHARTFUNCTION' => 'Function', 
    'LBL_MEANING' => 'Meaning', 
    'LBL_COLOR' => 'Color',
    'LBL_AXIS' => 'Axis',
    'LBL_CHARTAXIS_P' => 'Primary',
    'LBL_CHARTAXIS_S' => 'Secondary',
    'LBL_RENDERER' => 'render as', 
    'LBL_CHARTRENDER_DEFAULT' => 'default',
    'LBL_CHARTRENDER_BARS' => 'Bars',
    'LBL_CHARTRENDER_COLUMN' => 'Column',
    'LBL_CHARTRENDER_LINE' => 'Line',
    'LBL_CHARTRENDER_AREA' => 'Area',
    'LBL_CHARTRENDER_STEPPEDAREA' => 'Stepped Area',
    'LBL_CHARTOPTIONS_FS' => 'Chartoptions',
    'LBL_CHARTOPTIONS_TITLE' => 'Title',
    'LBL_CHARTOPTIONS_CONTEXT' => 'Context',
    'LBL_CHARTOPTIONS_VMINMAX' => 'V Axis Min/Max', 
    'LBL_CHARTOPTIONS_HMINMAX' => 'H Axis Min/Max', 
    'LBL_CHARTOPTIONS_GREEN' => 'Green from/to',
    'LBL_CHARTOPTIONS_YELLOW' => 'Yellow from/to',
    'LBL_CHARTOPTIONS_RED' => 'Red from/to',
    'LBL_CHARTOPTIONS_LEGEND' => 'display Legend', 
    'LBL_CHARTOPTIONS_EMTPY' => 'empty Values',
    'LBL_CHARTOPTIONS_NOVLABLES' => 'hide V-Axis Labels',
    'LBL_CHARTOPTIONS_NOHLABLES' => 'hide H-Axis Labels',
    'LBL_CHARTOPTIONS_LOGV' => 'logarithmic V Scale',
    'LBL_CHARTOPTIONS_LOGH' => 'logarithmic H Scale',
    'LBL_CHARTOPTIONS_3D' => '3 dimensional', 
    'LBL_CHARTOPTIONS_STACKED' => 'stacked Series', 
    'LBL_CHARTOPTIONS_REVERSED' => 'reverse Series', 
    'LBL_CHARTOPTIONS_CTFUNCTION' => 'smoothed Line', 
    'LBL_CHARTOPTIONS_POINTS' => 'show Points',
    
    // for Fusion Charts ... needs to be moved
    'LBL_CHARTTYPE_COLUMN2D' => 'Column 2D',
    'LBL_CHARTTYPE_COLUMN3D' => 'Column 3D',
    'LBL_CHARTTYPE_PIE2D' => 'Pie 2D',
    'LBL_CHARTTYPE_PIE3D' => 'Pie 3D',
    'LBL_CHARTTYPE_DOUGNUT2D' => 'Dougnut 2D',
    'LBL_CHARTTYPE_DOUGNUT3D' => 'Dougnut 3D',
    'LBL_CHARTTYPE_BAR2D' => 'Bar 2D',
    'LBL_CHARTTYPE_AREA2D' => 'Area 2D', 
    'LBL_CHARTTYPE_STACKEDAREA2D' => 'stacked area 2D',
    'LBL_CHARTTYPE_PARETO2D' => 'Pareto 2D', 
    'LBL_CHARTTYPE_PARETO3D' => 'Pareto 3D', 
    'LBL_CHARTTYPE_STACKEDCOLUMN2D' => 'stacked Column 2D',
    'LBL_CHARTTYPE_STACKEDCOLUMN3D' => 'stacked Column 3D',
    'LBL_CHARTTYPE_MSCOLUMN2D' => 'multiseries Column 2D',
    'LBL_CHARTTYPE_MSCOLUMN3D' => 'multiseries Column 3D',
    'LBL_CHARTTYPE_MSBAR2D' => 'multiseries Bar 2D',
    'LBL_CHARTTYPE_MSBAR3D' => 'multiseries Bar 3D',
    'LBL_CHARTTYPE_STACKEDBAR2D' => 'stacked Bar 2D',
    'LBL_CHARTTYPE_STACKEDBAR3D' => 'stacked Bar 3D',
    'LBL_CHARTTYPE_MARIMEKKO' => 'Marimekko Chart',
    'LBL_CHARTTYPE_MSLINE' => 'multiseries Line',
    'LBL_CHARTTYPE_MSAREA' => 'multiseries Area',
    'LBL_CHARTTYPE_MSCOMBIDY2D' => 'multiseries Combination dual',
    'LBL_CHARTOPTIONS_ROUNDEDGES' => 'round Edges', 
    'LBL_CHARTOPTIONS_HIDELABELS' => 'hide Labels', 
    'LBL_CHARTOPTIONS_HIDEVALUES' => 'hide Values', 
    'LBL_CHARTOPTIONS_FORMATNUMBERSCALE' => 'scale Numbers',
    'LBL_CHARTOPTIONS_ROTATEVALUES' => 'rotate Value', 
    'LBL_CHARTOPTIONS_PLACEVALUESINSIDE' => 'place Values inside',
    'LBL_CHARTOPTIONS_SHOWSHADOE' => 'show Shadow',
    'LBL_CHARTOPTIONS_LPOS' => 'Legend',
    'LBL_LPOS_NONE' => 'none', 
    'LBL_LPOS_RIGHT' => 'right', 
    'LBL_LPOS_LEFT' => 'left', 
    'LBL_LPOS_BOTTOM' => 'bottom',
    'LBL_LPOS_TOP' => 'top',
    
    
    'LBL_STANDARDPLUGIN' => 'Standard View',
    
    
    // for the Google Maps
    'LBL_GOOGLEMAPSFS_GEOCODEBY' => 'Geo by',
    'LBL_GOOGLEMAPSFS_GEOCODELATLONG' => 'Lat/Long',
    'LBL_GOOGLEMAPSFS_GEOCODEADDRESS' => 'Address',
    'LBL_GOOGLEMAPS_LONGITUDE' => 'Longitude', 
    'LBL_GOOGLEMAPS_LATITUDE' => 'Latitude', 
    'LBL_GOOGLEMAPSFS_LATLONG' => 'Geocoordinates', 
    'LBL_GOOGLEMAPS_STREET' => 'Street',
    'LBL_GOOGLEMAPS_CITY' => 'City',
    'LBL_GOOGLEMAPS_PC' => 'Postalcode',
    'LBL_GOOGLEMAPS_COUNTRY' => 'Country',
    'LBL_GOOGLEMAPS_ADDRESS' => 'Address', 
    'LBL_GOOGLEMAPSFS_TITLE' => 'Pin Info', 
    'LBL_GOOGLEMAPS_TITLE' => 'Title',
    'LBL_GOOGLEMAPS_CLUSTER' => 'Cluster Pins',
    
    // for the Plugins
    'LBL_PRESENTATION_PLUGIN' => 'Plugin',
    'LBL_PRESENTATION_PARAMS' => 'Presentation Parameters',
    'LBL_DEFAULT_GROUPBY' => 'Default Group By',
    'LBL_INTEGRATION' => 'integrate',
    'LBL_INTEGRATION_PLUGINNAME' => 'Plugin',
    'LBL_CSV_EXPORT' => 'Export to CSV', 
    'LBL_EXCEL_EXPORT' => 'Export to Excel',
    'LBL_TARGETLIST_EXPORT' => 'Export to Targetlist', 
    'LBL_SNAPSHOT_EXPORT' => 'take Snapshot',
    'LBL_QUERY_ANALIZER' => 'Query Analyzer',
    'LBL_SCHEDULE_REPORT' => 'schedule Report', 
    'LBL_PUBLISH_REPORT' => 'publish Report', 
    'LBL_PUBLISH_DASHLET' => 'Publish as Dashlet',
    'LBL_PUBLISH_DASHLETREPORT' => 'Select Report',
    'LBL_PUBLISH_DASHLETTITLE' => 'Dashlet Title',
    'LBL_PUBLISH_DASHLET_PRESENTATION' => 'Presentation',
    'LBL_PUBLISH_DASHLET_PRESENTATION_VISUALIZATION' => 'Visualization', 
    'LBL_PUBLISH_SUBPANEL_SEQUENCE' => 'Sequence',
    'LBL_PUBLISH_SUBPANEL_MODULE' => 'Module',
    'LBL_PUBLISH_SUBPANEL_TAB' => 'Tab',
    
    // PDF Export Option
    'LBL_PDF_EXPORT' => 'PDF Export', 
    'LBL_PDF_EXPORTOPTIONS_GENERAL' => 'General', 
    'LBL_PDF_LAYOUT' => 'PDF Layout',
    'LBL_PDF_FORMAT' => 'Format',
    'LBL_PDFFORMAT_LTR' => 'Letter',
    'LBL_PDFFORMAT_LGL' => 'Legal',
    'LBL_PDFFORMAT_A4' => 'A4',
    'LBL_PDFFORMAT_A5' => 'A5', 
    'LBL_PDF_ORIENTATION' => 'Orientation',
    'LBL_PDF_MULTILINE' => 'multiline',
    'LBL_PDFORIENT_P' => 'Portrait',
    'LBL_PDFORIENT_L' => 'Landscape', 
    'LBL_PDF_PALIGNMENT' => 'Data Alignment', 
    'LBL_PDFPALIGNMENT_L' => 'Left',
    'LBL_PDFPALIGNMENT_R' => 'Right',
    'LBL_PDFPALIGNMENT_C' => 'Center',
    'LBL_PDFPALIGNMENT_S' => 'Stretch', 
    'LBL_PDF_NEWPAGEPERGROUP' => 'new Page per Group',
    'LBL_PDF_HEADERPERPAGE' => 'header on each page',
    
    // Pivot Plugin ... to be moved later
    'LBL_PIVOT_SETTINGS' => 'Pivot table settings', 
    'LBL_PIVOT_ADVANCED' => 'Advanced Settings',
    'LBL_PIVOT_REPOSITORY' => 'available Fields', 
    'LBL_PIVOT_COLUMNS' => 'Columns', 
    'LBL_PIVOT_ROWS' => 'Rows',
    'LBL_PIVOT_ADDROWINFO' => 'additonal Row Info',
    'LBL_PIVOT_VALUES' => 'Values', 
    'LBL_PIVOT_FUNCTiON' => 'Function', 
    'LBL_PIVOT_TOTALS' => 'show totals', 
    'LBL_PIVOT_SUMS' => 'show sum',
    'LBL_PIVOT_ROTATEHEADERS' => 'rotate Headers',
    'LBL_PIVOT_EMPTYCOLUMNS' => 'show empty Columnns', 
    'LBL_PIVOT_ADJUSTCOLUMNS' => 'adjust column width',
    'LBL_PIVOT_SORTCOLUMNS' => 'sort Columns',
    'LBL_PIVOT_LBLPIVOTDATA' => 'Pivot Data',
    'LBL_PIVOT_NAMECOLUMNWIDTH' => 'Item Column Width', 
    'LBL_PIVOT_MINCOLUMNWIDTH' => 'min Column Width',
    
    // the field renderer
    'LBL_RENDERER_CURRENCY' => 'Currency', 
    'LBL_RENDERER_PERCENTAGE' => 'Percentage', 
    'LBL_RENDERER_NUMBER' => 'Number', 
    'LBL_RENDERER_INT' => 'Integer', 
    'LBL_RENDERER_DATE' => 'Date', 
    'LBL_RENDERER_DATETIME' => 'Datetime',
    'LBL_RENDERER_DATETUTC' => 'Datetime (UTC)',
    'LBL_RENDERER_FLOAT' => 'Float',
    'LBL_RENDERER_BOOL' => 'Boolean',
    'LBL_RENDERER_TEXT' => 'Text',
    'LBL_RENDERER_NONE' => 'do not Format', 
    
    // override Alignment
    'LBL_OVERRIDEALIGNMENT' => 'override Alignment',
    'LBL_ALIGNMENT_LEFT' => 'left',
    'LBL_ALIGNMENT_RIGHT' => 'right',
    'LBL_ALIGNMENT_CENTER' => 'center', 
    
    'LBL_REPORTTIMEOUT' => 'Timeout',
    'LBL_RT30' => '30 seconds',
    'LBL_RT60' => '1 minute',
    'LBL_RT120' => '2 minutes',
    'LBL_RT240' => '3 minutes',
    'LBL_RT300' => '4 minutes',
    
    'LBL_KSNAPSHOTS' => 'Snapshots',
    'LBL_KSNAPSHOT' => 'Snapshot', 
    'LBL_TAKING_SNAPSHOT' => 'taking snapshot ... '
    
);
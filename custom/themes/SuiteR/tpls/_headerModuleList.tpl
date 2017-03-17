{*
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see ttp://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/

*}
<style>{literal} #srmchildmenu{display:block!important}{/literal}</style>
<div class="col-md-3 left_col">
  <div class="left_col scroll-view">
	<div class="navbar nav_title" style="border: 0;">
	  <a href="index.php" class="site_title"><i class="fa fa-paw"></i> <span><img src="themes/default/images/logo.png"></span></a>
	</div>
	<div class="clearfix"></div>

	<!-- sidebar menu -->
	<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
	  <div class="menu_section">

				 {assign var="showsrm" value="0"}
                <ul class="nav side-menu">

                    {foreach from=$groupTabs item=modules key=group name=groupList}

                        {capture name=extraparams assign=extraparams}parentTab={$group}{/capture}
                        {if $group =='All'}
                              {php}continue;{/php}
                           {/if}
                        <li >

                            <a href="#"><i class="fa fa-home"></i>{$group}<span class="fa fa-chevron-down"></span></a>
                            {if $group !='SRM' }

                            <ul  class="nav child_menu" >

                                {foreach from=$modules.modules item=module key=modulekey}

									 {if $modulekey =='te_transfer_batch' || $modulekey =='te_student_batch' || $modulekey =='te_student'}
										 {assign var="showsrm" value="1"}
									 {/if}

                                    {if $modulekey =='te_transfer_batch' || $modulekey =='te_student_batch'|| $modulekey =='te_student' || $modulekey =='Home'}
										{php}continue;{/php}
									{/if}
                                    <li>
                                        {capture name=moduleTabId assign=moduleTabId}moduleTab_{$smarty.foreach.moduleList.index}_{$module}{/capture}
                                        {sugar_link id=$moduleTabId module=$modulekey data=$module extraparams=$extraparams}

                                        {if $modulekey == $MODULE_TAB}
											{if count($shortcutTopMenu.$modulekey) > 0}
										        <ul id="showactive" class="nav child_menu" style="display:block!important">
												{foreach from=$shortcutTopMenu.$modulekey item=item}
													{if $item.URL == "-"}
														<li><a></a><span>&nbsp;</span></li>
													{else}
														<li><a href="{$item.URL}">{$item.LABEL}</a></li>
													{/if}
												{/foreach}

												</ul>
												<script> $('#showactive').parent().css('display','block'); $('#showactive').parent().parent().css('display','block') ; $('#showactive').parent().parent().parent().addClass('active') ;</script>

											{/if}

                                        {/if}

                                    </li>
                                {/foreach}


                            </ul>




                             { else}



									 <ul  class="nav child_menu" >
									    <li> <a href="index.php?module=te_student_batch&action=revenue">Student</a>
									    <ul id="srmchildmenu" class="nav child_menu" >
											<li> <a href="index.php?module=te_student_batch&action=revenue">Summary</a> </li>
											<li> <a href="index.php?action=index&module=te_student_batch">List Student</a> </li>
											<li> <a href="index.php?module=te_student_batch&action=EditView&return_module=te_student_batch&return_action=DetailView">Create Student</a> </li>
											<li><a href="index.php?module=te_transfer_batch">Transfer Request</a> </li>
											<li><a href="index.php?module=te_student_batch&action=dropoutrequest">Dropout Request</a> </li>
											<li> <a href="index.php?module=Leads&action=EditView&addreferral=true">Add Referrals</a> </li>
											<li> <a href="index.php?module=te_student_batch&action=viewmyrefferal">View My Referrals</a> </li>
											<li> <a href="index.php?module=te_student_batch&action=search_leads">CRM Lead Search</a> </li>
                      <li> <a href="index.php?module=te_srm_auto_assignment">SRM Auto Assignment</a> </li>
                    </ul>
										</li>

									   {foreach from=$modules.modules item=module key=modulekey}
									       {if $modulekey =='te_transfer_batch' || $modulekey =='te_student_batch' || $modulekey =='te_student'}
												{assign var="showsrm" value="1"}
											{/if}
									     {if $modulekey =='te_transfer_batch' || $modulekey =='te_student_batch'|| $modulekey =='te_student' || $modulekey =='Home'}
											{php}continue;{/php}
										{/if}
									    <li>
                                        {capture name=moduleTabId assign=moduleTabId}moduleTab_{$smarty.foreach.moduleList.index}_{$module}{/capture}
                                        {sugar_link id=$moduleTabId module=$modulekey data=$module extraparams=$extraparams}
                                        {if $modulekey == $MODULE_TAB}
											{if count($shortcutTopMenu.$modulekey) > 0}
										        <ul id="showactive" class="nav child_menu" style="display:block!important">
												{foreach from=$shortcutTopMenu.$modulekey item=item}
													{if $item.URL == "-"}
														<li><a></a><span>&nbsp;</span></li>
													{else}
														<li><a href="{$item.URL}">{$item.LABEL}</a></li>
													{/if}
												{/foreach}

												</ul>
												<script> $('#showactive').parent().css('display','block'); $('#showactive').parent().parent().css('display','block') ; $('#showactive').parent().parent().parent().addClass('active') ;</script>

											{/if}

                                        {/if}

                                       </li>
                                       {/foreach}
									  </ul>





                             {/if}
                        </li>
                    {/foreach}
                </ul>

                  {if $showsrm==1}
                                <script>
                                 $('#srmchildmenu').parent().parent().css('display','block') ;
                                  $('#srmchildmenu').css('display','block') ;
                                </script>
                                {/if}
	</div>

	<!-- /sidebar menu -->

	  </div><!-- sidebar-->


</div> <!-- /left end -->
</div> <!-- /left end -->

<!-- top navigation -->
<div class="top_nav">
  <div class="nav_menu">
	<nav>
	  <div class="nav toggle">
		<a id="menu_toggle"><i class="fa fa-bars"></i></a>
	  </div>

	  <ul class="nav navbar-nav navbar-right">
		<li class="">
		  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
			<img src="themes/default/images/img.png" alt="">{$CURRENT_USER}
			<span class=" fa fa-angle-down"></span>
		  </a>
		  <ul class="dropdown-menu dropdown-usermenu pull-right">

			   {foreach from=$GCLS item=GCL name=gcl key=gcl_key}
				  <li><a id="{$gcl_key}_link" href="{$GCL.URL}"{if !empty($GCL.ONCLICK)} onclick="{$GCL.ONCLICK}"{/if}>{$GCL.LABEL}</a></li>
			   {/foreach}
			   <li ><a  href='{$LOGOUT_LINK}'>{$LOGOUT_LABEL}</a></li>

		  </ul>
		</li>

		<li id="desktop_notifications" role="presentation" class="dropdown">
		  <a href="javascript:;" class="dropdown-toggle info-number alertsButton" style="background: transparent;"  data-toggle="dropdown" aria-expanded="false">
			<i class="fa fa-envelope-o"></i>
			<span class="badge bg-green alert_count">0</span>
		  </a>
		   <div id="alerts" class="dropdown-menu" role="menu">{$APP.LBL_EMAIL_ERROR_VIEW_RAW_SOURCE}</div>

		</li>
	  </ul>
	</nav>
  </div>




</div>
<!-- /top navigation -->


  <div class="tile_count">
                {$statusWiseCount}
                {$convWiseCount}
  </div>

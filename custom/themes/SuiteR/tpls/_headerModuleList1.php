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

<div class="col-md-3 left_col">
  <div class="left_col scroll-view">
	<div class="navbar nav_title" style="border: 0;">
	  <a href="/" class="site_title"><i class="fa fa-paw"></i> <span><img src="themes/default/images/logo.png"></span></a>
	</div>
	<div class="clearfix"></div>
	
	<!-- menu profile quick info -->
	<div class="profile clearfix">
	  <div class="profile_pic">
		<img src="themes/default/images/img.png" alt="..." class="img-circle profile_img">
	  </div>
	  <div class="profile_info">
		<span>Welcome,</span>
		<h2>John Doe</h2>
	  </div>
	</div>
	<!-- /menu profile quick info -->

	<br />
	<!-- sidebar menu -->
	<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
	  <div class="menu_section">
	  {$moduleTopMenu|print_r}
	   {foreach from=$moduleTopMenu item=module key=name name=moduleList}	  
			<h3>General</h3>
			<ul class="nav side-menu">
			  <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
				<ul class="nav child_menu">
				  <li><a href="index.html">Dashboard</a></li>
				  <li><a href="index2.html">Dashboard2</a></li>
				  <li><a href="index3.html">Dashboard3</a></li>
				</ul>
			  </li>
			</ul> 
		 {/foreach}
	</div> 

	<!-- /sidebar menu -->
	<!-- /menu footer buttons -->
		<div class="sidebar-footer hidden-small">
		  <a data-toggle="tooltip" data-placement="top" title="Settings">
			<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
		  </a>
		  <a data-toggle="tooltip" data-placement="top" title="FullScreen">
			<span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
		  </a>
		  <a data-toggle="tooltip" data-placement="top" title="Lock">
			<span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
		  </a>
		  <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
			<span class="glyphicon glyphicon-off" aria-hidden="true"></span>
		  </a>
		</div>
		<!-- /menu footer buttons -->
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
			<img src="themes/default/images/img.png" alt="">John Doe
			<span class=" fa fa-angle-down"></span>
		  </a>
		  <ul class="dropdown-menu dropdown-usermenu pull-right">
			<li><a href="javascript:;"> Profile</a></li>
			<li>
			  <a href="javascript:;">
				<span class="badge bg-red pull-right">50%</span>
				<span>Settings</span>
			  </a>
			</li>
			<li><a href="javascript:;">Help</a></li>
			<li><a href="login.html"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
		  </ul>
		</li>

		<li role="presentation" class="dropdown">
		  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
			<i class="fa fa-envelope-o"></i>
			<span class="badge bg-green">6</span>
		  </a>
		  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
			<li>
			  <a>
				<span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
				<span>
				  <span>John Smith</span>
				  <span class="time">3 mins ago</span>
				</span>
				<span class="message">
				  Film festivals used to be do-or-die moments for movie makers. They were where...
				</span>
			  </a>
			</li>
			<li>
			  <a>
				<span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
				<span>
				  <span>John Smith</span>
				  <span class="time">3 mins ago</span>
				</span>
				<span class="message">
				  Film festivals used to be do-or-die moments for movie makers. They were where...
				</span>
			  </a>
			</li>
			<li>
			  <a>
				<span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
				<span>
				  <span>John Smith</span>
				  <span class="time">3 mins ago</span>
				</span>
				<span class="message">
				  Film festivals used to be do-or-die moments for movie makers. They were where...
				</span>
			  </a>
			</li>
			<li>
			  <a>
				<span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
				<span>
				  <span>John Smith</span>
				  <span class="time">3 mins ago</span>
				</span>
				<span class="message">
				  Film festivals used to be do-or-die moments for movie makers. They were where...
				</span>
			  </a>
			</li>
			<li>
			  <div class="text-center">
				<a>
				  <strong>See All Alerts</strong>
				  <i class="fa fa-angle-right"></i>
				</a>
			  </div>
			</li>
		  </ul>
		</li>
	  </ul>
	</nav>
  </div>
</div>
<!-- /top navigation -->
     	


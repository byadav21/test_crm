<div class="pageheadr col-sm-12">
		<div class="col-sm-7 col-md-8 paginationActionButtons">

			{if $prerow}

			{sugar_action_menu id=$link_select_id params=$selectLink}
		
			{/if}

			{sugar_action_menu id=$link_action_id params=$actionsLink}
			
			{ if $actionDisabledLink ne "" }<div class='selectActionsDisabled' id='select_actions_disabled_{$action_menu_location}'>{$actionDisabledLink}<span class='ab'></span></div>{/if}
			&nbsp;{$selectedObjectsSpan}
			{if $LOGGED_IN =='Success'}
				
				{if $LOGGED_IN_RESUME=='Resume'}
					<span id='show_pause'><button type="button" onclick="pauseTheNeoxCall()">Pause</button></span><span>&nbsp;&nbsp;</span>
				{/if}
				{if $LOGGED_IN_PAUSE=='Pause'}
					<span id='show_pause'><button type="button"onclick="resumeTheNeoxCall()">Resume</button></span><span>&nbsp;&nbsp;</span>
				{/if}
				
				
				{if $LOGGED_IN_MANUAL=='Manual'}
					<span id='shift_call'><button type="button" onclick="predictiveDialing()">Predictive Dialing</button></span>
				{/if}
				{if $LOGGED_IN_PREDICTIVE=='Predictive'}
					<span id='shift_call'><button type="button" onclick="manualDialing()">Manual Dialing</button></span>
				{/if}
				
			{/if}	
		
		
		</div>
		<div class="col-sm-4">
			<div class="col-sm-4 col-md-3 paginationChangeButtons" style="margin:0; padding:0">
					{if $pageData.urls.startPage}
						<button type='button' id='listViewStartButton_{$action_menu_location}' name='listViewStartButton' title='{$navStrings.start}' class='button' {if $prerow}onclick='return sListView.save_checks(0, "{$moduleString}");'{else} onClick='location.href="{$pageData.urls.startPage}"' {/if}>
							{sugar_getimage name="start" ext=".png" alt=$navStrings.start other_attributes='align="absmiddle" border="0" ' alt ="$alt_start"}
						</button>
					{else}
						<button type='button' id='listViewStartButton_{$action_menu_location}' name='listViewStartButton' title='{$navStrings.start}' class='button' disabled='disabled'>
							{sugar_getimage name="start_off" ext=".png" alt=$navStrings.start other_attributes='align="absmiddle" border="0" '}
						</button>
					{/if}
					{if $pageData.urls.prevPage}
						<button type='button' id='listViewPrevButton_{$action_menu_location}' name='listViewPrevButton' title='{$navStrings.previous}' class='button' {if $prerow}onclick='return sListView.save_checks({$pageData.offsets.prev}, "{$moduleString}")' {else} onClick='location.href="{$pageData.urls.prevPage}"'{/if}>
							{sugar_getimage name="previous" ext=".png" alt=$navStrings.previous other_attributes='align="absmiddle" border="0" ' alt ="$alt_prev"}
						</button>
					{else}
						<button type='button' id='listViewPrevButton_{$action_menu_location}' name='listViewPrevButton' class='button' title='{$navStrings.previous}' disabled='disabled'>
							{sugar_getimage name="previous_off" ext=".png" alt=$navStrings.previous other_attributes='align="absmiddle" border="0" '}
						</button>
					{/if}
			</div>
			<div class="col-sm-4 col-md-5 paginationActionButtons" style="    margin-top: 8px;" >	    
					<div class='pageNumbers'>({if $pageData.offsets.lastOffsetOnPage == 0}0{else}{$pageData.offsets.current+1}{/if} - {$pageData.offsets.lastOffsetOnPage} {$navStrings.of} {if $pageData.offsets.totalCounted}{$pageData.offsets.total}{else}{$pageData.offsets.total}{if $pageData.offsets.lastOffsetOnPage != $pageData.offsets.total}+{/if}{/if})</div>
			
			</div>	    
			<div class=" col-sm-4 col-md-3 paginationActionButtons"  style="margin:0; padding:0">
							{if $pageData.urls.nextPage}
								<button type='button' id='listViewNextButton_{$action_menu_location}' name='listViewNextButton' title='{$navStrings.next}' class='button' {if $prerow}onclick='return sListView.save_checks({$pageData.offsets.next}, "{$moduleString}")' {else} onClick='location.href="{$pageData.urls.nextPage}"'{/if}>
									{sugar_getimage name="next" ext=".png" alt=$navStrings.next other_attributes='align="absmiddle" border="0" ' alt ="$alt_next"}
								</button>
							{else}
								<button type='button' id='listViewNextButton_{$action_menu_location}' name='listViewNextButton' class='button' title='{$navStrings.next}' disabled='disabled'>
									{sugar_getimage name="next_off" ext=".png" alt=$navStrings.next other_attributes='align="absmiddle" border="0" '}
								</button>
							{/if}
							{if $pageData.urls.endPage  && $pageData.offsets.total != $pageData.offsets.lastOffsetOnPage}
								<button type='button' id='listViewEndButton_{$action_menu_location}' name='listViewEndButton' title='{$navStrings.end}' class='button' {if $prerow}onclick='return sListView.save_checks("end", "{$moduleString}")' {else} onClick='location.href="{$pageData.urls.endPage}"'{/if}>
									{sugar_getimage name="end" ext=".png" alt=$navStrings.end other_attributes='align="absmiddle" border="0" ' alt ="$alt_end"}
								</button>
							{elseif !$pageData.offsets.totalCounted || $pageData.offsets.total == $pageData.offsets.lastOffsetOnPage}
								<button type='button' id='listViewEndButton_{$action_menu_location}' name='listViewEndButton' title='{$navStrings.end}' class='button' disabled='disabled'>
									{sugar_getimage name="end_off" ext=".png" alt=$navStrings.end other_attributes='align="absmiddle" '}
								</button>
							{/if}	    
			</div>	
		
		</div> 


	</div> <!-- end of paging -->

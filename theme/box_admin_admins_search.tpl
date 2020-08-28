	<div class="sea_open">
		<blockquote class="m-b-5 text-center bgm-orange c-white f-17" style="border-left: 30px solid #ffffff;border-right: 30px solid #ffffff;">
			<p>Search Admins</p>
		</blockquote>
	</div>
	<div class="panel">
		
		<table width="100%" class="table">
					<thead>
						<tr>
							<th width="5%">#</th>
							<th width="25%">Properties</th>
							<th width="70%">Type</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="p-b-5">
								<div class="p-t-5">
									<label class="radio radio-inline m-r-20" for="name_">
										<input id="name_" name="search_type" type="radio" value="name" hidden="hidden" />
										<i class="input-helper"></i> 
									</label>
								</div>
							</td>
							<td class="p-b-5">
								<div class="p-t-5"><label for="nick" onclick="$('name_').checked = true">Nick</label></div>
							</td>
							<td class="p-b-5">
								<div class="fg-line">
									<input type="text" class="form-control" id="nick" value="" onmouseup="$('name_').checked = true" placeholder="Type nick" />
								</div>
							</td>
						</tr>
						<tr>
							<td class="p-b-5">
								<div class="p-t-5">
									<label class="radio radio-inline m-r-20" for="steam_">
										<input id="steam_" name="search_type" type="radio" value="radiobutton" hidden="hidden" />
										<i class="input-helper"></i> 
									</label>
								</div>
							</td>
							<td class="p-b-5">
								<div class="p-t-5"><label for="steamid" onclick="$('steam_').checked = true">SteamID</label></div>
							</td>
							<td class="p-b-5">
								<div class="col-sm-6 p-0">
									<div class="fg-line">
										<input type="text" class="form-control" id="steamid" value="" onmouseup="$('steam_').checked = true" placeholder="Type SteamID" />
									</div>
								</div>
								<div class="col-sm-6 p-t-5 p-r-0">
									<select class="selectpicker" id="steam_match" onmouseup="$('steam_').checked = true">
										<option value="0" selected>Exact match</option>
										<option value="1">Approximate match</option>
									</select>
								</div>
							</td>
						</tr>
						{if $can_editadmin}
							<tr>
								<td class="p-b-5">
									<div class="p-t-5">
										<label class="radio radio-inline m-r-20" for="admemail_">
											<input id="admemail_" name="search_type" type="radio" value="radiobutton" hidden="hidden" />
											<i class="input-helper"></i> 
										</label>
									</div>
								</td>
								<td class="p-b-5">
									<div class="p-t-5"><label for="admemail" onclick="$('admemail_').checked = true">E-mail</label></div>
								</td>
								<td class="p-b-5">
									<div class="fg-line">
										<input type="text" class="form-control" id="admemail" value="" onmouseup="$('admemail_').checked = true" placeholder="Type E-mail" />
									</div>
								</td>
							</tr>
						{/if}
						<tr>
							<td class="p-b-5">
								<div class="p-t-5">
									<label class="radio radio-inline m-r-20" for="webgroup_">
										<input id="webgroup_" name="search_type" type="radio" value="radiobutton" hidden="hidden" />
										<i class="input-helper"></i> 
									</label>
								</div>
							</td>
							<td class="p-b-5">
								<div class="p-t-5"><label for="webgroup" onclick="$('webgroup_').checked = true">Web permissions group</label></div>
							</td>
							<td class="p-b-5">
								<div class="col-sm-12 p-r-0 p-l-0">
									<select class="selectpicker" id="webgroup" onmouseup="$('webgroup_').checked = true">
										{foreach from="$webgroup_list" item="webgrp"}
											<option label="{$webgrp.name}" value="{$webgrp.gid}">{$webgrp.name}</option>
										{/foreach}
									</select>
								</div>
							</td>
						</tr>
						<tr>
							<td class="p-b-5">
								<div class="p-t-5">
									<label class="radio radio-inline m-r-20" for="srvadmgroup_">
										<input id="srvadmgroup_" name="search_type" type="radio" value="radiobutton" hidden="hidden" />
										<i class="input-helper"></i> 
									</label>
								</div>
							</td>
							<td class="p-b-5">
								<div class="p-t-5"><label for="srvadmgroup" onclick="$('srvadmgroup_').checked = true">Server permissions group</label></div>
							</td>
							<td class="p-b-5">
								<div class="col-sm-12 p-r-0 p-l-0">
									<select class="selectpicker" id="srvadmgroup" onmouseup="$('srvadmgroup_').checked = true;" onblur="$('srvadmgroup_').checked = true;">
										{foreach from="$srvadmgroup_list" item="srvadmgrp"}
											<option label="{$srvadmgrp.name}" value="{$srvadmgrp.name}">{$srvadmgrp.name}</option>
										{/foreach}
									</select>
								</div>
							</td>
						</tr>
						<tr>
							<td class="p-b-5">
								<div class="p-t-5">
									<label class="radio radio-inline m-r-20" for="srvgroup_">
										<input id="srvgroup_" name="search_type" type="radio" value="radiobutton" hidden="hidden" />
										<i class="input-helper"></i> 
									</label>
								</div>
							</td>
							<td class="p-b-5">
								<div class="p-t-5"><label for="srvgroup" onclick="$('srvgroup_').checked = true">Server groups</label></div>
							</td>
							<td class="p-b-5">
								<div class="col-sm-12 p-r-0 p-l-0 select">
									<select class="form-control" id="srvgroup" onmouseup="$('srvgroup_').checked = true">
										{foreach from="$srvgroup_list" item="srvgrp"}
											<option label="{$srvgrp.name}" value="{$srvgrp.gid}">{$srvgrp.name}</option>
										{/foreach}
									</select>
								</div>
							</td>
						</tr>
						<tr>
							<td class="p-b-5">
								<div class="p-t-5">
									<label class="radio radio-inline m-r-20" for="admwebflags_">
										<input id="admwebflags_" name="search_type" type="radio" value="radiobutton" hidden="hidden" />
										<i class="input-helper"></i> 
									</label>
								</div>
							</td>
							<td class="p-b-5">
								<div class="p-t-5"><label for="admwebflag" onclick="$('admwebflags_').checked = true">WEB permissions</label></div>
							</td>
							<td class="p-b-5">
								<div class="col-sm-12 p-r-0 p-l-0 select">
									<select class="form-control" id="admwebflag" onmouseup="$('admwebflags_').checked = true" onblur="getMultiple(this, 1);" size="5" multiple>
										{foreach from="$admwebflag_list" item="admwebflag"}
											<option label="{$admwebflag.name}" value="{$admwebflag.flag}">{$admwebflag.name}</option>
										{/foreach}
									</select>
								</div>
							</td>
						</tr>
						<tr>
							<td class="p-b-5">
								<div class="p-t-5">
									<label class="radio radio-inline m-r-20" for="admsrvflags_">
										<input id="admsrvflags_" name="search_type" type="radio" value="radiobutton" hidden="hidden" />
										<i class="input-helper"></i> 
									</label>
								</div>
							</td>
							<td class="p-b-5">
								<div class="p-t-5"><label for="admwebflag" onclick="$('admsrvflags_').checked = true">Server permissions</label></div>
							</td>
							<td class="p-b-5">
								<div class="col-sm-12 p-r-0 p-l-0 select">
									<select class="form-control" id="admwebflag" name="admsrvflag" onmouseup="$('admsrvflags_').checked = true" onblur="getMultiple(this, 2);" size="5" multiple>
										{foreach from="$admsrvflag_list" item="admsrvflag"}
											<option label="{$admsrvflag.name}" value="{$admsrvflag.flag}">{$admsrvflag.name}</option>
										{/foreach}
									</select>
								</div>
							</td>
						</tr>
						<tr>
							<td class="p-b-5">
								<div class="p-t-5">
									<label class="radio radio-inline m-r-20" for="admin_on_">
										<input id="admin_on_" name="search_type" type="radio" value="radiobutton" hidden="hidden" />
										<i class="input-helper"></i> 
									</label>
								</div>
							</td>
							<td class="p-b-5">
								<div class="p-t-5"><label for="admin_on_" onclick="$('admin_on_').checked = true">Server</label></div>
							</td>
							<td class="p-b-5">
								<div class="col-sm-12 p-r-0 p-l-0 select">
									<select class="form-control" id="server" onmouseup="$('admin_on_').checked = true">
										{foreach from="$server_list" item="server}
											<option value="{$server.sid}" id="ss{$server.sid}">Getting server name... ({$server.ip}:{$server.port})</option>
										{/foreach}
									</select>
								</div>
							</td>
						</tr>
						<tr>
							<td class="text-center" colspan="3">
								{sb_button text="Search" onclick="search_admins($exiperd_admins);" icon="<i class='zmdi zmdi-search'></i>" class="bgm-green btn-icon-text" id="searchbtn" submit=false}
							</td>
						</tr>
						
					</tbody>
		</table>
		
	</div>
{$server_script}
<script>InitAccordion('div.sea_open', 'div.panel', 'content');</script>

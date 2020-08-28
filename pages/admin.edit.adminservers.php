<?php 
// *************************************************************************
//  This file is part of SourceBans++.
//
//  Copyright (C) 2014-2016 Sarabveer Singh <me@sarabveer.me>
//
//  SourceBans++ is free software: you can redistribute it and/or modify
//  it under the terms of the GNU General Public License as published by
//  the Free Software Foundation, per version 3 of the License.
//
//  SourceBans++ is distributed in the hope that it will be useful,
//  but WITHOUT ANY WARRANTY; without even the implied warranty of
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//  GNU General Public License for more details.
//
//  You should have received a copy of the GNU General Public License
//  along with SourceBans++. If not, see <http://www.gnu.org/licenses/>.
//
//  This file is based off work covered by the following copyright(s):  
//
//   SourceBans 1.4.11
//   Copyright (C) 2007-2015 SourceBans Team - Part of GameConnect
//   Licensed under GNU GPL version 3, or later.
//   Page: <http://www.sourcebans.net/> - <https://github.com/GameConnect/sourcebansv1>
//
// *************************************************************************

if(!defined("IN_SB")){echo "Permission error!";die();} 
global $theme;
if(!isset($_GET['id']))
{
	echo '<div id="msg-red" >
	<i><img src="./images/warning.png" alt="Warning" /></i>
	<b>Error</b>
	<br />
	Admin ID not defined
</div>';
	PageDie();
}

if(!$userbank->GetProperty("user", $_GET['id']))
{
	$log = new CSystemLog("e", "Could not get admin details", "Can not find admin details with identify '".$_GET['id']."'");
	echo '<div id="msg-red" >
	<i><img src="./images/warning.png" alt="Warning" /></i>
	<b>Error</b>
	<br />
	Error getting current details.
</div>';
	PageDie();
}

$aid = (int)$_GET['id'];
if(!$userbank->HasAccess(ADMIN_OWNER|ADMIN_EDIT_ADMINS))
{
	$log = new CSystemLog("w", "Block try", $userbank->GetProperty("user") . " tried to edit server access of admin ".$userbank->GetProperty('user', $_GET['id']).", with no permission.");
	echo '<div id="msg-red" >
	<i><img src="./images/warning.png" alt="Warning" /></i>
	<b>Error</b>
	<br />
	You do not have access to edit server access of admin.
</div>';
	PageDie();
}

$servers = $GLOBALS['db']->GetAll("SELECT `server_id`, `srv_group_id` FROM ".DB_PREFIX."_admins_servers_groups WHERE admin_id = ". (int)$aid);
$adminGroup = $GLOBALS['db']->GetAll('SELECT id FROM '.DB_PREFIX.'_srvgroups sg, '.DB_PREFIX.'_admins a WHERE sg.name = a.srv_group and a.aid = ? limit 1', array($aid));

$server_grp = isset($adminGroup[0]['id'])?$adminGroup[0]['id']:0;

	
if(isset($_POST['editadminserver']))
{
	
	// clear old stuffs
	$GLOBALS['db']->Execute("DELETE FROM ".DB_PREFIX."_admins_servers_groups WHERE admin_id = {$aid}");
	if(isset($_POST['servers']) && is_array($_POST['servers']) && count($_POST['servers']) > 0) {
		foreach($_POST['servers'] AS $s)
		{
			$pre = $GLOBALS['db']->Prepare("INSERT INTO ".DB_PREFIX."_admins_servers_groups(admin_id,group_id,srv_group_id,server_id) VALUES (?,?,?,?)");
			$GLOBALS['db']->Execute($pre,array($aid,
											   $server_grp,
											   -1,
											   (int)substr($s,1)));
		}
	}
	if(isset($_POST['group']) && is_array($_POST['group']) && count($_POST['group']) > 0) {
		foreach($_POST['group'] AS $g)
		{
			$pre = $GLOBALS['db']->Prepare("INSERT INTO ".DB_PREFIX."_admins_servers_groups(admin_id,group_id,srv_group_id,server_id) VALUES (?,?,?,?)");
			$GLOBALS['db']->Execute($pre,array($aid,
											   $server_grp,
											   (int)substr($g,1),
											   -1));
		}
	}
	if(isset($GLOBALS['config']['config.enableadminrehashing']) && $GLOBALS['config']['config.enableadminrehashing'] == 1)
	{
		// rehash the admins on the servers
		$serveraccessq = $GLOBALS['db']->GetAll("SELECT s.sid FROM `".DB_PREFIX."_servers` s
												LEFT JOIN `".DB_PREFIX."_admins_servers_groups` asg ON asg.admin_id = '".(int)$aid."'
												LEFT JOIN `".DB_PREFIX."_servers_groups` sg ON sg.group_id = asg.srv_group_id
												WHERE ((asg.server_id != '-1' AND asg.srv_group_id = '-1')
												OR (asg.srv_group_id != '-1' AND asg.server_id = '-1'))
												AND (s.sid IN(asg.server_id) OR s.sid IN(sg.server_id)) AND s.enabled = 1");
		
		$allservers = array();
		foreach($serveraccessq as $access) {
			if(!in_array($access['sid'], $allservers)) {
				$allservers[] = $access['sid'];
			}
		}
		
		// Add all servers, he's been admin on before
		foreach($servers as $server)
		{
			if($server['server_id'] != "-1" && !in_array((int)$server['server_id'], $allservers)) {
				$allservers[] = (int)$server['server_id'];
			}
			
			// old server groups
			$serv_in_grp = $GLOBALS['db']->GetAll('SELECT server_id FROM `'.DB_PREFIX.'_servers_groups` WHERE group_id = ?;', array((int)$server['srv_group_id']));
			foreach($serv_in_grp as $srg)
			{
				if($srg['server_id'] != "-1" && !in_array((int)$srg['server_id'], $allservers)) {
					$allservers[] = (int)$srg['server_id'];
				}
			}
		}
		
		echo '<script>setTimeout(\'ShowRehashBox("'.implode(",", $allservers).'", "Server access updated", "Server access of admin updated succesfully", "green", "index.php?p=admin&c=admins");TabToReload();\', 1200);</script>';
	} else
		echo '<script>setTimeout(\'ShowBox("Server access updated", "Server access of admin updated succesfully", "green", "index.php?p=admin&c=admins");TabToReload();\', 1200);</script>';
	
	$admname = $GLOBALS['db']->GetRow("SELECT user FROM `".DB_PREFIX."_admins` WHERE aid = ?", array((int)$aid));
	$log = new CSystemLog("m", "Server access updated", "Server access of admin (" . $admname['user'] . ") has changed");
}


$server_list = 	$GLOBALS['db']->GetAll("SELECT * FROM `" . DB_PREFIX . "_servers`");
$group_list = 	$GLOBALS['db']->GetAll("SELECT * FROM `" . DB_PREFIX . "_groups` WHERE type = '3'");
$rowcount = 	(count($server_list)+count($group_list));

$theme->assign('row_count', $rowcount);
$theme->assign('group_list', $group_list);
$theme->assign('server_list', $server_list);
$theme->assign('assigned_servers', $servers);

$theme->display('page_admin_edit_admins_servers.tpl');
?>


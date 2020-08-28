<?php
if(!defined("IN_SB")){echo "Permission error!";die();}

error_reporting(E_ALL & ~E_DEPRECATED);
global $userbank, $theme;
	
if($GLOBALS['config']['page.adminlist']!="1"){
    CreateRedBox("Error", "Page disabled.");
    PageDie();
}

function FindAdminById($adlist, $aid) {
    $countl = count($adlist);
    for ($i = 0; $i < $countl; $i++) {
        if ($adlist[$i]['aid'] == $aid) return $adlist[$i];
    }
    
    return false;
}

function FindModById($modlist, $mid) {
    $countl = count($modlist);
    for ($i = 0; $i < $countl; $i++) {
        if ($modlist[$i]['mid'] == $mid) return $modlist[$i];
    }
    
    return false;
}

function IsExpired($admin) {
    if ($admin) {
        $exp = $admin['expired'];
        if (($exp > 0 && $exp > time()) || $exp == '0' || $exp == '')
            return false;
    }
    
    return true;
}

$servers = array();
$admins  = array();
$mods    = array();

/* Request all data */
$servers = $GLOBALS['db']->GetAll(sprintf('SELECT sid,ip,port,modid FROM `%s_servers` WHERE enabled = 1', DB_PREFIX));
$mods = $GLOBALS['db']->GetAll(sprintf('SELECT mid,name,icon,modfolder FROM `%s_mods`', DB_PREFIX));
$admins = $GLOBALS['db']->GetAll(sprintf("SELECT aid,user,authid,srv_group,immunity,expired,vk,skype,comment,gr.server_id srv FROM `%s_admins` INNER JOIN `%s_admins_servers_groups` AS gr ON aid = admin_id WHERE aid > 0", DB_PREFIX, DB_PREFIX));

foreach ($admins as &$admin)
    $admin['aid'] = (int)$admin['aid'];

/* Edit server data: add var 'adminlist' */
foreach ($servers as &$server)
    $server['adminlist'] = array();

/* Edit mod data: add var `servers` */
$iModCount = count($mods);
for ($i = 0; $i < $iModCount; $i++)
    $mods[$i]['servers'] = 0;
unset($iModCount);

$iServerCount = count($servers);
$iAdminCount  = count($admins);
for ($iServer = 0; $iServer < $iServerCount; $iServer++) {
    /* Admins */
    for ($iAdmin = 0; $iAdmin < $iAdminCount; $iAdmin++) {
        $administrator = $admins[$iAdmin];
        if ($administrator['srv'] == $servers[$iServer]['sid'] && !IsExpired($administrator)) {
            $administrator['avatar'] = GetUserAvatar($administrator['authid']);
            $administrator['authid'] = CSteamId::factory($administrator['authid'])->CommunityID;
                
            $servers[$iServer]['adminlist'][$administrator['aid']] = $administrator;
        }
    }
    
    /* Other infornation */
    $servers[$iServer]['admincount'] = count($servers[$iServer]['adminlist']);
    asort($servers[$iServer]['adminlist']);
    
    /* Games var */
    if ($servers[$iServer]['admincount']) {
        $countl = count($mods);
        for ($i = 0; $i < $countl; $i++) {
            if ($mods[$i]['mid'] == $servers[$iServer]['modid']) {
                $mods[$i]['servers']++;
                break;
            }
        }
    }
}

/* Optimization */
$countl = count($mods);
for ($i = 0; $i < $countl; $i++) {
    if ($mods[$i]['servers'] == 0) unset($mods[$i]);
}

/* App ID */
foreach ($mods as &$mod) {
	if ($mod['modfolder'] == 'tf') $mod['appid'] = 440;
	else $mod['appid'] = 0;
}

/* Add to theme */
if (count($mods) > 0) {
    $theme->assign('games', $mods);
    $theme->assign('server_list', $servers);
    $theme->display('page_adminlist.tpl');
} else
    CreateRedBox("Error", "There are no administrators to whom the administered servers would be assigned.");
//var_dump($servers);
?>

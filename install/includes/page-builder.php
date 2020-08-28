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

$_GET['step'] = isset($_GET['step']) ? $_GET['step'] : 'default';

switch ($_GET['step'])
{
	case "6":
		RewritePageTitle("Step 6 - Import AMXBans");
		$page = TEMPLATES_PATH . "/page.6.php";
		break;
	case "5":
		RewritePageTitle("Step 5 - Install");
		$page = TEMPLATES_PATH . "/page.5.php";
		break;
	case "4":
		RewritePageTitle("Step 4 - Creating tables");
		$page = TEMPLATES_PATH . "/page.4.php";
		break;
	case "3":
		RewritePageTitle("Step 3 - Checking system requirements");
		$page = TEMPLATES_PATH . "/page.3.php";
		break;
	case "2":
		RewritePageTitle("Step 2 - Database settings");
		$page = TEMPLATES_PATH . "/page.2.php";
		break;
	default:
		RewritePageTitle("Step 1 - License agreement");
		$page = TEMPLATES_PATH . "/page.1.php";
		break;
}

ob_start();
BuildPageHeader();
BuildPageTabs();
BuildSubMenu();
BuildContHeader();
if(!empty($page))
	include $page;
include_once(TEMPLATES_PATH . '/footer.php');
ob_end_flush();
?>

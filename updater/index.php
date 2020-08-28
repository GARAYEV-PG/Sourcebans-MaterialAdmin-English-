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

// Check PHP environment.
if (version_compare(PHP_VERSION, '5.5') == -1) {
  Header('Content-Type: text/plain; charset=UTF8');
  echo("SourceBans cannot work: it requires PHP version 5.5 or higher to work.\n");
  echo('Currently installed version ' . PHP_VERSION);
  exit();
}

if (!file_exists('../data/db.php')) {
  define('IN_SB', true);
  include('../data/config.php');
  $config  = "<?php\n";
  $config .= "if (!defined('IN_SB')) exit();\n\n";

  $config .= "/**\n";
  $config .= " * This file contains all database configurations for\n";
  $config .= " * using in SourceBans in new DB Framework.\n";
  $config .= " */\n";
  $config .= "\DatabaseManager::CreateConfig('SourceBans', [\n";
  $config .= "  'dsn'     => 'mysql:dbname=" . DB_NAME . ";host=" . DB_HOST . ";charset=UTF8;port=" . DB_PORT . "',\n";
  $config .= "  'user'    => '" . DB_USER . "',\n";
  $config .= "  'pass'    => '" . DB_PASS . "',\n";
  $config .= "  'prefix'  => '" . DB_PREFIX . "_',\n";
  $config .= "  'options' => [\n";
  $config .= "    \\PDO::ATTR_ERRMODE  => \\PDO::ERRMODE_EXCEPTION\n";
  $config .= "  ]\n";
  $config .= "]);";

  if (!is_writable('../data/')) {
    $config = htmlspecialchars($config);

    Header("Content-Type: text/html; charset=UTF8");
    echo('<html><body>');
    echo('<p>Unable to write the configuration file for the database framework.</p>');
    echo('<p>Please copy and paste the following text into <em> data / db.php </em> to continue with the updater:</p>');
    echo("<pre>$config</pre>");
    echo('<p>This text will automatically disappear when the file is created and written.</p>');
    echo('<script>setTimeout(function() { location.reload(); }, 5000);</script>');
    echo('</body></html>');

    exit();
  }

  file_put_contents('../data/db.php', $config);
  Header("Content-Type: text/html; charset=UTF8");
  echo('<script>setTimeout(location.reload, 500);</script>');
  exit();
}

 define('IS_UPDATE', true);

 ignore_user_abort(true);
 set_time_limit(0);

 include "../init.php";
 $theme->clear_compiled_tpl();

 define('IS_AJAX',   isset($_GET['updater_ajax_call']));

 include INCLUDES_PATH . "/CUpdate.php";
 $updater = new CUpdater();
 
 $setup = "Checking the current version of SourceBans ...<b> " . $updater->getCurrentRevision() . "</b>";
 if(!$updater->needsUpdate())
 {
	if (IS_AJAX)
		die(json_encode(['result' => false, 'reason' => "The system does not need updates."]));
	$setup .= "<br /><br />No updates needed. Delete the folder<b>updater</b>!";
	$theme->assign('setup', $setup);
	$theme->assign('progress', "");
	$theme->display('updater.tpl');
	die();
 }
 $setup .= "<br />Upgrade to version: <b>" . $updater->getLatestPackageVersion() . "</b>";
 
 $progress = $updater->doUpdates();
 
 if (IS_AJAX)
	die(json_encode(['result' => true]));
 $theme->assign('setup', $setup);
 $theme->assign('progress', $progress);
 $theme->display('updater.tpl');
?>

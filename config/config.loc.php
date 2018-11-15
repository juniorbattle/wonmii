<?php
$config["ncompany"] = (isset($_SESSION['ncompany']))? $_SESSION['ncompany']->name : 'wonmii';
$config["url"] = "http://" . $_SERVER["HTTP_HOST"] . "/";
$config['dir'] = "c:\wamp64/www/wonmii/";
# Declaration du style general pour chaque section
$config['unconnected']['css'] =  'style.general.secondary.css';
$config['connected']['css'] = 'style.general.secondary.css';
$config['general']['css'] = 'style.general.default.css';
# Regouprement des pages dans chaque section (connected, unconnected, general)
$config['connected']['pages'] = [
  'dashboard' => ['pin' => 'ti-panel', 'name' => 'Dashboard'],
  'pages' => ['pin' => 'ti-layers-alt', 'name' => 'Pages'],
  'company' => ['pin' => 'ti-user', 'name' => 'Company'],
  'settings' => ['pin' => 'ti-settings', 'name' => 'Settings'],
  'login' => ['pin' => 'ti-power-off', 'name' => 'Logout', 'action' => 'logout']
];
$config['unconnected']['pages'] = [
  'login',
  'resetpassword',
  'signup'
];
$config['general']['pages'] = [
  'home',
  'atelier',
  'tutorials',
  'contact'
];

require_once("functions.php");
require_once("database.loc.php");

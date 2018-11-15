<?php

require_once('config.load.php');
require_once($config['dir'] . 'structure/structure.class.php');
require_once($config["dir"] . "core/php/base.php");
require_once('config.connect.php');

$config["multilang"] = LANGUE::GetLibellesLangues();
$config["mainLang"] = (Secure::GetValue($_GET, 'lang'))? Secure::GetValue($_GET, 'lang') : LANGUE::GetLangueMain()['libelle'];

$config['actvPage'] = $actvPage = (Secure::GetValue($_GET, 'p') && file_exists($config['dir'] . 'public/' . Secure::GetValue($_GET, 'p')))? Secure::GetValue($_GET, 'p') : 'login';
$config['actvSsPage'] = $actvSsPage = (Secure::GetValue($_GET, 'ssp'))? Secure::GetValue($_GET, 'ssp') : null;

if (in_array($config['actvPage'],$config["connected"]["pages"]))
  $config['css'] = $config["connected"]["css"];
elseif (in_array($config['actvPage'],$config["unconnected"]["pages"]))
  $config['css'] = $config["unconnected"]["css"];
elseif (in_array($config['actvPage'],$config["general"]["pages"]))
  $config['css'] = $config["general"]["css"];
else $config['css'] = 'style.general.default.css';

$action = (Secure::GetValue($_GET, 'action'))? Secure::GetValue($_GET, 'action') : null;

/* LOAD COMPANY ELEMENTS */
$companyObj = new COMPANY();
/* INIT and GENERATE STRUCTURE CLASS */
$structure = new STRUCTURE($config['actvPage']);

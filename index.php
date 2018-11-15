<?php

require_once('config/config.php');
require_once('go.php');

/** HEADER **/
$content = $structure->header;
require_once($config['dir'] . 'core/layouts/header.layout.php');
/** PAGE ACTIVE **/
$content = $structure->body;
require_once($config['dir'] . 'public/' . $actvPage . '/controller.php');
require_once($config['dir'] . 'public/' . $actvPage . '/view.php');
/** FOOTER **/
$content = $structure->footer;
require_once($config['dir'] . 'core/layouts/footer.layout.php');
/** PLUGINS **/

$structure->generateEntityHTML();

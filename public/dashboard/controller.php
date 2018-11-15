<?php

switch($action)
{
  default :
    $contentHTML = getContent($config['dir'] . 'public/' . $config['actvPage'] . '/views/default.php', array('companyObj' => $companyObj));
    break;
}

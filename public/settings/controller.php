<?php

switch($action)
{
  default :
    $langues = LANGUE::GetAll();
    $companyObj = new COMPANY();
    $contentHTML = getContent($config['dir'] . 'public/' . $config['actvPage'] . '/views/default.php', array('langues' => $langues, 'companyObj' => $companyObj));

    break;
  case 'SaveLoginConnect':
    $companyObj->loginWoncreative = Secure::GetValue($_POST, 'login');
    $companyObj->passwordWoncreative = Secure::GetValue($_POST, 'password');
    $companyObj->Save();

    Utils::Redirect($config["url"] . "index.php?p=" . $config['actvPage'] . "&valid=1");
    exit();
    break;
  case 'SaveStatusWebsite':
    $companyObj->statusWebsite = Secure::GetValue($_POST, 'status');
    $companyObj->Save();

    Utils::Redirect($config["url"] . "index.php?p=" . $config['actvPage'] . "&valid=1");
    exit();
    break;
  case 'MainLang':
    $lang =  Secure::GetValue($_GET, 'lang');
    $langueObj = new LANGUE(null,$lang);
    $langueObj->SetMain();

    Utils::Redirect($config["url"] . "index.php?p=" . $config['actvPage'] . "&valid=1");
    exit();
    break;
  case 'ActiveLang':
    $lang =  Secure::GetValue($_GET, 'lang');
    $langueObj = new LANGUE(null,$lang);
    $langueObj->active = Secure::GetValue($_GET, 'value');
    $langueObj->Save();

    Utils::Redirect($config["url"] . "index.php?p=" . $config['actvPage'] . "&valid=1");
    exit();
    break;
}

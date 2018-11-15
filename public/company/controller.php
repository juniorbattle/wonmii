<?php

switch($action)
{
  default :
    $contentHTML = getContent($config['dir'] . 'public/' . $config['actvPage'] . '/views/default.php', array('companyObj' => $companyObj));
    break;
  case 'Save' :
    $companyObj->name = Secure::GetValue($_POST, 'name');
    $companyObj->domain = Secure::GetValue($_POST, 'domain');
    $companyObj->email = Secure::GetValue($_POST, 'email');
    $companyObj->email2 = Secure::GetValue($_POST, 'email2');
    $companyObj->emailForContact = Secure::GetValue($_POST, 'email_contact');
    $companyObj->phone = Secure::GetValue($_POST, 'phone');
    $companyObj->mailingAddress = Secure::GetValue($_POST, 'mailing_address');
    $companyObj->description = Secure::GetValue($_POST, 'description');
    $companyObj->keywords	= Secure::GetValue($_POST, 'keywords');
    $companyObj->socialsNetworks = Secure::GetValue($_POST, 'socialsnetworks');
    $companyObj->Save();

    Utils::Redirect($config["url"] . "index.php?p=" . $config['actvPage'] . "&valid=1");
    exit();
    break;
  case 'SaveLogo' :
    if ($_FILES['logo']['error'] == 0) {
        $img = new Image($_FILES['logo'], "adaptativeHV", 0, 0);
        $img->CopyTo($config["dir"] . "../core/img/company/", "logo_company", "original");
    }

    Utils::Redirect($config["url"] . "index.php?p=" . $config['actvPage'] . "&valid=1");
    exit();
    break;
}

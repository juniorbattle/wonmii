<?php

switch($action)
{
  default :
    if(Secure::GetValue($_GET, 'ssp')){
        $langues = LANGUE::GetLibellesLangues(array('active' => 1));

        $pageObj =  new PAGE(null,Secure::GetValue($_GET, 'ssp'));
    		$tabStrings = ($pageObj->id && !empty($pageObj->GetStrings()))? $pageObj->GetStrings() : null;

        switch($pageObj->display) {
          default:
          case 'basic':
            $arrayPart = array('langues' => $langues, 'pageObj' => $pageObj, 'tabStrings' => $tabStrings);
            break;
          case 'gallery':
            $galleryObj = GALLERY::GetGalleryPage(array('return' => 'object'));
            $galleryUptObj = new GALLERY(Secure::GetValue($_GET, 'idGallery'));
            $arrayPart = array('langues' => $langues, 'pageObj' => $pageObj, 'galleries' => $galleryObj, 'galleryUptObj' => $galleryUptObj, 'tabStrings' => $tabStrings);
            break;
          case 'blog':
            $blogObj = BLOG::GetBlogPage(array('return' => 'object'));
            $blogUptObj = new BLOG(Secure::GetValue($_GET, 'idBlog'));
            $arrayPart = array('langues' => $langues, 'pageObj' => $pageObj, 'blogs' => $blogObj, 'blogUptObj' => $blogUptObj, 'tabStrings' => $tabStrings);
            break;
        }

        $contentHTML = getContent($config['dir'] . 'public/' . $config['actvPage'] . '/views/details.php',$arrayPart);
    }
    else {
      $pages = PAGE::GetAll(array('return' => 'object'));
      $contentHTML = getContent($config['dir'] . 'public/' . $config['actvPage'] . '/views/default.php', array('pages' => $pages));
    }
    break;
  case 'activePage':
        $value   = Secure::GetValue($_GET, 'value');
        $ssp     = Secure::GetValue($_GET, 'ssp');

        $pageObj  =  new PAGE(null,$ssp);
        $pageObj->active  = ($value)? 1 : 0;

        $pageObj->Save();

        Utils::Redirect($config["url"] . "index.php?p=" . $config['actvPage'] . "&valid=1");
        exit();
        break;
  case 'pageInMenu':
      $value  = Secure::GetValue($_GET, 'value');
      $ssp    = Secure::GetValue($_GET, 'ssp');

      $pageObj  =  new PAGE(null,$ssp);
      $pageObj->inMenu  = ($value)? 1 : 0;

      $pageObj->Save();

      Utils::Redirect($config["url"] . "index.php?p=" . $config['actvPage'] . "&valid=1");
  		exit();
      break;
  case 'upOrdrePage':
      $ssp     = Secure::GetValue($_GET, 'ssp');

      $pageObj  =  new PAGE(null,$ssp);
      $pageObj->setOrdreUp();

      Utils::Redirect($config["url"] . "index.php?p=" . $config['actvPage'] . "&valid=1");
  		exit();
      break;
  case 'downOrdrePage':
      $ssp     = Secure::GetValue($_GET, 'ssp');

      $pageObj  =  new PAGE(null,$ssp);
      $pageObj->setOrdreDown();

      Utils::Redirect($config["url"] . "index.php?p=" . $config['actvPage'] . "&valid=1");
      exit();
      break;
  case 'SaveConfigPage':
  		$langues = LANGUE::GetLibellesLangues(array('active' => 1));

      $nameStrings      =  Secure::GetValue($_POST, 'name');
      $namePage         = (Secure::GetValue($_POST, 'namePage'))? Secure::GetValue($_POST, 'namePage') : str_replace(' ', '', strtolower($nameStrings[$config["mainLang"]]));
  		$descStrings      =  Secure::GetValue($_POST, 'description');

  		$pageObj          =  new PAGE(null,$namePage);
      $pageObj->name    = $namePage;
      $pageObj->active  = $active  =  (Secure::GetValue($_POST, 'active') == 'on')? 1 : 0;
      $pageObj->inMenu  = $inMenu  =  (Secure::GetValue($_POST, 'inmenu') == 'on')? 1 : 0;
      $pageObj->display = $display =  Secure::GetValue($_POST, 'display');
      $pageObj->plugins = $plugins =  Secure::GetValue($_POST, 'plugins');

      $pageObj->Save();

      foreach($langues as $langue) {
        $tabStrings[$langue]['name'] = $nameStrings[$langue];
    		$tabStrings[$langue]['description'] = $descStrings[$langue];
      }

  		$pageObj->SaveStrings($tabStrings);

  		Utils::Redirect($config["url"] . "index.php?p=" . $config['actvPage'] . "&ssp=" . $namePage . "&valid=1");
  		exit();
  		break;
  case 'savePreviewPage':
      $ssp     = Secure::GetValue($_GET, 'ssp');

      $pageObj =  new PAGE(null,$ssp);
      $tabStrings[$config["mainLang"]]['content'] = Secure::GetValue($_POST, 'code');
      $pageObj->SaveStrings($tabStrings);

      Utils::Redirect($config["url"] . "index.php?p=" . $config['actvPage'] . "&ssp=" . $config['actvSsPage'] . "&lang=" . $config["mainLang"] . "&valid=1");
  		exit();
      break;
  case 'saveGallery':
      $id       = Secure::GetValue($_POST, 'id');
      $display  = Secure::GetValue($_POST, 'display');

      $galleryObj          =  new GALLERY($id);
      $galleryObj->page    = $config['actvSsPage'];
      $galleryObj->display = $display;
      $galleryObj->Save();

      if($_FILES['img']['error'] == 0) {
			     $img = new Image($_FILES['img'], "adaptativeHV", 0, 0);
	         $img->CopyTo($config["dir"] . "../medias/gallery/" . $config['actvSsPage'] . "/", $galleryObj->id, "original");
      }

      Utils::Redirect($config["url"] . "index.php?p=" . $config['actvPage'] . "&ssp=" . $config['actvSsPage'] . "&lang=" . $config["mainLang"] . "&valid=1");
  		exit();
      break;
  case 'activeImgGallery':
      $id       = Secure::GetValue($_GET, 'id');
      $value    = Secure::GetValue($_GET, 'value');

      $galleryObj          =  new GALLERY($id);
      $galleryObj->active  = $value;
      $galleryObj->Save();

      Utils::Redirect($config["url"] . "index.php?p=" . $config['actvPage'] . "&ssp=" . $config['actvSsPage'] . "&lang=" . $config["mainLang"] . "&valid=1");
  		exit();
      break;
  case 'saveBlog':
      $langues = LANGUE::GetLibellesLangues(array('active' => 1));

      $id           = Secure::GetValue($_POST, 'id');
      $display      = Secure::GetValue($_POST, 'display');
      $nameStrings  =  Secure::GetValue($_POST, 'name');
      $contentStrings  =  Secure::GetValue($_POST, 'content');

      $blogObj          =  new BLOG($id);
      $blogObj->page    = $config['actvSsPage'];
      $blogObj->display = $display;
      $blogObj->Save();

      foreach($langues as $langue) {
        $tabStrings[$langue]['name'] = $nameStrings[$langue];
    		$tabStrings[$langue]['content'] = $contentStrings[$langue];
      }

      $blogObj->SaveStrings($tabStrings);

      if($_FILES['img']['error'] == 0) {
			     $img = new Image($_FILES['img'], "adaptativeHV", 0, 0);
	         $img->CopyTo($config["dir"] . "../medias/blog/" . $config['actvSsPage'] . "/", $blogObj->id, "original");
      }

      Utils::Redirect($config["url"] . "index.php?p=" . $config['actvPage'] . "&ssp=" . $config['actvSsPage'] . "&lang=" . $config["mainLang"] . "&valid=1");
  		exit();
      break;
  case 'activeBlog':
      $id       = Secure::GetValue($_GET, 'id');
      $value    = Secure::GetValue($_GET, 'value');

      $blogObj          =  new BLOG($id);
      $blogObj->active  = $value;
      $blogObj->Save();

      Utils::Redirect($config["url"] . "index.php?p=" . $config['actvPage'] . "&ssp=" . $config['actvSsPage'] . "&lang=" . $config["mainLang"] . "&valid=1");
  		exit();
      break;
}

<?php

require_once('header/header.class.php');
require_once('body/body.class.php');
require_once('footer/footer.class.php');

class STRUCTURE
{
  public $startHTML   = null;
  public $endHTML     = null;
  public $contentHTML = null;
  public $headerObj   = null;
  public $bodyObj     = null;
  public $footerObj   = null;
  public $container   = null;
  public $page        = null;
  public $displayHTML = null;

  function __construct($page,$container=false)
  {
      if($container) $this->container  = 'class="container"';
      $this->page               = $page;
      $this->header             = new HEADER();
      $this->body               = new BODY();
      $this->footer             = new FOOTER();
      $this->startHTML          = $this->getStartHTML();
      $this->endHTML            = $this->getEndHTML();
  }

  private function getStartHTML()
  {
    global $config;

    $display = '<html>';
    $display .= '<head>';
    $display .= '<title>WonMii</title>';
    $display .= '<link alt="icon WonCreative" rel="shortcut icon" href="#">';
    $display .= '<meta name="viewport" content="width=device-width, initial-scale=1">';
    $display .= '<link href="' . $config['url'] . 'core/css/themify-icons.css" rel="stylesheet">';
    $display .= $this->getAllCSSPublic();
    $display .= '<link href="' . $config['url'] . 'core/css/style.structure.min.css" rel="stylesheet" type="text/css" media="all">';
    $display .= '<link href="' . $config['url'] . 'core/css/' . $config['css'] . '" rel="stylesheet" type="text/css" media="all">';
    $display .= '<script src="' . $config['url'] . 'core/js/jquery.min.js"></script>';
    $display .= '<script src="' . $config['url'] . 'core/js/script.general.js"></script>';
    $display .= '</head>';
    $display .= '<body ' . $this->container . '>';
    $display .= '<div class="backoffice">';

    return $display;
  }

  private function getEndHTML()
  {
    $display  = '</div>';
    $display .= $this->getAllJSPublic();
    $display .= '</body>';
    $display .= '</html>';

    return $display;
  }

  private function generateEntityContent()
  {
    $display = $this->header->getEntityContent();
    $display .= $this->body->getEntityContent($this->footer->getEntityContent());

    return $display;
  }

  public function generateEntityHTML()
  {
    $this->displayHTML .= $this->startHTML;
    $this->displayHTML .= $this->generateEntityContent();
    $this->displayHTML .= $this->endHTML;

    echo $this->displayHTML;
  }

  public function getAllCSSPublic()
  {
    global $config;

    $display = null;
    $dirFolder = $config['dir'] . 'public/' . $this->page  . '/css/';
    $urlFolder = $config['url'] . 'public/' . $this->page  . '/css/';

    if (is_dir($dirFolder)) {
        if ($dh = opendir($dirFolder)) {
            while (($file = readdir($dh)) !== false) {
              if($file != '.' && $file != '..') {
                $display .= '<link href="' . $urlFolder . $file . '" rel="stylesheet" type="text/css" media="all">';
              }
            }
            closedir($dh);
        }
    }
    return $display;
  }

  public function getAllJSPublic()
  {
    global $config;

    $display = null;
    $dirFolder = $config['dir'] . 'public/' . $this->page  . '/js/';
    $urlFolder = $config['url'] . 'public/' . $this->page  . '/js/';

    if (is_dir($dirFolder)) {
        if ($dh = opendir($dirFolder)) {
            while (($file = readdir($dh)) !== false) {
              if($file != '.' && $file != '..') {
                $display .= '<script src="' . $urlFolder . $file . '"></script>';
              }
            }
            closedir($dh);
        }
    }
    return $display;
  }
}

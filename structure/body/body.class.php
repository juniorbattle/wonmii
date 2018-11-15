<?php

class BODY extends STRUCTURE
{
  private $body   = null;

  function __construct()
  {
  }

  protected function getEntityContent($extra=false)
  {
    global $config;
    $display = '<section>';
    $display .= '<div class="alert alert-success"><strong>Success!</strong> This alert box could indicate a successful or positive action.</div>';
    $display .= '<div class="alert alert-failed"><strong>Failed!</strong> This alert box could indicate a failed or negative action.</div>';
    $display .= '<div class="content-title">';
    $display .= '<span>' . $config['actvPage'] . '</span>';
    $display .= '<span>' . $config['actvSsPage'] .'</span>';
    $display .= '</div>';
    $display .= '<div class="content-main">';
    $display .= $this->body;
    $display .= '</div>';
    if($extra) $display .= $extra;
    $display .= '</section>';

    return $display;
  }

  public function setEntityContent($content)
  {
      $this->body .= $content;
  }

}

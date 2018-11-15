<?php

class HEADER extends STRUCTURE
{
  private $body   = null;

  function __construct()
  {
  }

  protected function getEntityContent($extra=false)
  {
    $display = '<header>';
    $display .= $this->body;
    if($extra) $display .= $extra;
    $display .= '</header>';

    return $display;
  }

  public function setEntityContent($content)
  {
      $this->body .= $content;
  }

}

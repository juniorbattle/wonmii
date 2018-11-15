<?php

class FOOTER extends STRUCTURE
{
  private $body   = null;

  function __construct()
  {
  }

  protected function getEntityContent($extra=false)
  {
    $display = '<footer>';
    $display .= $this->body;
    if($extra) $display .= $extra;
    $display .= '</footer>';

    return $display;
  }

  public function setEntityContent($content)
  {
      $this->body .= $content;
  }

}

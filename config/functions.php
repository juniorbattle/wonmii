<?php

function getContent($url,$params=array()) {
  global $config;

  extract($params);
  
  ob_start();
  include_once($url);
  $display = ob_get_contents();
  ob_end_clean();

  return $display;
}

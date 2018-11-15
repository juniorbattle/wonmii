<?php

$contentMenus = null;
foreach($config['connected']['pages'] as $page => $arrayPage) {
  $actvLink   = ($page == $actvPage)? 'class="active"' : null;
  $actionPage = (array_key_exists('action',$arrayPage))? '/log/' . $arrayPage['action'] : null;
  $contentMenus .= '<li ' . $actvLink . '><a href="' . $config['url']  . $page . $actionPage . '"><i class="' . $arrayPage['pin'] . '"></i><p>' . $arrayPage['name'] . '</p></a></li>';
}

$contentHTML =  '
  <div class="content-title">
      <span>WonMii</span>
  </div>
  <ul class="nav backoffice">
    ' . $contentMenus . '
  </ul>
';


$content->setEntityContent(
  $contentHTML
);

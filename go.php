<?php

if(!$session->Exist($config["ncompany"]) &&  in_array($config['actvPage'],$config["connected"]["pages"])) {
  Utils::Redirect($config["url"] . "login");
  exit();
} elseif($session->Exist($config["ncompany"]) && in_array($config["actvPage"],$config["unconnected"]["pages"]) && $action != "logout") {
  Utils::Redirect($config["url"] . "dashboard");
  exit();
}
